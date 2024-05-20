<?php

namespace App\Classes;

use App\Events\DatabaseTransactionEvent;
use Billplz\Laravel\Billplz;
use Carbon\Carbon;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Rfc4122\FieldsInterface;

class InvoiceHelper {
    /* Change accordingly to created country id */
    public static $malaysia    =   1;
    public static $indonesia   =   2;

    public static function invoiceStatus()
    {
        $status =   DB::table('invoice_status')->get();

        return $status;
    }

    public static function newFeeInvoice($invoice_data)
    {
        $currentYear        =   Carbon::now()->year;
        $invoice_config     =   DB::table('invoice_config')->whereYear('year', $currentYear)->first();

        $quota_exceeded    =   self::checkInvoiceQuota($invoice_config);

        if($quota_exceeded){
            return false;
        }

        $invoice_number    =   self::getCurrentYearInvoiceNumber($invoice_config);

        $invoice_items      =   collect($invoice_data['invoice_items']);

        /* Calculate total fee */
        $totalFee = $invoice_items->sum(function ($item) {
            $registration_fee   =   isset($item['include_registration_fee']) ? $item['registration_fee'] : 0;
            $material_fee       =   $item['include_material_fee'] ? $item['material_fee'] : 0;

            return $item['programme_fee'] + $registration_fee + $material_fee;
        });
        
        /* Calculate total promo */
        $totalPromo =   0;
        foreach($invoice_items as $fee_key => $fee){
            Log::info('', [$invoice_items]);
            Log::info('', [$fee]);
            if (isset($fee['promos'])) { // Check if 'promos' key exists
                foreach($fee['promos'] as $promo_key => $promo){
                    if($promo['type_id'] === 1){
                        $totalPromo += ($fee['programme_fee'] * $promo['value'] / 100);
                    }
                    if($promo['type_id'] === 2){
                        $totalPromo += $promo['value'];
                    }
                }
            }
            if (isset($fee->promos)) { // Check if 'promos' key exists
                foreach($fee->promos as $promo_key => $promo){
                    if($promo->type_id === 1){
                        $totalPromo += ($fee->programme_fee * $promo->value / 100);
                    }
                    if($promo->type_id === 2){
                        $totalPromo += $promo->value;
                    }
                }
            }
        }
        $totalFee = $totalFee - $totalPromo;
        
        $due_date           =   Carbon::parse($invoice_data['date_admission']);  
        $student_id         =   $invoice_data['student_id'];
        $student_country    =   UserHelper::getChildCountryId($invoice_data['children_id']);
        $invoice_number     =   Carbon::now()->year.'-'.$invoice_number;
        $date_admission     =   $invoice_data['date_admission'];
        $currency           =   $invoice_data['currency'];
        
        // if(env('APP_ENV') == 'production'){
            if($student_country == self::$malaysia){
                $bill_collection_id     =   config('app.billplz.collection_id');
                $bill_email             =   StudentHelper::getStudentEmail($invoice_data['student_id']);
                $bill_mobile            =   '';
                $bill_name              =   StudentHelper::getStudentName($invoice_data['student_id']);
                $bill_amount            =   $totalFee * 100;
                $bill_callback          =   route('fee.invoices.callback.my');
                $bill_description       =   'Invoice Number: '.$invoice_number;
                $bill_response          =   Billplz::bill()->create($bill_collection_id, $bill_email, $bill_mobile, $bill_name, $bill_amount, $bill_callback, $bill_description, [
                                                'due_at'    =>  $due_date->addMonths(1)->toDateString(),
                                                'redirect_url' => route('fee.invoices.check_status')
                                            ]); 
                          
                if($bill_response->getStatusCode() == 200){
                    $invoice_id =   DB::table('invoices')->insertGetId([
                                        'student_id'        => $student_id,
                                        'invoice_number'    => $invoice_number,
                                        'invoice_items'     => json_encode($invoice_items->toArray(), JSON_NUMERIC_CHECK),
                                        'date_issued'       => $date_admission,
                                        'due_date'          => $due_date->addWeeks(2)->toDateString(),
                                        'amount'            => $totalFee,
                                        'currency'          => $currency,
                                        'bill_id'           => $bill_response->toArray()['id'],
                                        'payment_url'       => env('VITE_BILLPLZ_ENDPOINT').$bill_response->toArray()['id'],
                                    ]);
            
                    return $invoice_id;
                }
            }
            else if($student_country == self::$indonesia){
                $endpoint           =   env('VITE_DOKU_ENDPOINT');
                $target_path        =   env('VITE_DOKU_TARGET_PATH');
                $secret_key         =   env('VITE_DOKU_SECRET_KEY');
                $client_id          =   env('VITE_DOKU_CLIENT_ID');
                $request_id         =   Uuid::uuid1()->toString();
                $request_timestamp  =   Carbon::now()->format('Y-m-d\TH:i:s\Z');
                
                $request_body = array (
                    "order" => array(
                        "amount"            =>  $totalFee,
                        "invoice_number"    =>  $invoice_number,
                        "callback_url"      =>  route('parent.invoices'),
                        "auto_redirect"     =>  true,
                    ),
                    "payment" => array(
                        "payment_due_date" => 43800 // 1 month
                    )
                );
    
                $digest_hash = base64_encode(hash('sha256', json_encode($request_body, JSON_NUMERIC_CHECK), true));
                
                $signature_component  = "Client-Id:".$client_id."\n".
                                        "Request-Id:".$request_id."\n" .
                                        "Request-Timestamp:".$request_timestamp."\n".
                                        "Request-Target:".$target_path."\n".
                                        "Digest:".$digest_hash;
                            
                $signature = base64_encode(hash_hmac('sha256', $signature_component, $secret_key, true));
            
                try {
                    $response = Http::withHeaders([
                        'Client-Id'         =>  $client_id,
                        'Request-Id'        =>  $request_id,
                        'Request-Timestamp' =>  $request_timestamp,
                        'Signature'         =>  "HMACSHA256=" . $signature,
                    ])->post($endpoint, $request_body);
    
                    $response_data  =   json_decode($response->body());
    
                    if($response->status() == 200){
                        $invoice_id =   DB::table('invoices')->insertGetId([
                            'student_id'        => $student_id,
                            'invoice_number'    => $invoice_number,
                            'invoice_items'     => json_encode($invoice_items->toArray(), JSON_NUMERIC_CHECK),
                            'date_issued'       => $date_admission,
                            'due_date'          => $due_date->addWeeks(2)->toDateString(),
                            'amount'            => $totalFee,
                            'currency'          => $currency,
                            'bill_id'           => $response_data->response->payment->token_id,
                            'payment_url'       => $response_data->response->payment->url,
                        ]);
                        return $invoice_id;
                    }
                } catch (RequestException $e) {
                    event(new DatabaseTransactionEvent($e));
                }
            }
            else{
                return redirect()->back()->with(['type'=>'error', 'message'=>'An error has occurred, please try again']);
            }
        // }
        // else{
        //     $invoice_id =   DB::table('invoices')->insertGetId([
        //         'student_id'        => $student_id,
        //         'invoice_number'    => $invoice_number,
        //         'invoice_items'     => json_encode($invoice_items->toArray(), JSON_NUMERIC_CHECK),
        //         'date_issued'       => $date_admission,
        //         'due_date'          => $due_date->addWeeks(2)->toDateString(),
        //         'amount'            => $totalFee,
        //         'currency'          => $currency,
        //     ]);

        //     return $invoice_id;
        // }
    }
    
    public  static function getStudentFeeInvoices($student_id)
    {
        $fee_invoices   =   DB::table('invoices')
                                ->join('invoice_status', 'invoices.status', '=', 'invoice_status.id')
                                ->where('student_id', $student_id)
                                ->select(   'invoices.id', 'invoices.invoice_number', 'invoices.invoice_items', 'invoices.date_issued', 'invoices.due_date', 'invoices.amount', 
                                            'invoice_status.id as status_id','invoice_status.name as status', 'invoice_status.bg_color as status_bg_color', 
                                            'invoices.bill_id', 'invoices.payment_url', 'invoice_status.text_color as status_text_color')
                                ->orderBy('invoices.date_issued')
                                ->get();

        return $fee_invoices;
    }

    public static function getCurrentYearInvoiceNumber($invoice_config){

        $quota              =   $invoice_config->quota;
        $current_count      =   $invoice_config->current_count;

        $invoice_number =   str_pad($current_count + 1, strlen((string)$quota), '0', STR_PAD_LEFT);

        DB::table('invoice_config')->whereYear('year', Carbon::now()->year)->update([
            'quota'         => $quota - 1 ,
            'current_count' => $current_count + 1 ,
        ]);

        return $invoice_number; 

    }

    public static function checkInvoiceQuota($invoice_config){

        $quota              =   $invoice_config->quota;
        $quota_exceeded     =   $quota < 1 ? true : false;

        return  $quota_exceeded;
    }
}
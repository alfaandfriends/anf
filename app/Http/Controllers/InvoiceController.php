<?php

namespace App\Http\Controllers;

use App\Classes\CentreHelper;
use App\Classes\ClassHelper;
use App\Classes\InvoiceHelper;
use App\Classes\ProgrammeHelper;
use App\Classes\StudentHelper;
use App\Classes\UserHelper;
use App\Events\DatabaseTransactionEvent;
use Billplz\Laravel\Billplz;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia; 
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Ramsey\Uuid\Uuid;

class InvoiceController extends Controller
{
    public static $malaysia    =   1;
    public static $indonesia   =   2;

    public function feeInvoiceIndex(Request $request)
    {
        $allowed_centres    =   Inertia::getShared('allowed_centres');
        if($allowed_centres->isEmpty()){
            return back()->with(['type'=>'error', 'message'=>"Sorry, you don't have access to centres. Please contact support to gain access for centres."]);
        }
        $can_access_centre = $allowed_centres->search(function ($value) {
            return $value->ID == request('centre_id');
        });
        $query =   DB::table('invoices')
                        ->join('students', 'invoices.student_id', '=', 'students.id')
                        ->join('children', 'students.children_id', '=', 'children.id')
                        ->join('wpvt_users', 'children.parent_id', '=', 'wpvt_users.ID')
                        ->join('invoice_status', 'invoices.status', '=', 'invoice_status.id')
                        ->select('invoices.id', 'invoices.invoice_number', 'invoices.invoice_items', 'children.name as student_name', 
                                    'wpvt_users.display_name as parent_full_name', 'wpvt_users.user_address as parent_address', 
                                    'invoices.date_issued', 'invoices.due_date', 'invoices.amount', 'invoice_status.name as status', 
                                    'invoice_status.bg_color as status_bg_color', 'invoice_status.text_color as status_text_color', 'invoices.can_delete');
        
        $request->merge([
            'centre_id' => $request->centre_id && $can_access_centre ? $request->centre_id : $allowed_centres[0]->ID
        ]);  
        
        if($request->search){
            $query->where(function ($query){
                $query->where('children.name', 'LIKE', '%'.request('search').'%')
                ->orWhere('invoices.invoice_number', 'LIKE', '%'.request('search').'%')
                ->orWhere('invoice_status.name', 'LIKE', '%'.request('search').'%');
            });
        }    
        
        if($request->centre_id){
            $centreIdJson = json_encode(["centre_id" => $request->centre_id], JSON_NUMERIC_CHECK);
            $query->whereRaw('JSON_CONTAINS(invoices.invoice_items, ?)', [$centreIdJson]);
        }     
        
        if($request->programme_id){
            $query->where('invoices.invoice_items', 'LIKE', '%programme_id": '.$request->programme_id.'%');
        }     
        
        if($request->date){
            $month  =   $request->date['month'] + 1  < 10 ? '-0'.$request->date['month'] + 1 : '-'.$request->date['month'] + 1;
            $query->where('invoices.date_issued', 'LIKE', '%'.$request->date['year'].$month.'%');
        }      

        $programmes =   ProgrammeHelper::programmes();
        
        return Inertia::render('Invoices/Index', [
            'filter'        =>  request()->all('search', 'centre_id', 'programme_id', 'date'),
            'invoices'      =>  $query->paginate(10),
            'programmes'    =>  $programmes,
        ]);
    }

    public function feeInvoiceCreate(Request $request){
        $programmes     =   ProgrammeHelper::programmes();
        $fee_types      =   ClassHelper::classTypeDetails();
        $levels         =   ProgrammeHelper::distinctLevels();
        $payment_status =   InvoiceHelper::invoiceStatus();

        return Inertia::render('Invoices/Create', [
            'programmes'        =>  $programmes,
            'fee_types'         =>  $fee_types,
            'levels'            =>  $levels,
            'payment_status'    =>  $payment_status,
            'params'            =>  $request->params,
        ]);
    }
    
    public function feeInvoiceStore(Request $request){
        try {
            DB::beginTransaction();

            /* Default single invoice */
            $invoice_to_create_count    =   1;

            /* If Bulk Create */
            if($request->create_bulk){
                $from_date = Carbon::create($request->from_date['year'], $request->from_date['month']+1, 1)->startOfMonth();
                $to_date = Carbon::create($request->to_date['year'], $request->to_date['month']+1, 1)->startOfMonth();
                do
                {
                    $months[$from_date->format('m-Y')] = $from_date->format('F Y');
                } 
                while ($from_date->addMonth() <= $to_date);

                $invoice_to_create_count    =   count($months);
                
                $currentYear        =   Carbon::now()->year;
                $invoice_config     =   DB::table('invoice_config')->whereYear('year', $currentYear)->first();
                $quota_exceeded     =   $this->checkInvoiceQuota($invoice_config->quota, $invoice_to_create_count);
                
                if($quota_exceeded){
                    return redirect(route('fee.invoices'))->with(['type'=>'error', 'message'=>'Invoice quota exceeded, please contact technical support!']);
                }

                $currency  =   StudentHelper::getStudentCurrency($request->student_id);

                $start_month = Carbon::create($request->from_date['year'], $request->from_date['month']+1, 1)->startOfMonth();
                
                foreach(range(1, $invoice_to_create_count) as $index){
                    $invoice_number    =   $this->getCurrentYearInvoiceNumber($invoice_config->quota, $invoice_config->current_count);
                    
                    $invoice_id =   DB::table('invoices')->insertGetId([
                        'student_id'                => $request->student_id,
                        'invoice_number'            => Carbon::now()->year.'-'.$invoice_number,
                        'invoice_items'             => json_encode($request->invoice_items, JSON_NUMERIC_CHECK),
                        'date_issued'               => $start_month->format('Y-m-d'),
                        'due_date'                  => $start_month->copy()->addDays(7)->format('Y-m-d'),
                        'amount'                    => $request->invoice_amount,
                        'currency'                  => $currency,
                        'status'                    => $request->status,
                        'can_delete'                => 1,
                    ]);
                    $start_month->addMonths(1);
                    $invoice_config->quota -= 1;
                    $invoice_config->current_count += 1;
                    
                    $log_data =   'Added invoice ID '.$invoice_id;
                    event(new DatabaseTransactionEvent($log_data));
                }
            }
            else{
                $currentYear        =   Carbon::now()->year;
                $invoice_config     =   DB::table('invoice_config')->whereYear('year', $currentYear)->first();
                $quota_exceeded     =   $this->checkInvoiceQuota($invoice_config->quota, $invoice_to_create_count);

                if($quota_exceeded){
                    return redirect(route('fee.invoices', $request->params))->with(['type'=>'error', 'message'=>'Invoice quota exceeded, please contact technical support!']);
                }

                $currency  =   StudentHelper::getStudentCurrency($request->student_id);
                $invoice_number     =   $this->getCurrentYearInvoiceNumber($invoice_config->quota, $invoice_config->current_count);
                
                if($request->file('payment.proof.file')){
                    $file = $request->file('payment.proof.file');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    Storage::putFileAs('proof_of_payment', $request->file('payment.proof.file'), $filename);
                }
                
                $invoice_id =   DB::table('invoices')->insertGetId([
                    'student_id'                => $request->student_id,
                    'invoice_number'            => Carbon::now()->year.'-'.$invoice_number,
                    'invoice_items'             => json_encode($request->invoice_items, JSON_NUMERIC_CHECK),
                    'date_issued'               => Carbon::parse($request->date_issued)->format('Y-m-d'),
                    'due_date'                  => Carbon::parse($request->due_date)->format('Y-m-d'),
                    'amount'                    => $request->invoice_amount,
                    'currency'                  => $currency,
                    'status'                    => $request->status,
                    'payment_date'              => $request->payment['date'] ? Carbon::parse($request->payment['date'])->format('Y-m-d') : null,
                    'payment_transaction_id'    => $request->payment['transaction_id'] ? $request->payment['transaction_id'] : null,
                    'payment_proof'             => $request->file('payment.proof') ? $filename : null,
                    'can_delete'                => 1
                ]);
                
                $log_data =   'Added invoice ID '.$invoice_id;
                event(new DatabaseTransactionEvent($log_data));
            }

            DB::commit();

            return redirect(route('fee.invoices', $request->params))->with(['type'=>'success', 'message'=>'Invoices have been successfully generated!']);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect(route('fee.invoices', $request->params))->with(['type'=>'error', 'message'=>'Something went wrong, please try again!']);
        }
    }

    public function feeInvoiceEdit(Request $request){
        $invoice_data   =   DB::table('invoices')
                                ->join('students', 'invoices.student_id', '=', 'students.id')
                                ->join('children', 'students.children_id', '=', 'children.id')
                                ->select('invoices.id', 'invoices.invoice_number', 'invoices.invoice_items', 'children.name as student_name', 
                                            'invoices.date_issued', 'invoices.due_date', 'invoices.amount', 'invoices.status as status',
                                            'invoices.payment_date', 'invoices.payment_transaction_id', 'invoices.payment_proof')
                                ->where('invoices.id', $request->invoice_id)->first();

        $invoice_status  =   InvoiceHelper::invoiceStatus();

        return Inertia::render('Invoices/Edit', [
            'invoice_data'      =>  $invoice_data,
            'invoice_status'    =>  $invoice_status,
            'params'            =>  $request->params
        ]);
    }

    public function feeInvoiceDestroy($id){
        try {
            DB::beginTransaction();

            DB::table('invoices')->where('id', $id)->delete();

            DB::commit();

            $log_data =   'Deleted invoice ID '.$id;
            event(new DatabaseTransactionEvent($log_data));

            return back()->with(['type'=>'success', 'message'=>'Invoice deleted successfully! ']);
        } catch (Exception $e) {
            DB::rollback();
            return back()->with(['type'=>'error', 'message'=>'An error has occurred, please try again!']);
        }
    }

    public function feeInvoiceUpdate(Request $request){
        $invoice_record     =   DB::table('invoices')->where('id', $request->invoice_id)->first();

        if($request->payment['proof']['delete_previous']){
            $file_deleted   =   Storage::delete('proof_of_payment/'.$invoice_record->payment_proof);
            $invoice_record->payment_proof  =   '';
        }

        if($request->file('payment.proof.file')){
            $file = $request->file('payment.proof.file');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            Storage::putFileAs('proof_of_payment', $request->file('payment.proof.file'), $filename);
        }
        if((int)$request->invoice_amount !== (int)$invoice_record->amount && $request->payment['status'] == 1){
            $student_country    =   StudentHelper::getStudentCountryId($invoice_record->student_id);
            if($student_country == self::$malaysia){
                $bill_collection_id     =   config('app.billplz.collection_id');
                $bill_email             =   env('APP_ENV') == 'local' ? 'abdulraof628@gmail.com' : StudentHelper::getStudentEmail($invoice_record->student_id);
                $bill_mobile            =   '';
                $bill_name              =   StudentHelper::getStudentName($invoice_record->student_id);
                $bill_amount            =   $request->invoice_amount * 100;
                $bill_callback          =   route('fee.invoices.callback.my');
                $bill_description       =   'Invoice Number: '.$invoice_record->invoice_number;
                $bill_response          =   Billplz::bill()->create($bill_collection_id, $bill_email, $bill_mobile, $bill_name, $bill_amount, $bill_callback, $bill_description, [
                                                'due_at'    =>  $invoice_record->due_date,
                                                'redirect_url' => route('fee.invoices.check_status')
                                            ]); 
                          
                if($bill_response->getStatusCode() == 200){
                    $invoice_id =   DB::table('invoices')->where('id', $request->invoice_id)->update([
                                        'amount'            => $request->invoice_amount,
                                        'bill_id'           => $bill_response->toArray()['id'],
                                        'payment_url'       => env('VITE_BILLPLZ_ENDPOINT').$bill_response->toArray()['id'],
                                    ]);
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
                        "amount"            =>  $request->invoice_amount,
                        "invoice_number"    =>  $invoice_record->invoice_number,
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
                        $invoice_id =   DB::table('invoices')->where('id', $request->invoice_id)->update([
                            'amount'            => $request->invoice_amount,
                            'bill_id'           => $response_data->response->payment->token_id,
                            'payment_url'       => $response_data->response->payment->url,
                        ]);
                    }
                } catch (RequestException $e) {
                    event(new DatabaseTransactionEvent($e));
                }
            }
        }
        else{
            DB::table('invoices')->where('id', $request->invoice_id)->update([
                'amount'            => $request->invoice_amount,
            ]);
        }

        DB::table('invoices')->where('id', $request->invoice_id)->update([
            'invoice_items'             =>  json_encode($request->invoice_items, JSON_NUMERIC_CHECK),
            'status'                    =>  $request->payment['status'],
            'payment_date'              =>  Carbon::parse($request->payment['date'])->format('Y-m-d'),
            'payment_transaction_id'    =>  $request->payment['transaction_id'],
            'payment_proof'             =>  $request->file('payment.proof') ? $filename : $invoice_record->payment_proof,
        ]);
                
        $log_data =   'Updated invoice ID '.$request->invoice_id;
        event(new DatabaseTransactionEvent($log_data));

        return redirect(route('fee.invoices', $request->params))->with(['type'=>'success', 'message'=>'Invoice updated successfully !']);
    }

    public function getCurrentYearInvoiceNumber($quota, $current_count){

        $invoice_number =   str_pad($current_count + 1, strlen((string)$quota), '0', STR_PAD_LEFT);

        DB::table('invoice_config')->whereYear('year', Carbon::now()->year)->update([
            'quota'         => $quota - 1 ,
            'current_count' => $current_count + 1 ,
        ]);

        return $invoice_number; 

    }

    public function checkInvoiceQuota($quota, $invoice_to_create_count){

        $quota_exceeded     =   $quota - $invoice_to_create_count >= 0 ? false : true;

        return  $quota_exceeded;
    }

    public function feeInvoiceGenerate(Request $request){
        $invoice_data   =   DB::table('invoices')
                                ->join('students', 'invoices.student_id', '=', 'students.id')
                                ->join('children', 'students.children_id', '=', 'children.id')
                                ->join('wpvt_users', 'children.parent_id', '=', 'wpvt_users.ID')
                                ->join('invoice_status', 'invoices.status', '=', 'invoice_status.id')
                                ->select('invoices.invoice_number', 'invoices.invoice_items', 'children.name as student_name', 
                                            'wpvt_users.display_name as parent_full_name', 'wpvt_users.user_address as parent_address', 
                                            'invoices.date_issued', 'invoices.due_date', 'invoices.amount', 'invoices.currency')
                                ->where('invoices.id', $request->invoice_id)
                                ->first();
                                
        $data   =   [
            'parent_full_name'  => $invoice_data->parent_full_name,
            'parent_address'    => $invoice_data->parent_address,
            'student_name'      => $invoice_data->student_name,
            'invoice_number'    => $invoice_data->invoice_number,
            'date_issued'       => Carbon::parse($invoice_data->date_issued)->format('d M Y'),
            'due_date'          => Carbon::parse($invoice_data->due_date)->format('d M Y'),
            'invoice_items'     => json_decode($invoice_data->invoice_items),
            'amount'            => $invoice_data->amount,
            'currency'          => $invoice_data->currency,
        ];
        
        $pdf = PDF::setPaper('a4', 'portrait')->loadView('invoices.fee_invoice', compact('data'));
        return $pdf->download($invoice_data->invoice_number.'.pdf');
    }

    
    public function callbackMy(Request $request)
    {
        return response('OK', 200)->header('Content-Type', 'text/plain');
    }

    public function callbackId(Request $request){
        $client_id              = $request->header('Client-Id');
        $request_id             = $request->header('Request-Id');
        $request_timestamp      = $request->header('Request-Timestamp');
        $header_signature       = $request->header('Signature');
        
        $request_body           = $request->getContent();
        $decoded_request_body   = json_decode($request->getContent(), true);
        
        $notification_path  = '/api/fee_invoices/callback/id'; // Adjust according to your notification path
        $secretKey          = env('VITE_DOKU_SECRET_KEY'); // Adjust according to your secret key
    
        $digest = base64_encode(hash('sha256', $request_body, true));

        $raw_signature = "Client-Id:" . $client_id . "\n"
            . "Request-Id:" . $request_id . "\n"
            . "Request-Timestamp:" . $request_timestamp . "\n"
            . "Request-Target:" . $notification_path . "\n"
            . "Digest:" . $digest;
    
        $signature = base64_encode(hash_hmac('sha256', $raw_signature, $secretKey, true));
        
        $finalSignature = 'HMACSHA256=' . $signature;

        if ($finalSignature == $header_signature) {
            if($decoded_request_body['transaction']['status'] == 'SUCCESS'){
                
                $invoice_id   =   DB::table('invoices')->where('invoice_number', $decoded_request_body['order']['invoice_number'])->pluck('id')->first();
                /* Update invoice status to paid */
                DB::table('invoices')->where('invoice_number', $decoded_request_body['order']['invoice_number'])->update([
                    'status'    => 2
                ]);
                /* Update order status to processing */
                DB::table('orders')->where('invoice_id', $invoice_id)->update([
                    'status'    => 2
                ]);
                return response('OK', 200)->header('Content-Type', 'text/plain');
            }
        }
    }

    public function checkStatus(Request $request){
        $data = Billplz::bill()->get($request->billplz['id'])->getContent();
        if($data['paid']){
            $invoice_id   =   DB::table('invoices')->where('bill_id', $request->billplz['id'])->pluck('id')->first();
            /* Update invoice status to paid */
            DB::table('invoices')->where('bill_id', $request->billplz['id'])->update([
                'status'    => 2
            ]);
            /* Update order status to processing */
            DB::table('orders')->where('invoice_id', $invoice_id)->update([
                'status'    => 2
            ]);
        }
        return redirect()->route('parent.invoices');
    }
}

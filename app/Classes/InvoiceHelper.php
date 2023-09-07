<?php

namespace App\Classes;

use Billplz\Laravel\Billplz;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class InvoiceHelper {

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

        $totalFee = $invoice_items->sum(function ($item) {
            return $item['include_material_fee']
                ? $item['programme_fee'] + $item['material_fee']
                : $item['programme_fee'];
        });
        
        $due_date           =   Carbon::parse($invoice_data['date_admission'])->addDays(7)->toDateString();  
        $student_id         =   $invoice_data['student_id'];
        $invoice_number     =   Carbon::now()->year.'-'.$invoice_number;
        $date_admission     =   $invoice_data['date_admission'];
        

        $bill_collection_id     =   config('app.billplz.collection_id');
        $bill_email             =   auth()->user()->user_email;
        $bill_mobile            =   '';
        $bill_name              =   auth()->user()->display_name;
        $bill_amount            =   $totalFee * 100;
        $bill_callback          =   route('parent.invoices.callback');
        $bill_description       =   'Invoice Number: '.$invoice_number;
        $bill_response          =   Billplz::bill()->create($bill_collection_id, $bill_email, $bill_mobile, $bill_name, $bill_amount, $bill_callback, $bill_description, [
                                        'due_at'    =>  $due_date,
                                        'redirect_url' => route('parent.invoices.callback')
                                    ]); 
                  
        if($bill_response->getStatusCode() == 200){
            $invoice_id =   DB::table('invoices')->insertGetId([
                                'student_id'        => $student_id,
                                'invoice_number'    => $invoice_number,
                                'invoice_items'     => json_encode($invoice_items->toArray()),
                                'date_issued'       => $date_admission,
                                'due_date'          => $due_date,
                                'amount'            => $totalFee,
                                'bill_id'           => $bill_response->toArray()['id'],
                            ]);
    
            return $invoice_id;
        }
        return false;
    }

    public  static function updateFeeInvoice($invoice_data)
    {
        $latest_fee_invoice     =   DB::table('invoices')->where('student_id', $invoice_data['student_id'])->latest()->first();
        $invoice_items          =   json_decode($latest_fee_invoice->invoice_items);

        
        dd();
    }
    public  static function getStudentFeeInvoices($student_id)
    {
        $fee_invoices   =   DB::table('invoices')
                                ->join('invoice_status', 'invoices.status', '=', 'invoice_status.id')
                                ->where('student_id', $student_id)
                                ->select(   'invoices.id', 'invoices.invoice_number', 'invoices.invoice_items', 'invoices.date_issued', 'invoices.due_date', 'invoices.amount', 
                                            'invoice_status.id as status_id','invoice_status.name as status', 'invoice_status.bg_color as status_bg_color', 
                                            'invoices.bill_id', 'invoice_status.text_color as status_text_color')
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
<?php

namespace App\Classes;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class InvoiceHelper {
    
    public static $fee_invoice_id   =   1;
    public static  $product_invoice_id   =   2;

    public static function invoiceStatus()
    {
        $status =   DB::table('invoice_status')->get();

        return $status;
    }

    public static function newFeeInvoice($data)
    {
        $currentYear        =   Carbon::now()->year;
        $invoice_config     =   DB::table('invoice_config')->whereYear('year', $currentYear)->first();

        $quota_exceeded    =   self::checkInvoiceQuota($invoice_config);

        if($quota_exceeded){
            return false;
        }

        $invoice_number    =   self::getCurrentYearInvoiceNumber($invoice_config);

        $invoice_data   =   DB::table('student_fees')
                            ->join('programme_level_fees', 'student_fees.fee_id', '=', 'programme_level_fees.id')
                            ->join('programme_levels', 'student_fees.fee_id', '=', 'programme_level_fees.id')
                            ->join('programmes', 'student_fees.fee_id', '=', 'programme_level_fees.id')
                            ->join('centres', 'student_fees.centre_id', '=', 'centres.id')
                            ->join('class_types_detail', 'programme_level_fees.class_type_detail_id', '=', 'class_types_detail.id')
                            ->select(   'centres.ID as centre_id', 'centres.label as centre_name', 'programme_levels.material_fee', 'programmes.id as programme_id',
                                        'programmes.name as programme_name', 'programme_levels.level as programme_level', 'programme_level_fees.fee_amount as programme_fee', 
                                        'class_types_detail.label as programme_type')
                            ->where('student_fees.id', $data['student_fee_id'])
                            ->first();

        $invoice_items      =   array(
            "centre_id" => $invoice_data->centre_id,
            "centre_name" => $invoice_data->centre_name,
            "material_fee" => $invoice_data->material_fee,
            "programme_id" => $invoice_data->programme_id,
            "programme_fee" => $invoice_data->programme_fee,
            "programme_name" => $invoice_data->programme_name,
            "programme_type" => $invoice_data->programme_type,
            "programme_level" => $invoice_data->programme_level,
            "include_material_fee" => true,
            "material_fee_discount" => 0,
            "programme_fee_discount" => 0
        );

        DB::table('invoices')->insert([
            'invoice_type_id'           => self::$fee_invoice_id,
            'student_id'                => $data['student_id'],
            'invoice_number'            => Carbon::now()->year.'-'.$invoice_number,
            'invoice_items'             => json_encode([$invoice_items]),
            'date_issued'               => $data['date_admission'],
            'due_date'                  => Carbon::parse($data['date_admission'])->addDays(7)->toDateString(),
            'amount'                    => $invoice_data->material_fee + $invoice_data->programme_fee,
        ]);

        return true;
    }

    public  static function getStudentFeeInvoices($student_id)
    {
        $fee_invoices   =   DB::table('invoices')
                                ->join('invoice_status', 'invoices.status', '=', 'invoice_status.id')
                                ->where('invoice_type_id', self::$fee_invoice_id)
                                ->where('student_id', $student_id)
                                ->select(   'invoices.id', 'invoices.invoice_number', 'invoices.date_issued', 'invoices.due_date', 'invoices.amount', 
                                            'invoice_status.name as status', 'invoice_status.bg_color as status_bg_color', 
                                            'invoice_status.text_color as status_text_color')->get();

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
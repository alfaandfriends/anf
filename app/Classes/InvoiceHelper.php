<?php

namespace App\Classes;

use Illuminate\Support\Facades\DB;

class InvoiceHelper {
    public static function invoiceStatus()
    {
        $status =   DB::table('invoice_status')->get();

        return $status;
    }
}
<?php

namespace App\Classes;

use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PaymentHelper {

    public static function paymentTypes()
    {
        $payment_types   =   collect(DB::table('payment_types')->get());

        return $payment_types;
    }
}
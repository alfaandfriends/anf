<?php

namespace App\Classes;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class OrderHelper {

    public static function getStatus(){
        $status  =   DB::table('order_status')->get();

        return $status;
    }

    public static function getShippingProviders(){
        $shipping_providers  =   DB::table('order_shipping_providers')->get();

        return $shipping_providers;
    }
}
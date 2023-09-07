<?php

namespace App\Classes;

use Illuminate\Support\Carbon;
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
    public static function newOrder($order_data)
    {
        $currentYear    =   Carbon::now()->year;
        $order_config   =   DB::table('order_config')->whereYear('year', $currentYear)->first();

        $quota_exceeded =   self::checkOrderQuota($order_config);

        if($quota_exceeded){
            return back()->with(['type'=>'error', 'message'=>'Quota to create new order has exceeded.']);
        }

        $order_number =   self::getCurrentYearOrderNumber($order_config);

        $order_id     =   DB::table('orders')->insertGetId([
            'student_id'    =>  $order_data['student_id'],
            'invoice_id'    =>  isset($order_data['invoice_id']) ? $order_data['invoice_id'] : null,
            'order_number'  =>  Carbon::now()->year.'-'.$order_number,
            'products'      =>  json_encode([$order_data['products']]),
        ]);

        return $order_id;
    }

    public static function checkOrderQuota($order_config){

        $quota              =   $order_config->quota;
        $quota_exceeded     =   $quota < 1 ? true : false;

        return  $quota_exceeded;
    }

    public static function getCurrentYearOrderNumber($order_config){

        $quota              =   $order_config->quota;
        $current_count      =   $order_config->current_count;

        $order_number =   str_pad($current_count + 1, strlen((string)$quota), '0', STR_PAD_LEFT);

        DB::table('order_config')->whereYear('year', Carbon::now()->year)->update([
            'quota'         => $quota - 1 ,
            'current_count' => $current_count + 1 ,
        ]);

        return $order_number; 

    }
}
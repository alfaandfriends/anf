<?php

namespace App\Classes;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProductHelper {

    public static function getProducts(Request $request){
        $products  =   DB::table('products')->where('name', 'LIKE', '%'.$request->keyword.'%')->limit(10)->get();

        return $products;
    }

    public static function getProductVariations(Request $request){
        $product_variations  =   DB::table('product_variations')->where('product_id', $request->product_id)->get();

        return $product_variations;
    }

    public static function getProductSubVariations(Request $request){
        $product_sub_variations  =   DB::table('product_sub_variations')->where('product_variation_id', $request->product_variation_id)->get();

        return $product_sub_variations;
    }

}
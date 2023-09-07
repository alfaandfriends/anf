<?php

namespace App\Classes;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProductHelper {

    public static function getProducts(Request $request){
        $products   =   DB::table('products')
                            ->leftJoin('product_variations', 'products.id', '=', 'product_variations.product_id')
                            ->leftJoin('product_sub_variations', 'product_variations.id', '=', 'product_sub_variations.product_variation_id')
                            ->where(function($query){
                                $query->whereNotNull('products.stock')
                                        ->where('products.stock', '>', 0);
                            })
                            ->orWhere(function($query){
                                $query->orWhereNotNull('product_variations.stock')
                                        ->where('product_variations.stock', '>', 0);
                            })
                            ->orWhere(function($query){
                                $query->orWhereNotNull('product_sub_variations.stock')
                                        ->where('product_sub_variations.stock', '>', 0);
                            })
                            ->where('products.name', 'LIKE', '%'.$request->keyword.'%')
                            ->distinct()
                            ->select('products.*')
                            ->limit(10)
                            ->get();

        return $products;
    }

    public static function getProductVariations(Request $request){
        $product_variations  =   DB::table('product_variations')->where('product_id', $request->product_id)->where('stock', '>', 0)->limit(10)->get();

        return $product_variations;
    }

    public static function getProductSubVariations(Request $request){
        $product_sub_variations  =   DB::table('product_sub_variations')->where('product_variation_id', $request->product_variation_id)->where('stock', '>', 0)->limit(10)->get();

        return $product_sub_variations;
    }

}
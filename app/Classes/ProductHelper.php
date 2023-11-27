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
                                $query->whereNotNull('product_variations.stock')
                                        ->where('product_variations.stock', '>', 0);
                            }) 
                            ->orWhere(function($query){
                                $query->whereNotNull('product_sub_variations.stock')
                                        ->where('product_sub_variations.stock', '>', 0);
                            }) 
                            // ->where(function($query){
                            //     $query->whereNotNull('products.stock')
                            //             ->where('products.stock', '>', 0)
                            //             ->whereNotNull('product_variations.stock')
                            //             ->where('product_variations.stock', '>', 0);
                            // }) 
                            // ->where(function($query){
                            //     $query->whereNotNull('products.stock')
                            //             ->where('products.stock', '>', 0)
                            //             // ->whereNotNull('product_variations.stock')
                            //             // ->where('product_variations.stock', '>', 0);
                            //             ->orWhereNotNull('product_sub_variations.stock')
                            //             ->where('product_sub_variations.stock', '>', 0);
                            // })
                            // ->orWhere(function($query){
                            //     $query->orWhereNotNull('product_variations.stock')
                            //             ->where('product_variations.stock', '>', 0);
                            // })
                            // ->where(function($query){
                            //     $query->orWhereNotNull('product_sub_variations.stock')
                            //             ->where('product_sub_variations.stock', '>', 0);
                            // })
                            ->where('products.name', 'LIKE', '%'.$request->keyword.'%')
                            ->distinct()
                            ->select('products.*')
                            ->limit(10)
                            ->get();

        return $products;
    }

    public static function getProductVariations(Request $request){
        $product_variations     =   DB::table('products')
                                        ->leftJoin('product_variations', 'products.id', '=', 'product_variations.product_id')
                                        ->leftJoin('product_sub_variations', 'product_variations.id', '=', 'product_sub_variations.product_variation_id')
                                        ->where('product_variations.product_id', $request->product_id)
                                        ->where(function ($query) {
                                            $query->where('product_variations.stock', '>', 0);
                                            $query->orWhere('product_sub_variations.stock', '>', 0);
                                        })
                                        ->distinct()
                                        ->select('product_variations.*')
                                        ->limit(10)
                                        ->get();

        return $product_variations;
    }

    public static function getProductSubVariations(Request $request){
        $product_sub_variations     =   DB::table('product_sub_variations')
                                            ->where('product_variation_id', $request->product_variation_id)
                                            ->where('stock', '>', 0)
                                            ->limit(10)
                                            ->get();

        return $product_sub_variations;
    }

    public static function getProductDataByFee($fee_ids){
        $product_result   =   DB::table('programme_level_fees')
                                ->join('programme_levels', 'programme_level_fees.programme_level_id', '=', 'programme_levels.id')
                                ->join('products', 'programme_levels.material_product_id', '=', 'products.id')
                                ->leftJoin('product_variations', 'programme_levels.material_product_variation_id', '=', 'product_variations.id')
                                ->leftJoin('product_sub_variations', 'programme_levels.material_product_sub_variation_id', '=', 'product_sub_variations.id')
                                ->whereIn('programme_level_fees.id', $fee_ids)
                                ->select('products.id as product_id', 'products.name as product_name', 'products.name as product_name', 'products.has_variation as has_variation', 
                                            'products.has_sub_variation as has_sub_variation', 'product_variations.id as product_variation_id', 
                                            'product_variations.option_name as product_variation_name', 'product_sub_variations.id as product_sub_variation_id', 
                                            'product_sub_variations.option_name as product_sub_variation_name')
                                ->get();
        $material                                       =   [];
        foreach($product_result as $product){
            $info['product']['id']                          =   $product->product_id;
            $info['product']['name']                        =   $product->product_name;
            $info['product']['has_variation']               =   $product->has_variation;
            $info['product']['has_sub_variation']           =   $product->has_sub_variation;
            $info['product_variation']['id']                =   $product->product_variation_id;
            $info['product_variation']['option_name']       =   $product->product_variation_name;
            $info['product_sub_variation']['id']            =   $product->product_sub_variation_id;
            $info['product_sub_variation']['option_name']   =   $product->product_sub_variation_name; 
            $info['quantity']                               =   1; 
            $material[]                                     =   $info; 
        }
        return $material;
    }

}
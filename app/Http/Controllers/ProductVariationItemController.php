<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductVariationItemRequest;
use App\Http\Requests\UpdateProductVariationItemRequest;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariation;
use App\Models\ProductVariationItem;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductVariationItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductVariationItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductVariationItemRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductVariationItem  $productVariationItem
     * @return \Illuminate\Http\Response
     */
    public function show(ProductVariationItem $productVariationItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductVariationItem  $productVariationItem
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductVariationItem $productVariationItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductVariationItemRequest  $request
     * @param  \App\Models\ProductVariationItem  $productVariationItem
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductVariationItemRequest $request, ProductVariationItem $productVariationItem)
    {
        try {
            DB::transaction(function () use ($request, $productVariationItem) {
                $productVariationItem->name = $request->name;
                $productVariationItem->price = $request->price;
                $productVariationItem->stock = $request->stock;
                $productVariationItem->sales = $request->sales;
                $productVariationItem->save();
            });

            return redirect(route('products'))->with(['type'=>'success', 'message'=>'Product updated successfully !']);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            return redirect(route('products'))->with(['type'=>'error', 'message'=>'Opps something went wrong']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductVariationItem  $productVariationItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductVariationItem $productVariationItem)
    {
        try {
            DB::transaction(function () use ($productVariationItem) {
                $productVariation = ProductVariation::where('id', $productVariationItem->product_variation_id)->first();
                $productVariationItem->delete();
                $allProductVariationItems = ProductVariationItem::where('product_variation_id', $productVariation->id)->get();

                if ($allProductVariationItems->isEmpty()) {
                    $product = Product::where('id', $productVariation->product_id)->first();
                    $productVariation->delete();
                    $allProductVariation = ProductVariation::where('product_id', $product->id)->get();
                    if ($allProductVariation->isEmpty()) {
                        $productImages = ProductImage::where('product_id', $product->id)->get();
                        foreach ($productImages as $key => $image) {
                            $image->delete();
                        }
                        $product->delete();
                    }
                }


            });

            return redirect(route('products'))->with(['type'=>'success', 'message'=>'Product deleted successfully !']);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            return redirect(route('products'))->with(['type'=>'error', 'message'=>'Opps something went wrong']);
        }
    }

    public function restore($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $productVariationItem = ProductVariationItem::withTrashed()->where('id', $id)->first();
                $productVariation = ProductVariation::withTrashed()->where('id', $productVariationItem->product_variation_id)->first();

                if ($productVariation->trashed()) {
                    $product = Product::withTrashed()->where('id', $productVariation->product_id)->first();
                    if ($product->trashed()) {
                        $productImages = ProductImage::withTrashed()->where('product_id', $product->id)->get();
                        foreach ($productImages as $key => $image) {
                            $image->restore();
                        }
                        $product->restore();
                    }
                    $productVariation->restore();
                    $productVariationItem->restore();
                }
            });

            return redirect(route('products.trash'))->with(['type'=>'success', 'message'=>'Product restored successfully !']);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            return redirect(route('products.trash'))->with(['type'=>'error', 'message'=>'Opps something went wrong']);
        }
    }
}
<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductCategoryRequest;
use App\Http\Requests\UpdateProductCategoryRequest;
use App\Models\ProductCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['categories'] = ProductCategory::paginate(5);
        return Inertia::render('ProductCategory/Index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('ProductCategory/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductCategoryRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                ProductCategory::create([
                    'name' => $request->category_name,
                ]);
            });

            return redirect(route('product-categories'))->with(['type'=>'success', 'message'=>'Product Category added successfully !']);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            return redirect(route('product-categories'))->with(['type'=>'error', 'message'=>'Opps something went wrong']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductCategory $productCategory)
    {
        return Inertia::render('ProductCategory/Create', ['category' => $productCategory]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductCategoryRequest $request, ProductCategory $productCategory)
    {
        try {
            DB::transaction(function () use ($request, $productCategory) {
                $productCategory->name = $request->category_name;
                $productCategory->save();
            });

            return redirect(route('product-categories'))->with(['type'=>'success', 'message'=>'Product Category updated successfully !']);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            return redirect(route('product-categories'))->with(['type'=>'error', 'message'=>'Opps something went wrong']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCategory $productCategory)
    {
        try {
            DB::transaction(function () use ($productCategory) {
                $productCategory->delete();
            });

            return redirect(route('product-categories'))->with(['type'=>'success', 'message'=>'Product Category deleted successfully !']);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            return redirect(route('product-categories'))->with(['type'=>'error', 'message'=>'Opps something went wrong']);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\ProductVariation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) : Response
    {
        $data['products'] = Product::with(
            'images:id,product_id,name,path',
        )->when($request->search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->when($request->filter, function ($query, $filter) {
            return $query->where('name', 'like', '%' . $filter . '%');
        })->paginate(10);

        $data['categories'] = ProductCategory::select('id', 'name')->get();

        return Inertia::render('Product/Index', $data);
    }

    public function trash(Request $request) : Response
    {
        $data['products'] = Product::with(
            [
                'images' => fn($q) => $q->onlyTrashed(),
                'variations' => fn($q) => $q->onlyTrashed(),
            ]
        )->when($request->search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->when($request->filter, function ($query, $filter) {
            return $query->where('name', 'like', '%' . $filter . '%');
        })->onlyTrashed()->paginate(10);

        return Inertia::render('Product/Trash', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() : Response
    {
        $data['categories'] = ProductCategory::select('id', 'name')->get();
        return Inertia::render('Product/Create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        dd($request->all());
        $data = [];
        try {
            DB::transaction(function () use ($request, $data) {
                $product = Product::create([
                    'name' => $request->product_name,
                    'description' => $request->product_description,
                    'product_category_id' => $request->product_category,
                    'has_variation' => ($request->product_variation == 'enabled') ? true : false,
                ]);

                foreach($request->all() as $key => $value) {
                    if ($request->hasFile($key)) {
                        ProductImage::create([
                            'name' => str_replace('product_', '', $key),
                            'path' => $request->file($key)->store('products'),
                            'product_id' => $product->id,
                        ]);
                    }
                }

                if ($request->product_variation == 'disabled') {
                    array_push($data, [
                        'name' => $request->product_name,
                        'price' => $request->product_price,
                        'stock' => $request->product_stock,
                        'sku' => '',
                        'sales' => 0
                    ]);
                } else {
                    foreach($request->product_variation_items['options'] as $key => $variation) {
                        $path = null;
                        if($variation['image']){
                            $path = 'products/'.$product->id.'/' . $variation['image']->getClientOriginalName();
                            Storage::put($path, file_get_contents($variation['image']));
                        }
                        array_push($data, [
                            'name' => $variation['name'],
                            'image' => '',
                            'url' => $path,
                            'row' => []
                        ]);
                        if(count($variation['rows']) == 1) {
                            foreach($variation['rows'] as $row){
                                array_push($data[$key]['row'], [
                                    'name' => $row['name'],
                                    'price' => $row['price'],
                                    'stock' => $row['stock'],
                                    'sku' => $row['sku'],
                                    'sales' => 0
                                ]);
                            }
                        }else{
                            $product->has_second_variation = true;
                            foreach($variation['rows'] as $row) {
                                array_push($data[$key]['row'], [
                                    'name' => $row['name']['name'],
                                    'price' => $row['price'],
                                    'stock' => $row['stock'],
                                    'sku' => $row['sku'],
                                    'sales' => 0
                                ]);
                            }
                        }
                    }
                }
                $product->details = json_encode($data);
                $product->save();
            });

            return redirect(route('products'))->with(['type'=>'success', 'message'=>'Product added successfully !']);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            return redirect(route('products'))->with(['type'=>'error', 'message'=>'Opps something went wrong']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product) : Response
    {
        $productImages = ProductImage::select('id', 'name', 'path')->where('product_id', $product->id)->get();
        $categories = ProductCategory::select('id', 'name')->get();

        return Inertia::render('Product/Create', [
            'product' => $product,
            'productImages' => $productImages,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = [];
        try {
            DB::transaction(function () use ($request, $product, $data) {
                $product->name = $request->product_name;
                $product->description = $request->product_description;
                $product->product_category_id = $request->product_category;
                $product->has_variation = ($request->product_variation == 'enabled') ? true : false;
                $product->save();

                $productImages = ProductImage::where('product_id', $product->id)->get();
                ProductVariation::where('product_id', $product->id)->delete();

                foreach($request->all() as $name => $value) {
                    if ($request->hasFile($name)) {
                        foreach ($productImages as $image) {
                            $image->path = $request->file($name)->store('products');
                        }
                    }
                }

                if ($request->product_variation == 'disabled') {
                    array_push($data, [
                        'name' => $request->product_name,
                        'price' => $request->product_price,
                        'stock' => $request->product_stock,
                        'sku' => '',
                        'sales' => 0
                    ]);
                } else {
                    foreach($request->product_variation_items['options'] as $key => $variation) {
                        $path = null;
                        if($variation['image']){
                            $path = 'products/'.$product->id.'/' . $variation['image']->getClientOriginalName();
                            Storage::put($path, file_get_contents($variation['image']));
                        }
                        array_push($data, [
                            'name' => $variation['name'],
                            'image' => '',
                            'url' => $path,
                            'row' => [],
                        ]);
                        if(count($variation['rows']) == 1) {
                            foreach($variation['rows'] as $row){
                                array_push($data[$key]['row'], [
                                    'name' => $row['name'],
                                    'price' => $row['price'],
                                    'stock' => $row['stock'],
                                    'sku' => $row['sku'],
                                    'sales' => 0
                                ]);
                            }
                        }else{
                            $product->has_second_variation = true;
                            foreach($variation['rows'] as $row) {
                                array_push($data[$key]['row'], [
                                    'name' => $row['name'],
                                    'price' => $row['price'],
                                    'stock' => $row['stock'],
                                    'sku' => $row['sku'],
                                    'sales' => 0
                                ]);
                            }
                        }
                    }
                }
                $product->details = json_encode($data);
                $product->save();
                // dump($data);
                // dd($product);

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
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product  $product)
    {
        try {
            DB::transaction(function () use ($product) {
                ProductImage::where('product_id', $product->id)->delete();
                ProductVariation::where('product_id', $product->id)->delete();
                $product->delete();
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
                $product = Product::where('id', $id)->withTrashed()->first();
                $product->restore();
                ProductImage::where('product_id', $product->id)->restore();
                ProductVariation::where('product_id', $product->id)->restore();
            });

            return redirect(route('products.trash'))->with(['type'=>'success', 'message'=>'Product restored successfully !']);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            return redirect(route('products.trash'))->with(['type'=>'error', 'message'=>'Opps something went wrong']);
        }
    }
}

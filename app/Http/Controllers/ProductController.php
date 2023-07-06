<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\ProductVariation;
use App\Models\ProductVariationItem;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['products'] = Product::with(
            'images:id,product_id,name,path',
            'variations:id,product_id,variation1,variation2,price,stock,sku,sales',
        )->when($request->search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->when($request->filter, function ($query, $filter) {
            return $query->where('name', 'like', '%' . $filter . '%');
        })->paginate(10);

        $data['categories'] = ProductCategory::select('id', 'name')->get();

        return Inertia::render('Product/Index', $data);
    }

    public function trash(Request $request)
    {
        $data['products'] = Product::with(
            [
                'images' => fn($q) => $q->onlyTrashed(),
                'variations' => fn($q) => $q->onlyTrashed(),
                'variations.items' => fn($q) => $q->onlyTrashed()
            ]
        )->when($request->search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->when($request->filter, function ($query, $filter) {
            return $query->where('name', 'like', '%' . $filter . '%');
        })->onlyTrashed()->paginate(10);

        $items = $data['products']->flatMap(function ($product) {
            return $product->variations->flatMap(function ($variation) use ($product) {
                return $variation->items->map(function ($item) use ($product) {
                    return [
                        'id' => $product->id,
                        'variation_item_id' => $item->id,
                        'name' => $product->name.'-'.$item->name,
                        'price' => $item->price,
                        'sales' => $item->sales,
                        'stock' => $item->stock,
                        'sku' => $item->sku,
                        'image' => ($product->images->first()) ? '../storage/'.$product->images->first()->path : 'https://placehold.co/200x200',
                    ];
                });
            });
        });

        $data['products']->setCollection($items);

        return Inertia::render('Product/Trash', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        try {
            DB::transaction(function () use ($request) {
                $product = Product::create([
                    'name' => $request->product_name,
                    'description' => $request->product_description,
                    'product_category_id' => $request->product_category,
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

                if (empty($request->product_variation_items)) {
                    ProductVariation::create([
                        'variation1' => $request->product_name,
                        'price' => $request->product_price,
                        'stock' => $request->product_stock,
                        'product_id' => $product->id,
                    ]);
                } else {
                    foreach($request->product_variation_items[0]['options'] as $key => $variation) {
                        $path = null;
                        if($variation['image']){
                            $path = 'products/'.$product->id.'/' . $variation['image']->getClientOriginalName();
                            Storage::put($path, file_get_contents($variation['image']));
                        }
                        if(count($variation['row']) == 1) {
                            foreach($variation['row'] as $row){
                                ProductVariation::create([
                                    'image' => $path,
                                    'variation1' => $variation['name'],
                                    'price' => $row['price'],
                                    'stock' => $row['stock'],
                                    'sku' => $row['sku'],
                                    'product_id' => $product->id,
                                ]);
                            }
                        }else{
                            foreach($variation['row'] as $row){
                                ProductVariation::create([
                                    'image' => $path,
                                    'variation1' => $request->product_variation_items[0]['name'],
                                    'variation2' => $row['name'],
                                    'price' => $row['price'],
                                    'stock' => $row['stock'],
                                    'sku' => $row['sku'],
                                    'product_id' => $product->id,
                                ]);
                            }
                        }
                    }
                }

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
    public function edit(Product $product)
    {
        $productImages = ProductImage::select('id', 'name', 'path')->where('product_id', $product->id)->get();
        $categories = ProductCategory::select('id', 'name')->get();
        $productVariatons = ProductVariation::select('id','image','variation1','variation2','price','stock','sku','sales',)->where('product_id', $product->id)->get();
        return Inertia::render('Product/Create', [
            'product' => $product,
            'productVariations' => $productVariatons,
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product  $product)
    {
    }
}

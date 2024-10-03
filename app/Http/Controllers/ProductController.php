<?php

namespace App\Http\Controllers;

use App\Events\DatabaseTransactionEvent;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query   =   DB::table('products');

        if($request->search){
            $query->where('products.name', 'LIKE', '%'.request('search').'%');
        }   

        return Inertia::render('Product/Index', [
            'filter'        =>  request()->all('search'),
            'products'      =>  $query->paginate(10)
        ]);
    }

    public function create()
    {
        return Inertia::render('Product/Create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'basic_info.product_name'           =>  'required',
            'basic_info.product_description'    =>  'required',
        ]);
        
        if(!$request->file('basic_info.product_images.cover')){
            return back()->with(['type'=>'error', 'message'=>'Cover image is required.']);
        }
        
        $request->validate([
            'basic_info.product_price'          =>  'required_unless:detailed_info.has_variation,1',
            'basic_info.product_stock'          =>  'required_unless:detailed_info.has_variation,1',
        ]);

        if($request->detailed_info['has_variation']){
            if(empty($request->detailed_info['variations']['options'])){
                return back()->with(['type'=>'error', 'message'=>'Please add at least 1 variation or disable variation.']);
            }

            $has_variations = collect($request->detailed_info['variations']['options'])->contains(function ($option) {
                return $option['name'] !== null;
            });
    
            if(!$has_variations){
                return back()->with(['type'=>'error', 'message'=>'Please add at least 1 variation or disable variation.']);
            }
            if($request->detailed_info['has_sub_variation']){
                $has_sub_variations = collect($request->detailed_info['variations']['options'])
                ->flatMap(function ($option) {
                    
                    if(empty($option['sub_variations']['options'])){
                        return back()->with(['type'=>'error', 'message'=>'Please add at least one (1) variation or please disable variation.']);
                    }
                    return collect($option['sub_variations']['options'])
                        ->pluck('name')
                        ->filter(function ($name) {
                            return $name !== null;
                        });
                })
                ->isNotEmpty();
    
                if(!$has_sub_variations){
                    return back()->with(['type'=>'error', 'message'=>'Please add at least one (1) sub variation or please disable sub variation.']);
                }
            }
            
        }
        
        $filename['cover_image']      =   '';
        $filename['image_1']    =   '';
        $filename['image_2']    =   '';
        $filename['image_3']    =   '';
        $filename['image_4']    =   '';
        $filename['image_5']    =   '';
        $filename['image_6']    =   '';

        /* Upload Images */
        if($request->file('basic_info.product_images.cover')){
            $filename['cover_image']  =   $request->file('basic_info.product_images.cover.file')->getClientOriginalName();
            Storage::putFileAs('products', $request->file('basic_info.product_images.cover.file'), $filename['cover_image']);
        }
        if($request->file('basic_info.product_images.image_1.file')){
            $filename['image_1']  =   $request->file('basic_info.product_images.image_1.file')->getClientOriginalName();
            Storage::putFileAs('products', $request->file('basic_info.product_images.image_1.file'), $filename['image_1']);
        }
        if($request->file('basic_info.product_images.image_2.file')){
            $filename['image_2']  =   $request->file('basic_info.product_images.image_2.file')->getClientOriginalName();
            Storage::putFileAs('products', $request->file('basic_info.product_images.image_2.file'), $filename['image_2']);
        }
        if($request->file('basic_info.product_images.image_3.file')){
            $filename['image_3']  =   $request->file('basic_info.product_images.image_3.file')->getClientOriginalName();
            Storage::putFileAs('products', $request->file('basic_info.product_images.image_3.file'), $filename['image_3']);
        }
        if($request->file('basic_info.product_images.image_4.file')){
            $filename['image_4']  =   $request->file('basic_info.product_images.image_4.file')->getClientOriginalName();
            Storage::putFileAs('products', $request->file('basic_info.product_images.image_4.file'), $filename['image_4']);
        }
        if($request->file('basic_info.product_images.image_5.file')){
            $filename['image_5']  =   $request->file('basic_info.product_images.image_5.file')->getClientOriginalName();
            Storage::putFileAs('products', $request->file('basic_info.product_images.image_5.file'), $filename['image_5']);
        }
        if($request->file('basic_info.product_images.image_6.file')){
            $filename['image_6']  =   $request->file('basic_info.product_images.image_6.file')->getClientOriginalName();
            Storage::putFileAs('products', $request->file('basic_info.product_images.image_6.file'), $filename['image_6']);
        }
        
        /* Add new product */
        $product_id     =   DB::table('products')->insertGetId([
            'name'                  =>  $request->basic_info['product_name'],
            'description'           =>  $request->basic_info['product_description'],   
            'price'                 =>  !$request->detailed_info['has_variation'] && !$request->detailed_info['has_sub_variation'] ? $request->basic_info['product_price'] : null,
            'stock'                 =>  !$request->detailed_info['has_variation'] && !$request->detailed_info['has_sub_variation'] ? $request->basic_info['product_stock'] : null,
            'cover_image'           =>  $filename['cover_image']!='' ? '/products/'.$filename['cover_image'] : null,  
            'image_1'               =>  $filename['image_1']!='' ? '/products/'.$filename['image_1'] : null,  
            'image_2'               =>  $filename['image_2']!='' ? '/products/'.$filename['image_2'] : null,  
            'image_3'               =>  $filename['image_3']!='' ? '/products/'.$filename['image_3'] : null,  
            'image_4'               =>  $filename['image_4']!='' ? '/products/'.$filename['image_4'] : null,  
            'image_5'               =>  $filename['image_5']!='' ? '/products/'.$filename['image_5'] : null,  
            'image_6'               =>  $filename['image_6']!='' ? '/products/'.$filename['image_6'] : null,  
            'variation_name'        =>  $request->detailed_info['main_variation_name'],  
            'has_variation'         =>  $request->detailed_info['has_variation'],  
            'sub_variation_name'    =>  $request->detailed_info['sub_variation_name'],
            'has_sub_variation'     =>  $request->detailed_info['has_sub_variation'],  
        ]);
                
        $log_data =   'Added product ID '.$product_id;
        event(new DatabaseTransactionEvent($log_data));

        /* Check if variation enabled */
        if($request->detailed_info['has_variation']){
            /* Add variations */
            foreach($request->detailed_info['variations']['options'] as $variation){
                $filename   =   '';
                if($variation['images']['file']){
                    $filename  =   $variation['images']['file']->getClientOriginalName();
                    Storage::putFileAs('products', $variation['images']['file'], $filename);
                }
                
                $product_variation_id     =   DB::table('product_variations')->insertGetId([
                    'product_id'    =>  $product_id,
                    'image'         =>  $filename != '' ? '/products/'.$filename : '',
                    'option_name'   =>  $variation['name'],
                    'price'         =>  !$request->detailed_info['has_sub_variation'] ? $variation['price'] : null,
                    'stock'         =>  !$request->detailed_info['has_sub_variation'] ? $variation['stock'] : null,
                ]);

                /* Check if sub variation enabled */
                if($request->detailed_info['has_sub_variation']){
                    foreach($variation['sub_variations']['options'] as $sub_variation){
                        DB::table('product_sub_variations')->insert([
                            'product_variation_id'      =>  $product_variation_id,
                            'option_name'               =>  $sub_variation['name'],
                            'price'                     =>  $sub_variation['price'],
                            'stock'                     =>  $sub_variation['stock']
                        ]);
                    }
                }
            }
        }
        return redirect(route('products'))->with(['type'=>'success', 'message'=>'Data has been added.']);
    }

    public function edit(Request $request)
    {
        $product                    =   DB::table('products')->where('products.id', $request->product_id)->first();
        $product_variations         =   DB::table('product_variations')->where('product_variations.product_id', $request->product_id)->get();
        $product_sub_variations     =   DB::table('product_sub_variations')
                                            ->whereIn('product_sub_variations.product_variation_id', collect($product_variations)->pluck('id'))
                                            ->orderBy('id')
                                            ->get();

        return Inertia::render('Product/Edit', [
            'product'                   => $product,
            'product_variations'        => $product_variations,
            'product_sub_variations'    => $product_sub_variations,
        ]);
    } 
    public function update(Request $request)
    {
        /* Validation */
        $request->validate([
            'basic_info.product_name'           =>  'required',
            'basic_info.product_description'    =>  'required',
            'basic_info.product_price'          =>  'required_unless:detailed_info.has_variation,1,true',
            'basic_info.product_stock'          =>  'required_unless:detailed_info.has_variation,1,true',
        ]);
        
        if(!$request->file('basic_info.product_images.cover') && !$request->basic_info['product_images']['cover']['value']){
            return back()->with(['type'=>'error', 'message'=>'Cover Image is required.']);
        }

        if($request->detailed_info['has_variation']){
            if(empty($request->detailed_info['variations']['options'])){
                return back()->with(['type'=>'error', 'message'=>'Please add at least 1 variation or disable variation.']);
            }

            $has_variations = collect($request->detailed_info['variations']['options'])->contains(function ($option) {
                return $option['name'] !== null;
            });
    
            if(!$has_variations){
                return back()->with(['type'=>'error', 'message'=>'Please add at least 1 variation or disable variation.']);
            }
            if($request->detailed_info['has_sub_variation']){
                $has_sub_variations = collect($request->detailed_info['variations']['options'])
                ->flatMap(function ($option) {
                    
                    if(empty($option['sub_variations']['options'])){
                        return back()->with(['type'=>'error', 'message'=>'Please add at least 1 variation or disable variation.']);
                    }
                    return collect($option['sub_variations']['options'])
                        ->pluck('name')
                        ->filter(function ($name) {
                            return $name !== null;
                        });
                })
                ->isNotEmpty();
    
                if(!$has_sub_variations){
                    return back()->with(['type'=>'error', 'message'=>'Please add at least 1 sub variation or disable sub variation.']);
                }
            }
            
        }

        $product                =   collect(DB::table('products')->where('id', $request->basic_info['product_id'])->first());
        $product_variations     =   collect(DB::table('product_variations')->where('product_id', $request->basic_info['product_id'])->get());
        $product_sub_variations =   collect(DB::table('product_sub_variations')->whereIn('product_variation_id', $product_variations->pluck('id'))->get());
        
        $filename['cover_image']    =   $product['cover_image'];
        $filename['image_1']        =   $product['image_1'];
        $filename['image_2']        =   $product['image_2'];
        $filename['image_3']        =   $product['image_3'];
        $filename['image_4']        =   $product['image_4'];
        $filename['image_5']        =   $product['image_5'];
        $filename['image_6']        =   $product['image_6'];

        /* Upload or replace image */
        if($request->file('basic_info.product_images.cover.file')){
            $new_image_name             =   $this->replaceImage($request->file('basic_info.product_images.cover.file'), $filename['cover_image']);
            $filename['cover_image']    =   $new_image_name;
        }
        if($request->file('basic_info.product_images.image_1.file')){
            $new_image_name         =   $this->replaceImage($request->file('basic_info.product_images.image_1.file'), $filename['image_1']);
            $filename['image_1']    =   $new_image_name;
        }
        if($request->file('basic_info.product_images.image_2.file')){
            $new_image_name         =   $this->replaceImage($request->file('basic_info.product_images.image_2.file'), $filename['image_2']);
            $filename['image_2']    =   $new_image_name;
        }
        if($request->file('basic_info.product_images.image_3.file')){
            $new_image_name         =   $this->replaceImage($request->file('basic_info.product_images.image_3.file'), $filename['image_3']);
            $filename['image_3']    =   $new_image_name;
        }
        if($request->file('basic_info.product_images.image_4.file')){
            $new_image_name         =   $this->replaceImage($request->file('basic_info.product_images.image_4.file'), $filename['image_4']);
            $filename['image_4']    =   $new_image_name;
        }
        if($request->file('basic_info.product_images.image_5.file')){
            $new_image_name         =   $this->replaceImage($request->file('basic_info.product_images.image_5.file'), $filename['image_5']);
            $filename['image_5']    =   $new_image_name;
        }
        if($request->file('basic_info.product_images.image_6.file')){
            $new_image_name         =   $this->replaceImage($request->file('basic_info.product_images.image_6.file'), $filename['image_6']);
            $filename['image_6']    =   $new_image_name;
        }

        /* Delete existing image */
        if(!$request->file('basic_info.product_images.image_1.file') && !$request->basic_info['product_images']['image_1']['value'] && $filename['image_1']){
            Storage::delete($filename['image_1']);
            $filename['image_1'] = null;
        }
        if(!$request->file('basic_info.product_images.image_2.file') && !$request->basic_info['product_images']['image_2']['value'] && $filename['image_2']){
            Storage::delete($filename['image_2']);
            $filename['image_2'] = null;
        }
        if(!$request->file('basic_info.product_images.image_3.file') && !$request->basic_info['product_images']['image_3']['value'] && $filename['image_3']){
            Storage::delete($filename['image_3']);
            $filename['image_3'] = null;
        }
        if(!$request->file('basic_info.product_images.image_4.file') && !$request->basic_info['product_images']['image_4']['value'] && $filename['image_4']){
            Storage::delete($filename['image_4']);
            $filename['image_4'] = null;
        }
        if(!$request->file('basic_info.product_images.image_5.file') && !$request->basic_info['product_images']['image_5']['value'] && $filename['image_5']){
            Storage::delete($filename['image_5']);
            $filename['image_5'] = null;
        }
        if(!$request->file('basic_info.product_images.image_6.file') && !$request->basic_info['product_images']['image_6']['value'] && $filename['image_6']){
            Storage::delete($filename['image_6']);
            $filename['image_6'] = null;
        }
        
        /* Add new product */
        DB::table('products')->where('id', $request->basic_info['product_id'])->update([
            'name'                  =>  $request->basic_info['product_name'],
            'description'           =>  $request->basic_info['product_description'],   
            'price'                 =>  $request->basic_info['product_price'],
            'stock'                 =>  $request->basic_info['product_stock'],
            'cover_image'           =>  $filename['cover_image'] !='' ? $filename['cover_image'] : null,  
            'image_1'               =>  $filename['image_1'] !='' ? $filename['image_1'] : null,  
            'image_2'               =>  $filename['image_2'] !='' ? $filename['image_2'] : null,  
            'image_3'               =>  $filename['image_3'] !='' ? $filename['image_3'] : null,  
            'image_4'               =>  $filename['image_4'] !='' ? $filename['image_4'] : null,  
            'image_5'               =>  $filename['image_5'] !='' ? $filename['image_5'] : null,  
            'image_6'               =>  $filename['image_6'] !='' ? $filename['image_6'] : null,  
            'has_variation'         =>  $request->detailed_info['has_variation'],
            'variation_name'        =>  $request->detailed_info['main_variation_name'],
            'has_sub_variation'     =>  $request->detailed_info['has_sub_variation'],
            'sub_variation_name'    =>  $request->detailed_info['sub_variation_name'],
        ]);

        /* Check if variation enabled */
        if($request->detailed_info['has_variation']){
            /* Add variations */
            foreach($request->detailed_info['variations']['options'] as $variation){
                if($variation['name']){
                    /* Update existing */
                    $product_variation_id   =   $variation['id'];
                    if($product_variation_id){
                        $variation_file_name   =   $product_variations->where('id', $product_variation_id)->pluck('image')->first();
                        if($variation['images']['file']){
                            $new_image_name         =   $this->replaceImage($variation['images']['file'], $variation_file_name);
                            $variation_file_name    =   $new_image_name;
                        }
                    
                        DB::table('product_variations')->where('id', $product_variation_id)->update([
                            'image'         =>  $variation_file_name != '' ? $variation_file_name : null,
                            'option_name'   =>  $variation['name'],
                            'price'         =>  $variation['price'],
                            'stock'         =>  $variation['stock'],
                        ]);
                    }
                    /* Create new */
                    else{
                        $variation_file_name   =   '';
                        if($variation['images']['file']){
                            $variation_file_name  =   $variation['images']['file']->getClientOriginalName();
                            Storage::putFileAs('products', $variation['images']['file'], $variation_file_name);
                        }
                        
                        $product_variation_id     =   DB::table('product_variations')->insertGetId([
                            'product_id'    =>  $request->basic_info['product_id'],
                            'image'         =>  $variation_file_name != '' ? '/products/'.$variation_file_name : '',
                            'option_name'   =>  $variation['name'],
                            'price'         =>  !$request->detailed_info['has_sub_variation'] ? $variation['price'] : null,
                            'stock'         =>  !$request->detailed_info['has_sub_variation'] ? $variation['stock'] : null,
                        ]);
                    }

                }

                /* Check if sub variation enabled */
                if($request->detailed_info['has_sub_variation']){
                    if($variation['name']){
                        foreach($variation['sub_variations']['options'] as $sub_variation){
                            if($sub_variation['id']){
                                DB::table('product_sub_variations')->where('id', $sub_variation['id'])->update([
                                    'option_name'               =>  $sub_variation['name'],
                                    'price'                     =>  $sub_variation['price'],
                                    'stock'                     =>  $sub_variation['stock']
                                ]);
                            }
                            else{
                                DB::table('product_sub_variations')->insert([
                                    'product_variation_id'      =>  $product_variation_id,
                                    'option_name'               =>  $sub_variation['name'],
                                    'price'                     =>  $sub_variation['price'],
                                    'stock'                     =>  $sub_variation['stock']
                                ]);
                            }
                        }
                    }
                }
            }
        }
                
        $log_data =   'Updated product ID '.$request->basic_info['product_id'];
        event(new DatabaseTransactionEvent($log_data));

        return redirect(route('products'))->with(['type'=>'success', 'message'=>'Data has been updated.']);
    } 

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            DB::table('products')->where('products.id', $id)->delete();
            DB::commit();
                
            $log_data =   'Deleted product ID '.$id;
            event(new DatabaseTransactionEvent($log_data));

            return redirect(route('products'))->with(['type'=>'success', 'message'=>'Data has been deleted.']); 
        } catch (Exception $e) {
            // Something went wrong, rollback the transaction
            DB::rollBack();
        
            return back()->with(['type'=>'error', 'message'=>'Failed to delete. The product is being used.']);
        }
    }

    public function deleteVariation($id){
        try {
            DB::beginTransaction();

            DB::table('product_variations')->where('id', $id)->delete();
        
            DB::commit();
                
            $log_data =   'Deleted variation for product ID '.$id;
            event(new DatabaseTransactionEvent($log_data));
        
            return back()->with(['type'=>'success', 'message'=>'Variation has been deleted!']);
        } catch (Exception $e) {
            // Something went wrong, rollback the transaction
            DB::rollBack();
        
            return back()->with(['type'=>'error', 'message'=>'Failed to delete. The variation or sub variation is being used.']);
        }
    }

    public function deleteSubVariation(Request $request){
        try {
            DB::beginTransaction();
            
            DB::table('product_sub_variations')->whereIn('id', $request->to_delete)->delete();
        
            DB::commit();
                
            $log_data =   'Deleted sub variation ID '.json_encode($request->to_delete);
            event(new DatabaseTransactionEvent($log_data));
        
            return back()->with(['type'=>'success', 'message'=>'Sub variation has been deleted!']);
        } catch (Exception $e) {
            DB::rollBack();
        
            return back()->with(['type'=>'error', 'message'=>'Failed to delete. The sub variation is being used.']);
        }
    }

    public function replaceImage($image_file, $image_name){
        if($image_name){
            Storage::delete($image_name);
        }
        $file_original_name   =   $image_file->getClientOriginalName();
        Storage::putFileAs('products', $image_file, $file_original_name);
        $new_image_name    =   '/products/'.$file_original_name;

        return $new_image_name;
    }
}

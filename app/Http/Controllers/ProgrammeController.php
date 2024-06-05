<?php

namespace App\Http\Controllers;

use App\Classes\ProgrammeHelper;
use App\Events\DatabaseTransactionEvent;
use App\Http\Controllers\Approval\ProgrammeApprovalController;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ProgrammeController extends Controller
{
    public $update_programme_config = 3;
    public $delete_programme_config = 4;

    public function programmeList(){
        $query      =   DB::table('programmes')
                            ->leftJoin('countries', 'programmes.country_id', '=', 'countries.id')
                            ->select('programmes.id', 'programmes.name as programme_name', 'countries.name as country', 'programmes.status');

        if(request('search')){
            $query->where('programmes.name', 'LIKE', '%'.request('search').'%');
        }

        $programmes    =   $query->paginate(10);
        
        return Inertia::render('CentreManagement/Programmes/Index', [
            'filter'            => request()->all('search'),
            'programme_list'    => $programmes,
        ]);
    }

    public function addProgramme(){
        $countries          =   DB::table('countries')->get();
        $class_types        =   DB::table('class_types')->get()->keyBy('id');
        $class_types_detail =   DB::table('class_types_detail')->get();

        return Inertia::render('CentreManagement/Programmes/Create',[
            'class_types'           =>  $class_types,
            'class_types_detail'    =>  $class_types_detail,
            'countries'             =>  $countries,
        ]);
    }

    public function storeProgramme(Request $request){
        $request->validate([
            'programme_name'        => 'required|max:255',
            'programme_country'     => 'required',
        ]);

        if(empty($request->programme_info)){
            return back()->with(['type'=>'error', 'message'=>'Please add at least 1 level !']);
        }
        $programme_id    =   DB::table('programmes')->insertGetId([
            'name'          =>  $request->programme_name,
            'country_id'    =>  $request->programme_country,
            'status'        =>  $request->programme_active,
        ]);

        foreach($request->programme_info as $key=>$info){
            $programme_level_id =   DB::table('programme_levels')->insertGetId([
                'programme_id'                      =>  $programme_id,
                'class_type_id'                     =>  $info['class_type'],
                'level'                             =>  $info['level'],
                'registration_fee'                  =>  $info['registration_fee'],
                'material_fee'                      =>  $info['material_fee'],
                'material_product_id'               =>  !empty($info['product']) ? $info['product']['id'] : null,
                'material_product_variation_id'     =>  !empty($info['product_variation']) ? $info['product_variation']['id'] : null,
                'material_product_sub_variation_id' =>  !empty($info['product_sub_variation']) ? $info['product_sub_variation']['id'] : null,
            ]);
            foreach($info['fees'] as $fee_key=>$fee){
                DB::table('programme_level_fees')->insert([
                    'programme_level_id'    =>  $programme_level_id,
                    'class_type_detail_id'  =>  $fee['class_type_detail_id'],
                    'fee_amount'            =>  $fee['value'],
                ]);
            }
        }
        $log_data =   'Created programme ' . $request->programme_name  . ' : ' . json_encode($request->all());
        event(new DatabaseTransactionEvent($log_data));

        return redirect(route('programmes'))->with(['type'=>'success', 'message'=>'New programme added successfully!']);
    }

    public function editProgramme(Request $request){

        $countries          =   DB::table('countries')->get();
        $class_types        =   DB::table('class_types')->get()->keyBy('id');
        $class_type_details =   DB::table('class_types_detail')->get();

        $programme_data         =   DB::table('programmes')->where('id', $request->programme_id)->first();
        $programme_info         =   DB::table('programme_levels')
                                        ->leftJoin('products', 'programme_levels.material_product_id', '=', 'products.id')
                                        ->leftJoin('product_variations', 'programme_levels.material_product_variation_id', '=', 'product_variations.id')
                                        ->leftJoin('product_sub_variations', 'programme_levels.material_product_sub_variation_id', '=', 'product_sub_variations.id')
                                        ->where('programme_levels.programme_id', $request->programme_id)
                                        ->select('programme_levels.id as programme_level_id', 'programme_levels.level', 'programme_levels.class_type_id as class_type', 
                                                'programme_levels.material_fee', 'programme_levels.registration_fee', 'products.id as product_id', 'products.name as product_name', 
                                                'products.has_variation as has_variation', 'products.has_sub_variation as has_sub_variation', 
                                                'product_variations.id as product_variation_id', 'product_variations.option_name as product_variation_name', 
                                                'product_sub_variations.id as product_sub_variation_id', 'product_sub_variations.option_name as product_sub_variation_name')
                                        ->orderBy('programme_levels.level')
                                        ->orderBy('programme_levels.class_type_id')
                                        ->get();
                                        
        $programme_level_fees   =   DB::table('programme_level_fees')
                                        ->whereIn('programme_level_id', $programme_info->pluck('programme_level_id'))
                                        ->select('id', 'programme_level_id', 'class_type_detail_id', 'fee_amount')
                                        ->get();
                                        
        foreach($programme_info as $programme_level){
            foreach($programme_level_fees as $programme_level_fee){
                if($programme_level_fee->programme_level_id == $programme_level->programme_level_id){
                    $info['fee_id']                 =   $programme_level_fee->id;
                    $info['class_type_detail_id']   =   $programme_level_fee->class_type_detail_id;
                    $info['value']                  =   $programme_level_fee->fee_amount;
                    $programme_level->fees[]        =   $info;
                }
            }
            $programme_level->product['id']                         =   $programme_level->product_id;
            $programme_level->product['name']                       =   $programme_level->product_name;
            $programme_level->product['has_variation']              =   $programme_level->has_variation;
            $programme_level->product['has_sub_variation']          =   $programme_level->has_sub_variation;
            $programme_level->product_variation['id']               =   $programme_level->product_variation_id;
            $programme_level->product_variation['option_name']      =   $programme_level->product_variation_name;
            $programme_level->product_sub_variation['id']           =   $programme_level->product_sub_variation_id;
            $programme_level->product_sub_variation['option_name']  =   $programme_level->product_sub_variation_name;
        }
                                    
        return Inertia::render('CentreManagement/Programmes/Edit', [
            'programme_data'        => $programme_data,
            'programme_info'        => $programme_info,
            'class_types'           => $class_types,
            'class_types_detail'    => $class_type_details,
            'countries'             => $countries,
        ]);
    }

    public function updateProgramme(Request $request){
        $request->validate([
            'programme_name'        => 'required|max:255',
            'programme_country'     => 'required',
        ]);

        if(empty($request->programme_info)){
            return back()->with(['type'=>'error', 'message'=>'Please add at least 1 level !']);
        }

        // if(auth()->user()->is_admin == false){
        //     $approval_data      =   $request->all();
        //     $pending_approval   =   ProgrammeHelper::checkProgrammePreviousApprovals($request->programme_id, $this->update_programme_config);

        //     if($pending_approval){
        //         return redirect(route('programmes'))->with(['type' => 'error', 'message' => 'This programme is on pending approval!']);
        //     }
            
        //     /* Approval Data */
        //     $class_types            =   DB::table('class_types')->get()->keyBy('id')->toArray();
        //     $class_type_details     =   DB::table('class_types_detail')->get()->toArray();

        //     $programme_name         =   DB::table('programmes')->where('id', $request->programme_id)->pluck('name')->first();
        //     $programme_levels       =   DB::table('programme_levels')
        //                                     ->where('programme_id', $request->programme_id)
        //                                     ->select(['id as programme_level_id', 'level', 'class_type_id', 'material_fee'])
        //                                     ->get();

        //     $programme_level_fees   =   DB::table('programme_level_fees')
        //                                     ->whereIn('programme_level_id', $programme_levels->pluck('programme_level_id'))
        //                                     ->select(['programme_level_id', 'class_type_detail_id', 'fee_amount'])
        //                                     ->get()->toArray();

        //     foreach($programme_levels as $programme_level){
        //         foreach($programme_level_fees as $programme_level_fee){
        //             if($programme_level_fee->programme_level_id == $programme_level->programme_level_id){
        //                 $programme_level->fees[$programme_level_fee->class_type_detail_id]  =   $programme_level_fee->fee_amount;
        //             }
        //         }
        //     }
            
        //     $approval_data['class_types']                   =   $class_types;
        //     $approval_data['class_type_details']            =   $class_type_details;
        //     $approval_data['current_programme_levels']      =   $programme_levels;
        //     $approval_data['programme_level_to_add']        =   $request->programme_level_to_add;
        //     $approval_data['programme_level_to_delete']     =   $programme_levels->whereIn('programme_level_id', $request->programme_level_to_delete);

        //     $approval   =   new ProgrammeApprovalController();
        //     $approval->sendProgrammeUpdateRequest($approval_data);

        //     return redirect(route('programmes'))->with(['type' => 'success', 'message' => 'Your request has been sent for approval!']);
        // }

        DB::table('programmes')->where('id', $request->programme_id)->update([
            'name'          =>  $request->programme_name,
            'country_id'    =>  $request->programme_country,
            'status'        =>  $request->programme_active,
            'updated_at'    =>  Carbon::now(),
        ]);
        $log_data =   'Updated programme ' . $request->programme_name  . ' : ' . json_encode([
            'name'          =>  $request->programme_name,
            'country_id'    =>  $request->programme_country,
            'status'        =>  $request->programme_active,
            'updated_at'    =>  Carbon::now(),
        ]);
        event(new DatabaseTransactionEvent($log_data));

        foreach($request->programme_info as $key=>$info){
            if(!isset($info['programme_level_id'])){
                $programme_level_id =   DB::table('programme_levels')->insertGetId([
                    'programme_id'                      =>  $request->programme_id,
                    'class_type_id'                     =>  $info['class_type'],
                    'level'                             =>  $info['level'],
                    'registration_fee'                  =>  $info['registration_fee'],
                    'material_fee'                      =>  $info['material_fee'],
                    'material_product_id'               =>  !empty($info['product']) ? $info['product']['id'] : null,
                    'material_product_variation_id'     =>  !empty($info['product_variation']) ? $info['product_variation']['id'] : null,
                    'material_product_sub_variation_id' =>  !empty($info['product_sub_variation']) ? $info['product_sub_variation']['id'] : null,
                ]);
                foreach($info['fees'] as $fee_key=>$fee){
                    DB::table('programme_level_fees')->insert([
                        'programme_level_id'    =>  $programme_level_id,
                        'class_type_detail_id'  =>  $fee['class_type_detail_id'],
                        'fee_amount'            =>  $fee['value'],
                    ]);
                }
                $log_data =   "Added programme " . $request->programme_name  . "'s fee " . ' : ' . json_encode($info);
                event(new DatabaseTransactionEvent($log_data));
            }
        }

        

        return redirect(route('programmes'))->with(['type'=>'success', 'message'=>'Programme updated successfully !']);
    }

    public function destroyProgramme($id){
        
        $programme_name =   DB::table('programmes')->where('id', $id)->pluck('name')->first();
        /* Check if programme can be deleted */
        $programme_is_deletable   =   ProgrammeHelper::checkProgrammeIsDeletable($id);
        if(!$programme_is_deletable){
            return redirect(route('programmes'))->with(['type' => 'error', 'message' => 'There are students in this programme!']);
        }

        /* Check if user is admin */
        // if(auth()->user()->is_admin == false){

        //     /* Check if delete request on this programme is still pending */
        //     $pending_approval   =   ProgrammeHelper::checkProgrammePreviousApprovals($id, $this->delete_programme_config);
        //     if($pending_approval){
        //         return redirect(route('programmes'))->with(['type' => 'error', 'message' => 'This programme is on pending approval!']);
        //     }

        //     /* Send programme delete request */
        //     $approval   =   new ProgrammeApprovalController();
        //     $approval->sendProgrammeDeleteRequest($id);

        //     return redirect(route('centres'))->with(['type' => 'success', 'message' => 'Your request has been sent for approval!']);
        // }

        /* proceed with programme delete */
        DB::table('programmes')
            ->join('programme_levels','programme_levels.programme_id','=','programmes.id')
            ->join('programme_level_fees','programme_level_fees.programme_level_id','=','programme_levels.id')
            ->where('programmes.id', $id)->delete();

        $log_data =   'Deleted programme ' . $programme_name;
        event(new DatabaseTransactionEvent($log_data));

        return redirect(route('programmes'))->with(['type'=>'success', 'message'=>'Programme deleted successfully !']);
    }

    public function destroyFee($id){
        try {
            $programme_level_info   =   DB::table('programme_levels')->where('id', $id)->first();
            $programme_info         =   DB::table('programmes')->where('id', $programme_level_info->programme_id)->first();
            $fee_count              =   DB::table('programme_levels')->where('programme_levels.programme_id', $programme_level_info->programme_id)->count();
            
            if($fee_count < 2){
                return back()->with(['type'=>'error', 'message'=>'Please add new fee before deleting the last one.']);
            }
            
            DB::table('programme_levels')
                ->join('programme_level_fees','programme_level_fees.programme_level_id','=','programme_levels.id')
                ->where('programme_levels.id', $id)->delete();

            $log_data =   'Deleted fee for programme ' . $programme_info->name . ' : ' . json_encode($programme_level_info);
            event(new DatabaseTransactionEvent($log_data));

            return back()->with(['type'=>'success', 'message'=>'Fee deleted successfully !']);
        } catch (\Throwable $th) {
            return back()->with(['type'=>'error', 'message'=>'Deletion failed. The fee might be in used. Please try again.']);
        }

    }

    public function getFee(Request $request){
        $fee_info_query  =   DB::table('classes')
                                ->join('centres', 'classes.centre_id', '=', 'centres.id')
                                ->join('countries', 'centres.country_id', '=', 'countries.id')
                                ->join('class_methods', 'classes.class_method_id', '=', 'class_methods.id')
                                ->join('programme_levels', 'classes.programme_level_id', '=', 'programme_levels.id')
                                ->join('class_types', 'programme_levels.class_type_id', '=', 'class_types.id')
                                ->join('programmes', 'programme_levels.programme_id', '=', 'programmes.id')
                                ->join('programme_level_fees', 'programme_level_fees.programme_level_id', '=', 'programme_levels.id')
                                ->join('class_types_detail', 'programme_level_fees.class_type_detail_id', '=', 'class_types_detail.id')
                                ->select(   'programmes.id as programme_id', 'programmes.name as programme_name', 'programme_levels.level as programme_level', 
                                            'programme_levels.material_fee', 'programme_levels.registration_fee', 'programme_level_fees.id as fee_id', 'programme_level_fees.fee_amount as programme_fee', 
                                            'class_types_detail.label as programme_type', 'centres.id as centre_id', 'centres.label as centre_name', 
                                            'class_types.id as class_type_id', 'class_methods.name as class_method', 'countries.currency_symbol')
                                ->where('programme_level_fees.fee_amount', '>', 0);
                        
        if($request->class_id){
            $fee_info_query->where('classes.id', $request->class_id);
        }
        else{
            $fee_info_query->where('classes.id', $request->classes)->where('programme_levels.class_type_id', $request->class_type)->where('class_types_detail.class_count', $request->class_count);
        }

        $data['fee_info']                               =   $fee_info_query->first();
        $data['fee_info']->include_material_fee         =   true;
        $data['fee_info']->include_registration_fee     =   true;
        $data['fee_info']->registration_fee_discount    =   0;
        $data['fee_info']->material_fee_discount        =   0;
        $data['fee_info']->programme_fee_discount       =   0;
        $data['fee_info']->promos                       =   [];

        $classes_query  =   DB::table('classes')
                                ->join('class_days', 'classes.class_day_id', '=', 'class_days.id')
                                ->select('classes.id as class_id', 'class_days.name as class_day', 'classes.start_time', 'classes.end_time');

        if($request->class_id){
            $classes_query->where('classes.id', $request->class_id);
        }
        else{
            $classes_query->orWhereIn('classes.id', $request->classes);
        }
        
        $data['classes']    =   $classes_query->get();

        if(!empty($fee_info_query)){
            $product_result     =   DB::table('programme_levels')
                                        ->join('programme_level_fees', 'programme_level_fees.programme_level_id', '=', 'programme_levels.id')
                                        ->leftJoin('products', 'programme_levels.material_product_id', '=', 'products.id')
                                        ->leftJoin('product_variations', 'programme_levels.material_product_variation_id', '=', 'product_variations.id')
                                        ->leftJoin('product_sub_variations', 'programme_levels.material_product_sub_variation_id', '=', 'product_sub_variations.id')
                                        ->select('products.id as product_id', 'products.name as product_name', 'products.name as product_name', 'products.has_variation as has_variation', 
                                                'products.has_sub_variation as has_sub_variation', 'product_variations.id as product_variation_id', 
                                                'product_variations.option_name as product_variation_name', 'product_sub_variations.id as product_sub_variation_id', 
                                                'product_sub_variations.option_name as product_sub_variation_name')
                                        ->where('programme_level_fees.id', $fee_info_query->pluck('fee_id'))
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
    
            $data['material']    =   $material;
        }       
        
        return json_encode($data, JSON_NUMERIC_CHECK);
    }

    public function updateFee(Request $request){
        foreach($request->fee_edit_form['data'] as $key=>$data){
            DB::table('programme_level_fees')->where('id', $data['fee_id'])->update([
                'fee_amount' => $data['value']
            ]);
        }

        return back()->with(['type'=>'success', 'message'=>'Fee amount updated!']);
    }
}

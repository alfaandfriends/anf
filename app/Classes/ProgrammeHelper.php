<?php

namespace App\Classes;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProgrammeHelper {

    public static function programmes(){
        $programmes =   DB::table('programmes')->join('countries', 'programmes.country_id', '=', 'countries.id')->select('programmes.id', 'programmes.name', 'countries.name as country_name')->get();

        return $programmes;
    }

    public function getProgrammeName($programme_id)
    {
        $programme_name     =   DB::table('programmes')->where('id', $programme_id)->pluck('name')->first();

        return $programme_name;
    }

    public static function distinctLevels(){
        $programme_name     =   DB::table('programme_levels')->distinct()->select('level')->get();

        return $programme_name;
    }

    public static function checkProgrammePreviousApprovals($programme_id, $notification_config_id)
    {
        $previous_programme_approval  =   DB::table('notifications')
                                                ->join('notification_config_data','notifications.notification_config_data_id','=','notification_config_data.id')
                                                ->where('notification_config_data.notification_config_id', $notification_config_id)
                                                ->where('notifications.pending', true)->get();

        if(count($previous_programme_approval) > 0){
            foreach($previous_programme_approval as $approval){
                $data   =   unserialize($approval->data);
                $pending_approval[$data['programme_id']] =   true;
            }
            $is_pending_approval    =   array_key_exists($programme_id, $pending_approval) && $approval->pending? true : false;
            return $is_pending_approval;
        }
        return false;
    }

    public static function checkProgrammeIsDeletable($programme_id){
        $students_in_programme_count  =   DB::table('programmes')
                                            ->join('programme_levels','programme_levels.programme_id','=','programmes.id')
                                            ->join('programme_level_fees','programme_level_fees.programme_level_id','=','programme_levels.id')
                                            ->join('student_fees','student_fees.fee_id','=','programme_level_fees.id')
                                            ->where('programmes.id', $programme_id)->count();
                                            
        if($students_in_programme_count > 0){
            return false;
        }

        return true;
    }

    public static function getProgrammeLevels($programme_id){
        $programme_levels  =   DB::table('programme_levels')->where('programme_id', $programme_id)->select('level')->distinct()->get();

        return $programme_levels;
    }

    public static function getFee(Request $request){
        $fee_info_query  =   DB::table('classes')
                                ->join('centres', 'classes.centre_id', '=', 'centres.id')
                                ->join('class_methods', 'classes.class_method_id', '=', 'class_methods.id')
                                ->join('programme_levels', 'classes.programme_level_id', '=', 'programme_levels.id')
                                ->join('class_types', 'programme_levels.class_type_id', '=', 'class_types.id')
                                ->join('programmes', 'programme_levels.programme_id', '=', 'programmes.id')
                                ->join('programme_level_fees', 'programme_level_fees.programme_level_id', '=', 'programme_levels.id')
                                ->join('class_types_detail', 'programme_level_fees.class_type_detail_id', '=', 'class_types_detail.id')
                                ->select(   'programmes.id as programme_id', 'programmes.name as programme_name', 'programme_levels.level as programme_level', 
                                            'programme_levels.material_fee', 'programme_level_fees.id as fee_id', 'programme_level_fees.fee_amount as programme_fee', 
                                            'class_types_detail.label as programme_type', 'centres.id as centre_id', 'centres.label as centre_name', 
                                            'class_types.id as class_type_id', 'class_methods.name as class_method');
                        
        if($request->class_id){
            $fee_info_query->where('classes.id', $request->class_id);
        }
        else{
            $fee_info_query->where('classes.id', $request->classes)->where('programme_levels.class_type_id', $request->class_type)->where('class_types_detail.class_count', $request->class_count);
        }

        $data['fee_info']   =   $fee_info_query->first();
        dd($data['fee_info']);

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
                  
        
                        

        return $data;
    }
}
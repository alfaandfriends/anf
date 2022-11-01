<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

use function GuzzleHttp\Promise\all;

class SettingController extends Controller
{
    /* Class Type */
        public function classTypeList(){
            $class_types  =   DB::table('class_types')->paginate(10);

            return Inertia::render('Settings/CentreManagement/Index',[
                'class_types' => $class_types,
            ]);
        }

        public function addClassType(){
            return Inertia::render('Settings/CentreManagement/ClassTypes/Create');
        }

        public function storeClassType(Request $request){
            $request->validate([
                'class_type'  => 'required'
            ]);

            DB::table('class_types')->insert([
                'name' =>  $request->class_type
            ]);

            return redirect(route('settings.class_types'))->with(['type'=>'success', 'message'=>'Class type added successfully !']);
        }

        public function editClassType(Request $request){
            $class_type_info  =   DB::table('class_types')->where('id', $request->class_type_id)->first();
            
            return Inertia::render('Settings/CentreManagement/ClassTypes/Edit', [
                'class_type_info' =>  $class_type_info
            ]);
        }

        public function updateClassType(Request $request){
            $request->validate([
                'class_type'  => 'required'
            ]);

            DB::table('class_types')->where('id', $request->class_type_id)->update([
                'name' =>  $request->class_type,
                'updated_at'        => Carbon::now(),
            ]);

            return redirect(route('settings.class_types'))->with(['type'=>'success', 'message'=>'Class type updated successfully !']);
        }

        public function destroyClassType($id){   
            DB::table('class_types')->where('id', $id)->delete();

            return back()->with(['type'=>'success', 'message'=>'Class type deleted successfully ! ']);
        }

    /* Programmes */
        public function programmeList(){
            $query      =   DB::table('programmes');

            if(request('search')){
                $query->where('name', 'LIKE', '%'.request('search').'%');
            }

            $programmes    =   $query->paginate(10);
            
            return Inertia::render('Settings/CentreManagement/Index', [
                'filter'            => request()->all('search'),
                'programme_list'    => $programmes,
            ]);
        }

        public function addProgramme(){
            $class_types        =   DB::table('class_types')->get()->keyBy('id');
            $class_types_detail =   DB::table('class_types_detail')->get();

            return Inertia::render('Settings/CentreManagement/Programmes/Create',[
                'class_types'           =>  $class_types,
                'class_types_detail'    =>  $class_types_detail,
            ]);
        }

        public function storeProgramme(Request $request){
            $request->validate([
                'programme_name'               => 'required|max:255',
            ]);

            if(empty($request->programme_info)){
                return back()->with(['type'=>'error', 'message'=>'Please add at least 1 level !']);
            }

            $programme_id    =   DB::table('programmes')->insertGetId([
                'name'              =>  $request->programme_name,
                'status'            =>  $request->programme_active,
            ]);

            foreach($request->programme_info as $key=>$info){
                $programme_level_id =   DB::table('programme_levels')->insertGetId([
                    'programme_id'      =>  $programme_id,
                    'class_type_id'     =>  $info['class_type'],
                    'level'             =>  $info['level'],
                    'material_fee'      =>  $info['material_fee'],
                ]);
                foreach($info['fee'] as $class_type_detail_id=>$fee){
                    if($fee != null || $fee != 0){
                        DB::table('programme_level_fees')->insert([
                            'programme_level_id'    =>  $programme_level_id,
                            'class_type_detail_id'  =>  $class_type_detail_id,
                            'fee_amount'            =>  $fee,
                        ]);
                        
                    }
                }
            }

            return redirect(route('settings.programmes'))->with(['type'=>'success', 'message'=>'Programme added successfully !']);
        }

        public function editProgramme(Request $request){

            $programme_name     =   DB::table('programmes')->where('id', $request->programme_id)->pluck('name')->first();
            $programme_fees     =   DB::table('programme_levels')
                                            ->join('programme_level_fees', 'programme_level_fees.programme_level_id', '=', 'programme_levels.id')
                                            ->where('programme_levels.programme_id', $request->programme_id)
                                            ->select([
                                                'programme_levels.level', 
                                                'programme_levels.material_fee', 
                                                'programme_levels.class_type_id', 
                                                'programme_level_fees.programme_level_id', 
                                                'programme_level_fees.class_type_detail_id', 
                                                'programme_level_fees.fee_amount'])->get();

            $programme_info     =   array();  
            $class_types        =   array();  
            foreach($programme_fees as $fee_info){
                if(!in_array($fee_info->class_type_id, $class_types)){
                    $class_types[]   =   $fee_info->class_type_id;
                }
            }

            foreach($class_types as $class_type){
                $data['level']              =   $programme_fees->where('class_type_id', $class_type)->pluck('level')->first();
                $data['material_fee']       =   $programme_fees->where('class_type_id', $class_type)->pluck('material_fee')->first();
                $data['class_type']         =   $programme_fees->where('class_type_id', $class_type)->pluck('class_type_id')->first();
                $data['fee']                =   $programme_fees->where('class_type_id', $class_type)->pluck('fee_amount', 'class_type_detail_id')->all();
                $programme_info[]           =   $data;
            }
            
            $class_types        =   DB::table('class_types')->get()->keyBy('id');
            $class_types_detail =   DB::table('class_types_detail')->get();
                                        
            return Inertia::render('Settings/CentreManagement/Programmes/Edit', [
                'programme_id'          => $request->programme_id,
                'programme_name'        => $programme_name,
                'programme_info'        => $programme_info,
                'class_types'           => $class_types,
                'class_types_detail'    => $class_types_detail,
            ]);
        }

        public function updateProgramme(Request $request){
            $request->validate([
                'programme_name'               => 'required|max:255',
            ]);

            if(empty($request->programme_info)){
                return back()->with(['type'=>'error', 'message'=>'Please add at least 1 level !']);
            }

            DB::table('programmes')->where('id', $request->programme_id)->update([
                'name'              =>  $request->programme_name,
                'status'            =>  $request->programme_active,
                'updated_at'        =>  Carbon::now(),
            ]);

            DB::table('programme_levels')->where('programme_id', $request->programme_id)->delete();
            foreach($request->programme_info as $key=>$info){
                $programme_level_id =   DB::table('programme_levels')->insertGetId([
                    'programme_id'      =>  $request->programme_id,
                    'class_type_id'     =>  $info['class_type'],
                    'level'             =>  $info['level'],
                    'material_fee'      =>  $info['material_fee'],
                ]);
                foreach($info['fee'] as $class_type_detail_id=>$fee){
                    if($fee != null || $fee != 0){
                        DB::table('programme_level_fees')->insert([
                            'programme_level_id'    =>  $programme_level_id,
                            'class_type_detail_id'  =>  $class_type_detail_id,
                            'fee_amount'            =>  $fee,
                        ]);
                        
                    }
                }
            }

            return redirect(route('settings.programmes'))->with(['type'=>'success', 'message'=>'Programme updated successfully !']);
        }

        public function destroyProgramme($id){
            DB::table('programmes')->where('id', $id)->delete();
            DB::table('programme_levels')->where('programme_id', $id)->delete();

            return redirect(route('settings.programmes'))->with(['type'=>'success', 'message'=>'Programme deleted successfully !']);
        }

        public function getFee(Request $request){
            $query  =   DB::table('classes')
                            ->join('programme_levels', 'classes.programme_level_id', '=', 'programme_levels.id')
                            ->join('programme_level_fees', 'programme_level_fees.programme_level_id', '=', 'programme_levels.id')
                            ->join('class_types_detail', 'programme_level_fees.class_type_detail_id', '=', 'class_types_detail.id');
                            
            if($request->class_id){
                $query->where('classes.id', $request->class_id);
            }
            else{
                $query->where('programme_levels.class_type_id', $request->class_type)->where('class_types_detail.class_count', $request->class_count);
            }

            $result =   $query->select(['programme_level_fees.id', 'class_types_detail.label', 'programme_level_fees.fee_amount'])->first();

            return $result;
        }

    /* Countries */
        public function countryList(){
            $country_list  =   DB::table('countries')->paginate(10);

            return Inertia::render('Settings/General/Countries/Index',[
                'country_list' => $country_list,
            ]);
        }

        public function addCountry(){
            return Inertia::render('Settings/General/Countries/Create');
        }

        public function storeCountry(Request $request){
            $request->validate([
                'fee_period'  => 'required'
            ]);

            DB::table('fee_periods')->insert([
                'label' =>  $request->fee_period
            ]);

            return redirect(route('settings.fee_period_list'))->with(['type'=>'success', 'message'=>'Fee Period added successfully !']);
        }

        public function editCountry(Request $request){
            $fee_period_info  =   DB::table('fee_periods')->where('id', $request->fee_period_id)->first();
            
            return Inertia::render('Settings/General/Countries/Edit', [
                'fee_period_info' =>  $fee_period_info
            ]);
        }

        public function updateCountry(Request $request){
            $request->validate([
                'fee_period'  => 'required',
                'updated_at'  => Carbon::now(),
            ]);

            DB::table('fee_periods')->where('id', $request->fee_period_id)->update([
                'label' =>  $request->fee_period
            ]);

            return redirect(route('settings.fee_period_list'))->with(['type'=>'success', 'message'=>'Fee period updated successfully !']);
        }

        public function destroyCountry($id){
            DB::table('fee_periods')->where('id', $id)->delete();

            return back()->with(['type'=>'success', 'message'=>'Fee period deleted successfully ! ']);
        }
    
    /* Diagnostic Test */
        /* Diagnostic Test List */
            public function dtList(){
                $diagnostic_test_list           =   DB::table('diagnostic_test')->paginate(10);

                return Inertia::render('Settings/General/DiagnosticTest/Index', [
                    'diagnostic_test_list' => $diagnostic_test_list,
                ]);
            }

            public function dtCreate(){
                return Inertia::render('Settings/General/DiagnosticTest/Create');
            }

            public function dtStore(Request $request){
                $request->validate([
                    'title'          => 'required',
                ]);
                
                DB::table('diagnostic_test')->insert([
                    'name'  =>  $request->title,
                ]);

                return redirect(route('settings.diagnostic_test'))->with(['type' => 'success', 'message' => 'New diagnostic test added successfully !']);
            }

            public function dtEdit(Request $request){
                $diagnostic_test_info           =   DB::table('diagnostic_test')->where('id', $request->dt_id)->first();
                
                return Inertia::render('Settings/General/DiagnosticTest/Edit', [
                    'diagnostic_test_info' => $diagnostic_test_info,
                ]);
            }

            public function dtUpdate(Request $request){
                $request->validate([
                    'title'          => 'required',
                ]);

                DB::table('diagnostic_test')->where('id', $request->dt_id)->update([
                    'name'          =>  $request->title,
                    'updated_at'    => Carbon::now(),
                ]);
                
                return redirect(route('settings.diagnostic_test'))->with(['type' => 'success', 'message' => 'Diagnostic test updated successfully !']);
            }

            public function dtDestroy($id){
                DB::table('diagnostic_test')->where('id', $id)->delete();
                DB::table('diagnostic_test_categories')->where('dt_id', $id)->delete();
                DB::table('diagnostic_test_conditions')->where('dt_id', $id)->delete();

                $diagnostic_test_info    =   DB::table('diagnostic_test_details')->where('dt_id', $id)->get();
                if(!empty($diagnostic_test_info)){
                    foreach($diagnostic_test_info as $key=>$info){
                        if($info->image_location != ''){
                            if(Storage::exists($info->image_location)){
                                Storage::delete($info->image_location);
                            }
                        }
                    }
                }
                DB::table('diagnostic_test_details')->where('dt_id', $id)->delete();

                return redirect(route('settings.diagnostic_test'))->with(['type' => 'success', 'message' => 'Diagnostic deleted successfully !']);
            }

        /* Diagnostic Test Detail List */
            public function dtDetailsList(Request $request){
                if(!DB::table('diagnostic_test')->find($request->dt_id)){
                    return abort(404);
                }
                $diagnostic_test_list           =   DB::table('diagnostic_test_details')->where('dt_id', $request->dt_id)->orderBy('ordering', 'asc')->get();
                $diagnostic_test_conditions     =   DB::table('diagnostic_test_conditions')->where('dt_id', $request->dt_id)->orderBy('score_capped', 'asc')->get();
                $diagnostic_test_categories     =   DB::table('diagnostic_test_categories')->where('dt_id', $request->dt_id)->get();
                
                return Inertia::render('Settings/General/DiagnosticTest/Details/Index', [
                    'diagnostic_test_id' => $request->dt_id,
                    'diagnostic_test_list' => $diagnostic_test_list,
                    'diagnostic_test_conditions' => $diagnostic_test_conditions,
                    'diagnostic_test_categories' => $diagnostic_test_categories
                ]);
            }

            public function dtDetailsCreate(Request $request){
                $redirect_url                   =   url()->previous();
                $diagnostic_test_list           =   DB::table('diagnostic_test_details')->where('dt_id', $request->dt_id)->orderBy('ordering', 'asc')->get();
                $diagnostic_test_categories     =   DB::table('diagnostic_test_categories')->where('dt_id', $request->dt_id)->get();

                return Inertia::render('Settings/General/DiagnosticTest/Details/Create', [
                    'diagnostic_test_id' => $request->dt_id,
                    'diagnostic_test_list' => $diagnostic_test_list,
                    'diagnostic_test_categories' => $diagnostic_test_categories,
                    'redirect_url' => $redirect_url,
                ]);
            }

            public function dtDetailsStore(Request $request){
                $request->validate([
                    'name'          => 'required',
                    'category_id'          => 'required',
                ]);

                if(empty($request->file())){
                    return back()->with(['type' => 'error', 'message' => 'Please upload an image !']);
                }

                $last_inserted_row  =   DB::table('diagnostic_test_details')->latest('ordering')->first();

                $latest_id  =   DB::table('diagnostic_test_details')->insertGetId([
                    'dt_id' => $request->dt_id,
                    'name' => $request->name,
                    'remarks' => $request->remarks,
                    'category_id' => $request->category_id,
                    'redirect_yes_id' => $request->redirect_yes,
                    'redirect_no_id' => $request->redirect_no,
                    'ordering' => $last_inserted_row ? $last_inserted_row->ordering + 1 : 1,
                ]);

                $file_path = Storage::putFile('diagnostic_test_photo', $request->file('image_file')[0]);

                DB::table('diagnostic_test_details')->where('id', $latest_id)->update([
                    'image_location'    => $file_path,
                    'updated_at'        => Carbon::now(),
                ]);

                return redirect()->route('settings.diagnostic_test.details', ['dt_id'=>$request->dt_id])->with(['type' => 'success', 'message' => 'New Item added successfully !']);
            }

            public function dtDetailsEdit(Request $request){
                $test_id                        =   $request->test_id;
                $dt_id                          =   $request->dt_id;
                $diagnostic_test_list           =   DB::table('diagnostic_test_details')->where('dt_id', $request->dt_id)->orderBy('ordering', 'asc')->get();
                $diagnostic_test_info           =   DB::table('diagnostic_test_details')->where('id', $request->test_id)->first();
                $diagnostic_test_conditions     =   DB::table('diagnostic_test_conditions')->where('dt_id', $request->dt_id)->orderBy('score_capped', 'asc')->get();
                $diagnostic_test_categories     =   DB::table('diagnostic_test_categories')->where('dt_id', $request->dt_id)->get();
                
                return Inertia::render('Settings/General/DiagnosticTest/Details/Edit', [
                    'test_id' => $test_id,
                    'dt_id' => $dt_id,
                    'diagnostic_test_list' => $diagnostic_test_list,
                    'diagnostic_test_info' => $diagnostic_test_info,
                    'diagnostic_test_conditions' => $diagnostic_test_conditions,
                    'diagnostic_test_categories' => $diagnostic_test_categories,
                ]);
            }

            public function dtDetailsUpdate(Request $request){

                $request->validate([
                    'name'          => 'required',
                ]);
                
                $diagnostic_test_info    =   DB::table('diagnostic_test_details')->where('id', $request->id)->first();

                if(!$diagnostic_test_info->image_location && empty($request->file())){
                    return back()->with(['type' => 'error', 'message' => 'Please upload an image !']);
                }
                
                DB::table('diagnostic_test_details')->where('id', $request->id)->update([
                    'name' => $request->name,
                    'remarks' => $request->remarks,
                    'category_id' => $request->category_id,
                    'redirect_yes_id' => $request->redirect_yes,
                    'redirect_no_id' => $request->redirect_no,
                    'updated_at'        => Carbon::now(),
                ]);

                if(!empty($request->file('image_file'))){

                    if(Storage::exists($diagnostic_test_info->image_location)){
                        Storage::delete($diagnostic_test_info->image_location);
                    }

                    $file_path = Storage::putFile('diagnostic_test_photo', $request->file('image_file')[0]);

                    DB::table('diagnostic_test_details')->where('id', $request->id)->update([
                        'image_location'    => $file_path,
                        'updated_at'        => Carbon::now(),
                    ]);
                }

                return redirect()->route('settings.diagnostic_test.details', ['dt_id' => $request->dt_id])->with(['type' => 'success', 'message' => 'Item updated successfully !']);
            }

            public function dtDetailsDestroy($id){   
                $diagnostic_test_info    =   DB::table('diagnostic_test_details')->where('id', $id)->first();
                
                if($diagnostic_test_info->image_location != ''){
                    if(Storage::exists($diagnostic_test_info->image_location)){
                        Storage::delete($diagnostic_test_info->image_location);
                    }
                }

                DB::table('diagnostic_test_details')->where('id', $id)->delete();

                return redirect()->route('settings.diagnostic_test.details', ['dt_id'=>$diagnostic_test_info->dt_id])->with(['type' => 'success', 'message' => 'Item deleted successfully !']);
            }

            public function dtDetailsSort(Request $request){
                foreach($request->sorted_list as $key=>$list){
                    DB::table('diagnostic_test_details')->where('id', $list['id'])->update([
                        'ordering' => $key+1
                    ]);
                }

                return redirect()->back()->with(['type' => 'success', 'message' => 'Item sorted successfully !']);
            }

        /* Diagnostic Test Conditions */
            public function dtConditionsCreate(Request $request){
                return Inertia::render('Settings/General/DiagnosticTest/Conditions/Create', [
                    'diagnostic_test_id' => $request->dt_id
                ]);
            }

            public function dtConditionsStore(Request $request){
                $request->validate([
                    'score'          => 'required',
                    'message'        => 'required',
                ]);

                DB::table('diagnostic_test_conditions')->insert([
                    'dt_id' =>  $request->dt_id,
                    'score_capped' =>  $request->score,
                    'message' =>  $request->message,
                ]);

                return redirect()->route('settings.diagnostic_test.details', ['dt_id'=>$request->dt_id])->with(['type' => 'success', 'message' => 'Condition added successfully !']);
            }

            public function dtConditionsEdit(Request $request){
                $condition_info = DB::table('diagnostic_test_conditions')->where('id', $request->condition_id)->first();

                return Inertia::render('Settings/General/DiagnosticTest/Conditions/Edit', [
                    'condition_info' => $condition_info
                ]);
            }

            public function dtConditionsUpdate(Request $request){
                $request->validate([
                    'score'          => 'required',
                    'message'        => 'required',
                ]);

                DB::table('diagnostic_test_conditions')->where('id', $request->condition_id)->update([
                    'score_capped'  =>  $request->score,
                    'message'       =>  $request->message,
                    'updated_at'    =>  Carbon::now(),
                ]); 

                return redirect()->route('settings.diagnostic_test.details', ['dt_id'=>$request->dt_id])->with(['type' => 'success', 'message' => 'Condition updated successfully !']);
            }

            public function dtConditionsDestroy($id){
                $dtInfo = DB::table('diagnostic_test_conditions')->where('id', $id)->first();
                DB::table('diagnostic_test_conditions')->where('id', $id)->delete();

                return redirect()->route('settings.diagnostic_test.details', ['dt_id'=>$dtInfo->dt_id])->with(['type' => 'success', 'message' => 'Condition added successfully !']);
            }

        /* Diagnostic Test Categories */
            public function dtCategoriesCreate(Request $request){
                return Inertia::render('Settings/General/DiagnosticTest/Categories/Create', [
                    'diagnostic_test_id' => $request->dt_id
                ]);
            }

            public function dtCategoriesStore(Request $request){
                $request->validate([
                    'category_name'          => 'required',
                ]);

                DB::table('diagnostic_test_categories')->insert([
                    'dt_id' =>  $request->dt_id,
                    'name' =>  $request->category_name,
                ]);

                return redirect()->route('settings.diagnostic_test.details', ['dt_id'=>$request->dt_id])->with(['type' => 'success', 'message' => 'Categories added successfully !']);
            }

            public function dtCategoriesEdit(Request $request){
                $category_info = DB::table('diagnostic_test_categories')->where('id', $request->category_id)->first();
                
                return Inertia::render('Settings/General/DiagnosticTest/Categories/Edit', [
                    'category_info' => $category_info
                ]);
            }

            public function dtCategoriesUpdate(Request $request){
                $request->validate([
                    'category_name'          => 'required',
                ]);

                DB::table('diagnostic_test_categories')->where('id', $request->category_id)->update([
                    'name'          =>  $request->category_name,
                    'updated_at'    =>  Carbon::now(),
                ]); 

                return redirect()->route('settings.diagnostic_test.details', ['dt_id'=>$request->dt_id])->with(['type' => 'success', 'message' => 'Category updated successfully !']);
            }

            public function dtCategoriesDestroy($id){
                $dtInfo = DB::table('diagnostic_test_categories')->where('id', $id)->first();
                DB::table('diagnostic_test_categories')->where('id', $id)->delete();

                return redirect()->route('settings.diagnostic_test.details', ['dt_id'=>$dtInfo->dt_id])->with(['type' => 'success', 'message' => 'Category deleted successfully !']);
            }
}

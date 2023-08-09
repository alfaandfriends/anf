<?php

namespace App\Http\Controllers;

use App\Classes\ProgrammeHelper;
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
        $query      =   DB::table('programmes');

        if(request('search')){
            $query->where('name', 'LIKE', '%'.request('search').'%');
        }

        $programmes    =   $query->paginate(10);
        
        return Inertia::render('CentreManagement/Programmes/Index', [
            'filter'            => request()->all('search'),
            'programme_list'    => $programmes,
        ]);
    }

    public function addProgramme(){
        $class_types        =   DB::table('class_types')->get()->keyBy('id');
        $class_types_detail =   DB::table('class_types_detail')->get();

        return Inertia::render('CentreManagement/Programmes/Create',[
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
            foreach($info['fees'] as $class_type_detail_id=>$fee){
                if($fee != null || $fee != 0){
                    DB::table('programme_level_fees')->insert([
                        'programme_level_id'    =>  $programme_level_id,
                        'class_type_detail_id'  =>  $class_type_detail_id,
                        'fee_amount'            =>  $fee,
                    ]);
                    
                }
            }
        }

        return redirect(route('programmes'))->with(['type'=>'success', 'message'=>'Programme added successfully !']);
    }

    public function editProgramme(Request $request){

        $class_types        =   DB::table('class_types')->get()->keyBy('id');
        $class_type_details =   DB::table('class_types_detail')->get();

        $programme_name         =   DB::table('programmes')->where('id', $request->programme_id)->pluck('name')->first();
        $programme_levels       =   DB::table('programme_levels')
                                        ->where('programme_id', $request->programme_id)
                                        ->select(['id as programme_level_id', 'level', 'class_type_id', 'material_fee'])
                                        ->get();

        $programme_level_fees   =   DB::table('programme_level_fees')
                                        ->whereIn('programme_level_id', $programme_levels->pluck('programme_level_id'))
                                        ->select(['programme_level_id', 'class_type_detail_id', 'fee_amount'])
                                        ->get();

        foreach($programme_levels as $programme_level){
            foreach($programme_level_fees as $programme_level_fee){
                if($programme_level_fee->programme_level_id == $programme_level->programme_level_id){
                    $programme_level->fees[$programme_level_fee->class_type_detail_id]  =   $programme_level_fee->fee_amount;
                }
            }
        }
                                    
        return Inertia::render('CentreManagement/Programmes/Edit', [
            'programme_id'          => $request->programme_id,
            'programme_name'        => $programme_name,
            'programme_levels'      => $programme_levels,
            'class_types'           => $class_types,
            'class_types_detail'     => $class_type_details,
        ]);
    }

    public function updateProgramme(Request $request){
        $request->validate([
            'programme_name'               => 'required|max:255',
        ]);

        if(empty($request->programme_info)){
            return back()->with(['type'=>'error', 'message'=>'Please add at least 1 level !']);
        }

        if(empty($request->programme_level_to_add) && empty($request->programme_level_to_delete)){
            return redirect(route('programmes'))->with(['type' => 'success', 'message' => 'No changes has been made!']);
        }

        if(auth()->user()->is_admin == false){
            $approval_data      =   $request->all();
            $pending_approval   =   ProgrammeHelper::checkProgrammePreviousApprovals($request->programme_id, $this->update_programme_config);

            if($pending_approval){
                return redirect(route('programmes'))->with(['type' => 'error', 'message' => 'This programme is on pending approval!']);
            }
            
            /* Approval Data */
            $class_types            =   DB::table('class_types')->get()->keyBy('id')->toArray();
            $class_type_details     =   DB::table('class_types_detail')->get()->toArray();

            $programme_name         =   DB::table('programmes')->where('id', $request->programme_id)->pluck('name')->first();
            $programme_levels       =   DB::table('programme_levels')
                                            ->where('programme_id', $request->programme_id)
                                            ->select(['id as programme_level_id', 'level', 'class_type_id', 'material_fee'])
                                            ->get();

            $programme_level_fees   =   DB::table('programme_level_fees')
                                            ->whereIn('programme_level_id', $programme_levels->pluck('programme_level_id'))
                                            ->select(['programme_level_id', 'class_type_detail_id', 'fee_amount'])
                                            ->get()->toArray();

            foreach($programme_levels as $programme_level){
                foreach($programme_level_fees as $programme_level_fee){
                    if($programme_level_fee->programme_level_id == $programme_level->programme_level_id){
                        $programme_level->fees[$programme_level_fee->class_type_detail_id]  =   $programme_level_fee->fee_amount;
                    }
                }
            }
            
            $approval_data['class_types']                   =   $class_types;
            $approval_data['class_type_details']            =   $class_type_details;
            $approval_data['current_programme_levels']      =   $programme_levels;
            $approval_data['programme_level_to_add']        =   $request->programme_level_to_add;
            $approval_data['programme_level_to_delete']     =   $programme_levels->whereIn('programme_level_id', $request->programme_level_to_delete);

            $approval   =   new ProgrammeApprovalController();
            $approval->sendProgrammeUpdateRequest($approval_data);

            return redirect(route('programmes'))->with(['type' => 'success', 'message' => 'Your request has been sent for approval!']);
        }
        
        foreach($request->programme_level_to_delete as $key=>$programme_level_id){

            DB::beginTransaction();

            try{
                DB::table('programme_level_fees')->where('id', $programme_level_id)->delete();
                DB::table('programme_levels')->where('id', $programme_level_id)->delete();
                DB::commit();
            }
            catch (Exception $e) {
                DB::rollBack();
                return back()->with(['type'=>'error', 'message'=>"Error when changing level or fee, it's being used by class or student."]);
            }
        }

        foreach($request->programme_level_to_add as $key=>$info){
            $programme_level_id =   DB::table('programme_levels')->insertGetId([
                'programme_id'      =>  $request->programme_id,
                'class_type_id'     =>  $info['class_type'],
                'level'             =>  $info['level'],
                'material_fee'      =>  $info['material_fee'],
            ]);
            foreach($info['fees'] as $class_type_detail_id=>$fee){
                if($fee != null || $fee != 0){
                    DB::table('programme_level_fees')->insert([
                        'programme_level_id'    =>  $programme_level_id,
                        'class_type_detail_id'  =>  $class_type_detail_id,
                        'fee_amount'            =>  $fee,
                    ]);
                    
                }
            }
        }
    
        DB::table('programmes')->where('id', $request->programme_id)->update([
            'name'              =>  $request->programme_name,
            'status'            =>  $request->programme_active,
            'updated_at'        =>  Carbon::now(),
        ]);


        return redirect(route('programmes'))->with(['type'=>'success', 'message'=>'Programme updated successfully !']);
    }

    public function destroyProgramme($id){
        
        /* Check if programme can be deleted */
        $programme_is_deletable   =   ProgrammeHelper::checkProgrammeIsDeletable($id);
        if(!$programme_is_deletable){
            return redirect(route('programmes'))->with(['type' => 'error', 'message' => 'There are students in this programme!']);
        }

        /* Check if user is admin */
        if(auth()->user()->is_admin == false){

            /* Check if delete request on this programme is still pending */
            $pending_approval   =   ProgrammeHelper::checkProgrammePreviousApprovals($id, $this->delete_programme_config);
            if($pending_approval){
                return redirect(route('programmes'))->with(['type' => 'error', 'message' => 'This programme is on pending approval!']);
            }

            /* Send programme delete request */
            $approval   =   new ProgrammeApprovalController();
            $approval->sendProgrammeDeleteRequest($id);

            return redirect(route('centres'))->with(['type' => 'success', 'message' => 'Your request has been sent for approval!']);
        }

        /* proceed with programme delete */
        DB::table('programmes')
            ->join('programme_levels','programme_levels.programme_id','=','programmes.id')
            ->join('programme_level_fees','programme_level_fees.programme_level_id','=','programme_levels.id')
            ->where('programmes.id', $id)->delete();

        return redirect(route('programmes'))->with(['type'=>'success', 'message'=>'Programme deleted successfully !']);
    }

    public function getFee(Request $request){
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

        return $data;
    }
}

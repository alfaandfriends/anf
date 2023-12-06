<?php

namespace App\Http\Controllers;

use App\Classes\ClassHelper;
use App\Classes\GeneralHelper;
use App\Classes\ProgrammeHelper;
use App\Events\DatabaseTransactionEvent;
use App\Http\Controllers\Approval\ClassApprovalController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ClassController extends Controller
{
    public $update_class_config = 3;
    public $delete_class_config = 4;

    public function index(Request $request)
    {
        $allowed_centres    =   Inertia::getShared('allowed_centres');
        if($allowed_centres->isEmpty()){
            return back()->with(['type'=>'error', 'message'=>"Sorry, you don't have access to centres. Please contact support to gain access for centres."]);
        }
        $can_access_centre = $allowed_centres->search(function ($value) {
            return $value->ID == request('centre_id');
        });
        $request->merge([
            'centre_id' => $request->centre_id && $can_access_centre ? $request->centre_id : $allowed_centres[0]->ID
        ]);

        $days_of_the_week   =   GeneralHelper::getDaysOfTheWeeks();

        $results    =   DB::table('classes')
                            ->join('centres', 'classes.centre_id', '=', 'centres.id')
                            ->join('programme_levels', 'classes.programme_level_id', '=', 'programme_levels.id')
                            ->join('programmes', 'programme_levels.programme_id', '=', 'programmes.id')
                            ->join('class_types', 'programme_levels.class_type_id', '=', 'class_types.id')
                            ->join('class_days', 'classes.class_day_id', '=', 'class_days.id')
                            ->when(request('search'), function ($query, $search) {
                                $query->where(function ($q) use ($search) {
                                    $q->where('programmes.name', 'LIKE', "%$search%");
                                });
                            })
                            ->when(request('day'), function ($query, $search) {
                                $query->where('classes.class_day_id', request('day'));
                            })
                            ->where('classes.centre_id', '=', $request->centre_id)
                            ->select([  'programmes.name as programme_name', 
                                        'class_days.name as class_day', 
                                        'programme_levels.level', 
                                        'classes.id', 
                                        'classes.centre_id', 
                                        'capacity',
                                        'class_types.name as type',
                                        'start_time',
                                        'end_time',
                                        'classes.status'])->paginate(10);

        return Inertia::render('CentreManagement/Classes/Index', [
            'filter'            => request()->all('search', 'centre_id', 'day'),
            'days_of_the_week'  => $days_of_the_week,
            'classes'           => $results,
        ]);
    }

    public function create(Request $request)
    {
        $programme_list     =   ProgrammeHelper::programmes();
        $day_list           =   DB::table('class_days')->get();
        $method_list        =   DB::table('class_methods')->get();

        return Inertia::render('CentreManagement/Classes/Create', [
            'programme_list'    => $programme_list,
            'day_list'          => $day_list,
            'method_list'       => $method_list,
            'centre_id'         => $request->centre_id
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'centre_id'             => 'required',
            'programme_id'          => 'required',
            'class_type'            => 'required',
            'programme_level_id'    => 'required',
            'class_day'             => 'required',
            "class_method"          => 'required',
            'class_capacity'        => 'required',
            'start_time'            => 'required',
            'end_time'              => 'required',
        ]);
        dd($request->all());
        $class_id   =   DB::table('classes')->insertGetId([
            'centre_id'             =>  $request->centre_id,
            'programme_level_id'    =>  $request->programme_level_id,
            'class_day_id'          =>  $request->class_day,
            'class_method_id'       =>  $request->class_method,
            'start_time'            =>  Carbon::createFromTime($request->start_time['hours'], $request->start_time['minutes'], $request->start_time['seconds'])->format('H:i'),
            'end_time'              =>  Carbon::createFromTime($request->end_time['hours'], $request->end_time['minutes'], $request->end_time['seconds'])->format('H:i'),
            'capacity'              =>  $request->class_capacity,
            'status'                =>  $request->class_status,
        ]);
        
        $log_data =   'Create class ID '.$class_id;
        event(new DatabaseTransactionEvent($log_data));

        return redirect(route('classes'))->with(['type'=>'success', 'message'=>'Class added successfully !']);
    }

    public function edit(Request $request)
    {
        $class_info         =   DB::table('classes')
                                    ->join('programme_levels','classes.programme_level_id','=','programme_levels.id')
                                    ->join('programmes','programme_levels.programme_id','=','programmes.id')
                                    ->where('classes.id', $request->class_id)
                                    ->select([  'classes.id as class_id','programmes.id as programme_id','programmes.name','programme_levels.id as programme_level_id',
                                                'programme_levels.level','classes.centre_id','classes.class_day_id',
                                                'programme_levels.class_type_id','classes.class_method_id','classes.start_time','classes.end_time','classes.capacity'
                                                ,'classes.status'])->first();

        $class_types        =   DB::table('programme_levels')
                                    ->join('class_types','programme_levels.class_type_id','=','class_types.id')
                                    ->select(['class_types.id', 'class_types.name'])
                                    ->distinct('class_types.id')
                                    ->where('programme_levels.programme_id', $class_info->programme_id)
                                    ->orderBy('class_types.id')
                                    ->get();

        $class_levels       =   DB::table('programme_levels')
                                    ->select(['id', 'level'])
                                    ->where('programme_id', $class_info->programme_id)
                                    ->where('class_type_id', $class_info->class_type_id)
                                    ->orderBy('level')
                                    ->get();

        $programme_list     =   ProgrammeHelper::programmes();
        $day_list           =   DB::table('class_days')->get();
        $type_list          =   DB::table('class_types')->get();
        $method_list        =   DB::table('class_methods')->get();
        
        return Inertia::render('CentreManagement/Classes/Edit', [
            'class_info'        =>  $class_info,
            'class_types'       =>  $class_types,
            'class_levels'      =>  $class_levels,
            'programme_list'    =>  $programme_list,
            'day_list'          =>  $day_list,
            'type_list'         =>  $type_list,
            'method_list'       =>  $method_list,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'centre_id'             => 'required',
            'programme_id'          => 'required',
            'class_type'            => 'required',
            'programme_level_id'    => 'required',
            'class_day'             => 'required',
            "class_method"          => 'required',
            'class_capacity'        => 'required',
            'start_time'            => 'required',
            'end_time'              => 'required',
        ]);
        
        // if(auth()->user()->is_admin == false){
        //     $approval_data      =   $request->all();
        //     $pending_approval   =   ClassHelper::checkClassPreviousApprovals($request->class_id, $this->update_class_config);
        
        //     if($pending_approval){
        //         return redirect(route('programmes'))->with(['type' => 'error', 'message' => 'This programme is on pending approval!']);
        //     }
        //     $approval_data['class_info']    =   DB::table('classes')
        //                                             ->join('programme_levels','classes.programme_level_id','=','programme_levels.id')
        //                                             ->join('programmes','programme_levels.programme_id','=','programmes.id')
        //                                             ->where('classes.id', $request->class_id)
        //                                             ->select([  'classes.id as class_id','programmes.id as programme_id','programmes.name','programme_levels.id as programme_level_id',
        //                                                         'programme_levels.level','classes.centre_id','classes.class_day_id',
        //                                                         'programme_levels.class_type_id','classes.class_method_id','classes.start_time','classes.end_time','classes.capacity'
        //                                                         ,'classes.status'])->first();

        //     $approval_data['class_types']   =   DB::table('programme_levels')
        //                                             ->join('class_types','programme_levels.class_type_id','=','class_types.id')
        //                                             ->select(['class_types.id', 'class_types.name'])
        //                                             ->distinct('class_types.id')
        //                                             ->where('programme_levels.programme_id', $approval_data['class_info']->programme_id)
        //                                             ->orderBy('class_types.id')
        //                                             ->get();

        //     $approval_data['class_levels']  =   DB::table('programme_levels')
        //                                             ->select(['id', 'level'])
        //                                             ->where('programme_id', $approval_data['class_info']->programme_id)
        //                                             ->where('class_type_id', $approval_data['class_info']->class_type_id)
        //                                             ->orderBy('level')
        //                                             ->get();

        //     $approval_data['programme_list']    =   ProgrammeHelper::programmes();
        //     $approval_data['day_list']          =   DB::table('class_days')->get();
        //     $approval_data['type_list']         =   DB::table('class_types')->get();
        //     $approval_data['method_list']       =   DB::table('class_methods')->get();

        //     $approval   =   new ClassApprovalController();
        //     $approval->sendClassUpdateRequest($approval_data);

        //     return redirect(route('classes'))->with(['type' => 'success', 'message' => 'Your request has been sent for approval!']);
        // }
        DB::table('classes')->where('id', $request->class_id)->update([
            'centre_id'             =>  $request->centre_id,
            'programme_level_id'    =>  $request->programme_level_id,
            'class_day_id'          =>  $request->class_day,
            'class_method_id'       =>  $request->class_method,
            'start_time'            =>  Carbon::createFromTime($request->start_time['hours'], $request->start_time['minutes'], $request->start_time['seconds'])->format('H:i'),
            'end_time'              =>  Carbon::createFromTime($request->end_time['hours'], $request->end_time['minutes'], $request->end_time['seconds'])->format('H:i'),
            'capacity'              =>  $request->class_capacity,
            'status'                =>  $request->class_status,
            'updated_at'            =>  Carbon::now(),
        ]);

        $log_data =   'Updated class ID '.$request->class_id;
        event(new DatabaseTransactionEvent($log_data));

        return redirect(route('classes'))->with(['type'=>'success', 'message'=>'Class updated successfully !']);
    }

    public function destroy($id)
    {
        /* Check if programme can be deleted */
        $class_is_deletable   =   ClassHelper::checkClassIsDeletable($id);
        if(!$class_is_deletable){
            return redirect(route('classes'))->with(['type' => 'error', 'message' => 'There are students in this class!']);
        }

        /* Check if user is admin */
        // if(auth()->user()->is_admin == false){

        //     /* Check if delete request on this programme is still pending */
        //     $pending_approval   =   ClassHelper::checkClassPreviousApprovals($id, $this->delete_class_config);
        //     if($pending_approval){
        //         return redirect(route('classes'))->with(['type' => 'error', 'message' => 'This class is on pending approval!']);
        //     }

        //     /* Send programme delete request */
        //     $approval   =   new ClassApprovalController();
        //     $approval->sendClassDeleteRequest($id);

        //     return redirect(route('classes'))->with(['type' => 'success', 'message' => 'Your request has been sent for approval!']);
        // }

        DB::table('classes')->where('id', $id)->delete();

        $log_data =   'Deleted class ID '.$id;
        event(new DatabaseTransactionEvent($log_data));

        return redirect(route('classes'))->with(['type'=>'success', 'message'=>'Class deleted successfully !']);
    }

    public function getClassTypes(Request $request){
        $class_types    =   DB::table('programme_levels')
                                ->join('class_types','programme_levels.class_type_id','=','class_types.id')
                                ->select(['class_types.id', 'class_types.name'])
                                ->distinct('class_types.id')
                                ->where('programme_levels.programme_id', $request->programme_id)
                                ->orderBy('class_types.id')
                                ->get();
        return $class_types;
    }

    public function getClassLevels(Request $request){
        $class_levels   =   DB::table('programme_levels')
                                ->select(['id', 'level'])
                                ->where('programme_id', $request->programme_id)
                                ->where('class_type_id', $request->class_type)
                                ->orderBy('level')
                                ->get();
        return $class_levels;
    }

    public function findClasses(Request $request){
        
        $classes        =   DB::table('classes')
                            ->join('centres', 'classes.centre_id', '=', 'centres.id')
                            ->join('programme_levels', 'classes.programme_level_id', '=', 'programme_levels.id')
                            ->join('programmes', 'programme_levels.programme_id', '=', 'programmes.id')
                            ->join('class_days', 'classes.class_day_id', '=', 'class_days.id')
                            ->join('class_methods', 'classes.class_method_id', '=', 'class_methods.id')
                            ->where('classes.centre_id', $request->centre_id)
                            ->where('programme_levels.programme_id', $request->programme_id)
                            ->where('programme_levels.class_type_id', $request->class_type)
                            ->where('programme_levels.level', $request->class_level)
                            ->where('classes.class_method_id', $request->class_method)
                            ->select(['classes.id as class_id', 'class_days.name as class_day', 'programme_levels.id as programme_level_id', 'programme_levels.class_type_id as class_type', 'classes.start_time', 'classes.end_time', 'classes.capacity', 'programmes.id as programme_id'])
                            ->get();
        return $classes;
    }
}

<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ClassController extends Controller
{
    public function index()
    {
        $query          =   DB::table('classes')
                                ->join('class_types', 'classes.class_type_id', '=', 'class_types.id')
                                ->join('wpvt_10_wlsm_schools', 'classes.centre_id', '=', 'wpvt_10_wlsm_schools.id')
                                ->join('programmes', 'classes.programme_id', '=', 'programmes.id')
                                ->join('class_days', 'classes.class_day_id', '=', 'class_days.id')
                                ->select(['wpvt_10_wlsm_schools.label as centre_name', 
                                            'programmes.name as programme_name', 
                                            'programmes.name as class_type', 
                                            'class_days.name as class_day', 
                                            'classes.level as class_level', 
                                            'classes.id', 
                                            'classes.name', 
                                            'capacity', 
                                            'class_types.name as type', 
                                            'start_time', 
                                            'end_time']);

        if(request('search')){
            $query->where('name', 'LIKE', '%'.request('search').'%');
        }

        $classes        =   $query->paginate(10);
        
        return Inertia::render('Classes/Index', [
            'filter'        => request()->all('search'),
            'classes'       => $classes,
        ]);
    }

    public function create()
    {
        $programme_list     =   DB::table('programmes')->get();
        $day_list           =   DB::table('class_days')->get();
        $type_list           =   DB::table('class_types')->get();
        
        return Inertia::render('Classes/Create', [
            'programme_list'    => $programme_list,
            'day_list'          => $day_list,
            'type_list'         => $type_list,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_name'        => 'required|max:50',
            'centre_id'         => 'required',
            'programme_id'      => 'required',
            'class_level'       => 'required',
            'class_day'         => 'required',
            'start_time'        => 'required',
            'end_time'          => 'required',
            'class_capacity'    => 'required',
            "class_type"        => 'required'
        ]);

        DB::table('classes')->insert([
            'programme_id'      =>  $request->programme_id,
            'centre_id'         =>  $request->centre_id,
            'name'              =>  $request->class_name,
            'level'             =>  $request->class_level,
            'class_day_id'      =>  $request->class_day,
            'start_time'        =>  Carbon::createFromTime($request->start_time['hours'], $request->start_time['minutes'], $request->start_time['seconds'])->format('H:i'),
            'end_time'          =>  Carbon::createFromTime($request->end_time['hours'], $request->end_time['minutes'], $request->end_time['seconds'])->format('H:i'),
            'capacity'          =>  $request->class_capacity,
            'class_type_id'     =>  $request->class_type,
            'status'            =>  $request->class_status,
        ]);

        return redirect(route('classes'))->with(['type'=>'success', 'message'=>'Class added successfully !']);
    }

    public function edit(Request $request)
    {
        $class_info         =   DB::table('classes')->where('id', $request->class_id)->first();
        $programme_list     =   DB::table('programmes')->get();
        $day_list           =   DB::table('class_days')->get();
        $type_list          =   DB::table('class_types')->get();
        
        for($i = 1; $i <= collect($programme_list)->keyBy('id')[$class_info->programme_id]->level; $i++){
            $class_level[] = $i;
        }
        
        return Inertia::render('Classes/Edit', [
            'class_info'        => $class_info,
            'programme_list'    => $programme_list,
            'day_list'          => $day_list,
            'type_list'         => $type_list,
            'class_level'       => $class_level,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'class_name'        => 'required|max:50',
            'centre_id'         => 'required',
            'programme_id'      => 'required',
            'class_level'       => 'required',
            'class_day'         => 'required',
            'start_time'        => 'required',
            'end_time'          => 'required',
            'class_capacity'    => 'required',
            "class_type"        => 'required'
        ]);
        
        DB::table('classes')->where('id', $request->class_id)->update([
            'programme_id'      =>  $request->programme_id,
            'centre_id'         =>  $request->centre_id,
            'name'              =>  $request->class_name,
            'level'             =>  $request->class_level,
            'class_day_id'               =>  $request->class_day,
            'start_time'        =>  Carbon::createFromTime($request->start_time['hours'], $request->start_time['minutes'], $request->start_time['seconds'])->format('H:i'),
            'end_time'          =>  Carbon::createFromTime($request->end_time['hours'], $request->end_time['minutes'], $request->end_time['seconds'])->format('H:i'),
            'capacity'          =>  $request->class_capacity,
            'class_type_id'     =>  $request->class_type,
            'status'            =>  $request->class_status,
        ]);

        return redirect(route('classes'))->with(['type'=>'success', 'message'=>'Class updated successfully !']);
    }

    public function destroy($id)
    {
        DB::table('classes')->where('id', $id)->delete();

        return redirect(route('classes'))->with(['type'=>'success', 'message'=>'Class deleted successfully !']);
    }
}

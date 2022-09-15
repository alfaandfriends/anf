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
                                ->select(['classes.name', 'capacity', 'class_types.name as type', 'start_time', 'end_time']);

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
            'name'              =>  $request->class_name,
            'level'             =>  $request->class_level,
            'day'               =>  $request->class_day,
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
        $session_info =   DB::table('wpvt_10_wlsm_sessions')->where('ID', $request->session_id)->first();
        
        return Inertia::render('Classes/Edit', [
            'session_info'    => $session_info
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'session'               => 'required|max:100',
            'start_date'            => 'required',
            'end_date'              => 'required',
        ]);
        
        DB::table('wpvt_10_wlsm_sessions')->where('ID', $request->session_id)->update([
            'label'         =>  $request->session,
            'start_date'    =>  Carbon::parse($request->start_date)->toDateString(),
            'end_date'      =>  Carbon::parse($request->end_date)->toDateString(),
            'updated_at'    =>  Carbon::now(),
        ]);

        return redirect(route('sessions'))->with(['type'=>'success', 'message'=>'Session updated successfully !']);
    }

    public function destroy($id)
    {
        DB::table('wpvt_10_wlsm_sessions')->where('ID', $id)->delete();

        return redirect(route('sessions'))->with(['type'=>'success', 'message'=>'Session deleted successfully !']);
    }
}

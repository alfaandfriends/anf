<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ClassController extends Controller
{
    public function index(Request $request)
    {
        $allowed_centres    =   (object)Inertia::getShared('allowed_centres');
        $can_access_centre = $allowed_centres->search(function ($value) { 
            return $value->ID == request('centre_id');
        });

        $query          =   DB::table('classes')
                                ->join('centres', 'classes.centre_id', '=', 'centres.id')
                                ->join('programme_levels', 'classes.programme_level_id', '=', 'programme_levels.id')
                                ->join('programmes', 'programme_levels.programme_id', '=', 'programmes.id')
                                ->join('class_types', 'programme_levels.class_type_id', '=', 'class_types.id')
                                ->join('class_days', 'classes.class_day_id', '=', 'class_days.id')
                                ->select([  'programmes.name as programme_name', 
                                            'class_days.name as class_day', 
                                            'programme_levels.level', 
                                            'classes.id', 
                                            'classes.centre_id', 
                                            'capacity',
                                            'class_types.name as type',
                                            'start_time',
                                            'end_time',
                                            'classes.status']);

        if($request->search){
            $query->where('programmes.name', 'LIKE', '%'.$request->search.'%');
        }

        if($request->centre_id){
            $request->merge([
                'centre_id' => !$can_access_centre ? $allowed_centres[0]->ID : $request->centre_id,
            ]);
        }
        else{
            $request->merge([
                'centre_id' => $allowed_centres[0]->ID
            ]);
        }
        $query->where('classes.centre_id', '=', $request->centre_id);

        return Inertia::render('CentreManagement/Classes/Index', [
            'filter'        => request()->all('search', 'centre_id'),
            'classes'       => $query->paginate(10),
        ]);
    }

    public function create(Request $request)
    {
        $programme_list     =   DB::table('programmes')->get();
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

        DB::table('classes')->insert([
            'centre_id'             =>  $request->centre_id,
            'programme_level_id'    =>  $request->programme_level_id,
            'class_day_id'          =>  $request->class_day,
            'class_method_id'       =>  $request->class_method,
            'start_time'            =>  Carbon::createFromTime($request->start_time['hours'], $request->start_time['minutes'], $request->start_time['seconds'])->format('H:i'),
            'end_time'              =>  Carbon::createFromTime($request->end_time['hours'], $request->end_time['minutes'], $request->end_time['seconds'])->format('H:i'),
            'capacity'              =>  $request->class_capacity,
            'status'                =>  $request->class_status,
        ]);

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

        $programme_list     =   DB::table('programmes')->get();
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

        return redirect(route('classes'))->with(['type'=>'success', 'message'=>'Class updated successfully !']);
    }

    public function destroy($id)
    {
        DB::table('classes')->where('id', $id)->delete();

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
                            ->join('class_days', 'classes.class_day_id', '=', 'class_days.id')
                            ->join('class_methods', 'classes.class_method_id', '=', 'class_methods.id')
                            ->where('classes.centre_id', $request->centre_id)
                            ->where('programme_levels.programme_id', $request->programme_id)
                            ->where('programme_levels.class_type_id', $request->class_type)
                            ->where('programme_levels.level', $request->class_level)
                            ->where('classes.class_method_id', $request->class_method)
                            ->select(['classes.id as class_id', 'class_days.name as class_day', 'programme_levels.class_type_id as class_type', 'classes.start_time', 'classes.end_time', 'classes.capacity'])
                            ->paginate(10);
        return $classes;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $allowed_centres    =   (object)Inertia::getShared('allowed_centres');
        $can_access_centre = $allowed_centres->search(function ($value) { 
            return $value->ID == request('centre_id');
        });

        $query          =   DB::table('classes')
                                ->join('class_types', 'classes.class_type_id', '=', 'class_types.id')
                                ->join('centres', 'classes.centre_id', '=', 'centres.id')
                                ->join('programmes', 'classes.programme_id', '=', 'programmes.id')
                                ->join('class_days', 'classes.class_day_id', '=', 'class_days.id')
                                ->select([  'programmes.name as programme_name', 
                                            'class_days.name as class_day', 
                                            'classes.id', 
                                            'classes.centre_id', 
                                            'classes.level as class_level', 
                                            'capacity', 
                                            'class_types.name as type',
                                            'start_time',
                                            'end_time']);

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

        return Inertia::render('CentreManagement/Students/Index', [
            'filter'        => request()->all('search', 'centre_id'),
            'classes'       => $query->paginate(10),
        ]);
    }
}

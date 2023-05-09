<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ProgressReportController extends Controller
{
    public function index()
    {
        $programmes     =   DB::table('programmes')->get();
        $class_days     =   DB::table('class_days')->get();
        
        // $classes_day    =   DB::table('student_fees')
        //                         ->join('students', 'student_fees.student_id', '=', 'students.id')
        //                         ->join('programme_level_fees', 'student_fees.fee_id', '=', 'programme_level_fees.id')
        //                         ->join('programme_levels', 'programme_level_fees.programme_level_id', '=', 'programme_levels.id')
        //                         ->join('programmes', 'programme_levels.programme_id', '=', 'programmes.id')
        //                         ->join('student_classes', 'student_classes.student_fee_id', '=', 'student_fees.id')
        //                         ->join('classes', 'student_classes.class_id', '=', 'classes.id')
        //                         ->join('class_days', 'classes.class_day_id', '=', 'class_days.id')
        //                         ->select('students.id', 'class_days.name', 'programmes.table')
        //                         ->paginate();
        // dd($classes_day);
        
        return Inertia::render('ProgressReport/Index', [
            'math_manipulatives' => [],
            'programmes' => $programmes,
            'class_days' => $class_days
        ]);
    }
}

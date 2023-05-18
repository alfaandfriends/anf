<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ProgressReportController extends Controller
{
    public function index(Request $request)
    {

        $allowed_centres    =   (object)Inertia::getShared('allowed_centres');
        $can_access_centre = $allowed_centres->search(function ($value) { 
            return $value->ID == request('centre_id');
        });
        
        $query  =   DB::table('progress_report_details')
                        ->join('progress_reports', 'progress_report_details.progress_report_id', '=', 'progress_reports.id')
                        ->join('progress_report_configs', 'progress_reports.progress_report_config_id', '=', 'progress_report_configs.id')
                        ->join('student_fees', 'progress_reports.student_fee_id', '=' ,'student_fees.id')
                        ->join('students', 'student_fees.student_id', '=' ,'students.id')
                        ->join('children', 'students.children_id', '=' ,'children.id')
                        ->select(   'progress_reports.id as progress_report_id',
                                    'students.id as student_id', 
                                    'children.name as student_name', 
                                    DB::raw('count(progress_reports.id) as total_class'), 
                                    DB::raw('count(CASE WHEN progress_report_details.attendance_status = 1 THEN 1 END) as total_present'), 
                                    DB::raw('count(CASE WHEN progress_report_details.attendance_status = 2 THEN 1 END) as total_absent'), 
                        );
                        
        if($request->search){
            $query->where('children.name', 'LIKE', '%'.$request->search.'%');
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

        if($request->programme_id){
            $query->where('progress_report_configs.programme_id', 'LIKE', '%'.$request->programme_id.'%');
        }

        if($request->date){
            $query->whereMonth('progress_reports.month', $request->date['month']+1);
            $query->whereYear('progress_reports.month', $request->date['year']);
        }
        
        $query->where('student_fees.centre_id', '=', $request->centre_id);

        return Inertia::render('ProgressReport/Index', [
            'filter'                => request()->all('search', 'centre_id', 'programme_id', 'date'),
            'progress_reports'      => $query->groupBy('progress_reports.id')->paginate(10),
        ]);
    }

    public function details(Request $request)
    {
        /* Math Select Options */
        $math_terms_books   =   DB::table('math_terms_books')->get();
        $math_units         =   DB::table('math_units')->get();
        $math_lessons         =   DB::table('math_lessons')->get();

        /* Coding Select Option */

        /* Digital Art Select Option */
        $attendance_status  =   DB::table('progress_report_status')->get();
        $report_details     =   DB::table('progress_reports')->where('id', $request->progress_report_id)->first();   
        $config_info        =   DB::table('progress_report_configs')->where('id', $report_details->progress_report_config_id)->first();
        $progress_reports   =   DB::table('progress_report_details')->where('progress_report_id', $request->progress_report_id)->get();
        
        return Inertia::render('ProgressReport/Templates/'.$config_info->vue_template, [
            'math_terms_books'      => $math_terms_books,
            'math_units'            => $math_units,
            'math_lessons'          => $math_lessons,
            'progress_reports'      => $progress_reports,
            'attendance_status'     => $attendance_status
        ]);
    }

    public function updateDate(Request $request)
    {
        dd($request->all());
    }
}

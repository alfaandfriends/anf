<?php

namespace App\Http\Controllers;

use App\Classes\ProgrammeHelper;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ProgressReportController extends Controller
{
    public function index(Request $request){

        $allowed_centres    =   (object)Inertia::getShared('allowed_centres');
        $can_access_centre = $allowed_centres->search(function ($value) { 
            return $value->ID == request('centre_id');
        });

        $programmes =   ProgrammeHelper::programmes();
        
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
            'filter'            =>  request()->all('search', 'centre_id', 'programme_id', 'date'),
            'progress_reports'  =>  $query->groupBy('progress_reports.id')->paginate(10),
            'programmes'        =>  $programmes
        ]);
    }

    public function details(Request $request){
        /* Student Information */
        $student_info   =   DB::table('progress_reports')
                                ->join('student_fees', 'progress_reports.student_fee_id', '=', 'student_fees.id')
                                ->join('students', 'student_fees.student_id', '=', 'students.id')
                                ->join('children', 'students.children_id', '=', 'children.id')
                                ->join('programme_level_fees', 'student_fees.fee_id', '=', 'programme_level_fees.id')
                                ->join('programme_levels', 'programme_level_fees.programme_level_id', '=', 'programme_levels.id')
                                ->join('programmes', 'programme_levels.programme_id', '=', 'programmes.id')
                                ->where('progress_reports.id', $request->progress_report_id)
                                ->select('children.name as name', 'students.created_at as joined_date', 'programmes.name as programme', 'programme_levels.level as level')
                                ->first();
        // dd($student_info);
        /* Math Init Selection */
        $math_terms_books   =   DB::table('math_terms_books')->where('level_id', $student_info->level)->get();

        /* Coding Init Selection */
        $coding_lessons     =   DB::table('coding_lessons')->where('level_id', $student_info->level)->get();

        /* Digital Art Init Selection */

        $attendance_status  =   DB::table('progress_report_status')->get();
        $report_details     =   DB::table('progress_reports')->where('id', $request->progress_report_id)->first();   
        $config_info        =   DB::table('progress_report_configs')->where('id', $report_details->progress_report_config_id)->first();
        $progress_reports   =   DB::table('progress_report_details')
                                    ->join('progress_report_status', 'progress_report_details.attendance_status', '=', 'progress_report_status.id')
                                    ->select('progress_report_details.progress_report_id', 'progress_report_details.id', 'progress_report_details.date', 
                                            'progress_report_details.report_data', 'progress_report_details.comments', 'progress_report_details.attendance_status',
                                            'progress_report_status.class as attendance_status_class_name', 'progress_report_status.name as attendance_status_name')
                                    ->where('progress_report_id', $request->progress_report_id)->get();
        
        return Inertia::render('ProgressReport/Templates/'.$config_info->vue_template, [
            'student_info'          => $student_info,
            'math_terms_books'      => $math_terms_books,
            'coding_lessons'        => $coding_lessons,
            'progress_reports'      => $progress_reports,
            'attendance_status'     => $attendance_status,
        ]);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'date'  => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with(['type'=>'error', 'message'=>'Date is required!']);
        }

        DB::table('progress_report_details')->where('id', $request->report_id)->update([
            'date'                  => Carbon::parse($request->date)->format('Y-m-d'),
            'report_data'           => json_encode($request->report_data),
            'comments'              => $request->comments,
            'attendance_status'     => $request->attendance_status,
        ]);

        return back()->with(['type'=>'success', 'message'=>'Progress report updated successfully !']);
    }

    public function getMathUnits($term_book_id){
        $units   =   DB::table('math_units')->where('term_book_id', $term_book_id)->get();

        return $units;
    }

    public function getMathLessons($unit_id){
        $lessons   =   DB::table('math_lessons')->where('unit_id', $unit_id)->get();

        return $lessons;
    }

    public function getMathObjectives($lesson_id){
        $objectives   =   DB::table('math_objectives')->where('lesson_id', $lesson_id)->select('id', 'name', 'lesson_id')->get();

        return $objectives;
    }

    public function getCodingTopics($lesson_id){
        $topics   =   DB::table('coding_topics')->where('lesson_id', $lesson_id)->get();

        return $topics;
    }

    public function getCodingObjectives($topic_id){
        $objectives   =   DB::table('coding_objectives')->where('topic_id', $topic_id)->get();

        return $objectives;
    }

    public function getCodingActivitiesProcedures($objective_id){
        $activities_procedures   =   DB::table('coding_activities_procedures')->where('objective_id', $objective_id)->get();

        return $activities_procedures;
    }
}

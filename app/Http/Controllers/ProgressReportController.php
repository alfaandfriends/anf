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
        if(empty($allowed_centres)){
            return back()->with(['type'=>'error', 'message'=>'Please contact support to gain access for centres']);
        }
        $can_access_centre = $allowed_centres->search(function ($value) {
            return $value->ID == request('centre_id');
        });

        $programmes =   ProgrammeHelper::programmes();
        $levels     =   ProgrammeHelper::distinctLevels();
        
        $query  =   DB::table('progress_report_details')
                        ->join('progress_reports', 'progress_report_details.progress_report_id', '=', 'progress_reports.id')
                        ->join('progress_report_configs', 'progress_reports.progress_report_config_id', '=', 'progress_report_configs.id')
                        ->join('student_fees', 'progress_reports.student_fee_id', '=' ,'student_fees.id')
                        ->join('centres', 'student_fees.centre_id', '=' ,'centres.id')
                        ->join('programme_level_fees', 'student_fees.fee_id', '=' ,'programme_level_fees.id')
                        ->join('programme_levels', 'programme_level_fees.programme_level_id', '=' ,'programme_levels.id')
                        ->join('programmes', 'programme_levels.programme_id', '=' ,'programmes.id')
                        ->join('students', 'student_fees.student_id', '=' ,'students.id')
                        ->join('children', 'students.children_id', '=' ,'children.id')
                        ->select(   'progress_reports.student_fee_id as student_fee',
                                    'progress_reports.id as progress_report_id',
                                    'programmes.name as programme_name',
                                    'centres.label as centre_name',
                                    'programme_levels.level as programme_level',
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
            'programmes'        =>  $programmes,
            'levels'            =>  $levels
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
                                
        /* Math Init Selection */
        $math_terms_books   =   $this->getMathTermBooks($student_info->level);

        /* Coding Init Selection */
        $coding_lessons     =   $this->getCodingLessons($student_info->level);

        /* Digital Art Init Selection */
        $art_themes     =   $this->getArtThemes($student_info->level);

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
            'art_themes'            => $art_themes,
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
    
    public function getFullProgressReports(Request $request)
    {
        $data['student_data']        =   DB::table('progress_reports')
                                            ->join('progress_report_details', 'progress_report_details.progress_report_id', '=', 'progress_reports.id')
                                            ->join('student_fees', 'progress_reports.student_fee_id', '=', 'student_fees.id')
                                            ->join('students', 'student_fees.student_id', '=', 'students.id')
                                            ->join('children', 'students.children_id', '=', 'children.id')
                                            ->join('programme_level_fees', 'student_fees.fee_id', '=', 'programme_level_fees.id')
                                            ->join('programme_levels', 'programme_level_fees.programme_level_id', '=', 'programme_levels.id')
                                            ->join('programmes', 'programme_levels.programme_id', '=', 'programmes.id')
                                            ->select('children.name as student_name', 'students.created_at as date_joined','programmes.name as programme_name', 
                                                    'programme_levels.level as programme_level')
                                            ->where('progress_report_id', $request->progress_report_id)->first();

        $data['report_data']        =   DB::table('progress_reports')
                                            ->join('progress_report_details', 'progress_report_details.progress_report_id', '=', 'progress_reports.id')
                                            ->join('progress_report_status', 'progress_report_details.attendance_status', '=', 'progress_report_status.id')
                                            ->select('progress_report_details.date', 'progress_report_details.report_data', 'progress_report_details.comments', 
                                                    'progress_report_status.name as attendance_status_name')
                                            ->where('progress_reports.student_fee_id', $request->student_fee)->orderBy('progress_report_details.id')->get();

        $data['report_template']    =    DB::table('progress_reports')
                                            ->join('progress_report_configs', 'progress_reports.progress_report_config_id', '=', 'progress_report_configs.id')
                                            ->where('progress_reports.id', $request->progress_report_id)->pluck('progress_report_configs.vue_template')
                                            ->first();

        return $data;
    }

    /* Math */
    public function getMathTermBooks($level_id){
        $terms_books   =   DB::table('pr_math_terms_books')->where('level_id', $level_id)->get();

        return $terms_books;
    }

    public function getMathUnits($term_book_id){
        $units   =   DB::table('pr_math_units')->where('term_book_id', $term_book_id)->get();

        return $units;
    }

    public function getMathLessons($unit_id){
        $lessons   =   DB::table('pr_math_lessons')->where('unit_id', $unit_id)->get();

        return $lessons;
    }

    public function getMathObjectives($lesson_id){
        $objectives   =   DB::table('pr_math_objectives')->where('lesson_id', $lesson_id)->select('id', 'name', 'lesson_id')->get();

        return $objectives;
    }

    /* Coding */
    public function getCodingLessons($level_id){
        $lessons     =   DB::table('pr_coding_lessons')->where('level_id', $level_id)->get();

        return $lessons;
    }
    public function getCodingTopics($lesson_id){
        $topics   =   DB::table('pr_coding_topics')->where('lesson_id', $lesson_id)->get();

        return $topics;
    }

    public function getCodingObjectives($topic_id){
        $objectives   =   DB::table('pr_coding_objectives')->where('topic_id', $topic_id)->get();

        return $objectives;
    }

    public function getCodingActivitiesProcedures($objective_id){
        $activities_procedures   =   DB::table('pr_coding_activities_procedures')->where('objective_id', $objective_id)->get();

        return $activities_procedures;
    }

    /* Art */
    public function getArtThemes($level_id){
        $themes     =   DB::table('pr_art_themes')->where('level_id', $level_id)->get();

        return $themes;
    }
    public function getArtLessons($theme_id){
        $lessons   =   DB::table('pr_art_lessons')->where('theme_id', $theme_id)->get();

        return $lessons;
    }

    public function getArtActivities($lesson_id){
        $activities   =   DB::table('pr_art_activities')->where('lesson_id', $lesson_id)->get();

        return $activities;
    }

    public function getArtLearningOutcomes($activity_id){
        $learning_outcomes   =   DB::table('pr_art_outcomes')->where('activity_id', $activity_id)->get();

        return $learning_outcomes;
    }

    public function getArtObjectives($outcome_id){
        $objectives   =   DB::table('pr_art_objectives')->where('outcome_id', $outcome_id)->get();

        return $objectives;
    }
}
<?php

namespace App\Http\Controllers;

use App\Classes\ProgrammeHelper;
use App\Classes\ProgressReportHelper;
use App\Events\DatabaseTransactionEvent;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ProgressReportController extends Controller
{
    public function index(Request $request)
    {
        $allowed_centres    =   Inertia::getShared('allowed_centres');
        if($allowed_centres->isEmpty()){
            return back()->with(['type'=>'error', 'message'=>"Sorry, you don't have access to centres. Please contact support to gain access for centres."]);
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
        


        $request->merge([
            'centre_id' => $request->centre_id && $can_access_centre ? $request->centre_id : $allowed_centres[0]->ID
        ]);

        if($request->programme_id){
            $query->where('progress_report_configs.programme_id', 'LIKE', '%'.$request->programme_id.'%');
        }

        if($request->date){
            $query->whereMonth('progress_reports.month', $request->date['month']+1);
            $query->whereYear('progress_reports.month', $request->date['year']);
        }

        if($request->programme_level){
            $query->where('programme_levels.level', $request->programme_level);
        }
        
        $query->where('student_fees.centre_id', '=', $request->centre_id);
        
        return Inertia::render('ProgressReport/Index', [
            'filter'            =>  request()->all('search', 'centre_id', 'programme_id', 'date', 'programme_level'),
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
                                    ->where('progress_report_id', $request->progress_report_id)->orderBy('progress_report_details.date')->get();
        
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
            'report_data'           => json_encode($request->report_data, JSON_NUMERIC_CHECK),
            'comments'              => $request->comments,
            'attendance_status'     => $request->attendance_status,
        ]);
        $log_data =   'Updated progress report ID '.$request->report_id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Progress report updated successfully !']);
    }
    
    public function getFullProgressReports(Request $request){
        $data['student_data']        =   DB::table('progress_reports')
                                            ->join('progress_report_details', 'progress_report_details.progress_report_id', '=', 'progress_reports.id')
                                            ->join('student_fees', 'progress_reports.student_fee_id', '=', 'student_fees.id')
                                            ->join('students', 'student_fees.student_id', '=', 'students.id')
                                            ->join('children', 'students.children_id', '=', 'children.id')
                                            ->join('programme_level_fees', 'student_fees.fee_id', '=', 'programme_level_fees.id')
                                            ->join('programme_levels', 'programme_level_fees.programme_level_id', '=', 'programme_levels.id')
                                            ->join('programmes', 'programme_levels.programme_id', '=', 'programmes.id')
                                            ->select('children.name as student_name', 'students.date_joined','programmes.name as programme_name', 
                                                    'programme_levels.level as programme_level')
                                            ->where('progress_report_id', $request->progress_report_id)->first();
        $data['student_data']->date_joined = Carbon::hasFormat($data['student_data']->date_joined, 'Y-m-d') && Carbon::createFromFormat('Y-m-d', $data['student_data']->date_joined)->isValid() ? Carbon::parse($data['student_data']->date_joined)->format('d/m/Y') : 'Not Set';

        $data['report_data']        =   DB::table('progress_reports')
                                            ->join('progress_report_details', 'progress_report_details.progress_report_id', '=', 'progress_reports.id')
                                            ->join('progress_report_status', 'progress_report_details.attendance_status', '=', 'progress_report_status.id')
                                            ->select('progress_report_details.date', 'progress_report_details.report_data', 'progress_report_details.comments', 
                                                    'progress_report_status.name as attendance_status_name')
                                            ->where('progress_reports.student_fee_id', $request->student_fee)->orderBy('progress_report_details.date')->get();

        $data['report_template']    =    DB::table('progress_reports')
                                            ->join('progress_report_configs', 'progress_reports.progress_report_config_id', '=', 'progress_report_configs.id')
                                            ->where('progress_reports.id', $request->progress_report_id)->pluck('progress_report_configs.report_template')->first();
                                            
        $pdf = PDF::setPaper('a4', 'portrait')->loadView($data['report_template'], compact('data'));
        return $pdf->stream();
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

    /* Settings */
        public function settings(){
            return Inertia::render('ProgressReport/Settings/Index');
        }
        
        /* Math Levels*/
            public function mathLevels(){
                $levels     =   DB::table('pr_math_levels')->get();
                return Inertia::render('ProgressReport/Settings/Math/Levels', [
                    'levels'    =>  $levels
                ]);
            }

            public function mathLevelsStore(Request $request)
            {
                $level   =   DB::table('pr_math_levels')->insertGetId([
                    'name'      => $request->level_name
                ]);
                $log_data =   'Added progress report level ID '.$level;
                event(new DatabaseTransactionEvent($log_data));

                return back()->with(['type'=>'success', 'message'=>'New level has been added!']);
            }

            public function mathLevelsUpdate(Request $request)
            {
                DB::table('pr_math_levels')->where('id', $request->id)->update([
                    'name'  => $request->level_name
                ]);
                $log_data =   'Updated progress report level ID '.$request->id;
                event(new DatabaseTransactionEvent($log_data));
        
                return back()->with(['type'=>'success', 'message'=>'Level has been updated!']);
            }

            public function mathLevelsDestroy($id)
            {
                DB::table('pr_math_levels')->where('id', $id)->delete();
    
                $log_data =   'Deleted progress report level ID '.$id;
                event(new DatabaseTransactionEvent($log_data));
    
                return back()->with(['type'=>'success', 'message'=>'Level has been deleted!']);
            }
        /* Math Levels */
        
        /* Math Terms Books*/
            public function mathTermsBooks(Request $request){
                $terms_books     =   DB::table('pr_math_terms_books')->where('level_id', $request->level_id)->get();
                return Inertia::render('ProgressReport/Settings/Math/TermsBooks', [
                    'level_id'       =>     $request->level_id,
                    'terms_books'    =>     $terms_books
                ]);
            }

            public function mathTermsBooksStore(Request $request)
            {
                $term_book   =   DB::table('pr_math_terms_books')->insertGetId([
                    'level_id'  => $request->level_id,
                    'name'      => $request->term_book_name
                ]);
                $log_data =   'Added progress report term book ID '.$term_book;
                event(new DatabaseTransactionEvent($log_data));

                return back()->with(['type'=>'success', 'message'=>'New term book has been added!']);
            }

            public function mathTermsBooksUpdate(Request $request)
            {
                DB::table('pr_math_terms_books')->where('id', $request->id)->update([
                    'name'  => $request->term_book_name
                ]);
                $log_data =   'Updated progress report term book ID '.$request->id;
                event(new DatabaseTransactionEvent($log_data));
        
                return back()->with(['type'=>'success', 'message'=>'Term Book has been updated!']);
            }

            public function mathTermsBooksDestroy($id)
            {
                DB::table('pr_math_terms_books')->where('id', $id)->delete();
    
                $log_data =   'Deleted progress report term book ID '.$id;
                event(new DatabaseTransactionEvent($log_data));
    
                return back()->with(['type'=>'success', 'message'=>'Term Book has been deleted!']);
            }
        /* Math Terms Books */
        
        /* Math Units*/
            public function mathUnits(Request $request){
                $units     =   DB::table('pr_math_units')->where('term_book_id', $request->term_book_id)->get();
                return Inertia::render('ProgressReport/Settings/Math/Units', [
                    'level_id'      =>     $request->level_id,
                    'term_book_id'  =>     $request->term_book_id,
                    'units'         =>     $units
                ]);
            }

            public function mathUnitsStore(Request $request)
            {
                $unit   =   DB::table('pr_math_units')->insertGetId([
                    'term_book_id'  => $request->term_book_id,
                    'name'          => $request->unit_name
                ]);
                $log_data =   'Added progress report unit ID '.$unit;
                event(new DatabaseTransactionEvent($log_data));

                return back()->with(['type'=>'success', 'message'=>'New unit has been added!']);
            }

            public function mathUnitsUpdate(Request $request)
            {
                DB::table('pr_math_units')->where('id', $request->id)->update([
                    'name'  => $request->unit_name
                ]);
                $log_data =   'Updated progress report unit ID '.$request->id;
                event(new DatabaseTransactionEvent($log_data));
        
                return back()->with(['type'=>'success', 'message'=>'Unit has been updated!']);
            }

            public function mathUnitsDestroy($id)
            {
                DB::table('pr_math_units')->where('id', $id)->delete();
    
                $log_data =   'Deleted progress report unit ID '.$id;
                event(new DatabaseTransactionEvent($log_data));
    
                return back()->with(['type'=>'success', 'message'=>'Unit has been deleted!']);
            }
        /* Math Units */
        
        /* Math Lessons*/
            public function mathLessons(Request $request){
                $lessons     =   DB::table('pr_math_lessons')->where('unit_id', $request->unit_id)->get();
                return Inertia::render('ProgressReport/Settings/Math/Lessons', [
                    'level_id'      =>     $request->level_id,
                    'term_book_id'  =>     $request->term_book_id,
                    'unit_id'       =>     $request->unit_id,
                    'lessons'       =>     $lessons
                ]);
            }

            public function mathLessonsStore(Request $request)
            {
                $lesson   =   DB::table('pr_math_lessons')->insertGetId([
                    'unit_id'   => $request->unit_id,
                    'name'      => $request->lesson_name
                ]);
                $log_data =   'Added progress report lesson ID '.$lesson;
                event(new DatabaseTransactionEvent($log_data));

                return back()->with(['type'=>'success', 'message'=>'New lesson has been added!']);
            }

            public function mathLessonsUpdate(Request $request)
            {
                DB::table('pr_math_lessons')->where('id', $request->id)->update([
                    'name'  => $request->lesson_name
                ]);
                $log_data =   'Updated progress report lesson ID '.$request->id;
                event(new DatabaseTransactionEvent($log_data));
        
                return back()->with(['type'=>'success', 'message'=>'Lesson has been updated!']);
            }

            public function mathLessonsDestroy($id)
            {
                DB::table('pr_math_lessons')->where('id', $id)->delete();
    
                $log_data =   'Deleted progress report lesson ID '.$id;
                event(new DatabaseTransactionEvent($log_data));
    
                return back()->with(['type'=>'success', 'message'=>'Lesson has been deleted!']);
            }
        /* Math Lessons */
        
        /* Math Objectives*/
            public function mathObjectives(Request $request){
                $objectives     =   DB::table('pr_math_objectives')->where('lesson_id', $request->lesson_id)->get();
                return Inertia::render('ProgressReport/Settings/Math/Objectives', [
                    'level_id'      =>     $request->level_id,
                    'term_book_id'  =>     $request->term_book_id,
                    'unit_id'       =>     $request->unit_id,
                    'lesson_id'     =>     $request->lesson_id,
                    'objectives'    =>     $objectives
                ]);
            }

            public function mathObjectivesStore(Request $request)
            {
                $objective   =   DB::table('pr_math_objectives')->insertGetId([
                    'lesson_id' => $request->lesson_id,
                    'name'      => $request->objective_name
                ]);
                $log_data =   'Added progress report objective ID '.$objective;
                event(new DatabaseTransactionEvent($log_data));

                return back()->with(['type'=>'success', 'message'=>'New objective has been added!']);
            }

            public function mathObjectivesUpdate(Request $request)
            {
                DB::table('pr_math_objectives')->where('id', $request->id)->update([
                    'name'  => $request->objective_name
                ]);
                $log_data =   'Updated progress report objective ID '.$request->id;
                event(new DatabaseTransactionEvent($log_data));
        
                return back()->with(['type'=>'success', 'message'=>'Objective has been updated!']);
            }

            public function mathObjectivesDestroy($id)
            {
                DB::table('pr_math_objectives')->where('id', $id)->delete();
    
                $log_data =   'Deleted progress report objective ID '.$id;
                event(new DatabaseTransactionEvent($log_data));
    
                return back()->with(['type'=>'success', 'message'=>'Objective has been deleted!']);
            }
        /* Math Objectives */
    /* Settings */
}
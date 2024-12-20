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
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

use function Laravel\Prompts\table;

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
                                    'progress_reports.month',
                                    'programmes.name as programme_name',
                                    'centres.label as centre_name',
                                    'programme_levels.level as programme_level',
                                    'students.id as student_id',
                                    'children.name as student_name',
                                    DB::raw('count(progress_reports.id) as total_class'),
                                    DB::raw('count(CASE WHEN progress_report_details.attendance_status = 1 THEN 1 END) as total_present'), 
                                    DB::raw('count(CASE WHEN progress_report_details.attendance_status = 2 THEN 1 END) as total_absent'), 
                        )
                        // ->whereNull('student_fees.status')
                        ->where('programmes.progress_report_required', 1)
                        ->orderBy('children.name');
                        
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
        // $query->where('students.status', '=', 1);
        
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
                                ->select('students.id', 'children.name as name', 'students.created_at as joined_date', 'programmes.name as programme', 'programme_levels.level as level')
                                ->first();
                                
        /* Math Init Selection */
        $math_terms_books   =   $this->getMathTermBooks($student_info->level);

        /* Coding Init Selection */
        $coding_lessons     =   $this->getCodingLessons($student_info->level);

        /* Digital Art Init Selection */
        $art_themes     =   $this->getArtThemes($student_info->level);

        /* Little Bot Init Selection */
        $little_bot_lessons     =   $this->getLittleBotLessons($student_info->level);

        $attendance_status  =   DB::table('progress_report_status')->get();
        $report_details     =   DB::table('progress_reports')->where('id', $request->progress_report_id)->first();   
        $config_info        =   DB::table('progress_report_configs')->where('id', $report_details->progress_report_config_id)->first();
        $progress_reports   =   DB::table('progress_report_details')
                                    ->join('progress_report_status', 'progress_report_details.attendance_status', '=', 'progress_report_status.id')
                                    ->leftJoin('wpvt_users', 'progress_report_details.teacher_user_id', '=', 'wpvt_users.ID')
                                    ->select('progress_report_details.progress_report_id', 'progress_report_details.id', 'progress_report_details.date', 
                                            'progress_report_details.report_data', 'progress_report_details.comments', 'progress_report_details.attendance_status',
                                            'progress_report_details.revision', 'progress_report_details.teacher_user_id', 'wpvt_users.display_name', 
                                            'progress_report_status.class as attendance_status_class_name', 'progress_report_status.name as attendance_status_name')
                                    ->where('progress_report_id', $request->progress_report_id)->orderBy('progress_report_details.date')->get();
        
        return Inertia::render('ProgressReport/Templates/'.$config_info->vue_template, [
            'progress_report_id'    =>  $request->progress_report_id,
            'report_details'        =>  $report_details,
            'student_info'          =>  $student_info,
            'math_terms_books'      =>  $math_terms_books,
            'coding_lessons'        =>  $coding_lessons,
            'art_themes'            =>  $art_themes,
            'little_bot_lessons'    =>  $little_bot_lessons,
            'progress_reports'      =>  $progress_reports,
            'attendance_status'     =>  $attendance_status,
        ]);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'date'  => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with(['type'=>'error', 'message'=>'Date is required!']);
        }

        $report_data = collect($request->report_data)->map(function ($report) use ($request) {
            if(isset($report['artworks'])){
                $report['artworks'] = collect($report['artworks'])->map(function ($artwork) use ($request, $report) {
                    if (isset($artwork['file'])) {
                        
                        $filename = uniqid() . '_' . str_replace(' ', '_', $artwork['file']->getClientOriginalName());
            
                        Storage::putFileAs('art_gallery', $artwork['file'], $filename);
            
                        DB::table('student_art_gallery')->insert([
                            'report_detail_id' => $request->report_id,
                            'student_id' => $request->student_id,
                            'level_id' => $request->student_level,
                            'theme_id' => $report['theme_id'],
                            'lesson_id' => $report['lesson_id'],
                            'activity_id' => $report['activity_id'],
                            'filename' => $filename,
                            'for_art_book' => $artwork['for_artbook'],
                        ]);
                        unset($artwork['file']);
                        $artwork['filename'] = $filename ?? '';
                    }
                    return $artwork; 
                })->toArray();
            }
            return $report;
        })->toArray();

        if(isset($request->file_to_delete) && count($request->file_to_delete)){
            foreach($request->file_to_delete as $filename){
                Storage::delete('art_gallery/'.$filename);
                DB::table('student_art_gallery')->where('filename', $filename)->delete();
            }
        }

        DB::table('progress_report_details')->where('id', $request->report_id)->update([
            'date'                  => Carbon::parse($request->date)->format('Y-m-d'),
            'report_data'           => json_encode($report_data, JSON_NUMERIC_CHECK),
            'comments'              => $request->comments,
            'attendance_status'     => $request->attendance_status,
            'revision'              => $request->revision,
            'teacher_user_id'       => $request->teacher_user_id,
        ]);
        $log_data =   'Updated progress report ID '.$request->report_id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
    }

    public function storeSummary(Request $request){
        DB::table('progress_reports')->where('id', $request->id)->update([
            'upcoming_feedback' => $request->upcoming_feedback,
            'improvement_feedback' => $request->improvement_feedback,
        ]);

        return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
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
                                            ->select('students.id as student_id', 'children.name as student_name', 'students.date_joined',
                                                    'programmes.name as programme_name', 'programme_levels.level as programme_level', 
                                                    'programme_levels.id as programme_level_id', 'programme_level_fees.id as programme_level_fee_id', 
                                                    'progress_reports.upcoming_feedback', 'progress_reports.improvement_feedback')
                                            ->where('progress_report_details.progress_report_id', $request->progress_report_id)->first();
                                         
        $data['student_data']->date_joined = Carbon::hasFormat($data['student_data']->date_joined, 'Y-m-d') && Carbon::createFromFormat('Y-m-d', $data['student_data']->date_joined)->isValid() ? Carbon::parse($data['student_data']->date_joined)->format('d/m/Y') : 'Not Set';

        $data['report_data']        =   DB::table('progress_reports')
                                            ->join('progress_report_details', 'progress_report_details.progress_report_id', '=', 'progress_reports.id')
                                            ->join('progress_report_status', 'progress_report_details.attendance_status', '=', 'progress_report_status.id')
                                            ->select('progress_report_details.date', 'progress_report_details.report_data', 'progress_report_details.comments', 
                                                    'progress_report_details.revision', 'progress_report_status.name as attendance_status_name')
                                            ->where('progress_reports.student_fee_id', $request->student_fee)->orderBy('progress_report_details.date')->get();
        
        /* For Maths */
        $data['units']              =   DB::table('pr_math_units')
                                            ->join('pr_math_terms_books', 'pr_math_units.term_book_id', '=', 'pr_math_terms_books.id')
                                            ->where('pr_math_terms_books.level_id', $data['student_data']->programme_level)
                                            ->select('pr_math_units.*')
                                            ->get();

        $data['assessments']        =   DB::table('assessments')
                                            ->where('student_id', $data['student_data']->student_id)
                                            ->where('programme_level_fee_id', $data['student_data']->programme_level_fee_id)
                                            ->first();   

        $data['report_template']    =    DB::table('progress_reports')
                                            ->join('progress_report_configs', 'progress_reports.progress_report_config_id', '=', 'progress_report_configs.id')
                                            ->where('progress_reports.id', $request->progress_report_id)->pluck('progress_report_configs.report_template')->first();
                                            
        $pdf = PDF::setPaper('a4', 'portrait')->loadView($data['report_template'], compact('data'));
        return $pdf->stream();
    }

    public function uploadArtwork($data){
        $decrypted_data = json_decode(Crypt::decryptString($data));

        $info['student']    =   DB::table('students')
                                    ->join('children', 'students.children_id', '=', 'children.id')
                                    ->select('children.name')
                                    ->where('students.id', $decrypted_data->student_id)->pluck('children.name')->first();
        $info['theme']      =   DB::table('pr_art_themes')->where('id', $decrypted_data->theme_id)->select('name')->pluck('name')->first();
        $info['lesson']     =   DB::table('pr_art_lessons')->where('id', $decrypted_data->lesson_id)->select('name')->pluck('name')->first();
        $info['activity']   =   DB::table('pr_art_activities')->where('id', $decrypted_data->activity_id)->select('name')->pluck('name')->first();
        $info['encrypted']  =   $data;
        
        return Inertia::render('ProgressReport/UploadArtwork', $info);
    }

    public function storeArtwork(Request $request){
        $decrypted_data = json_decode(Crypt::decryptString($request->encrypted_data));
        
        if(!$request->data){
            return back()->with(['type' => 'error', 'message' => 'Please upload at least 1 (one) artwork.']);
        }
        foreach($request->data as $item){

            if (isset($item['file'])) {
                $file = $item['file'];
                $name = $file->getClientOriginalName();
                $filename = time() . '_' . str_replace(' ', '_', $name);

                Storage::putFileAs('art_gallery',$file, $filename);

                DB::table('student_art_gallery')->insert([
                    'report_detail_id' => $decrypted_data->report_detail_id,
                    'student_id' => $decrypted_data->student_id,
                    'level_id' => $decrypted_data->level,
                    'theme_id' => $decrypted_data->theme_id,
                    'lesson_id' => $decrypted_data->lesson_id,
                    'activity_id' => $decrypted_data->activity_id,
                    'filename' => $filename,
                    'for_art_book' => $item['for_artbook'],
                ]);
            }
        }

        return back()->with(['type' => 'success', 'message' => 'Data has been saved.']);
    }

    public function artworks(Request $request){
        $artworks = DB::table('student_art_gallery')->where('report_detail_id', $request->report_detail_id)->get();

        return $artworks;
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

    /* Little Bot */
    public function getLittleBotLessons($level_id){
        $lessons     =   DB::table('pr_little_bot_lessons')->where('level_id', $level_id)->get();

        return $lessons;
    }

    public function getLittleBotTopics($lesson_id){
        $topics   =   DB::table('pr_little_bot_topics')->where('lesson_id', $lesson_id)->get();

        return $topics;
    }

    public function getLittleBotObjectives($topic_id){
        $objectives   =   DB::table('pr_little_bot_objectives')->where('topic_id', $topic_id)->get();

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
                $log_data =   'Added progress report math level ID '.$level;
                event(new DatabaseTransactionEvent($log_data));

                return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
            }

            public function mathLevelsUpdate(Request $request)
            {
                DB::table('pr_math_levels')->where('id', $request->id)->update([
                    'name'  => $request->level_name
                ]);
                $log_data =   'Updated progress report math level ID '.$request->id;
                event(new DatabaseTransactionEvent($log_data));
        
                return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
            }

            public function mathLevelsDestroy($id)
            {
                DB::table('pr_math_levels')->where('id', $id)->delete();
    
                $log_data =   'Deleted progress report math level ID '.$id;
                event(new DatabaseTransactionEvent($log_data));
    
                return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
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
                $log_data =   'Added progress report math term book ID '.$term_book;
                event(new DatabaseTransactionEvent($log_data));

                return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
            }

            public function mathTermsBooksUpdate(Request $request)
            {
                DB::table('pr_math_terms_books')->where('id', $request->id)->update([
                    'name'  => $request->term_book_name
                ]);
                $log_data =   'Updated progress report math term book ID '.$request->id;
                event(new DatabaseTransactionEvent($log_data));
        
                return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
            }

            public function mathTermsBooksDestroy($id)
            {
                DB::table('pr_math_terms_books')->where('id', $id)->delete();
    
                $log_data =   'Deleted progress report math term book ID '.$id;
                event(new DatabaseTransactionEvent($log_data));
    
                return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
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
                $log_data =   'Added progress report math unit ID '.$unit;
                event(new DatabaseTransactionEvent($log_data));

                return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
            }

            public function mathUnitsUpdate(Request $request)
            {
                DB::table('pr_math_units')->where('id', $request->id)->update([
                    'name'  => $request->unit_name
                ]);
                $log_data =   'Updated progress report math unit ID '.$request->id;
                event(new DatabaseTransactionEvent($log_data));
        
                return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
            }

            public function mathUnitsDestroy($id)
            {
                DB::table('pr_math_units')->where('id', $id)->delete();
    
                $log_data =   'Deleted progress report math unit ID '.$id;
                event(new DatabaseTransactionEvent($log_data));
    
                return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
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
                $log_data =   'Added progress report math lesson ID '.$lesson;
                event(new DatabaseTransactionEvent($log_data));

                return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
            }

            public function mathLessonsUpdate(Request $request)
            {
                DB::table('pr_math_lessons')->where('id', $request->id)->update([
                    'name'  => $request->lesson_name
                ]);
                $log_data =   'Updated progress report math lesson ID '.$request->id;
                event(new DatabaseTransactionEvent($log_data));
        
                return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
            }

            public function mathLessonsDestroy($id)
            {
                DB::table('pr_math_lessons')->where('id', $id)->delete();
    
                $log_data =   'Deleted progress report math lesson ID '.$id;
                event(new DatabaseTransactionEvent($log_data));
    
                return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
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
                $log_data =   'Added progress report math objective ID '.$objective;
                event(new DatabaseTransactionEvent($log_data));

                return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
            }

            public function mathObjectivesUpdate(Request $request)
            {
                DB::table('pr_math_objectives')->where('id', $request->id)->update([
                    'name'  => $request->objective_name
                ]);
                $log_data =   'Updated progress report math objective ID '.$request->id;
                event(new DatabaseTransactionEvent($log_data));
        
                return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
            }

            public function mathObjectivesDestroy($id)
            {
                DB::table('pr_math_objectives')->where('id', $id)->delete();
    
                $log_data =   'Deleted progress report math objective ID '.$id;
                event(new DatabaseTransactionEvent($log_data));
    
                return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
            }
        /* Math Objectives */

        
        
        /* Coding Robotics Levels*/
            public function codingRoboticsLevels(){
                $levels     =   DB::table('pr_coding_levels')->get();
                return Inertia::render('ProgressReport/Settings/CodingRobotics/Levels', [
                    'levels'    =>  $levels
                ]);
            }

            public function codingRoboticsLevelsStore(Request $request)
            {
                $level   =   DB::table('pr_coding_levels')->insertGetId([
                    'name'      => $request->level_name
                ]);
                $log_data =   'Added progress report coding robotics level ID '.$level;
                event(new DatabaseTransactionEvent($log_data));

                return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
            }

            public function codingRoboticsLevelsUpdate(Request $request)
            {
                DB::table('pr_coding_levels')->where('id', $request->id)->update([
                    'name'  => $request->level_name
                ]);
                $log_data =   'Updated progress report coding robotics level ID '.$request->id;
                event(new DatabaseTransactionEvent($log_data));
        
                return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
            }

            public function codingRoboticsLevelsDestroy($id)
            {
                DB::table('pr_coding_levels')->where('id', $id)->delete();

                $log_data =   'Deleted progress report coding robotics level ID '.$id;
                event(new DatabaseTransactionEvent($log_data));

                return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
            }
        /* Coding Robotics Levels */
        
        /* Coding Robotics Lessons*/
            public function codingRoboticsLessons(Request $request){
                $lessons     =   DB::table('pr_coding_lessons')->where('level_id', $request->level_id)->get();
                return Inertia::render('ProgressReport/Settings/CodingRobotics/Lessons', [
                    'level_id'      =>      $request->level_id,
                    'lessons'       =>      $lessons
                ]);
            }

            public function codingRoboticsLessonsStore(Request $request)
            {
                $lesson   =   DB::table('pr_coding_lessons')->insertGetId([
                    'level_id'  =>  $request->level_id,
                    'name'      =>  $request->lesson_name
                ]);
                $log_data =   'Added progress report coding robotics lesson ID '.$lesson;
                event(new DatabaseTransactionEvent($log_data));

                return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
            }

            public function codingRoboticsLessonsUpdate(Request $request)
            {
                DB::table('pr_coding_lessons')->where('id', $request->id)->update([
                    'name'  => $request->lesson_name
                ]);
                $log_data =   'Updated progress report coding robotics lesson ID '.$request->id;
                event(new DatabaseTransactionEvent($log_data));
        
                return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
            }

            public function codingRoboticsLessonsDestroy($id)
            {
                DB::table('pr_coding_lessons')->where('id', $id)->delete();

                $log_data =   'Deleted progress report coding robotics lesson ID '.$id;
                event(new DatabaseTransactionEvent($log_data));

                return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
            }
        /* Coding Robotics Lessons */
        
        /* Coding Robotics Topics*/
            public function codingRoboticsTopics(Request $request){
                $topics     =   DB::table('pr_coding_topics')->where('lesson_id', $request->lesson_id)->get();
                return Inertia::render('ProgressReport/Settings/CodingRobotics/Topics', [
                    'level_id'  =>  $request->level_id,
                    'lesson_id' =>  $request->lesson_id,
                    'topics'   =>  $topics
                ]);
            }

            public function codingRoboticsTopicsStore(Request $request)
            {
                $topic   =   DB::table('pr_coding_topics')->insertGetId([
                    'lesson_id' =>  $request->lesson_id,
                    'name'      =>  $request->topic_name
                ]);
                $log_data =   'Added progress report coding robotics topic ID '.$topic;
                event(new DatabaseTransactionEvent($log_data));

                return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
            }

            public function codingRoboticsTopicsUpdate(Request $request)
            {
                DB::table('pr_coding_topics')->where('id', $request->id)->update([
                    'name'  => $request->topic_name
                ]);
                $log_data =   'Updated progress report coding robotics topic ID '.$request->id;
                event(new DatabaseTransactionEvent($log_data));
        
                return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
            }

            public function codingRoboticsTopicsDestroy($id)
            {
                DB::table('pr_coding_topics')->where('id', $id)->delete();

                $log_data =   'Deleted progress report coding robotics topic ID '.$id;
                event(new DatabaseTransactionEvent($log_data));

                return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
            }
        /* Coding Robotics Topics */
        
        /* Coding Robotics Objectives*/
            public function codingRoboticsObjectives(Request $request){
                $objectives     =   DB::table('pr_coding_objectives')->where('topic_id', $request->topic_id)->get();
                return Inertia::render('ProgressReport/Settings/CodingRobotics/Objectives', [
                    'level_id'      =>  $request->level_id,
                    'lesson_id'     =>  $request->lesson_id,
                    'topic_id'      =>  $request->topic_id,
                    'objectives'    =>  $objectives
                ]);
            }

            public function codingRoboticsObjectivesStore(Request $request)
            {
                $objective   =   DB::table('pr_coding_objectives')->insertGetId([
                    'topic_id'  =>  $request->topic_id,
                    'name'      =>  $request->objective_name
                ]);
                $log_data =   'Added progress report coding robotics objective ID '.$objective;
                event(new DatabaseTransactionEvent($log_data));

                return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
            }

            public function codingRoboticsObjectivesUpdate(Request $request)
            {
                DB::table('pr_coding_objectives')->where('id', $request->id)->update([
                    'name'  => $request->objective_name
                ]);
                $log_data =   'Updated progress report coding robotics objective ID '.$request->id;
                event(new DatabaseTransactionEvent($log_data));
        
                return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
            }

            public function codingRoboticsObjectivesDestroy($id)
            {
                DB::table('pr_coding_objectives')->where('id', $id)->delete();

                $log_data =   'Deleted progress report coding robotics objective ID '.$id;
                event(new DatabaseTransactionEvent($log_data));

                return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
            }
        /* Coding Robotics Objectives */
        
        /* Coding Robotics Activities Procedures*/
            public function codingRoboticsActivitiesProcedures(Request $request){
                $activities_procedures     =   DB::table('pr_coding_activities_procedures')->where('objective_id', $request->objective_id)->get();
                return Inertia::render('ProgressReport/Settings/CodingRobotics/ActivitiesProcedures', [
                    'level_id'              =>  $request->level_id,
                    'lesson_id'             =>  $request->lesson_id,
                    'topic_id'              =>  $request->topic_id,
                    'objective_id'          =>  $request->objective_id,
                    'activities_procedures' =>  $activities_procedures
                ]);
            }

            public function codingRoboticsActivitiesProceduresStore(Request $request)
            {
                $activity_procedure   =   DB::table('pr_coding_activities_procedures')->insertGetId([
                    'objective_id'  =>  $request->objective_id,
                    'name'          =>  $request->activity_procedure_name
                ]);
                $log_data =   'Added progress report coding robotics activity procedure ID '.$activity_procedure;
                event(new DatabaseTransactionEvent($log_data));

                return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
            }

            public function codingRoboticsActivitiesProceduresUpdate(Request $request)
            {
                DB::table('pr_coding_activities_procedures')->where('id', $request->id)->update([
                    'name'  => $request->activity_procedure_name
                ]);
                $log_data =   'Updated progress report coding robotics activity procedure ID '.$request->id;
                event(new DatabaseTransactionEvent($log_data));
        
                return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
            }

            public function codingRoboticsActivitiesProceduresDestroy($id)
            {
                DB::table('pr_coding_activities_procedures')->where('id', $id)->delete();

                $log_data =   'Deleted progress report coding robotics activity procedure ID '.$id;
                event(new DatabaseTransactionEvent($log_data));

                return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
            }
        /* Coding Robotics Activities Procedures */

        
        
        /* Digital Art Levels*/
            public function digitalArtLevels(){
                $levels     =   DB::table('pr_art_levels')->get();
                return Inertia::render('ProgressReport/Settings/DigitalArt/Levels', [
                    'levels'    =>  $levels
                ]);
            }

            public function digitalArtLevelsStore(Request $request)
            {
                $level   =   DB::table('pr_art_levels')->insertGetId([
                    'name'      => $request->level_name
                ]);
                $log_data =   'Added progress report digital art level ID '.$level;
                event(new DatabaseTransactionEvent($log_data));

                return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
            }

            public function digitalArtLevelsUpdate(Request $request)
            {
                DB::table('pr_art_levels')->where('id', $request->id)->update([
                    'name'  => $request->level_name
                ]);
                $log_data =   'Updated progress report digital art level ID '.$request->id;
                event(new DatabaseTransactionEvent($log_data));
        
                return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
            }

            public function digitalArtLevelsDestroy($id)
            {
                DB::table('pr_art_levels')->where('id', $id)->delete();

                $log_data =   'Deleted progress report digital art level ID '.$id;
                event(new DatabaseTransactionEvent($log_data));

                return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
            }
        /* Digital Art Levels */
        
        /* Digital Art Themes*/
            public function digitalArtThemes(Request $request){
                $themes     =   DB::table('pr_art_themes')->where('level_id', $request->level_id)->get();
                return Inertia::render('ProgressReport/Settings/DigitalArt/Themes', [
                    'level_id'      =>      $request->level_id,
                    'themes'       =>      $themes
                ]);
            }

            public function digitalArtThemesStore(Request $request)
            {
                $theme   =   DB::table('pr_art_themes')->insertGetId([
                    'level_id'  =>  $request->level_id,
                    'name'      =>  $request->theme_name
                ]);
                $log_data =   'Added progress report digital art theme ID '.$theme;
                event(new DatabaseTransactionEvent($log_data));

                return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
            }

            public function digitalArtThemesUpdate(Request $request)
            {
                DB::table('pr_art_themes')->where('id', $request->id)->update([
                    'name'  => $request->theme_name
                ]);
                $log_data =   'Updated progress report digital art theme ID '.$request->id;
                event(new DatabaseTransactionEvent($log_data));
        
                return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
            }

            public function digitalArtThemesDestroy($id)
            {
                DB::table('pr_art_themes')->where('id', $id)->delete();

                $log_data =   'Deleted progress report digital art theme ID '.$id;
                event(new DatabaseTransactionEvent($log_data));

                return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
            }
        /* Digital Art Themes */
        
        /* Digital Art Lessons*/
            public function digitalArtLessons(Request $request){
                $lessons     =   DB::table('pr_art_lessons')->where('theme_id', $request->theme_id)->get();
                return Inertia::render('ProgressReport/Settings/DigitalArt/Lessons', [
                    'level_id'      =>      $request->level_id,
                    'theme_id'      =>      $request->theme_id,
                    'lessons'       =>      $lessons
                ]);
            }

            public function digitalArtLessonsStore(Request $request)
            {
                $lesson   =   DB::table('pr_art_lessons')->insertGetId([
                    'theme_id'  =>  $request->theme_id,
                    'name'      =>  $request->lesson_name
                ]);
                $log_data =   'Added progress report digital art lesson ID '.$lesson;
                event(new DatabaseTransactionEvent($log_data));

                return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
            }

            public function digitalArtLessonsUpdate(Request $request)
            {
                DB::table('pr_art_lessons')->where('id', $request->id)->update([
                    'name'  => $request->lesson_name
                ]);
                $log_data =   'Updated progress report digital art lesson ID '.$request->id;
                event(new DatabaseTransactionEvent($log_data));
        
                return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
            }

            public function digitalArtLessonsDestroy($id)
            {
                DB::table('pr_art_lessons')->where('id', $id)->delete();

                $log_data =   'Deleted progress report digital art lesson ID '.$id;
                event(new DatabaseTransactionEvent($log_data));

                return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
            }
        /* Digital Art Lessons */
        
        /* Digital Art Activities*/
            public function digitalArtActivities(Request $request){
                $activities     =   DB::table('pr_art_activities')->where('lesson_id', $request->lesson_id)->get();
                return Inertia::render('ProgressReport/Settings/DigitalArt/Activities', [
                    'level_id'      =>      $request->level_id,
                    'theme_id'      =>      $request->theme_id,
                    'lesson_id'     =>      $request->lesson_id,
                    'activities'    =>      $activities
                ]);
            }

            public function digitalArtActivitiesStore(Request $request)
            {
                $activity   =   DB::table('pr_art_activities')->insertGetId([
                    'lesson_id' =>  $request->lesson_id,
                    'name'      =>  $request->activity_name
                ]);
                $log_data =   'Added progress report digital art activity ID '.$activity;
                event(new DatabaseTransactionEvent($log_data));

                return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
            }

            public function digitalArtActivitiesUpdate(Request $request)
            {
                DB::table('pr_art_activities')->where('id', $request->id)->update([
                    'name'  => $request->activity_name
                ]);
                $log_data =   'Updated progress report digital art activity ID '.$request->id;
                event(new DatabaseTransactionEvent($log_data));
        
                return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
            }

            public function digitalArtActivitiesDestroy($id)
            {
                DB::table('pr_art_activities')->where('id', $id)->delete();

                $log_data =   'Deleted progress report digital art activity ID '.$id;
                event(new DatabaseTransactionEvent($log_data));

                return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
            }
        /* Digital Art Activities */
        
        /* Digital Art Outcomes*/
            public function digitalArtOutcomes(Request $request){
                $outcomes     =   DB::table('pr_art_outcomes')->where('activity_id', $request->activity_id)->get();
                return Inertia::render('ProgressReport/Settings/DigitalArt/Outcomes', [
                    'level_id'      =>      $request->level_id,
                    'theme_id'      =>      $request->theme_id,
                    'lesson_id'     =>      $request->lesson_id,
                    'activity_id'   =>      $request->activity_id,
                    'outcomes'      =>      $outcomes
                ]);
            }

            public function digitalArtOutcomesStore(Request $request)
            {
                $outcome   =   DB::table('pr_art_outcomes')->insertGetId([
                    'activity_id'   =>  $request->activity_id,
                    'name'          =>  $request->outcome_name
                ]);
                $log_data =   'Added progress report digital art outcome ID '.$outcome;
                event(new DatabaseTransactionEvent($log_data));

                return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
            }

            public function digitalArtOutcomesUpdate(Request $request)
            {
                DB::table('pr_art_outcomes')->where('id', $request->id)->update([
                    'name'  => $request->outcome_name
                ]);
                $log_data =   'Updated progress report digital art outcome ID '.$request->id;
                event(new DatabaseTransactionEvent($log_data));
        
                return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
            }

            public function digitalArtOutcomesDestroy($id)
            {
                DB::table('pr_art_outcomes')->where('id', $id)->delete();

                $log_data =   'Deleted progress report digital art outcome ID '.$id;
                event(new DatabaseTransactionEvent($log_data));

                return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
            }
        /* Digital Art Outcomes */
        
        /* Digital Art Objectives*/
            public function digitalArtObjectives(Request $request){
                $objectives     =   DB::table('pr_art_objectives')->where('outcome_id', $request->outcome_id)->get();
                return Inertia::render('ProgressReport/Settings/DigitalArt/Objectives', [
                    'level_id'      =>      $request->level_id,
                    'theme_id'      =>      $request->theme_id,
                    'lesson_id'     =>      $request->lesson_id,
                    'activity_id'   =>      $request->activity_id,
                    'outcome_id'    =>      $request->outcome_id,
                    'objectives'    =>      $objectives
                ]);
            }

            public function digitalArtObjectivesStore(Request $request)
            {
                $objective   =   DB::table('pr_art_objectives')->insertGetId([
                    'outcome_id'    =>  $request->outcome_id,
                    'name'          =>  $request->objective_name
                ]);
                $log_data =   'Added progress report digital art objective ID '.$objective;
                event(new DatabaseTransactionEvent($log_data));

                return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
            }

            public function digitalArtObjectivesUpdate(Request $request)
            {
                DB::table('pr_art_objectives')->where('id', $request->id)->update([
                    'name'  => $request->objective_name
                ]);
                $log_data =   'Updated progress report digital art objective ID '.$request->id;
                event(new DatabaseTransactionEvent($log_data));
        
                return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
            }

            public function digitalArtObjectivesDestroy($id)
            {
                DB::table('pr_art_objectives')->where('id', $id)->delete();

                $log_data =   'Deleted progress report digital art objective ID '.$id;
                event(new DatabaseTransactionEvent($log_data));

                return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
            }
        /* Digital Art Objectives */
        

        /* Little Bot Levels*/
            public function littleBotLevels(){
                $levels     =   DB::table('pr_little_bot_levels')->get();
                return Inertia::render('ProgressReport/Settings/LittleBot/Levels', [
                    'levels'    =>  $levels
                ]);
            }

            public function littleBotLevelsStore(Request $request)
            {
                $level   =   DB::table('pr_little_bot_levels')->insertGetId([
                    'name'      => $request->level_name
                ]);
                $log_data =   'Added progress report little bot level ID '.$level;
                event(new DatabaseTransactionEvent($log_data));

                return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
            }

            public function littleBotLevelsUpdate(Request $request)
            {
                DB::table('pr_little_bot_levels')->where('id', $request->id)->update([
                    'name'  => $request->level_name
                ]);
                $log_data =   'Updated progress report little bot level ID '.$request->id;
                event(new DatabaseTransactionEvent($log_data));
        
                return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
            }

            public function littleBotLevelsDestroy($id)
            {
                DB::table('pr_little_bot_levels')->where('id', $id)->delete();

                $log_data =   'Deleted progress report little bot level ID '.$id;
                event(new DatabaseTransactionEvent($log_data));

                return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
            }
        /* Little Bot Levels */
        
        /* Little Bot Lessons*/
            public function littleBotLessons(Request $request){
                $lessons     =   DB::table('pr_little_bot_lessons')->where('level_id', $request->level_id)->get();
                return Inertia::render('ProgressReport/Settings/LittleBot/Lessons', [
                    'level_id'      =>      $request->level_id,
                    'lessons'       =>      $lessons
                ]);
            }

            public function littleBotLessonsStore(Request $request)
            {
                $lesson   =   DB::table('pr_little_bot_lessons')->insertGetId([
                    'level_id'  =>  $request->level_id,
                    'name'      =>  $request->lesson_name
                ]);
                $log_data =   'Added progress report little bot lesson ID '.$lesson;
                event(new DatabaseTransactionEvent($log_data));

                return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
            }

            public function littleBotLessonsUpdate(Request $request)
            {
                DB::table('pr_little_bot_lessons')->where('id', $request->id)->update([
                    'name'  => $request->lesson_name
                ]);
                $log_data =   'Updated progress report little bot lesson ID '.$request->id;
                event(new DatabaseTransactionEvent($log_data));
        
                return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
            }

            public function littleBotLessonsDestroy($id)
            {
                DB::table('pr_little_bot_lessons')->where('id', $id)->delete();

                $log_data =   'Deleted progress report little bot lesson ID '.$id;
                event(new DatabaseTransactionEvent($log_data));

                return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
            }
        /* Little Bot Lessons */
        
        /* Little Bot Topics*/
            public function littleBotTopics(Request $request){
                $topics     =   DB::table('pr_little_bot_topics')->where('lesson_id', $request->lesson_id)->get();
                return Inertia::render('ProgressReport/Settings/LittleBot/Topics', [
                    'level_id'  =>  $request->level_id,
                    'lesson_id' =>  $request->lesson_id,
                    'topics'   =>  $topics
                ]);
            }

            public function littleBotTopicsStore(Request $request)
            {
                $topic   =   DB::table('pr_little_bot_topics')->insertGetId([
                    'lesson_id' =>  $request->lesson_id,
                    'name'      =>  $request->topic_name
                ]);
                $log_data =   'Added progress report little bot topic ID '.$topic;
                event(new DatabaseTransactionEvent($log_data));

                return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
            }

            public function littleBotTopicsUpdate(Request $request)
            {
                DB::table('pr_little_bot_topics')->where('id', $request->id)->update([
                    'name'  => $request->topic_name
                ]);
                $log_data =   'Updated progress report little bot topic ID '.$request->id;
                event(new DatabaseTransactionEvent($log_data));
        
                return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
            }

            public function littleBotTopicsDestroy($id)
            {
                DB::table('pr_little_bot_topics')->where('id', $id)->delete();

                $log_data =   'Deleted progress report little bot topic ID '.$id;
                event(new DatabaseTransactionEvent($log_data));

                return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
            }
        /* Little Bot Topics */
        
        /* Little Bot Objectives*/
            public function littleBotObjectives(Request $request){
                $objectives     =   DB::table('pr_little_bot_objectives')->where('topic_id', $request->topic_id)->get();
                return Inertia::render('ProgressReport/Settings/LittleBot/Objectives', [
                    'level_id'      =>  $request->level_id,
                    'lesson_id'     =>  $request->lesson_id,
                    'topic_id'      =>  $request->topic_id,
                    'objectives'    =>  $objectives
                ]);
            }

            public function littleBotObjectivesStore(Request $request)
            {
                $objective   =   DB::table('pr_little_bot_objectives')->insertGetId([
                    'topic_id'  =>  $request->topic_id,
                    'name'      =>  $request->objective_name
                ]);
                $log_data =   'Added progress report little bot objective ID '.$objective;
                event(new DatabaseTransactionEvent($log_data));

                return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
            }

            public function littleBotObjectivesUpdate(Request $request)
            {
                DB::table('pr_little_bot_objectives')->where('id', $request->id)->update([
                    'name'  => $request->objective_name
                ]);
                $log_data =   'Updated progress report little bot objective ID '.$request->id;
                event(new DatabaseTransactionEvent($log_data));
        
                return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
            }

            public function littleBotObjectivesDestroy($id)
            {
                DB::table('pr_little_bot_objectives')->where('id', $id)->delete();

                $log_data =   'Deleted progress report little bot objective ID '.$id;
                event(new DatabaseTransactionEvent($log_data));

                return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
            }
        /* Little Bot Objectives */
    /* Settings */

    public function exchange(){
        $info['student_art_gallery']    =   DB::table('student_art_gallery')
                                                ->join('art_levels', 'student_art_gallery.level_id', '=', 'art_levels.id')
                                                ->join('art_themes', 'student_art_gallery.theme_id', '=', 'art_themes.id')
                                                ->join('art_lessons', 'student_art_gallery.lesson_id', '=', 'art_lessons.id')
                                                ->join('art_activities', 'student_art_gallery.activity_id', '=', 'art_activities.id')
                                                ->select(
                                                    'art_levels.name as level_name', 
                                                    'art_themes.name as theme_name', 
                                                    'art_lessons.name as lesson_name', 
                                                    'art_activities.name as activity_name',
                                                    'student_art_gallery.activity_id'
                                                )
                                                ->distinct('student_art_gallery.activity_id')
                                                ->orderBy('art_levels.id')
                                                ->orderBy('art_themes.id')
                                                ->orderBy('art_lessons.id')
                                                ->orderBy('art_activities.id')
                                                ->where('changed', false)
                                                ->get();

        $info['pr_art_activities']      =   DB::table('pr_art_activities')
                                                ->join('pr_art_lessons', 'pr_art_activities.lesson_id', '=', 'pr_art_lessons.id')
                                                ->join('pr_art_themes', 'pr_art_lessons.theme_id', '=', 'pr_art_themes.id')
                                                ->join('pr_art_levels', 'pr_art_themes.level_id', '=', 'pr_art_levels.id')
                                                ->select(
                                                    'pr_art_levels.name as level_name', 
                                                    'pr_art_themes.name as theme_name', 
                                                    'pr_art_lessons.name as lesson_name', 
                                                    'pr_art_activities.name as activity_name',
                                                    'pr_art_activities.id as activity_id'
                                                )
                                                ->orderBy('pr_art_levels.id')
                                                ->orderBy('pr_art_themes.id')
                                                ->orderBy('pr_art_lessons.id')
                                                ->orderBy('pr_art_activities.id')
                                                ->get();
        
        return Inertia::render('ProgressReport/Exchange', $info);
    }
    public function exchangeStore(Request $request){
        if(!count($request->from) || !$request->to){
            return back()->with(['type' => 'error', 'message' => 'Please select both new and old activity to exchange.']);
        }
        DB::table('student_art_gallery')->whereIn('activity_id', $request->from)->update([
            'new_activity_id' => $request->to,
            'changed' => true
        ]);

        return back()->with(['type' => 'success', 'message' => 'Data has been saved.']);
    }
}
<?php

namespace App\Http\Controllers\ProgressReport;

use App\Classes\ProgrammeHelper;
use App\Classes\ProgressReportHelper;
use App\Events\DatabaseTransactionEvent;
use App\Http\Controllers\Controller;
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
        $allowed_centres    =   collect(Inertia::getShared('allowed_centres'))->pluck('ID');

        if($allowed_centres->isEmpty()){
            return back()->with(['type'=>'error', 'message'=>"Sorry, you don't have access to centres. Please contact support to gain access for centres."]);
        }
        $can_access_centre = $allowed_centres->search(function ($value) {
            return $value == request('centre_id');
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
                                    DB::raw("
                                        CASE 
                                            WHEN progress_report_details.date <= CURDATE() 
                                                AND (progress_report_details.attendance_status != 3)
                                                AND (count(progress_reports.id) = count(CASE WHEN progress_report_details.attendance_status = 1 THEN 1 END) + count(CASE WHEN progress_report_details.attendance_status = 2 THEN 1 END))
                                            THEN 1 
                                            ELSE 0 
                                        END as status_complete
                                    ")
                        )
                        ->where('programmes.progress_report_required', 1)
                        ->whereIn('student_fees.centre_id', $allowed_centres)
                        ->when($request->search, function($query) use ($request){
                            $query->where('children.name', 'LIKE', '%'.$request->search.'%');
                        })
                        ->when($request->centre_id, function($query) use ($request){
                            $query->where('student_fees.centre_id', $request->centre_id);
                        })
                        ->when($request->programme_id, function($query) use ($request){
                            $query->where('programmes.id', $request->programme_id);
                        })
                        ->when($request->programme_level, function($query) use ($request){
                            $query->where('programme_levels.level', $request->programme_level);
                        })
                        ->orderBy('children.name');

        if($request->date){
            $query->whereMonth('progress_reports.month', $request->date['month']+1)
                        ->whereYear('progress_reports.month', $request->date['year']);
        }
        else{
            $query->whereYear('progress_reports.month', '=', Carbon::now()->format('Y'))
                ->whereMonth('progress_reports.month', '=', Carbon::now()->format('m'));
        }
        
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

        /* Little Artist Init Selection */
        $little_artist_lessons     =   $this->getLittleArtistLessons($student_info->level);

        /* Art Digital Init Selection */
        $art_digital_themes     =   $this->getArtDigitalThemes($student_info->level);

        /* Art Traditional Init Selection */
        $art_traditional_themes     =   $this->getArtTraditionalThemes($student_info->level);


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
            'progress_report_id'        =>  $request->progress_report_id,
            'report_details'            =>  $report_details,
            'student_info'              =>  $student_info,
            'math_terms_books'          =>  $math_terms_books,
            'coding_lessons'            =>  $coding_lessons,
            'art_themes'                =>  $art_themes,
            'little_bot_lessons'        =>  $little_bot_lessons,
            'little_artist_lessons'     =>  $little_artist_lessons,
            'art_digital_themes'        =>  $art_digital_themes,
            'art_traditional_themes'    =>  $art_traditional_themes,
            'progress_reports'          =>  $progress_reports,
            'attendance_status'         =>  $attendance_status,
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

    /* Little Artist */
    public function getLittleArtistLessons($level_id){
        $lessons     =   DB::table('pr_little_artist_lessons')->where('level_id', $level_id)->get();
        return $lessons;
    }

    public function getLittleArtistOutcomes($lesson_id){
        $outcomes   =   DB::table('pr_little_artist_outcomes')->where('lesson_id', $lesson_id)->get();
        return $outcomes;
    }

    public function getLittleArtistObjectives($outcome_id){
        $objectives   =   DB::table('pr_little_artist_objectives')->where('outcome_id', $outcome_id)->get();
        return $objectives;
    }

    /* Art Digital */
    public function getArtDigitalThemes($level_id){
        $themes     =   DB::table('pr_art_digital_themes')->where('level_id', $level_id)->get();

        return $themes;
    }

    public function getArtDigitalLessons($theme_id){
        $lessons   =   DB::table('pr_art_digital_lessons')->where('theme_id', $theme_id)->get();

        return $lessons;
    }

    public function getArtDigitalActivities($lesson_id){
        $activities   =   DB::table('pr_art_digital_activities')->where('lesson_id', $lesson_id)->get();

        return $activities;
    }

    public function getArtDigitalLearningOutcomes($activity_id){
        $learning_outcomes   =   DB::table('pr_art_digital_outcomes')->where('activity_id', $activity_id)->get();

        return $learning_outcomes;
    }

    public function getArtDigitalObjectives($outcome_id){
        $objectives   =   DB::table('pr_art_traditional_objectives')->where('outcome_id', $outcome_id)->get();

        return $objectives;
    }

    /* Art Traditional */
    public function getArtTraditionalThemes($level_id){
        $themes     =   DB::table('pr_art_traditional_themes')->where('level_id', $level_id)->get();

        return $themes;
    }

    public function getArtTraditionalLessons($theme_id){
        $lessons   =   DB::table('pr_art_traditional_lessons')->where('theme_id', $theme_id)->get();

        return $lessons;
    }

    public function getArtTraditionalActivities($lesson_id){
        $activities   =   DB::table('pr_art_traditional_activities')->where('lesson_id', $lesson_id)->get();

        return $activities;
    }

    public function getArtTraditionalLearningOutcomes($activity_id){
        $learning_outcomes   =   DB::table('pr_art_traditional_outcomes')->where('activity_id', $activity_id)->get();

        return $learning_outcomes;
    }

    public function getArtTraditionalObjectives($outcome_id){
        $objectives   =   DB::table('pr_art_traditional_objectives')->where('outcome_id', $outcome_id)->get();

        return $objectives;
    }

    /* Progress Report Settings */
        public function settings(){
            return Inertia::render('ProgressReport/Settings/Index');
        }
}
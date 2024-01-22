<?php

namespace App\Http\Controllers;

use App\Classes\DiagnosticTestHelper;
use App\Events\DatabaseTransactionEvent;
use App\Mail\DiagnosticTest\ResultToParent;
use App\Mail\DiagnosticTest\ResultToPIC;
use Carbon\Carbon;
use Corcel\Model\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class DiagnosticTestController extends Controller
{
    /* main page */
    public function dtMain(){
        
        // $template               =   auth()->check() ? 'User/Main' : 'Public/Main';
        $template               =   'Public/Main';

        $diagnostic_test_list   =   DB::table('diagnostic_test')->get();
        $languages              =   DB::table('diagnostic_test_languages')->get();
        $ages                   =   DB::table('diagnostic_test_ages')->get();
        $children               =   auth()->check() ?  DB::table('children')->where('parent_id', auth()->user()->ID)->get() : [];

        return Inertia::render('DiagnosticTests/Run/'.$template, [
            'diagnostic_test_list'  => $diagnostic_test_list,
            'languages'             => $languages,
            'ages'                  => $ages,
            'children'              => $children,
        ]);
    }

    /* start */
    public function dtStart(Request $request){

        // $template       =   auth()->check() ? 'User/Start' : 'Public/Start';
        $template       =   'Public/Start';

        // if(auth()->check()){
        //     if(!$request->form_data['child_age'] || $request->form_data['child_age'] == 0){
        //         return redirect(route('diagnostic_test'))->with(['type' => 'error', 'message' => 'Sorry, diagnostic test is not available for this age.']);
        //     }
        // }

        // $age            =   auth()->check() && $request->form_data['child_age'] ? DB::table('diagnostic_test_ages')->where('age', $request->form_data['child_age'])->pluck('id')->first() : $request->form_data['age'];
        $age            =   $request->form_data['age'];
        $dt_id          =   DB::table('diagnostic_test')->where('age_id', $age)->where('language_id', $request->form_data['language'])->pluck('id')->first();
        $final_message  =   DB::table('diagnostic_test_languages')->where('id', $request->form_data['language'])->pluck('final_message')->first();

        if(!$dt_id){
            return back()->with(['type' => 'error', 'message' => 'Sorry, no diagnostic test found for this language.']);
        }

        $dt_details     =   DB::table('diagnostic_test')->where('id', $dt_id)->first();
        $dt_list        =   DB::table('diagnostic_test_questions')->where('dt_id', $dt_id)->orderBy('ordering', 'asc')->get();
        $answers_data   =   DB::table('diagnostic_test_answers')->whereIn('question_id', $dt_list->pluck('id'))->get();

        if(!empty($dt_list)){
            foreach($dt_list as $key=>$dt_info){
                $serialized_answers_data    =   $answers_data->where('question_id', $dt_info->id)->pluck('answer_data')->first();
                $answers_info               =   unserialize($serialized_answers_data);
                $dt_info->answers           =   !empty($answers_info) && array_key_exists('answers', $answers_info) ? $answers_info['answers'] : '';
                $dt_info->correct_answer    =   !empty($answers_info) && array_key_exists('correct_answer', $answers_info) ? $answers_info['correct_answer'] : '';
            }
        }

        $diagnostic_test_categories_label   =   DB::table('diagnostic_test_categories')->where('dt_id', $dt_id)->pluck('name');
        $diagnostic_test_categories         =   DB::table('diagnostic_test_categories')->where('dt_id', $dt_id)->select(['id', 'name'])->orderBy('id')->get();
        $diagnostic_test_chart_info         =   DB::table('diagnostic_test_chart_info')->where('language_id', $request->form_data['language'])->get();

        return Inertia::render('DiagnosticTests/Run/'.$template, [
            'form_data'                         =>  $request->form_data,
            'dt_details'                        =>  $dt_details,
            'final_message'                     =>  $final_message,
            'dt_list'                           =>  $dt_list,
            'dt_id'                             =>  $dt_id,
            'language_id'                       =>  $request->form_data['language'],
            'diagnostic_test_categories_label'  =>  $diagnostic_test_categories_label,
            'diagnostic_test_categories'        =>  $diagnostic_test_categories,
            'diagnostic_test_chart_info'        =>  $diagnostic_test_chart_info
        ]);
    }

    /* get new level */
    public function dtNewLevel(Request $request)
    {
        $new_level_data['category_label']   =   DB::table('diagnostic_test_categories')->where('dt_id', $request->dt_id)->pluck('name');
        $new_level_data['dt_details']       =   DB::table('diagnostic_test')->where('id', $request->dt_id)->first();
        $new_level_data['dt_list']          =   DB::table('diagnostic_test_questions')->where('dt_id', $request->dt_id)->orderBy('ordering', 'asc')->get();
        $answers_data   =   DB::table('diagnostic_test_answers')->whereIn('question_id', $new_level_data['dt_list']->pluck('id'))->get();

        if(!empty($new_level_data['dt_list'])){
            foreach($new_level_data['dt_list'] as $key=>$dt_info){
                $serialized_answers_data    =   $answers_data->where('question_id', $dt_info->id)->pluck('answer_data')->first();
                $answers_info               =   unserialize($serialized_answers_data);
                if(!empty($answers_info)){
                    $dt_info->answers           =   array_key_exists('answers', $answers_info) ? $answers_info['answers'] : '';
                    $dt_info->correct_answer    =   array_key_exists('correct_answer', $answers_info) ? $answers_info['correct_answer'] : '';
                }

            }
        }
        return $new_level_data;
    }

    /* save result */
    public function saveDtResult(Request $request)
    {
        $resultData = [
            'child_id'              => $request->input('student_id'),
            'child_name'            => $request->input('student_name'),
            'child_age'             => $request->input('student_age'),
            'child_school'          => $request->input('student_school'),
            'parent_name'           => $request->input('parent_name'),
            'parent_contact'        => $request->input('parent_contact'),
            'parent_area_location'  => $request->input('parent_area_location'),
            'parent_email'          => $request->input('parent_email'),
            'eligible_level'        => $request->input('eligible_level'),
        ];

        $result_id      =   DB::table('diagnostic_test_result')->insertGetId($resultData);
        $student_age    =   DB::table('diagnostic_test_ages')->where('id', $request->input('student_age'))->pluck('name')->first();

        foreach($request->answer_record as $answer){
            $info['question']               = $answer['question'];
            $info['question_category_id']   = $answer['question_category_id'];
            $info['answer']                 = $answer['answer'];
            $info['correct']                = $answer['correct'];
            $data[$answer['dt_id']][]       = $info;
        }

        $report_titles  =   DB::table('diagnostic_test')->whereIn('id', collect($data)->keys()->all())->select('id', 'name')->get()->keyBy('id');

        foreach($data as $dt_id=>$dt_data){
            $new_report  =   DB::table('diagnostic_test_result_details')->insertGetId([
                'result_id'     => $result_id,
                'dt_id'         => $dt_id,
                'answer_record' => serialize($dt_data),
            ]);
            $reports[] = [
                'name'   => $report_titles[$dt_id]->name,
                'id'     => encrypt($new_report),
            ];
        }

        if(app()->environment('production')){
            /* Send Email to User*/
            $parentNotification = new ResultToParent($reports);
            Mail::to($request->parent_email)->send($parentNotification);
        }
    
        /* Send Email to PIC */
        $emails     =   DiagnosticTestHelper::getPicEmailsByLanguageId($request->input('language_id'));
        if(!empty($emails)){ 
            $users      =   User::whereIn('user_email', $emails)->get();
            foreach ($users as $user) {
                $info    =   [
                    'pic_name'              =>  $user->display_name,
                    'student_name'          =>  $request->student_name,
                    'student_age'           =>  $student_age,
                    'dt_title'              =>  $request->dt_title,
                    'test_date'             =>  Carbon::now()->format('d/m/Y'),
                    'reports'               =>  $reports,
                    'parent_name'           =>  $request->input('parent_name'),
                    'parent_contact'        =>  $request->input('parent_contact'),
                    'parent_area_location'  =>  $request->input('parent_area_location'),
                    'parent_email'          =>  $request->input('parent_email'),
                ];
                $picNotification = new ResultToPIC($info);
                Mail::to($user->user_email)->send($picNotification);
            }
        }

        if($request->input('edu_teacher_email')){
            $edu_teacher      =   User::where('user_email', $emails)->first();
            $info    =   [
                'pic_name'              =>  $edu_teacher->display_name,
                'student_name'          =>  $request->student_name,
                'student_age'           =>  $student_age,
                'dt_title'              =>  $request->dt_title,
                'test_date'             =>  Carbon::now()->format('d/m/Y'),
                'reports'               =>  $reports,
                'parent_name'           =>  $request->input('parent_name'),
                'parent_contact'        =>  $request->input('parent_contact'),
                'parent_area_location'  =>  $request->input('parent_area_location'),
                'parent_email'          =>  $request->input('parent_email'),
            ];
            $picNotification = new ResultToPIC($info);
            Mail::to($edu_teacher->user_email)->send($picNotification);
        }
        return true;
    }

    /* list of saved result */
    public function savedDtResult(Request $request)
    {
        $allowed_centres    =   (object)Inertia::getShared('allowed_centres');
        $allowed_centres->search(function ($value) {
            return $value->ID == request('centre_id');
        });

        $query  =   DB::table('children')
                        ->rightJoin('diagnostic_test_result', 'diagnostic_test_result.child_id', '=', 'children.id')
                        ->leftJoin('diagnostic_test_ages', 'diagnostic_test_result.child_age', '=', 'diagnostic_test_ages.id')
                        ->leftJoin('centres', 'diagnostic_test_result.centre_id', '=', 'centres.ID');

        if($request->search){
            $query->where('child_name', 'LIKE', '%'.$request->search.'%');
        }

        if($request->centre_id){
            $query->where('centre_id', '=', $request->centre_id);
        }

        $query->select(['diagnostic_test_result.id',
                        'diagnostic_test_result.child_id',
                        'diagnostic_test_result.centre_id',
                        'centres.label as centre_name',
                        'diagnostic_test_result.child_name',
                        'diagnostic_test_ages.age as child_age',
                        'diagnostic_test_result.child_school',
                        'diagnostic_test_result.parent_name',
                        'diagnostic_test_result.parent_contact',
                        'diagnostic_test_result.parent_email',
                        'diagnostic_test_result.eligible_level',
                        'diagnostic_test_result.admitted',
                        'diagnostic_test_result.notes',
                        'diagnostic_test_result.eligible_level',
                        'children.name as student_name',
                        'children.date_of_birth as student_dob'])->get();

        return Inertia::render('DiagnosticTests/SavedResults/Index', [
            'filter'        => request()->all('search', 'centre_id'),
            'saved_results'       => $query->paginate(10),
        ]);
    }

    public function deleteDtResult($id){
        DB::table('diagnostic_test_result')->where('id', $id)->delete();

        return back()->with(['type' => 'success', 'message' => 'Record has been deleted successfully.']);
    }
    

    /* saved result details */
    public function savedDtResultDetails(Request $request)
    {
        $answer_record  =   DB::table('diagnostic_test_result_details')
                                ->join('diagnostic_test', 'diagnostic_test_result_details.dt_id', '=', 'diagnostic_test.id')
                                ->where('result_id', $request->result_id)
                                ->select([
                                    'diagnostic_test.id as dt_id',
                                    'diagnostic_test_result_details.id as dt_details_id',
                                    'diagnostic_test.name as dt_name',
                                    'diagnostic_test.chart_id as chart_type',
                                    'diagnostic_test_result_details.answer_record as answer_record',
                                    'diagnostic_test_result_details.created_at',
                                ])->orderBy('diagnostic_test_result_details.id')->paginate(10);

        foreach ($answer_record as $item) {
            $item->dt_details_id = encrypt($item->dt_details_id);
        }

        $answer_collection = collect($answer_record->items());

        $answer_collection->map(function ($answer){
            $answer->answer_record          = unserialize($answer->answer_record);
            $answer->total_correct_answers  = collect($answer->answer_record)->where('correct', true)->count();
            $answer->total_answers          = count($answer->answer_record);
            return $answer;
        });

        $transformedData = $answer_collection->all();
        $paginationData = new LengthAwarePaginator($transformedData, $answer_record->total(), $answer_record->perPage(), $answer_record->currentPage(), ['path' => $answer_record->path()]);

        return Inertia::render('DiagnosticTests/SavedResults/Details', [
            'result_id'     =>  $request->result_id,
            'filter'        =>  request()->all('search'),
            'answer_record' =>  $paginationData
        ]);
    }

    /* save dt status */
    public function saveDtResultStatus(Request $request)
    {
        DB::table('diagnostic_test_result')->where('id', $request->result_id)->update([
            'admitted'      =>  $request->admitted,
            'centre_id'     =>  $request->centre_id,
            'notes'         =>  $request->notes,
            'updated_at'    =>  Carbon::now(),
        ]);

        $log_data =   'Updated DT status ID '.$request->result_id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type' => 'success', 'message' => 'Status has been updated !']);
    }

    /* categories */
    public function getDtCategories(Request $request)
    {
        if($request->chart_type == 1){
            $categories['label']    =   DB::table('diagnostic_test_categories')->where('dt_id', $request->dt_id)->pluck('name');
            $categories['data']     =   DB::table('diagnostic_test_categories')->where('dt_id', $request->dt_id)->select(['id', 'name'])->orderBy('id')->get();

            $language_id            =   DB::table('diagnostic_test')->where('id', $request->dt_id)->pluck('language_id');
            $categories['info']     =   DB::table('diagnostic_test_chart_info')->where('language_id', $language_id)->where('chart_id', $request->chart_type)->get();
        }
        else{
            $categories['label']    =   DB::table('diagnostic_test_categories')->where('dt_id', $request->dt_id)->pluck('name');
            $categories['data']     =   DB::table('diagnostic_test_categories')->where('dt_id', $request->dt_id)->select(['id', 'name'])->orderBy('id')->get();

            $language_id            =   DB::table('diagnostic_test')->where('id', $request->dt_id)->pluck('language_id');
            $categories['info']     =   DB::table('diagnostic_test_chart_info')->where('language_id', $language_id)->where('chart_id', $request->chart_type)->get();
        }

        return $categories;
    }

    /* saved result basic info */
    public function getSavedResultInfo(Request $request)
    {
        $result_info    =   DB::table('diagnostic_test_result')
                                ->join('diagnostic_test_ages', 'diagnostic_test_result.child_age', '=', 'diagnostic_test_ages.id')
                                ->where('diagnostic_test_result.id', $request->result_id)
                                ->select(['diagnostic_test_result.child_name', 'diagnostic_test_ages.name as child_age', 'diagnostic_test_result.created_at'])
                                ->first();
        return $result_info;
    }

    /* Settings */
        /* Diagnostic Test List */
        public function dtList(){
            $languages              =   DiagnosticTestHelper::getLanguages();
            $ages                   =   DiagnosticTestHelper::getAges();
            $diagnostic_test_list   =   DB::table('diagnostic_test')
                                            ->leftJoin('diagnostic_test_languages', 'diagnostic_test.language_id', '=', 'diagnostic_test_languages.id')
                                            ->leftJoin('diagnostic_test_ages', 'diagnostic_test.age_id', '=', 'diagnostic_test_ages.id')
                                            ->select([
                                                'diagnostic_test.id',
                                                'diagnostic_test.name',
                                                'diagnostic_test_ages.name as age',
                                                'diagnostic_test_languages.name as language',
                                            ])
                                            ->when(request('search'), function ($query, $search) {
                                                $query->where('diagnostic_test.name', 'LIKE', '%'.request('search').'%');
                                                // $query->where('diagnostic_test.language_id', request('language_id'));
                                            })
                                            ->when(request('language_id'), function ($query, $search) {
                                                $query->where('diagnostic_test.language_id', request('language_id'));
                                            })
                                            ->when(request('age_id'), function ($query, $search) {
                                                $query->where('diagnostic_test.age_id', request('age_id'));
                                            })
                                            ->orderBy('age_id')
                                            ->paginate(10);

            return Inertia::render('DiagnosticTests/Index', [
                'filter'                => request()->all('search', 'language_id', 'age_id'),
                'languages'             => $languages,
                'ages'                  => $ages,
                'diagnostic_test_list'  => $diagnostic_test_list,
            ]);
        }

        public function dtCreate(){
            $languages      =   DB::table('diagnostic_test_languages')->get();
            $ages           =   DB::table('diagnostic_test_ages')->get();
            $dt_list        =   DB::table('diagnostic_test')
                                    ->join('diagnostic_test_ages', 'diagnostic_test.age_id', '=', 'diagnostic_test_ages.id')
                                    ->select('diagnostic_test.*', DB::raw("CONCAT(diagnostic_test_ages.name, ' - ', diagnostic_test.name) AS name"))
                                    ->get();
            $chart_types    =   DB::table('chart_types')->get();

            return Inertia::render('DiagnosticTests/Create', [
                'dt_list'           => $dt_list,
                'languages'         => $languages,
                'ages'              => $ages,
                'chart_types'       => $chart_types,
            ]);
        }

        public function dtStore(Request $request){
            $request->validate([
                'name'                      => 'required',
                'age'                       => 'required',
                'language'                  => 'required',
                'chart_type'                => 'required',
                'lower_score'               => 'required',
                'higher_score'              => 'required',
            ]);

            $dt_id  =   DB::table('diagnostic_test')->insertGetId([
                'name'                      =>  $request->name,
                'age_id'                    =>  $request->age,
                'language_id'               =>  $request->language,
                'chart_id'                  =>  $request->chart_type,
                'lower_score'               =>  $request->lower_score,
                'lower_score_direction'     =>  $request->lower_score_direction,
                'higher_score'              =>  $request->higher_score,
                'higher_score_direction'    =>  $request->higher_score_direction,
            ]);

            $log_data =   'Added DT ID '.$dt_id;
            event(new DatabaseTransactionEvent($log_data));

            return redirect(route('dt.settings'))->with(['type' => 'success', 'message' => 'New diagnostic test added successfully !']);
        }

        public function dtEdit(Request $request){
            $diagnostic_test_info   =   DB::table('diagnostic_test')->where('id', $request->dt_id)->first();
            $dt_list                =   DB::table('diagnostic_test')
                                            ->join('diagnostic_test_ages', 'diagnostic_test.age_id', '=', 'diagnostic_test_ages.id')
                                            ->select('diagnostic_test.*', DB::raw("CONCAT(diagnostic_test_ages.name, ' - ', diagnostic_test.name) AS name"))
                                            ->get();
            $languages              =   DB::table('diagnostic_test_languages')->get();
            $ages                   =   DB::table('diagnostic_test_ages')->get();
            $chart_types            =   DB::table('chart_types')->get();

            return Inertia::render('DiagnosticTests/Edit', [
                'diagnostic_test_info'  => $diagnostic_test_info,
                'dt_list'               => $dt_list,
                'languages'             => $languages,
                'ages'                  => $ages,
                'chart_types'       => $chart_types,
            ]);
        }

        public function dtUpdate(Request $request){
            $request->validate([
                'name'              => 'required',
                'age'               => 'required',
                'language'          => 'required',
                'chart_type'                => 'required',
                'lower_score'       => 'required',
                'higher_score'      => 'required',
            ]);

            DB::table('diagnostic_test')->where('id', $request->dt_id)->update([
                'name'                      =>  $request->name,
                'age_id'                    =>  $request->age,
                'language_id'               =>  $request->language,
                'chart_id'                  =>  $request->chart_type,
                'lower_score'               =>  $request->lower_score,
                'lower_score_direction'     =>  $request->lower_score_direction,
                'higher_score'              =>  $request->higher_score,
                'higher_score_direction'    =>  $request->higher_score_direction,
                'updated_at'                =>  Carbon::now(),
            ]);

            $log_data =   'Updated DT ID '.$request->dt_id;
            event(new DatabaseTransactionEvent($log_data));

            return redirect(route('dt.settings'))->with(['type' => 'success', 'message' => 'Diagnostic test updated successfully !']);
        }

        public function dtDestroy($dt_id){
            $dt_question_info   =   DB::table('diagnostic_test_questions')
                                        ->join('diagnostic_test_answers', 'diagnostic_test_questions.id', '=', 'diagnostic_test_answers.question_id')
                                        ->where('diagnostic_test_questions.dt_id', $dt_id)->get();

            foreach($dt_question_info as $question_info){

                if($question_info->question_image){
                    if(Storage::exists($question_info->question_image)){
                        Storage::delete($question_info->question_image);
                    }
                }

                $data       =   unserialize($question_info->answer_data);
                $images     =   $data['answers'];


                if($data['question_type'] == 3){
                    foreach($data['answers'] as $answer){
                        if($answer['criterion']['image_name']){
                            if(Storage::exists('diagnostic_test_photo/'.$answer['criterion']['image_name'])){
                                Storage::delete('diagnostic_test_photo/'.$answer['criterion']['image_name']);
                            }
                        }

                        foreach($answer['element']['images'] as $image_name){
                            if(Storage::exists('diagnostic_test_photo/'.$image_name)){
                                Storage::delete('diagnostic_test_photo/'.$image_name);
                            }
                        }
                    }
                }
                else{
                    foreach($images as $image){
                        if($image['image_name']){
                            if(Storage::exists('diagnostic_test_photo/'.$image['image_name'])){
                                Storage::delete('diagnostic_test_photo/'.$image['image_name']);
                            }
                        }
                    }
                }
            }

            DB::table('diagnostic_test_categories')->where('dt_id', $dt_id)->delete();
            DB::table('diagnostic_test_questions')->where('diagnostic_test_questions.dt_id', $dt_id)->delete();
            DB::table('diagnostic_test')->where('id', $dt_id)->delete();

            $log_data =   'Deleted DT ID '.$dt_id;
            event(new DatabaseTransactionEvent($log_data));

            return redirect(route('dt.settings'))->with(['type' => 'success', 'message' => 'Diagnostic deleted successfully !']);
        }

    /* Diagnostic Test Detail List */
        public function dtDetailsList(Request $request){
            if(!DB::table('diagnostic_test')->find($request->dt_id)){
                return abort(404);
            }
            $diagnostic_test_list           =   DB::table('diagnostic_test_questions')->where('dt_id', $request->dt_id)->orderBy('ordering', 'asc')->get();
            $diagnostic_test_categories     =   DB::table('diagnostic_test_categories')->where('dt_id', $request->dt_id)->get();

            return Inertia::render('DiagnosticTests/Details/Index', [
                'diagnostic_test_id'            => $request->dt_id,
                'diagnostic_test_list'          => $diagnostic_test_list,
                'diagnostic_test_categories'    => $diagnostic_test_categories
            ]);
        }

        public function dtDetailsCreate(Request $request){
            $redirect_url                   =   url()->previous();
            $diagnostic_test_list           =   DB::table('diagnostic_test_questions')->where('dt_id', $request->dt_id)->orderBy('ordering', 'asc')->get();
            $diagnostic_test_categories     =   DB::table('diagnostic_test_categories')->where('dt_id', $request->dt_id)->get();

            return Inertia::render('DiagnosticTests/Details/Create', [
                'diagnostic_test_id' => $request->dt_id,
                'diagnostic_test_list' => $diagnostic_test_list,
                'diagnostic_test_categories' => $diagnostic_test_categories,
                'redirect_url' => $redirect_url,
            ]);
        }

        public function dtDetailsStore(Request $request){
            $question_answer_data   =   $request->question_answer_data;

            if(!empty($question_answer_data['answers'])){
                if($request->question_answer_data['question_type'] != 3){
                    $answers_data   =   [];
                    /* Insert image for single choice and multiple choice */
                    foreach($question_answer_data['answers'] as $key=>$data){
                        if(array_key_exists('image_file', $data) && $data['image_file']){
                            Storage::putFileAs('diagnostic_test_photo', $data['image_file'], $data['image_file']->getClientOriginalName());
                        }
                        unset($data['image_file']);
                        $answers_data[]   =  $data;
                    }
                    $question_answer_data['answers'] = $answers_data;
                }
                else{
                    /* Insert image for criterion */
                    foreach($question_answer_data['answers'] as $key=>$data){
                        if(!$data['criterion']['image_name'] && !$data['criterion']['value'] && !$data['element']['value'] && empty($data['element']['images'])){
                            unset($question_answer_data['answers'][$key]);
                        }
                        if(array_key_exists('image_file', $data['criterion']) && $data['criterion']['image_file']){
                            Storage::putFileAs('diagnostic_test_photo', $data['criterion']['image_file'], $data['criterion']['image_file']->getClientOriginalName());
                        }
                        unset($question_answer_data['answers'][$key]['criterion']['image_file']);

                        if(!empty($data['element']['images'])){
                            $saved_images   =   array();
                            /* Insert image for element */
                            foreach($data['element']['images'] as $image_key=>$image){
                                if(array_key_exists('file', $image) && $image['file']){
                                    Storage::putFileAs('diagnostic_test_photo', $image['file'], $image['file']->getClientOriginalName());
                                }
                                unset($question_answer_data['answers'][$key]['element']['images'][$image_key]['file']);
                                $saved_images[]   =  $image;
                            }
                            $data['element']['images']  =   $saved_images;
                        }
                        else{
                            $question_answer_data['answers'][$key]['element']['images'] = array();
                        }
                    }
                }
            }

            $last_inserted_row  =   DB::table('diagnostic_test_questions')->latest('ordering')->first();

            $question_id  =   DB::table('diagnostic_test_questions')->insertGetId([
                'dt_id'             => $request->dt_id,
                'category_id'       => $request->category_id,
                'redirect_yes_id'   => $request->redirect_yes,
                'redirect_no_id'    => $request->redirect_no,
                'question_type'     => $request->question_type,
                'question'          => $request->question,
                'remarks'           => $request->remarks,
                'ordering'          => $last_inserted_row ? $last_inserted_row->ordering + 1 : 1,
            ]);

            DB::table('diagnostic_test_answers')->insertGetId([
                'question_id'   => $question_id,
                'answer_data'   => serialize($question_answer_data),
            ]);

            if($request->file('image_file')){
                $file_path = Storage::putFile('diagnostic_test_photo', $request->file('image_file')[0]);

                DB::table('diagnostic_test_questions')->where('id', $question_id)->update([
                    'question_image'    => $file_path,
                ]);
            }

            $log_data =   'Added DT Question ID '.$question_id;
            event(new DatabaseTransactionEvent($log_data));

            return redirect()->route('dt.settings.details', ['dt_id'=>$request->dt_id])->with(['type' => 'success', 'message' => 'New Item added successfully !']);
        }

        public function dtDetailsEdit(Request $request){
            $test_id                        =   $request->test_id;
            $dt_id                          =   $request->dt_id;
            $diagnostic_test_list           =   DB::table('diagnostic_test_questions')->where('dt_id', $request->dt_id)->orderBy('ordering', 'asc')->get();
            $diagnostic_test_info           =   DB::table('diagnostic_test_questions')->where('id', $request->test_id)->first();
            $diagnostic_test_answers        =   DB::table('diagnostic_test_answers')->where('question_id', $request->test_id)->first();
            $diagnostic_test_categories     =   DB::table('diagnostic_test_categories')->where('dt_id', $request->dt_id)->get();

            return Inertia::render('DiagnosticTests/Details/Edit', [
                'redirect_url'                  => url()->current(),
                'test_id' => $test_id,
                'dt_id' => $dt_id,
                'diagnostic_test_list'          => $diagnostic_test_list,
                'diagnostic_test_info'          => $diagnostic_test_info,
                'diagnostic_test_answers'       => unserialize($diagnostic_test_answers->answer_data),
                'diagnostic_test_categories'    => $diagnostic_test_categories,
            ]);
        }

        public function dtDetailsUpdate(Request $request){
            /* Images to delete */
            if(!empty($request->question_answer_data['images_to_delete'])){
                foreach($request->question_answer_data['images_to_delete'] as $key=>$image){
                    Storage::delete('diagnostic_test_photo/'.$image);
                }
            }

            $question_answer_data   =   $request->question_answer_data;
            if(!empty($question_answer_data['answers'])){
                if($request->question_answer_data['question_type'] != 3){
                    $answers_data   =   [];
                    /* Insert image for single choice and multiple choice */
                    foreach($question_answer_data['answers'] as $key=>$data){
                        if(array_key_exists('image_file', $data) && $data['image_file']){
                            Storage::putFileAs('diagnostic_test_photo', $data['image_file'], $data['image_file']->getClientOriginalName());
                        }
                        unset($data['image_file']);
                        $answers_data[]   =  $data;
                    }

                    /* delete empty array */
                    if(!empty($answers_data)){
                        foreach($answers_data as $key=>$data){
                            if($data['answer'] == null && $data['image_name'] == null){
                                unset($answers_data[$key]);
                            }
                        }
                    }

                    $question_answer_data['answers'] = $answers_data;
                }
                else{
                    /* Insert image for criterion */
                    foreach($question_answer_data['answers'] as $key=>$data){
                        if(array_key_exists('image_file', $data['criterion']) && $data['criterion']['image_file']){
                            Storage::putFileAs('diagnostic_test_photo', $data['criterion']['image_file'], $data['criterion']['image_file']->getClientOriginalName());
                        }
                        unset($question_answer_data['answers'][$key]['criterion']['image_file']);

                        if(!empty($data['element']['images'])){
                            $saved_images   =   array();
                            foreach($data['element']['images'] as $image_key=>$image){
                                if(array_key_exists('file', $image) && $image['file']){
                                    Storage::putFileAs('diagnostic_test_photo', $image['file'], $image['file']->getClientOriginalName());
                                }
                                unset($question_answer_data['answers'][$key]['element']['images'][$image_key]['file']);

                                /* delete criterion empty array */
                                if(!empty($data['element']['images']) && $data['element']['value'] != null){
                                    if($data['element']['value'] == null){
                                        $question_answer_data['answers'][$key]['element']['value'] = '';
                                    }
                                }
                                $saved_images[]   =  $image;
                            }
                            $data['element']['images']  =   $saved_images;
                        }
                        else{
                            $question_answer_data['answers'][$key]['element']['images'] = array();
                        }
                    }
                }
            }

            /* Get question's info */
            $diagnostic_test_info    =   DB::table('diagnostic_test_questions')->where('id', $request->id)->first();

            /* Delete question image */
            if($request->delete_image){
                if(Storage::exists($diagnostic_test_info->question_image)){
                    Storage::delete($diagnostic_test_info->question_image);
                }
                DB::table('diagnostic_test_questions')->where('id', $request->id)->update([
                    'question_image'    => '',
                    'updated_at'        => Carbon::now(),
                ]);
            }

            /* Replace question's image */
            if(!empty($request->file('image_file'))){
                if($diagnostic_test_info->question_image && Storage::exists($diagnostic_test_info->question_image)){
                    Storage::delete($diagnostic_test_info->question_image);
                }

                $file_path = Storage::putFile('diagnostic_test_photo', $request->file('image_file')[0]);

                DB::table('diagnostic_test_questions')->where('id', $request->id)->update([
                    'question_image'    => $file_path,
                    'updated_at'        => Carbon::now(),
                ]);
            }

            /* Update question's info */
            DB::table('diagnostic_test_questions')->where('id', $request->id)->update([
                'category_id'       => $request->category_id,
                'redirect_yes_id'   => $request->redirect_yes,
                'redirect_no_id'    => $request->redirect_no,
                'question_type'     => $request->question_type,
                'question'          => $request->question,
                'remarks'           => $request->remarks,
                'updated_at'        => Carbon::now(),
            ]);

            /* Update question's answers */
            DB::table('diagnostic_test_answers')->where('question_id', $diagnostic_test_info->id)->update([
                'answer_data'   => serialize($question_answer_data),
            ]);

            $log_data =   'Updated DT Question ID '.$request->id;
            event(new DatabaseTransactionEvent($log_data));

            return redirect()->route('dt.settings.details', ['dt_id' => $request->dt_id])->with(['type' => 'success', 'message' => 'Item updated successfully !']);
        }

        public function dtDetailsDestroy($id){

            $diagnostic_test_info    =   DB::table('diagnostic_test_questions')->where('id', $id)->first();

            $dt_answers =   DB::table('diagnostic_test_answers')->where('question_id', $id)->first();
            $data       =   unserialize($dt_answers->answer_data);

            if($data['question_type'] == 3){
                foreach($data['answers'] as $answer){
                    if($answer['criterion']['image_name']){
                        if(Storage::exists('diagnostic_test_photo/'.$answer['criterion']['image_name'])){
                            Storage::delete('diagnostic_test_photo/'.$answer['criterion']['image_name']);
                        }
                    }

                    foreach($answer['element']['images'] as $image_name){
                        if(Storage::exists('diagnostic_test_photo/'.$image_name)){
                            Storage::delete('diagnostic_test_photo/'.$image_name);
                        }
                    }
                }
            }
            else{
                $images     =   $data['answers'];
                foreach($images as $image){
                    if($image['image_name']){
                        if(Storage::exists('diagnostic_test_photo/'.$image['image_name'])){
                            Storage::delete('diagnostic_test_photo/'.$image['image_name']);
                        }
                    }
                }
            }

            DB::table('diagnostic_test_answers')->where('question_id', $id)->delete();
            DB::table('diagnostic_test_questions')->where('id', $id)->delete();

            $log_data =   'Deleted DT Question ID '.$id;
            event(new DatabaseTransactionEvent($log_data));

            return redirect()->route('dt.settings.details', ['dt_id'=>$diagnostic_test_info->dt_id])->with(['type' => 'success', 'message' => 'Item deleted successfully !']);
        }

        public function dtDetailsSort(Request $request){
            foreach($request->sorted_list as $key=>$list){
                DB::table('diagnostic_test_questions')->where('id', $list['id'])->update([
                    'ordering' => $key+1
                ]);
            }

            $log_data =   'Sorted DT Question';
            event(new DatabaseTransactionEvent($log_data));

            return redirect()->back()->with(['type' => 'success', 'message' => 'Item sorted successfully !']);
        }

    /* Diagnostic Test Categories */
        public function dtCategoriesCreate(Request $request){
            return Inertia::render('DiagnosticTests/Categories/Create', [
                'diagnostic_test_id' => $request->dt_id
            ]);
        }

        public function dtCategoriesStore(Request $request){
            $request->validate([
                'category_name'          => 'required',
            ]);

            $category_id    =   DB::table('diagnostic_test_categories')->insertGetId([
                'dt_id' =>  $request->dt_id,
                'name' =>  $request->category_name,
            ]);

            $log_data =   'Added DT category ID '.$category_id;
            event(new DatabaseTransactionEvent($log_data));

            return redirect()->route('dt.settings.details', ['dt_id'=>$request->dt_id])->with(['type' => 'success', 'message' => 'Categories added successfully !']);
        }

        public function dtCategoriesEdit(Request $request){
            $category_info = DB::table('diagnostic_test_categories')->where('id', $request->category_id)->first();

            return Inertia::render('DiagnosticTests/Categories/Edit', [
                'category_info' => $category_info
            ]);
        }

        public function dtCategoriesUpdate(Request $request){
            $request->validate([
                'category_name'          => 'required',
            ]);

            DB::table('diagnostic_test_categories')->where('id', $request->category_id)->update([
                'name'          =>  $request->category_name,
                'updated_at'    =>  Carbon::now(),
            ]);

            $log_data =   'Updated DT category ID '.$request->category_id;
            event(new DatabaseTransactionEvent($log_data));

            return redirect()->route('dt.settings.details', ['dt_id'=>$request->dt_id])->with(['type' => 'success', 'message' => 'Category updated successfully !']);
        }

        public function dtCategoriesDestroy($id){
            $has_record =   DB::table('diagnostic_test_questions')->where('category_id', $id)->exists();

            if($has_record){
                return redirect()->back()->with(['type' => 'error', 'message' => 'This category is being used !']);
            }

            $dtInfo = DB::table('diagnostic_test_categories')->where('id', $id)->first();
            DB::table('diagnostic_test_categories')->where('id', $id)->delete();

            $log_data =   'Deleted DT category ID '.$id;
            event(new DatabaseTransactionEvent($log_data));

            return redirect()->route('dt.settings.details', ['dt_id'=>$dtInfo->dt_id])->with(['type' => 'success', 'message' => 'Category deleted successfully !']);
        }

    /* Diagnostic Test Generate Report */
        public function report($id){
            $result_id      =   decrypt($id);
            $answer_record  =   DB::table('diagnostic_test_result_details')
                                    ->join('diagnostic_test', 'diagnostic_test_result_details.dt_id', '=', 'diagnostic_test.id')
                                    ->join('diagnostic_test_result', 'diagnostic_test_result_details.result_id', '=', 'diagnostic_test_result.id')
                                    ->join('diagnostic_test_ages', 'diagnostic_test_result.child_age', '=', 'diagnostic_test_ages.id')
                                    ->where('diagnostic_test_result_details.id', $result_id)
                                    ->select([
                                        'diagnostic_test.id as dt_id',
                                        'diagnostic_test.name as dt_name',
                                        'diagnostic_test.chart_id as chart_type',
                                        'diagnostic_test_result.child_name as child_name',
                                        'diagnostic_test_ages.name as child_age',
                                        'diagnostic_test_result_details.answer_record as answer_record',
                                        'diagnostic_test_result_details.created_at',
                                    ])->orderBy('diagnostic_test_result_details.id')->first();

            $answer_record->answer_record           =   unserialize($answer_record->answer_record);
            $answer_record->total_correct_answers   =   collect($answer_record->answer_record)->where('correct', true)->count();
            $answer_record->total_answers           =   count($answer_record->answer_record);

            return Inertia::render('DiagnosticTests/SavedResults/Report', [
                'result_id'     =>  $result_id,
                'answer_record' =>  $answer_record
            ]);
        }

    /***************  settings *****************/
    /* language list */
    public function dtLanguages(){
        $languages  =   DB::table('diagnostic_test_languages')->paginate(10);

        return Inertia::render('DiagnosticTests/Settings/Index', [
            'languages' =>  $languages
        ]);
    }

    /* save language */
    public function dtLanguagesStore(Request $request){
        $request->validate([
            'name'              =>  'required',
            'guideline_header'  =>  'required',
            'guideline_body'    =>  'required',
            'final_message'     =>  'required',
        ]);

        try {
            DB::beginTransaction();

            $language_id    =   DB::table('diagnostic_test_languages')->insertGetId([
                'name'              =>  $request->name,
                'guideline_header'  =>  $request->guideline_header,
                'guideline_body'    =>  $request->guideline_body,
                'final_message'     =>  $request->final_message,
            ]);
            
            if (!empty($request->pic_emails)) {
            
                $emailsToInsert = [];
            
                foreach ($request->pic_emails as $pic) {
                    $emailsToInsert[] = [
                        'language_id'   => $language_id,
                        'email'         => $pic['email'],
                    ];
                }
            
                if (!empty($emailsToInsert)) {
                    DB::table('diagnostic_test_emails')->insert($emailsToInsert);
                }
            }

            DB::commit();
            return back()->with(['type'=>'success', 'message'=>'Added new language successfully!']);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with(['type'=>'error', 'message'=>'An error has occurred!']);
        }
    }

    public function dtLanguagesEdit(Request $request){
        $data['language_info']  =   DB::table('diagnostic_test_languages')->where('id', $request->language_id)->first();
        $data['pic_emails']     =   DB::table('diagnostic_test_emails')->where('language_id', $request->language_id)->select('email')->get();

        return $data;
    }

    /* update language */
    public function dtLanguagesUpdate(Request $request){
        $request->validate([
            'name'              =>  'required',
            'guideline_header'  =>  'required',
            'guideline_body'    =>  'required',
            'final_message'     =>  'required',
        ]);

        try {
            DB::beginTransaction();

            DB::table('diagnostic_test_languages')->where('id', $request->id)->update([
                'name'              =>  $request->name,
                'guideline_header'  =>  $request->guideline_header,
                'guideline_body'    =>  $request->guideline_body,
                'final_message'     =>  $request->final_message,
            ]);

            DB::table('diagnostic_test_emails')->where('language_id', $request->id)->delete();
            
            if (!empty($request->pic_emails)) {
            
                $emailsToInsert = [];
            
                foreach ($request->pic_emails as $pic) {
                    $emailsToInsert[] = [
                        'language_id'   => $request->id,
                        'email'         => $pic['email'],
                    ];
                }
            
                if (!empty($emailsToInsert)) {
                    DB::table('diagnostic_test_emails')->insert($emailsToInsert);
                }
            }

            DB::commit();
            return back()->with(['type'=>'success', 'message'=>'Updated language successfully!']);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with(['type'=>'error', 'message'=>'An error has occurred!']);
        }
    }
    /* delete language */
    public function dtLanguagesDestroy($id){
        try {
            DB::beginTransaction();

            DB::table('diagnostic_test_languages')
                ->join('diagnostic_test_emails', 'diagnostic_test_emails.language_id', '=', 'diagnostic_test_languages.id')
                ->where('diagnostic_test_languages.id', $id)
                ->delete();

            DB::commit();
            return back()->with(['type'=>'success', 'message'=>'Deleted language successfully!']);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with(['type'=>'error', 'message'=>'Cannot proceed, this language is being used!']);
        }
    }
}

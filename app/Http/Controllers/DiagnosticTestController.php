<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class DiagnosticTestController extends Controller
{

    /* Diagnostic Test Run */
    public function dtMain(){
        
        // $template               =   auth()->check() ? 'User/Main' : 'Public/Main';
        $template               =   'Public/Main';
        
        $diagnostic_test_list   =   DB::table('diagnostic_test')->get();
        $languages              =   DB::table('languages')->get();
        $ages                   =   DB::table('diagnostic_test_ages')->get();
        $children               =   auth()->check() ?  DB::table('children')->where('parent_id', auth()->user()->ID)->get() : [];

        return Inertia::render('DiagnosticTests/Run/'.$template, [
            'diagnostic_test_list'  => $diagnostic_test_list,
            'languages'             => $languages,
            'ages'                  => $ages,
            'children'              => $children,
        ]);
    }

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
        
        return Inertia::render('DiagnosticTests/Run/'.$template, [
            'form_data' =>  $request->form_data,
            'dt_details'   =>  $dt_details,
            'dt_list'   =>  $dt_list,
            'dt_id'     =>  $dt_id,
            'diagnostic_test_categories_label'     =>  $diagnostic_test_categories_label,
            'diagnostic_test_categories'     =>  $diagnostic_test_categories
        ]);
    }

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

    public function saveDtResult(Request $request)
    {  
        $result_id  =   DB::table('diagnostic_test_result')->insertGetId([
            // 'user_id'           =>  auth()->check() ? auth()->user()->ID : NULL,
            'child_id'          =>  auth()->check() ? $request->student_id : NULL,
            'child_name'        =>  $request->student_name ? $request->student_name : NULL,
            'child_age'         =>  $request->student_age ? $request->student_age : NULL,
            'child_school'      =>  $request->student_school ? $request->student_school : NULL,
            'parent_name'       =>  $request->parent_name ? $request->parent_name : NULL,
            'parent_contact'    =>  $request->parent_contact ? $request->parent_contact : NULL,
            'parent_address'    =>  $request->parent_address ? $request->parent_address : NULL,
            'parent_email'      =>  $request->parent_email ? $request->parent_email : NULL,
            'eligible_level'    =>  $request->eligible_level ? $request->eligible_level : NULL,
        ]);

        $data = array();
        foreach($request->answer_record as $answer){
            $info['question']           = $answer['question'];
            $info['correct']            = $answer['correct'];
            $data[$answer['dt_id']][]   = $info;
        }

        foreach($data as $dt_id=>$dt_data){
            DB::table('diagnostic_test_result_details')->insert([
                'result_id' => $result_id,
                'dt_id' => $dt_id,
                'answer_record' => serialize($dt_data),
            ]);
        }
        return true;

    }

    public function savedDtResult(Request $request)
    {
        $allowed_centres    =   (object)Inertia::getShared('allowed_centres');
        $allowed_centres->search(function ($value) {
            return $value->ID == request('centre_id');
        });

        $query  =   DB::table('wpvt_10_wlsm_student_records')
                        ->rightJoin('diagnostic_test_result', 'diagnostic_test_result.child_id', '=', 'wpvt_10_wlsm_student_records.user_id')
                        ->leftJoin('diagnostic_test_ages', 'diagnostic_test_result.child_age', '=', 'diagnostic_test_ages.id')
                        ->leftJoin('wpvt_10_wlsm_schools', 'diagnostic_test_result.centre_id', '=', 'wpvt_10_wlsm_schools.ID');

        if($request->search){
            $query->where('child_name', 'LIKE', '%'.$request->search.'%');
        }
        
        if($request->centre_id){
            $query->where('centre_id', '=', $request->centre_id);
        }

        $query->select(['diagnostic_test_result.id', 
                        'diagnostic_test_result.child_id', 
                        'diagnostic_test_result.centre_id', 
                        'wpvt_10_wlsm_schools.label as centre_name', 
                        'diagnostic_test_result.child_name', 
                        'diagnostic_test_ages.age as child_age', 
                        'diagnostic_test_result.child_school', 
                        'diagnostic_test_result.parent_name', 
                        'diagnostic_test_result.parent_contact', 
                        'diagnostic_test_result.parent_address', 
                        'diagnostic_test_result.parent_email', 
                        'diagnostic_test_result.eligible_level', 
                        'diagnostic_test_result.admitted', 
                        'diagnostic_test_result.notes', 
                        'diagnostic_test_result.eligible_level', 
                        'wpvt_10_wlsm_student_records.name as student_name', 
                        'wpvt_10_wlsm_student_records.dob as student_dob'])->get();

        return Inertia::render('DiagnosticTests/SavedResults/Index', [
            'filter'        => request()->all('search', 'centre_id'),
            'saved_results'       => $query->paginate(10),
        ]);
    }

    public function saveDtResultStatus(Request $request)
    {
        DB::table('diagnostic_test_result')->where('id', $request->result_id)->update([
            'admitted'      =>  $request->admitted,
            'centre_id'     =>  $request->centre_id,
            'notes'         =>  $request->notes,
            'updated_at'    =>  Carbon::now(),
        ]);

        return back()->with(['type' => 'success', 'message' => 'Status has been updated !']);
    }

    public function savedDtResultDetails(Request $request)
    {
        $answer_record  =   DB::table('diagnostic_test_result_details')
                                ->join('diagnostic_test', 'diagnostic_test_result_details.dt_id', '=', 'diagnostic_test.id')
                                ->where('result_id', $request->result_id)
                                ->select([
                                    'diagnostic_test.id as dt_id',
                                    'diagnostic_test.name as dt_name',
                                    'diagnostic_test.chart_id as chart_type',
                                    'diagnostic_test_result_details.answer_record as answer_record',
                                    'diagnostic_test_result_details.created_at',
                                ])->orderBy('diagnostic_test_result_details.id')->paginate(10);

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

    public function getDtCategories(Request $request)
    {
        if($request->chart_type == 1){
            $categories['label']    =   DB::table('diagnostic_test_categories')->where('dt_id', $request->dt_id)->pluck('name');
            $categories['data']     =   DB::table('diagnostic_test_categories')->where('dt_id', $request->dt_id)->select(['id', 'name'])->orderBy('id')->get();
        }
        else{
            $categories['label']    =   DB::table('diagnostic_test_categories')->where('dt_id', $request->dt_id)->pluck('name');
            $categories['data']     =   DB::table('diagnostic_test_categories')->where('dt_id', $request->dt_id)->select(['id', 'name'])->orderBy('id')->get();
        }

        return $categories;
    }

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
            $diagnostic_test_list   =   DB::table('diagnostic_test')
                                            ->join('languages', 'diagnostic_test.language_id', '=', 'languages.id')
                                            ->join('diagnostic_test_ages', 'diagnostic_test.age_id', '=', 'diagnostic_test_ages.id')
                                            ->select([
                                                'diagnostic_test.id',
                                                'diagnostic_test.name',
                                                'diagnostic_test_ages.name as age',
                                                'languages.name as language',
                                            ])
                                            ->paginate(10);

            return Inertia::render('DiagnosticTests/Index', [
                'diagnostic_test_list' => $diagnostic_test_list,
            ]);
        }

        public function dtCreate(){
            $languages      =   DB::table('languages')->get();
            $ages           =   DB::table('diagnostic_test_ages')->get();
            $dt_list        =   DB::table('diagnostic_test')->get();
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
                'final_message'             => 'required',
            ]);
            
            DB::table('diagnostic_test')->insert([
                'name'                      =>  $request->name,
                'age_id'                    =>  $request->age,
                'language_id'               =>  $request->language,
                'chart_id'                  =>  $request->chart_type,
                'lower_score'               =>  $request->lower_score,
                'lower_score_direction'     =>  $request->lower_score_direction,
                'higher_score'              =>  $request->higher_score,
                'higher_score_direction'    =>  $request->higher_score_direction,
                'final_message'             =>  $request->final_message,
            ]);

            return redirect(route('dt.settings'))->with(['type' => 'success', 'message' => 'New diagnostic test added successfully !']);
        }

        public function dtEdit(Request $request){
            $diagnostic_test_info   =   DB::table('diagnostic_test')->where('id', $request->dt_id)->first();
            $dt_list                =   DB::table('diagnostic_test')->get();
            $languages              =   DB::table('languages')->get();
            $ages                   =   DB::table('diagnostic_test_ages')->get();
            $chart_types    =   DB::table('chart_types')->get();
            
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
                'final_message'     => 'required',
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
                'final_message'             =>  $request->final_message,
                'updated_at'                =>  Carbon::now(),
            ]);
            
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

            return redirect()->route('dt.settings.details', ['dt_id'=>$diagnostic_test_info->dt_id])->with(['type' => 'success', 'message' => 'Item deleted successfully !']);
        }

        public function dtDetailsSort(Request $request){
            foreach($request->sorted_list as $key=>$list){
                DB::table('diagnostic_test_questions')->where('id', $list['id'])->update([
                    'ordering' => $key+1
                ]);
            }

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

            DB::table('diagnostic_test_categories')->insert([
                'dt_id' =>  $request->dt_id,
                'name' =>  $request->category_name,
            ]);

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

            return redirect()->route('dt.settings.details', ['dt_id'=>$request->dt_id])->with(['type' => 'success', 'message' => 'Category updated successfully !']);
        }

        public function dtCategoriesDestroy($id){
            $has_record =   DB::table('diagnostic_test_questions')->where('category_id', $id)->exists();

            if($has_record){
                return redirect()->back()->with(['type' => 'error', 'message' => 'This category is being used !']);
            }

            $dtInfo = DB::table('diagnostic_test_categories')->where('id', $id)->first();
            DB::table('diagnostic_test_categories')->where('id', $id)->delete();

            return redirect()->route('dt.settings.details', ['dt_id'=>$dtInfo->dt_id])->with(['type' => 'success', 'message' => 'Category deleted successfully !']);
        }
}

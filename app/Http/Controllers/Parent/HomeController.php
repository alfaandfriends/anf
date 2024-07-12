<?php

namespace App\Http\Controllers\Parent;

use App\Classes\CentreHelper;
use App\Classes\ClassHelper;
use App\Classes\ProgrammeHelper;
use App\Classes\StoryHelper;
use App\Classes\StudentHelper;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as FacadesDB;
use Inertia\Inertia;
use PDO;

class HomeController extends Controller
{
    public function onboarding()
    {
        if(auth()->user()->profile_updated){
            return redirect(route('parent.home'));
        }

        $countries = FacadesDB::table('countries')->get();

        return Inertia::render('Parent/Onboard', [
            'countries' => $countries
        ]);
    }

    public function index(Request $request)
    {
        $can    =   Inertia::getShared('can');
        if(isset($can['view_student_stories'])){
            $centres        =   CentreHelper::getUserCentres(auth()->user()->user_country_id);
    
            if($centres->isEmpty()){
                return back()->with(['type'=>'error', 'message'=>"Sorry, you don't have access to centres. Please contact support to gain access for centres."]);
            }
    
            if(count($centres) < 1){
                $can_access_centre  =   $centres->where('ID', $request->centre_id)->isNotEmpty();
                
                if(!$can_access_centre){
                    return back()->with(['type'=>'error', 'message'=>"Sorry, you don't have access to centres. Please contact support to gain access for centres."]);
                }
            }
            
            $programmes     =   ProgrammeHelper::programmes(auth()->user()->user_country_id);   
            $class_types    =   ClassHelper::getClassTypes();
            $stories        =   StoryHelper::getStories();
        }
        else{
            $stories    =   StoryHelper::getStudentStories(false, false);
        }

        return Inertia::render('Parent/Home',[
            'academics'     =>  $academics ?? '',
            'stories'       =>  $stories ?? [],
            'programmes'    =>  $programmes ?? [],
            'centres'       =>  $centres ?? [],
            'class_types'   =>  $class_types ?? [],
        ]);
    }

    public function switchChild(Request $request){
        $child_session_data =   [
            'child_id'      =>  $request->child_id, 
            'child_name'    =>  $request->child_name, 
            'student_id'    =>  $request->student_id
        ]; 
        $request->session()->put('current_active_child', $child_session_data);

        return true;
    }
}

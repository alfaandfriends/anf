<?php

namespace App\Http\Controllers\Parent;

use App\Classes\StoryHelper;
use App\Classes\StudentHelper;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as FacadesDB;
use Inertia\Inertia;

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
        $stories          =   StoryHelper::getStudentStories();

        return Inertia::render('Parent/Home',[
            'academics' =>  $academics ?? '',
            'stories'   =>  $stories ?? [],
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

<?php

namespace App\Http\Controllers;

use App\Classes\CentreHelper;
use App\Classes\ClassHelper;
use App\Classes\ProgrammeHelper;
use App\Classes\StoryHelper;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StoryController extends Controller
{
    public function index(Request $request)
    {   
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
        $stories        =   StoryHelper::getStories($request->centre_id, $request->programme_id);

        return Inertia::render('Stories/Index',[
            'filter'        =>  request()->all('search', 'centre_id', 'theme', 'status'),
            'programmes'    =>  $programmes,
            'centres'       =>  $centres,
            'class_types'   =>  $class_types,
            'stories'       =>  $stories,
            'themes'        =>  [],
            'arts'          =>  [],
        ]);
    }
}

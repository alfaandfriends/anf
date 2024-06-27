<?php

namespace App\Http\Controllers;

use App\Classes\CentreHelper;
use App\Classes\ProgrammeHelper;
use App\Classes\StoryHelper;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StoryController extends Controller
{
    public function index(Request $request)
    {   
        $allowed_centres    =   collect(Inertia::getShared('allowed_centres'));

        if($allowed_centres->isEmpty()){
            return back()->with(['type'=>'error', 'message'=>"Sorry, you don't have access to centres. Please contact support to gain access for centres."]);
        }

        if($request->centre_id){
            $can_access_centre  =   $allowed_centres->where('ID', $request->centre_id)->isNotEmpty();
            
            if(!$can_access_centre){
                return back()->with(['type'=>'error', 'message'=>"Sorry, you don't have access to centres. Please contact support to gain access for centres."]);
            }
        }

        $programmes =   ProgrammeHelper::programmes();
        $stories    =   StoryHelper::getStories($request->centre_id, $request->programme_id);

        return Inertia::render('Stories/Index',[
            'filter'        =>  request()->all('search', 'centre_id', 'theme', 'status'),
            'programmes'    =>  $programmes,
            'stories'       =>  $stories,
            'themes'        =>  [],
            'arts'          =>  [],
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Classes\CentreHelper;
use App\Classes\ProgrammeHelper;
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
        

        if($request->centre_id){
            $centre_info    =   CentreHelper::getCentreInfo($request->centre_id);
            // dd($centre_info['centre_country_id']);
            ProgrammeHelper::programmes($centre_info['centre_country_id']);
        }

        return Inertia::render('Stories/Index',[
            'filter'        =>  request()->all('search', 'centre_id', 'theme', 'status'),
            // 'programmes'    =>  $programmes,
            'themes'        =>  [],
            'arts'          =>  [],
        ]);
    }
}

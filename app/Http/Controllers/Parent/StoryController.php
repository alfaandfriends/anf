<?php

namespace App\Http\Controllers\Parent;

use App\Classes\StoryHelper;
use App\Http\Controllers\Controller;
use Hashids\Hashids;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StoryController extends Controller
{
    public function index(Request $request){
        
        $hashids = new Hashids('', 10);
        $programme_id   =   $hashids->decode($request->segment(2));

        if(count($programme_id) < 1){
            return redirect(route('parent.home'))->with(['type' => 'error', 'message' => 'Unable to fetch class data']);
        }

        $programme_info =   DB::table('programmes')->where('id', $programme_id[0])->first();
        
        /* Set selected programme session */
        session([
            'current_active_programme' => [
                'id'            => $programme_info->id, 
                'encrypted_id'  => $request->segment(2), 
                'name'          => $programme_info->name
            ]
        ]);

        $student_id     =   $request->session()->get('current_active_child.student_id');
        
        $posts          =   StoryHelper::getPosts($student_id);

        return Inertia::render('Parent/Class/Index', [
            'current_active_programme'    =>  session('current_active_programme'),
            'posts'                       =>  $posts ?? []
        ]);
    }
}

<?php

namespace App\Http\Controllers\Parent;

use App\Classes\PostHelper;
use App\Http\Controllers\Controller;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ProgressReportController extends Controller
{
    public function index(Request $request){
        
        $hashids = new Hashids('', 10);
        $programme_id   =   $hashids->decode($request->segment(2));

        if(count($programme_id) < 1){
            return redirect(route('parent.home'))->with(['type' => 'error', 'message' => 'Unable to fetch class data']);
        }
        
        $student_id     =   $request->session()->get('current_active_child.student_id');
        
        $posts          =   PostHelper::getPosts($student_id);
        $programme_info =   DB::table('programmes')->where('id', $programme_id[0])->first();

        return Inertia::render('Parent/Class/ProgressReports', [
            'programme_info'    => $programme_info,
            'programme_id'      => $request->segment(2),
            'posts'             => $posts ?? []
        ]);
    }
}

<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ClassController extends Controller
{
    public function index(Request $request){
        
        $hashids = new Hashids('', 10);
        $programme_id   =   $hashids->decode($request->segment(2));

        if(count($programme_id) < 1){
            return back()->with(['type' => 'error', 'message' => 'Unable to fetch class data']);
        }
        
        $programme_info =   DB::table('programmes')->where('id', $programme_id[0])->first();

        return Inertia::render('Parent/Class/Index', [
            'programme_info' => $programme_info
        ]);
    }
}

<?php

namespace App\Http\Controllers\Parent;

use App\Classes\ArtBookHelper;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Str;

class ArtBookController extends Controller
{
    public function index()
    {
        $levels     =   ArtBookHelper::getLevels();

        return Inertia::render('Parent/ArtBook/Index',[
            'levels'    =>  $levels,
        ]);
    }

    public function generate(Request $request){
        
        $image_condition    =   DB::table('art_book_conditions')->where('theme_id', $request->theme_id)->get();

        $data['image_1']    =   DB::table('student_art_gallery')
                                    ->where('theme_id', $request->theme_id)
                                    ->where('lesson_id', $image_condition->where('artwork_number', 1)->pluck('lesson_id')->first())
                                    ->where('activity_id', $image_condition->where('artwork_number', 1)->pluck('activity_id')->first())
                                    ->where('student_id', $request->student_id)
                                    ->pluck('filename')
                                    ->first();
                            
        $data['image_2']    =   DB::table('student_art_gallery')
                                    ->where('theme_id', $request->theme_id)
                                    ->where('lesson_id', $image_condition->where('artwork_number', 2)->pluck('lesson_id')->first())
                                    ->where('activity_id', $image_condition->where('artwork_number', 2)->pluck('activity_id')->first())
                                    ->where('student_id', $request->student_id)
                                    ->pluck('filename')
                                    ->first();

        
        $data['image_3']    =   DB::table('student_art_gallery')
                                    ->where('theme_id', $request->theme_id)
                                    ->where('lesson_id', $image_condition->where('artwork_number', 3)->pluck('lesson_id')->first())
                                    ->where('activity_id', $image_condition->where('artwork_number', 3)->pluck('activity_id')->first())
                                    ->where('student_id', $request->student_id)
                                    ->pluck('filename')
                                    ->first();
                            
        $data['image_4']    =   DB::table('student_art_gallery')
                                    ->where('theme_id', $request->theme_id)
                                    ->where('lesson_id', $image_condition->where('artwork_number', 4)->pluck('lesson_id')->first())
                                    ->where('activity_id', $image_condition->where('artwork_number', 4)->pluck('activity_id')->first())
                                    ->where('student_id', $request->student_id)
                                    ->pluck('filename')
                                    ->first();
                                    
        $data['name']   =   Str::headline($request->student_nickname);
        $folder         =   DB::table('art_themes')->where('id', $request->theme_id)->pluck('art_book_assets')->first();
        
        $pdf = PDF::setPaper(array(0,0,648,576))
                    ->setOption('fontDir', public_path('/fonts'))
                    ->loadView($folder.'template', compact('data'));
        return $pdf->stream();
    }
}

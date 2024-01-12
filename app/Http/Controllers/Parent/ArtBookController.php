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
        $data['name']   =   Str::headline($request->student_nickname);
        $folder         =   DB::table('art_themes')->where('id', $request->theme_id)->pluck('art_book_assets')->first();
        
        $pdf = PDF::setPaper(array(0,0,648,576))
                    ->setOption('fontDir', public_path('/fonts'))
                    ->loadView($folder.'template', compact('data'));
        return $pdf->stream();
    }
}

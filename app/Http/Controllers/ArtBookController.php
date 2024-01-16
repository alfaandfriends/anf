<?php

namespace App\Http\Controllers;

use App\Classes\ArtBookHelper;
use App\Http\Controllers\Parent\ArtGalleryController;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Str;

class ArtBookController extends Controller
{

    public function index()
    {
        $artbooks     =   DB::table('art_themes')
                            ->join('art_levels', 'art_themes.level_id', '=', 'art_levels.id')
                            ->select('art_levels.name as level_name', 'art_themes.*')
                            ->get()
                            ->groupBy('level_name')
                            ->toArray();

        return Inertia::render('ArtBook/Index',[
            'artbooks'    =>  $artbooks,
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

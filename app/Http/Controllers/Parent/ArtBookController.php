<?php

namespace App\Http\Controllers\Parent;

use App\Classes\ArtBookHelper;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

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
        $data['name']   =   'Hoo Lee Shet';
        $pdf = PDF::setPaper(array(0,0,648,576))
                    ->setOption('fontDir', public_path('/images/artbook/fonts'))
                    ->loadView('artbooks.level_1.artventure_to_the_beach.template', compact('data'));
        return $pdf->stream();
    }
}

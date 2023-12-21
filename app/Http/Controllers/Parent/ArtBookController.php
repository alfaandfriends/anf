<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ArtBookController extends Controller
{
    public function index()
    {
        $themes     =   DB::table('art_themes')->where('level_id', 1)->get();

        return Inertia::render('Parent/ArtBook/Index',[
            'themes'    =>  $themes
        ]);
    }
}

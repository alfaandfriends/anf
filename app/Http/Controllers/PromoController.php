<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PromoController extends Controller
{
    public function index(){
        $promo_list  =   DB::table('promos')->paginate(10);
        return Inertia::render('Promos/Index', [
            'promo_list' => $promo_list
        ]);
    }
    public function create(){
        return Inertia::render('Promos/Create');
    }
}

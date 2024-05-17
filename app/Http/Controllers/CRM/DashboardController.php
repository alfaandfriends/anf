<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Centre;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('CRM/Dashboard',[
        ]);
    }
}

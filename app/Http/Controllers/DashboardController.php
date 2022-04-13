<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Corcel\Model\User;
use Inertia\Inertia;
use App\Models\Centre;

class DashboardController extends Controller
{
    public function index()
    {
        $total_user = User::count();
        $total_school = Centre::count();

        return Inertia::render('Dashboard',[
            'total_user'=>$total_user,
            'total_school'=>$total_school,
        ]);
    }
}

<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Corcel\Model\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function create()
    {
        $user_info = User::where('ID', auth()->user()->ID)->first();
        
        return Inertia::render('Parent/Profile', [
            'user_info' => $user_info
        ]);
    }
}

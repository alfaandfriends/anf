<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Corcel\Model\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        Auth::check();
        $users = User::orderBy('id')->paginate(5);
        // dd($users);
            
        return Inertia::render('User/Index', [
            'users' => $users
        ]);
    }
}

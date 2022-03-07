<?php

namespace App\Http\Controllers;

use Corcel\Model\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        // dd(request()->al);
        $query  =   User::query();
        
        if(request('search')){
            $query  ->where('user_email', 'LIKE', '%'.request('search').'%')
                    ->orWhere('display_name', 'LIKE', '%'.request('search').'%');
        }

        return Inertia::render('User/Index', [
            'user_list' => $query->orderBy('id')->paginate(10),
            'filter'=>request()->all('search')
        ]);
    }
}

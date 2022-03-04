<?php

namespace App\Http\Controllers;

use Corcel\Model\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $query  =   User::query();
        
        if(request('search')){
            $query  ->where('user_email', 'LIKE', '%'.request('search').'%')
                    ->orWhere('display_name', 'LIKE', '%'.request('search').'%');
        }

        if(request('page')){
            $query  ->paginate(10, ['*'], request('page'));
        }

        return Inertia::render('User/Index', [
            'user_list' => $query->orderBy('id')->paginate(10)
        ]);
    }

    // public function search_user(Request $request)
    // {
    //     dd($request->page, $request->term);
    //     return Inertia::render('User/Index', [
    //         'user_list' => 
    //     ]);
    // }
}

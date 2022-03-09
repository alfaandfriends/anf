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

        return Inertia::render('Users/Index', [
            'user_list' => $query->orderBy('id')->paginate(10),
            'filter'=>request()->all('search')
        ]);
    }

    public function destroy(){
        return Inertia::render('Components/ConfirmationModal');
    }
}

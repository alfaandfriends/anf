<?php

namespace App\Http\Controllers;

use Corcel\Model\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function index()
    {
        $query  =   User::query();
        
        if(request('search')){
            $query  ->where('user_email', 'LIKE', '%'.request('search').'%')
                    ->orWhere('display_name', 'LIKE', '%'.request('search').'%');
        }

        $results    =   $query->orderBy('id')->paginate(10);

        return Inertia::render('Users/Index', [
            'filter'=>request()->all('search'),
            'user_list' => $results,
        ]);
    }

    public function destroy($user_id){
        User::where('ID', $user_id)->delete();

        return redirect()->back()->with(['type'=>'success', 'message'=>'User deleted successfully !']);
    }
}

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

        $user_data  =   array();
        foreach($results as $key=>$user){
            $url            =   env('APP_URL');
            $response       =   Http::get($url.'/wp-json/anf-custom-api/v1/roles/get_role_by_user_id/'.$user->ID);
            $user_data[]    =   (array)json_decode($response->getBody()->getContents());
        }
        dd($user_data);

        // $url        =   env('APP_URL');
        // $response   =   Http::get($url.'/wp-json/anf-custom-api/v1/roles');
        // $roles      =   (array)json_decode($response->getBody()->getContents());

        //     dd($roles);
        // $available_role         =   array();
        // $serialized_role        =   array();
        // $count                  =   0;

        // foreach($roles as $role_id=>$role){
        //     $available_role[$count][$role_id]     =   true;
        //     $serialized_role[]              =   serialize($available_role[$count]);
        //     $count++;
        // }

        return Inertia::render('Users/Index', [
            'filter'=>request()->all('search'),
            'user_list' => $results,
            // 'roles' => $roles,
        ]);
    }
}

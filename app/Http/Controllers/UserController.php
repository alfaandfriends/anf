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

        $results     =   $query->orderBy('id')->paginate(10);

        // foreach($results as $result){
            // dd($results);
            // foreach($result->meta as $meta){
            // }
        // }

        $url        =   env('APP_URL');
        $response   =   Http::get($url.'/wp-json/anf-custom-api/v1/roles');
        $roles      =   (array)json_decode($response->getBody()->getContents());
        $serialized_role            =   array();
        foreach($roles as $role_id=>$role){
            $serialized_id          =   serialize($role_id);

            // $info[$serialized_id]   =   true;
            // $info[$serialized_id]['role_name']      =   $role;

            $serialized_role[][$serialized_id]      =   true;
        }
        dd($serialized_role);

        return Inertia::render('Users/Index', [
            'filter'=>request()->all('search'),
            'user_list' => $results,
            'roles' => $roles,
        ]);
    }
}

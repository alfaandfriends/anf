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

        
        // $url        =   env('APP_URL');
        // $response   =   Http::get($url.'/wp-json/anf-custom-api/v1/roles');
        // $role_list      =   (array)json_decode($response->getBody()->getContents());

        /* get user role */
        // $user_role  =   array();
        // foreach($results as $result){
        //     foreach($result->meta as $meta){
        //         if($meta->meta_key == 'wpvt_capabilities'){
        //             $roles   =    unserialize($meta->meta_value);
        //             foreach($roles as $role_id=>$role){
        //                 if(isset($role_list[$role_id])){
        //                     $role_name[$role_id]      =   $role_list[$role_id];
        //                 }
        //             }
        //         }
        //     }
        //     $user_role[$result->ID]     =   $role_name;
        // }

        return Inertia::render('Users/Index', [
            'filter'=>request()->all('search'),
            'user_list' => $results,
            // 'user_role' => $user_role,
            // 'role_list' => $role_list,
        ]);
    }
}

<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class RoleController extends Controller
{   
    public function get_roles(){
        $url        =   env('APP_URL');
        $response   =   Http::get($url.'/wp-json/anf-custom-api/v1/roles');
        $roles      =   $response->getBody()->getContents();
        // dd($roles);
        return Inertia::render('Roles/Index', [
            'roles' => $roles
        ]);
    }
}

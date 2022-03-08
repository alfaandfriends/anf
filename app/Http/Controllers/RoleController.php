<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use Illuminate\Http\Request;

class RoleController extends Controller
{   
    public function getRoles(){
        $url        =   env('APP_URL');
        $response   =   Http::get($url.'/wp-json/anf-custom-api/v1/roles');
        $roles      =   json_decode($response->getBody()->getContents());

        return Inertia::render('Roles/Index', [
            'roles' => $roles
        ]);
    }

    public function getRolesByRoleName($request)
    {
        $url        =   env('APP_URL');
        $response   =   Http::get($url.'/wp-json/anf-custom-api/v1/roles/'.$request);
        $roles      =   json_decode($response->getBody()->getContents());
        dd($roles);
    }
}

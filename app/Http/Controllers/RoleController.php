<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class RoleController extends Controller
{   
    public function index(){
        $url        =   env('APP_URL');
        $response   =   Http::get($url.'/wp-json/anf-custom-api/v1/roles');
        $roles      =   json_decode($response->getBody()->getContents());

        return Inertia::render('Roles/Index', [
            'roles' => $roles
        ]);
    }

    public function create(){
        return Inertia::render('Roles/Create');
    }

    public function store(Request $request){
        
        $request->validate([
            'role'      => 'required|max:20',
            'role_name' => 'required|max:50',
        ]);

        $url        =   env('APP_URL');
        $response    =   Http::post($url.'/wp-json/anf-custom-api/v1/roles/add_role', [
            'role'          =>  $request->role,
            'role_name'     =>  $request->role_name,
        ]);
        
        return Redirect::route('roles');
    }

    public function destroy(Request $request){
        dd($request);
    }
}

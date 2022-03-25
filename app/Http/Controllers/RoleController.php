<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class RoleController extends Controller
{   
    public function index(){
        $roles  =  Role::get();
        
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

        DB::table('roles')->insert([
            'role' => $request->role,
            'name' => $request->role_name,
            'status' => $request->status
        ]);
        
        return redirect('roles')->with(['type'=>'success', 'message'=>'Role added successfully !']);
    }

    public function edit(Request $request){
        $roles      =   Role::where('role', $request->role)->first();

        return Inertia::render('Roles/Edit', [
            'roles' => $roles
        ]);
    }

    public function update(Request $request){
        $request->validate([
            'name' => 'required|max:50',
        ]);

        DB::table('roles')
            ->where('role', $request->role)
            ->update(['name' => $request->name, 'status' => $request->status]);

        return redirect('roles')->with(['type'=>'success', 'message'=>'Role updated successfully !']);
    }

    public function destroy($id){
        DB::table('roles')->where('role', $id)->delete();
        
        return redirect('roles')->with(['type'=>'success', 'message'=>'Role deleted successfully !']);
    }
}

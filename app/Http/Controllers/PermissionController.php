<?php

namespace App\Http\Controllers;

use App\Models\RoleHasPermissions;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index(){
        $permissions  =  Permission::get();
        
        return Inertia::render('Permissions/Index', [
            'permissions' => $permissions
        ]);
    }

    public function create(){
        return Inertia::render('Permissions/Create');
    }

    public function store(Request $request){

        $request->validate([
            'permission'          => 'required|max:255',
        ]);

        Permission::create(['name' => $request->permission, 'status' => $request->status]);
        
        return redirect('permissions')->with(['type'=>'success', 'message'=>'Permission added successfully !']);
    }

    public function edit(Request $request){
        $permission      =   Permission::where('id', $request->permission)->first();

        return Inertia::render('Permissions/Edit', [
            'permission_id' => $request->permission,
            'permission' => $permission
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'permission' => 'required|max:50',
        ]);
        
        DB::table('permissions')
            ->where('id', $request->permission_id)
            ->update(['name' => $request->permission, 'status' => $request->status]);

        return redirect('permissions')->with(['type'=>'success', 'message'=>'Permission updated successfully !']);
    }

    public function destroy($id){

        DB::table('permissions')->where('id', $id)->delete();
        RoleHasPermissions::where('permission_id', $id)->delete();
        
        return redirect('permissions')->with(['type'=>'success', 'message'=>'Permission deleted successfully !']);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\RoleHasPermissions;
use App\Models\User;
use App\Models\UserHasRoles;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleController extends Controller

{   
    public function index(){
        $roles          =   DB::table('roles')
                            ->join('role_groups', 'roles.role_group_id', '=', 'role_groups.id')
                            ->select([
                                'roles.id',
                                'roles.name',
                                'roles.display_name',
                                'roles.status',
                                'role_groups.id as role_group_id',
                                'role_groups.name as role_group_name',
                            ])->get();
        
        return Inertia::render('Roles/Index', [
            'roles'         => $roles,
        ]);
    }

    public function create(){
        $role_groups    =   DB::table('role_groups')->get();
        return Inertia::render('Roles/Create', [
            'role_groups'   => $role_groups
        ]);
    }

    public function store(Request $request){
        
        $request->validate([
            'display_name'  => 'required|max:50',
            'role_group'    => 'required',
        ]);

        DB::table('roles')->insert([
            'display_name' => $request->display_name, 
            'role_group_id' => $request->role_group, 
            'status' => $request->status
        ]);
        
        return redirect(route('roles'))->with(['type'=>'success', 'message'=>'Role added successfully !']);
    }

    public function edit(Request $request){
        $roles          =   DB::table('roles')
                            ->join('role_groups', 'roles.role_group_id', '=', 'role_groups.id')
                            ->select([
                                'roles.id',
                                'roles.name',
                                'roles.display_name',
                                'roles.status',
                                'role_groups.id as role_group_id',
                                'role_groups.name as role_group_name',
                            ])->where('roles.id', $request->role_id)->first();
        $role_groups    =   DB::table('role_groups')->get();

        return Inertia::render('Roles/Edit', [
            'roles' => $roles,
            'role_groups'   => $role_groups
        ]);
    }

    public function update(Request $request){

        $request->validate([
            'role'          => 'required|max:20',
            'display_name'  => 'required|max:50',
            'role_group'    => 'required',
        ]);

        DB::table('roles')
            ->where('name', $request->name)
            ->update([
                'display_name'  => $request->display_name, 
                'status'        => $request->status, 
                'updated_at'    => Carbon::now()
            ]);

        return redirect(route('roles'))->with(['type'=>'success', 'message'=>'Role updated successfully !']);
    }

    public function destroy($id){
        
        DB::table('roles')->where('id', $id)->delete();
        UserHasRoles::where('role_id', $id)->delete();
        
        return redirect(route('roles'))->with(['type'=>'success', 'message'=>'Role deleted successfully !']);
    }

    public function assignPermissions(Request $request)
    {
        $permissions_arr            =   Permission::where('status', true)->where('parent_id', null)->get();
        $sub_permissions_arr        =   Permission::where('status', true)->where('parent_id', '!=', null)->get();

        foreach($permissions_arr as $permission_key=>$permission){
            $permissions[$permission_key]   =   $permission;
            $permission_sub                 =   array();
            foreach($sub_permissions_arr as $sub_permission_key=>$sub_permission){
                if($sub_permission->parent_id == $permission->id){
                    $permission_sub[] =   $sub_permission;
                }
            }
            $permissions[$permission_key]['permission_sub']     = [];
            $permissions[$permission_key]['permission_sub']     = $permission_sub;
        }
        $role_permissions   =   RoleHasPermissions::where('role_id', $request->role_id)->get('permission_id')->keyBy('permission_id');

        return Inertia::render('Roles/AssignPermissions', [
            'role_id' => $request->role_id,
            'permissions' => $permissions,
            'role_permissions' => $role_permissions,
        ]);
    }

    public function assignPermissionsStore(Request $request)
    {
        RoleHasPermissions::where('role_id', $request->role_id)->delete();

        foreach($request->selected_permissions as $key=>$permission_id){
            DB::table('role_has_permissions')->insert([
                'role_id'       =>  $request->role_id,
                'permission_id' =>  $permission_id,
            ]);
        }

        return redirect(route('roles'))->with(['type'=>'success', 'message'=>'Permissions assigned successfully !']);

    }
}

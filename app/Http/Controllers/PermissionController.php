<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\RoleHasPermissions;
use App\Models\SubPermission;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    public function index(){
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

        $permission =   Permission::create([
                                        'name'      => $request->permission, 
                                        'status'    => $request->status
                                    ]);

        foreach($request->sub_permission as $key=>$data){
            Permission::insert([
                            'parent_id'     => $permission->id,
                            'name'          => $data,
                        ]);
        }
        
        return redirect(route('permissions'))->with(['type'=>'success', 'message'=>'Permission added successfully !']);
    }

    public function edit(Request $request){
        $permission_info        =   Permission::where('id', $request->permission_id)->first();
        $sub_permissions        =   collect(Permission::where('parent_id', $request->permission_id)->select(['id', 'name'])->get())->toArray();
        
        return Inertia::render('Permissions/Edit', [
            'permission_id'     => $request->permission_id,
            'permission_info'   => $permission_info,
            'sub_permissions'   => $sub_permissions,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'permission' => 'required|max:255',
        ]);
        
        DB::table('permissions')
            ->where('id', $request->permission_id)
            ->update(['name' => $request->permission, 'updated_at' => Carbon::now()]);

        if(!empty($request->add_sub_permission)){
            foreach($request->add_sub_permission as $key=>$data){
                Permission::insert([
                                'parent_id'     => $request->permission_id,
                                'name'          => $data['name'],
                            ]);
            }
        }

        if(!empty($request->delete_sub_permission)){
            foreach($request->delete_sub_permission as $key=>$id){
                Permission::where('id', $id)->delete();
            }
        }

        return redirect(route('permissions'))->with(['type'=>'success', 'message'=>'Permission updated successfully !']);
    }

    public function destroy($id){

        Permission::where('id', $id)->orWhere('parent_id', $id)->delete();
        RoleHasPermissions::where('permission_id', $id)->delete();
        
        return redirect(route('permissions'))->with(['type'=>'success', 'message'=>'Permission deleted successfully !']);
    }
}

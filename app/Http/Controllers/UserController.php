<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\UserHasRoles;
use Corcel\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $query  =   User::query();
        
        if(request('search')){
            $query  ->where('user_email', 'LIKE', '%'.request('search').'%')
                    ->orWhere('display_name', 'LIKE', '%'.request('search').'%');
        }
        $results    =   $query->with('user_has_role.role')->orderBy('id')->paginate(10);
        // dd($results);

        $user_has_role  =   UserHasRoles::get()->keyBy('user_id');
        $role_list      =   Role::get()->keyBy('id');

        return Inertia::render('Users/Index', [
            'filter'=>request()->all('search'),
            'user_list' => $results,
            'user_has_role' => $user_has_role,
            'role_list' => $role_list,
        ]);
    }

    public function assignRoles(Request $request)
    {
        $roles      =   Role::get();
        $user_roles =   UserHasRoles::where('user_id', $request->user_id)->get('role_id')->keyBy('role_id');

        return Inertia::render('Users/AssignRoles', [
            'user_id' => $request->user_id,
            'roles' => $roles,
            'user_roles' => $user_roles,
        ]);
    }

    public function assignRolesStore(Request $request)
    {
        UserHasRoles::where('user_id', $request->user_id)->delete();

        foreach($request->selected_roles as $key=>$role_id){
            DB::table('user_has_roles')->insert([
                'user_id'   =>  $request->user_id,
                'role_id'   =>  $role_id
            ]);
        }

        return redirect('users')->with(['type'=>'success', 'message'=>'Roles assigned successfully !']);

    }

    public function destroy($user_id){
        User::where('ID', $user_id)->delete();

        return redirect()->back()->with(['type'=>'success', 'message'=>'User deleted successfully !']);
    }
}

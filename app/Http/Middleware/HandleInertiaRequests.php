<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Models\Menu;
use App\Models\RoleHasPermissions;
use App\Models\UserHasRoles;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        if($request->user()){
            /* get user permissions */
            $user_roles =   collect(UserHasRoles::where('user_id', $request->user()->ID)->get('role_id'));
            $roles      =   RoleHasPermissions::with('permission')->whereIn('role_id', $user_roles)->get();
    
            foreach($roles as $key=>$role){
                $can[$role->permission->name] = true;
            }
        }
        
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
                'role' => $request->user()->role ?? ''
            ],
            'flash' => [
                'type' => fn () => $request->session()->get('type'),
                'message' => fn () => $request->session()->get('message')
            ],
            'menu' => Menu::getAllMenu(),
            'can' => $can ?? ''
        ]);
    }
}

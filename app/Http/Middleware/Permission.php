<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $permissions)
    {   
        // $profile_updated    = Inertia::getShared('auth.profile_updated');
        // if(!$profile_updated && !in_array(Route::currentRouteName(), ['profile', 'profile.store', 'profile.store.security.store'])){
        //     return redirect('profile');
        // }

        $user_permissions   = Inertia::getShared('can');
        $permissions =   explode('|', $permissions);
        foreach($permissions as $key=>$permission){
            if(array_key_exists($permission, $user_permissions)){
                return $next($request);
            }
        }

        return abort(401);
    }
}

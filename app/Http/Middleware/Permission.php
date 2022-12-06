<?php

namespace App\Http\Middleware;

use App\Models\Menu;
use App\Models\Role;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
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
        $user_permissions = Inertia::getShared('can');
        $permissions =   explode('|', $permissions);
        
        foreach($permissions as $key=>$permission){
            if(array_key_exists($permission, $user_permissions)){
                return $next($request);
            }
        }
        return abort(401);
    }
}

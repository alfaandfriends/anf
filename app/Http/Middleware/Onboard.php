<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;

class Onboard
{
    public function handle(Request $request, Closure $next)
    {
        if(!auth()->user()->profile_updated){
            return redirect('onboarding');
        }

        return $next($request);
    }
}
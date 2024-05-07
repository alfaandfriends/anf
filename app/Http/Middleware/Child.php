<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;

class Child
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $children               =   collect(Inertia::getShared('user_has_children'));
        
        $child_session_data = [
            'child_id'   => '',
            'child_name' => '',
            'student_id' => '',
        ];
        
        if (count($children) > 0) {
            $existingSessionData = $request->session()->get('current_active_child', []);
            if (!isset($existingSessionData['child_id']) || !$children->contains('child_id', $existingSessionData['child_id']) || empty($existingSessionData) || $existingSessionData['child_id'] === '') {
                $child_session_data = [
                    'child_id'   => $children->pluck('child_id')->first(),
                    'child_name' => $children->pluck('child_name')->first(),
                    'student_id' => $children->pluck('student_id')->first(),
                ];
            } 
            else {
                $child_session_data = $existingSessionData;
            }
        }
        
        $request->session()->put('current_active_child', $child_session_data);
        Inertia::share('current_active_child', $child_session_data);

        return $next($request);
    }
}

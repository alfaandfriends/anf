<?php

namespace App\Http\Middleware;

use Closure;
use Jenssegers\Agent\Agent;

class CheckDeviceType
{
    public function handle($request, Closure $next)
    {
        $agent = new Agent();

        // Check if the user is using a mobile device
        if ($agent->isMobile() || $agent->isTablet()) {
            // You can customize the response or redirect as needed
            return abort(503, 'Mobile / tablet view is currently disabled. Please use desktop to access.');
        }

        return $next($request);
    }
}
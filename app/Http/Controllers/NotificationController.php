<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications  =   DB::table('notifications')
                                ->join('notification_types', 'notifications.type', '=', 'notification_types.id')
                                ->whereIn('notifications.role_to_notify', Inertia::getShared('user_has_roles'))
                                ->orWhere('notifications.user_to_notify', Auth()->ID())
                                // ->select(['']);
                                ->get();
        // dd($notifications);
        return Inertia::render('Notifications/Index', [
            'notifications' => $notifications
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Classes\NotificationHelper;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NotificationController extends Controller
{

    public function index(Request $request)
    {   
        if(!$request->filter || $request->filter == 'all'){
            $filter =   array();
        }

        if($request->filter == 'unread'){
            $filter['column']   =   'seen';
            $filter['data']     =   0;
        }

        if($request->filter == 'read'){
            $filter['column']   =   'seen';
            $filter['data']     =   1;
        }

        $notifications = NotificationHelper::getNotificationsWithFilter($filter);
        
        return Inertia::render('Admin/Notifications/Index', [
            'notifications' => $notifications,
        ]);
    }

    public function viewNotification(Request $request)
    {
        $filter['data_count'] = $request->data_count != null && $request->data_count != 0 ? $request->data_count : 10;

        $notification_seen  =   NotificationHelper::checkIfNotificationSeen($request->id);

        if($notification_seen === null){
            return redirect()->route('notifications')->with(["type"=>"warning", "message"=>"Something's went wrong, please try again"]);
        }

        if(!$notification_seen){
            NotificationHelper::setNotificationSeen($request->id);
        }

        $notification_data  =   NotificationHelper::getNotificationDataByID($request->id);
        
        if(empty($notification_data)){
            return redirect()->route('notifications');
        }

        $user_notifications =   NotificationHelper::getCurrentUserNotifications();
        
        if($user_notifications->contains($request->id)){
            return Inertia::render('Admin/Notifications/Templates/'.$notification_data->template_path, [
                'user_has_notifications'    => count(collect(Inertia::getShared('user_notifications'))->where('seen', 0)) > 0 ? true : false,
                'user_notifications'        => Inertia::getShared('user_notifications'),
                'notifications'             => NotificationHelper::getNotificationsWithFilter($filter),
                'notification_data'         => NotificationHelper::getNotificationDataByID($request->id),
                'request_data'              => unserialize($notification_data->data),
                'created_by'                => $notification_data->created_by,
            ]);
        }

        return redirect(route('notifications'));
    }

    public function showMoreNotifications(Request $request)
    {
        if($request->data_count){
            $filter['data_count']   =   $request->data_count;
            $more_notifications     =   NotificationHelper::getNotificationsWithFilter($filter);
            return $more_notifications;
        }
    }

    
    

    
}

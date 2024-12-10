<?php

namespace App\Classes;

// use App\PusherHelpers;   
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Events\Approval;
use App\Events\Notifications;

class NotificationHelper {

    public static function getNotificationsWithFilter($filter = [])
    {
        $page_count     =   array_key_exists('data_count', $filter) && $filter['data_count'] != 0 ? $filter['data_count'] : 10;
        $query          =   DB::table('notifications')
                                ->join('notification_config_data', 'notifications.notification_config_data_id', '=', 'notification_config_data.id')
                                ->join('wpvt_users', 'notifications.created_by', '=', 'wpvt_users.id')
                                ->where(function($query){
                                    return $query
                                    ->whereIn('notifications.role_to_notify', Inertia::getShared('user_has_roles'))
                                    ->orWhere('notifications.user_to_notify', Auth()->ID());
                                })
                                ->select(['notifications.id', 
                                          'wpvt_users.display_name as sender', 
                                          'notification_config_data.notification_message as message', 
                                          'notifications.created_at',
                                          'notifications.seen'])
                                ->orderByDesc('id');
        if(array_key_exists('column', $filter) && $filter['column'] != ''){
            $query->where($filter['column'], $filter['data']);
        }
        
        $notifications  =   $query->paginate($page_count)->items();
        
        return $notifications;
    }

    public static function getNotificationDataByID($notification_id)
    {
        $notification_data  =   DB::table('notifications')
                                    ->join('notification_config_data', 'notifications.notification_config_data_id', '=', 'notification_config_data.id')
                                    ->where('notifications.id', $notification_id)
                                    ->select(['notifications.id', 'notifications.data', 'notifications.seen', 'notifications.created_at', 'notifications.created_by', 'notification_config_data.template_path'])
                                    ->first();

        return $notification_data;
    }

    public static function checkIfNotificationSeen($notification_id)
    {   
        $seen    =   DB::table('notifications')
                                ->where('id', $notification_id)
                                ->pluck('seen')
                                ->first();
        
        return $seen;                        
    }

    public static function setNotificationSeen($notification_id)
    {   
        $user_notifications     =   collect(Inertia::getShared('user_notifications'));
        $index                  =   array_search($notification_id, array_column($user_notifications->toArray(), 'id'));
        $user_notifications[$index]->seen = 1;
        
        $notification_info  =   self::getNotificationDataByID($notification_id);
        DB::table('notifications')->where('id', $notification_id)->update([
            'seen'          => true,  
            'created_at'    => $notification_info->created_at,  
        ]);
    }

    public static function getCurrentUserNotifications()
    {
        $user_has_roles             =   Inertia::getShared('user_has_roles');
        $current_user_notifications =   DB::table('notifications')
                                            ->whereIn('role_to_notify', $user_has_roles)
                                            ->orWhere('user_to_notify', auth()->user()->ID)->pluck('id');

        return $current_user_notifications;
    }

    public static function sendApprovalNotifications($notification_config, $data)
    {
        $approval_type              =   array_key_exists('approval_type', $data) && $data['approval_type'] != null ? $data['approval_type'] : '';
        $notification_config_data   =   self::getNotificationConfigData($notification_config, $approval_type);
        
        $send_to_user               =   array_key_exists('send_to_user_id', $data) && $data['send_to_user_id'] != null ? true : false;
        $user_to_notify             =   $send_to_user ? $data['send_to_user_id'] : null;
        $role_to_notify             =   !$send_to_user ? $notification_config_data->receiver_role_id : null;

        $notification_data          =   array(  'user_to_notify'                => $user_to_notify,
                                                'role_to_notify'                => $role_to_notify,
                                                'notification_config_data_id'   => $notification_config_data->id,
                                                'pending'                       => $approval_type == 'approve' || $approval_type == 'reject' ? false : true,
                                                'data'                          => array_key_exists('approval_data', $data) && $data['approval_data'] != null ? serialize($data['approval_data']) : null,
                                                'created_by'                    => Auth()->ID());   

        $new_notification_id        =   DB::table('notifications')->insertGetId($notification_data);
        
        $notification_data['new_notification_id']   = $new_notification_id;
        $notification_data['panel_icon']            = $notification_config_data->panel_icon;
        $notification_data['panel_content']         = $notification_config_data->panel_content;
        $notification_data['notification_message']  = $notification_config_data->notification_message;
        $notification_data['sender']                = auth()->user()->display_name;
        $notification_data['created_at']            = now();
        
        if($send_to_user){
            // $pusher = new PusherHelpers();
            // $pusher->trigger('notifications.'.$user_to_notify, 'Notifications', $notification_data);
        }
        else{
            // $pusher =   new PusherHelpers();
            // $pusher->trigger('approval.'.$role_to_notify, 'Approval', $notification_data);
        }
    }
    
    public static function getNotificationConfigData($notification_config, $approval_type)
    {
        $user_role              =   collect(Inertia::getShared('user_has_roles'))->first();
        $query                  =   DB::table('notification_config_data')
                                    ->where('notification_config_id', $notification_config)
                                    ->where('sender_role_id', $user_role);
        $approval_type != ''    ?   $query->where('approval_type', $approval_type) : '';

        $receiver_role_id       =   $query->select(['id', 'receiver_role_id', 'panel_icon', 'panel_content', 'notification_message'])->first();

        return $receiver_role_id;
    }
}
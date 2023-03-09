<?php

namespace App\Classes;

use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class CentreHelper {

    public static function getUserAllowedCentres()
    {
        $user_allowed_centres   =   collect(Inertia::getShared('allowed_centres'));

        return $user_allowed_centres;
    }

    public static function getCentreInfo($centre_id)
    {
        $centre_info                =   collect(DB::table('centres')
                                            ->join('centre_principals', 'centres.id', '=', 'centre_principals.centre_id')
                                            ->join('centre_images', 'centres.id', '=', 'centre_images.centre_id')
                                            ->where('centres.id', $centre_id)
                                            ->select([  'centres.ID as centre_id', 
                                                        'centres.label as centre_name', 
                                                        'centres.phone as centre_contact_number', 
                                                        'centres.email as centre_email', 
                                                        'centres.address as centre_address', 
                                                        'centres.is_active as centre_active', 
                                                        'centre_principals.first_name as principal_firstname', 
                                                        'centre_principals.last_name as principal_lastname', 
                                                        'centre_principals.email as principal_email', 
                                                        'centre_principals.contact_number as principal_contact'])
                                            ->first())
                                        ->toArray();

        $centre_info['image_list']  =   collect(DB::table('centre_images')->where('centre_id', $centre_id)->get())->toArray();

        return $centre_info;
    }

    public static function checkCentrePreviousApprovals($centre_id, $notification_config_id)
    {
        $previous_centre_approval  =   DB::table('notifications')
                                                ->join('notification_config_data','notifications.notification_config_data_id','=','notification_config_data.id')
                                                ->where('notification_config_data.notification_config_id', $notification_config_id)
                                                ->where('notifications.pending', true)->get();
        if(count($previous_centre_approval) > 0){
            foreach($previous_centre_approval as $approval){
                $data   =   unserialize($approval->data);
                $pending_approval[$data['centre_id']] =   true;
            }
            $is_pending_approval    =   array_key_exists($centre_id, $pending_approval) && $approval->pending? true : false;
            return $is_pending_approval;
        }
        return false;
    }
}
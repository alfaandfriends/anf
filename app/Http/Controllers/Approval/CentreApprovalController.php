<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Approval\ApprovalController;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CentreApprovalController extends ApprovalController
{
    public function __construct($wf_id)
    {
        $this->wf_id                =   $wf_id;
        $this->user_role            =   $this->checkUserRole();
    }

    public function sendCentreUpdateRequest($approval_data)
    {
        $role   =   $this->getSenderReceiverRoleID();

        // if(!empty($approval_data['image_list'])){
        //     foreach($approval_data['image_list'] as $key=>$image_data){
        //         if(array_key_exists('image_file', $image_data)){
        //             $image_path     =   Storage::putFile('centre_photo', $image_data['image_file']);
        //             $image_size     =   Storage::size($image_path);
        //             $image_type     =   $image_data['image_type'];
                    
        //             $new_images[$key]   =   array(
        //                 'centre_id'     => $approval_data['centre_id'],
        //                 'image_path'    => '/storage/'.$image_path,
        //                 'image_size'    => $image_size,
        //                 'image_type'    => $image_type,
        //             );
        //             unset($approval_data['image_list'][$key]);
        //         }
        //     }
        //     $approval_data['new_images']    =   $new_images;
        // }

        // DB::table('approval_wf_process')->insert([
        //     'approval_wf_id' => $this->wf_id,
        //     'sender_role_id' => $role->sender_role_id,
        //     'receiver_role_id' => $role->receiver_role_id,
        //     'data' => serialize($approval_data),
        //     'current_wf_status' => 3,
        //     'created_by' => Auth()->ID(),
        // ]);

        $notification_data   =   $this->getNotificationInfo(1);
        $this->send_approval_notifications($notification_data);
    }

    public function previewUpdateCenter()
    {
        # code...
    }

    public function updateCentre()
    {
        /* Check principal details */
        $email_exist  =   User::where('user_email', $this->approval_data->principal_email)->count();

        if($email_exist < 1){
            return redirect()->back()->with(['type'=>'error', 'message'=>'Please enter a valid principal email address !']);
        }
        /* Check principal details */

        /* Check images */
        $images_count           = DB::table('centre_images')->where('centre_id', $this->approval_data->centre_id)->count();

        if( (empty($this->approval_data->image_list) && $images_count < 1) || 
            count(collect($this->approval_data->image_list)->where('image_type', 'front')) < 1 || 
            count(collect($this->approval_data->image_list)->where('image_type', 'inside')) < 5){   
            return redirect()->back()->with(['type'=>'error', 'message'=>'Please upload required image !']);
        }
        /* Check images */

        /* Update centre info */
        DB::table('centres')->where('ID', $this->approval_data->centre_id)->update([
                    'label' => 'ANFC '.$this->approval_data->centre_name,
                    'phone' => $this->approval_data->centre_contact_number,
                    'email' => $this->approval_data->centre_email,
                    'address' => $this->approval_data->centre_address,
                    'is_active' => $this->approval_data->centre_active,
                ]);
        /* Update centre info */
            
        /* Update principal info */
        $principal_exist    =   DB::table('centre_principals')->where('centre_id', $this->approval_data->centre_id)->exists();

        if($principal_exist){
            DB::table('centre_principals')->where('centre_id', $this->approval_data->centre_id)->update([
                'first_name'        => $this->approval_data->principal_first_name,
                'last_name'         => $this->approval_data->principal_last_name,
                'email'             => $this->approval_data->principal_email,
                'contact_number'    => $this->approval_data->principal_contact,
                'updated_at'        => Carbon::now(),
            ]);
        }
        else{
            DB::table('centre_principals')->insert([
                'centre_id'         => $this->approval_data->centre_id,
                'first_name'        => $this->approval_data->principal_first_name,
                'last_name'         => $this->approval_data->principal_last_name,
                'email'             => $this->approval_data->principal_email,
                'contact_number'    => $this->approval_data->principal_contact,
            ]);
        }
        /* Update principal info */

        /* Delete selected images */
        if(!empty($this->approval_data->images_to_delete)){
            foreach($this->approval_data->images_to_delete as $key=>$image_to_delete){
                $this->destroyImage($image_to_delete['image_id']);
            }
        }
        /* Delete selected images */

        return redirect(route('centres'))->with(['type'=>'success', 'message'=>'Centre updated successfully !']);
    }

    public function checkCentrePreviousApprovals($centre_id)
    {
        $previous_centre_update_approval  =   DB::table('approval_wf_process')->where('approval_wf_id', $this->wf_id)->get();
        if(count($previous_centre_update_approval) > 0){
            foreach($previous_centre_update_approval as $approval){
                $data   =   unserialize($approval->data);
                $pending_approval[$data['centre_id']] =   true;
            }
            $is_pending_approval    =   array_key_exists($centre_id, $pending_approval) ? true : false;
            return $is_pending_approval;
        }
        return false;
    }
}

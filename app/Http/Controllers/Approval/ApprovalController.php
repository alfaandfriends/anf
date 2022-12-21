<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use App\Models\UserHasRoles;
use App\PusherHelpers;
use Illuminate\Support\Facades\DB;

class ApprovalController extends Controller
{
    public function send_approval_notifications($notification_data)
    {
        $id =   DB::table('notifications')->insertGetId([
            'type' => $notification_data->id,
            'role_to_notify' => $notification_data->receiver_role_id,
            'created_by' => Auth()->ID(),
        ]);

        if($id){
            $pusher = new PusherHelpers();
            $pusher->trigger('approval', 'Approval', $notification_data);
        }
    }

    public function sendApprovalConfirmation()
    {    
    }

    public function getSenderReceiverRoleID()
    {
        $sender_receiver_role_id    =   DB::table('approval_wf')
                                            ->join('approval_wf_details', 'approval_wf.id', '=', 'approval_wf_details.approval_wf_id')
                                            ->where('sender_role_id', $this->user_role)
                                            ->where('approval_wf_id', $this->wf_id)
                                            ->select(['sender_role_id', 'receiver_role_id'])
                                            ->first();

        return $sender_receiver_role_id;
    }

    public function checkUserRole()
    {
        $user_role    =   UserHasRoles::where('user_id', (Auth()->ID()))->pluck('role_id')->first();

        return $user_role;
    }

    public function getNotificationInfo($notification_type_id)
    {
        $notications    =   DB::table('notification_types')
                            ->where('id', $notification_type_id)
                            ->select(['id', 'sender_role_id', 'receiver_role_id', 'icon', 'content'])
                            ->first();

        return $notications;
    }
}

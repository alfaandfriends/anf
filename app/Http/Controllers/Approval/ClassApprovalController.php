<?php

namespace App\Http\Controllers\Approval;

use App\Classes\NotificationHelper;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassApprovalController extends Controller
{
    public $update_class_config = 5;
    public $delete_class_config = 6;

    public function sendClassUpdateRequest($approval_data)
    {
        $data  =   array('approval_data' => $approval_data);
        NotificationHelper::sendApprovalNotifications($this->update_class_config, $data);
    }

    public function approveClassUpdate(Request $request)
    {
        DB::table('classes')->where('id', $request->class_id)->update([
            'centre_id'             =>  $request->centre_id,
            'programme_level_id'    =>  $request->programme_level_id,
            'class_day_id'          =>  $request->class_day,
            'class_method_id'       =>  $request->class_method,
            'start_time'            =>  Carbon::createFromTime($request->start_time['hours'], $request->start_time['minutes'], $request->start_time['seconds'])->format('H:i'),
            'end_time'              =>  Carbon::createFromTime($request->end_time['hours'], $request->end_time['minutes'], $request->end_time['seconds'])->format('H:i'),
            'capacity'              =>  $request->class_capacity,
            'updated_at'            =>  Carbon::now(),
        ]);

        DB::table('notifications')->where('id', $request->notification_id)->delete();

        $data = array(  'send_to_user_id'   => $request->created_by, 
                        'approval_data'     => $request->all(), 
                        'approval_type'     => 'approve');
        NotificationHelper::sendApprovalNotifications($this->update_class_config, $data);

        return redirect(route('notifications'))->with(['type'=>'success', 'message'=>'User has been notify on applied changes!']);
    }

    public function rejectClassUpdate(Request $request)
    {
        DB::table('notifications')->where('id', $request->notification_id)->delete();

        $data = array(  'send_to_user_id'   => $request->created_by, 
                        'approval_data'     => $request->all(), 
                        'approval_type'     => 'reject');
        NotificationHelper::sendApprovalNotifications($this->update_class_config, $data);

        return redirect(route('notifications'))->with(['type'=>'success', 'message'=>'User has been notify on applied changes!']);
    }

    public function sendClassDeleteRequest($class_id)
    {
        $approval_data['class_id'] =   $class_id;
        $data  =   array('approval_data' => $approval_data);
        NotificationHelper::sendApprovalNotifications($this->delete_class_config, $data);
    }

    public function approveClassDelete(Request $request)
    {
        DB::table('classes')->where('id', $request->class_id)->delete();
            
        DB::table('notifications')->where('id', $request->notification_id)->delete();

        $data = array(  'send_to_user_id'   => $request->created_by, 
                        'approval_data'     => $request->all(), 
                        'approval_type'     => 'approve');
        NotificationHelper::sendApprovalNotifications($this->delete_class_config, $data);

        return redirect(route('notifications'))->with(['type'=>'success', 'message'=>'User has been notify on applied changes!']);
    }

    public function rejectClassDelete(Request $request)
    {
        DB::table('notifications')->where('id', $request->notification_id)->delete();

        $data = array(  'send_to_user_id'   => $request->created_by, 
                        'approval_data'     => $request->all(), 
                        'approval_type'     => 'reject');
        NotificationHelper::sendApprovalNotifications($this->delete_class_config, $data);

        return redirect(route('notifications'))->with(['type'=>'success', 'message'=>'User has been notify on applied changes!']);
    }
}

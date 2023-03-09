<?php

namespace App\Http\Controllers\Approval;

use App\Classes\NotificationHelper;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProgrammeApprovalController extends Controller
{
    public $update_programme_config = 3;
    public $delete_programme_config = 4;

    public function sendProgrammeUpdateRequest($approval_data)
    {
        $data  =   array('approval_data' => $approval_data);
        NotificationHelper::sendApprovalNotifications($this->update_programme_config, $data);
    }

    public function approveProgrammeUpdate(Request $request)
    {
        foreach($request->programme_level_to_delete as $key=>$programme_level_id){
            DB::beginTransaction();
            try{
                DB::table('programme_level_fees')->where('programme_level_id', $programme_level_id)->delete();
                DB::table('programme_levels')->where('id', $programme_level_id)->delete();
                DB::commit();
            }
            catch (Exception $e) {
                DB::rollBack();
                return back()->with(['type'=>'error', 'message'=>"Error when changing level or fee, it's being used by class or student."]);
            }
        }

        foreach($request->programme_level_to_add as $key=>$info){
            $programme_level_id =   DB::table('programme_levels')->insertGetId([
                'programme_id'      =>  $request->programme_id,
                'class_type_id'     =>  $info['class_type'],
                'level'             =>  $info['level'],
                'material_fee'      =>  $info['material_fee'],
            ]);
            foreach($info['fees'] as $class_type_detail_id=>$fee){
                if($fee != null || $fee != 0){
                    DB::table('programme_level_fees')->insert([
                        'programme_level_id'    =>  $programme_level_id,
                        'class_type_detail_id'  =>  $class_type_detail_id,
                        'fee_amount'            =>  $fee,
                    ]);
                    
                }
            }
        }
    
        DB::table('programmes')->where('id', $request->programme_id)->update([
            'name'              =>  $request->programme_name,
            'status'            =>  1,
            'updated_at'        =>  Carbon::now(),
        ]);

        DB::table('notifications')->where('id', $request->notification_id)->delete();

        $data = array(  'send_to_user_id'   => $request->created_by, 
                        'approval_data'     => $request->all(), 
                        'approval_type'     => 'approve');
        NotificationHelper::sendApprovalNotifications($this->update_programme_config, $data);

        return redirect(route('notifications'))->with(['type'=>'success', 'message'=>'User has been notify on applied changes!']);
    }

    public function rejectProgrammeUpdate(Request $request)
    {
        DB::table('notifications')->where('id', $request->notification_id)->delete();

        $data = array(  'send_to_user_id'   => $request->created_by, 
                        'approval_data'     => $request->all(), 
                        'approval_type'     => 'reject');
        NotificationHelper::sendApprovalNotifications($this->update_programme_config, $data);

        return redirect(route('notifications'))->with(['type'=>'success', 'message'=>'User has been notify on applied changes!']);
    }

    public function sendProgrammeDeleteRequest($programme_id)
    {
        $approval_data['programme_id'] =   $programme_id;
        $data  =   array('approval_data' => $approval_data);
        NotificationHelper::sendApprovalNotifications($this->delete_programme_config, $data);
    }

    public function approveProgrammeDelete(Request $request)
    {
        DB::table('programmes')
            ->join('programme_levels','programme_levels.programme_id','=','programmes.id')
            ->join('programme_level_fees','programme_level_fees.programme_level_id','=','programme_levels.id')
            ->join('classes','classes.programme_level_id','=','programme_levels.id')
            ->where('programmes.id', $request->programme_id)->delete();
            
        DB::table('notifications')->where('id', $request->notification_id)->delete();

        $data = array(  'send_to_user_id'   => $request->created_by, 
                        'approval_data'     => $request->all(), 
                        'approval_type'     => 'approve');
        NotificationHelper::sendApprovalNotifications($this->delete_programme_config, $data);

        return redirect(route('notifications'))->with(['type'=>'success', 'message'=>'User has been notify on applied changes!']);
    }

    public function rejectProgrammeDelete(Request $request)
    {
        DB::table('notifications')->where('id', $request->notification_id)->delete();

        $data = array(  'send_to_user_id'   => $request->created_by, 
                        'approval_data'     => $request->all(), 
                        'approval_type'     => 'reject');
        NotificationHelper::sendApprovalNotifications($this->delete_programme_config, $data);

        return redirect(route('notifications'))->with(['type'=>'success', 'message'=>'User has been notify on applied changes!']);
    }
}

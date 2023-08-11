<?php

namespace App\Http\Controllers\Approval;

use App\Classes\NotificationHelper;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CentreApprovalController extends Controller
{
    public $update_centre_config     =   1;
    public $delete_centre_config     =   2;

    public function sendCentreUpdateRequest($approval_data)
    {
        if(!empty($approval_data['images_to_delete'])){
            $images_id_to_delete                =   collect($approval_data['images_to_delete'])->pluck('image_id');
            $images_to_delete                   =   DB::table('centre_images')->whereIn('id', $images_id_to_delete)->get()->toArray();
            $approval_data['images_to_delete']  =   $images_to_delete;
        }

        if(!empty($approval_data['image_list'])){
            foreach($approval_data['image_list'] as $key=>$image_data){
                if(array_key_exists('image_file', $image_data)){
                    $image_path     =   Storage::putFile('centre_photo', $image_data['image_file']);
                    $image_size     =   Storage::size($image_path);
                    $image_type     =   $image_data['image_type'];
                    
                    $new_images[]   =   array(
                        'centre_id'     => $approval_data['centre_id'],
                        'image_path'    => '/storage/'.$image_path,
                        'image_size'    => $image_size,
                        'image_type'    => $image_type,
                    );
                    unset($approval_data['image_list'][$key]);
                    $approval_data['images_to_add']     =   $new_images;
                }
            }
        }

        $data  =   array('approval_data' => $approval_data);
        NotificationHelper::sendApprovalNotifications($this->update_centre_config, $data);
    }

    public function approveCentreUpdate(Request $request)
    {
        // /* Update centre info */
        DB::table('centres')->where('ID', $request->centre_id)->update([
                    'label' => $request->centre_name,
                    'phone' => $request->centre_contact_number,
                    'email' => $request->centre_email,
                    'address' => $request->centre_address,
                    'is_active' => $request->centre_active,
                    'principal_user_id' => $request->principal_user_id,
                ]);

        /* Add images */
        if(!empty($request->images_to_add)){
            foreach($request->images_to_add as $key=>$image_to_add){
                DB::table('centre_images')->insert([
                    'centre_id'     => $image_to_add['centre_id'],
                    'image_path'    => $image_to_add['image_path'],
                    'image_size'    => $image_to_add['image_size'],
                    'image_type'    => $image_to_add['image_type'],
                ]);
            }
        }

        /* delete images */
        if(!empty($request->images_to_delete)){
            DB::table('centre_images')->whereIn('id', collect($request->images_to_delete)->pluck('id'))->delete();
            foreach($request->images_to_delete as $key=>$image_to_delete){
                Storage::delete(Str::replace('/storage/', '', $image_to_delete['image_path']));
            }
        }

        DB::table('notifications')->where('id', $request->notification_id)->delete();

        $data = array(  'send_to_user_id'   => $request->created_by, 
                        'approval_data'     => $request->all(), 
                        'approval_type'     => 'approve');
        NotificationHelper::sendApprovalNotifications($this->update_centre_config, $data);

        return redirect(route('notifications'))->with(['type'=>'success', 'message'=>'User has been notify on applied changes!']);
    }

    public function rejectCentreUpdate(Request $request)
    {
        DB::table('notifications')->where('id', $request->notification_id)->delete();

        $data = array(  'send_to_user_id'   => $request->created_by, 
                        'approval_data'     => $request->all(), 
                        'approval_type'     => 'reject');
        NotificationHelper::sendApprovalNotifications($this->update_centre_config, $data);

        return redirect(route('notifications'))->with(['type'=>'success', 'message'=>'User has been notify on applied changes!']);
    }

    public function sendCentreDeleteRequest($centre_id)
    {
        $approval_data['centre_id'] =   $centre_id;
        $data  =   array('approval_data' => $approval_data);
        NotificationHelper::sendApprovalNotifications($this->delete_centre_config, $data);
    }

    public function approveCentreDelete(Request $request)
    {
        DB::table('centres')->where('id', $request->centre_id)->delete();
        DB::table('notifications')->where('id', $request->notification_id)->delete();

        $data = array(  'send_to_user_id'   => $request->created_by, 
                        'approval_data'     => $request->all(), 
                        'approval_type'     => 'approve');
        NotificationHelper::sendApprovalNotifications($this->delete_centre_config, $data);

        return redirect(route('notifications'))->with(['type'=>'success', 'message'=>'User has been notify on applied changes!']);
    }

    public function rejectCentreDelete(Request $request)
    {
        DB::table('notifications')->where('id', $request->notification_id)->delete();

        $data = array(  'send_to_user_id'   => $request->created_by, 
                        'approval_data'     => $request->all(), 
                        'approval_type'     => 'reject');
        NotificationHelper::sendApprovalNotifications($this->delete_centre_config, $data);

        return redirect(route('notifications'))->with(['type'=>'success', 'message'=>'User has been notify on applied changes!']);
    }
}

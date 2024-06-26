<?php

namespace App\Classes;

use Illuminate\Support\Facades\DB;

class ProgrammeHelper {

    public static function programmes($country_id = null){
        $programmes =   DB::table('programmes')
                            ->join('countries', 'programmes.country_id', '=', 'countries.id')
                            ->select('programmes.id', 'programmes.name', 'countries.name as country_name')
                            ->when($country_id, function($query) use ($country_id){
                                $query->where('programmes.country_id', $country_id);
                            })
                            ->get();

        return $programmes;
    }

    public function getProgrammeName($programme_id)
    {
        $programme_name     =   DB::table('programmes')->where('id', $programme_id)->pluck('name')->first();

        return $programme_name;
    }

    public static function distinctLevels(){
        $programme_name     =   DB::table('programme_levels')->distinct()->select('level')->get();

        return $programme_name;
    }

    public static function checkProgrammePreviousApprovals($programme_id, $notification_config_id)
    {
        $previous_programme_approval  =   DB::table('notifications')
                                                ->join('notification_config_data','notifications.notification_config_data_id','=','notification_config_data.id')
                                                ->where('notification_config_data.notification_config_id', $notification_config_id)
                                                ->where('notifications.pending', true)->get();

        if(count($previous_programme_approval) > 0){
            foreach($previous_programme_approval as $approval){
                $data   =   unserialize($approval->data);
                $pending_approval[$data['programme_id']] =   true;
            }
            $is_pending_approval    =   array_key_exists($programme_id, $pending_approval) && $approval->pending? true : false;
            return $is_pending_approval;
        }
        return false;
    }

    public static function checkProgrammeIsDeletable($programme_id){
        $students_in_programme_count  =   DB::table('programmes')
                                            ->join('programme_levels','programme_levels.programme_id','=','programmes.id')
                                            ->join('programme_level_fees','programme_level_fees.programme_level_id','=','programme_levels.id')
                                            ->join('student_fees','student_fees.fee_id','=','programme_level_fees.id')
                                            ->where('programmes.id', $programme_id)->count();
                                            
        if($students_in_programme_count > 0){
            return false;
        }

        return true;
    }

    public static function getProgrammeLevels($programme_id){
        $programme_levels  =   DB::table('programme_levels')->where('programme_id', $programme_id)->select('level')->distinct()->get();

        return $programme_levels;
    }

    public static function getProgrammeIdByStudentFee($student_fee_id){
        $programme_id   =   DB::table('student_fees')
                                ->join('programme_level_fees', 'student_fees.fee_id', '=', 'programme_level_fees.id')
                                ->join('programme_levels', 'programme_level_fees.programme_level_id', '=', 'programme_levels.id')
                                ->join('programmes', 'programme_levels.programme_id', '=', 'programmes.id')
                                ->where('student_fees.id', $student_fee_id)
                                ->pluck('programme.id')
                                ->first();

        return $programme_id;
    }
}
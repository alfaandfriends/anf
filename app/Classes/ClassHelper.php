<?php

namespace App\Classes;

use Illuminate\Support\Facades\DB;

class ClassHelper {

    public static function getClassInfo($class_id)
    {
        $class_info                =   collect(DB::table('classes')
                                            ->join('centres', 'classes.centre_id', '=', 'centres.id')
                                            ->join('programme_levels', 'classes.programme_level_id', '=', 'programme_levels.id')
                                            ->join('programmes', 'programme_levels.programme_id', '=', 'programmes.id')
                                            ->join('class_types', 'programme_levels.class_type_id', '=', 'class_types.id')
                                            ->join('class_days', 'classes.class_day_id', '=', 'class_days.id')
                                            ->join('class_methods', 'classes.class_method_id', '=', 'class_methods.id')
                                            ->where('classes.id', $class_id)
                                            ->select([  'classes.id as class_id', 
                                                        'centres.label as centre_name', 
                                                        'programmes.name as programme_name', 
                                                        'class_types.name as class_type', 
                                                        'programme_levels.level as class_level', 
                                                        'class_days.name as class_day', 
                                                        'class_methods.name as class_method',
                                                        'classes.start_time as class_start_time',
                                                        'classes.end_time as class_end_time',
                                                        'classes.capacity as class_capacity',])
                                            ->first())
                                        ->toArray();

        return $class_info;
    }

    public static function checkClassPreviousApprovals($class_id, $notification_config_id)
    {
        $previous_class_approval  =   DB::table('notifications')
                                                ->join('notification_config_data','notifications.notification_config_data_id','=','notification_config_data.id')
                                                ->where('notification_config_data.notification_config_id', $notification_config_id)
                                                ->where('notifications.pending', true)->get();

        if(count($previous_class_approval) > 0){
            foreach($previous_class_approval as $approval){
                $data   =   unserialize($approval->data);
                $pending_approval[$data['class_id']] =   true;
            }
            $is_pending_approval    =   array_key_exists($class_id, $pending_approval) && $approval->pending ? true : false;
            return $is_pending_approval;
        }
        return false;
    }

    public static function checkClassIsDeletable($class_id){
        $students_in_programme_count  =   DB::table('classes')
                                            ->join('student_classes','student_classes.class_id','=','classes.id')
                                            ->join('student_fees','student_fees.id','=','student_classes.student_fee_id')
                                            ->join('students','students.id','=','student_fees.student_id')
                                            ->where('classes.id', $class_id)->count();
                                            
        if($students_in_programme_count > 0){
            return false;
        }

        return true;
    }
}
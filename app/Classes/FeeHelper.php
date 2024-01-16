<?php

namespace App\Classes;

use Illuminate\Support\Facades\DB;

class FeeHelper {
    public static function getMonthlyActiveFees(){
        $fees      =   DB::table('students')
                            ->join('student_fees', 'student_fees.student_id', '=', 'students.id')
                            ->join('centres', 'student_fees.centre_id', '=', 'centres.id')
                            ->join('programme_level_fees', 'student_fees.fee_id', '=', 'programme_level_fees.id')
                            ->join('programme_levels', 'programme_level_fees.programme_level_id', '=', 'programme_levels.id')
                            ->join('programmes', 'programme_levels.programme_id', '=', 'programmes.id')
                            ->join('class_types_detail', 'programme_level_fees.class_type_detail_id', '=', 'class_types_detail.id')
                            ->join('student_classes', 'student_classes.student_fee_id', '=', 'student_fees.id')
                            ->join('classes', 'student_classes.class_id', '=', 'classes.id')
                            ->join('class_methods', 'classes.class_method_id', '=', 'class_methods.id')
                            ->whereNull('student_fees.status')
                            ->where('students.status', 1)
                            ->whereMonth('student_fees.created_at', '=', now()->subMonth()->format('m'))
                            ->select('students.id as student_id', 'programme_level_fees.id as fee_id', 'centres.id as centre_id', 'centres.label as centre_name', 
                                    'class_methods.name as class_method', 'programme_levels.material_fee', 'programmes.id as programme_id', 
                                    'class_types_detail.class_type_id', 'programme_level_fees.fee_amount as programme_fee', 'programmes.name as programme_name', 
                                    'class_types_detail.label as programme_type', 'programme_levels.level as programme_level', 'classes.id as class_id')
                            ->get();

        return $fees;
    }
}
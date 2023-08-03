<?php

namespace App\Classes;

use Illuminate\Support\Facades\DB;

class StudentHelper {

    public static function studentAcademicDetails($student_id){
        $academics =   DB::table('students')
                            ->join('children', 'students.children_id' ,'=', 'children.id')
                            ->join('student_fees', 'student_fees.student_id' ,'=', 'students.id')
                            ->join('centres', 'student_fees.centre_id' ,'=', 'centres.id')
                            ->join('programme_level_fees', 'student_fees.fee_id' ,'=', 'programme_level_fees.id')
                            ->join('programme_levels', 'programme_level_fees.programme_level_id' ,'=', 'programme_levels.id')
                            ->join('class_types', 'programme_levels.class_type_id' ,'=', 'class_types.id')
                            ->join('programmes', 'programme_levels.programme_id' ,'=', 'programmes.id')
                            ->where('students.id', $student_id)
                            ->select(   'programmes.name as programme_name', 'programme_levels.level as programme_level', 'class_types.name as class_type',
                                        'centres.label as centre_name')
                            ->get()->collect();

        return $academics;
    }
}
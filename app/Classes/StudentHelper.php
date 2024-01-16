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
                            ->where('student_fees.status', null)
                            ->whereMonth('student_fees.created_at', '=', now()->format('m'))
                            ->select(   'programmes.name as programme_name', 'programme_levels.level as programme_level', 'class_types.name as class_type',
                                        'centres.label as centre_name')
                            ->get()->collect();

        return $academics;
    }

    public static function getStudentCountryId($student_id)
    {
        $student_country_id =   DB::table('students')
                                    ->join('children', 'students.children_id', '=', 'children.id')
                                    ->join('wpvt_users', 'children.parent_id', '=', 'wpvt_users.id')
                                    ->where('students.id', $student_id)
                                    ->pluck('wpvt_users.user_country_id')
                                    ->first();
        return $student_country_id;
    }

    public static function getStudentCurrency($student_id)
    {
        $user_currenct_currency =   DB::table('students')
                                        ->join('children', 'students.children_id', '=', 'children.id')
                                        ->join('wpvt_users', 'children.parent_id', '=', 'wpvt_users.id')
                                        ->join('countries', 'wpvt_users.user_country_id', '=', 'countries.id')
                                        ->where('students.id', $student_id)
                                        ->pluck('countries.currency_symbol')
                                        ->first();
                                        
        return $user_currenct_currency;
    }

    public static function getStudentName($student_id)
    {
        $child_name     =   DB::table('students')
                                ->join('children', 'students.children_id', '=', 'children.id')
                                ->where('students.id', $student_id)
                                ->pluck('children.name')
                                ->first();

        return $child_name;
    }

    public static function getStudentEmail($student_id)
    {
        $student_email =   DB::table('students')
                                        ->join('children', 'students.children_id', '=', 'children.id')
                                        ->join('wpvt_users', 'children.parent_id', '=', 'wpvt_users.id')
                                        ->where('students.id', $student_id)
                                        ->pluck('wpvt_users.user_email')
                                        ->first();

        return $student_email;
    }

    public static function getChildId($student_id)
    {
        $child_id =   DB::table('students')
                                    ->join('children', 'students.children_id', '=', 'children.id')
                                    ->where('students.id', $student_id)
                                    ->pluck('children.id')
                                    ->first();
        return $child_id;
    }

    public static function getStudentFees($student_id)
    {
        $student_fees   =   DB::table('student_fees')
                                ->join('programme_level_fees', 'student_fees.fee_id', '=', 'programme_level_fees.id')
                                ->join('programme_levels', 'programme_level_fees.programme_level_id', '=', 'programme_levels.id')
                                ->join('programmes', 'programme_levels.programme_id', '=', 'programmes.id')
                                ->where('student_fees.student_id', $student_id)
                                ->whereNull('student_fees.status')
                                ->select('student_fees.id as id', 'programmes.name as name', 'programme_levels.level as programme_level')
                                ->get();

        return $student_fees;
    }
}
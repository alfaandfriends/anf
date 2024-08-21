<?php

namespace App\Classes;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class GeneralHelper {

    public static function getDaysOfTheWeeks()
    {
        $days_of_the_week   =   DB::table('class_days')->get();

        return $days_of_the_week;
    }

    public function findTeachers(Request $request){
        $teachers   =   DB::table('wpvt_users')
                            ->join('user_has_roles', 'user_has_roles.user_id', '=', 'wpvt_users.ID')
                            ->join('roles', 'user_has_roles.role_id', '=', 'roles.id')
                            ->where('wpvt_users.display_name', 'LIKE', '%'.$request->keyword.'%')
                            ->whereIn('roles.id', [5, 6, 7, 9])
                            ->select(['wpvt_users.ID', 'wpvt_users.display_name'])
                            ->limit(20)->get();

        return $teachers;
    }
}
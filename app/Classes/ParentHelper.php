<?php

namespace App\Classes;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ParentHelper {

    public static function getParents(Request $request)
    {
        $parents =   DB::table('students')
                        ->join('children', 'students.children_id', '=', 'children.id')
                        ->join('wpvt_users', 'children.parent_id', '=', 'wpvt_users.ID')
                        ->where('students.status', 1)
                        ->where('wpvt_users.display_name', 'LIKE', '%'.request('keyword').'%')
                        ->select('wpvt_users.ID as parent_id', 'wpvt_users.display_name as parent_name', 'wpvt_users.user_email as parent_email')
                        ->get();
        return $parents;
    }
}
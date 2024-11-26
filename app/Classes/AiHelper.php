<?php

namespace App\Classes;

use Illuminate\Support\Facades\DB;

class AiHelper {
    public static function getStudentIdByName($name)
    {
        $student_id     =   DB::table('students')
                                ->join('children', 'students.children_id', '=', 'children.id')
                                ->where('children.name', "ILIKE '%", "$name%'")
                                ->pluck('children.name')->first();

        return response()->json($student_id);
    }

    public static function getArtBookThemesByLevel($level_id)
    {
        $themes =   DB::table('art_storybooks')->where('level_id', $level_id)->get();

        return $themes;
    }
}
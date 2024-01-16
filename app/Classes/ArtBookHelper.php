<?php

namespace App\Classes;

use DateTime;
use Illuminate\Support\Facades\DB;

class ArtBookHelper {
    public static function getLevels()
    {
        $levels =   DB::table('art_levels')->get();

        return $levels;
    }

    public static function getArtBookThemesByLevel($level_id)
    {
        $themes =   DB::table('art_storybooks')->where('level_id', $level_id)->get();

        return $themes;
    }
}
<?php

namespace App\Classes;

use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class GeneralHelper {

    public static function getDaysOfTheWeeks()
    {
        $days_of_the_week   =   DB::table('class_days')->get();

        return $days_of_the_week;
    }
}
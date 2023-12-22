<?php

namespace App\Classes;

use DateTime;
use Illuminate\Support\Facades\DB;

class ProgressReportHelper {
    public static function getDatesForDayOfWeekFromCustomDate($dayOfWeek, $customDate) {
        $dates = [];
        $startDate = new DateTime($customDate);
        $endDate = clone $startDate;
        $endDate->modify('last day of this month');

        $count = 0;
        while ($startDate <= $endDate && $count < 4) {
            if ($startDate->format('N') == $dayOfWeek) {
                $dates[] = $startDate->format('Y-m-d');
                $count++;
            }
            $startDate->modify('+1 day');
        }
        
        return $dates;
    }

    public static function getConfigByProgrammeId($programme_id)
    {
        $config_id     =   DB::table('progress_report_configs')->where('programme_id', $programme_id)->first();

        return $config_id;
    }
}
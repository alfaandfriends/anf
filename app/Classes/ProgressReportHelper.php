<?php

namespace App\Classes;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ProgressReportHelper {

    public static function getStudentProgressReports(){
        $progress_reports       =   DB::table('student_fees')
                                        ->join('progress_reports', 'progress_reports.student_fee_id' ,'=' , 'student_fees.id')
                                        ->join('progress_report_configs', 'progress_reports.progress_report_config_id' ,'=' , 'progress_report_configs.id')
                                        ->join('programmes', 'progress_report_configs.programme_id' ,'=' , 'programmes.id')
                                        ->where('student_fees.student_id', session('current_active_child.student_id'))
                                        ->where('programmes.id', session('current_active_programme.id'))
                                        ->select('progress_reports.*')
                                        ->orderByDesc('created_at')
                                        ->paginate(10);

        return $progress_reports;
    }
    
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
<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ProgressReportController extends Controller
{
    public function index(Request $request){

        if(!session('current_active_programme.id')){
            return redirect(route('parent.home'))->with(['type' => 'error', 'message' => 'Unable to fetch class data']);
        }

        $student_id     =   $request->session()->get('current_active_child.student_id');

        $progress_reports       =   DB::table('student_fees')
                                        ->join('progress_reports', 'progress_reports.student_fee_id' ,'=' , 'student_fees.id')
                                        ->join('progress_report_configs', 'progress_reports.progress_report_config_id' ,'=' , 'progress_report_configs.id')
                                        ->join('programmes', 'progress_report_configs.programme_id' ,'=' , 'programmes.id')
                                        ->where('student_fees.student_id', $student_id)
                                        ->where('programmes.id', session('current_active_programme.id'))
                                        ->select('progress_reports.*')
                                        ->get();

        return Inertia::render('Parent/Class/ProgressReports', [
            'progress_reports'  => $progress_reports,
        ]);
    }
}

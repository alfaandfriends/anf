<?php

namespace App\Http\Controllers\Parent;

use App\Classes\ProgressReportHelper;
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

        $progress_reports   =   ProgressReportHelper::getStudentProgressReports();

        return Inertia::render('Parent/Class/ProgressReports', [
            'progress_reports'  => $progress_reports,
        ]);
    }
}

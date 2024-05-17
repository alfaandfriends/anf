<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Corcel\Model\User;
use Inertia\Inertia;
use App\Models\Centre;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $total_centres  =   $request->centre_status != null ? Centre::where('is_active', $request->centre_status)->count() : Centre::count(); 

        $online_students_this_month     =   DB::table('student_fees')
                                                ->join('students', 'student_fees.student_id', '=', 'students.id')
                                                ->join('student_classes', 'student_classes.student_fee_id', '=', 'student_fees.id')
                                                ->join('classes', 'student_classes.class_id', '=', 'classes.id')
                                                ->where('classes.class_method_id', 1)
                                                ->where('students.status', 1)
                                                ->whereYear('student_fees.created_at', '=', Carbon::now()->format('Y'))
                                                ->whereMonth('student_fees.created_at', '=', Carbon::now()->format('m'))
                                                ->distinct()->select('students.id')->get();

        $online_students_last_month     =   DB::table('student_fees')
                                                ->join('students', 'student_fees.student_id', '=', 'students.id')
                                                ->join('student_classes', 'student_classes.student_fee_id', '=', 'student_fees.id')
                                                ->join('classes', 'student_classes.class_id', '=', 'classes.id')
                                                ->where('classes.class_method_id', 1)
                                                ->where('students.status', 1)
                                                ->whereYear('student_fees.created_at', '=', Carbon::now()->format('Y'))
                                                ->whereMonth('student_fees.created_at', '=', Carbon::now()->subMonth(1)->format('m'))
                                                ->distinct()->select('students.id')->get();

        $physical_students_this_month   =   DB::table('student_fees')
                                                ->join('students', 'student_fees.student_id', '=', 'students.id')
                                                ->join('student_classes', 'student_classes.student_fee_id', '=', 'student_fees.id')
                                                ->join('classes', 'student_classes.class_id', '=', 'classes.id')
                                                ->where('classes.class_method_id', 2)
                                                ->where('students.status', 1)
                                                ->whereYear('student_fees.created_at', '=', Carbon::now()->format('Y'))
                                                ->whereMonth('student_fees.created_at', '=', Carbon::now()->format('m'))
                                                ->distinct()->select('students.id')->get();

        $physical_students_last_month   =   DB::table('student_fees')
                                                ->join('students', 'student_fees.student_id', '=', 'students.id')
                                                ->join('student_classes', 'student_classes.student_fee_id', '=', 'student_fees.id')
                                                ->join('classes', 'student_classes.class_id', '=', 'classes.id')
                                                ->where('classes.class_method_id', 2)
                                                ->where('students.status', 1)
                                                ->whereYear('student_fees.created_at', '=', Carbon::now()->format('Y'))
                                                ->whereMonth('student_fees.created_at', '=', Carbon::now()->subMonth(1)->format('m'))
                                                ->distinct()->select('students.id')->get();

        return Inertia::render('Admin/Dashboard',[
            'filters'                       =>  request()->all('centre_status', 'student_status'),
            'total_centres'                 =>  $total_centres,
            'online_students_this_month'    =>  count($online_students_this_month),
            'online_students_last_month'    =>  count($online_students_last_month),
            'physical_students_this_month'  =>  count($physical_students_this_month),
            'physical_students_last_month'  =>  count($physical_students_last_month),
        ]);
    }

    public function centresData(Request $request){
        // return Inertia::render('Dashboard',[
        //     'total_centres'=>$total_centres,
        // ]);
    }
}

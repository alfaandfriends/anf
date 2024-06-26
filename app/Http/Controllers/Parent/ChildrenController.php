<?php

namespace App\Http\Controllers\Parent;

use App\Classes\ProgrammeHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ChildrenController extends Controller
{
    public function create(){
        $children_list          =   DB::table('children')
                                    ->leftJoin('students', 'students.children_id', '=', 'children.id')
                                    ->join('genders', 'children.gender_id', '=', 'genders.id')
                                    ->where('parent_id', auth()->id())
                                    ->select(['children.id', 'children.name', 'genders.name as gender', 'children.date_of_birth as dob', 'students.id as student_id'])
                                    ->orderBy('children.date_of_birth')
                                    ->get();
        $gender_list            =   DB::table('genders')->get();
        $programme_list         =   ProgrammeHelper::programmes();
        $children_class_info    =   DB::table('student_fees')
                                        ->join('students', 'student_fees.student_id', '=', 'students.id')
                                        ->join('children', 'students.children_id', '=', 'children.id')
                                        ->join('wpvt_users', 'children.parent_id', '=', 'wpvt_users.id')
                                        ->join('centres', 'student_fees.centre_id', '=', 'centres.id')
                                        ->where('wpvt_users.id', auth()->id())
                                        ->whereYear('student_fees.created_at', Carbon::now()->format('Y'))
                                        ->whereMonth('student_fees.created_at', Carbon::now()->format('m'))
                                        ->select('student_fees.*', 'centres.label')
                                        ->get()
                                        ->groupBy('student_id');

        return Inertia::render('Parent/Children/Index', [
            'gender_list'           => $gender_list,
            'programme_list'        => $programme_list,
            'children_list'         => $children_list,
            'children_class_info'   => $children_class_info,
        ]);
    }
}

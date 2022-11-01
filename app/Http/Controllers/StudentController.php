<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $allowed_centres    =   (object)Inertia::getShared('allowed_centres');
        $can_access_centre = $allowed_centres->search(function ($value) { 
            return $value->ID == request('centre_id');
        });

        $query          =   DB::table('students')
                                ->join('student_fees', 'students.id', '=', 'student_fees.student_id')
                                ->join('programme_level_fees', 'student_fees.fee_id', '=', 'programme_level_fees.id')
                                ->join('programme_levels', 'programme_level_fees.programme_level_id', '=', 'programme_levels.id')
                                ->join('programmes', 'programme_levels.programme_id', '=', 'programmes.id')
                                ->join('classes', 'programme_levels.id', '=', 'classes.programme_level_id')
                                ->join('wpvt_users', 'students.parent_id', '=', 'wpvt_users.id')
                                ->distinct()
                                ->select([  'students.id as id', 
                                            'students.name as name', 
                                            'programmes.name as programme_name', 
                                            'wpvt_users.display_name as parent_name']);

        if($request->search){
            $query->where('programmes.name', 'LIKE', '%'.$request->search.'%');
        }

        if($request->centre_id){
            $request->merge([
                'centre_id' => !$can_access_centre ? $allowed_centres[0]->ID : $request->centre_id,
            ]);
        }
        else{
            $request->merge([
                'centre_id' => $allowed_centres[0]->ID
            ]);
        }
        $query->where('classes.centre_id', '=', $request->centre_id);

        return Inertia::render('CentreManagement/Students/Index', [
            'filter'        => request()->all('search', 'centre_id'),
            'students'       => $query->paginate(10),
        ]);
    }

    public function create(Request $request)
    {
        $programme_list     =   DB::table('programmes')->get();
        $method_list        =   DB::table('class_methods')->get();

        return Inertia::render('CentreManagement/Students/Create', [
            'programme_list'    => $programme_list,
            'method_list'       => $method_list,
            'centre_id'         => $request->centre_id
        ]);
    }

    public function store(Request $request)
    {
        $student_fee_id     =   DB::table('student_fees')->insertGetId([
            'student_id'    =>  $request->student_id,
            'fee_id'        =>  $request->fee['id'],
        ]);

        foreach($request->classes as $key => $class_id){
            DB::table('student_classes')->insert([
                'student_fee_id'    =>  $student_fee_id,
                'class_id'          =>  $class_id,
            ]);
        }

        return redirect(route('students'))->with(['type'=>'success', 'message'=>'Admission success !']);
    }

    public function edit(Request $request)
    {
        $student_info       =   DB::table('students')
                                    ->join('genders', 'students.gender_id', '=', 'genders.id')
                                    ->join('user_basic_information', 'students.parent_id', '=', 'user_basic_information.user_id')
                                    ->join('wpvt_users', 'students.parent_id', '=', 'wpvt_users.id')
                                    ->where('students.id', $request->student_id)
                                    ->select([  'students.name as name', 
                                                'students.date_of_birth as dob', 
                                                'genders.id as gender', 
                                                'user_basic_information.user_first_name as parent_first_name', 
                                                'user_basic_information.user_last_name as parent_last_name', 
                                                'user_basic_information.user_calling_code as parent_calling_code', 
                                                'user_basic_information.user_contact as parent_contact', 
                                                'user_basic_information.user_address as parent_address', 
                                                'wpvt_users.user_email as parent_email'])
                                    ->first();

        $student_academics  =   DB::table('student_fees')
                                    ->join('student_classes', 'student_fees.id', '=', 'student_classes.student_fee_id')
                                    ->join('classes', 'student_classes.class_id', '=', 'classes.id')
                                    ->join('programme_levels', 'classes.programme_level_id', '=', 'programme_levels.id')
                                    ->join('programmes', 'programme_levels.programme_id', '=', 'programmes.id')
                                    ->join('class_types', 'programme_levels.class_type_id', '=', 'class_types.id')
                                    ->join('class_days', 'classes.class_day_id', '=', 'class_days.id')
                                    ->join('centres', 'classes.centre_id', '=', 'centres.id')
                                    ->where('student_fees.student_id', $request->student_id)
                                    ->select([  'programmes.name as programme_name', 
                                                'centres.label as centre_name', 
                                                'programme_levels.level as level', 
                                                'class_types.name as type', 
                                                'class_days.name as day', 
                                                'classes.start_time', 
                                                'classes.end_time'])
                                    ->get();
        $gender_list    =   DB::table('genders')->get();
        $programme_list     =   DB::table('programmes')->get();
        $method_list        =   DB::table('class_methods')->get();
        
        return Inertia::render('CentreManagement/Students/Edit', [
            'student_info'          => $student_info,
            'student_academics'     => $student_academics,
            'gender_list'           => $gender_list,
            'programme_list'        => $programme_list,
            'method_list'           => $method_list,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'class_name'        => 'required|max:50',
            'centre_id'         => 'required',
            'programme_id'      => 'required',
            'class_level'       => 'required',
            'class_day'         => 'required',
            'start_time'        => 'required',
            'end_time'          => 'required',
            'class_capacity'    => 'required',
            "class_type"        => 'required'
        ]);
        
        DB::table('classes')->where('id', $request->class_id)->update([
            'programme_id'      =>  $request->programme_id,
            'centre_id'         =>  $request->centre_id,
            'name'              =>  $request->class_name,
            'level'             =>  $request->class_level,
            'class_day_id'      =>  $request->class_day,
            'start_time'        =>  Carbon::createFromTime($request->start_time['hours'], $request->start_time['minutes'], $request->start_time['seconds'])->format('H:i'),
            'end_time'          =>  Carbon::createFromTime($request->end_time['hours'], $request->end_time['minutes'], $request->end_time['seconds'])->format('H:i'),
            'capacity'          =>  $request->class_capacity,
            'class_type_id'     =>  $request->class_type,
            'status'            =>  $request->class_status,
        ]);

        return redirect(route('classes'))->with(['type'=>'success', 'message'=>'Class updated successfully !']);
    }

    public function destroy($id)
    {
        DB::table('classes')->where('id', $id)->delete();

        return redirect(route('classes'))->with(['type'=>'success', 'message'=>'Class deleted successfully !']);
    }

    public function findStudents(Request $request){
        $students   =   DB::table('students')->where('name', 'LIKE', '%'.$request->keyword.'%')->select(['id', 'name'])->get();
        return $students;
    }
}

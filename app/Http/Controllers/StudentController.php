<?php

namespace App\Http\Controllers;

use App\Classes\NotificationHelper;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Inertia\Inertia;

class StudentController extends Controller
{
    public $update_student_config = 7;

    public function index(Request $request)
    {
        $allowed_centres    =   (object)Inertia::getShared('allowed_centres');
        $can_access_centre = $allowed_centres->search(function ($value) { 
            return $value->ID == request('centre_id');
        });
        
        $query          =   DB::table('students')
                                ->join('children', 'students.children_id', '=', 'children.id')
                                ->join('student_fees', 'students.id', '=', 'student_fees.student_id')
                                ->join('programme_level_fees', 'student_fees.fee_id', '=', 'programme_level_fees.id')
                                ->join('programme_levels', 'programme_level_fees.programme_level_id', '=', 'programme_levels.id')
                                ->join('programmes', 'programme_levels.programme_id', '=', 'programmes.id')
                                ->join('wpvt_users', 'children.parent_id', '=', 'wpvt_users.id')
                                ->select([  'students.id as id', 
                                            'children.name as name', 
                                            'wpvt_users.display_name as parent_name', 
                                            'students.status']);

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
        
        $query->where('student_fees.centre_id', '=', $request->centre_id);

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
        // $student_id         =   DB::table('students')->insertGetId([
        //     'children_id'    =>  $request->student_id,
        // ]);

        // $student_fee_id     =   DB::table('student_fees')->insertGetId([
        //     'student_id'        =>  $student_id,
        //     'centre_id'         =>  $request->centre_id,
        //     'fee_id'            =>  $request->fee['id'],
        //     'admission_date'    =>  Carbon::parse($request->date_admission)->format('Y-m-d')
        // ]);

        // foreach($request->classes as $key => $class_id){
        //     DB::table('student_classes')->insert([
        //         'student_fee_id'    =>  $student_fee_id,
        //         'class_id'          =>  $class_id,
        //     ]);
        // }

        // /* Create progress report */
        // $programme_id   =   DB::table('programme_level_fees')
        //                         ->join('programme_levels', 'programme_level_fees.programme_level_id', '=', 'programme_levels.id')
        //                         ->join('programmes', 'programme_levels.programme_id', '=', 'programmes.id')
        //                         ->where('programme_level_fees.id', $request->fee['id'])
        //                         ->pluck('programmes.id')
        //                         ->first();

        // $report_info        =   DB::table('progress_report_configs')->where('programme_id', $programme_id)->select('table', 'columns')->first();
        // $report_table       =   $report_info->table;
        // $report_columns     =   Str($report_info->columns);

        // $progress_report_id =   DB::table('progress_reports')->insertGetId([
        //     'student_id'        =>  $request->student_id,
        //     'centre_id'         =>  $request->centre_id,
        //     'programme_id'      =>  $programme_id,
        //     'month'             =>  Carbon::parse($request->date_admission)->format('Y-m-d')
        // ]);

        // $columns                                =   explode(", ", $report_columns);
        // $values                                 =   array_fill(0, count($columns), null);
        // $empty_record                           =   array_combine($columns, $values);
        // $empty_record['progress_report_id']     =   $progress_report_id;

        // DB::table($report_table)->insert($empty_record);

        dd($this->getDatesForDayOfWeekFromCustomDate(1, Carbon::parse($request->date_admission)->format('Y-m-d')));

        return redirect(route('students'))->with(['type'=>'success', 'message'=>'Admission success !']);
    }

    public function edit(Request $request)
    {
        $student_info       =   DB::table('students')
                                    ->join('children', 'students.children_id', '=', 'children.id')
                                    ->join('genders', 'children.gender_id', '=', 'genders.id')
                                    ->leftJoin('user_basic_information', 'children.parent_id', '=', 'user_basic_information.user_id')
                                    ->rightJoin('wpvt_users', 'children.parent_id', '=', 'wpvt_users.id')
                                    ->where('students.id', $request->student_id)
                                    ->select([  
                                                'students.id as id', 
                                                'students.status as status', 
                                                'children.name as name', 
                                                'children.date_of_birth as dob', 
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
                                    ->select([  'student_fees.fee_id as fee_id', 
                                                'programmes.name as programme_name', 
                                                'centres.label as centre_name', 
                                                'programme_levels.level as level', 
                                                'class_types.name as type', 
                                                'class_days.name as day', 
                                                'classes.start_time', 
                                                'classes.end_time'])
                                    ->orderBy('programme_levels.level')
                                    ->orderBy('class_days.id')
                                    ->get();
        $gender_list        =   DB::table('genders')->get();
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
        DB::table('students')->where('id', $request->student_id)->update([
            'status' => $request->student_status
        ]);

        
        if(auth()->user()->is_admin == false){
            $data  =   array('approval_data' => $request->all());
            NotificationHelper::sendApprovalNotifications($this->update_student_config, $data);
        }

        return redirect(route('students'))->with(['type'=>'success', 'message'=>'Student details updated !']);
    }

    public function destroy(Request $request)
    {
        $fee_count  =   DB::table('student_fees')->where('student_id', $request->student_id)->get();

        if(count($fee_count) <= 1){
            return redirect()->back()->with(['type'=>'error', 'message'=>'Please add a new class before deleting the last class!']);
        }

        DB::table('student_fees')->where('student_id', $request->student_id)->where('fee_id', $request->fee_id)->delete();
        $fee_count  =   DB::table('student_fees')->where('student_id', $request->student_id)->count();
        if($fee_count < 1){
            DB::table('students')->where('id', $request->student_id)->delete();
        }

        return redirect()->back()->with(['type'=>'success', 'message'=>'Class deleted successfully !']);
    }

    public function findStudents(Request $request){
        $students   =   DB::table('children')
                            ->join('user_basic_information', 'user_basic_information.user_id', '=', 'children.parent_id')
                            ->where('children.name', 'LIKE', '%'.$request->keyword.'%')
                            ->whereNotExists(function ($query) {
                                $query->select(DB::raw(1))
                                      ->from('students')
                                      ->whereColumn('students.children_id', 'children.id');
                            })
                            ->select(['children.id', 
                                        DB::Raw("CONCAT(children.name, ' - ( ', user_basic_information.user_first_name, ' ', user_basic_information.user_last_name, ' )') AS name")
                                    ])->get();

        return $students;
    }

    public function addStudentClass(Request $request)
    {
        if(empty($request->classes)){
            return back()->with(['type'=>'error', 'message'=>'Please select at least 1 class !']);
        }

        $student_fee_id =   DB::table('student_fees')->insertGetId([
            'student_id'        =>  $request->student_id,
            'centre_id'         =>  $request->centre_id,
            'fee_id'            =>  $request->fee['id'],
            'admission_date'    =>  Carbon::parse($request->date_admission)->format('Y-m-d')
        ]);

        foreach($request->classes as $key => $class_id){
            DB::table('student_classes')->insert([
                'student_fee_id'    =>  $student_fee_id,
                'class_id'          =>  $class_id,
            ]);
        }
        
        /* Create progress report */
        $programme_id   =   DB::table('programme_level_fees')
                                ->join('programme_levels', 'programme_level_fees.programme_level_id', '=', 'programme_levels.id')
                                ->join('programmes', 'programme_levels.programme_id', '=', 'programmes.id')
                                ->where('programme_level_fees.id', $request->fee['id'])
                                ->pluck('programmes.id')
                                ->first();

        $progress_report_id =   DB::table('progress_reports')->insertGetId([
            'student_id'        =>  $request->student_id,
            'centre_id'         =>  $request->centre_id,
            'programme_id'      =>  $programme_id,
            'month'             =>  Carbon::createFromTimeString($request->date_admission)->month,
        ]);

        // if(!empty($request->classes)){
        //     $classes    =   DB::table('classes')
        //                         ->join('class_days', 'classes.class_day_id', '=', 'class_days.id')
        //                         ->join('programme_levels', 'classes.programme_level_id', '=', 'programme_levels.id')
        //                         ->join('programmes', 'programme_levels.programme_id', '=', 'programmes.id')
        //                         ->whereIn('classes.id', $request->classes)
        //                         ->select('class_days.id', 'class_days.name', 'programmes.table')
        //                         ->get();

        //     foreach($classes as $key=>$class_info){
        //         $class_day      =    $class_info->id;
        //         $table_name     =    $class_info->table;

        //         $daysForMonth   =   $this->getDatesForDayOfWeekFromCustomDate($class_info->id, date('Y-m-d'));
        //         dd($daysForMonth);
        //         if(!empty($daysForMonth)){
        //             foreach($daysForMonth as $key=>$date){
        //                 DB::table($table_name)->insert([
        //                     'date'
        //                 ]);
        //             }
        //         }

        //     }
        // }
        
        return redirect()->back()->with(['type'=>'success', 'message'=>'New class added successfully !']);
    }

    /* Usage: $this->getDatesForDayOfWeekFromCustomDate(1, '2023-05-02') */
    public function getDatesForDayOfWeekFromCustomDate($dayOfWeek, $customDate) {
        $dates = array();
        $startDate = new DateTime($customDate);
        $year = $startDate->format('Y');
        $month = $startDate->format('m');
        $date = new DateTime("$year-$month-01");
        if ($startDate->format('N') != $dayOfWeek) {
            $startDate->modify("next Monday");
            $startDate->modify("+".($dayOfWeek-1)." days");
        }
        if ($startDate->format('j') < $date->format('j')) {
            $startDate->modify("+7 days");
        }
        $weeksProcessed = 0;
        while ($startDate->format('m') == $month) {
            $dates[] = $startDate->format('Y-m-d');
            $startDate->modify("+7 days");
            $weeksProcessed++;
            if ($weeksProcessed >= 4) {
                break;
            }
        }
        return $dates;
    }
}

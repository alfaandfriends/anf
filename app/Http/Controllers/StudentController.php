<?php

namespace App\Http\Controllers;

use App\Classes\InvoiceHelper;
use App\Classes\NotificationHelper;
use App\Classes\OrderHelper;
use App\Classes\ProgrammeHelper;
use Billplz\Laravel\Billplz;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Inertia\Inertia;

class StudentController extends Controller
{
    public $update_student_config = 7;

    public function index(Request $request)
    {
        $query          =   DB::table('students')
                                ->join('children', 'students.children_id', '=', 'children.id')
                                ->leftJoin('student_fees', 'students.id', '=', 'student_fees.student_id')
                                ->leftJoin('programme_level_fees', 'student_fees.fee_id', '=', 'programme_level_fees.id')
                                ->leftJoin('programme_levels', 'programme_level_fees.programme_level_id', '=', 'programme_levels.id')
                                ->leftJoin('programmes', 'programme_levels.programme_id', '=', 'programmes.id')
                                ->join('wpvt_users', 'children.parent_id', '=', 'wpvt_users.id')
                                ->select([  'students.id as id', 
                                            'children.name as name', 
                                            'wpvt_users.display_name as parent_name', 
                                            'students.status'])
                                ->distinct();

        if($request->search){
            $query->where('programmes.name', 'LIKE', '%'.$request->search.'%');
        }

        return Inertia::render('CentreManagement/Students/Index', [
            'filter'        => request()->all('search'),
            'students'       => $query->paginate(10),
        ]);
    }

    public function create(Request $request)
    {
        $programme_list     =   ProgrammeHelper::programmes();
        $method_list        =   DB::table('class_methods')->get();

        return Inertia::render('CentreManagement/Students/Create', [
            'programme_list'    => $programme_list,
            'method_list'       => $method_list,
            'centre_id'         => $request->centre_id
        ]);
    }

    public function store(Request $request)
    {
        try {
            // Begin the transaction
            DB::beginTransaction();
            
            /* Create student */
            $student_id         =   DB::table('students')->insertGetId([
                'children_id'    =>  $request->children_id,
            ]);

            /* Create Invoice */
            $invoice_data['student_id']         =   $student_id;
            $invoice_data['invoice_items']      =   collect($request->fee)->pluck('fee_info')->toArray();
            $invoice_data['date_admission']     =   Carbon::parse($request->date_admission)->format('Y-m-d');
        
            $new_invoice_id =   InvoiceHelper::newFeeInvoice($invoice_data);

            foreach($request->fee as $fee_index=>$fee){
                /* Create Fee */
                $student_fee_id     =   DB::table('student_fees')->insertGetId([
                    'student_id'        =>  $student_id,
                    'centre_id'         =>  $request->centre_id,
                    'fee_id'            =>  $fee['fee_info']['fee_id'],
                    'invoice_id'        =>  $new_invoice_id,
                    'admission_date'    =>  Carbon::parse($request->date_admission)->format('Y-m-d')
                ]);

                /* Create Order */
                $order_data['student_id']   =   $student_id;
                $order_data['invoice_id']   =   $new_invoice_id;
                $order_data['products']     =   $fee['material'];
                OrderHelper::newOrder($order_data);

                /* Create Class */
                foreach($fee['classes'] as $class_key => $class){
                    DB::table('student_classes')->insert([
                        'student_fee_id'    =>  $student_fee_id,
                        'class_id'          =>  $class['class_id'],
                    ]);
                }
                
                /* Create progress report */
                $progress_report_config_id  =   DB::table('progress_report_configs')->where('programme_id', $fee['fee_info']['programme_id'])->pluck('id')->first();

                $progress_report_id =   DB::table('progress_reports')->insertGetId([
                    'student_fee_id'                =>  $student_fee_id,
                    'progress_report_config_id'     =>  $progress_report_config_id,
                    'month'                         =>  Carbon::parse($request->date_admission)->format('Y-m-d')
                ]);


                $class_days     =   DB::table('classes')->whereIn('id', collect($fee['classes'])->pluck('class_id'))->select('class_day_id as class_day')->get();
                $total_class    =   count($class_days) * 4;

                $total_date_available   =   0;
                foreach($class_days as $data){
                    $date_available =   $this->getDatesForDayOfWeekFromCustomDate($data->class_day, Carbon::parse($request->date_admission)->format('Y-m-d'));
                    foreach($date_available as $date){
                        DB::table('progress_report_details')->insert([
                            'progress_report_id'    => $progress_report_id,
                            'date'                  => $date,
                            'report_data'           => json_encode([]),
                        ]);
                        $total_date_available++;
                    }
                }

                $remaining_days =   $total_class - $total_date_available;
                if($remaining_days != 0){
                    for($i = 1; $i <= $remaining_days; $i++){
                        DB::table('progress_report_details')->insert([
                            'progress_report_id'    => $progress_report_id,
                            'date'                  => now(),
                            'report_data'           => json_encode([]),
                        ]);
                    }
                }
            }
        
            DB::commit();   

            return redirect(route('students'))->with(['type'=>'success', 'message'=>'Admission success !']);
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect(route('students'))->with(['type'=>'error', 'message'=>'Something went wrong, please contact support !']);
        }
    }

    public function edit(Request $request)
    {
        $student_info       =   DB::table('students')
                                    ->join('children', 'students.children_id', '=', 'children.id')
                                    ->join('genders', 'children.gender_id', '=', 'genders.id')
                                    ->rightJoin('wpvt_users', 'children.parent_id', '=', 'wpvt_users.id')
                                    ->where('students.id', $request->student_id)
                                    ->select([  
                                                'students.id as id', 
                                                'students.status as status', 
                                                'children.name as name', 
                                                'children.date_of_birth as dob', 
                                                'genders.id as gender', 
                                                'wpvt_users.display_name as parent_full_name', 
                                                'wpvt_users.user_calling_code as parent_calling_code', 
                                                'wpvt_users.user_contact as parent_contact', 
                                                'wpvt_users.user_address as parent_address', 
                                                'wpvt_users.user_email as parent_email'])
                                    ->first();

        $result            =   DB::table('classes')
                                    ->join('student_classes', 'student_classes.class_id', '=', 'classes.id')
                                    ->join('student_fees', 'student_classes.student_fee_id', '=', 'student_fees.id')
                                    ->join('class_days', 'classes.class_day_id', '=', 'class_days.id')
                                    ->join('centres', 'student_fees.centre_id', '=', 'centres.id')
                                    ->join('class_methods', 'classes.class_method_id', '=', 'class_methods.id')
                                    ->join('programme_levels', 'classes.programme_level_id', '=', 'programme_levels.id')
                                    ->join('class_types', 'programme_levels.class_type_id', '=', 'class_types.id')
                                    ->join('programmes', 'programme_levels.programme_id', '=', 'programmes.id')
                                    ->join('programme_level_fees', 'student_fees.fee_id', '=', 'programme_level_fees.id')
                                    ->join('class_types_detail', 'programme_level_fees.class_type_detail_id', '=', 'class_types_detail.id')
                                    ->join('invoices', 'student_fees.invoice_id', '=', 'invoices.id')
                                    ->select(   'classes.id as class_id', 
                                                'class_days.name as class_day', 
                                                'classes.start_time', 
                                                'classes.end_time',
                                                'programmes.id as programme_id', 
                                                'programmes.name as programme_name', 
                                                'programme_levels.level as programme_level', 
                                                'programme_levels.material_fee', 
                                                'programme_level_fees.id as fee_id', 
                                                'programme_level_fees.fee_amount as programme_fee', 
                                                'class_types_detail.label as programme_type', 
                                                'centres.id as centre_id', 
                                                'centres.label as centre_name', 
                                                'class_types.id as class_type_id', 
                                                'class_methods.name as class_method', 
                                                'invoices.id as invoice_id', 
                                                'student_fees.admission_date as admission_date', 
                                                'student_fees.id as student_fee_id', 
                                                'student_fees.status as student_fee_status')
                                    ->where('student_fees.student_id', $request->student_id)
                                    ->get();

        $student_academics = collect($result)->groupBy('fee_id')->map(function ($group) {
            $fee_info = [
                "centre_id" => $group->first()->centre_id,
                "centre_name" => $group->first()->centre_name,
                "class_method" => $group->first()->class_method,
                "class_type_id" => $group->first()->class_type_id,
                "fee_id" => $group->first()->fee_id,
                "material_fee" => $group->first()->material_fee,
                "programme_fee" => $group->first()->programme_fee,
                "programme_id" => $group->first()->programme_id,
                "programme_level" => $group->first()->programme_level,
                "programme_name" => $group->first()->programme_name,
                "programme_type" => $group->first()->programme_type,
                "invoice_id" => $group->first()->invoice_id,
                "admission_date" => $group->first()->admission_date,
                "student_fee_id" => $group->first()->student_fee_id,
                "student_fee_status" => $group->first()->student_fee_status ? $group->first()->student_fee_status : '',
            ];
        
            $classes = $group->map(function ($item) {
                return [
                    "class_id" => $item->class_id,
                    "class_day" => $item->class_day,
                    "start_time" => $item->start_time,
                    "end_time" => $item->end_time,
                ];
            })->values()->all();
        
            return [
                "classes" => $classes,
                "fee_info" => $fee_info,
            ];
        })->values()->all();

        $gender_list        =   DB::table('genders')->get();
        $programme_list     =   ProgrammeHelper::programmes();
        $method_list        =   DB::table('class_methods')->get();
        $fee_status        =   DB::table('student_fee_status')->get();
        
        return Inertia::render('CentreManagement/Students/Edit', [
            'student_info'          => $student_info,
            'student_academics'     => $student_academics,
            'gender_list'           => $gender_list,
            'programme_list'        => $programme_list,
            'method_list'           => $method_list,
            'fee_status'            => $fee_status,
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
        $invoice_data   =  DB::table('invoices')->where('id', $request->invoice_id)->first();

        $invoice_items      =   collect(json_decode($invoice_data->invoice_items, true));

        
        /* Check if paid */ 
        $bill   =   Billplz::bill()->get($invoice_data->bill_id)->toArray();
        if(!$bill['paid']){
            Billplz::bill()->destroy($invoice_data->bill_id);
        }

        if($invoice_items->count() <= 1){
            DB::table('invoices')->where('id', $request->invoice_id)->delete();
            DB::table('student_fees')
                ->join('student_classes', 'student_classes.student_fee_id', '=', 'student_fees.id')
                ->join('progress_reports', 'progress_reports.student_fee_id', '=', 'student_fees.id')
                ->where('student_fees.invoice_id', $request->invoice_id)->delete();
        }
        else{
            $fee_to_delete          = intval($request->fee_to_delete); // Assuming you get the fee_id from the request
            $filtered_invoice_items = $invoice_items->reject(function ($item) use ($fee_to_delete) {
                return $item["fee_id"] === $fee_to_delete;
            });

            DB::table('invoices')->where('id', $request->invoice_id)->delete(); 
            DB::table('student_fees')
                ->join('student_classes', 'student_classes.student_fee_id', '=', 'student_fees.id')
                ->join('progress_reports', 'progress_reports.student_fee_id', '=', 'student_fees.id')
                ->where('student_fees.fee_id', $request->fee_to_delete)->delete();
            
            /* Create Invoice */
            $new_invoice_data['student_id']         =   $invoice_data->student_id;
            $new_invoice_data['invoice_items']      =   $filtered_invoice_items;
            $new_invoice_data['date_admission']     =   Carbon::parse($request->admission_date)->format('Y-m-d');
        
            $new_invoice_id =   InvoiceHelper::newFeeInvoice($new_invoice_data);
            DB::table('student_fees')->where('id', $request->student_fee_id)->update([
                'invoice_id'    =>  $new_invoice_id
            ]);
        }
        
        return redirect()->back()->with(['type'=>'success', 'message'=>'Class deleted successfully!']);
    }

    public function findStudents(Request $request){
        $students   =   DB::table('students')
                            ->join('children', 'students.children_id', '=', 'children.id')
                            ->where('children.name', 'LIKE', '%'.$request->keyword.'%')
                            ->select('students.id', 'children.name')
                            ->get();

        return $students;
    }

    public function addStudentClass(Request $request)
    {
        try {
            // Begin the transaction
            DB::beginTransaction();
            
            /* Create student */
            $student_id         =   $request->student_id;

            /* Create Invoice */
            $invoice_data['student_id']         =   $student_id;
            $invoice_data['invoice_items']      =   collect($request->fee)->pluck('fee_info')->toArray();
            $invoice_data['date_admission']     =   Carbon::parse($request->date_admission)->format('Y-m-d');
        
            $new_invoice_id =   InvoiceHelper::newFeeInvoice($invoice_data);
            
            foreach($request->fee as $fee_index=>$fee){
                /* Create Fee */
                $student_fee_id     =   DB::table('student_fees')->insertGetId([
                    'student_id'        =>  $student_id,
                    'centre_id'         =>  $request->centre_id,
                    'fee_id'            =>  $fee['fee_info']['fee_id'],
                    'invoice_id'        =>  $new_invoice_id,
                    'admission_date'    =>  Carbon::parse($request->date_admission)->format('Y-m-d')
                ]);

                /* Create Class */
                foreach($fee['classes'] as $class_key => $class){
                    DB::table('student_classes')->insert([
                        'student_fee_id'    =>  $student_fee_id,
                        'class_id'          =>  $class['class_id'],
                    ]);
                }
                /* Create progress report */
                $progress_report_config_id  =   DB::table('progress_report_configs')->where('programme_id', $fee['fee_info']['programme_id'])->pluck('id')->first();

                $progress_report_id =   DB::table('progress_reports')->insertGetId([
                    'student_fee_id'                =>  $student_fee_id,
                    'progress_report_config_id'     =>  $progress_report_config_id,
                    'month'                         =>  Carbon::parse($request->date_admission)->format('Y-m-d')
                ]);


                $class_days     =   DB::table('classes')->whereIn('id', collect($fee['classes'])->pluck('class_id'))->select('class_day_id as class_day')->get();
                $total_class    =   count($class_days) * 4;

                $total_date_available   =   0;
                foreach($class_days as $data){
                    $date_available =   $this->getDatesForDayOfWeekFromCustomDate($data->class_day, Carbon::parse($request->date_admission)->format('Y-m-d'));
                    foreach($date_available as $date){
                        DB::table('progress_report_details')->insert([
                            'progress_report_id'    => $progress_report_id,
                            'date'                  => $date,
                            'report_data'           => json_encode([]),
                        ]);
                        $total_date_available++;
                    }
                }

                $remaining_days =   $total_class - $total_date_available;
                if($remaining_days != 0){
                    for($i = 1; $i <= $remaining_days; $i++){
                        DB::table('progress_report_details')->insert([
                            'progress_report_id'    => $progress_report_id,
                            'date'                  => now(),
                            'report_data'           => json_encode([]),
                        ]);
                    }
                }
            }
        
            DB::commit();   

            return redirect()->back()->with(['type'=>'success', 'message'=>'New class added!']);
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect(route('students'))->with(['type'=>'error', 'message'=>'Something went wrong, please contact support !']);
        }
    }

    public function setFeeStatus(Request $request)
    {
        DB::table('student_fees')->where('id', $request->data)->update([
            'status' => $request['data']['student_fee_status']
        ]);

        return back()->with(['type'=>'success', 'message' => 'Fee status changed successfully!']);
    }

    /* Usage: $this->getDatesForDayOfWeekFromCustomDate(1, '2023-05-02') */
    public function getDatesForDayOfWeekFromCustomDate($dayOfWeek, $customDate) {
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
}



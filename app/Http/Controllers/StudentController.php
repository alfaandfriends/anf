<?php

namespace App\Http\Controllers;

use App\Classes\CentreHelper;
use App\Classes\InvoiceHelper;
use App\Classes\NotificationHelper;
use App\Classes\OrderHelper;
use App\Classes\ProductHelper;
use App\Classes\ProgrammeHelper;
use App\Classes\StudentHelper;
use App\Classes\UserHelper;
use App\Events\DatabaseTransactionEvent;
use Billplz\Laravel\Billplz;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Inertia\Inertia;

class StudentController extends Controller
{
    public $update_student_config = 7;
    public $malaysia    =   1;
    public $indonesia   =   2;

    public function index(Request $request)
    {
        $allowed_centres    =   Inertia::getShared('allowed_centres');
        if($allowed_centres->isEmpty()){
            return back()->with(['type'=>'error', 'message'=>"Sorry, you don't have access to centres. Please contact support to gain access for centres."]);
        }
        $can_access_centre = $allowed_centres->search(function ($value) {
            return $value->ID == request('centre_id');
        });

        $query          =   DB::table('students')
                                ->leftJoin('children', 'students.children_id', '=', 'children.id')
                                ->leftJoin('wpvt_users', 'children.parent_id', '=', 'wpvt_users.id')
                                ->leftJoin('student_fees', 'students.id', '=', 'student_fees.student_id')
                                ->select([  'students.id as id', 
                                            'children.name as name', 
                                            'wpvt_users.display_name as parent_name', 
                                            'students.status'])
                                ->where('students.status', 1)
                                ->whereNull('student_fees.status')
                                ->groupBy('student_fees.student_id');

        if($request->search){
            $query->where('children.name', 'LIKE', '%'.$request->search.'%');
        }
                    
        $request->centre_id ?   $query->where('student_fees.centre_id', '=', $request->centre_id) : $query->where('student_fees.centre_id', '=', $allowed_centres[0]->ID);

        if($request->date){
            $date = new DateTime($request->date['year']."-".($request->date['month'] + 1)."-01");
            $month = $date->format('m');

            $query->whereYear('student_fees.created_at', '=', $request->date['year'])
                    ->whereMonth('student_fees.created_at', '=', $month);
        }
        else{
            $query->whereYear('student_fees.created_at', '=', Carbon::now()->format('Y'))
                ->whereMonth('student_fees.created_at', '=', Carbon::now()->format('m'));
        }

        $request->merge([
            'centre_id' => $request->centre_id && $can_access_centre ? $request->centre_id : $allowed_centres[0]->ID
        ]);

        return Inertia::render('CentreManagement/Students/Index', [
            'filter'        => request()->all('search', 'centre_id'),
            'students'       => $query->paginate(10),
        ]);
    }
    
    public function inactive(Request $request)
    {
        $allowed_centres    =   Inertia::getShared('allowed_centres');
        if($allowed_centres->isEmpty()){
            return back()->with(['type'=>'error', 'message'=>"Sorry, you don't have access to centres. Please contact support to gain access for centres."]);
        }
        $can_access_centre = $allowed_centres->search(function ($value) {
            return $value->ID == request('centre_id');
        });

        $query          =   DB::table('students')
                                ->leftJoin('children', 'students.children_id', '=', 'children.id')
                                ->leftJoin('wpvt_users', 'children.parent_id', '=', 'wpvt_users.id')
                                ->select([  'students.id as id', 
                                            'children.name as name', 
                                            'wpvt_users.display_name as parent_name', 
                                            'students.status'])
                                ->where('students.status', 0);

        if($request->search){
            $query->where('children.name', 'LIKE', '%'.$request->search.'%');
        }

        $request->merge([
            'centre_id' => $request->centre_id && $can_access_centre ? $request->centre_id : $allowed_centres[0]->ID
        ]);
        
        $query->where('students.status', 0);

        return Inertia::render('CentreManagement/Students/Inactive', [
            'filter'        => request()->all('search', 'centre_id'),
            'students'       => $query->paginate(10),
        ]);
    }
    
    public function unassigned(Request $request)
    {
        $allowed_centres    =   Inertia::getShared('allowed_centres');
        if($allowed_centres->isEmpty()){
            return back()->with(['type'=>'error', 'message'=>"Sorry, you don't have access to centres. Please contact support to gain access for centres."]);
        }
        $can_access_centre = $allowed_centres->search(function ($value) {
            return $value->ID == request('centre_id');
        });

        $query          =   DB::table('students')
                                ->join('children', 'students.children_id', '=', 'children.id')
                                ->leftJoin('student_fees', function ($join) {
                                    $join->on('student_fees.student_id', '=', 'students.id')
                                        ->whereYear('student_fees.created_at', '=', now()->year)
                                        ->whereMonth('student_fees.created_at', '=', now()->format('m'))
                                        ->whereNull('student_fees.status');
                                })
                                ->join('wpvt_users', 'children.parent_id', '=', 'wpvt_users.id')
                                ->select([
                                    'students.id as id',
                                    'children.name as name',
                                    'wpvt_users.display_name as parent_name',
                                    'students.status'
                                ])
                                ->where('students.status', 1)
                                ->where('student_fees.id');

        if($request->search){
            $query->where('children.name', 'LIKE', '%'.$request->search.'%');
        }

        $request->merge([
            'centre_id' => $request->centre_id && $can_access_centre ? $request->centre_id : $allowed_centres[0]->ID
        ]);

        return Inertia::render('CentreManagement/Students/Unassigned', [
            'filter'        => request()->all('search', 'centre_id'),
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
        /* Check for children currency first */
        $child_currency           =   UserHelper::getChildCurrency($request->children_id);

        if(!$child_currency){
            return back()->with(['type'=>'error', 'message'=>'Please set the country for the parent of this child.']);
        }

        try {
            // Begin the transaction
            DB::beginTransaction();

            /* Create student */
            $student_id         =   DB::table('students')->insertGetId([
                'date_joined'    =>  Carbon::now()->format('Y-m-d'),
                'children_id'    =>  $request->children_id,
            ]);
                                            
            /* Create Invoice */
            $invoice_data['student_id']         =   $student_id;
            $invoice_data['children_id']        =   $request->children_id;
            $invoice_data['invoice_items']      =   collect($request->fee)->pluck('fee_info')->toArray();
            $invoice_data['date_admission']     =   Carbon::parse($request->date_admission)->format('Y-m-d');
            $invoice_data['currency']           =   StudentHelper::getStudentCurrency($student_id);
        
            $new_invoice_id                     =   InvoiceHelper::newFeeInvoice($invoice_data);
            
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
            
            /* Create Orders */
            $materials = array_filter($request->fee, function ($item) {
                return data_get($item, 'fee_info.include_material_fee') === true;
            });

            if(!empty($materials)){
                /* Create Orders */
                $order_data['student_id']   =   $student_id;
                $order_data['invoice_id']   =   $new_invoice_id;
                $order_data['products']     =   array_merge(...collect($materials)->pluck('material')->toArray());
                OrderHelper::newOrder($order_data);
            }
        
            DB::commit();   

            $log_data =   'Created student ID '.$student_id;
            event(new DatabaseTransactionEvent($log_data));

            return redirect(route('students'))->with(['type'=>'success', 'message'=>'Admission success !']);
        } catch (\Exception $e) {
            event(new DatabaseTransactionEvent($e));
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
                                    ->leftJoin('countries', 'wpvt_users.user_country_id', '=', 'countries.id')
                                    ->where('students.id', $request->student_id)
                                    ->select([  
                                                'students.id as id', 
                                                'students.status as status', 
                                                'students.date_joined', 
                                                'children.id as children_id', 
                                                'children.name as name', 
                                                'children.date_of_birth as dob', 
                                                'genders.id as gender', 
                                                'wpvt_users.display_name as parent_full_name', 
                                                'countries.calling_code as parent_calling_code', 
                                                'wpvt_users.user_contact as parent_contact', 
                                                'wpvt_users.user_address as parent_address', 
                                                'wpvt_users.user_email as parent_email'])
                                    ->first();

        $result            =   DB::table('classes')
                                    ->leftJoin('student_classes', 'student_classes.class_id', '=', 'classes.id')
                                    ->leftJoin('student_fees', 'student_classes.student_fee_id', '=', 'student_fees.id')
                                    ->leftJoin('class_days', 'classes.class_day_id', '=', 'class_days.id')
                                    ->leftJoin('centres', 'student_fees.centre_id', '=', 'centres.id')
                                    ->leftJoin('class_methods', 'classes.class_method_id', '=', 'class_methods.id')
                                    ->leftJoin('programme_levels', 'classes.programme_level_id', '=', 'programme_levels.id')
                                    ->leftJoin('class_types', 'programme_levels.class_type_id', '=', 'class_types.id')
                                    ->leftJoin('programmes', 'programme_levels.programme_id', '=', 'programmes.id')
                                    ->leftJoin('programme_level_fees', 'student_fees.fee_id', '=', 'programme_level_fees.id')
                                    ->leftJoin('class_types_detail', 'programme_level_fees.class_type_detail_id', '=', 'class_types_detail.id')
                                    ->leftJoin('invoices', 'student_fees.invoice_id', '=', 'invoices.id')
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
                                    ->where(function($query){
                                        $query->whereYear('student_fees.created_at', '=', now()->year)
                                            ->whereMonth('student_fees.created_at', '=', now()->month)
                                            ->whereNull('student_fees.status');
                                    })
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
        // dd($request->all());
        if(!$request->basic_info['name']){
            return back()->with(['type'=>'error', 'message'=>'Student name is required.']);
        }
        if(!$request->basic_info['gender']){
            return back()->with(['type'=>'error', 'message'=>'Student gender is required.']);
        }
        if(!$request->basic_info['dob']){
            return back()->with(['type'=>'error', 'message'=>'Student date of birth is required.']);
        }
        if(!$request->basic_info['date_joined']){
            return back()->with(['type'=>'error', 'message'=>'Student date joined is required.']);
        }

        $children_id    =   DB::table('students')->where('id', $request->student_id)->pluck('children_id')->first();

        DB::table('children')->where('id', $children_id)->update([
            'name'          => $request->basic_info['name'],
            'gender_id'     => $request->basic_info['gender'],
            'date_of_birth' => Carbon::parse($request->basic_info['dob'])->format('Y-m-d'),
        ]);

        DB::table('students')->where('id', $request->student_id)->update([
            'status' => $request->student_status,
            'date_joined' => Carbon::parse($request->basic_info['date_joined'])->format('Y-m-d'),
        ]);



        $log_data =   'Updated student ID '.$request->student_id;
        event(new DatabaseTransactionEvent($log_data));

        
        // if(auth()->user()->is_admin == false){
        //     $data  =   array('approval_data' => $request->all());
        //     NotificationHelper::sendApprovalNotifications($this->update_student_config, $data);
        // }

        return redirect()->back()->with(['type'=>'success', 'message'=>'Student details updated !']);
    }

    public function destroy(Request $request)
    {
        $invoice_data       =  DB::table('invoices')->where('id', $request->invoice_id)->first();
        $invoice_items      =   collect(json_decode($invoice_data->invoice_items, true));
        $student_country    =   StudentHelper::getStudentCountryId($invoice_data->student_id);

        /* Check if paid */ 
        if($student_country == $this->malaysia){
            if($invoice_data->bill_id){
                $bill   =   Billplz::bill()->get($invoice_data->bill_id)->toArray();
                if(!$bill['paid']){
                    Billplz::bill()->destroy($invoice_data->bill_id);
                }
            }
        }
        /* Delete related records */
        if($invoice_items->count() <= 1){
            DB::table('student_fees')
                ->join('student_classes', 'student_classes.student_fee_id', '=', 'student_fees.id')
                ->join('progress_reports', 'progress_reports.student_fee_id', '=', 'student_fees.id')
                ->where('student_fees.invoice_id', $request->invoice_id)->delete();
            DB::table('invoices')->where('id', $request->invoice_id)->delete();
        }
        /* Recreate new record */
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
            $new_invoice_data['children_id']        =   StudentHelper::getChildId($invoice_data->student_id);
            $new_invoice_data['invoice_items']      =   $filtered_invoice_items;
            $new_invoice_data['date_admission']     =   Carbon::parse($request->admission_date)->format('Y-m-d');
            $new_invoice_data['currency']           =   StudentHelper::getStudentCurrency($invoice_data->student_id);
        
            $new_invoice_id =   InvoiceHelper::newFeeInvoice($new_invoice_data);
            
            DB::table('student_fees')->where('invoice_id', $request->invoice_id)->update([
                'invoice_id'    =>  $new_invoice_id
            ]);
            
            $fee_ids            =   $filtered_invoice_items->pluck('fee_id')->toArray();
            $produce_items      =   ProductHelper::getProductDataByFee($fee_ids);

            /* Create Order */
            $order_data['student_id']   =   $invoice_data->student_id;
            $order_data['invoice_id']   =   $new_invoice_id;
            $order_data['products']     =   $produce_items;
            OrderHelper::newOrder($order_data);
        }
        $log_data =   'Deleted student ID ' . $invoice_data->student_id . ' data';
        event(new DatabaseTransactionEvent($log_data));

        return redirect()->back()->with(['type'=>'success', 'message'=>'Student data deleted successfully!']);
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
            $invoice_data['children_id']        =   $request->children_id;
            $invoice_data['invoice_items']      =   collect($request->fee)->pluck('fee_info')->toArray();
            $invoice_data['date_admission']     =   Carbon::parse($request->date_admission)->format('Y-m-d');
            $invoice_data['currency']           =   StudentHelper::getStudentCurrency($student_id);
        
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
            
            $materials = array_filter($request->fee, function ($item) {
                return data_get($item, 'fee_info.include_material_fee') === true;
            });

            if(!empty($materials)){
                /* Create Orders */
                $order_data['student_id']   =   $student_id;
                $order_data['invoice_id']   =   $new_invoice_id;
                $order_data['products']     =   array_merge(...collect($materials)->pluck('material')->toArray());
                OrderHelper::newOrder($order_data);
            }
        
            $log_data =   'Added class for student ID '.$student_id;
            event(new DatabaseTransactionEvent($log_data));

            DB::commit();   

            return redirect()->back()->with(['type'=>'success', 'message'=>'New class added!']);
        } catch (\Exception $e) {
            event(new DatabaseTransactionEvent($e));
            DB::rollback();
            
            return redirect(route('students'))->with(['type'=>'error', 'message'=>'Something went wrong, please contact support !']);
        }
    }

    public function setFeeStatus(Request $request)
    {
        $status     =   $request['data']['student_fee_status'];
        DB::table('student_fees')->where('id', $request['data']['student_fee_id'])->update([
            'status'    => $status,
        ]);
        $log_data =   "Updated fee status for student's fee ID ".$request['data']['student_fee_id'];
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message' => 'Status has been changed successfully!']);
    }

    public function transferStudent(Request $request){
        $centre_info    =   CentreHelper::getCentreInfo($request->centre_id);
        $fee_info       =   collect(DB::table('student_fees')->where('student_id', $request->student_id)->where('id', $request->student_fee_id)->first())->toArray();
        $invoice_info   =   json_decode(DB::table('invoices')->where('id', $fee_info['invoice_id'])->pluck('invoice_items')->first());

        $new_invoice_items  =   collect($invoice_info)->each(function ($item) use ($request, $centre_info) {
            // if ($item->fee_id === $request->fee_id) {
                $item->centre_id = $centre_info['centre_id'] ? $centre_info['centre_id'] : '';
                $item->centre_name = $centre_info['centre_name'] ? $centre_info['centre_name'] : '';
            // }
        })->toArray();

        DB::table('student_fees')->where('student_id', $request->student_id)->where('id', $request->student_fee_id)->update([
            'centre_id'    => $request->centre_id,
        ]);

        DB::table('invoices')->where('id', $fee_info['invoice_id'])->update([
            'invoice_items'    => json_encode($new_invoice_items, JSON_NUMERIC_CHECK),
        ]);

        DB::table('student_classes')->where('student_fee_id', $request->student_fee_id)->delete();
        foreach ($request->fee as $fee) {
            foreach($fee["classes"] as $class_key => $class){
                DB::table('student_classes')->insert([
                    'student_fee_id'    =>  $request->student_fee_id,
                    'class_id'          =>  $class['class_id'],
                ]);
            }
        }

        $log_data =   'Transferred student ID '.$request->student_fee_id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message' => 'Student has been transferred successfully.']);
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



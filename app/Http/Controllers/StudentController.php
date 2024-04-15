<?php

namespace App\Http\Controllers;

use App\Classes\CentreHelper;
use App\Classes\FeeHelper;
use App\Classes\InvoiceHelper;
use App\Classes\NotificationHelper;
use App\Classes\OrderHelper;
use App\Classes\ProductHelper;
use App\Classes\ProgrammeHelper;
use App\Classes\ProgressReportHelper;
use App\Classes\StudentHelper;
use App\Classes\UserHelper;
use App\Events\DatabaseTransactionEvent;
use Billplz\Laravel\Billplz;
use Carbon\Carbon;
use DateTime;
use Illuminate\Console\Command;
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
                                ->groupBy('student_fees.student_id')
                                ->orderBy('children.name');

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
                                ->where('students.status', 0)
                                ->orderBy('children.name');

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
                                ->where('student_fees.id')
                                ->orderBy('children.name');

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
        $promos             =   DB::table('promotions')
                                    ->join('promotion_types', 'promotions.type_id', '=', 'promotion_types.id')
                                    ->join('promotion_durations', 'promotions.duration_id', '=', 'promotion_durations.id')
                                    ->select('promotions.id as promo_id', 'promotions.name as promo_name', 'promotion_types.id as type_id', 
                                            'promotion_types.name as type_name', 'promotions.value as value', 'promotion_durations.id as duration_id', 
                                            'promotion_durations.name as duration_name', 'promotion_durations.duration as duration_count')
                                    ->get();


        return Inertia::render('CentreManagement/Students/Create', [
            'programme_list'    => $programme_list,
            'method_list'       => $method_list,
            'promos'            => $promos,
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

                foreach($fee['fee_info']['promos'] as $promo_index=>$promo){
                    DB::table('student_fee_promotions')->insert([
                        'student_fee_id'        =>  $student_fee_id,
                        'promotion_id'          =>  $promo['promo_id'],
                        'duration_remaining'    =>  $promo['duration_count'] - 1,
                    ]);
                }

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
        // $promos             =   DB::table('promotions')->get();
        $promos             =   DB::table('promotions')
        ->join('promotion_types', 'promotions.type_id', '=', 'promotion_types.id')
        ->join('promotion_durations', 'promotions.duration_id', '=', 'promotion_durations.id')
        ->select('promotions.id as promo_id', 'promotions.name as promo_name', 'promotion_types.id as type_id', 
                'promotion_types.name as type_name', 'promotions.value as value', 'promotion_durations.id as duration_id', 
                'promotion_durations.name as duration_name', 'promotion_durations.duration as duration_count')
        ->get();
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

        $results            =   DB::table('classes')
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
                                    ->leftJoin('student_fee_promotions', 'student_fee_promotions.student_fee_id', '=', 'student_fees.id')
                                    ->leftJoin('promotions', 'student_fee_promotions.promotion_id', '=', 'promotions.id')
                                    ->leftJoin('promotion_types', 'promotions.type_id', '=', 'promotion_types.id')
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
                                                'student_fee_promotions.id as student_fee_promo_id', 
                                                'promotions.id as promo_id', 
                                                'promotions.name as promo_name', 
                                                'promotions.value as promo_value', 
                                                'promotion_types.id as promo_type_id', 
                                                'promotion_types.name as promo_type_name', 
                                                'student_fees.invoice_id as invoice_id', 
                                                'student_fees.admission_date as admission_date', 
                                                'student_fees.id as student_fee_id', 
                                                'student_fees.created_at as fee_month', 
                                                'student_fees.status as student_fee_status')
                                    ->where('student_fees.student_id', $request->student_id)
                                    ->get();

        $student_academics['current'] =  collect($results)->filter(function ($result) {
            return Carbon::parse($result->fee_month)->isCurrentMonth();
        })->groupBy('fee_id')->map(function ($group) {
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
                "fee_month" => $group->first()->fee_month,
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
            
            $promo_exist    =   $group[0]->promo_id ? true : false;
            if($promo_exist){
                $promos =  $group->map(function ($item) {
                    return [
                        "student_fee_promo_id" => $item->student_fee_promo_id,
                        "promo_id" => $item->promo_id,
                        "promo_name" => $item->promo_name,
                        "promo_value" => $item->promo_value,
                        "promo_type_id" => $item->promo_type_id,
                        "promo_type_name" => $item->promo_type_name,
                    ];
                })->values()->all();
            }
            else{
                $promos =  [];
            }

            return [
                "classes" => $classes,
                "fee_info" => array_merge($fee_info, ["promos" => $promos]),
            ];
        })->values()->all(); 


        $academics = [];
        $fees_by_month  =   collect($results)->groupBy('fee_month');
        foreach ($fees_by_month as $fees) {
            foreach($fees as $fee){
                $info['class_id']       =   $fee->class_id;
                $info['class_day']      =   $fee->class_day;
                $info['start_time']     =   $fee->start_time;
                $info['end_time']       =   $fee->end_time;
                $classes[$fee->student_fee_id][]   =   $info;
            }
        }
        foreach ($fees_by_month as $fees) {
            foreach($fees as $fee){
                $info['programme_id']           =   $fee->programme_id;
                $info['programme_name']         =   $fee->programme_name;
                $info['programme_level']        =   $fee->programme_level;
                $info['programme_type']         =   $fee->programme_type;
                $info['programme_fee']          =   $fee->programme_fee;
                $info['material_fee']           =   $fee->material_fee;
                $info['fee_id']                 =   $fee->fee_id;
                $info['centre_id']              =   $fee->centre_id;
                $info['centre_name']            =   $fee->centre_name;
                $info['class_type_id']          =   $fee->class_type_id;
                $info['class_method']           =   $fee->class_method;
                $info['invoice_id']             =   $fee->invoice_id;
                $info['student_fee_status']     =   $fee->student_fee_status;
                $info['student_fee_id']         =   $fee->student_fee_id;
                $info['fee_month']              =   $fee->fee_month;
                $info['classes']                =   $classes[$fee->student_fee_id];
                $academics[$fee->student_fee_id] =   $info;
            }
        }

        $student_academics['history']   =   !empty($academics) ? collect($academics)->filter(function ($fee) {
            return $fee['fee_month'] < Carbon::now()->format('Y-m');
        }) : [];

        $gender_list        =   DB::table('genders')->get();
        $programme_list     =   ProgrammeHelper::programmes();
        $method_list        =   DB::table('class_methods')->get();
        $fee_status        =   DB::table('student_fee_status')->get();
        
        return Inertia::render('CentreManagement/Students/Edit', [
            'student_info'          =>  $student_info,
            'student_academics'     =>  $student_academics,
            'gender_list'           =>  $gender_list,
            'programme_list'        =>  $programme_list,
            'method_list'           =>  $method_list,
            'fee_status'            =>  $fee_status,
            'promos'                =>  $promos
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
        $invoice_data       =   DB::table('invoices')->where('id', $request->invoice_id)->first();
        if(!$invoice_data){
            DB::table('student_fees')
                ->join('student_classes', 'student_classes.student_fee_id', '=', 'student_fees.id')
                ->join('progress_reports', 'progress_reports.student_fee_id', '=', 'student_fees.id')
                ->where('student_fees.invoice_id', $request->invoice_id)->delete();
        }
        else{
            $invoice_items      =   collect(json_decode($invoice_data->invoice_items, true));
            $student_country    =   StudentHelper::getStudentCountryId($invoice_data->student_id);
    
            /* Check if paid */ 
            if(env('APP_ENV') != 'local'){
                if($student_country == $this->malaysia){
                    if($invoice_data->bill_id){
                        $bill   =   Billplz::bill()->get($invoice_data->bill_id)->toArray();
                        if(!$bill['paid']){
                            Billplz::bill()->destroy($invoice_data->bill_id);
                        }
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
                DB::table('orders')->where('invoice_id', $request->invoice_id)->delete();
            }
            /* Recreate new record */
            else{
                /* Remove fee in invoice json */
                $filtered_invoice_items = $invoice_items->reject(function ($item) use ($request) {
                    return $item["centre_id"] == $request->centre_id && $item["programme_id"] == $request->programme_id;
                })->values();
    
                /* Remove fee in table */
                DB::table('invoices')->where('id', $request->invoice_id)->delete(); 
                DB::table('student_fees')
                    ->join('student_classes', 'student_classes.student_fee_id', '=', 'student_fees.id')
                    ->join('progress_reports', 'progress_reports.student_fee_id', '=', 'student_fees.id')
                    ->where('student_fees.id', $request->student_fee_id)->delete();
                DB::table('orders')->where('invoice_id', $request->invoice_id)->delete();
                
                /* Create latest Invoice */
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
            
            $log_data =   'Deleted student fee ID ' . $invoice_data->student_id . ' data';
            event(new DatabaseTransactionEvent($log_data));
        }

        return redirect()->back()->with(['type'=>'success', 'message'=>'Student data deleted successfully!']);
    }

    public function findStudents(Request $request){
        $students   =   DB::table('students')
                            ->join('children', 'students.children_id', '=', 'children.id')
                            ->join('wpvt_users', 'children.parent_id', '=', 'wpvt_users.id')
                            ->where('children.name', 'LIKE', '%'.$request->keyword.'%')
                            ->select('students.id', 'children.name', 'wpvt_users.user_address')
                            ->get();

        return $students;
    }

    public function findDigitalArtStudents(Request $request){
        $digital_art_programme_id   =   [3, 5];
        $students   =   DB::table('students')
                            ->join('children', 'students.children_id', '=', 'children.id')
                            ->join('student_fees', 'student_fees.student_id', '=', 'students.id')
                            ->join('programme_level_fees', 'student_fees.fee_id', '=', 'programme_level_fees.id')
                            ->join('programme_levels', 'programme_level_fees.programme_level_id', '=', 'programme_levels.id')
                            ->join('programmes', 'programme_levels.programme_id', '=', 'programmes.id')
                            ->where('children.name', 'LIKE', '%'.$request->keyword.'%')
                            ->whereIn('programmes.id', $digital_art_programme_id)
                            ->whereNull('student_fees.status')
                            ->whereYear('student_fees.created_at', '=', now()->year)
                            ->whereMonth('student_fees.created_at', '=', now()->month)
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
            
            return back()->with(['type'=>'error', 'message'=>'Something went wrong, please contact support !']);
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

    public function addPromo(Request $request){

        
        $fee_info       =   collect(DB::table('student_fees')->where('id', $request->student_fee_id)->first())->toArray();
        $invoice_info   =   json_decode(DB::table('invoices')->where('id', $fee_info['invoice_id'])->pluck('invoice_items')->first(), true);
        

        $updated_fees = collect($invoice_info)->map(function ($fee) use ($request){
            if ($fee['fee_id'] === $request->fee_id) {
                $fee['promos'][] = [
                    "value" => $request->data['value'],
                    "type_id" => $request->data['type_id'],
                    "promo_id" => $request->data['promo_id'],
                    "type_name" => $request->data['type_name'],
                    "promo_name" => $request->data['promo_name'],
                    "duration_id" => $request->data['duration_id'],
                    "duration_name" => $request->data['duration_name'],
                    "duration_count" => $request->data['duration_count']
                ];
            }
            return $fee;
        });
        
        DB::table('invoices')->where('id', $fee_info['invoice_id'])->delete(); 
        
        DB::table('student_fee_promotions')->insert([
            'student_fee_id'        =>  $request->student_fee_id,
            'promotion_id'          =>  $request->data['promo_id'],
            'duration_remaining'    =>  $request->data['duration_count'] - 1,
        ]);
        
        /* Create latest Invoice */
        $new_invoice_data['student_id']         =   $fee_info['student_id'];
        $new_invoice_data['children_id']        =   StudentHelper::getChildId($fee_info['student_id']);
        $new_invoice_data['invoice_items']      =   $updated_fees;
        $new_invoice_data['date_admission']     =   now()->format('Y-m-d');
        $new_invoice_data['currency']           =   StudentHelper::getStudentCurrency($fee_info['student_id']);
    
        $new_invoice_id =   InvoiceHelper::newFeeInvoice($new_invoice_data);
        
        DB::table('student_fees')->where('invoice_id', $fee_info['invoice_id'])->update([
            'invoice_id'    =>  $new_invoice_id
        ]);

        $log_data =   'Added Promo for '.$request->student_fee_id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message' => 'Promo added successfully.']);
    }

    public function deletePromo(Request $request){
        // $centre_info    =   CentreHelper::getCentreInfo($request->centre_id);
        $student_id     =   $request->form['student_id'];
        $fee_info       =   collect(DB::table('student_fees')->where('student_id', $student_id)->where('id', $request->student_fee_id)->first())->toArray();
        $invoice_info   =   json_decode(DB::table('invoices')->where('id', $fee_info['invoice_id'])->pluck('invoice_items')->first(), true);

        $filtered_invoice_items = array_map(function ($fee) use ($request) {
            if (isset($fee['promos']) && $fee['fee_id'] === (int)$request->fee_id) {
                $fee['promos'] = array_filter($fee['promos'], function ($promo) use ($request) {
                    return $promo['promo_id'] !== (int)$request->promo_id;
                });
            }
            return $fee;
        }, $invoice_info);
        
        /* Remove fee in table */
        DB::table('invoices')->where('id', $fee_info['invoice_id'])->delete(); 
        DB::table('student_fee_promotions')->where('student_fee_id', $request->student_fee_id)->where('promotion_id', $request->promo_id)->delete();
        
        /* Create latest Invoice */
        $new_invoice_data['student_id']         =   $fee_info['student_id'];
        $new_invoice_data['children_id']        =   StudentHelper::getChildId($fee_info['student_id']);
        $new_invoice_data['invoice_items']      =   $filtered_invoice_items;
        $new_invoice_data['date_admission']     =   Carbon::parse($request->admission_date)->format('Y-m-d');
        $new_invoice_data['currency']           =   StudentHelper::getStudentCurrency($fee_info['student_id']);
    
        $new_invoice_id =   InvoiceHelper::newFeeInvoice($new_invoice_data);
        
        DB::table('student_fees')->where('invoice_id', $fee_info['invoice_id'])->update([
            'invoice_id'    =>  $new_invoice_id
        ]);

        $log_data =   'Deleted Promo for '.$request->student_fee_id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message' => 'Promo deleted successfully.']);
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

    public function generateMonthly(){
        
        try {
            DB::beginTransaction();
            $progress_report_configs    =   collect(DB::table('progress_report_configs')->get());
            $raw_fee_collection         =   collect(FeeHelper::getMonthlyActiveFees());
            DB::table('student_fee_promotions')->decrement('duration_remaining', 1);
            DB::table('student_fee_promotions')->where('duration_remaining', 0)->delete();
            $promotions                 =   collect(
                                                DB::table('student_fees')
                                                ->join('student_fee_promotions', 'student_fee_promotions.student_fee_id', '=', 'student_fees.id')
                                                ->join('promotions', 'student_fee_promotions.promotion_id', '=', 'promotions.id')
                                                ->join('promotion_types', 'promotions.type_id', '=', 'promotion_types.id')
                                                ->join('promotion_durations', 'promotions.duration_id', '=', 'promotion_durations.id')
                                                ->select('student_fees.student_id as student_id', 'student_fees.fee_id as fee_id', 'promotions.id as promo_id', 
                                                        'promotions.name as promo_name', 'promotion_types.id as type_id', 'promotion_types.name as type_name', 
                                                        'promotion_durations.id as duration_id', 'promotion_durations.name as duration_name', 
                                                        'promotion_durations.duration as duration_count', 'promotions.value as value')
                                                ->get()
                                            );

            $student_promos     =   $promotions->groupBy('student_id')->map(function ($promo_array) {
                return $promo_array->groupBy('fee_id')->map(function ($promos) {
                    return $promos->map(function ($promo) {
                        return (array) $promo;
                    });
                    return $promos;
                })->toArray();
            })->toArray();

            $added_material_collection  =   $raw_fee_collection->map(function ($item) use ($student_promos) {
                return array_merge((array)$item, [
                    "include_material_fee" => false,
                    "material_fee_discount" => 0,
                    "programme_fee_discount" => 0,
                    "promos" => $student_promos[$item->student_id][$item->fee_id] ?? [],
                ]);
            });

            $finalized = $added_material_collection->groupBy('student_id')->map(function ($raw_data) {
                return $raw_data->groupBy('fee_id')->map(function ($fee_info) {
                    $class_items = $fee_info->pluck('class_id')->toArray();
                    
                    return $fee_info->map(function ($info) use ($class_items) {
                        $info['class_items'] = $class_items;
                        unset($info['class_id']);
                        unset($info['student_id']);
                        return $info;
                    })->first();
                });
            });

            /* Reset running index */
            $fee_collection = collect([]);
            foreach ($finalized as $studentId => $feeGroups) {
                $reset_index = $feeGroups->values();
                $fee_collection->put($studentId, $reset_index);
            }

            /*  */
            $fee_collection =   $fee_collection->toArray();
            foreach($fee_collection as $student_id=>$fees){
                $temps_class_items = [];

                foreach($fees as &$fee){
                    $temps_class_items[$fee['fee_id']] = $fee['class_items'];
                    unset($fee['class_items']);
                }

                /* Create invoice */
                $invoice_data['student_id']         =   $student_id;
                $invoice_data['children_id']        =   StudentHelper::getChildId($student_id);
                $invoice_data['invoice_items']      =   $fees;
                $invoice_data['date_admission']     =   Carbon::now()->startOfMonth()->format('Y-m-d');
                $invoice_data['currency']           =   StudentHelper::getStudentCurrency($student_id);

                $new_invoice_id =   InvoiceHelper::newFeeInvoice($invoice_data);

                // Reinsert class items
                foreach($fees as &$fee){
                    $fee['class_items'] = $temps_class_items[$fee['fee_id']];
                }

                foreach($fees as &$fee){
                    /* Create Fee */
                    $student_fee_id     =   DB::table('student_fees')->insertGetId([
                        'student_id'        =>  $student_id,
                        'centre_id'         =>  $fee['centre_id'],
                        'fee_id'            =>  $fee['fee_id'],
                        'invoice_id'        =>  $new_invoice_id,
                        'admission_date'    =>  Carbon::now()->startOfMonth()->format('Y-m-d'),
                        'created_at'        =>  Carbon::now()->startOfMonth()->format('Y-m-d')
                    ]);

                    /* Create Class */
                    foreach($fee['class_items'] as $class){
                        DB::table('student_classes')->insert([
                            'student_fee_id'    =>  $student_fee_id,
                            'class_id'          =>  $class,
                        ]);
                    }
                    
                    /* Create progress report */
                    $progress_report_config_id  =   $progress_report_configs->where('programme_id', $fee['programme_id'])->pluck('id')->first();
                    $progress_report_id =   DB::table('progress_reports')->insertGetId([
                        'student_fee_id'                =>  $student_fee_id,
                        'progress_report_config_id'     =>  $progress_report_config_id,
                        'month'                         =>  Carbon::now()->startOfMonth()->format('Y-m-d')
                    ]);

                    /* Calculate how many days a week */
                    $class_days     =   DB::table('classes')->whereIn('id', $fee['class_items'])->select('class_day_id as class_day')->get();
                    $total_class    =   count($class_days) * 4;

                    /* Create class based on student selected date */
                    $total_date_available   =   0;
                    foreach($class_days as $data){
                        $date_available =   ProgressReportHelper::getDatesForDayOfWeekFromCustomDate($data->class_day, Carbon::now()->startOfMonth()->format('Y-m-d'));
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
            }
            DB::commit();
            return Command::SUCCESS;
        } catch (\Exception $e) {
            DB::rollback();
            
            $log_data =   'Generate invoice failed';
            event(new DatabaseTransactionEvent($log_data));
            event(new DatabaseTransactionEvent($e));
            return Command::FAILURE;
        }
    }
}



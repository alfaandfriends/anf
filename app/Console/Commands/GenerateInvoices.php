<?php

namespace App\Console\Commands;

use App\Classes\FeeHelper;
use App\Classes\InvoiceHelper;
use App\Classes\ProgressReportHelper;
use App\Classes\StudentHelper;
use App\Events\DatabaseTransactionEvent;
use App\Http\Controllers\StudentController;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class GenerateInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {   
        try {
            DB::beginTransaction();
            $progress_report_configs    =   collect(DB::table('progress_report_configs')->get());
            $raw_collection             =   collect(FeeHelper::getMonthlyActiveFees());

            $student_fee_ids    =   $raw_collection->pluck('student_fee_id');
            $students_promos    =   collect(DB::table('student_fee_promotions')
                                        ->join('promotions', 'student_fee_promotions.promotion_id', '=', 'promotions.id')
                                        ->join('countries', 'promotions.country_id', '=', 'countries.id')
                                        ->join('promotion_durations', 'promotions.duration_id', '=', 'promotion_durations.id')
                                        ->join('promotion_types', 'promotions.type_id', '=', 'promotion_types.id')
                                        ->whereIn('student_fee_promotions.student_fee_id', $student_fee_ids)
                                        ->whereMonth('student_fee_promotions.created_at', '=', now()->subMonth()->format('m'))
                                        ->select(
                                            'student_fee_promotions.student_fee_id as student_fee_id',
                                            'student_fee_promotions.duration_remaining as duration_remaining',
                                            'promotions.id as promo_id', 
                                            'promotions.name as promo_name',
                                            'countries.id as country_id', 
                                            'countries.name as country_name', 
                                            'promotion_durations.id as duration_id', 
                                            'promotion_durations.name as duration_name', 
                                            'promotion_types.id as type_id', 
                                            'promotion_types.name as type_name', 
                                            'promotions.value as value')
                                        ->get());

            event(new DatabaseTransactionEvent($students_promos));
                                

            $added_material_collection  =   $raw_collection->map(function ($item) use ($students_promos) {
                $promos = $students_promos->filter(function ($promo) use ($item) {
                    return $promo->duration_remaining >= 0 && $promo->student_fee_id === $item->student_fee_id;
                })->map(function ($promo) {
                    return (array) $promo;
                });
                
                // Convert the collection to a plain array
                $promosArray = $promos->isEmpty() ? [] : $promos->all();

                return array_merge((array)$item, [
                    "include_registration_fee" => false,
                    "include_material_fee" => false,
                    "registration_fee_discount" => 0,
                    "material_fee_discount" => 0,
                    "programme_fee_discount" => 0,
                    "promos" => $promosArray,
                ]);
            });
            event(new DatabaseTransactionEvent($added_material_collection));

            DB::table('student_fee_promotions')->delete();

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

                    foreach($fee['promos'] as $promo_index=>$promo){
                        if($promo['duration_remaining'] - 1 >= 0){
                            DB::table('student_fee_promotions')->insert([
                                'student_fee_id'        =>  $student_fee_id,
                                'promotion_id'          =>  $promo['promo_id'],
                                'duration_remaining'    =>  $promo['duration_remaining'] - 1,
                            ]);
                        }
                    }

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

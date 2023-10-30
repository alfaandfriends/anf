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

            $added_material_collection  =   $raw_collection->map(function ($item) {
                return array_merge((array)$item, [
                    "include_material_fee" => false,
                    "material_fee_discount" => 0,
                    "programme_fee_discount" => 0,
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

            $fee_collection = collect([]);
            foreach ($finalized as $studentId => $feeGroups) {
                $reset_index = $feeGroups->values();
                $fee_collection->put($studentId, $reset_index);
            }

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
                        'admission_date'    =>  Carbon::now()->startOfMonth()->format('Y-m-d')
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
            DB::commit(); // Commit the transaction if everything was successful
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

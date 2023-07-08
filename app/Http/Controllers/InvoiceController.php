<?php

namespace App\Http\Controllers;

use App\Classes\CentreHelper;
use App\Classes\ClassHelper;
use App\Classes\InvoiceHelper;
use App\Classes\ProgrammeHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class InvoiceController extends Controller
{
    private $fee_invoice_id   =   1;
    private $product_invoice_id   =   2;

    public function feeInvoiceIndex(Request $request)
    {
        $query =   DB::table('invoices')
                        ->join('students', 'invoices.student_id', '=', 'students.id')
                        ->join('children', 'students.children_id', '=', 'children.id')
                        ->leftJoin('user_basic_information', 'children.parent_id', '=', 'user_basic_information.user_id')
                        ->join('invoice_status', 'invoices.status', '=', 'invoice_status.id')
                        ->where('invoice_type_id', $this->fee_invoice_id)
                        ->select('invoices.id', 'invoices.invoice_number', 'invoices.invoice_items', 'children.name as student_name', 
                                    'user_basic_information.user_first_name as parent_first_name', 'user_basic_information.user_last_name as parent_last_name', 
                                    'user_basic_information.user_address as parent_address', 'invoices.date_issued', 'invoices.due_date', 'invoices.amount', 
                                    'invoice_status.name as status', 'invoice_status.bg_color as status_bg_color', 'invoice_status.text_color as status_text_color');
        if($request->search){
            $query->where('children.name', 'LIKE', '%'.request('search').'%')
                ->orWhere('invoices.invoice_number', 'LIKE', '%'.request('search').'%')
                ->orWhere('invoice_status.name', 'LIKE', '%'.request('search').'%');
        }   
        
        if($request->centre_id){
            $query->where('invoices.invoice_items', 'LIKE', '%centre_id": "'.$request->centre_id.'%');
        }     
        
        if($request->programme_id){
            $query->where('invoices.invoice_items', 'LIKE', '%programme_id": "'.$request->programme_id.'%');
        }     
        
        if($request->date){
            $query->where('invoices.date_issued', 'LIKE', '%'.$request->date['year'].'-0'.$request->date['month']  + 1 .'%');
        }         

        $programmes =   ProgrammeHelper::programmes();
        
        return Inertia::render('Invoices/Index', [
            'filter'        =>  request()->all('search', 'centre_id', 'programme_id', 'date'),
            'invoices'      =>  $query->paginate(10),
            'programmes'    =>  $programmes,
        ]);
    }

    public function feeInvoiceCreate(){
        $programmes     =   ProgrammeHelper::programmes();
        $fee_types      =   ClassHelper::classTypeDetails();
        $levels         =   ProgrammeHelper::distinctLevels();
        $payment_status =   InvoiceHelper::invoiceStatus();

        return Inertia::render('Invoices/Create', [
            'programmes'        =>  $programmes,
            'fee_types'         =>  $fee_types,
            'levels'            =>  $levels,
            'payment_status'    =>  $payment_status,
        ]);
    }
    
    public function feeInvoiceStore(Request $request){
        
        $currentYear        =   Carbon::now()->year;
        $invoice_config     =   DB::table('invoice_config')->whereYear('year', $currentYear)->first();

        $quota_exceeded    =   $this->checkInvoiceQuota($invoice_config);
        
        if($quota_exceeded){
            return redirect(route('fee.invoices'))->with(['type'=>'error', 'message'=>'Invoice quota exceeded, please contact technical support!']);
        }
        
        $invoice_number    =   $this->getCurrentYearInvoiceNumber($invoice_config);

        if($request->file('payment.proof.file')){
            $file = $request->file('payment.proof.file');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            Storage::putFileAs('proof_of_payment', $request->file('payment.proof.file'), $filename);
        }

        DB::table('invoices')->insert([
            'invoice_type_id'           => $this->fee_invoice_id,
            'student_id'                => $request->student_id,
            'invoice_number'            => $invoice_number,
            'invoice_items'             => json_encode($request->invoice_items),
            'date_issued'               => Carbon::parse($request->date_issued)->format('Y-m-d'),
            'due_date'                  => Carbon::parse($request->due_date)->format('Y-m-d'),
            'amount'                    => $request->invoice_amount,
            'status'                    => $request->status,
            'payment_date'              => Carbon::parse($request->payment['date'])->format('Y-m-d'),
            'payment_transaction_id'    => $request->payment['transaction_id'],
            'payment_proof'             => $request->file('payment.proof') ? $filename : '',
        ]);

        return redirect(route('fee.invoices'))->with(['type'=>'success', 'message'=>'New invoice created successfully !']);
    }

    public function feeInvoiceEdit(Request $request){
        $invoice_data   =   DB::table('invoices')
                                ->join('students', 'invoices.student_id', '=', 'students.id')
                                ->join('children', 'students.children_id', '=', 'children.id')
                                ->select('invoices.id', 'invoices.invoice_number', 'invoices.invoice_items', 'children.name as student_name', 
                                            'invoices.date_issued', 'invoices.due_date', 'invoices.amount', 'invoices.status as status',
                                            'invoices.payment_date', 'invoices.payment_transaction_id', 'invoices.payment_proof')
                                ->where('invoices.id', $request->invoice_id)->first();

        $invoice_status  =   InvoiceHelper::invoiceStatus();

        return Inertia::render('Invoices/Edit', [
            'invoice_data'      =>  $invoice_data,
            'invoice_status'    =>  $invoice_status
        ]);
    }

    public function feeInvoiceUpdate(Request $request){
        $previous_file  =   DB::table('invoices')->where('id', $request->invoice_id)->pluck('payment_proof')->first();

        if($request->payment['proof']['delete_previous']){
            $file_deleted   =   Storage::delete('proof_of_payment/'.$previous_file);
            $previous_file  =   '';
        }

        if($request->file('payment.proof.file')){
            $file = $request->file('payment.proof.file');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            Storage::putFileAs('proof_of_payment', $request->file('payment.proof.file'), $filename);
        }

        DB::table('invoices')->where('id', $request->invoice_id)->update([
            'invoice_items'             =>  $request->invoice_items,
            'amount'                    =>  $request->invoice_amount,
            'status'                    =>  $request->payment['status'],
            'payment_date'              =>  Carbon::parse($request->payment['date'])->format('Y-m-d'),
            'payment_transaction_id'    =>  $request->payment['transaction_id'],
            'payment_proof'             =>  $request->file('payment.proof') ? $filename : $previous_file,
        ]);

        return redirect(route('fee.invoices'))->with(['type'=>'success', 'message'=>'Invoice updated successfully !']);
    }

    public function getCurrentYearInvoiceNumber($invoice_config){

        $quota              =   $invoice_config->quota;
        $current_count      =   $invoice_config->current_count;

        $invoice_number =   str_pad($current_count + 1, strlen((string)$quota), '0', STR_PAD_LEFT);

        DB::table('invoice_config')->whereYear('year', Carbon::now()->year)->update([
            'quota'         => $quota - 1 ,
            'current_count' => $current_count + 1 ,
        ]);

        return $invoice_number; 

    }

    public function checkInvoiceQuota($invoice_config){

        $quota              =   $invoice_config->quota;
        $quota_exceeded     =   $quota < 1 ? true : false;

        return  $quota_exceeded;
    }
}

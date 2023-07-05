<?php

namespace App\Http\Controllers;

use App\Classes\InvoiceHelper;
use App\Classes\ProgrammeHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query =   DB::table('invoices')
                        ->join('students', 'invoices.student_id', '=', 'students.id')
                        ->join('children', 'students.children_id', '=', 'children.id')
                        ->join('user_basic_information', 'children.parent_id', '=', 'user_basic_information.user_id')
                        ->join('invoice_status', 'invoices.status', '=', 'invoice_status.id')
                        ->select('invoices.id', 'invoices.invoice_number', 'invoices.invoice_items', 'children.name as student_name', 
                                    'user_basic_information.user_first_name as parent_first_name', 'user_basic_information.user_last_name as parent_last_name', 
                                    'user_basic_information.user_address as parent_address', 'invoices.date_issued', 'invoices.due_date', 'invoices.amount', 
                                    'invoice_status.name as status', 'invoice_status.bg_color as status_bg_color', 'invoice_status.text_color as status_text_color');
        if($request->search){
            $query->where('children.name', 'LIKE', '%'.request('search').'%')
                ->orWhere('invoices.invoice_number', 'LIKE', '%'.request('search').'%')
                ->orWhere('invoice_status.name', 'LIKE', '%'.request('search').'%');
        }
        
        if($request->programme_id){
            $query->where('invoices.invoice_items', 'LIKE', '%"programme_id": "'.$request->programme_id.'%');
        }                   

        $programmes     =   ProgrammeHelper::programmes();
        
        return Inertia::render('Invoices/Index', [
            'filter'            =>  request()->all('search', 'programme_id'),
            'invoices'          =>  $query->paginate(10),
            'programmes'        =>  $programmes
        ]);
    }
    
    public function edit(Request $request){
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

    public function update(Request $request){
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

        return redirect(route('invoices'))->with(['type'=>'success', 'message'=>'Invoice updated successfully !']);
    }
}

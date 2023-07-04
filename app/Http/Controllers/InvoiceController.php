<?php

namespace App\Http\Controllers;

use App\Classes\PaymentHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        // if($request->search){
        //     $query->where('invoices.title', 'LIKE', '%'.request('search').'%');
        // }
        
        // if($request->programme_id){
        //     $query->where('programmes.id', $request->programme_id);
        // }                   

        $programmes     =   DB::table('programmes')->get();
        
        return Inertia::render('Invoices/Index', [
            // 'filter'            =>  request()->all('search', 'programme_id'),
            'invoices'          =>  $query->paginate(10),
            'programmes'        =>  $programmes
        ]);
    }
    
    public function edit(Request $request){
        $invoice_data   =   DB::table('invoices')
                                ->join('students', 'invoices.student_id', '=', 'students.id')
                                ->join('children', 'students.children_id', '=', 'children.id')
                                ->join('invoice_status', 'invoices.status', '=', 'invoice_status.id')
                                ->select('invoices.id', 'invoices.invoice_number', 'invoices.invoice_items', 'children.name as student_name', 
                                            'invoices.date_issued', 'invoices.due_date', 'invoices.amount', 
                                            'invoice_status.name as status', 'invoice_status.bg_color as status_bg_color', 'invoice_status.text_color as status_text_color')
                                ->where('invoices.id', $request->invoice_id)->first();

        $payment_types  =   PaymentHelper::paymentTypes();

        return Inertia::render('Invoices/Edit', [
            'invoice_data'      =>  $invoice_data,
            'payment_types'     =>  $payment_types
        ]);
    }

    public function update(Request $request){

        DB::table('invoices')->where('id', $request->invoice_id)->update([
            'invoice_items' => json_encode($request->invoice_items)
        ]);

        return redirect(route('invoices'))->with(['type'=>'success', 'message'=>'Invoice updated successfully !']);
    }
}

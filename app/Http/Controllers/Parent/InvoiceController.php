<?php

namespace App\Http\Controllers\Parent;

use App\Classes\InvoiceHelper;
use App\Classes\ProgrammeHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $invoices =   InvoiceHelper::getStudentFeeInvoices($request->session()->get('current_active_child.student_id'));
        
        return Inertia::render('Parent/Invoice/Index', [
            'invoices'      =>  $invoices,
        ]);
    }

    public function callback(Request $request)
    {
        if($request->billplz['paid'] == 'true'){
            DB::table('invoices')->where('bill_id', $request->billplz['id'])->update([
                'status'    => 2
            ]);
            return redirect(route('parent.invoices'))->with([
                'type'=>'success',
                'header'=>'Payment Successful!',
                'message'=>'Thank you. Your transaction has been completed.'
            ]);
        }
        else{
            return redirect(route('parent.invoices'))->with([
                'type'=>'error',
                'header'=>'Payment Unsuccessful!',
                'message'=>'Sorry, payment process has failed. Please try again.'
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers\Parent;

use App\Classes\InvoiceHelper;
use App\Classes\ProgrammeHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        if(!$request->paid){
            return redirect(route('parent.invoices'))->with(['type'=>'error', 'message'=>'Payment not complete.']);
        }
    }
    public function callbackRedirect(Request $request)
    {
        dd($request->all());
    }
}

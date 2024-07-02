<?php

namespace App\Http\Controllers\Parent;

use App\Classes\InvoiceHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        if(!session('current_active_programme.id')){
            return redirect(route('parent.home'))->with(['type' => 'error', 'message' => 'Unable to fetch class data']);
        }

        $invoices =   InvoiceHelper::getStudentFeeInvoices();
        
        return Inertia::render('Parent/Class/Invoices', [
            'invoices'          =>  $invoices,
        ]);
    }
}

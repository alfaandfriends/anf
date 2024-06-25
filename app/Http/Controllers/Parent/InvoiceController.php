<?php

namespace App\Http\Controllers\Parent;

use App\Classes\InvoiceHelper;
use App\Classes\PostHelper;
use App\Classes\ProgrammeHelper;
use App\Http\Controllers\Controller;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        if(!session('current_active_programme.id')){
            return redirect(route('parent.home'))->with(['type' => 'error', 'message' => 'Unable to fetch class data']);
        }

        $invoices =   InvoiceHelper::getStudentFeeInvoices($request->session()->get('current_active_child.student_id'));
        
        return Inertia::render('Parent/Class/Invoices', [
            'invoices'          =>  $invoices,
        ]);
    }
}

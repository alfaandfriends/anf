<?php

namespace App\Http\Controllers\Parent;

use App\Classes\InvoiceHelper;
use App\Http\Controllers\Controller;
use Billplz\Laravel\Billplz;
use DB;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Log;

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

    public function paymentStatus($bill_id){
        $bill_info = Billplz::bill()->get($bill_id)->getContent();
        
        if($bill_info['paid']){
            $response = [
                'payment_type' => 'billplz',
                'url_redirect' => env('VITE_BILLPLZ_ENDPOINT').$bill_id
            ];
        }
        else{
            $invoice_id = DB::table('invoices')->where('bill_id', $bill_id)->pluck('id')->first();
            $file_name = DB::table('invoice_attachments')->where('invoice_id', $invoice_id)->pluck('attachment')->first();
            $attachment = '/storage/proof_of_payment/'.$file_name;
            $response = [
                'payment_type' => 'manual',
                'url_redirect' => $attachment
            ];
        }
        Log::error(json_encode($bill_info));
        Log::error(json_encode($response));

        return $response;
    }
}

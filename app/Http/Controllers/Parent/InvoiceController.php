<?php

namespace App\Http\Controllers\Parent;

use App\Classes\ProgrammeHelper;
use App\Http\Controllers\Controller;
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
                        ->leftJoin('user_basic_information', 'children.parent_id', '=', 'user_basic_information.user_id')
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

        return Inertia::render('Parent/Invoice/Index', [
            'filter'        =>  request()->all('search', 'centre_id', 'programme_id', 'date'),
            'invoices'      =>  $query->paginate(10),
            'programmes'    =>  $programmes,
        ]);
    }
}

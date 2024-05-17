<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Centre;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


class PipelineController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('CRM/Sales/Pipelines/Index',[
        ]);
    }

    public function create()
    {
        $lead_sources           =   DB::table('crm_lead_sources')->get();
        $school_types           =   DB::table('crm_school_types')->get();
        $pic_positions          =   DB::table('crm_pic_positions')->get();
        $progress_percentage    =   DB::table('crm_progress_percentage')->get();
        $case_status            =   DB::table('crm_case_status')->get();
        $programs               =   DB::table('crm_programs')->get();

        return Inertia::render('CRM/Sales/Pipelines/Create',[
            'lead_sources'          => $lead_sources,
            'school_types'          => $school_types,
            'pic_positions'         => $pic_positions,
            'progress_percentage'   => $progress_percentage,
            'case_status'           => $case_status,
            'programs'              => $programs
        ]);
    }
    
    public function store(Request $request)
    {
        dd($request->all());
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DiagnosticTestController extends Controller
{

    /* Diagnostic Test Run */
    public function dtStartList(){
        $diagnostic_test_list       =   DB::table('diagnostic_test')->get();

        return Inertia::render('Settings/General/DiagnosticTest/Run/List', [
            'diagnostic_test_list' => $diagnostic_test_list,
        ]);
    }

    public function dtStart(Request $request){
        $diagnostic_test_list               =   DB::table('diagnostic_test_details')->where('dt_id', $request->dt_id)->orderBy('ordering', 'asc')->get();
        $diagnostic_test_categories_label   =   DB::table('diagnostic_test_categories')->where('dt_id', $request->dt_id)->get()->pluck('name');
        $diagnostic_test_categories         =   DB::table('diagnostic_test_categories')->where('dt_id', $request->dt_id)->get()->keyBy('id')->pluck('name', 'id');
        
        $result                             =   array();
        $result_score                       =   '';
        
        if($request->final_score != null){
            $result			=   DB::table('diagnostic_test_conditions')->where('dt_id', $request->dt_id)->where('score_capped', '>=', $request->final_score)->orderBy('score_capped', 'asc')->first();
            $result_score   =   $request->final_score;
        }

        return Inertia::render('Settings/General/DiagnosticTest/Run/Start', [
            'diagnostic_test_list' => $diagnostic_test_list,
            'diagnostic_test_categories_label' => $diagnostic_test_categories_label,
            'diagnostic_test_categories' => $diagnostic_test_categories,
            'result' => $result,
            'result_score' => $result_score,
            'dt_id' => $request->dt_id
        ]);
    }
}

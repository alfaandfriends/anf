<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class FeeController extends Controller
{
    public function index()
    {
        $query      =   DB::table('fees')
                            ->join('fee_types', 'fees.fee_type', '=', 'fee_types.id')
                            ->join('fee_periods', 'fees.fee_period', '=', 'fee_periods.id')
                            ->select(   'fees.*', 
                                        'fee_types.id as fee_type_id', 
                                        'fee_types.label as fee_type_label', 
                                        'fee_periods.id as fee_period_id', 
                                        'fee_periods.label as fee_period_label');

        if(request('search')){
            $query->where('label', 'LIKE', '%'.request('search').'%');
        }

        $fees    =   $query->paginate(10);
        
        return Inertia::render('Fees/Index', [
            'filter' => request()->all('search'),
            'fees' => $fees,
        ]);
    }

    public function create()
    {
        $fee_types  =   $this->getFeeTypes();
        $fee_periods  =   $this->getFeePeriods();

        return Inertia::render('Fees/Create',[
            'fee_types'  => $fee_types,
            'fee_periods'  => $fee_periods,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'fee_type'                  => 'required',
            'period'                    => 'required',
            'class_per_week'            => 'required',
            'class_duration_hours'      => 'required',
            'class_duration_minutes'    => 'required',
            'fee_amount'                => 'required',
        ]);

        DB::table('fees')->insert([
            'fee_type'                  =>  $request->fee_type,
            'fee_period'                =>  $request->period,
            'class_duration_hours'      =>  $request->class_duration_hours,
            'class_duration_minutes'    =>  $request->class_duration_minutes,
            'class_per_week'            =>  $request->class_per_week,
            'amount'                    =>  $request->fee_amount,
        ]);

        return redirect(route('fees'))->with(['type'=>'success', 'message'=>'New Fee added successfully !']);
    }

    public function edit(Request $request)
    {
        $fee_types  =   $this->getFeeTypes();
        $fee_periods  =   $this->getFeePeriods();
        $fee_info =   DB::table('fees')
                                ->join('fee_types', 'fees.fee_type', '=', 'fee_types.id')
                                ->join('fee_periods', 'fees.fee_period', '=', 'fee_periods.id')
                                ->select(   'fees.*', 
                                            'fee_types.id as fee_type_id', 
                                            'fee_types.label as fee_type_label', 
                                            'fee_periods.id as fee_period_id', 
                                            'fee_periods.label as fee_period_label')
                                ->where('fees.id', $request->fee_id)->first();
        
        return Inertia::render('Fees/Edit', [
            'fee_info'    => $fee_info,
            'fee_types'  => $fee_types,
            'fee_periods'  => $fee_periods,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'fee_type'                  => 'required',
            'period'                    => 'required',
            'class_per_week'            => 'required',
            'class_duration_hours'      => 'required',
            'class_duration_minutes'    => 'required',
            'fee_amount'                => 'required',
        ]);
        
        DB::table('fees')->where('id', $request->fee_id)->update([
            'fee_type'                  =>  $request->fee_type,
            'fee_period'                =>  $request->period,
            'class_duration_hours'      =>  $request->class_duration_hours,
            'class_duration_minutes'    =>  $request->class_duration_minutes,
            'class_per_week'            =>  $request->class_per_week,
            'amount'                    =>  $request->fee_amount,
        ]);

        return redirect(route('fees'))->with(['type'=>'success', 'message'=>'Fee updated successfully !']);
    }

    public function destroy($id)
    {
        DB::table('fees')->where('id', $id)->delete();

        return redirect(route('fees'))->with(['type'=>'success', 'message'=>'Fee deleted successfully !']);
    }

    public function getFeeTypes()
    {
        $fee_types  =   DB::table('fee_types')->get();

        return $fee_types;
    }

    public function getFeePeriods()
    {
        $fee_periods  =   DB::table('fee_periods')->get();

        return $fee_periods;
    }
}

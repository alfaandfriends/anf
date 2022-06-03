<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class SettingController extends Controller
{
    public function index()
    {
        return Inertia::render('Settings/Index');
    }

    /* Fee Type */
    public function feeTypeList(){
        $fee_type_list  =   DB::table('fee_types')->paginate(10);

        return Inertia::render('Settings/Index',[
            'fee_type_list' => $fee_type_list,
        ]);
    }

    public function addFeeType()
    {
        return Inertia::render('Settings/FeeType/Create');
    }

    public function storeFeeType(Request $request)
    {
        $request->validate([
            'fee_type'  => 'required'
        ]);

        DB::table('fee_types')->insert([
            'label' =>  $request->fee_type
        ]);

        return redirect(route('settings.fee_type_list'))->with(['type'=>'success', 'message'=>'Fee type added successfully !']);
    }

    public function editFeeType(Request $request)
    {
        $fee_type_info  =   DB::table('fee_types')->where('id', $request->fee_type_id)->first();
        
        return Inertia::render('Settings/FeeType/Edit', [
            'fee_type_info' =>  $fee_type_info
        ]);
    }

    public function updateFeeType(Request $request)
    {
        $request->validate([
            'fee_type'  => 'required'
        ]);

        DB::table('fee_types')->where('id', $request->fee_type_id)->update([
            'label' =>  $request->fee_type
        ]);

        return redirect(route('settings.fee_type_list'))->with(['type'=>'success', 'message'=>'Fee type updated successfully !']);
    }

    public function destroyFeeType($id)
    {   
        DB::table('fee_types')->where('id', $id)->delete();

        return back()->with(['type'=>'success', 'message'=>'Fee type deleted successfully ! ']);
    }

    /* Fee Period */
    public function feePeriodList(){
        $fee_period_list  =   DB::table('fee_periods')->paginate(10);

        return Inertia::render('Settings/Index',[
            'fee_period_list' => $fee_period_list,
        ]);
    }

    public function addFeePeriod()
    {
        return Inertia::render('Settings/FeePeriod/Create');
    }

    public function storeFeePeriod(Request $request)
    {
        $request->validate([
            'fee_period'  => 'required'
        ]);

        DB::table('fee_periods')->insert([
            'label' =>  $request->fee_period
        ]);

        return redirect(route('settings.fee_period_list'))->with(['type'=>'success', 'message'=>'Fee Period added successfully !']);
    }

    public function editFeePeriod(Request $request)
    {
        $fee_period_info  =   DB::table('fee_periods')->where('id', $request->fee_period_id)->first();
        
        return Inertia::render('Settings/FeePeriod/Edit', [
            'fee_period_info' =>  $fee_period_info
        ]);
    }

    public function updateFeePeriod(Request $request)
    {
        $request->validate([
            'fee_period'  => 'required'
        ]);

        DB::table('fee_periods')->where('id', $request->fee_period_id)->update([
            'label' =>  $request->fee_period
        ]);

        return redirect(route('settings.fee_period_list'))->with(['type'=>'success', 'message'=>'Fee period updated successfully !']);
    }

    public function destroyFeePeriod($id)
    {
        DB::table('fee_periods')->where('id', $id)->delete();

        return back()->with(['type'=>'success', 'message'=>'Fee period deleted successfully ! ']);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

use function GuzzleHttp\Promise\all;

class SettingController extends Controller
{
    /* Class Type */
        public function classTypeList(){
            $class_types  =   DB::table('class_types')->paginate(10);

            return Inertia::render('Settings/CentreManagement/Index',[
                'class_types' => $class_types,
            ]);
        }

        public function addClassType(){
            return Inertia::render('Settings/CentreManagement/ClassTypes/Create');
        }

        public function storeClassType(Request $request){
            $request->validate([
                'class_type'  => 'required'
            ]);

            DB::table('class_types')->insert([
                'name' =>  $request->class_type
            ]);

            return redirect(route('settings.class_types'))->with(['type'=>'success', 'message'=>'Class type added successfully !']);
        }

        public function editClassType(Request $request){
            $class_type_info  =   DB::table('class_types')->where('id', $request->class_type_id)->first();
            
            return Inertia::render('Settings/CentreManagement/ClassTypes/Edit', [
                'class_type_info' =>  $class_type_info
            ]);
        }

        public function updateClassType(Request $request){
            $request->validate([
                'class_type'  => 'required'
            ]);

            DB::table('class_types')->where('id', $request->class_type_id)->update([
                'name' =>  $request->class_type,
                'updated_at'        => Carbon::now(),
            ]);

            return redirect(route('settings.class_types'))->with(['type'=>'success', 'message'=>'Class type updated successfully !']);
        }

        public function destroyClassType($id){   
            DB::table('class_types')->where('id', $id)->delete();

            return back()->with(['type'=>'success', 'message'=>'Class type deleted successfully ! ']);
        }

    /* Countries */
        public function countryList(){
            $country_list  =   DB::table('countries')->paginate(10);

            return Inertia::render('Settings/General/Countries/Index',[
                'country_list' => $country_list,
            ]);
        }

        public function addCountry(){
            return Inertia::render('Settings/General/Countries/Create');
        }

        public function storeCountry(Request $request){
            $request->validate([
                'fee_period'  => 'required'
            ]);

            DB::table('fee_periods')->insert([
                'label' =>  $request->fee_period
            ]);

            return redirect(route('settings.fee_period_list'))->with(['type'=>'success', 'message'=>'Fee Period added successfully !']);
        }

        public function editCountry(Request $request){
            $fee_period_info  =   DB::table('fee_periods')->where('id', $request->fee_period_id)->first();
            
            return Inertia::render('Settings/General/Countries/Edit', [
                'fee_period_info' =>  $fee_period_info
            ]);
        }

        public function updateCountry(Request $request){
            $request->validate([
                'fee_period'  => 'required',
                'updated_at'  => Carbon::now(),
            ]);

            DB::table('fee_periods')->where('id', $request->fee_period_id)->update([
                'label' =>  $request->fee_period
            ]);

            return redirect(route('settings.fee_period_list'))->with(['type'=>'success', 'message'=>'Fee period updated successfully !']);
        }

        public function destroyCountry($id){
            DB::table('fee_periods')->where('id', $id)->delete();

            return back()->with(['type'=>'success', 'message'=>'Fee period deleted successfully ! ']);
        }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class SettingController extends Controller
{
    public function index(){
        return Inertia::render('Settings/CentreManagement/Index');
    }

    /* Fee Type */
        public function feeTypeList(){
            $fee_type_list  =   DB::table('fee_types')->paginate(10);

            return Inertia::render('Settings/CentreManagement/Index',[
                'fee_type_list' => $fee_type_list,
            ]);
        }

        public function addFeeType(){
            return Inertia::render('Settings/CentreManagement/FeeType/Create');
        }

        public function storeFeeType(Request $request){
            $request->validate([
                'fee_type'  => 'required'
            ]);

            DB::table('fee_types')->insert([
                'label' =>  $request->fee_type
            ]);

            return redirect(route('settings.fee_type_list'))->with(['type'=>'success', 'message'=>'Fee type added successfully !']);
        }

        public function editFeeType(Request $request){
            $fee_type_info  =   DB::table('fee_types')->where('id', $request->fee_type_id)->first();
            
            return Inertia::render('Settings/CentreManagement/FeeType/Edit', [
                'fee_type_info' =>  $fee_type_info
            ]);
        }

        public function updateFeeType(Request $request){
            $request->validate([
                'fee_type'  => 'required'
            ]);

            DB::table('fee_types')->where('id', $request->fee_type_id)->update([
                'label' =>  $request->fee_type
            ]);

            return redirect(route('settings.fee_type_list'))->with(['type'=>'success', 'message'=>'Fee type updated successfully !']);
        }

        public function destroyFeeType($id){   
            DB::table('fee_types')->where('id', $id)->delete();

            return back()->with(['type'=>'success', 'message'=>'Fee type deleted successfully ! ']);
        }

    /* Fee Period */
        public function feePeriodList(){
            $fee_period_list  =   DB::table('fee_periods')->paginate(10);

            return Inertia::render('Settings/CentreManagement/Index',[
                'fee_period_list' => $fee_period_list,
            ]);
        }

        public function addFeePeriod(){
            return Inertia::render('Settings/CentreManagement/FeePeriod/Create');
        }

        public function storeFeePeriod(Request $request){
            $request->validate([
                'fee_period'  => 'required'
            ]);

            DB::table('fee_periods')->insert([
                'label' =>  $request->fee_period
            ]);

            return redirect(route('settings.fee_period_list'))->with(['type'=>'success', 'message'=>'Fee Period added successfully !']);
        }

        public function editFeePeriod(Request $request){
            $fee_period_info  =   DB::table('fee_periods')->where('id', $request->fee_period_id)->first();
            
            return Inertia::render('Settings/CentreManagement/FeePeriod/Edit', [
                'fee_period_info' =>  $fee_period_info
            ]);
        }

        public function updateFeePeriod(Request $request){
            $request->validate([
                'fee_period'  => 'required'
            ]);

            DB::table('fee_periods')->where('id', $request->fee_period_id)->update([
                'label' =>  $request->fee_period
            ]);

            return redirect(route('settings.fee_period_list'))->with(['type'=>'success', 'message'=>'Fee period updated successfully !']);
        }

        public function destroyFeePeriod($id){
            DB::table('fee_periods')->where('id', $id)->delete();

            return back()->with(['type'=>'success', 'message'=>'Fee period deleted successfully ! ']);
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
                'fee_period'  => 'required'
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
    
    /* Diagnostic Test */
        public function dtList()
        {
            $diagnostic_test_list           =   DB::table('diagnostic_test')->paginate(10);

            return Inertia::render('Settings/General/DiagnosticTest/Index', [
                'diagnostic_test_list' => $diagnostic_test_list,
            ]);
        }

        public function dtDetailsList(Request $request){
            $diagnostic_test_list           =   DB::table('diagnostic_test_details')->where('dt_id', $request->dt_id)->orderBy('ordering', 'asc')->get();
            $diagnostic_test_conditions     =   DB::table('diagnostic_test_scoring')->where('dt_id', $request->dt_id)->orderBy('score_capped', 'asc')->get();

            return Inertia::render('Settings/General/DiagnosticTest/Details/Index', [
                'diagnostic_test_id' => $request->dt_id,
                'diagnostic_test_list' => $diagnostic_test_list,
                'diagnostic_test_conditions' => $diagnostic_test_conditions
            ]);
        }

        public function dtDetailsCreate(Request $request){
            $redirect_url   =   url()->previous();

            return Inertia::render('Settings/General/DiagnosticTest/Details/Create', [
                'diagnostic_test_id' => $request->dt_id,
                'redirect_url' => $redirect_url,
            ]);
        }

        public function dtDetailsStore(Request $request){
            $request->validate([
                'name'          => 'required',
            ]);

            if(empty($request->file())){
                return back()->with(['type' => 'error', 'message' => 'Please upload an image !']);
            }

            $last_inserted_row  =   DB::table('diagnostic_test_details')->latest('ordering')->first();

            $latest_id  =   DB::table('diagnostic_test_details')->insertGetId([
                'dt_id' => $request->dt_id,
                'name' => $request->name,
                'redirect_yes_id' => $request->redirect_yes,
                'redirect_no_id' => $request->redirect_no,
                'ordering' => $last_inserted_row ? $last_inserted_row->ordering + 1 : 1,
            ]);

            $file_path = Storage::putFile('diagnostic_test_photo', $request->file('image_file')[0]);

            DB::table('diagnostic_test_details')->where('id', $latest_id)->update([
                'image_location' => $file_path
            ]);

            return redirect($request->redirect_url)->with(['type' => 'success', 'message' => 'New Item added successfully !']);
        }

        public function dtDetailsEdit(Request $request){
            $test_id                        =   $request->test_id;
            $diagnostic_test_list           =   DB::table('diagnostic_test_details')->orderBy('ordering', 'asc')->get();
            $diagnostic_test_info           =   DB::table('diagnostic_test_details')->where('id', $request->test_id)->first();
            $diagnostic_test_conditions     =   DB::table('diagnostic_test_scoring')->orderBy('score_capped', 'asc')->get();
            $redirect_url                   =   $request->redirect_url ? $request->redirect_url : url()->previous();

            return Inertia::render('Settings/General/DiagnosticTest/Details/Edit', [
                'test_id' => $test_id,
                'diagnostic_test_list' => $diagnostic_test_list,
                'diagnostic_test_info' => $diagnostic_test_info,
                'diagnostic_test_conditions' => $diagnostic_test_conditions,
                'redirect_url' => $redirect_url
            ]);
        }

        public function dtDetailsUpdate(Request $request){
            $request->validate([
                'name'          => 'required',
            ]);
            
            $diagnostic_test_info    =   DB::table('diagnostic_test_details')->where('id', $request->id)->first();

            if(!$diagnostic_test_info->image_location && empty($request->file())){
                return back()->with(['type' => 'error', 'message' => 'Please upload an image !']);
            }
            
            DB::table('diagnostic_test_details')->where('id', $request->id)->update([
                'name' => $request->name,
                'redirect_yes_id' => $request->redirect_yes,
                'redirect_no_id' => $request->redirect_no,
            ]);

            if(!empty($request->file('image_file'))){

                if(Storage::exists($diagnostic_test_info->image_location)){
                    Storage::delete($diagnostic_test_info->image_location);
                }

                $file_path = Storage::putFile('diagnostic_test_photo', $request->file('image_file')[0]);

                DB::table('diagnostic_test_details')->where('id', $request->id)->update([
                    'image_location' => $file_path
                ]);
            }

            return redirect($request->redirect_url)->with(['type' => 'success', 'message' => 'Item updated successfully !']);
        }

        public function dtDetailsDestroy($id){   
            $diagnostic_test_info    =   DB::table('diagnostic_test_details')->where('id', $id)->first();

            if($diagnostic_test_info->image_location != ''){
                if(Storage::exists($diagnostic_test_info->image_location)){
                    Storage::delete($diagnostic_test_info->image_location);
                }
            }

            DB::table('diagnostic_test_details')->where('id', $id)->delete();

            return redirect()->back()->with(['type' => 'success', 'message' => 'Item deleted successfully !']);
        }

        public function dtDetailsSort(Request $request){
            foreach($request->sorted_list as $key=>$list){
                DB::table('diagnostic_test_details')->where('id', $list['id'])->update([
                    'ordering' => $key+1
                ]);
            }

            return redirect(route('settings.diagnostic_test'))->with(['type' => 'success', 'message' => 'Item sorted successfully !']);
        }

        public function dtStart(Request $request){
            $diagnostic_test_list       =   DB::table('diagnostic_test_details')->orderBy('ordering', 'asc')->get();
            $result                     =   array();
            $result_score               =   '';
            
            if($request->final_score != null){
                $result			=   DB::table('diagnostic_test_scoring')->where('score_capped', '>=', $request->final_score)->orderBy('score_capped', 'asc')->first();
                $result_score   =   $request->final_score;
            }

            return Inertia::render('Settings/General/DiagnosticTest/Start', [
                'diagnostic_test_list' => $diagnostic_test_list,
                'result' => $result,
                'result_score' => $result_score,
            ]);
        }
}

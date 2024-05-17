<?php

namespace App\Http\Controllers;

use App\Events\DatabaseTransactionEvent;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class CountryController extends Controller
{
    /* Countries */
        public function index(){
            $country_list  =   DB::table('countries')->paginate(10);

            return Inertia::render('Admin/Country/Index',[
                'country_list' => $country_list,
            ]);
        }

        public function create(){
            return Inertia::render('Admin/Country/Create');
        }

        public function store(Request $request){
            $request->validate([
                'country_name'      => 'required',
                'country_code'      => 'required',
                'currency_name'     => 'required',
                'currency_code'     => 'required',
                'currency_symbol'   => 'required',
                'calling_code'      => 'required'
            ]);

            $country_id =   DB::table('countries')->insertGetId([
                'name'              =>  $request->country_name,
                'country_code'      =>  $request->country_code,
                'currency_name'     =>  $request->currency_name,
                'currency_code'     =>  $request->currency_code,
                'currency_symbol'   =>  $request->currency_symbol,
                'calling_code'      =>  $request->calling_code,
            ]);
            
            $log_data =   'Added country ID '.$country_id;
            event(new DatabaseTransactionEvent($log_data));

            return redirect(route('countries'))->with(['type'=>'success', 'message'=>'New country added!']);
        }

        public function destroy($id){
            try {
                DB::beginTransaction();

                DB::table('countries')->where('id', $id)->delete();

                DB::commit();

                $log_data =   'Deleted country ID '.$id;
                event(new DatabaseTransactionEvent($log_data));

                return back()->with(['type'=>'success', 'message'=>'Country deleted successfully! ']);
            } catch (Exception $e) {
                DB::rollback();
                return back()->with(['type'=>'error', 'message'=>'Error occurred, this country is being used! ']);
            }
            
        }

        public function getCountries(){
            $countries  =   DB::table('countries')->get();
            return $countries;
        }

        public function getCountry($id){
            $country  =   DB::table('countries')->where('id', $id)->first();
            return $country;
        }
}

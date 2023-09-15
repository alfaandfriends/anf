<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class CountryController extends Controller
{
    /* Countries */
        public function index(){
            $country_list  =   DB::table('countries')->paginate(10);

            return Inertia::render('Country/Index',[
                'country_list' => $country_list,
            ]);
        }

        public function create(){
            return Inertia::render('Country/Create');
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

            DB::table('countries')->insert([
                'name'              =>  $request->country_name,
                'country_code'      =>  $request->country_code,
                'currency_name'     =>  $request->currency_name,
                'currency_code'     =>  $request->currency_code,
                'currency_symbol'   =>  $request->currency_symbol,
                'calling_code'      =>  $request->calling_code,
            ]);

            return redirect(route('country'))->with(['type'=>'success', 'message'=>'New country added!']);
        }

        public function destroy($id){
            DB::table('countries')->where('id', $id)->delete();

            return back()->with(['type'=>'success', 'message'=>'Country deleted successfully ! ']);
        }
}

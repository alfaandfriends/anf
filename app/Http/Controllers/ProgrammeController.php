<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ProgrammeController extends Controller
{
    public function index()
    {
        $query      =   DB::table('programmes');

        if(request('search')){
            $query->where('name', 'LIKE', '%'.request('search').'%');
        }

        $programmes    =   $query->paginate(10);
        
        return Inertia::render('Programmes/Index', [
            'filter' => request()->all('search'),
            'programmes' => $programmes,
        ]);
    }

    public function create()
    {
        return Inertia::render('Programmes/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'programme_name'               => 'required|max:100',
        ]);

        DB::table('programmes')->insert([
            'name'         =>  $request->programme_name,
            'created_at'    =>  Carbon::now(),
            'updated_at'    =>  Carbon::now(),
            'status'        =>  $request->programme_active,
        ]);

        return redirect(route('programmes'))->with(['type'=>'success', 'message'=>'Programme added successfully !']);
    }

    public function edit(Request $request)
    {
        $programme_info     =   DB::table('programmes')->where('id', $request->programme_id)->first();
        $fee_types          =   DB::table('fee_types')->orderBy('id')->get();
        $fee_types_detail   =   DB::table('fee_types_detail')->get()->groupBy('fee_type_id');
        $programme_fees     =   DB::table('programmes_fees')->select('fee_type_detail_id','amount')->where('programme_id', $request->programme_id)->get();
        // dd($programme_fees);
        
        return Inertia::render('Programmes/Edit', [
            'programme_info'    => $programme_info,
            'fee_types'         => $fee_types,
            'fee_types_detail'  => $fee_types_detail,
            'programme_fees'    => $programme_fees,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'programme_name'               => 'required|max:100',
        ]);

        DB::table('programmes')->where('id', $request->programme_id)->update([
            'name'              =>  $request->programme_name,
            'level'             =>  $request->programme_level,
            'updated_at'        =>  Carbon::now(),
            'status'            =>  $request->programme_active,
        ]);

        DB::table('programmes_fees')->where('programme_id', $request->programme_id)->delete();

        foreach($request->programme_fees as $fee_detail_id=>$amount){
            if($amount){
                DB::table('programmes_fees')->insert([
                    'programme_id'          =>  $request->programme_id,
                    'fee_type_detail_id'    =>  $fee_detail_id,
                    'amount'                =>  $amount,
                ]);
            }
        }

        return redirect(route('programmes'))->with(['type'=>'success', 'message'=>'Programme updated successfully !']);
    }

    public function destroy($id)
    {
        DB::table('programmes')->where('id', $id)->delete();

        return redirect(route('programmes'))->with(['type'=>'success', 'message'=>'Programme deleted successfully !']);
    }
}

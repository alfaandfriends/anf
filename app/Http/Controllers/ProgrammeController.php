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
        $programme_info =   DB::table('programmes')->where('id', $request->programme_id)->first();
        $programme_fees =   DB::table('programmes_fees')->where('programme_id', $request->programme_id)->get()->groupBy('fee_type');
        $fee_types      =   DB::table('fee_types')->orderBy('id')->get();
        
        return Inertia::render('Programmes/Edit', [
            'programme_info'    => $programme_info,
            'programme_fees'    => $programme_fees,
            'fee_types'         => $fee_types,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'programme_name'               => 'required|max:100',
        ]);

        DB::table('programmes')->where('id', $request->programme_id)->update([
            'name'         =>  $request->programme_name,
            'updated_at'    =>  Carbon::now(),
            'status'        =>  $request->programme_active,
        ]);

        return redirect(route('programmes'))->with(['type'=>'success', 'message'=>'Programme updated successfully !']);
    }

    public function destroy($id)
    {
        DB::table('programmes')->where('id', $id)->delete();

        return redirect(route('programmes'))->with(['type'=>'success', 'message'=>'Programme deleted successfully !']);
    }
}

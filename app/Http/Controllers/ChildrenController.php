<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ChildrenController extends Controller
{
    public function create(){
        $children_list      =   DB::table('children')
                                    ->join('genders', 'children.gender_id', '=', 'genders.id')
                                    ->where('parent_id', auth()->id())
                                    ->select(['children.id', 'children.name', 'genders.name as gender', 'children.date_of_birth as dob'])
                                    ->orderBy('children.date_of_birth')
                                    ->get();
        $gender_list        =   DB::table('genders')->get();
        $programme_list     =   DB::table('programmes')->get();

        return Inertia::render('Children/Create', [
            'gender_list'       => $gender_list,
            'programme_list'    => $programme_list,
            'children_list'     => $children_list,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required',
            'gender'          => 'required',
            'dob'            => 'required',
        ]);

        DB::table('children')->insert([
            'parent_id'     => auth()->id(),
            'name'          => $request->name,
            'gender_id'        => $request->gender,
            'date_of_birth' => Carbon::parse($request->dob)->format('Y-m-d'),
        ]);
        
        return redirect()->back()->with(['type'=>'success', 'message'=>'Child added successfully !']);
    }

    public function edit(Request $request){
        $child_info     =   DB::table('children')->where('id', $request->child_id)->first();

        return $child_info;
    }

    public function update(Request $request)
    {
        $request->validate([
            'edit_name'     => 'required',
            'edit_gender'   => 'required',
            'edit_dob'      => 'required',
        ]);

        DB::table('children')->where('id', $request->edit_child_id)->update([
            'name'          => $request->edit_name,
            'gender_id'     => $request->edit_gender,
            'date_of_birth' => Carbon::parse($request->edit_dob)->format('Y-m-d'),
            'updated_at'    => now(),
        ]);

        return redirect()->back()->with(['type'=>'success', 'message'=>'Child updated successfully !']);
    }

    public function destroy($id)
    {
        DB::table('children')->where('id', $id)->delete();
    }
}

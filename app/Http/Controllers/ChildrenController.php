<?php

namespace App\Http\Controllers;

use App\Classes\ProgrammeHelper;
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
        $programme_list     =   ProgrammeHelper::programmes();

        return Inertia::render('Children/Create', [
            'gender_list'       => $gender_list,
            'programme_list'    => $programme_list,
            'children_list'     => $children_list,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required',
            'gender'        => 'required',
            'dob'           => 'required',
        ]);

        DB::table('children')->insert([
            'parent_id'     => $request->parent_id,
            'name'          => $request->name,
            'gender_id'     => $request->gender,
            'date_of_birth' => Carbon::parse($request->dob)->format('Y-m-d'),
        ]);
        
        return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
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

        return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
    }

    public function destroy($id)
    {
        $record_exists   =   DB::table('students')->where('children_id', $id)->exists();
        if($record_exists){
            return back()->with(['type'=>'error', 'message'=>'Unable to delete this child as there are associated records within the application.']);
        }
        DB::table('children')->where('id', $id)->delete();

        return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
    }

    public function findChildren(Request $request){
        $children   =   DB::table('children')
                            ->join('wpvt_users', 'children.parent_id', '=', 'wpvt_users.ID')
                            ->where('children.name', 'LIKE', '%'.$request->keyword.'%')
                            ->whereNotExists(function ($query) {
                                $query->select(DB::raw(1))
                                      ->from('students')
                                      ->whereColumn('students.children_id', 'children.id');
                            })
                            ->select(['children.id', 'children.name'])->get();

        return $children;
    }
}

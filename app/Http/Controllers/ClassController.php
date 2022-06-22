<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ClassController extends Controller
{
    public function index()
    {
        $query      =   DB::table('wpvt_10_wlsm_classes');

        if(request('search')){
            $query->where('label', 'LIKE', '%'.request('search').'%');
        }

        $classes    =   $query->paginate(10);
        
        return Inertia::render('Classes/Index', [
            'filter' => request()->all('search'),
            'classes' => $classes
        ]);
    }

    public function create()
    {
        return Inertia::render('Classes/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_name'               => 'required|max:100',
        ]);

        DB::table('wpvt_10_wlsm_classes')->insert([
            'label'         =>  $request->class_name,
            'created_at'    =>  Carbon::now(),
            'updated_at'    =>  Carbon::now(),
            'status'        =>  $request->class_active,
        ]);

        return redirect(route('classes'))->with(['type'=>'success', 'message'=>'Class added successfully !']);
    }

    public function edit(Request $request)
    {
        $class_info =   DB::table('wpvt_10_wlsm_classes')->where('ID', $request->class_id)->first();
        
        return Inertia::render('Classes/Edit', [
            'class_info'    => $class_info
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'class_name'               => 'required|max:100',
        ]);

        DB::table('wpvt_10_wlsm_classes')->where('ID', $request->class_id)->update([
            'label'         =>  $request->class_name,
            'updated_at'    =>  Carbon::now(),
            'status'        =>  $request->class_active,
        ]);

        return redirect(route('classes'))->with(['type'=>'success', 'message'=>'Class updated successfully !']);
    }

    public function destroy($id)
    {
        DB::table('wpvt_10_wlsm_classes')->where('ID', $id)->delete();

        return redirect(route('classes'))->with(['type'=>'success', 'message'=>'Class deleted successfully !']);
    }
}

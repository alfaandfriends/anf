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
        $centres    =   DB::table('wpvt_10_wlsm_schools')->orderBy('ID')->get(['ID as value','label']);

        $query      =   DB::table('programmes')
                            ->join('wpvt_10_wlsm_class_school', 'programmes.id', '=', 'wpvt_10_wlsm_class_school.programme_id')
                            ->join('wpvt_10_wlsm_schools', 'wpvt_10_wlsm_class_school.school_id', '=', 'wpvt_10_wlsm_schools.ID');

        if(request('search')){
            $query->where('name', 'LIKE', '%'.request('search').'%');
        }

        if(request('centre')){
            $query->where('wpvt_10_wlsm_schools.ID', request('centre'));
        }

        $programmes    =   $query->select('programmes.*')->distinct()->paginate(10);
        
        return Inertia::render('Programmes/Index', [
            'filter' => request()->all('search', 'centre'),
            'programmes' => $programmes,
            'centres' => $centres
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
        
        return Inertia::render('Programmes/Edit', [
            'programme_info'    => $programme_info
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

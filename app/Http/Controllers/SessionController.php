<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class SessionController extends Controller
{
    public function index()
    {
        $query      =   DB::table('wpvt_10_wlsm_sessions');

        if(request('search')){
            $query->where('label', 'LIKE', '%'.request('search').'%');
        }

        $sessions    =   $query->paginate(10);
        
        return Inertia::render('Sessions/Index', [
            'filter' => request()->all('search'),
            'sessions' => $sessions
        ]);
    }

    public function create()
    {
        return Inertia::render('Sessions/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'session'               => 'required|max:100',
            'start_date'            => 'required',
            'end_date'              => 'required',
        ]);

        DB::table('wpvt_10_wlsm_sessions')->insert([
            'label'         =>  $request->session,
            'start_date'    =>  Carbon::parse($request->start_date)->toDateString(),
            'end_date'      =>  Carbon::parse($request->end_date)->toDateString(),
            'created_at'    =>  Carbon::now(),
            'updated_at'    =>  Carbon::now(),
        ]);

        return redirect('sessions')->with(['type'=>'success', 'message'=>'Session added successfully !']);
    }

    public function edit(Request $request)
    {
        $session_info =   DB::table('wpvt_10_wlsm_sessions')->where('ID', $request->session_id)->first();
        
        return Inertia::render('Sessions/Edit', [
            'session_info'    => $session_info
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'session'               => 'required|max:100',
            'start_date'            => 'required',
            'end_date'              => 'required',
        ]);
        
        DB::table('wpvt_10_wlsm_sessions')->where('ID', $request->session_id)->update([
            'label'         =>  $request->session,
            'start_date'    =>  Carbon::parse($request->start_date)->toDateString(),
            'end_date'      =>  Carbon::parse($request->end_date)->toDateString(),
            'updated_at'    =>  Carbon::now(),
        ]);

        return redirect('sessions')->with(['type'=>'success', 'message'=>'Session updated successfully !']);
    }

    public function destroy($id)
    {
        DB::table('wpvt_10_wlsm_sessions')->where('ID', $id)->delete();

        return redirect('sessions')->with(['type'=>'success', 'message'=>'Session deleted successfully !']);
    }
}

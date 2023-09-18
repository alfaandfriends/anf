<?php

namespace App\Http\Controllers\Parent;

use App\Classes\StudentHelper;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function onboarding()
    {
        if(auth()->user()->profile_updated){
            return redirect(route('parent.home'));
        }

        $countries = DB::table('countries')->get();

        return Inertia::render('Parent/Onboard', [
            'countries' => $countries
        ]);
    }

    public function index(Request $request)
    {
        $student_id =   $request->session()->get('current_active_child.student_id');
        if($student_id){
            $academics  =   StudentHelper::studentAcademicDetails($student_id);
        }

        return Inertia::render('Parent/Home',[
            'academics'    =>  $academics ?? ''
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function switchChild(Request $request){
        $child_session_data =   [
            'child_id'      =>  $request->child_id, 
            'child_name'    =>  $request->child_name, 
            'student_id'    =>  $request->student_id
        ]; 
        $request->session()->put('current_active_child', $child_session_data);

        return true;
    }
}

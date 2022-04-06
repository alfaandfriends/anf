<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SchoolController extends Controller
{
    public function index()
    {
        $query  =   School::query();
        
        if(request('search')){
            $query  ->where('label', 'LIKE', '%'.request('search').'%')
                    ->orWhere('email', 'LIKE', '%'.request('search').'%');
        }

        $results    =   $query->orderBy('id')->paginate(10);

        return Inertia::render('Schools/Index', [
            'filter'=>request()->all('search'),
            'schools' => $results,
        ]);
    }

    public function create()
    {
        return Inertia::render('Schools/Create');
    }

    public function store(Request $request)
    {
        dd($request->validate([
            'centre_name'       => 'required|max:20',
            'centre_contact'    => 'required|max:50',
            'centre_email'      => 'required|max:50',
            'centre_address'    => 'required|max:50',
            'menu_status'       => 'required|max:50',
        ]));
        return redirect('schools')->with(['type'=>'success', 'message'=>'School added successfully !']);
    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}

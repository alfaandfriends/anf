<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function create()
    {
        $info = DB::table('user_basic_information')->where('user_id', auth()->user()->ID)->first();
        
        return Inertia::render('Profile/Create', [
            'info' => $info
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name'        => 'required',
            'last_name'         => 'required',
            'country'           => 'required',
            'calling_code'      => 'required',
            'contact_number'    => 'required',
            'country_state'     => 'required',
            'address'           => 'required',
        ]);

        $user_info    =   DB::table('user_basic_information')
                            ->where('user_id', auth()->user()->ID)
                            ->first();

        if(empty($user_info)){
            $path   = Storage::putFile('profile_photo', $request->file('profile_photo'));
            DB::table('user_basic_information')
                ->insert([
                    'user_id'           => auth()->user()->ID,
                    'user_first_name'   => $request->first_name,
                    'user_last_name'    => $request->last_name,
                    'user_calling_code' => $request->calling_code,
                    'user_contact'      => $request->contact_number,
                    'user_address'      => $request->address,
                    'user_country'      => $request->country,
                    'user_state'        => $request->country_state,
                    'user_country_code' => $request->country_code,
                    'user_photo'        => $path,
                ]);
        }

        if(!empty($user_info) && $request->file('profile_photo')){
            if($user_info->user_photo){
                Storage::delete($user_info->user_photo);
            }
            $path = Storage::putFile('profile_photo', $request->file('profile_photo'));
            DB::table('user_basic_information')
                ->where('user_id', auth()->user()->ID)
                ->update([
                    'user_photo'        => $path,
                ]);
        }
        
        DB::table('wpvt_users')
            ->where('ID', auth()->user()->ID)
            ->update(['display_name' => $request->first_name.' '.$request->last_name]);

        DB::table('user_basic_information')
            ->where('user_id', auth()->user()->ID)
            ->update([
                'user_first_name'   => $request->first_name,
                'user_last_name'    => $request->last_name,
                'user_calling_code' => $request->calling_code,
                'user_contact'      => $request->contact_number,
                'user_address'      => $request->address,
                'user_country'      => $request->country,
                'user_state'        => $request->country_state,
                'user_country_code' => $request->country_code,
            ]);

        return redirect()->back()->with(['type'=>'success', 'message'=>'Profile has been saved !']);
    }
}

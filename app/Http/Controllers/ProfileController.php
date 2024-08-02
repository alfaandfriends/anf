<?php

namespace App\Http\Controllers;

use Corcel\Model\User;
use Corcel\Services\PasswordService;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    public function create()
    {
        $user_info  =   DB::table('wpvt_users')
                            ->leftJoin('countries', 'wpvt_users.user_country_id', '=', 'countries.id')
                            ->where('wpvt_users.id', auth()->user()->ID)
                            ->select('wpvt_users.id', 'wpvt_users.display_name', 'wpvt_users.user_country_id', 'wpvt_users.user_state', 'wpvt_users.user_address', 
                                    'wpvt_users.user_contact', 'wpvt_users.user_photo', 'countries.name', 'countries.country_code', 'countries.currency_name', 
                                    'countries.currency_code', 'countries.currency_symbol', 'countries.calling_code')
                            ->first();
                            
        $countries = DB::table('countries')->get();
        
        return Inertia::render('Profile/Create', [
            'user_info' => $user_info,
            'countries' => $countries
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name'         => 'required',
            'country_id'        => 'required',
            'contact_number'    => 'required',
            'country_state'     => 'required',
            'address'           => 'required',
        ]);

        $user_info    =   User::where('ID', auth()->user()->ID)->first();

        if(isset($request->file('profile_photo')['file'])){
            Storage::delete($user_info->user_photo);
            $path   =   Storage::putFile('profile_photo', $request->file('profile_photo')['file']);
            User::where('ID', auth()->user()->ID)
                ->update([
                    'user_photo'        => $path,
                ]);
        }
        
        User::where('ID', auth()->user()->ID)
            ->update([
                'display_name'      => $request->full_name,
                'user_country_id'   => $request->country_id,
                'user_contact'      => $request->contact_number,
                'user_address'      => $request->address,
                'user_state'        => $request->country_state,
                'profile_updated'   => true,
            ]);

        return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
    }

    public function storeSecurity(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password'     => 'required',
            'new_password'         => 'required',
            'confirm_new_password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with(['type'=>'error', 'message'=>'Please fill in all the required fields']);
        }

        $password_service           =   new PasswordService();
        $current_password_match     =   $password_service->check($request->current_password, auth()->user()->user_pass);

        if(!$current_password_match){
            return  redirect()->back()
                    ->withErrors(['current_password'=>'Current password does not match']) 
                    ->withInput()->with(['type'=>'error', 'message'=>'Current password does not match']);
        }

        if($request->new_password != $request->confirm_new_password){
            
            return  redirect()->back()
                    ->withErrors(['new_password'=> 'New password does not match.', 'confirm_new_password'=> 'New password does not match'])
                    ->withInput()->with(['type'=>'error', 'message'=>'New password does not match']);
        }

        $request->user()->fill([
            'user_pass' => $password_service->makeHash($request->new_password)
        ])->save();


        return back()->with(['type'=>'success', 'message'=>'Password has been changed.']);

    }
}

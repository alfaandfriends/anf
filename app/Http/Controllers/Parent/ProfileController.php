<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Corcel\Model\User;
use DB;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function create()
    {
        $user_info = DB::table('wpvt_users')
                        ->leftJoin('countries', 'wpvt_users.user_country_id', '=', 'countries.id')
                        ->where('wpvt_users.id', auth()->user()->ID)
                        ->select('wpvt_users.id', 'wpvt_users.display_name', 'wpvt_users.user_country_id', 'wpvt_users.user_state', 'wpvt_users.user_address', 
                                'wpvt_users.user_contact', 'wpvt_users.user_photo', 'countries.name', 'countries.country_code', 'countries.currency_name', 
                                'countries.currency_code', 'countries.currency_symbol', 'countries.calling_code')
                        ->first();
        $countries = DB::table('countries')->get();
        
        return Inertia::render('Parent/Profile/Profile', [
            'user_info' => $user_info,
            'countries' => $countries
        ]);
    }
    public function security()
    {
        $user_info = User::where('ID', auth()->user()->ID)->first();
        
        return Inertia::render('Parent/Profile/Security', [
            'user_info' => $user_info
        ]);
    }
}

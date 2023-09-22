<?php

namespace App\Classes;

use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class UserHelper {

    public static function getCurrentUserCurrency()
    {
        $user_currenct_currency =   DB::table('wpvt_users')
                                        ->leftJoin('countries', 'wpvt_users.user_country_id', '=', 'countries.id')
                                        ->where('wpvt_users.id', auth()->user()->ID)
                                        ->pluck('countries.currency_symbol')
                                        ->first();

        return $user_currenct_currency;
    }
}
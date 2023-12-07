<?php

namespace App\Classes;

use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class UserHelper {

    public static function getChildCountryId($children_id)
    {
        $children_country_id =   DB::table('children')
                                    ->join('wpvt_users', 'children.parent_id', '=', 'wpvt_users.id')
                                    ->where('children.id', $children_id)
                                    ->pluck('wpvt_users.user_country_id')
                                    ->first();
        return $children_country_id;
    }

    public static function getChildCurrency($children_id)
    {
        $children_currency =   DB::table('children')
                                    ->join('wpvt_users', 'children.parent_id', '=', 'wpvt_users.id')
                                    ->join('countries', 'wpvt_users.user_country_id', '=', 'countries.id')
                                    ->where('children.id', $children_id)
                                    ->pluck('countries.currency_symbol')
                                    ->first();
        return $children_currency;
    }
}
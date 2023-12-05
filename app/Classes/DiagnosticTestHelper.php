<?php

namespace App\Classes;

use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DiagnosticTestHelper {

    public static function getLanguages()
    {
        $languages   =   DB::table('diagnostic_test_languages')->get();

        return $languages;
    }

    public static function getAges()
    {
        $ages   =   DB::table('diagnostic_test_ages')->get();

        return $ages;
    }
}
<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;

class CountryService
{
    public function getCountries()
    {
        return  DB::table('countries')->get();
    }

    public function getPaginatedCountries($perPage)
    {
        return  DB::table('countries')->paginate($perPage);
    }
}
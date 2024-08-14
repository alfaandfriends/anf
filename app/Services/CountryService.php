<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;

class CountryService
{
    public function getCountries()
    {
        return  DB::table('countries')->get();
    }

    public function getPaginatedCountries($perPage, $request)
    {
        return  DB::table('countries')
                    ->when($request->search, function ($query) use ($request) {
                        $query->where('name', 'LIKE', "%$request->search%");
                    })
                    ->paginate($perPage);
    }
}
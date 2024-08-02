<?php

namespace App\Http\Controllers;

use App\Services\CentreService;
use App\Services\CountryService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CentreController extends Controller
{
    public $centreService;
    public $countryService;
    public $update_centre_config = 1;
    public $delete_centre_config = 2;

    public function __construct(CentreService $centreService, CountryService $countryService)
    {
        $this->centreService    =   $centreService;
        $this->countryService   =   $countryService;
    }

    public function index()
    {
        $results    =   $this->centreService->getCentres(request('search'));

        return Inertia::render('CentreManagement/Centres/Index', [
            'filter'    => request()->only('search'),
            'centres'   => $results,
        ]);
    }

    public function create()
    {
        $countries  =   $this->countryService->getCountries();

        return Inertia::render('CentreManagement/Centres/Create', [
            'countries' => $countries
        ]);
    }

    public function store(Request $request)
    {   
        // dd($request->all());
        $this->centreService->createCentre($request);
        
        return redirect(route('centres'))->with(['type'=>'success', 'message'=>'Data has been added.']);
    }

    public function edit(Request $request)
    {
        $countries      =   $this->countryService->getCountries();
        $centre_info    =   $this->centreService->getCentreByID($request->centre_id);
        $centre_images  =   $this->centreService->getCentreImages($request->centre_id);
    
        return Inertia::render('CentreManagement/Centres/Edit', [
            'centre_info' => $centre_info,
            'centre_images' => $centre_images,
            'countries' => $countries,
        ]);
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $this->centreService->deleteImages($request);
        $this->centreService->updateCentre($request);

        return redirect(route('centres'))->with(['type'=>'success', 'message'=>'Data has been saved.']);
    }

    public function destroy($id)
    {
        $this->centreService->deleteCentre($id);

        return redirect(route('centres'))->with(['type'=>'success', 'message'=>'Data has been deleted.']);
    }
}

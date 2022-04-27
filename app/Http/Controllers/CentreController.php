<?php

namespace App\Http\Controllers;

use App\Models\Centre;
use Carbon\Carbon;
use Corcel\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class CentreController extends Controller
{
    public function index()
    {
        $query  =   Centre::query();
        
        if(request('search')){
            $query  ->where('label', 'LIKE', '%'.request('search').'%')
                    ->orWhere('email', 'LIKE', '%'.request('search').'%');
        }

        $results    =   $query->orderBy('id')->paginate(10);

        return Inertia::render('Centres/Index', [
            'filter'=>request()->all('search'),
            'centres' => $results,
        ]);
    }

    public function create(Request $request)
    {
        if($request->principal_email){
            $email_exist    =   User::where('user_email', $request->principal_email)->first();
            if(!empty($email_exist)){
                $email_exist      =   DB::table('user_basic_information')->where('user_id', $email_exist->ID)->first();
            }
        }
        else{
            $email_exist    =   null;
        }
        
        return Inertia::render('Centres/Create', [
            'email_exist'=>$email_exist,
        ]);
    }

    public function store(Request $request)
    {   
        $request->validate([
            'centre_name'               => 'required|max:20',
            'centre_contact_number'     => 'required|max:50',
            'centre_email'              => 'required|max:50',
            'centre_address'            => 'required|max:50',
            'principal_email'           => 'required|max:50',
            'principal_contact'         => 'required|max:50',
        ]);

        $email_exist  =   User::where('user_email', $request->principal_email)->count();

        if($email_exist < 1){
            return redirect()->back()->with(['type'=>'error', 'message'=>'Please enter a valid principal email address !']);
        }

        if(empty($request->image_list) || count(collect($request->image_list)->where('type', 'front')) < 1 || count(collect($request->image_list)->where('type', 'inside')) < 1){
            return redirect()->back()->with(['type'=>'error', 'message'=>'Please select required image !']);
        }

        $new_centre_id   =   DB::table('wpvt_10_wlsm_schools')->insertGetId([
                                'label' => 'ANFC_'.$request->centre_name,
                                'phone' => $request->centre_contact_number,
                                'email' => $request->centre_email,
                                'address' => $request->centre_address,
                                'is_active' => $request->school_active,
                                'last_enrollment_count' => 0,
                                'last_invoice_count' => 0,
                                'last_payment_count' => 0,
                                'last_admission_count' => 0,
                                'last_certificate_count' => 0,
                            ]);

        DB::table('wpvt_10_wlsm_schools_principals')->insert([
            'centre_id'         => $new_centre_id,
            'first_name'        => $request->principal_first_name,
            'last_name'         => $request->principal_last_name,
            'email'             => $request->principal_email,
            'contact_number'    => $request->principal_contact,
        ]);
        
        $images =   $request->file('image_list');

        foreach($images as $key=>$image){
            $image_path     =   Storage::putFile('centre_photo', $image['image_file']);
            $image_size     =   Storage::size($image_path);
            $image_type     =   $request->image_list[$key]['type'];

            DB::table('wpvt_10_wlsm_schools_images')->insert([
                'centre_id'     => $new_centre_id,
                'image_path'    => $image_path,
                'image_size'    => $image_size,
                'image_type'    => $image_type,
            ]);
        }
        return redirect('centres')->with(['type'=>'success', 'message'=>'School added successfully !']);
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

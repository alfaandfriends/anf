<?php

namespace App\Http\Controllers;

use App\Models\Centre;
use Corcel\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Support\Str;

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
            'filter'=>request()->all('search', 'centre_id'),
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
                                'is_active' => $request->centre_active,
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
        return redirect(route('centres'))->with(['type'=>'success', 'message'=>'School added successfully !']);
    }

    public function edit(Request $request)
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

        $centre_info        =   DB::table('wpvt_10_wlsm_schools')->where('ID', $request->centre_id)->first();
        $centre_images      =   DB::table('wpvt_10_wlsm_schools_images')->where('centre_id', $request->centre_id)->get();
        $centre_principal   =   DB::table('wpvt_10_wlsm_schools_principals')->where('centre_id', $request->centre_id)->first();

        return Inertia::render('Centres/Edit', [
            'email_exist'=>$email_exist,
            'centre_info' => $centre_info,
            'centre_images' => $centre_images,
            'centre_principal' => $centre_principal,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'centre_name'               => 'required|max:20',
            'centre_contact_number'     => 'required|max:50',
            'centre_email'              => 'required|max:50',
            'centre_address'            => 'required|max:100',
            'principal_email'           => 'required|max:50',
            'principal_contact'         => 'required|max:50',
        ]);
        
        /* Check principal details */
        $email_exist  =   User::where('user_email', $request->principal_email)->count();

        if($email_exist < 1){
            return redirect()->back()->with(['type'=>'error', 'message'=>'Please enter a valid principal email address !']);
        }
        /* Check principal details */

        /* Check images */
        $images_count           = DB::table('wpvt_10_wlsm_schools_images')->where('centre_id', $request->centre_id)->count();

        if( (empty($request->image_list) && $images_count < 1) || 
            count(collect($request->image_list)->where('image_type', 'front')) < 1 || 
            count(collect($request->image_list)->where('image_type', 'inside')) < 5){   
            return redirect()->back()->with(['type'=>'error', 'message'=>'Please upload required image !']);
        }
        /* Check images */

        /* Update centre info */
        DB::table('wpvt_10_wlsm_schools')->where('ID', $request->centre_id)->update([
                    'label' => 'ANFC '.$request->centre_name,
                    'phone' => $request->centre_contact_number,
                    'email' => $request->centre_email,
                    'address' => $request->centre_address,
                    'is_active' => $request->centre_active,
                ]);
        /* Update centre info */
            
        /* Update principal info */
        $principal_exist    =   DB::table('wpvt_10_wlsm_schools_principals')->where('centre_id', $request->centre_id)->exists();

        if($principal_exist){
            DB::table('wpvt_10_wlsm_schools_principals')->where('centre_id', $request->centre_id)->update([
                'first_name'        => $request->principal_first_name,
                'last_name'         => $request->principal_last_name,
                'email'             => $request->principal_email,
                'contact_number'    => $request->principal_contact,
                'updated_at'        => Carbon::now(),
            ]);
        }
        else{
            DB::table('wpvt_10_wlsm_schools_principals')->insert([
                'centre_id'         => $request->centre_id,
                'first_name'        => $request->principal_first_name,
                'last_name'         => $request->principal_last_name,
                'email'             => $request->principal_email,
                'contact_number'    => $request->principal_contact,
            ]);
        }
        /* Update principal info */

        /* Delete selected images */
        if(!empty($request->images_to_delete)){
            foreach($request->images_to_delete as $key=>$image_to_delete){
                $this->destroyImage($image_to_delete['image_id']);
            }
        }
        /* Delete selected images */
        
        /* Upload new images */
        $images =   $request->file('image_list');
        if(!empty($images)){
            foreach($images as $key=>$image){
                $image_path     =   Storage::putFile('centre_photo', $image['image_file']);
                $image_size     =   Storage::size($image_path);
                $image_type     =   $request->image_list[$key]['image_type'];
    
                DB::table('wpvt_10_wlsm_schools_images')->insert([
                    'centre_id'     => $request->centre_id,
                    'image_path'    => '/storage/'.$image_path,
                    'image_size'    => $image_size,
                    'image_type'    => $image_type,
                    'updated_at'    => Carbon::now(),
                ]);
            }
        }
        /* Upload new images */

        return redirect(route('centres'))->with(['type'=>'success', 'message'=>'Centre updated successfully !']);
    }

    public function destroy($id)
    {
        DB::table('wpvt_10_wlsm_schools')->where('ID', $id)->delete();
        DB::table('wpvt_10_wlsm_schools_principals')->where('centre_id', $id)->delete();

        $images  =   DB::table('wpvt_10_wlsm_schools_images')->where('centre_id', $id)->get();
        foreach($images as $key=>$image){
            $image_path =   Str::replace('/storage/', '', $image->image_path);
            Storage::delete($image_path);
        }
        DB::table('wpvt_10_wlsm_schools_images')->where('centre_id', $id)->delete();

        return redirect(route('centres'))->with(['type'=>'success', 'message'=>'Centre deleted successfully !']);
    }

    public function destroyImage($id){
        $image      =   DB::table('wpvt_10_wlsm_schools_images')->where('ID', $id)->first();
        $image_path =   Str::replace('/storage/', '', $image->image_path);
        Storage::delete($image_path);
        DB::table('wpvt_10_wlsm_schools_images')->where('ID', $id)->delete();

        return back()->with(['type'=>'success', 'message'=>'Image deleted !']);
    }

    public function getCentreImages(Request $request){

        $images = DB::table('wpvt_10_wlsm_schools_images')->where('centre_id', $request->centre_id)->get();

        $centre_images =   array();
        if($images->isNotEmpty()){
            foreach($images as $key => $image){
                $data['thumb']      =   File::exists(public_path($image->image_path)) ? $image->image_path : 'https://media.istockphoto.com/vectors/no-image-available-sign-vector-id1138179183?k=20&m=1138179183&s=612x612&w=0&h=iJ9y-snV_RmXArY4bA-S4QSab0gxfAMXmXwn5Edko1M=';
                $data['src']        =   File::exists(public_path($image->image_path)) ? $image->image_path : 'https://media.istockphoto.com/vectors/no-image-available-sign-vector-id1138179183?k=20&m=1138179183&s=612x612&w=0&h=iJ9y-snV_RmXArY4bA-S4QSab0gxfAMXmXwn5Edko1M=';
                $data['caption']    =   Str::ucfirst($image->image_type) . ' View';
                $centre_images[]    =   $data;
            }
        }
        else{
            $data['thumb']      =   'https://media.istockphoto.com/vectors/no-image-available-sign-vector-id1138179183?k=20&m=1138179183&s=612x612&w=0&h=iJ9y-snV_RmXArY4bA-S4QSab0gxfAMXmXwn5Edko1M=';
            $data['src']        =   'https://media.istockphoto.com/vectors/no-image-available-sign-vector-id1138179183?k=20&m=1138179183&s=612x612&w=0&h=iJ9y-snV_RmXArY4bA-S4QSab0gxfAMXmXwn5Edko1M=';
            $data['caption']    =   'Not Available';
            $centre_images[]    =   $data;
        }
        
        return $centre_images;
    }
}

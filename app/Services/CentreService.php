<?php
namespace App\Services;

use App\Events\DatabaseTransactionEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CentreService
{
    public function getCentres($search_query = null)
    {
        return  DB::table('centres')
                    ->leftJoin('countries', 'centres.country_id', '=', 'countries.id')
                    ->when($search_query, function ($query, $search) {
                        $query->where(function ($q) use ($search) {
                            $q->where('centres.label', 'LIKE', "%$search%");
                        });
                    })
                    ->select(
                        'centres.id as centre_id', 
                        'centres.label as centre_name', 
                        'centres.address as centre_address',
                        'centres.is_active as centre_status', 
                        'countries.name as country_name'
                    )
                    ->orderBy('centres.label')
                    ->paginate(10);
    }

    public function getCentreByID($centre_id)
    {
        return DB::table('centres')->where('ID', $centre_id)->first();
    }

    public function getCentreImages($centre_id){
        return DB::table('centre_images')->where('centre_id', $centre_id)->get();
    }

    public function createCentre($request)
    {
        $request->validate([
            'centre_name'               => 'required',
            'centre_country'            => 'required',
            'centre_contact_number'     => 'required',
            'centre_email'              => 'required',
            'centre_address'            => 'required',
        ]);
        
        $centre_id  =   DB::table('centres')->insertGetId([
            'country_id'                => $request->centre_country,
            'label'                     => $request->centre_name,
            'phone'                     => $request->centre_contact_number,
            'email'                     => $request->centre_email,
            'address'                   => $request->centre_address,
            'is_active'                 => $request->centre_active,
            'last_enrollment_count'     => 0,
            'last_invoice_count'        => 0,
            'last_payment_count'        => 0,
            'last_admission_count'      => 0,
            'last_certificate_count'    => 0,
        ]);

        $log_data =   'Created centre ' . $request->centre_name . ' : ' . json_encode([
            'country_id'                => $request->centre_country,
            'label'                     => $request->centre_name,
            'phone'                     => $request->centre_contact_number,
            'email'                     => $request->centre_email,
            'address'                   => $request->centre_address,
            'is_active'                 => $request->centre_active,
            'last_enrollment_count'     => 0,
            'last_invoice_count'        => 0,
            'last_payment_count'        => 0,
            'last_admission_count'      => 0,
            'last_certificate_count'    => 0,
        ], true) ;
        event(new DatabaseTransactionEvent($log_data));

        $this->uploadImages($centre_id, $request);
    }

    public function updateCentre($request)
    {
        $request->validate([
            'centre_name'               => 'required',
            'centre_country'            => 'required',
            'centre_contact_number'     => 'required',
            'centre_email'              => 'required',
            'centre_address'            => 'required',
        ]);

        DB::table('centres')->where('ID', $request->centre_id)->update([
            'country_id' => $request->centre_country,
            'label' => $request->centre_name,
            'phone' => $request->centre_contact_number,
            'email' => $request->centre_email,
            'address' => $request->centre_address,
            'is_active' => $request->centre_active,
        ]);

        $log_data =   'Updated centre ' . $request->centre_name . ' : ' . json_encode([
            'country_id'                => $request->centre_country,
            'label'                     => $request->centre_name,
            'phone'                     => $request->centre_contact_number,
            'email'                     => $request->centre_email,
            'address'                   => $request->centre_address,
            'is_active'                 => $request->centre_active,
            'last_enrollment_count'     => 0,
            'last_invoice_count'        => 0,
            'last_payment_count'        => 0,
            'last_admission_count'      => 0,
            'last_certificate_count'    => 0,
        ], true) ;
        event(new DatabaseTransactionEvent($log_data));

        $this->uploadImages($request->centre_id, $request);
    }

    public function deleteCentre($centre_id){
        $centre_info = DB::table('centres')->where('ID', $centre_id)->first();
        DB::table('centres')->where('ID', $centre_id)->delete();

        $images  =   DB::table('centre_images')->where('centre_id', $centre_id)->get();
        foreach($images as $key=>$image){
            $image_path =   Str::replace('/storage/', '', $image->image_path);
            Storage::delete($image_path);
        }
        DB::table('centre_images')->where('centre_id', $centre_id)->delete();

        $log_data =   'Deleted centre '.$centre_info->label;
        event(new DatabaseTransactionEvent($log_data));
    }

    public function uploadImages($centre_id, $request)
    {
        $images =   $request->file('image_list');

        if(!empty($images)){
            foreach($images as $key=>$image){
                $image_path     =   Storage::putFile('centre_photo', $image['image_file']);
                $image_size     =   Storage::size($image_path);
                $image_type     =   $request->image_list[$key]['image_type'];
    
                DB::table('centre_images')->insert([
                    'centre_id'     => $centre_id,
                    'image_path'    => '/storage/'.$image_path,
                    'image_size'    => $image_size,
                    'image_type'    => $image_type,
                ]);

                $log_data =   'Uploaded images for centre ' . $request->centre_name . ' : ' . json_encode([
                    'centre_id'     => $centre_id,
                    'image_path'    => '/storage/'.$image_path,
                    'image_size'    => $image_size,
                    'image_type'    => $image_type,
                ], true);
                event(new DatabaseTransactionEvent($log_data));
            }
        }
    }

    public function deleteImages($request)
    {
        if(!empty($request->images_to_delete)){
            foreach($request->images_to_delete as $key=>$image_to_delete){
                $image      =   DB::table('centre_images')->where('ID', $image_to_delete)->first();
                $image_path =   Str::replace('/storage/', '', $image->image_path);
                Storage::delete($image_path);
                DB::table('centre_images')->where('ID', $image_to_delete)->delete();
            }
            $log_data =   'Deleted images for centre ' . $request->centre_name;
            event(new DatabaseTransactionEvent($log_data));
        }
    }
}
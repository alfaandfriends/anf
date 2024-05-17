<?php

namespace App\Http\Controllers;

use App\Events\DatabaseTransactionEvent;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PromoController extends Controller
{
    public function index(Request $request){
        $promo_list     =   DB::table('promotions')
                                ->join('countries', 'promotions.country_id', '=', 'countries.id')
                                ->join('promotion_durations', 'promotions.duration_id', '=', 'promotion_durations.id')
                                ->join('promotion_types', 'promotions.type_id', '=', 'promotion_types.id')
                                ->when($request->search, function($query) use ($request){
                                    $query->where('promotions.name', 'LIKE', '%'.$request->search.'%');
                                })
                                ->select(
                                    'promotions.id as promotion_id', 
                                    'promotions.name as promotion_name',
                                    'countries.id as country_id', 
                                    'countries.name as country_name', 
                                    'promotion_durations.id as duration_id', 
                                    'promotion_durations.name as duration_name', 
                                    'promotion_types.id as type_id', 
                                    'promotion_types.name as type_name', 
                                    'promotions.value as promotion_value')
                                ->paginate(10);

        return Inertia::render('Admin/Promos/Index', [
            'filter'        => request()->all('search'),
            'promo_list'    => $promo_list
        ]);
    }

    public function create(){
        $countries  =   DB::table('countries')->get();
        $durations  =   DB::table('promotion_durations')->get();
        $types  =   DB::table('promotion_types')->get();

        return Inertia::render('Admin/Promos/Create', [
            'countries' => $countries,
            'durations' => $durations,
            'types'     => $types
        ]);
    }
    
    public function store(Request $request){
        
        DB::table('promotions')->insert([
            'name'          => $request->promo_name,
            'country_id'    => $request->country_id,
            'duration_id'   => $request->duration_id,
            'type_id'       => $request->type_id,
            'value'         => $request->promo_value
        ]);

        return redirect(route('fee.promos'))->with(['type' => 'success', 'message' => 'Promotion has been added.']);
    }

    public function destroy($id){
        try {
            DB::beginTransaction();

            DB::table('promotions')->where('id', $id)->delete();

            DB::commit();

            $log_data =   'Deleted promotion ID '.$id;
            event(new DatabaseTransactionEvent($log_data));

            return back()->with(['type'=>'success', 'message'=>'Promotion deleted successfully! ']);
        } catch (Exception $e) {
            DB::rollback();
            return back()->with(['type'=>'error', 'message'=>'An error has occurred, please try again!']);
        }
    }
}

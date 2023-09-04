<?php

namespace App\Http\Controllers;

use App\Classes\InvoiceHelper;
use App\Classes\OrderHelper;
use App\Enums\OrderStatus;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Models\OrderStatus as ModelsOrderStatus;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\ShippingProvider;
use App\Models\User;
use App\Notifications\InvoiceCreated;
use Billplz\Laravel\Billplz;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        
        $query  =   DB::table('orders')
                        ->leftJoin('invoices', 'orders.invoice_id', '=', 'invoices.id')
                        ->leftJoin('students', 'orders.student_id', '=', 'students.id')
                        ->leftJoin('children', 'students.children_id', '=', 'children.id')
                        ->leftJoin('wpvt_users', 'children.parent_id', '=', 'wpvt_users.ID')
                        ->leftJoin('invoice_status', 'invoices.status', '=', 'invoice_status.id')
                        ->leftJoin('order_shipping_providers', 'orders.shipping_provider', '=', 'order_shipping_providers.id')
                        ->join('order_status', 'orders.status', '=', 'order_status.id')
                        ->select('orders.id', 'orders.order_number', 'orders.products', 'orders.tracking_number', 'orders.created_at', 'order_status.name as status_name', 
                                'orders.tracking_status as tracking_status', 'order_shipping_providers.name as shipping_provider_name',
                                 'order_status.class_name as class_name', 'invoices.id as invoice_id', 'invoices.invoice_number', 'invoices.invoice_items', 
                                 'children.name as student_name', 'wpvt_users.display_name as parent_full_name', 'wpvt_users.user_address as parent_address', 
                                 'invoices.date_issued', 'invoices.due_date', 'invoices.amount', 'invoice_status.name as status', 
                                 'invoice_status.bg_color as status_bg_color', 'invoice_status.text_color as status_text_color');
        // if($request->search){
        //     $query->where('orders.name', 'LIKE', '%'.request('search').'%');
        // }   

        return Inertia::render('Order/Index', [
            'filter'        =>  request()->all('search'),
            'orders'        =>  $query->paginate(10)
        ]);
    }

    public function create()
    {
        $status             =   OrderHelper::getStatus();
        $shipping_providers =   OrderHelper::getShippingProviders();

        return Inertia::render('Order/Create', [
            'status'                =>  $status,
            'shipping_providers'    =>  $shipping_providers,
        ]);
    }
    
    public function store(Request $request)
    {
        if(empty($request->products)){
            return back()->with(['type'=>'error', 'message'=>'Please add some products.']);
        }
        
        DB::table('orders')->insert([
            'student_id'            =>  $request->student_id,
            'products'              =>  json_encode($request->products),
            'shipping_provider'     =>  $request->shipping_provider,
            'tracking_number'       =>  $request->tracking_number,
            'tracking_status'       =>  json_encode($request->tracking_status),
            'status'                =>  $request->status,
        ]);

        return redirect(route('orders'))->with(['type'=>'success', 'message'=>'New order has been created!']);
    }
    
    public function edit(Request $request)
    {
        $status             =   OrderHelper::getStatus();
        $shipping_providers =   OrderHelper::getShippingProviders();

        $order_info     =   DB::table('orders')
                                ->leftJoin('students', 'orders.student_id', '=', 'students.id')
                                ->leftJoin('children', 'students.children_id', '=', 'children.id')
                                ->leftJoin('wpvt_users', 'children.parent_id', '=', 'wpvt_users.ID')
                                ->leftJoin('order_shipping_providers', 'orders.shipping_provider', '=', 'order_shipping_providers.id')
                                ->join('order_status', 'orders.status', '=', 'order_status.id')
                                ->select('orders.id as order_id', 'orders.products', 'orders.student_id', 'orders.tracking_number', 'orders.status as status_id', 
                                        'orders.shipping_provider as shipping_provider_id', 'orders.tracking_status as tracking_status', 'children.name as student_name', 
                                        'order_shipping_providers.name as shipping_provider_name', 'order_status.name as status_name')
                                ->where('orders.id', $request->order_id)
                                ->first();
        // dd($order_info);
        return Inertia::render('Order/Edit', [
            'order_info'            =>  $order_info,
            'status'                =>  $status,
            'shipping_providers'    =>  $shipping_providers,
        ]);
    }
    
    public function update(Request $request)
    {
        if(empty($request->products)){
            return back()->with(['type'=>'error', 'message'=>'Please add some products.']);
        }

        DB::table('orders')->where('id', $request->order_id)->update([
            'student_id'            =>  $request->student_id,
            'products'              =>  json_encode($request->products),
            'shipping_provider'     =>  $request->shipping_provider,
            'tracking_number'       =>  $request->tracking_number,
            'tracking_status'       =>  json_encode($request->tracking_status),
            'status'                =>  $request->status,
        ]);

        return redirect(route('orders'))->with(['type'=>'success', 'message'=>'Order has been updated!']);
    }
    
    public function destroy($id)
    {
        DB::table('orders')->where('id', $id)->delete();

        return redirect(route('orders'))->with(['type'=>'success', 'message'=>'Order has been deleted.']);
    }
}

<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Models\OrderStatus as ModelsOrderStatus;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\ShippingProvider;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['orders'] = Order::select(
            'id', 'product_id', 'customer_id'
        )->with(
            'user:id,user_email',
            'shipping:id,order_id,shipping_provider_id,tracking_no',
            'shipping.provider:id,name',
            'status:id,order_id,status'
        )->when($request->search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->when($request->filter, function ($query, $filter) {
            return $query->where('name', 'like', '%' . $filter . '%');
        })->paginate(10);

        return Inertia::render('Order/Index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['statuses']['pending'] = OrderStatus::PENDING;
        $data['statuses']['processing'] = OrderStatus::PROCESSING;
        $data['statuses']['completed'] = OrderStatus::COMPLETED;
        $data['providers'] = ShippingProvider::get();
        $data['users'] = User::select('id', 'display_name')->where('first_time_login', 1)->where('is_admin', 0)->limit(1000)->get();
        $data['products'] = Product::get();

        return Inertia::render('Order/Create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $order = Order::create([
                    'product_id' => $request->order_product,
                    'customer_id' => $request->order_customer,
                ]);

                ModelsOrderStatus::create([
                    'order_id' => $order->id,
                    'status' => $request->order_status,
                ]);

                Shipping::create([
                    'order_id' => $order->id,
                    'shipping_provider_id' => $request->order_shipping_provider,
                    'tracking_no' => $request->order_shipping_no,
                ]);

                //TODO: send out invoice
            });

            return redirect(route('orders'))->with(['type'=>'success', 'message'=>'Order added successfully !']);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            return redirect(route('orders'))->with(['type'=>'error', 'message'=>'Opps something went wrong']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $data['statuses']['pending'] = OrderStatus::PENDING;
        $data['statuses']['processing'] = OrderStatus::PROCESSING;
        $data['statuses']['completed'] = OrderStatus::COMPLETED;
        $data['providers'] = ShippingProvider::get();
        $data['users'] = User::select('id', 'display_name')->where('first_time_login', 1)->where('is_admin', 0)->limit(1000)->get();
        $data['products'] = Product::get();

        $shipping = Shipping::where('order_id', $order->id)->latest()->first();
        $orderStatus = ModelsOrderStatus::where('order_id', $order->id)->latest()->first();
        $order->tracking_no = $shipping->tracking_no;
        $order->shipping_provider = $shipping->shipping_provider_id;
        $order->status = $orderStatus->status;
        $data['order'] = $order;

        return Inertia::render('Order/Create', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOrderRequest  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        try {
            DB::transaction(function () use ($request, $order) {
                $shipping = Shipping::where('order_id', $order->id)->latest()->first();
                $orderStatus = ModelsOrderStatus::where('order_id', $order->id)->latest()->first();

                $order->update([
                    'product_id' => $request->order_product,
                    'customer_id' => $request->order_customer,
                ]);

                if ($orderStatus->status != $request->order_status) {
                    ModelsOrderStatus::create([
                        'order_id' => $order->id,
                        'status' => $request->order_status,
                    ]);
                }

                $shipping->update([
                    'order_id' => $order->id,
                    'shipping_provider_id' => $request->order_shipping_provider,
                    'tracking_no' => $request->order_shipping_no,
                ]);
            });

            return redirect(route('orders'))->with(['type'=>'success', 'message'=>'Order updated successfully !']);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            return redirect(route('orders'))->with(['type'=>'error', 'message'=>'Opps something went wrong']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        try {
            DB::transaction(function () use ($order) {
                Shipping::where('order_id', $order->id)->delete();
                ModelsOrderStatus::where('order_id', $order->id)->delete();
                $order->delete();
            });

            return redirect(route('orders'))->with(['type'=>'success', 'message'=>'Order deleted successfully !']);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            return redirect(route('orders'))->with(['type'=>'error', 'message'=>'Opps something went wrong']);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ShopController extends Controller
{
    public function index()
    {
        return Inertia::render('Shop/Index');
    }

    public function shopCart()
    {
        return Inertia::render('Shop/Cart');
    }

    public function shopCheckout()
    {
        return Inertia::render('Shop/Checkout');
    }

    public function shopPayment(){
        return response('OK', 200);
    }

    public function shopPaymentStatus(Request $request){
        if($request->billplz['transaction_status'] == 'completed'){
            return Inertia::render('Shop/PaymentStatus');
        }
        else{
            dd($request->billplz);
        }
    }
}

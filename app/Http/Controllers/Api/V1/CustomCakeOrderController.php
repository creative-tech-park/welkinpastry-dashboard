<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\CustomCakeOrder;
use Illuminate\Http\Request;

class CustomCakeOrderController extends Controller
{
    public function index()
    {
        $orders = CustomCakeOrder::with('custom_cake', 'custom_cake_customer', 'custom_cake_flavor', 'custom_cake_order_images')->orderBy('id', 'desc')->get();
        return response()->json($orders);
    }
}

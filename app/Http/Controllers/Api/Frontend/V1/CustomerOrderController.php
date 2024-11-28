<?php

namespace App\Http\Controllers\Api\Frontend\V1;

use App\Http\Controllers\Controller;
use App\Models\CustomCakeOrder;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerOrderController extends Controller
{
    public function customerOrders()
    {
        $orders = Order::query()
            ->with(['customer', 'address'])
            ->with(['orderDetails.product'])
            ->withCount('orderDetails')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return response()->json($orders);
    }

    public function customCakeOrders()
    {
        $data = CustomCakeOrder::with(['custom_cake_customer', 'custom_cake_flavor', 'custom_cake'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return response()->json($data);
    }
    public function showCustomerOrder($id)
    {
        $order = Order::query()
            ->with(['customer', 'address.orderArea', 'orderDetails.product'])
            ->findOrFail($id);


        return response()->json($order);
    }
}

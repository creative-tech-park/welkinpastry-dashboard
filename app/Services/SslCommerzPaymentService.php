<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Library\SslCommerz\SslCommerzNotification;

class SslCommerzPaymentService
{
    public function initiatePayment(array $data)
    {
        $post_data = [
            'total_amount' => $data['grand_total'],
            'currency' => "BDT",
            'tran_id' => uniqid(),
            // Customer Information
            'cus_name' => Auth::user()->name,
            'cus_email' => Auth::user()->email,
            'cus_add1' => $data['address'] ?? 'N/A',
            'cus_country' => "Bangladesh",
            'cus_phone' => Auth::user()->phone,
            // Shipment Information
            'shipping_method' => 'NO',
            'ship_name' => "Store Test",
            'ship_add1' => "Dhaka",
            'ship_city' => "Dhaka",
            'ship_postcode' => "1000",
            'ship_country' => "Bangladesh",
            // Product Profile
            'product_name' => $data['product_name'] ?? 'Unknown',
            'product_category' => "Goods",
            'product_profile' => "physical-goods",
            // Optional
            'value_a' => "ref001",
            'value_b' => "ref002",
        ];

        // Create Order with Pending status
        $order = Order::create([
            'sub_total' => $data['sub_total'],
            'grand_total' => $data['grand_total'],
            'payment_method' => "SSL Commerz",
            'user_id' => Auth::id(),
            'payment_status' => 'paid',
            'address_id' => $data['address_id'],
            'transaction_id' => $post_data['tran_id'],
            'order_date' => Carbon::now('Asia/Dhaka'),
            'delivery_type_id' => Carbon::now('Asia/Dhaka')->hour < 11 ? 2 : 1,
        ]);

        // Create Order Details
        $orderDetails = [];
        foreach ($data['orders'] as $item) {
            $orderDetails[] = [
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item["buyQty"] ?? 1,
            ];
            // Update product visit count
            $product = Product::find($item['id']);
            $product->increment('visited');
        }
        $order->orderdetails()->createMany($orderDetails);

        // Initiate SSLCommerz Payment
        $sslc = new SslCommerzNotification();
        $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');
        return $payment_options;
    }
}

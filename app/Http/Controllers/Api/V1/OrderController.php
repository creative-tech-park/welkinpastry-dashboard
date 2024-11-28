<?php

namespace App\Http\Controllers\Api\V1;


use App\Services\SslCommerzPaymentService;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Address;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use App\Models\CustomCakeOrder;
use App\Models\CustomCakeCustomer;
use App\Http\Controllers\Controller;
use App\Models\CustomCakeOrderImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthenticationException;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $orders = Order::query()
            ->with(['customer', 'orderdetails', 'orderdetails.product', 'orderdetails.product.images', 'orderdetails.stoke'])
            ->latest()
            ->paginate(10);

        return response()->json([
            'message' => 'users all orders',
            'data' => $orders
        ]);
    }

    public function store(Request $request, SslCommerzPaymentService $paymentService)
    {
        if (!Auth::check()) {
            throw new AuthenticationException();
        }
        $request->validate([
            'addressId' => 'required',
            'paymentMethod' => 'required',
            'orderTotal' => 'required',
            'orders' => 'required|array',
            'orders.*.id' => 'required|exists:products,id',
        ]);

        $address = Address::findOrFail($request->addressId);
        $grandTotal = $address->orderArea->delevery_charge + $request->orderTotal;
        $paymentData = [
            'sub_total' => $request->orderTotal,
            'grand_total' => $grandTotal,
            'address_id' => $request->addressId,
            'orders' => $request->orders,
            'address' => $address->address_line,
        ];
        $paymentResponse = $paymentService->initiatePayment($paymentData);
        return $paymentResponse;
        if ($paymentResponse->status == 'fail') {
            return response()->json(['message' => 'Payment initiation failed'], 400);
        }
        return response()->json($paymentResponse);
    }

    public function show($id)
    {
        $order = Order::query()
            ->with(['customer', 'address.orderArea', 'orderDetails.product'])
            ->findOrFail($id);
        return response()->json($order);
    }

    public function orderDetails($id)
    {
        $order = Order::with(['orderdetails', 'orderdetails.product', 'orderdetails.stoke', 'customer', 'address.orderArea'])->findOrFail($id);
        return response()->json($order, 200);
    }

    public function update(Request $request, Order $order)
    {
        //
    }

    public function destroy(Order $order)
    {
        $order->orderdetails()->delete();
        $order->delete();
        return response()->json("Order Deleted...", 200);
    }


    public function changeOrderStatus(Request $request)
    {
        $order = Order::findOrFail($request->id);
        if ($request->input('type') == 'payment') {
            $order->payment_status = Str::lower($request->input('status'));
        } else {
            $order->order_status = Str::lower($request->input('status'));
        }
        $order->update();
        return response()->json(['message' => 'Status Updated...']);
    }

    public function changePaymentStatus()
    {
        return dd(\request()->all());
    }

    public function customCakeOrder(Request $request)
    {
        // Validate incoming request
        $validatedData = $request->validate([
            'custom_cake_id' => 'required|exists:custom_cakes,id',
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'custom_cake_flavor_id' => 'required|exists:custom_cake_flavors,id',
            'weight' => 'required',
            'message_on_cake' => 'nullable|string|max:255',
            'delivery_location' => 'required|string|max:100',
            'delivery_date' => 'required|string|max:50',
        ]);

        // Create the customer record if it does not exist
        $customer = CustomCakeCustomer::firstOrCreate(
            ['phone_number' => $validatedData['phone_number']],
            [
                'full_name' => $validatedData['full_name'],
                'address' => $validatedData['address'],
            ]
        );

        // Handle the image upload
        if ($request->hasFile('photo_on_cake')) {
            // Store the image in the 'storage/app/photo_on_cakes' directory
            $imagePath = $request->file('photo_on_cake')->store('photo_on_cakes');

            // Get only the filename from the path
            $imageName = basename($imagePath);
        }

        // Create the order record
        $orderData = [
            'custom_cake_id' => $validatedData['custom_cake_id'],
            'custom_cake_customer_id' => $customer->id,
            'custom_cake_flavor_id' => $validatedData['custom_cake_flavor_id'],
            'photo_on_cake' => $imageName ?? null,
            'message_on_cake' => $validatedData['message_on_cake'],
            'weight' => $validatedData['weight'],
            'delivery_location' => $validatedData['delivery_location'],
            'delivery_date' => $validatedData['delivery_date'],
        ];

        // Check if user_id is present in the request and assign it
        if ($request->has('user_id')) {
            $orderData['user_id'] = $request->user_id;
        } else {

            $orderData['user_id'] = null; // or handle accordingly
        }

        // Create the order record
        $order = CustomCakeOrder::create($orderData);

        if ($request->hasFile('custom_cake_images')) {
            foreach ($request->file('custom_cake_images') as $image) {
                // Validate the file (optional but recommended)
                $request->validate([
                    'custom_cake_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // You can adjust rules as per your requirements
                ]);

                // Store the image in the 'storage/app/custom_cake_images' directory
                $imagePath = $image->store('custom_cake_images');

                // Save image path and related data to the database
                CustomCakeOrderImage::create([
                    'custom_cake_order_id' => $order->id,
                    'image' => $imagePath,
                ]);
            }
        }


        // Return a response
        return response()->json(['success' => true, 'order' => $order], 201);
    }

    public function buyNowOrder(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'fullName' => 'required|string|max:255',
            'phoneNumber' => 'required|string|max:15',
            'address' => 'required|string',
            'deliveryLocation' => 'required|string',
            'areaId' => 'required',
            'paymentMethod' => 'required|string',
            'totalAmount' => 'required',
        ]);

        // Create a new user
        $user = new User();
        $user->name = $request->fullName;
        $user->phone = $request->phoneNumber;
        $user->address = $request->address; // Optional if you want to store this
        $user->save();

        // Create a new order associated with the user
        $order = new Order();
        $order->user_id = $user->id; // Associate order with newly created user
        $order->shipping_area_id = $request->areaId; // Assuming this is a valid field
        $order->sub_total = $request->totalAmount; // Subtotal
        $order->grand_total = $request->totalAmount; // Total amount
        $order->payment_method = $request->paymentMethod; // Payment method
        $order->order_date = now(); // Set the order date to now
        $order->payment_status = 'pending'; // Initial payment status
        $order->order_status = 'pending'; // Initial order status

        // Save the order
        if ($order->save()) {
            return response()->json(['success' => true, 'order' => $order], 201);
        } else {
            return response()->json(['success' => false, 'message' => 'Unable to create order.'], 500);
        }
    }


}

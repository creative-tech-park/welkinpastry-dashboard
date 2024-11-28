<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Properties;
use App\Models\Course;
use App\Models\Order;
use App\Models\Transaction;
use Http\Discovery\Exception\NotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Stripe\StripeClient;

class StripeController extends Controller
{

    public $sessionId;

    public function index()
    {
        $client = new StripeClient(config('stripe.stripe_sk'));
        return $client->paymentIntents->all();

        return "redirect index page";
    }

    public function checkout($order, $orderDetails)
    {
        Stripe::setApiKey(config('stripe.stripe_sk'));

        try {
            $session = Session::create([
                'line_items' =>[
                    [
                        'price_data' => [
                            'currency' => 'USD',
                            'product_data' => [
                                'name' => "You Can Get Order Information After Complete Payment Process",//$course['name'],
//                                'description' => $course['description']
                            ],
                            'unit_amount' => intval($order->grand_total) * 100,
                        ],
                        'quantity' => 1,
                    ]
                ],
                'mode' => 'payment',
                'success_url' => config('stripe.frontend_url')."/order-complete?session_url={CHECKOUT_SESSION_ID}",
                'cancel_url' => config('stripe.frontend_url')
            ]);
            return $session;
        } catch (ApiErrorException $e) {
            return $e->getMessage();
        }
    }

    public function verify(Request $request)
    {
        $sessionId = $request->input('sessionId');

        $stripe = new StripeClient(config('stripe.stripe_sk'));

        if($sessionId){
            try {
                $session = $stripe->checkout->sessions->retrieve($sessionId);

                if($session){
                    $order = Order::where('session_id', $session->id)->where('status', 'pending')->first();
                    $trx = Transaction::where('session_id', $session->id)->where('status', 'pending')->first();
                    if($order && $order != null){
                        $order->status = 'active';
                        $order->save();
                    }
                    if ($trx && $trx != null){
                        $trx->status = 'successfull';
                        $trx->save();
                    }

                    return $session;
                }else{
                    throw new NotFoundException();
                }

            } catch (ApiErrorException $e) {
                throw new NotFoundException();
            }
        }
        return response()->json('Your Session Id Is Not Valid...');
    }


    public function cancel()
    {
        return "this is cancel url";
    }
    private function createArrayGroups($request): array
    {
        $added = array();
        $user_id = Auth::id();

        $added[$user_id] = [
            "coupon_id" => $request->coupon_id,
            "using" => 1
        ];
        return $added;
    }
}

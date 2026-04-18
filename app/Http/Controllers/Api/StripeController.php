<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\Checkout;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class StripeController extends Controller
{
    // Orden/Session
    public function createSession(string $priceId, 
    string $successURL="http://larafirststeps.test/vue/stripe/success", 
    string $cancelUrl="http://larafirststeps.test/vue/stripe/cancel")
    {

        $session = Checkout::guest()->create($priceId, [
            'mode' => 'payment',
            // 'mode' => 'subscription',
            'success_url' => $successURL.'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => $cancelUrl,
        ]);

        // return $session;
        return response()->json([
            'id' => $session->id,
            'url' => $session->url,
        ]);
    }

    /**
     * Create a Stripe Checkout Session by dynamic amount
     */
    public function createSessionByAmount(float $amount, string $successRouteUrl, string $cancelUrl = 'https://academy.desarrollolibre.net/')
    {
        $session = Cashier::stripe()->checkout->sessions->create([
            'success_url' => $successRouteUrl,
            'cancel_url' => $cancelUrl,
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Compra en Desarrollolibre Academy',
                        ],
                        'unit_amount' => $amount * 100, // Stripe uses cents
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
        ]);

        return [
            'id' => $session->id,
            'url' => $session->url,
        ];
    }

    private function checkSessionById(string $sessionId): Session
    {
        return Cashier::stripe()->checkout->sessions->retrieve($sessionId);
    }

    public function checkPayment(string $sessionId)
    {
        $session = $this->checkSessionById($sessionId);

        // dd($session->payment_intent);
        // dd($session->payment_status);
        if ($session->payment_status == 'paid') {
            // To Do verificar que el session no existe en la BD

            // To Do Registrar producto al cliente

            // To Do register el pago BD
            // $session->payment_status;
            // $sessionId;
            // $price = intdiv($session->amount_total, 100);
            // return json_encode($session);

            // return response()->json('payment success');
        }

        return json_encode($session);
        // return response()->json('payment not success', 400);
    }

    public function checkPaymentIntentByid(string $paymentIntentId)
    {
        Stripe::setApiKey(config('cashier.secret'));

        return PaymentIntent::retrieve($paymentIntentId);
    }

    public function stripeCustomer()
    {
        $user = auth()->user();
        $user->createOrGetStripeCustomer();
    }

    public function stripeBalance()
    {
        $user = auth()->user();

        $user->debitBalance(600, 'add balance');
        $balance = $user->balance();
        dd($balance);
    }
}

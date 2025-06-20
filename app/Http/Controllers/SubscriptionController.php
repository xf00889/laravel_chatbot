<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\Http;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        // Add global CURL options for all PayPal and Stripe requests
        Http::macro('withCurlOptions', function (    ) {
            return $this->withOptions([
                'curl' => [
                    CURLOPT_SSL_VERIFYPEER => true,
                    CURLOPT_SSL_VERIFYHOST => 2,
                    CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
                    CURLOPT_CONNECTTIMEOUT => 30,
                    CURLOPT_TIMEOUT => 30,
                ]
            ]);
        });
    }

    public function index()
    {
        return view('subscription.index');
    }

    // PayPal Methods
    public function createPayPalOrder()
    {
        try {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            
            $provider->getAccessToken();

            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => route('subscription.paypal.success'),
                    "cancel_url" => route('subscription.paypal.cancel'),
                    "brand_name" => "OpenGen",
                    "landing_page" => "BILLING",
                    "user_action" => "PAY_NOW",
                    "shipping_preference" => "NO_SHIPPING"
                ],
                "purchase_units" => [
                    [
                        "reference_id" => uniqid(),
                        "description" => "Premium Subscription",
                        "amount" => [
                            "currency_code" => "USD",
                            "value" => "9.99"
                        ]
                    ]
                ]
            ]);

            if (isset($response['id']) && $response['id'] != null) {
                foreach ($response['links'] as $link) {
                    if ($link['rel'] === 'approve') {
                        return redirect()->away($link['href']);
                    }
                }
            }

            return redirect()->route('subscription.index')
                ->with('error', 'Something went wrong with PayPal.');

        } catch (\Exception $e) {
            \Log::error('PayPal Error: ' . $e->getMessage());
            return redirect()->route('subscription.index')
                ->with('error', 'Could not process PayPal payment.');
        }
    }

    public function paypalSuccess(Request $request)
    {
        try {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $provider->getAccessToken();

            $response = $provider->capturePaymentOrder($request->token);

            if (isset($response['status']) && $response['status'] === 'COMPLETED') {
                auth()->user()->subscribe();
                return redirect()->route('chat.index')
                    ->with('success', 'Premium subscription activated successfully!');
            }

            return redirect()->route('subscription.index')
                ->with('error', 'Payment was not completed.');

        } catch (\Exception $e) {
            \Log::error('PayPal Error: ' . $e->getMessage());
            return redirect()->route('subscription.index')
                ->with('error', 'Could not verify payment.');
        }
    }

    public function paypalCancel()
    {
        return redirect()->route('subscription.index')
            ->with('error', 'Payment was cancelled.');
    }

    // Stripe Methods
    public function createStripeSession()
    {
        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Premium Subscription',
                            'description' => '100 prompts per day + Premium features',
                        ],
                        'unit_amount' => 999, // $9.99 in cents
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('subscription.stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('subscription.stripe.cancel'),
                'metadata' => [
                    'user_id' => auth()->id()
                ]
            ]);

            return response()->json(['id' => $session->id]);

        } catch (\Exception $e) {
            \Log::error('Stripe Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function stripeSuccess(Request $request)
    {
        try {
            if (!$request->session_id) {
                throw new \Exception('No session ID provided');
            }

            Stripe::setApiKey(config('services.stripe.secret'));
            $session = \Stripe\Checkout\Session::retrieve($request->session_id);

            if ($session->payment_status === 'paid') {
                auth()->user()->subscribe();
                return redirect()->route('chat.index')
                    ->with('success', 'Premium subscription activated successfully!');
            }

            return redirect()->route('subscription.index')
                ->with('error', 'Payment was not completed.');

        } catch (\Exception $e) {
            \Log::error('Stripe Error: ' . $e->getMessage());
            return redirect()->route('subscription.index')
                ->with('error', 'Could not verify payment.');
        }
    }

    public function stripeCancel()
    {
        return redirect()->route('subscription.index')
            ->with('error', 'Payment was cancelled.');
    }
}
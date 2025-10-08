<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaymentController extends Controller
{
    private $products = [
        1 => [
            'name' => 'Premium Ebook Package',
            'price' => 25.00,
            'image' => 'https://dummyimage.com/600x600/000/fff&text=Ebook'
        ],
        2 => [
            'name' => 'One Month Subscription',
            'price' => 35.00,
            'image' => 'https://dummyimage.com/600x600/4F46E5/fff&text=Subscription'
        ],
        3 => [
            'name' => 'Software License Key',
            'price' => 45.00,
            'image' => 'https://dummyimage.com/600x600/10B981/fff&text=License'
        ],
    ];

    /** Show all products */
    public function index()
    {
        return view('payment.index', [
            'products' => $this->products
        ]);
    }

    /** Create PayPal payment link */
    public function paypalPaymentLink($id)
    {
        $product = $this->products[$id] ?? null;

        if (!$product) {
            return redirect()->route('payment.index')->with('error', 'Product not found.');
        }

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $data = [
            "intent" => "CAPTURE",
            "application_context" => [
                'return_url' => route('payment.paymentSuccess'),
                'cancel_url' => route('payment.paymentCancel'),
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => number_format($product['price'], 2)
                    ],
                    "description" => $product['name'],
                ],
            ],
        ];

        try {
            $order = $provider->createOrder($data);
        } catch (\Exception $e) {
            Log::error("PayPal Order Creation Failed: " . $e->getMessage());
            return redirect()->route('payment.index')
                ->with('error', 'Payment processing failed. Please try again.');
        }

        $url = collect($order['links'])->firstWhere('rel', 'approve')['href'] ?? null;

        if ($url) {
            return redirect()->away($url);
        }

        return redirect()->route('payment.index')
            ->with('error', 'Could not get PayPal approval link.');
    }

    /** Cancelled payment */
    public function paypalPaymentCancel()
    {
        return view('payment.cancelled');
    }

    /** Successful payment */
    public function paypalPaymentSuccess(Request $request)
    {
        return view('payment.success');
    }
}

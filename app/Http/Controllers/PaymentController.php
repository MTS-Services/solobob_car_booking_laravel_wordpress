<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
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
                        "value" => number_format($product['price'], 2, '.', '')
                    ],
                    "description" => $product['name'],
                ],
            ],
        ];

        try {
            $order = $provider->createOrder($data);
            
            // Log the complete PayPal order response
            Log::info('PayPal Order Created', [
                'order_id' => $order['id'] ?? null,
                'status' => $order['status'] ?? null,
                'full_response' => $order
            ]);

            // Create payment record with PENDING status
            $payment = Payment::create([
                'booking_id' => 1, // Replace with actual booking_id from your flow
                'user_id' => user()->id, // Replace with actual user_id
                'payment_method' => Payment::METHOD_PAYPAL,
                'type' => Payment::TYPE_DEPOSIT, // Adjust based on your payment type
                'status' => Payment::STATUS_PENDING,
                'amount' => $product['price'],
                'note' => json_encode([
                    'product_id' => $id,
                    'product_name' => $product['name'],
                    'paypal_order_id' => $order['id'] ?? null,
                    'paypal_status' => $order['status'] ?? null,
                ]),
                'created_by' => user()->id,
            ]);

            // Store payment ID in session to use later
            session(['pending_payment_id' => $payment->id]);
            session(['paypal_order_id' => $order['id'] ?? null]);

            Log::info('Payment Record Created', [
                'payment_id' => $payment->id,
                'status' => 'PENDING',
                'amount' => $product['price']
            ]);

        } catch (\Exception $e) {
            Log::error("PayPal Order Creation Failed: " . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
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
    public function paypalPaymentCancel(Request $request)
    {
        Log::info('PayPal Payment Cancelled', [
            'request_data' => $request->all(),
            'token' => $request->token
        ]);

        // Update payment status to FAILED
        $paymentId = session('pending_payment_id');
        
        if ($paymentId) {
            $payment = Payment::find($paymentId);
            
            if ($payment) {
                $payment->update([
                    'status' => Payment::STATUS_FAILED,
                    'note' => json_encode([
                        'original_note' => json_decode($payment->note, true),
                        'cancellation_reason' => 'User cancelled payment',
                        'cancelled_at' => now()->toDateTimeString(),
                        'paypal_token' => $request->token,
                    ]),
                    'updated_by' => user()->id,
                ]);

                Log::info('Payment Status Updated to FAILED', [
                    'payment_id' => $payment->id,
                    'status' => 'FAILED'
                ]);
            }

            session()->forget(['pending_payment_id', 'paypal_order_id']);
        }

        return view('payment.cancelled');
    }

    /** Successful payment */
    public function paypalPaymentSuccess(Request $request)
    {
        Log::info('PayPal Payment Success Callback', [
            'request_data' => $request->all(),
            'token' => $request->token,
            'PayerID' => $request->PayerID
        ]);

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $paymentId = session('pending_payment_id');
        $paypalOrderId = session('paypal_order_id');

        try {
            // Capture the payment
            $response = $provider->capturePaymentOrder($request->token);
            
            // Log complete PayPal response
            Log::info('PayPal Capture Response', [
                'full_response' => $response,
                'status' => $response['status'] ?? null,
                'order_id' => $response['id'] ?? null
            ]);

            // Check if payment was successful
            if (isset($response['status']) && $response['status'] === 'COMPLETED') {
                
                DB::beginTransaction();
                
                try {
                    // Update payment record
                    $payment = Payment::find($paymentId);
                    
                    if ($payment) {
                        $payment->update([
                            'status' => Payment::STATUS_PAID,
                            'note' => json_encode([
                                'original_note' => json_decode($payment->note, true),
                                'paypal_capture_response' => $response,
                                'completed_at' => now()->toDateTimeString(),
                            ]),
                            'updated_by' => user()->id,
                        ]);

                        // Extract payer and payment details
                        $payer = $response['payer'] ?? [];
                        $purchaseUnit = $response['purchase_units'][0] ?? [];
                        $capture = $purchaseUnit['payments']['captures'][0] ?? [];

                        // Create payment method record
                        PaymentMethod::create([
                            'payment_id' => $payment->id,
                            'user_id' => $payment->user_id,
                            'method_type' => PaymentMethod::METHOD_TYPE_PAYPAL,
                            'provider' => 'PayPal',
                            'cardholder_name' => $payer['name']['given_name'] . ' ' . $payer['name']['surname'] ?? null,
                            'is_verified' => true,
                            'transaction_id' => $capture['id'] ?? $response['id'],
                            'created_by' => user()->id,
                        ]);

                        Log::info('Payment Successfully Completed', [
                            'payment_id' => $payment->id,
                            'status' => 'PAID',
                            'transaction_id' => $capture['id'] ?? $response['id'],
                            'payer_email' => $payer['email_address'] ?? null,
                            'amount' => $capture['amount']['value'] ?? null
                        ]);
                    }

                    DB::commit();
                    
                    session()->forget(['pending_payment_id', 'paypal_order_id']);
                    
                    return view('payment.success', [
                        'payment' => $payment,
                        'transaction_id' => $capture['id'] ?? $response['id']
                    ]);
                    
                } catch (\Exception $e) {
                    DB::rollBack();
                    throw $e;
                }
                
            } else {
                // Payment not completed
                Log::warning('PayPal Payment Not Completed', [
                    'status' => $response['status'] ?? 'unknown',
                    'response' => $response
                ]);

                if ($paymentId) {
                    $payment = Payment::find($paymentId);
                    if ($payment) {
                        $payment->update([
                            'status' => Payment::STATUS_FAILED,
                            'note' => json_encode([
                                'original_note' => json_decode($payment->note, true),
                                'failure_reason' => 'Payment not completed',
                                'paypal_status' => $response['status'] ?? 'unknown',
                                'paypal_response' => $response,
                            ]),
                            'updated_by' => user()->id,
                        ]);
                    }
                }

                return redirect()->route('payment.index')
                    ->with('error', 'Payment was not completed. Status: ' . ($response['status'] ?? 'unknown'));
            }

        } catch (\Exception $e) {
            Log::error('PayPal Payment Capture Failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'payment_id' => $paymentId
            ]);

            // Update payment to failed
            if ($paymentId) {
                $payment = Payment::find($paymentId);
                if ($payment) {
                    $payment->update([
                        'status' => Payment::STATUS_FAILED,
                        'note' => json_encode([
                            'original_note' => json_decode($payment->note, true),
                            'failure_reason' => $e->getMessage(),
                            'failed_at' => now()->toDateTimeString(),
                        ]),
                        'updated_by' => user()->id,
                    ]);
                }
            }

            return redirect()->route('payment.index')
                ->with('error', 'Payment capture failed. Please contact support.');
        }
    }
}
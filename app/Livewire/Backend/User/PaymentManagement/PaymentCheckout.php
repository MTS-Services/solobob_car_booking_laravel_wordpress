<?php

namespace App\Livewire\Backend\User\PaymentManagement;

use App\Models\Booking;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout(
    'app',
    [
        'title' => 'Payment-checkout',
        'breadcrumb' => 'Payment-checkout',
        'page_slug' => 'payment-checkout'
    ]
)]
class PaymentCheckout extends Component
{
    public $booking;
    public $selectedPaymentMethod = null;
    public $agreedToTerms = false;
    public $processing = false;

    public function mount($reference)
    {
        // Load booking with all relationships
        $this->booking = Booking::with([
            'user',
            'vehicle.images',
            'vehicle.relations.make',
            'vehicle.relations.model',
            'vehicle.category',
            'pickupLocation',
            'relation',
            'billingInformation',
        ])
        ->where('booking_reference', $reference)
        ->firstOrFail();

        // Check if booking is accepted
        if ($this->booking->booking_status !== Booking::BOOKING_STATUS_ACCEPTED) {
            session()->flash('error', 'This booking is not available for payment.');
            return redirect()->route('home');
        }
    }

    public function selectPaymentMethod($method)
    {
        $this->selectedPaymentMethod = $method;
    }

    public function processPayment()
    {
        $this->validate([
            'selectedPaymentMethod' => 'required|in:paypal,stripe',
            'agreedToTerms' => 'accepted',
        ], [
            'selectedPaymentMethod.required' => 'Please select a payment method.',
            'agreedToTerms.accepted' => 'You must agree to the terms and conditions.',
        ]);

        $this->processing = true;

        try {
            if ($this->selectedPaymentMethod === 'paypal') {
                // Redirect to PayPal payment processing
                return redirect()->route('payment.paypal', ['reference' => $this->booking->booking_reference]);
            } elseif ($this->selectedPaymentMethod === 'stripe') {
                // Redirect to Stripe payment processing
                return redirect()->route('payment.stripe', ['reference' => $this->booking->booking_reference]);
            }
        } catch (\Exception $e) {
            $this->processing = false;
            session()->flash('error', 'Payment processing failed. Please try again.');
        }
    }
    public function render()
    {
        return view('livewire.backend.user.payment-management.payment-checkout');
    }
}

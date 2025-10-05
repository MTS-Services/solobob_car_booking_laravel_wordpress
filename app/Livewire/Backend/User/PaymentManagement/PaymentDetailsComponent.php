<?php

namespace App\Livewire\Backend\User\PaymentManagement;

use App\Models\Payment;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout(
    'app',
    [
        'title' => 'Payment Details',
        'breadcrumb' => 'Payment Details',
        'page_slug' => 'user-payments'
    ]
)]
class PaymentDetailsComponent extends Component
{
    public $detailsPayment = null;
    public $paymentId = null;

    public function mount($id)
    {
        $this->paymentId = $id;
        $this->detailsPayment = Payment::findOrFail($this->paymentId)->first()->load('paymentMethod');
    }
    public function render()
    {
        return view('livewire.backend.user.payment-management.payment-details-component');
    }
}

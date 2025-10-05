<?php

namespace App\Livewire\Backend\Admin\PaymentManagement;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout(
    'app',
    [
        'title' => 'Payment Details',
        'breadcrumb' => 'Payment Details',
        'page_slug' => 'payments'
    ]
)]
class PaymentDetailsComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.admin.payment-management.payment-details');
    }
}

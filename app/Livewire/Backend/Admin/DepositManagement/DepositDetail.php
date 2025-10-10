<?php

namespace App\Livewire\Backend\Admin\DepositManagement;

use App\Models\Payment;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout(
    'app',
    [
        'title' => 'livewire.backend.admin.deposit-management.deposit-detail',
        'breadcrumb' => 'livewire.backend.admin.deposit-management.deposit-detail',
        'page_slug' => 'livewire.backend.admin.deposit-management.deposit-detail',
    ]
)]
class DepositDetail extends Component
{
    public $depositDetail = null;

    public $showModal = false;
 

    public function mount($id)
    {

        $this->depositDetail = Payment::with(['booking', 'user', 'paymentMethod'])
            ->find($id)
            ->first();

    }

    public function render()
    {
        return view('livewire.backend.admin.deposit-management.deposit-detail');
    }
}

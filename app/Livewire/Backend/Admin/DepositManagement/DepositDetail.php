<?php

namespace App\Livewire\Backend\Admin\DepositManagement;

use App\Models\Payment;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout(
    'app',
    [
        'title' => 'livewire.backend.admin.deposit-management.deposit-detail',
        'breadcrumb' => 'livewire.backend.admin.deposit-management.deposit-detail',
        'page_slug' => 'livewire.backend.admin.deposit-management.deposit-detail'
    ]
)]
class DepositDetail extends Component
{
    public $depositDetail = null;
    public  $showModal = false;

    public function mount($id){

        $this->depositDetail = Payment::findOrFail($id)
                            ->with(['booking','user','paymentMethod'])
                            ->first();

    }
    public function render()
    {
        return view('livewire.backend.admin.deposit-management.deposit-detail');
    }
}

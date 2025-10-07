<?php

namespace App\Livewire\Backend\User;

use App\Models\Payment;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout(
    'app',
    [
        'title' => 'livewire.backend.user.deposit-detail',
        'breadcrumb' => 'livewire.backend.user.deposit-detail',
        'page_slug' => 'livewire.backend.user.deposit-detail'
    ]
)]
class DepositDetail extends Component
{
    public $depositDetail = null;


    public function mount($id){
        $this->depositDetail = Payment::where('id', $id)
                            ->with(['booking','user','paymentMethod'])
                            ->first();
          

    }
    public function render()
    {
        return view('livewire.backend.user.deposit-detail');
    }
}

<?php

namespace App\Livewire\Backend\User;

use App\Models\Booking;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout(
    'app',
    [
        'title' => 'livewire.backend.user.my-bookings-details',
        'breadcrumb' => 'livewire.backend.user.my-bookings-details',
        'page_slug' => 'livewire.backend.user.my-bookings-details'
    ]
)]
class MyBookingsDetails extends Component
{

    public $detailsOrder = null;
    public function mount($id){

        $this->detailsOrder = Booking::query()->self()->where('id', $id)->firstOrFail();

    
        
    }
    public function render()
    {
        return view('livewire.backend.user.my-bookings-details');
    }
}

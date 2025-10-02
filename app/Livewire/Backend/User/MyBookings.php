<?php

namespace App\Livewire\Backend\User;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout(
    'app',
    [
        'title' => 'My-bookings',
        'breadcrumb' => 'My-bookings',
        'page_slug' => 'user-my-bookings'
    ]
)]
class MyBookings extends Component
{
    public function render()
    {
        return view('livewire.backend.user.my-bookings');
    }
}

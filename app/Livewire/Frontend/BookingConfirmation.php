<?php

namespace App\Livewire\Frontend;

use App\Models\Booking;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout(
    'app',
    [
        'title' => 'Booking Confirmation',
        'breadcrumb' => 'Booking Confirmation',
        'page_slug' => 'booking-confirmation',
    ]
)]
class BookingConfirmation extends Component
{
    public ?Booking $booking;

    public function mount($id)
    {
        // Load booking with all relations
        $this->booking = Booking::with([
            'vehicle.images',
            'vehicle.relations.make',
            'vehicle.relations.model',
            'user',
            'pickupLocation',
            'timeline'
        ])
        ->where('id', $id)
        ->where('user_id', user()->id) // Security: Only show user's own bookings
        ->firstOrFail();
    }

    public function downloadReceipt()
    {
        // TODO: Generate PDF receipt
        session()->flash('info', 'Receipt download will be available soon.');
    }

    public function render()
    {
        return view('livewire.frontend.booking-confirmation');
    }
}
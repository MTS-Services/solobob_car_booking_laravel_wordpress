<?php

namespace App\Livewire\Backend\User;

use App\Models\Booking;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout(
    'app',
    [
        'title' => 'My-bookings',
        'breadcrumb' => 'My-bookings',
        'page_slug' => 'user-my-bookings',
    ]
)]
class MyBookings extends Component
{
    public $search = '';

    public $perPage = 10;

    public function render()
    {

        $myBookings = Booking::query()
            ->self()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('booking_reference', 'like', '%'.$this->search.'%')
                        ->orWhere('return_location', 'like', '%'.$this->search.'%');
                });
            })
            ->with(['vehicle', 'user', 'pickupLocation', 'auditor'])
            ->latest()
            ->paginate($this->perPage);

        $columns = [

            ['key' => 'user_id', 'label' => 'Name', 'width' => '20%',
                'format' => function ($myBookings) {
                    return user()->name;
                },
            ],
            ['key' => 'booking_date', 'label' => 'Booking Date', 'width' => '20%',
                'format' => function ($myBookings) {

                    return Carbon::parse($myBookings->booking_date)->format('d M, Y h:i A');
                },
             ],

            ['key' => 'pickup_date', 'label' => 'Pickup Date', 'width' => '20%',
                'format' => function ($myBookings) {

                    return Carbon::parse($myBookings->pickup_date)->format('d M, Y h:i A');
                },
             ],

            [
                'key' => 'vehicle_id',
                'label' => 'Vehicle',
                'width' => '15%',
                'format' => function ($myBookings) {
                    return $myBookings->vehicle?->title ?? 'Unknow';
                },
             ],

        ];
        $actions = [
            ['key' => 'id', 'label' => 'View', 'route' => 'user.booking-details'],
        ];

        return view('livewire.backend.user.my-bookings', compact(
            'myBookings',
            'columns',
            'actions'
        ));
    }
}

<?php

namespace App\Livewire\Backend\User;

use App\Models\Booking;
use Carbon\Carbon;
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
    public $search = '';


    public function render()
    {

         $myBookings = Booking::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('booking_reference', 'like', '%' . $this->search . '%')
                        ->orWhere('return_location', 'like', '%' . $this->search . '%');
                });
            })
            ->with(['vehicle', 'user', 'pickupLocation', 'auditor'])
            ->latest()
            ->paginate(10);

         $columns = [
         
            ['key' => 'user_id', 'label' => 'Name', 'width' => '20%',
                'format'    => function($myBookings){
                    return user()->name;
                }
            ],
            ['key' => 'booking_date', 'label' => 'Booking Date', 'width' => '20%',
                'format'    => function($myBookings){
                    
                   return Carbon::parse($myBookings->booking_date)->format('d M, Y h:i A');
                }
            ],
             ['key' => 'booking_date', 'label' => 'Booking Date', 'width' => '20%',
                'format'    => function($myBookings){
                    
                   return Carbon::parse($myBookings->booking_date)->format('d M, Y h:i A');
                }
            ],
             ['key' => 'pickup_date', 'label' => 'Pickup Date', 'width' => '20%',
                'format'    => function($myBookings){
                    
                   return Carbon::parse($myBookings->pickup_date)->format('d M, Y h:i A');
                }
            ],
             ['key' => 'special_requests', 'label' => 'Notes', 'width' => '20%',
                
            ],
           

            [
                'key' => 'vehicle_id',
                'label' => 'Vehicle Models',
                'width' => '15%',
                'format' => function ($myBookings) {
                    return $myBookings->vehicle?->title ?? 'Unknow' ;
                }
            ]   , 
             [
                'key' => 'created_at',
                'label' => 'Created',
                'width' => '15%',
                'format' => function ($myBookings) {
                    return $myBookings->created_at_formatted;
                }
            ],               
        ];
         $actions = [
            ['key' => 'id', 'label' => 'View', 'href' => 'details'],
        ];
        return view('livewire.backend.user.my-bookings',compact(
            'myBookings',
            'columns',
            'actions'
        ));
    }
}

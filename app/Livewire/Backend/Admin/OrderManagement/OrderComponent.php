<?php

namespace App\Livewire\Backend\Admin\OrderManagement;

use App\Models\Booking;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout(
    'app',
    [
        'title' => 'Order Management',
        'breadcrumb' => 'Order Management',
        'page_slug' => 'order-management',
    ]
)]
class OrderComponent extends Component
{
    public $search = '';

    public $perPage = 10;

    public $editMode = false;

    public $showDetailsModal = false;

    public $detailsOrder = null;

    public function openDetailsModal($id)
    {

        $this->detailsOrder = Booking::withTrashed()

            ->findOrFail($id);

        $this->showDetailsModal = true;
    }

    public function closeDetailsModal()
    {
        $this->showDetailsModal = false;
    }

    public function render()
    {
        $orders = Booking::query()
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
                'format' => function ($orders) {
                    return $orders->user->name;
                },
            ],
            ['key' => 'booking_date', 'label' => 'Booking Date', 'width' => '20%',
                'format' => function ($orders) {

                    return Carbon::parse($orders->booking_date)->format('d M, Y h:i A');
                },
            ],
            ['key' => 'booking_date', 'label' => 'Booking Date', 'width' => '20%',
                'format' => function ($orders) {

                    return Carbon::parse($orders->booking_date)->format('d M, Y h:i A');
                },
            ],
            ['key' => 'pickup_date', 'label' => 'Pickup Date', 'width' => '20%',
                'format' => function ($orders) {

                    return Carbon::parse($orders->pickup_date)->format('d M, Y h:i A');
                },
            ],
            ['key' => 'special_requests', 'label' => 'Notes', 'width' => '20%',

            ],

            [
                'key' => 'vehicle_id',
                'label' => 'Vehicle Models',
                'width' => '15%',
                'format' => function ($orders) {
                    return $orders->vehicle?->title ?? 'Unknow';
                },
            ],
            [
                'key' => 'created_at',
                'label' => 'Created',
                'width' => '15%',
                'format' => function ($orders) {
                    return $orders->created_at_formatted;
                },
            ],
        ];

        $actions = [
            ['key' => 'id', 'label' => 'View', 'route' => 'admin.om.details'],
        ];

        return view('livewire.backend.admin.order-management.order-component', compact(

            'orders',
            'columns',
            'actions'

        ));
    }
}

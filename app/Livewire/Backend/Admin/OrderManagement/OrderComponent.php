<?php

namespace App\Livewire\Backend\Admin\OrderManagement;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Booking;

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
    public $editMode = false;





    public function render()
    {
        $orders = Booking::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('slug', 'like', '%' . $this->search . '%');
                });
            })
            ->with(['vehicle', 'user','pickupLocation','auditor'])
            ->latest()
            ->paginate(10);

       
        return view('livewire.backend.admin.order-management.order-component', compact('orders'));
    }
}

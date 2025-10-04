<?php

namespace App\Livewire\Backend\Admin\OrderManagement;

use Livewire\Component;
use Livewire\Attributes\Layout;

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
        $orders = []; // Replace with actual order fetching logic
        return view('livewire.backend.admin.order-management.order-component', compact('orders'));
    }
}

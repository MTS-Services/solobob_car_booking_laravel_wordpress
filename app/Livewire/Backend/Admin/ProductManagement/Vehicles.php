<?php

namespace App\Livewire\Backend\Admin\ProductManagement;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout(
    'app',
    [
        'title' => 'vehicle-product',
        'breadcrumb' => 'vehicle-product',
        'page_slug' => 'vehicle-product'
    ]
)]
class Vehicles extends Component
{
    public function render()
    {
        return view('livewire.backend.admin.product-management.vehicles');
    }
}

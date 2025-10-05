<?php

namespace App\Livewire\Frontend;

use App\Models\Vehicle;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout(
    'app',
    [
        'title' => 'Product',
        'breadcrumb' => 'Product',
        'page_slug' => 'product'
    ]
)]
class Product extends Component
{
    use WithPagination;

    public $perPage = 12; // Items per page

    public function render()
    {
        $products = Vehicle::query()
            ->with(['category', 'owner'])
            ->where('status', Vehicle::STATUS_AVAILABLE)
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.frontend.product', [
            'products' => $products
        ]);
    }
}
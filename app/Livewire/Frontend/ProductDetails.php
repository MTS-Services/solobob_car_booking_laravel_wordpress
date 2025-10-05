<?php

namespace App\Livewire\Frontend;

use App\Models\Vehicle;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout(
    'app',
    [
        'title' => 'Product Details',
        'breadcrumb' => 'Product Details',
        'page_slug' => 'product-details'
    ]
)]
class ProductDetails extends Component
{
    public $vehicle;

    public function mount($slug)
    {
        // Fetch vehicle with relationships
        $this->vehicle = Vehicle::where('slug', $slug)
            ->with(['category', 'owner'])
            ->where('status', Vehicle::STATUS_AVAILABLE)
            ->firstOrFail();
    }

    public function back()
    {
        return $this->redirect(route('products'), navigate: true);
    }

    public function render()
    {
        return view('livewire.frontend.product-details');
    }
}

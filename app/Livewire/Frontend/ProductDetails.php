<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout(
    'app',
    [
        'title' => 'Product-details',
        'breadcrumb' => 'Product-details',
        'page_slug' => 'product-details'
    ]
)]
class ProductDetails extends Component
{
    public function render()
    {
        return view('livewire.frontend.product-details');
    }
}

<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout(
    'app',
    [
        'title' => 'livewire.frontend.product-details',
        'breadcrumb' => 'livewire.frontend.product-details',
        'page_slug' => 'livewire.frontend.product-details'
    ]
)]
class ProductDetails extends Component
{
    public function render()
    {
        return view('livewire.frontend.product-details');
    }
}

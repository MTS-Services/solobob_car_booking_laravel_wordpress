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

    public $showModal = false;

    public function openModal()
    {
        $this->showModal = true;
        $this->dispatch('modal-opened');
    }

    public function closeModal()
    {
        $this->showModal = false;
    }
    public function render()
    {
        return view('livewire.frontend.product-details');
    }
}

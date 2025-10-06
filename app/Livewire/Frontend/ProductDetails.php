<?php

namespace App\Livewire\Frontend;

use App\Livewire\Forms\ContactForm;
use App\Models\Contacts;
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
            ->with(['category', 'owner', 'images'])
            ->where('status', Vehicle::STATUS_AVAILABLE)
            ->firstOrFail();
    }

    public function back()
    {
        return $this->redirect(route('products'), navigate: true);
    }

    // Contact message

    public ContactForm $form;

    public function contactSubmit()
    {

        $this->validate();

        Contacts::create($this->form->all());

        session()->flash('submit_message', 'Message has been sent successfully');

        $this->reset(['form.first_name', 'form.last_name', 'form.phone', 'form.email', 'form.message']);
    }

    public function render()
    {
        return view('livewire.frontend.product-details');
    }
}

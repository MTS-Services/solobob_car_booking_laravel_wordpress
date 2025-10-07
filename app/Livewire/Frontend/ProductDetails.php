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
    
    // Properties for selected vehicle in modal
    public $selectedVehicleTitle = '';
    public $selectedVehicleYear = '';
    
    // Contact form
    public ContactForm $form;

    public function mount($slug)
    {
        // Fetch vehicle with relationships
        $this->vehicle = Vehicle::where('slug', $slug)
            ->with(['category', 'owner', 'images'])
            ->where('status', Vehicle::STATUS_AVAILABLE)
            ->firstOrFail();
            
        // Set the selected vehicle details for the modal
        $this->selectedVehicleTitle = $this->vehicle->title;
        $this->selectedVehicleYear = $this->vehicle->year;
    }

    public function back()
    {
        return $this->redirect(route('products'), navigate: true);
    }

    public function contactSubmit()
    {
        $this->validate();

        // Create contact with vehicle information
        Contacts::create(array_merge(
            $this->form->all(),
            [
                'vehicle_info' => $this->selectedVehicleYear . ' ' . $this->selectedVehicleTitle,
                'vehicle_id' => $this->vehicle->id
            ]
        ));

        session()->flash('submit_message', 'Message has been sent successfully');

        $this->reset(['form.first_name', 'form.last_name', 'form.phone', 'form.email', 'form.message']);
    }

    public function render()
    {
        return view('livewire.frontend.product-details');
    }
}
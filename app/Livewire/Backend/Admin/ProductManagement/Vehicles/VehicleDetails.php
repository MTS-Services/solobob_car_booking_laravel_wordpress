<?php

namespace App\Livewire\Backend\Admin\ProductManagement\Vehicles;

use App\Models\Vehicle;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout(
    'app',
    [
        'title' => 'vehicle-details',
        'breadcrumb' => 'vehicle-details',
        'page_slug' => 'vehicle-list',
    ]
)]
class VehicleDetails extends Component
{
    public $vehicle;
    public $selectedImage = null;

    public function mount($id)
    {
        $this->vehicle = Vehicle::with(['category', 'owner', 'createdBy', 'updatedBy', 'deletedBy', 'images' => function($query) {
                $query->orderBy('sort_order');
            }])
            ->findOrFail($id);
        
        // Set the primary image or first image as selected
        if ($this->vehicle->images->isNotEmpty()) {
            $primaryImage = $this->vehicle->images->firstWhere('is_primary', true);
            $this->selectedImage = $primaryImage ? $primaryImage->image : $this->vehicle->images->first()->image;
        }
    }

    public function selectImage($imagePath)
    {
        $this->selectedImage = $imagePath;
    }

    public function render()
    {
        return view('livewire.backend.admin.product-management.vehicles.vehicle-details');
    }
}
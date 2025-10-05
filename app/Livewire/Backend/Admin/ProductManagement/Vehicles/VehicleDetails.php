<?php

namespace App\Livewire\Backend\Admin\ProductManagement\Vehicles;

use App\Models\Vehicle;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout(
    'app',
    [
        'title' => 'vehicle-details',
        'breadcrumb' => 'vehicle-details',
        'page_slug' => 'vehicle-details'
    ]
)]
class VehicleDetails extends Component
{
    public $vehicle;

    public function mount($id)
    {
        $this->vehicle = Vehicle::withTrashed()
            ->with(['category', 'owner', 'createdBy', 'updatedBy', 'deletedBy'])
            ->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.backend.admin.product-management.vehicles.vehicle-details');
    }
}

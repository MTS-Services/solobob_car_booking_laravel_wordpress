<?php

namespace App\Livewire\Backend\Admin\ProductManagement\Vehicles;

use App\Models\Vehicle;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('app', [
    'title' => 'vehicle-list',
    'breadcrumb' => 'vehicle-list',
    'page_slug' => 'vehicle-list'
])]
class VehicleList extends Component
{
    use WithPagination;

    public $search = '';
    public $showDeleteModal = false;
    public $vehicleIdToDelete = null;

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openDeleteModal($id)
    {
        $this->vehicleIdToDelete = $id;
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->vehicleIdToDelete = null;
    }

    public function deleteVehicle()
    {
        $vehicle = Vehicle::findOrFail($this->vehicleIdToDelete);
        $vehicle->update(['deleted_by' => user()->id]);
        $vehicle->delete();

        session()->flash('message', 'Vehicle deleted successfully.');
        $this->closeDeleteModal();
    }

    public function render()
    {
        $vehicles = Vehicle::query()
            ->when($this->search, function ($q) {
                $q->where(function ($sq) {
                    $sq->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('license_plate', 'like', '%' . $this->search . '%');
                });
            })
            ->with(['category', 'owner'])
            ->latest()
            ->paginate(10);

       return view('livewire.backend.admin.product-management.vehicles.vehicle-list', [
            'vehicles' => $vehicles,
        ]);
    }
}
  
<?php

namespace App\Livewire\Backend\Admin\ProductManagement\Vehicles;

use App\Models\Vehicle;
use App\Services\FileUpload\FileUploadService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout(
    'app',
    [
        'title' => 'vehicle-trash',
        'breadcrumb' => 'vehicle-trash',
        'page_slug' => 'vehicle-list',
    ]
)]

class VehicleTrash extends Component
{
    use WithPagination;

    protected FileUploadService $fileUploadService;

    public $search = '';

    public $showRestoreModal = false;

    public $showPermanentDeleteModal = false;

    public $vehicleIdToRestore = null;

    public $vehicleIdToDelete = null;

    protected $queryString = ['search'];

    public function boot(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openRestoreModal($id)
    {
        $this->vehicleIdToRestore = $id;
        $this->showRestoreModal = true;
    }

    public function closeRestoreModal()
    {
        $this->showRestoreModal = false;
        $this->vehicleIdToRestore = null;
    }

    public function openPermanentDeleteModal($id)
    {
        $this->vehicleIdToDelete = $id;
        $this->showPermanentDeleteModal = true;
    }

    public function closePermanentDeleteModal()
    {
        $this->showPermanentDeleteModal = false;
        $this->vehicleIdToDelete = null;
    }

    public function restore()
    {
        try {
            $vehicle = Vehicle::withTrashed()->findOrFail($this->vehicleIdToRestore);
            $vehicle->restore();

            $this->closeRestoreModal();

            session()->flash('message', 'Vehicle restored successfully.');

            $this->dispatch('$refresh');
        } catch (\Exception $e) {
            $this->closeRestoreModal();
            session()->flash('error', 'Failed to restore vehicle: '.$e->getMessage());
        }
    }

    public function permanentDelete()
    {
        try {
            // dd($this->vehicleIdToDelete);
            $vehicle = Vehicle::withTrashed()->findOrFail($this->vehicleIdToDelete);

            if ($vehicle->avatar) {
                $this->fileUploadService->delete($vehicle->avatar, 'public');
            }

            $vehicle->forceDelete();

            $this->closePermanentDeleteModal();

            session()->flash('message', 'Vehicle permanently deleted.');

            $this->dispatch('$refresh');
        } catch (\Exception $e) {
            $this->closePermanentDeleteModal();
            session()->flash('error', 'Failed to delete vehicle: '.$e->getMessage());
        }
    }

    public function render()
    {
        $vehicles = Vehicle::onlyTrashed()
            ->when($this->search, function ($q) {
                $q->where(function ($sq) {
                    $sq->where('title', 'like', '%'.$this->search.'%')
                        ->orWhere('license_plate', 'like', '%'.$this->search.'%');
                });
            })
            ->with(['category', 'owner', 'deletedBy'])
            ->latest('deleted_at')
            ->paginate(10);

        return view('livewire.backend.admin.product-management.vehicles.vehicle-trash', [
            'vehicles' => $vehicles,
        ]);
    }
}

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
        $columns = [
            ['key' => 'title', 'label' => 'Title', 'width' => '20%'],
            ['key' => 'license_plate', 'label' => 'License Plate', 'width' => '15%'],
            ['key' => 'owner', 'label' => 'Owner', 'width' => '15%', 'format' => fn($v) => $v->owner?->name ?? 'N/A'],
            ['key' => 'category', 'label' => 'Category', 'width' => '15%', 'format' => fn($v) => $v->category?->name ?? 'N/A'],
            [
                'key' => 'status',
                'label' => 'Status',
                'width' => '10%',
                'format' => fn($v) => '<span class="badge badge-soft ' . $v->status_color . '">' . ucfirst($v->status_label) . '</span>',
            ],
            [
                'key' => 'created_at',
                'label' => 'Created At',
                'width' => '15%',
                'format' => fn($v) => $v->created_at_formatted,
            ],
            [
                'key' => 'created_by',
                'label' => 'Created By',
                'width' => '15%',
                'format' => fn($v) => $v->createdBy?->name ?? 'System',
            ],
        ];

        $actions = [
            ['key' => 'id', 'label' => 'View', 'route' => 'admin.pm.vehicle-details'],
            ['key' => 'id', 'label' => 'Edit', 'route' => 'admin.pm.vehicle-edit'],
            ['key' => 'id', 'label' => 'Delete', 'method' => 'openDeleteModal'],
        ];

        return view('livewire.backend.admin.product-management.vehicles.vehicle-list', [
            'vehicles' => $vehicles,
            'columns' => $columns,
            'actions' => $actions
        ]);
    }
}

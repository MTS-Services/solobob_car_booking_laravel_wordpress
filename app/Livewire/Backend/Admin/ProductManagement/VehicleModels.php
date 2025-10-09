<?php

namespace App\Livewire\Backend\Admin\ProductManagement;

use App\Models\VehicleModel;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout(
    'app',
    [
        'title' => 'vehicle-models',
        'breadcrumb' => 'vehicle-models',
        'page_slug' => 'vehicle-model'
    ]
)]
class VehicleModels extends Component
{

    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $showDeleteModal = false;
    public $showDetailsModal = false;
    public $detailsVehicleModel = null;
    public $editMode = false;

    // Form fields
    public $adminId;
    public $name = '';
    public $slug = '';
    public $status = VehicleModel::STATUS_ACTIVE;






    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetFields()
    {
        $this->reset([
            'name',
            'status'

        ]);

        $this->status = VehicleModel::STATUS_ACTIVE;
        $this->resetValidation();
    }

    public function openCreateModal()
    {
        $this->resetFields();
        $this->showModal = true;
    }

    public function openDetailsModal($id)
    {
        $this->detailsVehicleModel = VehicleModel::withTrashed()
            ->with(['createdBy', 'updatedBy', 'deletedBy'])
            ->findOrFail($id);
        $this->showDetailsModal = true;
    }

    public function closeDetailsModal()
    {
        $this->showDetailsModal = false;
        $this->detailsVehicleModel = null;
    }

    public function openEditModal($id)
    {
        $this->resetFields();
        $admin = VehicleModel::findOrFail($id);

        $this->adminId = $admin->id;
        $this->name = $admin->name;
        $this->status = $admin->status ?? VehicleModel::STATUS_ACTIVE;
        $this->editMode = true;
        $this->showModal = true;
    }



    public function openDeleteModal($id)
    {
        $this->adminId = $id;
        $this->showDeleteModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetFields();
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->adminId = null;
    }

    public function save()
    {
        $rules = [
            'name' => 'required|string|max:255',


        ];



        $this->validate($rules);

        if ($this->editMode) {
            $vehicleModel = VehicleModel::findOrFail($this->adminId);

            $updateData = [
                'name' => $this->name,


                'updated_by' => user()->id,
            ];


            $vehicleModel->update($updateData);

            session()->flash('message', 'category updated successfully.');
        } else {
            $data = [
                'name' => $this->name,


                'created_by' => user()->id,
            ];

            // Handle avatar upload for new admin


            VehicleModel::create($data);

            session()->flash('message', 'category created successfully.');
        }

        $this->closeModal();
    }

    public function delete()
    {
        $vehicleModel = VehicleModel::findOrFail($this->adminId);


        // Update deleted_by before soft deleting
      //  $vehicleModel->update(['deleted_by' => user()->id]);
        $vehicleModel->delete(); // This will soft delete due to SoftDeletes trait

        session()->flash('message', 'Vehicle Model deleted successfully.');
        $this->closeDeleteModal();
    }

    public function render()
    {
        $vehicleModel = VehicleModel::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('slug', 'like', '%' . $this->search . '%');
                });
            })
            ->with(['createdBy', 'updatedBy'])
            ->latest()
            ->paginate(10);
        $columns = [

            ['key' => 'name', 'label' => 'Name', 'width' => '20%'],
            [
                'key' => 'status',
                'label' => 'Status',
                'width' => '10%',
                'format' => function ($vehicleModel) {
                    return '<span class="badge badge-soft ' . $vehicleModel->status_color . '">' . ucfirst($vehicleModel->status_label) . '</span>';
                }
            ],

            [
                'key' => 'created_at',
                'label' => 'Created At',
                'width' => '15%',
                'format' => function ($vehicleModel) {
                    return $vehicleModel->created_at_formatted;
                }
            ],

            [
                'key' => 'created_by',
                'label' => 'Created By',
                'width' => '15%',
                'format' => function ($vehicleModel) {
                    return $vehicleModel->createdBy?->name ?? 'System';
                }
            ]
        ];
        $actions = [
            ['key' => 'id', 'label' => 'View', 'method' => 'openDetailsModal'],
            ['key' => 'id', 'label' => 'Edit', 'method' => 'openEditModal'],
            ['key' => 'id', 'label' => 'Delete', 'method' => 'openDeleteModal'],
        ];

        return view(
            'livewire.backend.admin.product-management.vehicle-models',
            [
                'vehicleModels' => $vehicleModel,
                'columns' => $columns,
                'statuses' => VehicleModel::getStatuses(),
                'actions' => $actions

            ]
        );
    }
}

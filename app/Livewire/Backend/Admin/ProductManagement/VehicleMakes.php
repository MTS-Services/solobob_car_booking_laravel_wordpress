<?php

namespace App\Livewire\Backend\Admin\ProductManagement;


use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Models\VehicleMake;

#[Layout(
    'app',
    [
        'title' => 'vehicle-makes',
        'breadcrumb' => 'vehicle-makes',
        'page_slug' => 'vehicle-make'
    ]
)]
class VehicleMakes extends Component
{


    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $showDeleteModal = false;
    public $showDetailsModal = false;
    public $detailsAdmin = null;
    public $editMode = false;

    // Form fields
    public $adminId;
    public $name = '';
    public $slug = '';






    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetFields()
    {
        $this->reset([
            'name',
            'slug',


        ]);

        $this->resetValidation();
    }

    public function openCreateModal()
    {
        $this->resetFields();
        $this->showModal = true;
    }

    public function openDetailsModal($id)
    {
        $this->detailsAdmin = VehicleMake::withTrashed()
            ->with(['createdBy', 'updatedBy', 'deletedBy'])
            ->findOrFail($id);
        $this->showDetailsModal = true;
    }

    public function closeDetailsModal()
    {
        $this->showDetailsModal = false;
        $this->detailsAdmin = null;
    }

    public function openEditModal($id)
    {
        $this->resetFields();
        $admin = VehicleMake::findOrFail($id);

        $this->adminId = $admin->id;
        $this->name = $admin->name;
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
            $vehicleMake = VehicleMake::findOrFail($this->adminId);

            $updateData = [
                'name' => $this->name,
                'updated_by' => user()->id,
            ];


            $vehicleMake->update($updateData);

            session()->flash('message', 'category updated successfully.');
        } else {
            $data = [
                'name' => $this->name,

                'created_by' => user()->id,
            ];

            // Handle avatar upload for new admin


            VehicleMake::create($data);

            session()->flash('message', 'category created successfully.');
        }

        $this->closeModal();
    }

    public function delete()
    {
        $vehicleMake = VehicleMake::findOrFail($this->adminId);

        

        // Update deleted_by before soft deleting
     //   $vehicleMake->update(['deleted_by' => user()->id]);
        $vehicleMake->delete(); // This will soft delete due to SoftDeletes trait

        session()->flash('message', 'Vehicle deleted successfully.');
        $this->closeDeleteModal();
    }

    public function render()
    {
        $vehicleMake = VehicleMake::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                       
                });
            })
            ->with(['createdBy', 'updatedBy'])
            ->latest()
            ->paginate(10);

        $columns = [

            ['key' => 'name', 'label' => 'Name', 'width' => '20%'],

            [
                'key' => 'created_at',
                'label' => 'Created At',
                'width' => '15%',
                'format' => function ($vehicleMake) {
                    return $vehicleMake->created_at_formatted;
                }
            ],

            [
                'key' => 'created_by',
                'label' => 'Created By',
                'width' => '15%',
                'format' => function ($vehicleMake) {
                    return $vehicleMake->createdBy?->name ?? 'System';
                }
            ]
        ];
        $actions = [
            ['key' => 'id', 'label' => 'View', 'method' => 'openDetailsModal'],
            ['key' => 'id', 'label' => 'Edit', 'method' => 'openEditModal'],
            ['key' => 'id', 'label' => 'Delete', 'method' => 'openDeleteModal'],
        ];

        return view(
            'livewire.backend.admin.product-management.vehicle-makes',
            [
                'vehicleMakes' => $vehicleMake,
                'columns' => $columns,
                'actions' => $actions

            ]
        );
    }
}

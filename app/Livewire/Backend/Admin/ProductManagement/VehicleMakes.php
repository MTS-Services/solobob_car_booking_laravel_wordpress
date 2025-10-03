<?php

namespace App\Livewire\Backend\Admin\ProductManagement;


use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Models\VehicleMake;

#[Layout(
    'app',
    [
        'title' => 'livewire.backend.admin.product-management.vehicle-makes',
        'breadcrumb' => 'livewire.backend.admin.product-management.vehicle-makes',
        'page_slug' => 'livewire.backend.admin.product-management.vehicle-makes'
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
            'slug' => 'required|string|max:255|unique:categories,slug,' . ($this->editMode ? $this->adminId : 'NULL') . ',id',
           
           
        ];

       

        $this->validate($rules);

        if ($this->editMode) {
            $vehicleMake = VehicleMake::findOrFail($this->adminId);
            
            $updateData = [
                'name' => $this->name,
                'slug' => $this->slug,
              
                'updated_by' => user()->id,
            ];

           
            $vehicleMake->update($updateData);

            session()->flash('message', 'category updated successfully.');
        } else {
            $data = [
                'name' => $this->name,
                'slug' => $this->slug,
               
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

        // Prevent deleting yourself
        if ($vehicleMake->id === user()->id) {
            session()->flash('error', 'You cannot delete your own account.');
            $this->closeDeleteModal();
            return;
        }

        // Update deleted_by before soft deleting
        $vehicleMake->update(['deleted_by' => user()->id]);
        $vehicleMake->delete(); // This will soft delete due to SoftDeletes trait

        session()->flash('message', 'Admin deleted successfully.');
        $this->closeDeleteModal();
    }
    
    public function render()
    {
         $vehicleMake = VehicleMake::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('slug', 'like', '%' . $this->search . '%');
                });
            })
            ->with(['createdBy', 'updatedBy'])
            ->latest()
            ->paginate(10);
     
        return view('livewire.backend.admin.product-management.vehicle-makes',
            [
                'productCategories' => $vehicleMake,
                
            ]);
    }

}

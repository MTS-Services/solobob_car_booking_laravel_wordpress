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
            $vehicleModel = VehicleModel::findOrFail($this->adminId);
            
            $updateData = [
                'name' => $this->name,
                'slug' => $this->slug,
              
                'updated_by' => user()->id,
            ];

           
            $vehicleModel->update($updateData);

            session()->flash('message', 'category updated successfully.');
        } else {
            $data = [
                'name' => $this->name,
                'slug' => $this->slug,
               
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

        // Prevent deleting yourself
        if ($vehicleModel->id === user()->id) {
            session()->flash('error', 'You cannot delete your own account.');
            $this->closeDeleteModal();
            return;
        }

        // Update deleted_by before soft deleting
        $vehicleModel->update(['deleted_by' => user()->id]);
        $vehicleModel->delete(); // This will soft delete due to SoftDeletes trait

        session()->flash('message', 'Admin deleted successfully.');
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
     
        return view('livewire.backend.admin.product-management.vehicle-models',
            [
                'vehicleModels' => $vehicleModel,
                
            ]);
    }
   
}

<?php

namespace App\Livewire\Backend\Admin\ProductManagement;

use App\Models\VehicleFuel;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout(
    'app',
    [
        'title' => 'vehiclefuels',
        'breadcrumb' => 'vehiclefuels',
        'page_slug' => 'vehicle-fuel'
    ]
)]
class Vehiclefuels extends Component
{

    
      use WithPagination;

    public $search = '';
    public $showModal = false;
    public $showDeleteModal = false;
    public $showDetailsModal = false;
    public $detailsVehicleFuel = null;
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
        $this->detailsVehicleFuel = VehicleFuel::withTrashed()
            ->with(['createdBy', 'updatedBy', 'deletedBy'])
            ->findOrFail($id);
        $this->showDetailsModal = true;
    }

    public function closeDetailsModal()
    {
        $this->showDetailsModal = false;
        $this->detailsVehicleFuel = null;
    }

    public function openEditModal($id)
    {
        $this->resetFields();
        $admin = VehicleFuel::findOrFail($id);

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
            $vehiclefule = VehicleFuel::findOrFail($this->adminId);
            
            $updateData = [
                'name' => $this->name,
               
              
                'updated_by' => user()->id,
            ];

           
            $vehiclefule->update($updateData);

            session()->flash('message', 'category updated successfully.');
        } else {
            $data = [
                'name' => $this->name,
                
               
                'created_by' => user()->id,
            ];

            // Handle avatar upload for new admin
           

            VehicleFuel::create($data);

            session()->flash('message', 'category created successfully.');
        }

        $this->closeModal();
    }

    public function delete()
    {
        $vehiclefule = VehicleFuel::findOrFail($this->adminId);

 

        // Update deleted_by before soft deleting
        //$vehiclefule->update(['deleted_by' => user()->id]);
        $vehiclefule->delete(); // This will soft delete due to SoftDeletes trait

        session()->flash('message', 'Vehicle Fuel deleted successfully.');
        $this->closeDeleteModal();
    }
    
    public function render()
    {
         $vehiclefuel = VehicleFuel::query()
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
                'format' => function ($vehiclefuel) {
                    return $vehiclefuel->created_at_formatted;
                }
            ],

            [
                'key' => 'created_by',
                'label' => 'Created By',
                'width' => '15%',
                'format' => function ($vehiclefuel) {
                    return $vehiclefuel->createdBy?->name ?? 'System';
                }
            ]
        ];
        $actions = [
            ['key' => 'id', 'label' => 'View', 'method' => 'openDetailsModal'],
            ['key' => 'id', 'label' => 'Edit', 'method' => 'openEditModal'],
            ['key' => 'id', 'label' => 'Delete', 'method' => 'openDeleteModal'],
        ];
     
        return view('livewire.backend.admin.product-management.vehiclefuels',
            [
                'vehiclefuels' => $vehiclefuel,
                'columns' => $columns,
                'actions' => $actions
                
            ]);
    }
   
}

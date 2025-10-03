<?php

namespace App\Livewire\Backend\Admin\ProductManagement;

use App\Models\Category;
use Illuminate\Support\Facades\Hash;use Livewire\Component;
use Livewire\Attributes\Layout;

use Livewire\WithPagination;

#[Layout(
    'app',
    [
        'title' => 'product-category',
        'breadcrumb' => 'product-category',
        'page_slug' => 'product-category'
    ]
)]
class ProductCategory extends Component
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
    public $status = Category::STATUS_ACTIVE;
 
  



    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetFields()
    {
        $this->reset([
            'name', 
            'slug',
            'status',
       
        ]);
        $this->status = Category::STATUS_ACTIVE;
        $this->resetValidation();
    }

    public function openCreateModal()
    {
        $this->resetFields();
        $this->showModal = true;
    }

    public function openDetailsModal($id)
    {
        $this->detailsAdmin = Category::withTrashed()
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
        $admin = Category::findOrFail($id);

        $this->adminId = $admin->id;
        $this->name = $admin->name;
        $this->status = $admin->status ?? Category::STATUS_ACTIVE;
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
            'status' => 'required|in:' . Category::STATUS_ACTIVE . ',' . Category::STATUS_INACTIVE,
           
        ];

       

        $this->validate($rules);

        if ($this->editMode) {
            $category = Category::findOrFail($this->adminId);
            
            $updateData = [
                'name' => $this->name,
                'slug' => $this->slug,
                'status' => $this->status,
                'updated_by' => user()->id,
            ];

           
            $category->update($updateData);

            session()->flash('message', 'category updated successfully.');
        } else {
            $data = [
                'name' => $this->name,
                'slug' => $this->slug,
                'status' => $this->status,
                'created_by' => user()->id,
            ];

            // Handle avatar upload for new admin
           

            Category::create($data);

            session()->flash('message', 'category created successfully.');
        }

        $this->closeModal();
    }

    public function delete()
    {
        $category = Category::findOrFail($this->adminId);

        // Prevent deleting yourself
        if ($category->id === user()->id) {
            session()->flash('error', 'You cannot delete your own account.');
            $this->closeDeleteModal();
            return;
        }

        // Update deleted_by before soft deleting
        $category->update(['deleted_by' => user()->id]);
        $category->delete(); // This will soft delete due to SoftDeletes trait

        session()->flash('message', 'Admin deleted successfully.');
        $this->closeDeleteModal();
    }
    
    public function render()
    {
         $productCategories = Category::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('slug', 'like', '%' . $this->search . '%');
                });
            })
            ->with(['createdBy', 'updatedBy'])
            ->latest()
            ->paginate(10);
     
        return view('livewire.backend.admin.product-management.product-category',
            [
                'productCategories' => $productCategories,
                'statuses' => Category::getStatus(),
            ]);
    }
}

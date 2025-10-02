<?php

namespace App\Livewire\Backend\Admin\AdminManagement;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Hash;

#[Layout(
    'app',
    [
        'title' => 'admin',
        'breadcrumb' => 'admin',
        'page_slug' => 'admin'
    ]
)]
class Admin extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $showDeleteModal = false;
    public $editMode = false;

    // Form fields
    public $adminId;
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetFields()
    {
        $this->reset(['name', 'email', 'password', 'password_confirmation', 'adminId', 'editMode']);
        $this->resetValidation();
    }

    public function openCreateModal()
    {
        $this->resetFields();
        $this->showModal = true;
    }

    public function openEditModal($id)
    {
        $this->resetFields();
        $admin = User::findOrFail($id);

        $this->adminId = $admin->id;
        $this->name = $admin->name;
        $this->email = $admin->email;
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
            'email' => 'required|email|unique:users,email' . ($this->editMode ? ',' . $this->adminId : ''),
        ];

        if (!$this->editMode) {
            $rules['password'] = 'required|string|min:8|confirmed';
        } elseif ($this->password) {
            $rules['password'] = 'nullable|string|min:8|confirmed';
        }

        $this->validate($rules);

        if ($this->editMode) {
            $admin = User::findOrFail($this->adminId);
            $admin->update([
                'name' => $this->name,
                'email' => $this->email,
                'updated_by' => user()->id,
            ]);

            if ($this->password) {
                $admin->update(['password' => Hash::make($this->password)]);
            }

            session()->flash('message', 'Admin updated successfully.');
        } else {
            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'is_admin' => User::ROLE_ADMIN, // Automatically set as admin
                'created_by' => user()->id,
            ]);

            session()->flash('message', 'Admin created successfully.');
        }

        $this->closeModal();
    }

    public function delete()
    {
        $admin = User::findOrFail($this->adminId);

        // Prevent deleting yourself
        if ($admin->id === user()->id) {
            session()->flash('error', 'You cannot delete your own account.');
            $this->closeDeleteModal();
            return;
        }

        $admin->update(['deleted_by' => user()->id]);
        $admin->forceDelete();

        session()->flash('message', 'Admin deleted successfully.');
        $this->closeDeleteModal();
    }

    public function render()
    {
        $admins = User::admins()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->with(['createdBy', 'updatedBy'])
            ->latest()
            ->paginate(10);

        return view('livewire.backend.admin.admin-management.admin', [
            'admins' => $admins
        ]);
    }
}

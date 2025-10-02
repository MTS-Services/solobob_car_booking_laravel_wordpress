<?php

namespace App\Livewire\Backend\Admin\AdminManagement;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
    use WithPagination, WithFileUploads;

    public $search = '';
    public $showModal = false;
    public $showDeleteModal = false;
    public $showDetailsModal = false;
    public $detailsAdmin = null;
    public $editMode = false;

    // Form fields
    public $adminId;
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $status = User::STATUS_ACTIVE;
    public $avatar;
    public $existingAvatar = null;

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetFields()
    {
        $this->reset([
            'name', 
            'email', 
            'password', 
            'password_confirmation', 
            'adminId', 
            'editMode',
            'status',
            'avatar',
            'existingAvatar'
        ]);
        $this->status = User::STATUS_ACTIVE;
        $this->resetValidation();
    }

    public function openCreateModal()
    {
        $this->resetFields();
        $this->showModal = true;
    }

    public function openDetailsModal($id)
    {
        $this->detailsAdmin = User::withTrashed()
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
        $admin = User::findOrFail($id);

        $this->adminId = $admin->id;
        $this->name = $admin->name;
        $this->email = $admin->email;
        $this->status = $admin->status ?? User::STATUS_ACTIVE;
        $this->existingAvatar = $admin->avatar;
        $this->editMode = true;
        $this->showModal = true;
    }

    public function removeAvatar()
    {
        $this->avatar = null;
        $this->existingAvatar = null;
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
            'status' => 'required|in:' . User::STATUS_ACTIVE . ',' . User::STATUS_SUSPENDED . ',' . User::STATUS_DELETED,
            'avatar' => 'nullable|image|max:2048', // 2MB max
        ];

        if (!$this->editMode) {
            $rules['password'] = 'required|string|min:8|confirmed';
        } elseif ($this->password) {
            $rules['password'] = 'nullable|string|min:8|confirmed';
        }

        $this->validate($rules);

        if ($this->editMode) {
            $admin = User::findOrFail($this->adminId);
            
            $updateData = [
                'name' => $this->name,
                'email' => $this->email,
                'status' => $this->status,
                'updated_by' => user()->id,
            ];

            if ($this->password) {
                $updateData['password'] = Hash::make($this->password);
            }

            // Handle avatar upload
            if ($this->avatar) {
                // Delete old avatar if exists
                if ($admin->avatar) {
                    Storage::disk('public')->delete($admin->avatar);
                }
                $updateData['avatar'] = $this->avatar->store('avatars', 'public');
            } elseif ($this->existingAvatar === null && $admin->avatar) {
                // If existing avatar was removed
                Storage::disk('public')->delete($admin->avatar);
                $updateData['avatar'] = null;
            }

            $admin->update($updateData);

            session()->flash('message', 'Admin updated successfully.');
        } else {
            $data = [
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'is_admin' => User::ROLE_ADMIN,
                'status' => $this->status,
                'created_by' => user()->id,
            ];

            // Handle avatar upload for new admin
            if ($this->avatar) {
                $data['avatar'] = $this->avatar->store('avatars', 'public');
            }

            User::create($data);

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

        // Update deleted_by before soft deleting
        $admin->update(['deleted_by' => user()->id]);
        $admin->delete(); // This will soft delete due to SoftDeletes trait

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
            'admins' => $admins,
            'statuses' => User::getStatus(),
        ]);
    }
}
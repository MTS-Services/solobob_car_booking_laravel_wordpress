<?php

namespace App\Livewire\Backend\Admin\UserManagement;

use App\Models\User as ModelsUser;
use App\Services\FileUpload\FileUploadService;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;

#[Layout(
    'app',
    [
        'title' => 'User Management',
        'breadcrumb' => 'Users',
        'page_slug' => 'admin-users',
    ]
)]
class User extends Component
{
    use WithPagination, WithFileUploads;

    protected FileUploadService $fileUploadService;

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
    public $status = ModelsUser::STATUS_ACTIVE;
    public $avatar;
    public $existingAvatar = null;

    protected $queryString = ['search'];

    public function boot(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

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
        $this->status = ModelsUser::STATUS_ACTIVE;
        $this->resetValidation();
    }

    public function openCreateModal()
    {
        $this->resetFields();
        $this->showModal = true;
    }

    public function openDetailsModal($id)
    {
        $this->detailsAdmin = ModelsUser::withTrashed()
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
        $admin = ModelsUser::findOrFail($id);

        $this->adminId = $admin->id;
        $this->name = $admin->name;
        $this->email = $admin->email;
        $this->status = $admin->status ?? ModelsUser::STATUS_ACTIVE;
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
        if ($this->editMode) {
            $this->updateAdmin();
        } else {
            $this->createAdmin();
        }
    }

    protected function createAdmin()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'status' => 'required|in:' . ModelsUser::STATUS_ACTIVE . ',' . ModelsUser::STATUS_SUSPENDED . ',' . ModelsUser::STATUS_DELETED,
            'avatar' => 'nullable|image|max:2048',
        ]);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'is_admin' => ModelsUser::ROLE_ADMIN,
            'status' => $this->status,
            'created_by' => user()->id,
        ];

        // Handle avatar upload using service
        if ($this->avatar) {
            $data['avatar'] = $this->fileUploadService->uploadImage(
                file: $this->avatar,
                directory: 'avatars',
                width: 400,
                height: 400,
                disk: 'public',
                maintainAspectRatio: true
            );
        }

        ModelsUser::create($data);

        session()->flash('message', 'Admin created successfully.');
        $this->closeModal();
    }

    protected function updateAdmin()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->adminId,
            'password' => 'nullable|string|min:8|confirmed',
            'status' => 'required|in:' . ModelsUser::STATUS_ACTIVE . ',' . ModelsUser::STATUS_SUSPENDED . ',' . ModelsUser::STATUS_DELETED,
            'avatar' => 'nullable|image|max:2048',
        ]);

        $admin = ModelsUser::findOrFail($this->adminId);
        
        $updateData = [
            'name' => $this->name,
            'email' => $this->email,
            'status' => $this->status,
            'updated_by' => user()->id,
        ];

        // Update password if provided
        if ($this->password) {
            $updateData['password'] = Hash::make($this->password);
        }

        // Handle avatar update using service
        if ($this->avatar) {
            $updateData['avatar'] = $this->fileUploadService->updateImage(
                file: $this->avatar,
                oldPath: $admin->avatar,
                directory: 'avatars',
                width: 400,
                height: 400,
                disk: 'public',
                maintainAspectRatio: true
            );
        } elseif ($this->existingAvatar === null && $admin->avatar) {
            // If existing avatar was removed
            $this->fileUploadService->delete($admin->avatar, 'public');
            $updateData['avatar'] = null;
        }

        $admin->update($updateData);

        session()->flash('message', 'Admin updated successfully.');
        $this->closeModal();
    }

    public function delete()
    {
        $admin = ModelsUser::findOrFail($this->adminId);

        // Prevent deleting yourself
        if ($admin->id === user()->id) {
            session()->flash('error', 'You cannot delete your own account.');
            $this->closeDeleteModal();
            return;
        }

        // Update deleted_by before soft deleting
        $admin->update(['deleted_by' => user()->id]);
        $admin->delete();

        session()->flash('message', 'Admin deleted successfully.');
        $this->closeDeleteModal();
    }

    public function render()
    {
        $admins = ModelsUser::admins()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->with(['createdBy', 'updatedBy'])
            ->latest()
            ->paginate(10);

        return view('livewire.backend.admin.user-management.user', [
            'admins' => $admins,
            'statuses' => ModelsUser::getStatus(),
        ]);
    }
}

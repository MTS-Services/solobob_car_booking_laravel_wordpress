<?php

namespace App\Livewire\Backend\Admin\AdminManagement;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use App\Services\FileUpload\FileUploadService;

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
    public $number;
    public $date_of_birth;
    public $status = User::STATUS_ACTIVE;
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
            'status' => 'required|in:' . User::STATUS_ACTIVE . ',' . User::STATUS_SUSPENDED . ',' . User::STATUS_DELETED,
            'avatar' => 'nullable|image|max:2048',
            'date_of_birth' => 'required|date|before : today ',
            'number' => ['required', 'regex:/^(\+8801|01)[0-9]{9}$/'],

            // 'date_of_birth'
            // 'number'
        ]);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'is_admin' => User::ROLE_ADMIN,
            'status' => $this->status,
            'created_by' => user()->id,
            'date_of_birth' => $this->date_of_birth,
            'number' => $this->number,

            // 'date_of_birth' => 
            // 'number'
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

        User::create($data);

        session()->flash('message', 'Admin created successfully.');
        $this->closeModal();
    }

    protected function updateAdmin()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->adminId,
            'password' => 'nullable|string|min:8|confirmed',
            'status' => 'required|in:' . User::STATUS_ACTIVE . ',' . User::STATUS_SUSPENDED . ',' . User::STATUS_DELETED,
            'avatar' => 'nullable|image|max:2048',
        ]);

        $admin = User::findOrFail($this->adminId);

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
        $admin = User::findOrFail($this->adminId);

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

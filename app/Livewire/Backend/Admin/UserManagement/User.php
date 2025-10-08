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
        'page_slug' => 'users',
    ]
)]
class User extends Component
{
    use WithFileUploads, WithPagination;

    protected FileUploadService $fileUploadService;

    public $search = '';

    public $showModal = false;

    public $showDeleteModal = false;

    public $showDetailsModal = false;

    public $detailsUser = null;

    public $editMode = false;

    // Form fields
    public $userId;

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
            'userId',
            'editMode',
            'status',
            'avatar',
            'existingAvatar',
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
        $this->detailsUser = ModelsUser::withTrashed()
            ->with(['createdBy', 'updatedBy', 'deletedBy'])
            ->findOrFail($id);
        $this->showDetailsModal = true;
    }

    public function closeDetailsModal()
    {
        $this->showDetailsModal = false;
        $this->detailsUser = null;
    }

    public function openEditModal($id)
    {
        $this->resetFields();
        $user = ModelsUser::findOrFail($id);

        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->status = $user->status ?? ModelsUser::STATUS_ACTIVE;
        $this->existingAvatar = $user->avatar;
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
        $this->userId = $id;
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
        $this->userId = null;
    }

    public function save()
    {
        if ($this->editMode) {
            $this->updateUser();
        } else {
            $this->createUser();
        }
    }

    protected function createUser()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'status' => 'required|in:' . ModelsUser::STATUS_ACTIVE . ',' . ModelsUser::STATUS_SUSPENDED . ',' . ModelsUser::STATUS_INACTIVE,
            'avatar' => 'nullable|image|max:2048',
        ]);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'is_user' => ModelsUser::ROLE_USER,
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

        session()->flash('message', 'User created successfully.');
        $this->closeModal();
    }

    protected function updateUser()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'password' => 'nullable|string|min:8|confirmed',
            'status' => 'required|in:' . ModelsUser::STATUS_ACTIVE . ',' . ModelsUser::STATUS_SUSPENDED . ',' . ModelsUser::STATUS_INACTIVE,
            'avatar' => 'nullable|image|max:2048',
        ]);

        $user = ModelsUser::findOrFail($this->userId);

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
                oldPath: $user->avatar,
                directory: 'avatars',
                width: 400,
                height: 400,
                disk: 'public',
                maintainAspectRatio: true
            );
        } elseif ($this->existingAvatar === null && $user->avatar) {
            // If existing avatar was removed
            $this->fileUploadService->delete($user->avatar, 'public');
            $updateData['avatar'] = null;
        }

        $user->update($updateData);

        session()->flash('message', 'User updated successfully.');
        $this->closeModal();
        return $this->redirect(route('admin.admins'), navigate: true);
    }
    public function delete()
    {
        $user = ModelsUser::findOrFail($this->userId);

        // Prevent deleting yourself
        if ($user->id === user()->id) {
            session()->flash('error', 'You cannot delete your own account.');
            $this->closeDeleteModal();

            return;
        }

        // Update deleted_by before soft deleting
        $user->update(['deleted_by' => user()->id]);
        $user->delete();

        session()->flash('message', 'User deleted successfully.');
        $this->closeDeleteModal();
    }

    public function render()
    {
        $users = ModelsUser::user()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->with(['createdBy', 'updatedBy'])
            ->latest()
            ->paginate(10);
        $columns = [
            ['key' => 'name', 'label' => 'Name', 'width' => '20%'],
            ['key' => 'email', 'label' => 'Email', 'width' => '25%'],
            [
                'key' => 'status',
                'label' => 'Status',
                'width' => '10%',
                'format' => function ($admin) {
                    return '<span class="badge badge-soft ' . $admin->status_color . '">' . ucfirst($admin->status_label) . '</span>';
                }
            ],
            [
                'key' => 'created_at',
                'label' => 'Created',
                'width' => '15%',
                'format' => function ($admin) {
                    return $admin->created_at_formatted;
                }
            ],

            [
                'key' => 'created_by',
                'label' => 'Created',
                'width' => '15%',
                'format' => function ($admin) {
                    return $admin->createdBy?->name ?? 'System';
                }
            ]
        ];

        $actions = [
            ['key' => 'id', 'label' => 'View', 'method' => 'openDetailsModal'],
            ['key' => 'id', 'label' => 'Edit', 'method' => 'openEditModal'],
            ['key' => 'id', 'label' => 'Delete', 'method' => 'openForceDeleteModal'],
            
        ];
        return view('livewire.backend.admin.user-management.user', [
             'items' => $users,
            'statuses' => ModelsUser::getStatus(),
            'columns' => $columns,
            'actions' => $actions,
        ]);
    }
}

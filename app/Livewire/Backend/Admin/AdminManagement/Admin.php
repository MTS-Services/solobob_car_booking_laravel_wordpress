<?php

namespace App\Livewire\Backend\Admin\AdminManagement;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use App\Services\FileUpload\FileUploadService;
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

    protected FileUploadService $fileUploadService;

    public $search = '';
    public $perPage = 10;

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

    // Trash modal properties
    public $showTrashModal = false;
    public $showForceDeleteModal = false;
    public $forceDeleteId = null;
    public $trashSearch = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];
    // Customization for pagination theme
    protected string $paginationTheme = 'tailwind';

    public function boot(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function updatingTrashSearch()
    {
        $this->resetPage('trashedPage');
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
            'existingAvatar',
            'date_of_birth',
            'number',
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
        $this->number = $admin->number;
        $this->date_of_birth = $admin->date_of_birth;
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

    // Trash Modal Methods
    public function openTrashModal()
    {
        $this->showTrashModal = true;
        $this->resetPage('trashedPage');
    }

    public function closeTrashModal()
    {
        $this->showTrashModal = false;
        $this->trashSearch = '';
    }

    public function openForceDeleteModal($id)
    {
        $this->forceDeleteId = $id;
        $this->showForceDeleteModal = true;
    }

    public function closeForceDeleteModal()
    {
        $this->forceDeleteId = null;
        $this->showForceDeleteModal = false;
    }


    public function forceDelete()
    {
        if ($this->forceDeleteId) {
            $admin = User::findOrFail($this->forceDeleteId);

            // Delete avatar if exists
            if ($admin->avatar) {
                $this->fileUploadService->delete($admin->avatar, 'public');
            }

            $admin->delete();

            session()->flash('message', 'Admin permanently deleted!');
        }

        $this->closeForceDeleteModal();
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
            'status' => 'required|in:' . User::STATUS_ACTIVE . ',' . User::STATUS_SUSPENDED . ',' . User::STATUS_INACTIVE,
            'avatar' => 'nullable|image|max:2048',
            'date_of_birth' => 'nullable|date|before:today',
            'number' => 'nullable'
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
            'status' => 'required|in:' . User::STATUS_ACTIVE . ',' . User::STATUS_SUSPENDED . ',' . User::STATUS_INACTIVE,
            'avatar' => 'nullable|image|max:2048',
            'date_of_birth' => 'nullable|date|before:today',
            'number' => 'nullable',
        ]);

        $admin = User::findOrFail($this->adminId);

        $updateData = [
            'name' => $this->name,
            'email' => $this->email,
            'status' => $this->status,
            'updated_by' => user()->id,
            'date_of_birth' => $this->date_of_birth,
            'number' => $this->number,
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
        // Main admins query

        $admins = User::admin()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('number', 'like', '%' . $this->search . '%')
                        ->orWhere('date_of_birth', 'like', '%' . $this->search . '%');
                });
            })
            ->with(['createdBy', 'updatedBy'])
            ->orderBy('name', 'asc')
            ->paginate($this->perPage);

        
        $columns = [
            // ['key' => 'id', 'label' => 'ID', 'width' => '5%'],
            // [
            //     'key' => 'avatar',
            //     'label' => 'Avatar',
            //     'width' => '8%',
            //     'format' => function ($admin) {
            //         if ($admin->avatar) {
            //             return '<img src="' . Storage::url($admin->avatar) . '" class="w-10 h-10 rounded-full" alt="' . $admin->name . '">';
            //         }
            //         return '<div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-white font-bold">' . strtoupper(substr($admin->name, 0, 1)) . '</div>';
            //     }
            // ],
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


        // Trashed admins query - always return a paginator
        // $trashedAdmins = User::onlyTrashed()
        //     ->where('is_admin', true)
        //     ->when($this->trashSearch, function ($query) {
        //         $query->where(function ($q) {
        //             $q->where('name', 'like', '%' . $this->trashSearch . '%')
        //                 ->orWhere('email', 'like', '%' . $this->trashSearch . '%');
        //         });
        //     })
        //     ->with(['deletedBy', 'createdBy'])
        //     ->latest('deleted_at')
        //     ->paginate(10, ['*'], 'trashedPage');

        return view('livewire.backend.admin.admin-management.admin', [
            'admins' => $admins,
            // 'trashedAdmins' => $trashedAdmins,
            'statuses' => User::getStatus(),
            'columns' => $columns,
            'actions' => $actions,
        ]);
    }
}

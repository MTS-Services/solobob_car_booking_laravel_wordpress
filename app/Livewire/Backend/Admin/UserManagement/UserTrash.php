<?php

namespace App\Livewire\Backend\Admin\UserManagement;

use App\Models\User as ModelsUser;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout(
    'app',
    [
        'title' => 'livewire.backend.admin.user-management.user-trash',
        'breadcrumb' => 'livewire.backend.admin.user-management.user-trash',
        'page_slug' => 'livewire.backend.admin.user-management.user-trash',
    ]
)]
class UserTrash extends Component
{
    use WithPagination;

    public $search = '';

    public $perPage = 10;

    public $users = [];

    public $showDeleteModal = false;
    public $userId = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openDeleteModal($id)
    {
        $this->userId = $id;
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->userId = null;
    }

    public function permanentDelete()
    {
        try {
            ModelsUser::withTrashed()->findOrFail($this->userId)->forceDelete();
            session()->flash('message', 'User permanently deleted successfully.');
            $this->closeDeleteModal();
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function restore($id)
    {
        try {
            ModelsUser::withTrashed()->findOrFail($id)->restore();
            session()->flash('message', 'User restored successfully.');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render()
    {
        $this->users = ModelsUser::users()
            ->onlyTrashed()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('email', 'like', '%'.$this->search.'%');
                });
            })
            ->with(['createdBy', 'updatedBy'])
            ->latest()->get();

        return view('livewire.backend.admin.user-management.user-trash', [
            'users' => $this->users,
            'statuses' => ModelsUser::getStatus(),
        ]);
    }
}

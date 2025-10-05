<?php

namespace App\Livewire\Backend\Admin\UserManagement;

use App\Models\User as ModelsUser;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Livewire\Component;

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

    public function updatingSearch()
    {
        $this->resetPage();
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

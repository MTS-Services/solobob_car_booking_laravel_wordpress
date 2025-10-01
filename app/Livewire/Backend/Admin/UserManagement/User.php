<?php

namespace App\Livewire\Backend\Admin\UserManagement;

use Livewire\Attributes\Layout;
use Livewire\Component;

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
    public function render()
    {
        return view('livewire.backend.admin.user-management.user');
    }
}

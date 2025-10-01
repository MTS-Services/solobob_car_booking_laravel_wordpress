<?php

namespace App\Livewire\Backend\UserManagement;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout(
    'layouts.authenticated',
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
        return view('livewire.backend.user-management.user');
    }
}

<?php

namespace App\Livewire\Backend\Admin\AdminManagement;

use Livewire\Component;
use Livewire\Attributes\Layout;

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
    public function render()
    {
        return view('livewire.backend.admin.admin-management.admin');
    }
}

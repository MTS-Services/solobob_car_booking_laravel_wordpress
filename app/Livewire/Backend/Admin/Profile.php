<?php

namespace App\Livewire\Backend\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout(
    'app',
    [
        'title' => 'livewire.backend.admin.profile',
        'breadcrumb' => 'livewire.backend.admin.profile',
        'page_slug' => 'livewire.backend.admin.profile'
    ]
)]
class Profile extends Component
{
    public function render()
    {
        return view('livewire.backend.admin.profile');
    }
}

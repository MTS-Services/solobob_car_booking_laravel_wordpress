<?php

namespace App\Livewire\Backend\User;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout(
    'app',
    [
        'title' => 'Dashboard',
        'breadcrumb' => 'Dashboard',
        'page_slug' => 'user-dashboard'
    ]
)]
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.backend.user.dashboard');
    }
}

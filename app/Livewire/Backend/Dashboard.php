<?php

namespace App\Livewire\Backend;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout(
    'app',
    [
        'title' => 'Admin Dashboard',
        'breadcrumb' => 'Admin Dashboard',
        'page_slug' => 'admin-dashboard'
    ]
)]
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.backend.dashboard');
    }
}

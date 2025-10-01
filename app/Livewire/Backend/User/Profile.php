<?php

namespace App\Livewire\Backend\User;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout(
    'app',
    [
        'title' => 'Profile',
        'page_slug' => 'profile',
    ]
)]
class Profile extends Component
{
    public function render()
    {
        return view('livewire.backend.user.profile');
    }
}

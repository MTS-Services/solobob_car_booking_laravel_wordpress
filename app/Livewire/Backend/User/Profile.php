<?php

namespace App\Livewire\Backend\User;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout(
    'app',
    [
        'title' => 'User-profile',
        'page_slug' => 'user-profile',
    ]
)]
class Profile extends Component
{
    public function render()
    {
        return view('livewire.backend.user.profile');
    }
}

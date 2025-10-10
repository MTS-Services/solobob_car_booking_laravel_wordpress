<?php

namespace App\Livewire\Backend\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout(
    'app',
    [
        'title' => 'User Security',
        'breadcrumb' => 'User Security',
        'page_slug' => 'user-security',
    ]
)]
class Security extends Component
{
    public $current_password;

    public $password;

    public $password_confirmation;

    public function updatePassword()
    {
        $this->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::findOrFail(user()->id);

        $user->update([
            'password' => Hash::make($this->password),
        ]);

        // Reset form
        $this->reset(['current_password', 'password', 'password_confirmation']);

        // Flash success message
        session()->flash('success', 'Password changed successfully.');
    }

    public function render()
    {
        return view('livewire.backend.user.security');
    }
}

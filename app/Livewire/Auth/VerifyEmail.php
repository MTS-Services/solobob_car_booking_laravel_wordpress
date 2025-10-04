<?php

namespace App\Livewire\Auth;

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class VerifyEmail extends Component
{

    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            
            $defaultRoute = $user->is_admin 
                ? route('admin.dashboard', absolute: false) 
                : route('user.my-bookings', absolute: false);

            $this->redirectIntended(default: $defaultRoute, navigate: true);
            return;
        }

        // send email
        $user->sendEmailVerificationNotification();
        // flash message
        Session::flash('status', 'verification-link-sent');

    }

    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }
}

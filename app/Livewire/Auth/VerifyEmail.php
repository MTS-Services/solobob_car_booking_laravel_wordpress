<?php

namespace App\Livewire\Auth;

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log; // 🔹 Add this
use Livewire\Component;

class VerifyEmail extends Component
{
    /**
     * Send an email verification notification to the user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('admin.dashboard', absolute: false), navigate: true);
            return;
        }

        // send email
        $user->sendEmailVerificationNotification();

        // flash message
        Session::flash('status', 'verification-link-sent');

        // 🔹 log the action
        Log::info('Verification email sent', [
            'user_id' => $user->id,
            'email'   => $user->email,
            'time'    => now()->toDateTimeString(),
            'ip'      => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }
}

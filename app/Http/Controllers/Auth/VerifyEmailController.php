<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        dd('test');
        $user = $request->user();
        
        // Ensure user is authenticated
        if (!$user) {
            return redirect()->route('login');
        }
        dd($user ,'is_admin');
        // Determine the correct dashboard route
        $defaultRoute = $user->is_admin 
            ? route('admin.dashboard', absolute: false) 
            : route('user.my-bookings', absolute: false);

        if ($user->hasVerifiedEmail()) {
            return redirect($defaultRoute . '?verified=1');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return redirect($defaultRoute . '?verified=1');
    }
}
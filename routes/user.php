<?php

use App\Livewire\Backend\User\MyBookings;
use App\Livewire\Backend\User\Profile;
use App\Livewire\Backend\User\Security;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->name('user.')->prefix('user')->group(function () {
    Route::get('/profile', Profile::class)->name('profile');
    Route::get('/my-bookings', MyBookings::class)->name('my-bookings');
    Route::get('/security', Security::class)->name('security');
});

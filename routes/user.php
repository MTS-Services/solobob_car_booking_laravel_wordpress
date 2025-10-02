<?php

use App\Livewire\Backend\User\Dashboard;
use App\Livewire\Backend\User\Profile;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->name('user.')->prefix('user')->group(function () {
    Route::get('/profile', Profile::class)->name('profile');
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
});

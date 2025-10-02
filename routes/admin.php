<?php

use App\Livewire\Backend\Admin\Dashboard;
use App\Livewire\Backend\Admin\Profile;
use App\Livewire\Backend\Admin\UserManagement\User;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/users', User::class)->name('users');
    Route::get('/profile', Profile::class)->name('profile');
});

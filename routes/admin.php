<?php

use App\Livewire\Backend\Dashboard;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::get('/users', \App\Livewire\Backend\UserManagement\User::class)->name('users');
});

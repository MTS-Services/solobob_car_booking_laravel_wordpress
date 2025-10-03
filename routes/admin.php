<?php

use App\Livewire\Backend\Admin\AdminManagement\Admin;
use App\Livewire\Backend\Admin\Dashboard;
use App\Livewire\Backend\Admin\ProductManagement\ProductCategory;
use App\Livewire\Backend\Admin\ProductManagement\VehicleMakes;
use App\Livewire\Backend\Admin\UserManagement\User;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/users', User::class)->name('users');
    Route::get('/admins', Admin::class)->name('admins');
});

Route::middleware(['auth', 'admin'])->name('admin.')->group(function () {

  Route::group(['as' => 'pm.', 'prefix' => 'product-management'], function () {
      Route::get('/category', ProductCategory::class)->name('product-category');
    
  });

 Route::group(['as' => 'pm.', 'prefix' => 'product-management'], function () {
      Route::get('/vehicle', VehicleMakes::class)->name('vehicle-makes');
    
  });
});



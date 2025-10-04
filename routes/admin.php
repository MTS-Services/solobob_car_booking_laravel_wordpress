<?php

use App\Livewire\Backend\Admin\AdminManagement\Admin;
use App\Livewire\Backend\Admin\Dashboard;
use App\Livewire\Backend\Admin\Profile;
use App\Livewire\Backend\Admin\ProductManagement\ProductCategory;
use App\Livewire\Backend\Admin\ProductManagement\Vehiclefuels;
use App\Livewire\Backend\Admin\ProductManagement\VehicleMakes;
use App\Livewire\Backend\Admin\ProductManagement\VehicleModels;
use App\Livewire\Backend\Admin\ProductManagement\Vehicles;
use App\Livewire\Backend\Admin\ProductManagement\VehicleTransmissions;
use App\Livewire\Backend\Admin\UserManagement\User;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin', 'verified'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/users', User::class)->name('users');
    Route::get('/profile', Profile::class)->name('profile');
    Route::get('/admins', Admin::class)->name('admins');
});

Route::middleware(['auth', 'admin'])->name('admin.')->group(function () {

  Route::group(['as' => 'pm.', 'prefix' => 'product-management'], function () {
      Route::get('/category', ProductCategory::class)->name('product-category');
    
  });

 Route::group(['as' => 'pm.', 'prefix' => 'product-management'], function () {
      Route::get('/vehicle', VehicleMakes::class)->name('vehicle-makes');
    
  });
   Route::group(['as' => 'pm.', 'prefix' => 'product-management'], function () {
      Route::get('/vehiclefuel', Vehiclefuels::class)->name('vehicle-fuel');
    
  });
   Route::group(['as' => 'pm.', 'prefix' => 'product-management'], function () {
      Route::get('/vehiclemodel', VehicleModels::class)->name('vehicle-model');
    
  });

    Route::group(['as' => 'pm.', 'prefix' => 'product-management'], function () {
      Route::get('/vehicletransmission', VehicleTransmissions::class)->name('vehicle-transmission');
    
  });

  Route::group(['as' => 'pm.', 'prefix' => 'product-management'], function () {
      Route::get('/vehicleproduct', Vehicles::class)->name('vehicle-product');
    
  });
});



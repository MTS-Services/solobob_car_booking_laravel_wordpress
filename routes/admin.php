<?php

use Illuminate\Support\Facades\Route;

// Admin Components
use App\Livewire\Backend\Admin\Dashboard;
use App\Livewire\Backend\Admin\Profile;
use App\Livewire\Backend\Admin\AdminManagement\Admin;
use App\Livewire\Backend\Admin\UserManagement\User;

// Product Management Components
use App\Livewire\Backend\Admin\ProductManagement\ProductCategory;
use App\Livewire\Backend\Admin\ProductManagement\Vehiclefuels;
use App\Livewire\Backend\Admin\ProductManagement\VehicleMakes;
use App\Livewire\Backend\Admin\ProductManagement\VehicleModels;
use App\Livewire\Backend\Admin\ProductManagement\Vehicles;
use App\Livewire\Backend\Admin\ProductManagement\VehicleTransmissions;

// Other Management Components
use App\Livewire\Backend\Admin\DepositManagement\DepositComponent;
use App\Livewire\Backend\Admin\OrderManagement\OrderComponent;
use App\Livewire\Backend\Admin\OrderManagement\OrderDetails;
use App\Livewire\Backend\Admin\PaymentComponent;
use App\Livewire\Backend\Admin\ProductManagement\Vehicles\VehicleCreate;
use App\Livewire\Backend\Admin\ProductManagement\Vehicles\VehicleDetails;
use App\Livewire\Backend\Admin\ProductManagement\Vehicles\VehicleEdit;
use App\Livewire\Backend\Admin\ProductManagement\Vehicles\VehicleList;
use App\Livewire\Backend\Admin\ProductManagement\Vehicles\VehicleTrash;
use App\Livewire\Backend\Admin\UserManagement\UserTrash;


Route::middleware(['auth', 'admin', 'verified'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/users', User::class)->name('users');
    Route::get('/users/trash', UserTrash::class)->name('users.trash');
    Route::get('/profile', Profile::class)->name('profile');
    Route::get('/admins', Admin::class)->name('admins');

    Route::group(['as' => 'om.', 'prefix' => 'order-management'], function () {
        Route::get('/index', OrderComponent::class)->name('index');
        Route::get('/details/{id}', OrderDetails::class)->name('details');
    });

    Route::get('/deposit-management', DepositComponent::class)->name('deposits');
    
    Route::get('/deposits', DepositComponent::class)->name('deposits');
    Route::get('/orders', OrderComponent::class)->name('orders');
    Route::get('/payments', PaymentComponent::class)->name('payments');

    // Product Management
    Route::prefix('product-management')->as('pm.')->group(function () {
        Route::get('/category', ProductCategory::class)->name('product-category');
        Route::get('/vehicle-makes', VehicleMakes::class)->name('vehicle-makes');
        Route::get('/vehicle-fuel', Vehiclefuels::class)->name('vehicle-fuel');
        Route::get('/vehicle-model', VehicleModels::class)->name('vehicle-model');
        Route::get('/vehicle-transmission', VehicleTransmissions::class)->name('vehicle-transmission');
        Route::get('/vehicle-product', Vehicles::class)->name('vehicle-product');
        Route::get('/vehicle-list', VehicleList::class)->name('vehicle-list');
        Route::get('/vehicle-create', VehicleCreate::class)->name('vehicle-create');
        Route::get('/vehicle-edit/{id}', VehicleEdit::class)->name('vehicle-edit');
        Route::get('/vehicle-details/{id}', VehicleDetails::class)->name('vehicle-details');
        Route::get('/vehicle-trash', VehicleTrash::class)->name('vehicle-trash');
    });
});

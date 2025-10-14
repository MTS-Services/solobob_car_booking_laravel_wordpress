<?php

use App\Livewire\Backend\Admin\AdminManagement\Admin;
// Admin Components
use App\Livewire\Backend\Admin\Dashboard;
use App\Livewire\Backend\Admin\DepositManagement\DepositComponent;
use App\Livewire\Backend\Admin\DepositManagement\DepositDetail;
use App\Livewire\Backend\Admin\OrderManagement\OrderComponent;
// Product Management Components
use App\Livewire\Backend\Admin\OrderManagement\OrderDetails;
use App\Livewire\Backend\Admin\PaymentManagement\PaymentComponent;
use App\Livewire\Backend\Admin\PaymentManagement\PaymentDetailsComponent;
use App\Livewire\Backend\Admin\ProductManagement\ProductCategory;
use App\Livewire\Backend\Admin\ProductManagement\Vehiclefuels;
use App\Livewire\Backend\Admin\ProductManagement\VehicleMakes;
// Other Management Components
use App\Livewire\Backend\Admin\ProductManagement\VehicleModels;
use App\Livewire\Backend\Admin\ProductManagement\Vehicles;
use App\Livewire\Backend\Admin\ProductManagement\Vehicles\VehicleCreate;
use App\Livewire\Backend\Admin\ProductManagement\Vehicles\VehicleDetails;
use App\Livewire\Backend\Admin\ProductManagement\Vehicles\VehicleEdit;
use App\Livewire\Backend\Admin\ProductManagement\Vehicles\VehicleList;
use App\Livewire\Backend\Admin\ProductManagement\VehicleTransmissions;
use App\Livewire\Backend\Admin\Profile;
use App\Livewire\Backend\Admin\UserManagement\User;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin', 'verified'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/users', User::class)->name('users');
    Route::get('/profile', Profile::class)->name('profile');
    Route::get('/admins', Admin::class)->name('admins');

    Route::group(['as' => 'om.', 'prefix' => 'order-management'], function () {
        Route::get('/index', OrderComponent::class)->name('index');
        Route::get('/order/details/{id}', OrderDetails::class)->name('details');
    });

    Route::group([], function () {
        Route::get('/deposit-management', DepositComponent::class)->name('deposits');
        Route::get('/deposits', DepositComponent::class)->name('deposits');
        route::get('/deposit/details/{id}', DepositDetail::class)->name('deposit.detail');
    });

    Route::get('/orders', OrderComponent::class)->name('orders');

    Route::group(['prefix' => 'payment-management'], function () {
        Route::get('/', PaymentComponent::class)->name('payments');
        Route::get('/details/{id}', PaymentDetailsComponent::class)->name('payment-details');
    });

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
    });
});

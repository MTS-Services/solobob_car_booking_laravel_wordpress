<?php

use App\Http\Controllers\PaymentController;
use App\Livewire\Backend\User\Deposit;
use App\Livewire\Backend\User\DepositDetail;
use App\Livewire\Backend\User\MyBookings;
use App\Livewire\Backend\User\MyBookingsDetails;
use App\Livewire\Backend\User\PaymentManagement\PaymentCheckout;
use App\Livewire\Backend\User\PaymentManagement\PaymentComponent;
use App\Livewire\Backend\User\PaymentManagement\PaymentDetailsComponent;
use App\Livewire\Backend\User\Profile;
use App\Livewire\Backend\User\Security;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->name('user.')->prefix('user')->group(function () {
    Route::get('/profile', Profile::class)->name('profile');


    Route::get('/security', Security::class)->name('security');

    Route::group([], function () {
        Route::get('/my-bookings', MyBookings::class)->name('my-bookings');
        Route::get('/booking-details/{id}', MyBookingsDetails::class)->name('booking-details');
    });
    Route::group([], function () {
        Route::get('/deposits', Deposit::class)->name('deposit');
        Route::get('/deposit-details/{id}', DepositDetail::class)->name('deposit.detail');
    });

    Route::group(['prefix' => 'payment'], function () {
        Route::get('/list', PaymentComponent::class)->name('payments');
        Route::get('/details/{id}', PaymentDetailsComponent::class)->name('payment-details');
    });
  Route::get('/booking/{reference}/checkout', PaymentCheckout::class)
    ->name('booking.checkout');


});
Route::prefix('payments')->controller(PaymentController::class)->name('payment.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/product/{id}', 'paypalPaymentLink')->name('link');
    Route::get('/success', 'paypalPaymentSuccess')->name('paymentSuccess');
    Route::get('/cancel', 'paypalPaymentCancel')->name('paymentCancel');
});

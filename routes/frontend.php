<?php

use App\Livewire\Frontend\Buttons;
use App\Livewire\Frontend\Home;
use App\Livewire\Frontend\Product;
use App\Livewire\Frontend\ProductDetails;
use Illuminate\Support\Facades\Route;
use App\Livewire\Frontend\Booking;

Route::get('/', Home::class)->name('home');
Route::get('/buttons', Buttons::class)->name('buttons');
Route::get('/products',Product::class)->name('products');
<<<<<<< Updated upstream
Route::get('/products/details',ProductDetails::class)->name('product-details');
=======
Route::get('/booking',Booking::class)->name('booking');
>>>>>>> Stashed changes

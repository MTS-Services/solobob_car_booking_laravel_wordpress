<?php

use App\Livewire\Frontend\Booking;
use App\Livewire\Frontend\Buttons;
use App\Livewire\Frontend\Contact;
use App\Livewire\Frontend\Home;
use App\Livewire\Frontend\payment;
use App\Livewire\Frontend\Product;
use App\Livewire\Frontend\ProductDetails;
use App\Livewire\Frontend\sign_agreement;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');
Route::get('/buttons', Buttons::class)->name('buttons');
Route::get('/products', Product::class)->name('products');
Route::get('/contact', Contact::class)->name('contact');
Route::get('/payment', Payment::class)->name('payment');
Route::get('/sign_agreement', sign_agreement::class)->name('sign_agreement');
Route::get('/products/details/{slug}', ProductDetails::class)->name('product-details');

Route::get('/booking', Booking::class)->name('booking');

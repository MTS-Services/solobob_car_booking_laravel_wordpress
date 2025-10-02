<?php

use App\Livewire\Frontend\Buttons;
use App\Livewire\Frontend\Home;
use App\Livewire\Frontend\Product;
use App\Livewire\Frontend\ProductDetails;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');
Route::get('/buttons', Buttons::class)->name('buttons');
Route::get('/products',Product::class)->name('products');
Route::get('/products/details',ProductDetails::class)->name('product-details');

<?php

use App\Livewire\Frontend\Buttons;
use App\Livewire\Frontend\Home;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');
Route::get('/buttons', Buttons::class)->name('buttons');

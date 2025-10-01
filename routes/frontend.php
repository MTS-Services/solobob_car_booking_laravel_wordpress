<?php

use App\Livewire\Frontend\Pages\Buttons;
use App\Livewire\Frontend\Pages\Home;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');
Route::get('/buttons', Buttons::class)->name('buttons');

<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->name('user.')->prefix('user')->group(function () {
    //
});

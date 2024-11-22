<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\FacilityController;

//facility
Route::prefix('facilities')->group(function () {
    Route::get('/admin', [HomeController::class, 'index'])->name('admin.home');
});

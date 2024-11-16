<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\FacilityController;

//admin page
Route::get('/', [HomeController::class, 'index'])->name('admin.home');

//facility
Route::prefix('facilities')->group(function () {
    Route::get('/', [FacilityController::class, 'index'])->name('facilities.index');
    // Route::match(['get', 'post'], '/create', [FacilityController::class, 'create'])->name('facilities.create');
    // Route::match(['get', 'put'], '/update/{id}', [FacilityController::class, 'update'])->name('facilities.update');
    // Route::delete('/delete/{id}', [FacilityController::class, 'delete'])->name('facilities.delete');
});

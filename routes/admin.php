<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\FacilityController;

//admin page
Route::get('/', [HomeController::class, 'index'])->name('admin.home');

//facility
Route::prefix('facilities')->name('admin.facilities.')->group(function () {
    Route::get('/', [FacilityController::class, 'index'])->name('index');
    Route::get('/create', [FacilityController::class, 'create'])->name('create');
    Route::post('/store', [FacilityController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [FacilityController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [FacilityController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [FacilityController::class, 'delete'])->name('delete');
});

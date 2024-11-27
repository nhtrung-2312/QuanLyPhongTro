<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\FacilityController;
use App\Http\Controllers\Admin\RoomTypeController;
use App\Http\Controllers\Admin\CustomerController;

Route::prefix('')->name('admin.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
});
Route::prefix('facilities')->name('admin.facilities.')->group(function () {
    Route::get('/', [FacilityController::class, 'index'])->name('index');
    Route::get('/create', [FacilityController::class, 'create'])->name('create');
    Route::post('/store', [FacilityController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [FacilityController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [FacilityController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [FacilityController::class, 'delete'])->name('delete');
});

//room type
Route::prefix('room-types')->name('admin.room-types.')->group(function () {
    Route::get('/', [RoomTypeController::class, 'index'])->name('index');
    Route::get('/create', [RoomTypeController::class, 'create'])->name('create');
    Route::post('/store', [RoomTypeController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [RoomTypeController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [RoomTypeController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [RoomTypeController::class, 'delete'])->name('delete');
});

Route::prefix('customers')->name('admin.customers.')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('index');
});


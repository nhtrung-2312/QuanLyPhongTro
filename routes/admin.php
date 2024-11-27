<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\FacilityController;
use App\Http\Controllers\Admin\RoomTypeController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\LoaiPhiController;
use App\Http\Controllers\Admin\HopDongThueController;
use App\Http\Controllers\Admin\HoaDonController;
use App\Http\Controllers\Admin\ChiTietHoaDonController;
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

Route::prefix('khachhang')->name('admin.khachhang.')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('index');
});

Route::prefix('loaiphi')->name('admin.loaiphi.')->group(function () {
    Route::get('/', [LoaiPhiController::class, 'index'])->name('index');
});

Route::prefix('hopdongthue')->name('admin.hopdongthue.')->group(function () {
    Route::get('/', [HopDongThueController::class, 'index'])->name('index');
});
Route::prefix('hoadon')->name('admin.hoadon.')->group(function () {
    Route::get('/', [HoaDonController::class, 'index'])->name('index');
});
Route::prefix('chitiethoadon')->name('admin.chitiethoadon.')->group(function () {
    Route::get('/{MaHoaDon}', [ChiTietHoaDonController::class, 'index'])->name('index');
});

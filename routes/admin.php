<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\LoaiPhongController;
use App\Http\Controllers\Admin\KhachThueController;
use App\Http\Controllers\Admin\LoaiPhiController;
use App\Http\Controllers\Admin\HopDongThueController;
use App\Http\Controllers\Admin\HoaDonController;
use App\Http\Controllers\Admin\ChiTietHoaDonController;
use App\Http\Controllers\Admin\CoSoController;
use App\Http\Controllers\Admin\PhongController;

Route::prefix('')->name('admin.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
});
Route::prefix('coso')->name('admin.coso.')->group(function () {
    Route::get('/', [CoSoController::class, 'index'])->name('index');
    Route::get('/create', [CoSoController::class, 'create'])->name('create');
    Route::post('/store', [CoSoController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [CoSoController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [CoSoController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [CoSoController::class, 'delete'])->name('delete');
});



//room type
Route::prefix('loaiphong')->name('admin.loaiphong.')->group(function () {
    Route::get('/', [LoaiPhongController::class, 'index'])->name('index');
    Route::get('/create', [LoaiPhongController::class, 'create'])->name('create');
    Route::post('/store', [LoaiPhongController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [LoaiPhongController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [LoaiPhongController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [LoaiPhongController::class, 'delete'])->name('delete');
});

Route::prefix('khachhang')->name('admin.khachhang.')->group(function () {
    Route::get('/', [KhachThueController::class, 'index'])->name('index');
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

//room
Route::prefix('rooms')->name('admin.rooms.')->group(function() {
    Route::get('/', [PhongController::class, 'index'])->name('index');
    Route::get('/create', [PhongController::class, 'create'])->name('create');
    Route::post('/store', [PhongController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [PhongController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [PhongController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [PhongController::class, 'delete'])->name('delete');
});

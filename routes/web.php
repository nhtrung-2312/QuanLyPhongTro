<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\PhongController;
use App\Http\Controllers\Client\AuthController;
use App\Http\Controllers\Admin\HoaDonController;
use App\Http\Controllers\Client\ThongTinController;
use App\Http\Controllers\Client\ThanhToanController;
Route::middleware('web')->group(function () {
    Route::prefix('')->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home.index');
        Route::get('/about', [HomeController::class, 'about'])->name('home.about');
        Route::get('/contact', [HomeController::class, 'contact'])->name('home.contact');

        Route::prefix('phong')->group(function () {
            Route::get('/', [PhongController::class, 'index'])->name('phong.index');
            Route::post('/dat-phong', [PhongController::class, 'book'])->name('phong.book');
            Route::get('/chi-tiet/{id}', [PhongController::class, 'details'])->name('phong.details');
            Route::get('/{id}', [PhongController::class, 'show'])->name('phong.show');
        });

        Route::prefix('thong-tin')->middleware('auth.client')->group(function () {
            Route::get('/thong-tin-ca-nhan', [ThongTinController::class, 'index'])->name('thongtin.index');
            Route::post('/thong-tin-ca-nhan/update', [ThongTinController::class, 'ttupdate'])->name('thongtin.ttupdate');
            Route::get('/cap-nhat-tai-khoan', [ThongTinController::class, 'account'])->name('thongtin.account');
            Route::post('/cap-nhat-tai-khoan/update', [ThongTinController::class, 'tkupdate'])->name('thongtin.tkupdate');
            Route::get('/lich-su-hoa-don', [ThongTinController::class, 'history'])->name('thongtin.history');
            Route::get('/thong-tin-phong', [ThongTinController::class, 'phong'])->name('thongtin.phong');
        });

        Route::prefix('thanh-toan')->middleware('auth.client')->group(function () {
            Route::get('/dat-phong/{id}', [ThanhToanController::class, 'datphong'])->name('thanhToan.datphong');
            Route::post('/hoa-don/{id}', [ThanhToanController::class, 'bill'])->name('thanhToan.bill');
            Route::get('/thanh-toan-tien-mat', [ThanhToanController::class, 'thanhToanCash'])->name('thanhToan.thanhToanCash');
            Route::get('/thanh-toan-momo', [ThanhToanController::class, 'thanhToanMomo'])->name('thanhToan.thanhToanMomo');
            Route::post('/thanh-toan-momo', [ThanhToanController::class, 'thanhToanMomo'])->name('thanhToan.thanhToanMomo');
            // Route::get('/hoa-don/{id}', [ThanhToanController::class, 'thanhToanHoaDon'])->name('thanhToan.hoaDon');
            Route::get('/momo-callback', [ThanhToanController::class, 'momoCallback'])->name('thanhToan.momoCallback');
            Route::get('/thanh-toan-bank', [ThanhToanController::class, 'thanhToanBank'])->name('thanhToan.thanhToanBank');
        });
        Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
        Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
        Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    });
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::post('/hoadon/update', [HoaDonController::class, 'update'])->name('hoadon.update');
    Route::get('/hoadon/{maHoaDon}/get-status', [HoaDonController::class, 'getStatus'])->name('hoadon.getStatus');
});

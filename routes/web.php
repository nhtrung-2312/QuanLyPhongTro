<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\PhongController;
use App\Http\Controllers\Client\AuthController;
use App\Http\Controllers\Client\ThongTinController;

Route::middleware('web')->group(function () {
    Route::prefix('')->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home.index');
        Route::get('/about', [HomeController::class, 'about'])->name('home.about');
        Route::get('/contact', [HomeController::class, 'contact'])->name('home.contact');

        Route::prefix('phong')->group(function () {
            Route::get('/', [PhongController::class, 'index'])->name('phong.index');
            Route::post('/dat-phong', [PhongController::class, 'book'])->name('phong.book');
            Route::get('/thanh-toan/{id}', [PhongController::class, 'payment'])->name('phong.payment');
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
    });
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});

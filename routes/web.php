<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\PhongController;
use App\Http\Controllers\Client\AuthController;



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
    });
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});

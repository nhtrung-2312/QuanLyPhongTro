<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\PhongController;
use App\Http\Controllers\AuthenticationController;

Route::prefix('')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home.index');
    Route::get('/about', [HomeController::class, 'about'])->name('home.about');
    Route::get('/contact', [HomeController::class, 'contact'])->name('home.contact');

    Route::prefix('phong')->group(function () {
        Route::get('/', [PhongController::class, 'index'])->name('phong.index');
        Route::get('/{id}', [PhongController::class, 'show'])->name('phong.show');
        Route::get('/chi-tiet/{id}', [PhongController::class, 'details'])->name('phong.details');
    });
});

Route::post('/login', [AuthenticationController::class, 'login'])->name('login');
// Route::get('auth/google', [AuthenticationController::class, 'redirectToGoogle'])->name('google.login');
// Route::get('auth/google/callback', [AuthenticationController::class, 'handleGoogleCallback']);
Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');

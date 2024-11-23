<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\PhongController;

Route::prefix('')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home.index');
    Route::get('/about', [HomeController::class, 'about'])->name('home.about');
    Route::get('/contact', [HomeController::class, 'contact'])->name('home.contact');
});

Route::prefix('phong')->group(function () {
    Route::get('/', [PhongController::class, 'index'])->name('phong.index');
    Route::get('/{id}', [PhongController::class, 'show'])->name('phong.show');
});

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
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\NhanVienController;
use App\Http\Controllers\Api\HopDongThueApi;
use App\Http\Controllers\Api\LoaiPhiApi;
use App\Http\Controllers\Api\PhongTroApi;
use App\Http\Controllers\Api\KhachHangApi;


Route::get('/login', [AuthController::class, 'login'])->name('admin.auth.login');
Route::post('/store', [AuthController::class, 'store'])->name('admin.auth.store');
Route::get('/logout', [AuthController::class, 'logout'])->name('admin.logout');
Route::post('/check-permissions', [HomeController::class, 'checkPermissions'])->name('admin.checkPermissions');

Route::prefix('api')->name('api.')->group(function () {
    Route::get('/hopdongthue/get-phong', [HopDongThueApi::class, 'getPhong'])->name('hopdongthue.getPhong');
    Route::get('/loaiphi/get-loaiphi', [LoaiPhiApi::class, 'getLoaiPhi'])->name('loaiphi.getLoaiPhi');
    Route::get('/phongtro/get-phong', [PhongTroApi::class, 'getPhong'])->name('phongtro.getPhong');
    Route::get('/khachhang/get-khachhang', [KhachHangApi::class, 'getKhachHang'])->name('khachhang.getKhachHang');
});

Route::middleware(['auth.admin', 'check.permission'])->prefix('')->group(function () {
    Route::prefix('')->name('admin.')->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');
    });

    Route::resource('coso', CoSoController::class);
    Route::resource('loaiphong', LoaiPhongController::class);
    Route::resource('rooms', PhongController::class);
    Route::resource('khachhang', KhachThueController::class);
    Route::resource('loaiphi', LoaiPhiController::class);
    Route::resource('hopdongthue', HopDongThueController::class);
    Route::resource('hoadon', HoaDonController::class);
    // Route::resource('nhanvien', NhanVienController::class);

    Route::prefix('coso')->name('admin.coso.')->group(function () {
        Route::get('/', [CoSoController::class, 'index'])->name('index');
        Route::get('/create', [CoSoController::class, 'create'])->name('create');
        Route::post('/store', [CoSoController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [CoSoController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [CoSoController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [CoSoController::class, 'delete'])->name('delete');
    });

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
        Route::get('/create', [KhachThueController::class, 'create'])->name('create');
        Route::post('/store', [KhachThueController::class, 'store'])->name('store');
        Route::get('/edit/{maKhachThue}', [KhachThueController::class, 'edit'])->name('edit');
        Route::put('/update/{maKhachThue}', [KhachThueController::class, 'update'])->name('update');
    });

    Route::prefix('loaiphi')->name('admin.loaiphi.')->group(function () {
        Route::get('/', [LoaiPhiController::class, 'index'])->name('index');
        Route::get('/create', [LoaiPhiController::class, 'create'])->name('create');
        Route::post('/store', [LoaiPhiController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [LoaiPhiController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [LoaiPhiController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [LoaiPhiController::class, 'delete'])->name('delete');
    });

    Route::prefix('hopdongthue')->name('admin.hopdongthue.')->group(function () {
        Route::get('/', [HopDongThueController::class, 'index'])->name('index');
        Route::get('/edit/{id}', [HopDongThueController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [HopDongThueController::class, 'update'])->name('update');
        Route::get('/create', [HopDongThueController::class, 'create'])->name('create');
        Route::post('/store', [HopDongThueController::class, 'store'])->name('store');
    });
    Route::prefix('hoadon')->name('admin.hoadon.')->group(function () {
        Route::get('/', [HoaDonController::class, 'index'])->name('index');
        Route::get('/edit/{MaHoaDon}', [HoaDonController::class, 'edit'])->name('edit');
        Route::put('/update', [HoaDonController::class, 'update'])->name('update');
        Route::post('/store', [HoaDonController::class, 'store'])->name('store');
        Route::get('/create', [HoaDonController::class, 'create'])->name('create');
        Route::get('/details/{MaHoaDon}', [HoaDonController::class, 'details'])->name('details');
        Route::get('/xuat-hoa-don/{MaHoaDon}', [HoaDonController::class, 'printHoaDon'])->name('print');
    });

    Route::prefix('nhanvien')->name('admin.nhanvien.')->group(function () {
        Route::get('/', [NhanVienController::class, 'index'])->name('index');
        Route::get('/create', [NhanVienController::class, 'create'])->name('create');
        Route::post('/store', [NhanVienController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [NhanVienController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [NhanVienController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [NhanVienController::class, 'delete'])->name('delete');
    });

    Route::prefix('rooms')->name('admin.rooms.')->group(function() {
        Route::get('/', [PhongController::class, 'index'])->name('index');
        Route::get('/create', [PhongController::class, 'create'])->name('create');
        Route::post('/store', [PhongController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [PhongController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [PhongController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [PhongController::class, 'delete'])->name('delete');
        Route::get('/details/{id}', [PhongController::class, 'details'])->name('details');
        Route::get('/details/create/{id}', [PhongController::class, 'createDetail'])->name('details.create');
        Route::post('/details/store', [PhongController::class, 'storeDetail'])->name('details.store');
        Route::get('/details/{id}/edit/{maTienNghi}', [PhongController::class, 'editDetail'])->name('details.edit');
        Route::put('/details/update/{id}/{maTienNghi}', [PhongController::class, 'updateDetail'])->name('details.update');
        Route::delete('/details/delete/{id}/{idTienNghi}', [PhongController::class, 'deleteDetail'])->name('details.delete');
    });

});

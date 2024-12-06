<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KhachHang;
use Illuminate\Http\Request;
use App\Models\KhachThue;

class KhachHangApi extends Controller
{
    public function getKhachHang(Request $request) {
        $credentials = $request->validate([
            'sdt' => ['required', 'string', 'regex:/^0\d{9}$/', 'size:10'],
        ], [
            'sdt.required' => 'Số điện thoại không được để trống',
            'sdt.regex' => 'Số điện thoại phải bắt đầu bằng số 0 và có 10 chữ số',
            'sdt.size' => 'Số điện thoại phải có đúng 10 chữ số'
        ]);
        $khachHang = KhachThue::where('SDT', $request->sdt)->first();
        return response(['success' => 'true', 'data' => $khachHang]);
    }
}

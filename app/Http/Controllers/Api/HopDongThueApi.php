<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PhongTro;
class HopDongThueApi extends Controller
{
    public function getPhong() {
        $phongs = PhongTro::where('MaCoSo', session('selected_facility'))
        ->where('TrangThai', 'Phòng trống')
        ->get();
        return response(['success' => 'true', 'data' => $phongs]);
    }
}

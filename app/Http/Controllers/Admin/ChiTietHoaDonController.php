<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChiTietHoaDon;
use App\Models\HoaDon;
class ChiTietHoaDonController extends Controller
{
    public function details($MaHoaDon)
    {
        $chitiethoadons = ChiTietHoaDon::with(['hoadon.hopdongthue.phong.coSo'])->where('MaHoaDon', $MaHoaDon)->get();
        return view('Admin.ChiTietHoaDon.details', compact('chitiethoadons'));
    }

}

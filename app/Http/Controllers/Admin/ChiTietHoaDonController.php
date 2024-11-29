<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChiTietHoaDon;
use App\Models\HoaDon;
class ChiTietHoaDonController extends Controller
{
    public function index($MaHoaDon)
    {
        $chitiethoadons = ChiTietHoaDon::with(['hoadon.hopdongthue.phong.coSo'])->where('MaHoaDon', $MaHoaDon)->paginate(5);
        return view('Admin.ChiTietHoaDon.index', compact('chitiethoadons'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChiTietHoaDon;
use App\Models\HoaDon;
class ChiTietHoaDonController extends Controller
{
    public function index($maHoaDon)
    {
        $chitiethoadons = ChiTietHoaDon::with([
            'hoadon.hopdongthue.phong',
            'loaiPhi'
        ])->where('MaHoaDon', $maHoaDon)->get();

        return view('Admin.ChiTietHoaDon.index', compact('chitiethoadons'));
    }

}

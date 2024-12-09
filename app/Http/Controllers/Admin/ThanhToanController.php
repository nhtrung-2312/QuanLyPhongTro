<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ThanhToan;
use Illuminate\Http\Request;

class ThanhToanController extends Controller
{
    public function index()
    {
        $thanhtoans = ThanhToan::join('hoadon', 'thanhtoan.MaHoaDon', '=', 'hoadon.MaHoaDon')
            ->join('hopdongthue', 'hoadon.MaHopDong', '=', 'hopdongthue.MaHopDong')
            ->join('phongtro', 'hopdongthue.MaPhong', '=', 'phongtro.MaPhong')
            ->where('phongtro.MaCoSo', session('selected_facility'))
            ->select('thanhtoan.*')
            ->paginate(10);
        return view('Admin.HoaDon.lichsu', compact('thanhtoans'));
    }
}

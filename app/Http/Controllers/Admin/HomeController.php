<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PhongTro;
use App\Models\HopDongThue;
use App\Models\KhachThue;
use App\Models\HoaDon;
class HomeController extends Controller
{
    public function index()
    {
        $phongs = PhongTro::where('maCoSo', session('selected_facility'))->get();


        $khachThueMoi = KhachThue::select('khachthue.*')
        ->join('chitiethopdong', 'khachthue.MaKhachThue', '=', 'chitiethopdong.MaKhachThue')
        ->join('hopdongthue', 'chitiethopdong.MaHopDong', '=', 'hopdongthue.MaHopDong')
        ->join('phongtro', 'hopdongthue.MaPhong', '=', 'phongtro.MaPhong')
        ->where('phongtro.MaCoSo', session('selected_facility'))
        ->where('hopdongthue.TrangThai', 'Còn hiệu lực')
        ->distinct()
        ->get();

        $hoaDons = HoaDon::whereHas('hopdongthue.phong', function($query) {
            $query->where('MaCoSo', session('selected_facility'));
        })
        ->orderBy('NgayLap', 'desc')
        ->limit(5)
        ->get();

        $hopDongs = HopDongThue::whereHas('phong', function($query) {
            $query->where('MaCoSo', session('selected_facility'));
        })
        ->orderBy('NgayBatDau', 'desc')
        ->limit(5)
        ->get();

        return view('Admin.Home.index', compact('phongs', 'khachThueMoi', 'hoaDons', 'hopDongs'));
    }

    public function checkPermissions(Request $request)
    {
        $maCoSo = $request->maCoSo;
        session(['selected_facility' => $maCoSo]);
        return response()->json(['success' => true]);
    }
    public function thongtin()
    {
        return view('Admin.Home.thongtin');
    }
}

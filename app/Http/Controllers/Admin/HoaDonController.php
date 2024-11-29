<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HoaDon;
use App\Models\PhongTro;
class HoaDonController extends Controller
{
    public function index()
    {
        $hoadons = HoaDon::with(['hopdongthue.phong.coSo'])->paginate(5);
        return view('Admin.HoaDon.index', compact('hoadons'));
    }
    public function details($MaHoaDon)
    {
        $chitiethoadons = \App\Models\ChiTietHoaDon::where('MaHoaDon', $MaHoaDon)->get();
        return view('Admin.HoaDon.details', compact('chitiethoadons'));
    }
    public function getStatus($maHoaDon)
    {
        $hoaDon = HoaDon::find($maHoaDon);
        return response()->json([
            'TrangThai' => $hoaDon->TrangThai
        ]);
    }
    
    public function update(Request $request)
    {
        $hoaDon = HoaDon::find($request->MaHoaDon);
        $hoaDon->TrangThai = $request->TrangThai;
        $hoaDon->save();
    
        return response()->json([
            'status' => true,
            'message' => 'Cập nhật thành công!'
        ]);
    }
}

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
        $hoadons = HoaDon::with([
            'hopdongthue.phong.coSo'
        ])->orderBy('NgayLap', 'desc')
            ->paginate(5);

        return view('Admin.HoaDon.index', compact('hoadons'));
    }
    public function details($MaHoaDon)
    {
        $chitiethoadons = \App\Models\ChiTietHoaDon::where('MaHoaDon', $MaHoaDon)->get();
        return view('Admin.HoaDon.details', compact('chitiethoadons'));
    }
    public function getStatus($maHoaDon)
    {
        try {
            $hoaDon = HoaDon::find($maHoaDon);
            if (!$hoaDon) {
                return response()->json([
                    'status' => false,
                    'message' => 'Không tìm thấy hóa đơn!'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'data' => [
                    'MaHoaDon' => $hoaDon->MaHoaDon,
                    'TrangThai' => $hoaDon->TrangThai
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function update(Request $request)
    {
        try {
            $hoaDon = HoaDon::with(['chiTietHoaDon', 'hopdongthue.phong'])->find($request->MaHoaDon);
            if (!$hoaDon) {
                return response()->json([
                    'status' => false,
                    'message' => 'Không tìm thấy hóa đơn!'
                ], 404);
            }

            // Cập nhật trạng thái
            $hoaDon->TrangThai = $request->TrangThai;
            
            // Cập nhật lại tổng tiền
            $tienPhong = $hoaDon->hopdongthue->phong->GiaThue;
            $tongTienDichVu = $hoaDon->chiTietHoaDon->sum('ThanhTien');
            $hoaDon->TongTien = $tienPhong + $tongTienDichVu;
            
            $hoaDon->save();

            return response()->json([
                'status' => true,
                'message' => 'Cập nhật thành công!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }
}

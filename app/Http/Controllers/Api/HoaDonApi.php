<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HoaDon;
use App\Models\PhongTro;
use Illuminate\Http\Request;
use App\Models\ChiSoDienNuoc;
class HoaDonApi extends Controller
{
    public function getHoaDonByPhong(Request $request) {
        $phong = PhongTro::where('MaPhong', $request->maPhong)->first();
        if (!$phong) {
            return response(['success' => 'false', 'message' => 'Không tìm thấy phòng'], 404);
        }

        // $hopdongthue = $phong->hopdongthue()->first();
        // if (!$hopdongthue) {
        //     return response(['success' => 'false', 'message' => 'Không tìm thấy hợp đồng thuê'], 404);
        // }

        // $hoadon = $hopdongthue->hoadon()->orderBy('NgayLap', 'desc')->first();
        // if (!$hoadon) {
        //     return response(['success' => 'false', 'message' => 'Không tìm thấy hoá đơn'], 404);
        // }

        // $chitiethoadon = $hoadon->chitiethoadon()
        //     ->whereHas('loaiphi', function($query) {
        //         $query->whereIn('TenLoaiPhi', ['Tiền điện', 'Tiền nước']);
        //     })
        //     ->get();

        $chisodiennuoc = ChiSoDienNuoc::where('MaPhong', $phong->MaPhong)
                                        ->orderBy('NgayGhi', 'desc')
                                        ->first();

        return response(['success' => 'true', 'data' => $chisodiennuoc]);
    }
    public function getHoaDonByYear(Request $request) {
        $hoaDons = HoaDon::whereYear('NgayLap', $request->year)
                            ->where('TrangThai', 'Đã thanh toán')
                            ->whereHas('hopdongthue.phong', function($query) {
                                $query->where('MaCoSo', session('selected_facility'));
                            })
                            ->get();
        return response(['success' => 'true', 'data' => $hoaDons]);
    }
}


<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChiSoDienNuoc;
use Illuminate\Http\Request;
use App\Models\PhongTro;
use App\Models\KhachThue;
use App\Models\ChiTietHoaDon;
use App\Models\HoaDon;
use App\Models\HopDongThue;
use App\Models\ChiTietHopDong;
use App\Models\ThanhToan;
use App\Models\LoaiPhi;

use Illuminate\Support\Facades\DB;

class HopDongThueController extends Controller
{
    public function index()
    {
        $hopdongthues = HopDongThue::whereHas('phong', function($query) {
            $query->where('MaCoSo', session('selected_facility'));
        })->paginate(10);
        return view('Admin.HopDongThue.index', compact('hopdongthues'));
    }
    public function edit($id) {
        $hopdongthue = HopDongThue::find($id);
        return response(['success' => 'true', 'data' => $hopdongthue]);
    }
    public function update(Request $request, $id) {
        $hopdongthue = HopDongThue::find($id);
        $hopdongthue->update([
            'TrangThai' => $request->TrangThai
        ]);
        return response(['success' => 'true', 'data' => $hopdongthue]);
    }
    public function create() {
        return view('Admin.HopDongThue.create');
    }
    public function store(Request $request)
    {
        // return response()->json(['success' => 'true', 'data' => $request->all()]);
        $khachthue = KhachThue::where('SDT', $request->SoDienThoai)->first();

        DB::beginTransaction();

        do {
            $maHopDong = 'HDT' . str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);
        } while (HopDongThue::where('MaHopDong', $maHopDong)->exists());

        do {
            $maChiSoDienNuoc = 'CS' . str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);
        } while (ChiSoDienNuoc::where('MaChiSo', $maChiSoDienNuoc)->exists());

        do {
            $maHoaDon = 'HD' . str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);
        } while (HoaDon::where('MaHoaDon', $maHoaDon)->exists());

        $hopdongthue = new HopDongThue();
        $hopdongthue->MaHopDong = $maHopDong;
        $hopdongthue->MaPhong = $request->MaPhong;
        $hopdongthue->NgayBatDau = date('Y-m-d', strtotime(str_replace('/', '-', $request->NgayBatDau)));
        $hopdongthue->NgayKetThuc = date('Y-m-d', strtotime(str_replace('/', '-', $request->NgayKetThuc)));
        $hopdongthue->TrangThai = 'Chờ thanh toán cọc';
        $hopdongthue->TienCoc = $request->TienCoc;
        $hopdongthue->save();

        $phong = PhongTro::where('MaPhong', $request->MaPhong)->first();
        $phong->TrangThai = 'Đang thuê';
        $phong->save();

        $chisodn = new ChiSoDienNuoc();
        $chisodn->MaChiSo = $maChiSoDienNuoc;
        $chisodn->MaPhong = $request->MaPhong;
        $chisodn->DienCu = 0;
        $chisodn->DienMoi = 0;
        $chisodn->NuocCu = 0;
        $chisodn->NuocMoi = 0;
        $chisodn->NgayGhi = date('Y-m-d');
        $chisodn->save();

        $chitiethopdong = new ChiTietHopDong();
        $chitiethopdong->MaHopDong = $hopdongthue->MaHopDong;
        $chitiethopdong->MaKhachThue = $khachthue->MaKhachThue;
        $chitiethopdong->save();

        $hoadon = new HoaDon();
        $hoadon->MaHoaDon = $maHoaDon;
        $hoadon->MaHopDong = $hopdongthue->MaHopDong;
        $hoadon->MaChiSo = $maChiSoDienNuoc;
        $hoadon->NgayLap = date('Y-m-d');
        $hoadon->TongTien = $request->TongTienHoaDon;
        $hoadon->TrangThai = 'Chưa thanh toán';
        $hoadon->save();

        $loaiphis = LoaiPhi::where('MaCoSo', session('selected_facility'))->get();

        foreach($loaiphis as $loaiphi) {
            $chitietHD = new ChiTietHoaDon();
            $chitietHD->MaHoaDon = $maHoaDon;
            $chitietHD->MaLoaiPhi = $loaiphi->MaLoaiPhi;
            $chitietHD->GhiChu = null;

            switch($loaiphi->TenLoaiPhi) {
                case 'Tiền điện':
                    $chitietHD->SoLuong = $chisodn->DienMoi - $chisodn->DienCu;
                    $chitietHD->ThanhTien = $loaiphi->DonGia * $chitietHD->SoLuong;
                    break;
                case 'Tiền nước':
                    $chitietHD->SoLuong = $chisodn->NuocMoi - $chisodn->NuocCu;
                    $chitietHD->ThanhTien = $loaiphi->DonGia * $chitietHD->SoLuong;
                    break;
                default:
                    $chitietHD->SoLuong = 0;
                    $chitietHD->ThanhTien = 0;
                    if(in_array($loaiphi->MaLoaiPhi, $request->dichvu)) {
                        $soLuong = $request->input('quantity_' . $loaiphi->MaLoaiPhi);
                        $chitietHD->SoLuong = $soLuong;
                        $chitietHD->ThanhTien = $loaiphi->DonGia * $soLuong;
                    }
                    break;
            }
            $chitietHD->save();
        }

        DB::commit();

        return response(['success' => 'true', 'data' => $hopdongthue]);
    }
}

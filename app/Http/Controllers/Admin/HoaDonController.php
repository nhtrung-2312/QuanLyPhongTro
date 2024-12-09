<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChiSoDienNuoc;
use Illuminate\Http\Request;
use App\Models\HoaDon;
use App\Models\PhongTro;
use App\Models\CoSo;
use App\Models\LoaiPhi;
use Illuminate\Support\Facades\DB;
use App\Models\ChitietHoaDon;
use App\Models\ChiTietHopDong;
use App\Models\HopDongThue;
use App\Models\KhachThue;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use App\Models\ThanhToan;
class HoaDonController extends Controller
{
    public function index()
    {
        $hoadons = HoaDon::whereHas('hopdongthue.phong', function($query) {
            $query->where('MaCoSo', session('selected_facility'))->orderBy('NgayLap', 'desc');
        })->paginate(10);
        return view('Admin.HoaDon.index', compact('hoadons'));
    }
    public function edit($MaHoaDon)
    {
        $hoadon = HoaDon::find($MaHoaDon);
        return response()->json($hoadon);
    }
    public function update(Request $request)
    {
        $hoadon = HoaDon::find($request->MaHoaDon);
        $hoadon->TrangThai = $request->TrangThai;
        $hoadon->save();
        return response()->json(['success' => true]);
    }
    public function details($MaHoaDon)
    {
        $hoadon = HoaDon::find($MaHoaDon);
        $chitiethoadons = ChitietHoaDon::where('MaHoaDon', $MaHoaDon)->get();
        return view('Admin.HoaDon.details', compact('hoadon', 'chitiethoadons'));
    }
    public function printHoaDon($MaHoaDon)
    {
        $coso = CoSo::find(session('selected_facility'))->first();

        $hoadon = HoaDon::whereHas('hopdongthue.phong', function($query) {
            $query->where('MaCoSo', session('selected_facility'));
        })->where('MaHoaDon', $MaHoaDon)->first();

        $khachthue = KhachThue::join('ChiTietHopDong', 'KhachThue.MaKhachThue', '=', 'ChiTietHopDong.MaKhachThue')
            ->where('ChiTietHopDong.MaHopDong', $hoadon->MaHopDong)
            ->first();

        $pdf = Pdf::loadView('Admin.HoaDon.print', compact( 'coso', 'hoadon', 'khachthue'));
        return $pdf->download('hoa-don-' . $MaHoaDon . '.pdf');
    }
    public function create()
    {
        $hopdongs = HopDongThue::whereHas('phong', function($query) {
            $query->where('MaCoSo', session('selected_facility'));
        })->get();
        return view('Admin.HoaDon.create', compact('hopdongs'));
    }
    public function store(Request $request)
    {
        DB::beginTransaction();
        do {
            $machiso = 'CS' . str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);
        } while (ChiSoDienNuoc::where('MaChiSo', $machiso)->exists());

        $cthd = new ChiSoDienNuoc();
        $cthd->MaChiSo = $machiso;
        $cthd->MaPhong = $request->phongDaThue;
        $cthd->NgayGhi = now();
        $cthd->DienCu = $request->DienCu;
        $cthd->DienMoi = $request->DienMoi;
        $cthd->NuocCu = $request->NuocCu;
        $cthd->NuocMoi = $request->NuocMoi;
        $cthd->save();


        $hoadon = new HoaDon();
        do {
            $mahoadon = 'HD' . str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);
        } while (HoaDon::where('MaHoaDon', $mahoadon)->exists());

        $hoaDonTruoc = HoaDon::whereHas('hopdongthue', function($query) use ($request) {
            $query->where('MaPhong', $request->phongDaThue);
        })
        ->orderBy('NgayLap', 'desc')
        ->first();

        $hoadon->MaHoaDon = $mahoadon;
        $hoadon->MaHopDong = HopDongThue::where('MaPhong', $request->phongDaThue)->first()->MaHopDong;
        $hoadon->MaChiSo = $machiso;
        $hoadon->TrangThai = 'Chưa thanh toán';
        $hoadon->TongTien = 0;
        $hoadon->NgayLap = now();
        $hoadon->save();

        if ($hoaDonTruoc) {
            $chiTietHoaDonTruoc = ChiTietHoaDon::where('MaHoaDon', $hoaDonTruoc->MaHoaDon)->get();
            foreach ($chiTietHoaDonTruoc as $cthd) {
                $chitiet = new ChiTietHoaDon();
                $chitiet->MaHoaDon = $hoadon->MaHoaDon;
                $loaiphi = LoaiPhi::find($cthd->MaLoaiPhi);

                switch($loaiphi->TenLoaiPhi) {
                    case 'Tiền điện':
                        $chitiet->MaLoaiPhi = $cthd->MaLoaiPhi;
                        $chitiet->SoLuong = $request->DienMoi - $request->DienCu;
                        $chitiet->ThanhTien = $loaiphi->DonGia * $chitiet->SoLuong;
                        break;
                    case 'Tiền nước':
                        $chitiet->MaLoaiPhi = $cthd->MaLoaiPhi;
                        $chitiet->SoLuong = $request->NuocMoi - $request->NuocCu;
                        $chitiet->ThanhTien = $loaiphi->DonGia * $chitiet->SoLuong;
                        break;
                    default:
                        $chitiet->MaLoaiPhi = $cthd->MaLoaiPhi;
                        $chitiet->SoLuong = $cthd->SoLuong;
                        $chitiet->ThanhTien = $cthd->ThanhTien;
                        break;
                }
                $chitiet->save();
            }
        }
        $hoadon->TongTien = ChiTietHoaDon::where('MaHoaDon', $mahoadon)->sum('ThanhTien') + PhongTro::find($request->phongDaThue)->GiaThue;
        $hoadon->save();
        DB::commit();
        return response()->json(['success' => true]);
    }
}

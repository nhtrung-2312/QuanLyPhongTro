<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
}

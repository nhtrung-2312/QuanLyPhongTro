<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HoaDon;
use App\Models\PhongTro;
use App\Models\KhachThue;
use App\Models\LoaiPhi;
class ThanhToanController extends Controller
{
    public function datphong($id)
    {
        try {
            $phong = PhongTro::with(['loaiPhong', 'coSo'])->find($id);
            $khachthue = KhachThue::find(session('user_id'));

            if (!$phong || $phong->TrangThai !== 'Phòng trống') {
                return redirect()->route('phong.index')
                    ->with('error', 'Phòng không khả dụng');
            }

            if (!$khachthue) {
                return redirect()->route('phong.index')
                    ->with('error', 'Vui lòng đăng nhập để đặt phòng');
            }


            return view('Client.ThanhToan.datphong', compact('phong', 'khachthue'));

        } catch (\Exception $e) {
            return redirect()->route('phong.index')
                ->with('error', 'Có lỗi xảy ra, vui lòng thử lại');
        }
    }

    public function bill(Request $request, $id)
    {
        dd($request->all());
    }
    public function thanhToanMomo(Request $request)
    {
        dd($request->all());
    }
}

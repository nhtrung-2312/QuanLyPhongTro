<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\ThongTinRequest;
use App\Http\Requests\TaiKhoanRequest;
use App\Models\KhachThue;
use App\Models\TaiKhoan;
use App\Models\HoaDon;
use App\Models\PhongTro;
use Illuminate\Http\Request;


class ThongTinController extends Controller
{
    public function index()
    {
        $khachthue = KhachThue::find(session('user_id'));
        return view("Client.ThongTin.index", compact('khachthue'));
    }
    public function ttupdate(ThongTinRequest $request)
    {
        $credentials = $request->validated();

        $khachthue = KhachThue::where('MaKhachThue', session('user_id'))->first();

        if (!$khachthue) {
            return response()->json([
                'status' => false,
                'message' => 'Khách hàng không tồn tài',
            ], 422);
        }

        $khachthue->HoTen = $credentials['hoten'];
        $khachthue->CCCD = $credentials['cccd'];
        $khachthue->SDT = $credentials['sdt'];
        $khachthue->DiaChi = $credentials['diachi'];
        $khachthue->NgaySinh = $credentials['ngaysinh'];
        $khachthue->GioiTinh = $credentials['gioitinh'];
        $khachthue->save();

        session(['username' => $khachthue->HoTen]);

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật thông tin thành công.',
        ]);
    }
    public function tkupdate(TaiKhoanRequest $request)
    {
        $credentials = $request->validated();

        $taikhoan = TaiKhoan::find(session('acc_id'));

        if (!$taikhoan) {
            return response()->json([
                'status' => false,
                'message' => 'Tài khoản không tồn tại',
            ], 422);
        }

        $taikhoan->TenDangNhap = $credentials['phone'];
        $taikhoan->MatKhau = $credentials['password'];
        $taikhoan->save();

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật thông tin thành công.',
        ]);
    }
    public function account()
    {
        $taikhoan = TaiKhoan::find(session('acc_id'));
        return view('Client.ThongTin.account', compact('taikhoan'));
    }
    public function history()
    {
        $hoadons = HoaDon::join('hopdongthue', 'hoadon.MaHopDong', '=', 'hopdongthue.MaHopDong')
            ->join('chitiethopdong', 'hopdongthue.MaHopDong', '=', 'chitiethopdong.MaHopDong')
            ->where('chitiethopdong.MaKhachThue', session('user_id'))
            ->select('hoadon.*')
            ->get();
        return view('Client.ThongTin.history', compact('hoadons'));
    }
    public function phong()
    {
        $khachthue = KhachThue::with([
            'chitiethopdong.hopdongthue' => function($query) {
                $query->select('hopdongthue.*');
            },
            'chitiethopdong.hopdongthue.phong.coso',  // Thêm relationship với cơ sở
            'chitiethopdong.hopdongthue.phong.loaiphong'  // Thêm relationship với loại phòng
        ])
        ->find(session('user_id'));

        $phongs = collect();
        foreach($khachthue->chitiethopdong as $chitiet) {
            if ($chitiet->hopdongthue && $chitiet->hopdongthue->phong) {
                $phongs->push([
                    'hopdongthue' => $chitiet->hopdongthue,
                    'phong' => $chitiet->hopdongthue->phong,
                    'coso' => $chitiet->hopdongthue->phong->coso,
                    'loaiphong' => $chitiet->hopdongthue->phong->loaiphong,
                    'NgayBatDau' => $chitiet->hopdongthue->NgayBatDau,
                    'NgayKetThuc' => $chitiet->hopdongthue->NgayKetThuc,
                    'TrangThaiHD' => $chitiet->hopdongthue->TrangThai
                ]);
            }
        }

        return view('Client.ThongTin.phong', compact('phongs'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\NhanVien;
use App\Models\TaiKhoan;
use App\Models\PhanQuyen;
class NhanVienController extends Controller
{
    public function index()
    {
        $nhanviens = NhanVien::paginate(10);
        return view("admin.nhanvien.index", compact("nhanviens"));
    }
    public function create()
    {
        return view("admin.nhanvien.create");
    }
    public function edit($maNhanVien)
    {
        $nhanvien = NhanVien::find($maNhanVien);
        return response()->json([
            'success' => true,
            'data' => $nhanvien
        ]);
    }
    public function update(Request $request)
    {
        $nhanvien = NhanVien::find($request->MaNhanVien);
        $nhanvien->HoTen = $request->HoTen;
        $nhanvien->SDT = $request->SDT;
        $nhanvien->DiaChi = $request->DiaChi;
        $nhanvien->NgaySinh = $request->NgaySinh;
        $nhanvien->GioiTinh = $request->GioiTinh;
        $nhanvien->CCCD = $request->CCCD;
        $nhanvien->ChucVu = $request->ChucVu;
        $nhanvien->save();

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật thành công!'
        ]);
    }
    public function delete($maNhanVien)
    {
        $nhanvien = NhanVien::find($maNhanVien);
        $nhanvien->delete();
        return response()->json(['success' => true]);
    }
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'HoTen' => 'required|string|max:255',
            'SDT' => 'required|string|regex:/^0\d{9}$/',
            'DiaChi' => 'required|string|max:255',
            'CCCD' => 'required|string|regex:/^\d{12}$/',
            'NgaySinh' => 'required|date',
            'GioiTinh' => 'required|string',
            'ChucVu' => 'required|string',
        ], [
            'HoTen.required' => 'Vui lòng nhập họ tên',
            'HoTen.max' => 'Họ tên không được vượt quá 255 ký tự',
            'SDT.required' => 'Vui lòng nhập số điện thoại',
            'SDT.regex' => 'Số điện thoại không hợp lệ',
            'DiaChi.required' => 'Vui lòng nhập địa chỉ',
            'DiaChi.max' => 'Địa chỉ không được vượt quá 255 ký tự',
            'CCCD.required' => 'Vui lòng nhập CCCD',
            'CCCD.regex' => 'CCCD không hợp lệ',
            'NgaySinh.required' => 'Vui lòng nhập ngày sinh',
            'NgaySinh.date' => 'Ngày sinh không hợp lệ',
            'GioiTinh.required' => 'Vui lòng chọn giới tính',
            'ChucVu.required' => 'Vui lòng chọn chức vụ',
        ]);

        if($request->createAccount === 'on') {
            $account = $request->validate([
                'TenDangNhap' => 'required|string|max:255|unique:TaiKhoan,TenDangNhap',
                'MatKhau' => 'required|string|min:8',
            ]);
        }

        do {
            $maTaiKhoan = 'TK' . str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);
        } while (TaiKhoan::where('MaTaiKhoan', $maTaiKhoan)->exists());

        do {
            $maNhanVien = 'NV' . str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);
        } while (NhanVien::where('MaNhanVien', $maNhanVien)->exists());

        $credentials['MaTaiKhoan'] = $request->createAccount ? TaiKhoan::create([
            'MaTaiKhoan' => $maTaiKhoan,
            'TenDangNhap' => $request->TenDangNhap,
            'MatKhau' => $request->MatKhau,
            'VaiTro' => $request->ChucVu,
            'TrangThai' => 1
        ])->MaTaiKhoan : null;

        $credentials['MaNhanVien'] = $maNhanVien;
        $nhanvien = new NhanVien();
        $nhanvien->MaNhanVien = $maNhanVien;
        $nhanvien->HoTen = $request->HoTen;
        $nhanvien->SDT = $request->SDT;
        $nhanvien->DiaChi = $request->DiaChi;
        $nhanvien->NgaySinh = $request->NgaySinh;
        $nhanvien->GioiTinh = $request->GioiTinh;
        $nhanvien->CCCD = $request->CCCD;
        $nhanvien->Luong = 0;
        $nhanvien->ChucVu = $request->ChucVu;
        if($request->createAccount === 'on') {
            $nhanvien->MaTaiKhoan = $credentials['MaTaiKhoan'];
        } else {
            $nhanvien->MaTaiKhoan = null;
        }
        $nhanvien->save();

        return response()->json(['success' => true]);
    }
    public function phanQuyen()
    {
        $taikhoans = TaiKhoan::where('VaiTro', '!=', 'Khách hàng')->get();
        return view("admin.nhanvien.phanquyen", compact("taikhoans"));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KhachThue;
use App\Models\TaiKhoan;
use App\Http\Requests\KhachThueRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class KhachThueController extends Controller
{
    public function index(Request $request)
    {
        $user = TaiKhoan::find(session('admin_id'));
        $selectedFacility = session('selected_facility');

        if ($user->VaiTro === 'Chủ trọ') {
            $khachhangs = KhachThue::with(['TaiKhoan'])->paginate(10);
        } else {
            $khachhangs = KhachThue::with(['TaiKhoan'])
                ->whereHas('ChiTietHopDong.HopDongThue.Phong', function($query) use ($selectedFacility) {
                    $query->where('MaCoSo', $selectedFacility);
                })
                ->whereHas('ChiTietHopDong.HopDongThue', function($query) {
                    $query->where('TrangThai', 'Đang thuê');
                })
                ->paginate(10);
        }
        return view('Admin.KhachHang.index', compact('khachhangs'));
    }
    public function create()
    {
        return view('Admin.KhachHang.create');
    }
    public function store(Request $request)
    {
        DB::beginTransaction();

        $credentials = $request->validate([
            'HoTen' => 'required|string|max:255',
            'SDT' => 'required|string|regex:/^0\d{9}$/',
            'DiaChi' => 'required|string|max:255',
            'CCCD' => 'required|string|regex:/^\d{12}$/',
            'NgaySinh' => 'required|date',
            'GioiTinh' => 'required|string',
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

        $credentials['MaTaiKhoan'] = $request->createAccount ? TaiKhoan::create([
            'MaTaiKhoan' => $maTaiKhoan,
            'TenDangNhap' => $request->TenDangNhap,
            'MatKhau' => $request->MatKhau,
            'VaiTro' => 'Khách hàng',
            'TrangThai' => 1
        ])->MaTaiKhoan : null;

        do {
            $maKhachThue = 'KT' . str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);
        } while (KhachThue::where('MaKhachThue', $maKhachThue)->exists());

        $credentials['MaKhachThue'] = $maKhachThue;
        $khachThue = KhachThue::create($credentials);

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Thêm khách thuê thành công',
            'data' => $khachThue
        ], 200);
    }
    public function edit($maKhachThue)
    {
        $khachThue = KhachThue::find($maKhachThue);
        return response()->json($khachThue);
    }
    public function update(Request $request, $maKhachThue)
    {
        $credentials = $request->validate([
            'HoTen' => 'required|string|max:255',
            'SDT' => 'required|string|regex:/^0\d{9}$/',
            'DiaChi' => 'required|string|max:255',
            'CCCD' => 'required|string|regex:/^\d{12}$/',
            'NgaySinh' => 'required|date',
            'GioiTinh' => 'required|string',
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
        ]);

        $khachThue = KhachThue::find($maKhachThue);
        $khachThue->update($credentials);
        return response()->json(['success' => true, 'data' => $khachThue]);
    }
}

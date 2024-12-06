<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TaiKhoan;
use Illuminate\Http\Request;
use App\Models\PhanQuyen;

class AuthController extends Controller
{
    public function login()
    {
        if (session('admin_logged_in')) {
            return redirect()->route('admin.home');
        }
        return view('Admin.Auth.login');
    }
    public function store(Request $request)
    {
        $user = TaiKhoan::where('TenDangNhap', $request->username)
                        ->where('TrangThai', 1)
                        ->where('VaiTro', '!=', 'Khách hàng')
                        ->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'errors' => ['username' => 'Tài khoản không tồn tại']
            ], 422);
        }

        if ($user->MatKhau != $request->password) {
            return response()->json([
                'status' => false,
                'message' => 'Mật khẩu không chính xác',
                'errors' => ['password' => 'Mật khẩu không chính xác']
            ], 422);
        }

        session([
            'admin_logged_in' => true,
            'admin_id' => $user->MaTaiKhoan,
            'admin_name' => $user->TenDangNhap
        ]);

        $firstFacility = PhanQuyen::where('MaTaiKhoan', $user->MaTaiKhoan)->orderBy('MaCoSo', 'ASC')->first();

        if ($firstFacility) {
            session(['selected_facility' => $firstFacility->MaCoSo]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Đăng nhập thành công',
            'redirect' => route('admin.home')
        ]);
    }
    public function logout()
    {
        session()->flush();
        return redirect()->route('admin.auth.login');
    }
}

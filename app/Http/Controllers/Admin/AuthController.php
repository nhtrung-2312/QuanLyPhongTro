<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TaiKhoan;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    public function login() {
        return view('Admin.Auth.login');
    }
    public function store(LoginRequest $request)
    {
        $credentials = $request->validated();

        $user = TaiKhoan::where('TenDangNhap', $credentials['username'])
                        ->where('VaiTro', 'Admin')
                        ->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Tài khoản không tồn tại',
                'errors' => ['username' => 'Tài khoản không tồn tại']
            ], 422);
        }

        if ($user->MatKhau != $credentials['password']) {
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

        return response()->json([
            'status' => true,
            'message' => 'Đăng nhập thành công',
            'redirect' => route('admin.dashboard')
        ]);
    }
    public function logout() {
        session()->flush();
        return redirect()->route('admin.login');
    }
}

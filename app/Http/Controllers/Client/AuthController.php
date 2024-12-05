<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginRequest;
use App\Models\TaiKhoan;
use App\Models\KhachThue;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        $user = TaiKhoan::where('TenDangNhap', $credentials['phone'])->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Số điện thoại không tồn tại',
                'errors' => [
                    'phone' => 'Số điện thoại không tồn tại'
                ]
            ], 422);
        }

        if ($user->MatKhau != $credentials['password']) {
            return response()->json([
                'status' => false,
                'message' => 'Mật khẩu không chính xác',
                'errors' => [
                    'password' => 'Mật khẩu không chính xác'
                ]
            ], 422);
        }
        $customer = KhachThue::where('MaTaiKhoan', $user->MaTaiKhoan)->first();
        session([
            'logged_in' => true,
            'acc_id' => $user->MaTaiKhoan,
            'user_id' => $customer->MaKhachThue,
            'username' => $customer->HoTen,
            'role' => $user->VaiTro
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Đăng nhập thành công',
            'redirect' => route('home.index')
        ]);
    }
    public function register(RegisterRequest $request)
    {
        $credentials = $request->validated();

        if (TaiKhoan::where('TenDangNhap', $credentials['phone'])->exists()) {
            return response()->json([
                'status' => false,
                'errors' => [
                    'phone' => ['Số điện thoại đã được đăng ký']
                ]
            ], 422);
        }

        do {
            $maTaiKhoan = 'TK' . str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
        } while (TaiKhoan::where('MaTaiKhoan', $maTaiKhoan)->exists());

        $taiKhoan = new TaiKhoan();
        $taiKhoan->MaTaiKhoan = $maTaiKhoan;
        $taiKhoan->TenDangNhap = $credentials['phone'];
        $taiKhoan->MatKhau = $credentials['password'];
        $taiKhoan->VaiTro = 'Khách hàng';
        $taiKhoan->TrangThai = 1;
        $taiKhoan->save();

        do {
            $maKhachThue = 'KT' . str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
        } while (KhachThue::where('MaKhachThue', $maKhachThue)->exists());

        $khachThue = new KhachThue();
        $khachThue->MaKhachThue = $maKhachThue;
        $khachThue->SDT = $credentials['phone'];
        $khachThue->MaTaiKhoan = $maTaiKhoan;
        $khachThue->save();

        session([
            'logged_in' => true,
            'acc_id' => $taiKhoan->MaTaiKhoan,
            'user_id' => $khachThue->MaKhachThue,
            'username' => $khachThue->HoTen,
            'role' => $taiKhoan->VaiTro
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Đăng ký thành công',
            'redirect' => route('home.index')
        ]);
    }
    public function logout()
    {
        session()->flush();
        return redirect()->back();
    }
}

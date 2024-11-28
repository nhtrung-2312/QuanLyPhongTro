<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginRequest;
use App\Models\TaiKhoan;
use App\Models\KhachThue;
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
            'user_id' => $user->MaTaiKhoan,
            'username' => $customer->HoTen,
            'role' => $user->VaiTro
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Đăng nhập thành công',
            'redirect' => route('home.index')
        ]);
    }
    public function logout()
    {
        session()->flush();
        return redirect()->route('home.index');
    }
}

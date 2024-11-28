<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required|regex:/^[0-9]{10}$/',
            'password' => 'required'
        ]);

        if (Auth::attempt(['phone' => $request->phone, 'password' => $request->password])) {
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'phone' => 'Thông tin đăng nhập không chính xác.',
        ]);
    }
    // public function redirectToGoogle()
    // {
    //     return Socialite::driver('google')->redirect();
    // }

    // public function handleGoogleCallback()
    // {
    //     try {
    //         $user = Socialite::driver('google')->user();

    //         $findUser = User::where('google_id', $user->id)->first();

    //         if ($findUser) {
    //             Auth::login($findUser);
    //             return redirect('/');
    //         }

    //         $newUser = User::create([
    //             'name' => $user->name,
    //             'email' => $user->email,
    //             'google_id' => $user->id,
    //             'avatar' => $user->avatar,
    //             'password' => Hash::make(rand(100000,999999))
    //         ]);

    //         Auth::login($newUser);
    //         return redirect('/');

    //     } catch (\Exception $e) {
    //         return redirect('/login')->withErrors(['error' => 'Đã có lỗi xảy ra khi đăng nhập với Google']);
    //     }
    // }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}

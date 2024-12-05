<?php

namespace App\Http\Middleware;

use App\Models\PhanQuyen;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('logged_in')) {
            return redirect()->route('auth.login');
        }

        $hasAdminAccess = PhanQuyen::where('MaTaiKhoan', session('acc_id'))
            ->exists();

        if (!$hasAdminAccess) {
            return redirect()->route('home.index')->with('error', 'Bạn không có quyền truy cập trang quản trị');
        }

        return $next($request);
    }
}

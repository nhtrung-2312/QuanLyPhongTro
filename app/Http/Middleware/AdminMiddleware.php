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
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.auth.login');
        }

        $selectedCoSo = session('selected_facility');

        $hasAdminAccess = PhanQuyen::where('MaTaiKhoan', session('admin_id'))->exists();

        if (!$hasAdminAccess) {
            return redirect()->route('admin.auth.login');
        }

        return $next($request);
    }
}

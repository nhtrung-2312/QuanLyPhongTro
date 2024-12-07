<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\PhanQuyen;

class CheckPermissionMiddleware
{
    private $permissionMap = [
        'admin/thongke' => 'Q009',
        'admin/coso' => 'Q001',
        'admin/loaiphong' => 'Q004',
        'admin/rooms' => 'Q004',
        'admin/khachhang' => 'Q002',
        'admin/loaiphi' => 'Q005',
        'admin/hopdongthue' => 'Q008',
        'admin/hoadon' => 'Q007',
        'admin/nhanvien' => 'Q003'
    ];

    public function handle(Request $request, Closure $next)
    {
        $path = $request->path();
        $selectedCoSo = session('selected_facility');
        $requiredPermission = null;

        foreach ($this->permissionMap as $urlPattern => $permission) {
            if (str_starts_with($path, $urlPattern)) {
                $requiredPermission = $permission;
                break;
            }
        }

        if ($requiredPermission) {
            $hasPermission = PhanQuyen::where('MaTaiKhoan', session('admin_id'))
                ->where('MaCoSo', $selectedCoSo)
                ->where('MaQuyen', $requiredPermission)
                ->exists();

            if (!$hasPermission) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                    ], 403);
                }

                return redirect()->route('admin.home');
            }
        }

        return $next($request);
    }
}

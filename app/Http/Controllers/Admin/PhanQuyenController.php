<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quyen;
use App\Models\TaiKhoan;
use App\Models\PhanQuyen;
class PhanQuyenController extends Controller
{
    public function index()
    {
        $quyens = Quyen::all();
        return view('Admin.PhanQuyen.index', compact('quyens'));
    }

    public function create()
    {
        return view('Admin.PhanQuyen.create');
    }

    public function store(Request $request)
    {
        do {
            $maQuyen = 'Q' . str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);
        } while (Quyen::where('MaQuyen', $maQuyen)->exists());

        $request['MaQuyen'] = $maQuyen;

        $existingQuyen = Quyen::where('TenQuyen', $request->TenQuyen)->first();

        if ($existingQuyen) {
            return response()->json([
                'success' => false,
                'message' => 'Tên quyền đã tồn tại',
            ]);
        }
        Quyen::create($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Thêm quyền thành công',
        ]);
    }

    public function update(Request $request)
    {
        $quyen = Quyen::find($request->MaQuyen);
        $quyen->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật quyền thành công',
        ]);
    }
    public function delete(Request $request)
    {
        try {
            Quyen::find($request->maQuyen)->delete();
            return response()->json([
                'success' => true,
                'message' => 'Xóa quyền thành công',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xoá quyền, kiểm tra lại!',
            ]);
        }
    }
    public function capquyen()
    {
        $taiKhoans = TaiKhoan::with(['phanQuyen' => function($query) {
            $query->where('MaCoSo', session('selected_facility'));
        }])->get();

        return view('Admin.PhanQuyen.capquyen', compact('taiKhoans'));
    }
    public function chitietquyen($maTaiKhoan)
    {
        $taiKhoan = TaiKhoan::find($maTaiKhoan);
        $quyens = Quyen::all();
        return view('Admin.PhanQuyen.chitietquyen', compact('taiKhoan', 'quyens'));
    }
    public function updateQuyen(Request $request)
    {
        try {
            PhanQuyen::where('MaTaiKhoan', $request->MaTaiKhoan)
                     ->where('MaCoSo', $request->MaCoSo)
                     ->delete();

            if ($request->has('quyens')) {
                foreach ($request->quyens as $maQuyen) {
                    PhanQuyen::create([
                        'MaTaiKhoan' => $request->MaTaiKhoan,
                        'MaQuyen' => $maQuyen,
                        'MaCoSo' => $request->MaCoSo
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật quyền thành công'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật quyền',
                'data' => $e->getMessage()
            ]);
        }
    }
    public function createaccount()
    {
        return view('Admin.PhanQuyen.createaccount');
    }
    public function storeaccount(Request $request)
    {
        $request->validate([
            'TenDangNhap' => 'required|unique:taikhoan,TenDangNhap',
            'MatKhau' => 'required',
            'VaiTro' => 'required'
        ], [
            'TenDangNhap.required' => 'Tên đăng nhập không được để trống',
            'TenDangNhap.unique' => 'Tên đăng nhập đã tồn tại',
            'MatKhau.required' => 'Mật khẩu không được để trống',
            'VaiTro.required' => 'Vai trò không được để trống'
        ]);

        do {
            $maTaiKhoan = 'TK' . str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);
        } while (TaiKhoan::where('MaTaiKhoan', $maTaiKhoan)->exists());

        $taiKhoan = new TaiKhoan();
        $taiKhoan->MaTaiKhoan = $maTaiKhoan;
        $taiKhoan->TenDangNhap = $request->TenDangNhap;
        $taiKhoan->MatKhau = $request->MatKhau;
        $taiKhoan->VaiTro = $request->VaiTro;
        $taiKhoan->TrangThai = 1;
        $taiKhoan->save();
        return response()->json([
            'success' => true,
            'data' => $request->all()
        ]);
    }
    public function deleteaccount($id)
    {
        try {
            TaiKhoan::find($id)->delete();
            return response()->json([
                'success' => true,
                'message' => 'Xóa tài khoản thành công'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xoá tài khoản, kiểm tra lại!'
            ]);
        }
    }
}

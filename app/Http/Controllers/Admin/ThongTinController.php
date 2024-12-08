<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NhanVien;
use App\Models\TaiKhoan;
class ThongTinController extends Controller
{
    public function index()
    {
        $nhanvien = NhanVien::where('MaTaiKhoan', session('admin_id'))->first();
        return view('admin.thongtin.index', compact('nhanvien'));
    }
    public function account()
    {
        $taikhoan = TaiKhoan::where('MaTaiKhoan', session('admin_id'))->first();
        return view('admin.thongtin.account', compact('taikhoan'));
    }
    public function backup()
    {
        $permissions = \App\Models\PhanQuyen::where('MaTaiKhoan', session('admin_id'))
            ->where('MaCoSo', session('selected_facility'))
            ->pluck('MaQuyen')
            ->toArray();
        if(in_array("Q010", $permissions)){
            return view('admin.thongtin.backup');
        }
        return redirect()->route('admin.thongtin.index')->with('error', 'Bạn không có quyền truy cập trang này');
    }
    public function update(Request $request)
    {
        dd($request->all());
    }
}

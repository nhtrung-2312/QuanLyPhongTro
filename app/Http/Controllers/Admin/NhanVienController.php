<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\NhanVien;

class NhanVienController extends Controller
{
    public function index()
    {
        $nhanviens = NhanVien::paginate(10);
        return view("admin.nhanvien.index", compact("nhanviens"));
    }
}

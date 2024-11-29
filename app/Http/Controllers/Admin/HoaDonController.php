<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HoaDon;
use App\Models\PhongTro;
class HoaDonController extends Controller
{
    public function index()
    {
        $hoadons = HoaDon::with(['hopdongthue.phong.coSo'])->paginate(5);
        return view('Admin.HoaDon.index', compact('hoadons'));
    }
}

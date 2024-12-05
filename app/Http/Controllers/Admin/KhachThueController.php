<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KhachThue;
use App\Models\TaiKhoan;
use App\Http\Requests\KhachThueRequest;
use Illuminate\Support\Facades\Log;

class KhachThueController extends Controller
{
    public function index(Request $request)                
    {
        $khachhangs = KhachThue::with(['TaiKhoan'])->paginate(5);
        return view('Admin.KhachHang.index', compact('khachhangs'));
    }
}

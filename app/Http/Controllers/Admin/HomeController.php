<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class HomeController extends Controller
{
    public function index()
    {
        return view('Admin.Home.index');
    }

    public function checkPermissions(Request $request)
    {
        $maCoSo = $request->maCoSo;
        session(['selected_facility' => $maCoSo]);
        return response()->json(['success' => true]);
    }
    public function thongtin()
    {
        return view('Admin.Home.thongtin');
    }
}

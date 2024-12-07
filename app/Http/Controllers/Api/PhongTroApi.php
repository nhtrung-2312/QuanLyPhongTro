<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PhongTro;
use Illuminate\Http\Request;

class PhongTroApi extends Controller
{
    public function getPhong(Request $request) {
        $phong = PhongTro::with('loaiphong')->where('MaPhong', $request->id)->first();
        return response(['success' => 'true', 'data' => $phong]);
    }
    public function getPhongByKhach(Request $request)
    {
        $phong = PhongTro::whereHas('hopdongthue.khachthue', function($query) use ($request) {
            $query->where('MaKhachThue', $request->id);
        })->with('loaiphong')->first();

        if ($phong) {
            return response()->json(['success' => true, 'data' => $phong], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy phòng'], 404);
        }
    }
}

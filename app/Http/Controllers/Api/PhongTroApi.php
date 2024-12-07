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
    public function getPhongDaThue(Request $request) {
        $phong = PhongTro::with('hopdongthue.chitiethopdong.khachthue')->whereHas('hopdongthue.chitiethopdong', function($query) use ($request) {
            $query->whereHas('khachthue', function($subQuery) use ($request) {
                $subQuery->where('MaKhachThue', $request->maKhachThue);
            });
        })->get();
        return response(['success' => 'true', 'data' => $phong]);
    }
}

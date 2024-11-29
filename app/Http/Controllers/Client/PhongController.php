<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoaiPhong;
use App\Models\PhongTro;
use App\Models\LoaiPhi;
use App\Jobs\UpdatePhongStatus;
use App\Models\HopDongThue;

class PhongController extends Controller
{
    public function index()
    {
        $loaiphong = LoaiPhong::all();
        return view('Client.Phong.index', compact('loaiphong'));
    }
    public function show($id)
    {

        $phong = PhongTro::with('coSo')->where('MaLoaiPhong', $id)->where('TrangThai', 'Phòng trống')->paginate(6);
        $loaiphong = LoaiPhong::find($id);

        return view('Client.Phong.show', compact('phong', 'loaiphong'));
    }
    public function details($id)
    {
        $phong = PhongTro::with('coSo', 'chiTietPhong', 'loaiPhong')->find($id);
        $loaiphi = LoaiPhi::all();
        return view('Client.Phong.details', compact('phong', 'loaiphi'));
    }
    public function book(Request $request)
    {
        try {
            $phong = PhongTro::find($request->maPhong);

            if ($phong->TrangThai != 'Phòng trống') {
                return response()->json([
                    'success' => false,
                    'message' => 'Phòng đã được đặt.'
                ]);
            }
            // $phong->update(['TrangThai' => 'Đang xử lý']);

            // UpdatePhongStatus::dispatch($phong->MaPhong)->delay(now()->addMinutes(10));

            do {
                $maHopDong = 'HDT' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
            } while (HopDongThue::where('MaHopDong', $maHopDong)->exists());

            $paymentUrl = route('phong.payment', ['id' => $phong->MaPhong, 'maHopDong' => $maHopDong]);

            return response()->json([
                'success' => true,
                'redirectUrl' => $paymentUrl
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại sau'
            ]);
        }
    }
    public function payment($id)
    {
        $phong = PhongTro::find($id);
        return view('Client.Phong.payment', compact('phong'));
    }
}

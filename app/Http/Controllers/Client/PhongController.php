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
            $maPhong = $request->input('maPhong');


            $phong = PhongTro::find($maPhong);
            if (!$phong) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy thông tin phòng'
                ]);
            }

            if ($phong->TrangThai != 'Phòng trống') {
                return response()->json([
                    'success' => false,
                    'message' => 'Phòng đã được đặt'
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Đặt phòng thành công',
                'redirectUrl' => route('thanhToan.datphong', ['id' => $maPhong])
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ]);
        }
    }
}

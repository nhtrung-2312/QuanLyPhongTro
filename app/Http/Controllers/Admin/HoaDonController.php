<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HoaDon;
use App\Models\PhongTro;
use App\Models\CoSo;
use App\Models\LoaiPhi;
use Illuminate\Support\Facades\DB;

class HoaDonController extends Controller
{
    public function index()
    {
        $hoadons = HoaDon::with([
            'hopdongthue.phong.coSo'
        ])->orderBy('NgayLap', 'desc')
            ->paginate(5);

        return view('Admin.HoaDon.index', compact('hoadons'));
    }
    public function details($MaHoaDon)
    {
        $chitiethoadons = \App\Models\ChiTietHoaDon::where('MaHoaDon', $MaHoaDon)->get();
        return view('Admin.HoaDon.details', compact('chitiethoadons'));
    }
    public function getStatus($maHoaDon)
    {
        try {
            $hoaDon = HoaDon::find($maHoaDon);
            if (!$hoaDon) {
                return response()->json([
                    'status' => false,
                    'message' => 'Không tìm thấy hóa đơn!'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'data' => [
                    'MaHoaDon' => $hoaDon->MaHoaDon,
                    'TrangThai' => $hoaDon->TrangThai
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function update(Request $request)
    {
        try {
            $hoaDon = HoaDon::with(['chiTietHoaDon', 'hopdongthue.phong'])->find($request->MaHoaDon);
            if (!$hoaDon) {
                return response()->json([
                    'status' => false,
                    'message' => 'Không tìm thấy hóa đơn!'
                ], 404);
            }

            // Cập nhật trạng thái
            $hoaDon->TrangThai = $request->TrangThai;
            
            // Cập nhật lại tổng tiền
            $tienPhong = $hoaDon->hopdongthue->phong->GiaThue;
            $tongTienDichVu = $hoaDon->chiTietHoaDon->sum('ThanhTien');
            $hoaDon->TongTien = $tienPhong + $tongTienDichVu;
            
            $hoaDon->save();

            return response()->json([
                'status' => true,
                'message' => 'Cập nhật thành công!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    public function create()
    {
        try {
            // Lấy danh sách cơ sở
            $cosos = DB::table('coso')->get();
            \Log::info('Danh sách cơ sở:', ['cosos' => $cosos]);

            // Lấy danh sách phòng đang thuê
            $phongs = DB::table('phongtro as p')
                ->join('hopdongthue as h', function($join) {
                    $join->on('p.MaPhong', '=', 'h.MaPhong')
                         ->where('h.TrangThai', '=', 'Đang thuê');
                })
                ->join('khachhang as k', 'h.MaKhachHang', '=', 'k.MaKhachHang')
                ->select(
                    'p.MaPhong',
                    'p.TenPhong',
                    'p.MaCoSo',
                    'k.HoTen as TenKhachHang'
                )
                ->get();
            \Log::info('Danh sách phòng:', ['phongs' => $phongs]);
            
            // Lấy danh sách loại phí
            $loaiphis = DB::table('loaiphi')->get();
            \Log::info('Danh sách loại phí:', ['loaiphis' => $loaiphis]);

            // Truyền tất cả biến vào view
            return view('Admin.HoaDon.create', compact('cosos', 'phongs', 'loaiphis'));
            
        } catch (\Exception $e) {
            \Log::error('Lỗi trong phương thức create: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi tải trang tạo hóa đơn');
        }
    }

    public function store(Request $request)
    {
        try {
            // Log dữ liệu gửi lên
            \Log::info('Dữ liệu gửi lên:', $request->all());

            DB::beginTransaction();

            // Lấy mã hợp đồng
            $hopdong = DB::table('hopdongthue')
                ->where('MaPhong', $request->MaPhong)
                ->where('TrangThai', 'Đang thuê')
                ->first();

            \Log::info('Thông tin hợp đồng:', ['hopdong' => $hopdong]);

            if (!$hopdong) {
                throw new \Exception('Không tìm thấy hợp đồng thuê cho phòng này');
            }

            // Tạo mã hóa đơn mới
            $maHoaDon = 'HD' . time();

            // Insert hóa đơn
            $hoadon = DB::table('hoadon')->insert([
                'MaHoaDon' => $maHoaDon,
                'MaHopDong' => $hopdong->MaHopDong,
                'NgayLap' => $request->NgayLap,
                'TongTien' => $request->TongTien,
                'TrangThai' => $request->TrangThai
            ]);

            \Log::info('Đã tạo hóa đơn:', ['MaHoaDon' => $maHoaDon]);

            // Insert chi tiết hóa đơn
            foreach ($request->chitiet as $chitiet) {
                if (!empty($chitiet['MaLoaiPhi'])) {
                    DB::table('chitiethoadon')->insert([
                        'MaHoaDon' => $maHoaDon,
                        'MaLoaiPhi' => $chitiet['MaLoaiPhi'],
                        'SoLuong' => $chitiet['SoLuong'],
                        'DonGia' => $chitiet['DonGia'],
                        'ThanhTien' => $chitiet['ThanhTien']
                    ]);
                }
            }

            \Log::info('Đã tạo chi tiết hóa đơn');

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Tạo hóa đơn thành công'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Lỗi tạo hóa đơn: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getPhongByCoSo($maCoSo)
    {
        try {
            $phongs = DB::table('phongtro as p')
                ->join('hopdongthue as h', function($join) {
                    $join->on('p.MaPhong', '=', 'h.MaPhong')
                         ->where('h.TrangThai', '=', 'Đang thuê');
                })
                ->join('khachhang as k', 'h.MaKhachHang', '=', 'k.MaKhachHang')
                ->where('p.MaCoSo', '=', $maCoSo)
                ->select(
                    'p.MaPhong',
                    'p.TenPhong',
                    'k.HoTen as TenKhachHang',
                    'h.MaHopDong'
                )
                ->get();

            \Log::info('Danh sách phòng theo cơ sở:', [
                'MaCoSo' => $maCoSo,
                'phongs' => $phongs
            ]);

            return response()->json($phongs);
        } catch (\Exception $e) {
            \Log::error('Lỗi lấy danh sách phòng: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

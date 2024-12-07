<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HoaDon;
use App\Models\PhongTro;
use App\Models\KhachThue;
use App\Models\LoaiPhi;
use App\Models\HopDongThue;
use App\Models\ChiTietHoaDon;
use App\Models\ChiTietHopDong;
use App\Jobs\UpdatePhongStatus;
use Illuminate\Support\Facades\DB;
use App\Services\ThanhToanService;
use App\Models\ChiSoDienNuoc;
use Illuminate\Support\Facades\Log;
class ThanhToanController extends Controller
{
    protected $thanhToanService;
    public function __construct(ThanhToanService $thanhToanService)
    {
        $this->thanhToanService = $thanhToanService;
    }

    public function datphong($id)
    {
        try {
            $phong = PhongTro::with(['loaiPhong', 'coSo'])->find($id);
            $khachthue = KhachThue::find(session('user_id'));

            if (!$phong || $phong->TrangThai !== 'Phòng trống') {
                return redirect()->route('phong.index')
                    ->with('error', 'Phòng không khả dụng');
            }

            if (!$khachthue) {
                return redirect()->route('phong.index')
                    ->with('error', 'Vui lòng đăng nhập để đặt phòng');
            }


            return view('Client.ThanhToan.datphong', compact('phong', 'khachthue'));

        } catch (\Exception $e) {
            return redirect()->route('phong.index')
                ->with('error', 'Có lỗi xảy ra, vui lòng thử lại');
        }
    }

    public function bill(Request $request, $id)
    {
        dd($request->all());
    }
    public function thanhToanMomo(Request $request)
    {
        try{
            DB::beginTransaction();

            // Check room status first
            $phong = PhongTro::find($request->ma_phong);
            
            if (!$phong) {
                throw new \Exception('Phòng không tồn tại');
            }

            // Check existing active contract
            $existingContract = HopDongThue::where('MaPhong', $request->ma_phong)
                ->where('TrangThai', 'Chờ thanh toán cọc')
                ->first();

            if ($existingContract) {
                if ($existingContract->TrangThai === 'Chờ thanh toán cọc') {
                    $paymentData = [
                        'orderId' => $existingContract->MaHopDong,
                        'roomId' => $request->ma_phong,
                        'amount' => $request->tien_coc
                    ];
    
                    $momoPayment = $this->thanhToanService->processCheckout($paymentData);
                    DB::commit();
                    return redirect($momoPayment['payUrl']);
                } else {
                    throw new \Exception('Phòng đã được thuê và thanh toán');
                }    
            }
            $selectedServices = json_decode($request->input('selected_services'), true);
            $selectedServices = $selectedServices ?? [];
            do{
                $mahdt = 'HDT' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
                $hopdongthue = HopDongThue::where('MaHopDong', $mahdt)->first();        
            }while($hopdongthue);

            do{
                $mahd = 'HD' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
                $hoadon = HoaDon::where('MaHoaDon', $mahd)->first();    
            }while($hoadon);

            do{
                $macs = 'CS' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
                $chisodn = ChiSoDienNuoc::where('MaChiSo', $macs)->first(); 
            }while($chisodn);

            $loaiphi = LoaiPhi::all();

            $phong->TrangThai = 'Đang thuê';
            $phong->save();


            $hopdongthue = new HopDongThue();
            $hopdongthue->MaHopDong = $mahdt;
            $hopdongthue->MaPhong = $request->ma_phong; 
            $hopdongthue->NgayBatDau = $request->ngay_bat_dau;  
            $hopdongthue->NgayKetThuc = $request->ngay_ket_thuc;
            $hopdongthue->TienCoc = $request->tien_coc;
            $hopdongthue->TrangThai = 'Chờ thanh toán cọc';
            $hopdongthue->save();

            $chitiethopdong = new ChiTietHopDong(); 
            $chitiethopdong->MaHopDong = $mahdt;
            $chitiethopdong->MaKhachThue = session('user_id');
            $chitiethopdong->save();

            $chisodn = new ChiSoDienNuoc();
            $chisodn->MaChiSo = $macs;
            $chisodn->MaPhong = $request->ma_phong;
            $chisodn->DienCu = 0;
            $chisodn->DienMoi = 0;
            $chisodn->NuocCu = 0;
            $chisodn->NuocMoi = 0;
            $chisodn->NgayGhi = now(); 
            $chisodn->save();

            $hoadon = new HoaDon();
            $hoadon->MaHoaDon = $mahd;
            $hoadon->MaHopDong = $mahdt;
            $hoadon->MaChiSo = $macs;
            $hoadon->NgayLap = now();
            $hoadon->TongTien = $request->tong_tien - $request->tien_coc;
            $hoadon->TrangThai = 'Chưa thanh toán';
            $hoadon->save();

            foreach($loaiphi as $lp) {
                $chiTietHD = new ChiTietHoaDon();
                $chiTietHD->MaHoaDon = $mahd;
                $chiTietHD->MaLoaiPhi = $lp->MaLoaiPhi;
                $chiTietHD->GhiChu = null;
                switch($lp->MaLoaiPhi) {
                    case 'PHI001':
                        $chiTietHD->SoLuong = $chisodn->DienMoi - $chisodn->DienCu;
                        $chiTietHD->ThanhTien = $lp->DonGia * $chiTietHD->SoLuong;
                        break;
                    case 'PHI002':
                        $chiTietHD->SoLuong = $chisodn->NuocMoi - $chisodn->NuocCu;
                        $chiTietHD->ThanhTien = $lp->DonGia * $chiTietHD->SoLuong;
                        break;
                    default:
                        $found = false;
                        foreach($selectedServices as $service) {
                            if($service['id'] == $lp->MaLoaiPhi) {
                                $chiTietHD->SoLuong = $service['quantity'] ?? 1;
                                $chiTietHD->ThanhTien = $service['price'];
                                $found = true;
                                break;
                            }
                        }
                        if(!$found) {
                            $chiTietHD->SoLuong = 0;
                            $chiTietHD->ThanhTien = 0;
                        }
                        break;
                }
                $chiTietHD->save();
            }   
            $paymentData = [
                'orderId' => $mahd,
                'roomId' => $request->ma_phong,
                'amount' => $request->tien_coc
            ];

            $momoPayment = $this->thanhToanService->processCheckout($paymentData);

            DB::commit();

            return redirect($momoPayment['payUrl']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại');
        }
    }
    public function momoCallback(Request $request)
    {
        try {
            Log::info('Momo callback received in controller:', $request->all());
            
            $result = $this->thanhToanService->handleMomoCallback($request->all());
            
            if ($result['success']) {
                return redirect($result['redirectUrl'])
                    ->with('success', 'Thanh toán thành công');
            }
            
            return redirect($result['redirectUrl'])
                ->with('error', 'Thanh toán thất bại');
                
        } catch (\Exception $e) {
            Log::error('Momo callback error in controller: ' . $e->getMessage());
            return redirect()->route('phong.index')
                ->with('error', 'Có lỗi xảy ra trong quá trình thanh toán');
        }
    }

    public function thanhToanBank(Request $request)
    {
        dd($request->all());
    }
    public function thanhToanCash(Request $request)
    {
        try {
            $selectedServices = json_decode($request->input('selected_services'), true);
            do{
                $mahdt = 'HDT' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
                $hopdongthue = HopDongThue::where('MaHopDong', $mahdt)->first();
            }while($hopdongthue);

            do{
                $mahd = 'HD' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
                $hoadon = HoaDon::where('MaHoaDon', $mahd)->first();
            }while($hoadon);

            do{
                $macs = 'CS' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
                $chisodn = ChiSoDienNuoc::where('MaChiSo', $macs)->first();
            }while($chisodn);

            $loaiphi = LoaiPhi::all();

            DB::beginTransaction();

            $phong = PhongTro::find($request->ma_phong);
            $phong->TrangThai = 'Đang thuê';
            $phong->save();

            $hopdongthue = new HopDongThue();
            $hopdongthue->MaHopDong = $mahdt;
            $hopdongthue->MaPhong = $request->ma_phong;
            $hopdongthue->NgayBatDau = $request->ngay_bat_dau;
            $hopdongthue->NgayKetThuc = $request->ngay_ket_thuc;
            $hopdongthue->TienCoc = $request->tien_coc;
            $hopdongthue->TrangThai = 'Chờ thanh toán cọc';
            $hopdongthue->save();

            $chitiethopdong = new ChiTietHopDong();
            $chitiethopdong->MaHopDong = $mahdt;
            $chitiethopdong->MaKhachThue = session('user_id');
            $chitiethopdong->save();

            $chisodn = new ChiSoDienNuoc();
            $chisodn->MaChiSo = $macs;
            $chisodn->MaPhong = $request->ma_phong;
            $chisodn->DienCu = 0;
            $chisodn->DienMoi = 0;
            $chisodn->NuocCu = 0;
            $chisodn->NuocMoi = 0;
            $chisodn->NgayGhi = now();
            $chisodn->save();

            $hoadon = new HoaDon();
            $hoadon->MaHoaDon = $mahd;
            $hoadon->MaHopDong = $mahdt;
            $hoadon->MaChiSo = $macs;
            $hoadon->NgayLap = now();
            $hoadon->TongTien = $request->tong_tien - $request->tien_coc;
            $hoadon->TrangThai = 'Chưa thanh toán';
            $hoadon->save();

            foreach($loaiphi as $lp) {
                $chiTietHD = new ChiTietHoaDon();
                $chiTietHD->MaHoaDon = $mahd;
                $chiTietHD->MaLoaiPhi = $lp->MaLoaiPhi;
                $chiTietHD->GhiChu = null;
                switch($lp->MaLoaiPhi) {
                    case 'PHI001':
                        $chiTietHD->SoLuong = $chisodn->DienMoi - $chisodn->DienCu;
                        $chiTietHD->ThanhTien = $lp->DonGia * $chiTietHD->SoLuong;
                        break;
                    case 'PHI002':
                        $chiTietHD->SoLuong = $chisodn->NuocMoi - $chisodn->NuocCu;
                        $chiTietHD->ThanhTien = $lp->DonGia * $chiTietHD->SoLuong;
                        break;
                    default:
                        $found = false;
                        foreach($selectedServices as $service) {
                            if($service['id'] == $lp->MaLoaiPhi) {
                                $chiTietHD->SoLuong = $service['quantity'] ?? 1;
                                $chiTietHD->ThanhTien = $service['price'];
                                $found = true;
                                break;
                            }
                        }
                        if(!$found) {
                            $chiTietHD->SoLuong = 0;
                            $chiTietHD->ThanhTien = 0;
                        }
                        break;
                }
                $chiTietHD->save();
            }

            DB::commit();

            return redirect()->route('phong.index')->with('success', 'Đặt phòng thành công');

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại'
            ]);
        }
    }
}

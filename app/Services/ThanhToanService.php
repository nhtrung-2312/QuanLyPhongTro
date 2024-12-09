<?php
namespace App\Services;

use MongoDB\Client;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\ThanhToanMomoService;

class ThanhToanService
{
    protected $momoPaymentService;

    public function __construct(ThanhToanMomoService $momoPaymentService)
    {
        $this->momoPaymentService = $momoPaymentService;
    }

    public function processCheckout($data)
    {
        try {
            $paymentData = [
                'orderId' => $data['orderId'],
                'roomId' => $data['roomId'],
                'amount' => $data['amount'],
                'type' => $data['type'],
                'fees' => $data['fees'] ?? []
            ];

            $momoPayment = $this->momoPaymentService->createPayment($paymentData);

            return [
                'payUrl' => $momoPayment['payUrl'],
                'orderId' => $data['orderId']
            ];
        } catch (\Exception $e) {
            Log::error('Payment processing error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function handleMomoCallback($data)
    {
        try {
            if (!isset($data['orderId']) || !isset($data['resultCode'])) {
                throw new \Exception('Invalid callback data');
            }

            $orderId = explode('_', $data['orderId'])[0] ?? $data['orderId'];
            $success = $data['resultCode'] == 0;
            $extraData = json_decode($data['extraData'], true);
            $type = $extraData['type'] ?? 'deposit';
            $roomId = $extraData['room_id'] ?? null;

            Log::info('Processing Momo callback:', [
                'orderId' => $orderId,
                'success' => $success,
                'extraData' => $extraData
            ]);

            DB::beginTransaction();
            if($type === 'invoice'){
                $hoadon = \App\Models\HoaDon::find($orderId);
                if (!$hoadon) {
                    throw new \Exception("Không tìm thấy hóa đơn: {$orderId}");
                }

                $hopdongthue = \App\Models\HopDongThue::find($hoadon->MaHopDong);
                if (!$hopdongthue) {
                    throw new \Exception("Không tìm thấy hợp đồng cho hóa đơn: {$orderId}");
                }

                $hoadon->TrangThai = $success ? 'Đã thanh toán' : 'Chưa thanh toán';
                $hoadon->save();

               $fees = $extraData['fees'] ?? [];
               foreach ($fees as $fee) {
                    $chiTietHD = new \App\Models\ChiTietHoaDon();
                    $chiTietHD->MaHoaDon = $hoadon->MaHoaDon;
                    $chiTietHD->MaLoaiPhi = $fee['MaLoaiPhi'];
                    $chiTietHD->SoLuong = $fee['SoLuong'];
                    $chiTietHD->ThanhTien = $fee['ThanhTien'];
                    $chiTietHD->GhiChu = 'Chi tiết hóa đơn';
                    $chiTietHD->save();
               }
            }else{
                $hopdongthue = \App\Models\HopDongThue::where('MaHopDong', $orderId)->first();
                Log::info('Hop dong thue:', [
                    'hopdongthue' => $hopdongthue
                ]);
                if (!$hopdongthue) {
                    throw new \Exception("Không tìm thấy hợp đồng: {$orderId}");
                }
                if ($success) {
                    $hopdongthue->TrangThai = 'Còn hiệu lực';
                    $phong = \App\Models\PhongTro::find($roomId);
                    if ($phong) {
                        $phong->TrangThai = 'Đang thuê';
                        $phong->save();
                    }
                } else {
                    $hopdongthue->TrangThai = 'Chờ thanh toán cọc';
                }
                $hopdongthue->save();

                $hoadon = \App\Models\HoaDon::where('MaHopDong', $hopdongthue->MaHopDong)->first();
                if (!$hoadon) {
                    throw new \Exception("Không tìm thấy hóa đơn cho hợp đồng: {$hopdongthue->MaHopDong}");
                }
            }
            $matt = 'TT' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
            $thanhtoan = new \App\Models\ThanhToan([
                'MaThanhToan' => $matt,
                'MaHoaDon' => $hoadon->MaHoaDon,
                'NgayThanhToan' => now(),
                'SoTien' => $data['amount'],
                'PhuongThucThanhToan' => 'MOMO',
                'GhiChu' => $type === 'invoice' ? 'Thanh toán hóa đơn' : 'Thanh toán tiền cọc'
            ]);
            $thanhtoan->save();
            DB::commit();
            return [
                'success' => $success,
                'redirectUrl' => route('thongtin.phong')
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Momo callback error: ' . $e->getMessage(), [
                'orderId' => $orderId ?? null,
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
}

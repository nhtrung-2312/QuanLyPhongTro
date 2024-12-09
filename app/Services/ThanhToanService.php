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
                'room_id' => $data['roomId'],
                'amount' => $data['amount']
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
            $room_id = $data['extraData'] ?? null;

            DB::beginTransaction();

            $hopdongthue = \App\Models\HopDongThue::where('MaHopDong', $orderId)->first();
            if ($success) {
                $hopdongthue->TrangThai = 'Còn hiệu lực';
                $phong = \App\Models\PhongTro::find($hopdongthue->MaPhong);
                if ($phong) {
                    $phong->TrangThai = 'Đang thuê';
                    $phong->save();
                }
            } else {
                $hopdongthue->TrangThai = 'Chờ thanh toán cọc';
            }
            $hopdongthue->save();


            DB::commit();
            return [
                'success' => $success,
                'redirectUrl' => route('thongtin.phong')
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Momo callback error: ' . $e->getMessage());
            throw $e;
        }
    }
}

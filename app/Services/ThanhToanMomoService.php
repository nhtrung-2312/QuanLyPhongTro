<?php

namespace App\Services;
use Illuminate\Support\Facades\Log;

class ThanhToanMomoService
{
    protected $endpoint;
    protected $partnerCode;
    protected $accessKey;
    protected $secretKey;
    protected $redirectUrl;
    protected $ipnUrl;

    public function __construct()
    {
        $this->endpoint = config('services.momo.endpoint');
        $this->partnerCode = config('services.momo.partner_code');
        $this->accessKey = config('services.momo.access_key');
        $this->secretKey = config('services.momo.secret_key');
        $this->redirectUrl = route('thanhToan.momoCallback');
        $this->ipnUrl = config('services.momo.ipn_url');

        Log::info('MoMo environment variables:', [
            'endpoint' => $this->endpoint,
            'partnerCode' => $this->partnerCode,
            'accessKey' => $this->accessKey,
            'secretKey' => $this->secretKey,
            'redirectUrl' => $this->redirectUrl,
            'ipnUrl' => $this->ipnUrl,
        ]);
    }   
    public function createPayment($data)
    {
        try{
            $requestId = time() . rand(100, 999);
            $originalId = $data['orderId'];
            $orderId = $originalId . '_' . time();
            $amount = (int)$data['amount'];

            $extraData = json_encode([
                'room_id' => $data['roomId'],
                'orderId' => $originalId,
                'type' => $data['type'] ?? 'deposit',
                'fees' => $data['fees'] ?? []
            ]);

            $orderInfo = "Thanh toán đơn hàng #" . $orderId;
            $rawHash = "accessKey=" . $this->accessKey .
                "&amount=" . $amount .
                "&extraData=" . $extraData .
                "&ipnUrl=" . $this->ipnUrl .
                "&orderId=" . $orderId .
                "&orderInfo=" . $orderInfo .
                "&partnerCode=" . $this->partnerCode .
                "&redirectUrl=" . $this->redirectUrl .
                "&requestId=" . $requestId .
                "&requestType=captureWallet";

            $signature = hash_hmac('sha256', $rawHash, $this->secretKey);

            $requestData = [
                'partnerCode' => $this->partnerCode,
                'accessKey' => $this->accessKey,
                'requestId' => $requestId,
                'amount' => $amount,
                'orderId' => $orderId,
                'orderInfo' => $orderInfo,
                'redirectUrl' => $this->redirectUrl,
                'ipnUrl' => $this->ipnUrl,
                'requestType' => 'captureWallet',
                'extraData' => $extraData,
                'signature' => $signature,
                'lang' => 'vi'
            ];

            Log::info('MoMo payment request:', ['data' => $requestData]);

            $result = $this->execPostRequest($this->endpoint, json_encode($requestData));
            $response = json_decode($result, true);

            Log::info('MoMo payment response:', ['response' => $response]);

            if (!isset($response['payUrl'])) {
                throw new \Exception('PaymentUrl không tồn tại trong kết quả thanh toán');
            }
            return $response;
        } catch (\Exception $e) {
            Log::error('MoMo payment error: ' . $e->getMessage());
            throw $e;
        }
    }

    protected function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)  
        ]);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}
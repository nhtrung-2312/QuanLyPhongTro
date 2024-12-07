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
            $orderId = $data['orderId'] . '_' . time();
            $amount = (int)$data['amount'];
            $room_id = $data['room_id'];
            $orderInfo = "Thanh toán đơn hàng #" . $orderId;
            $failureUrl = url('/thanh-toan/dat-phong/' . $room_id);
            $rawHash = "accessKey=" . $this->accessKey .
                "&amount=" . $amount .
                "&extraData=" . $room_id .
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
                'extraData' => $room_id,
                'signature' => $signature,
                'lang' => 'vi'
            ];

            Log::info('MoMo payment request:', ['data' => $requestData]);

            $result = $this->execPostRequest($this->endpoint, json_encode($requestData));
            $response = json_decode($result, true);

            Log::info('MoMo payment response:', ['response' => $response]);

            if (!isset($response['payUrl'])) {
                Log::error('Missing payUrl in MoMo response', ['response' => $response]);
                return [
                    'success' => false,
                    'redirectUrl' => $failureUrl
                ];
            }
            return [
                'success' => true,
                'payUrl' => $response['payUrl']
            ];
        } catch (\Exception $e) {
            Log::error('MoMo payment error: ' . $e->getMessage());
            return [
                'success' => false,
                'redirectUrl' => $failureUrl
            ];
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
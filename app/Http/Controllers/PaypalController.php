<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class PaypalController extends Controller
{
      private function paypalConfig()
    {
        return config('paypal.' . config('paypal.mode'));
    }

    private function getAccessToken()
    {
        $config = $this->paypalConfig();

        $response = Http::withBasicAuth(
            $config['client_id'],
            $config['secret']
        )->asForm()->post($config['base_url'] . '/v1/oauth2/token', [
            'grant_type' => 'client_credentials'
        ]);

        return $response->json()['access_token'];
    }

    public function index()
    {
        return view('paypal');
    }

    public function createOrder(Request $request)
    {
        $token  = $this->getAccessToken();
        $config = $this->paypalConfig();

        // if($token){
        //     return response()->json(['error'=>'Token not generated'],500);
        // }

        $amount = 10.00; // 👉 yahan dynamic cart total bhi bhej sakte ho

        $response = Http::withToken($token)->post(
            $config['base_url'] . '/v2/checkout/orders',
            [
                'intent' => 'CAPTURE',
                'purchase_units' => [[
                    'amount' => [
                        'currency_code' => 'USD',
                        'value' => number_format($amount, 2, '.', '')
                    ]
                ]]
            ]
        );

        return response()->json($response->json());
    }

    public function captureOrder(Request $request)
    {
        $token  = $this->getAccessToken();
        $config = $this->paypalConfig();

        $orderId = $request->orderID;

        $response = Http::withToken($token)->post(
            $config['base_url'] . "/v2/checkout/orders/$orderId/capture"
        );

        // ✅ YAHAN PAYMENT SUCCESS SAVE KARO (DB)
        // $response['status'] == COMPLETED

        return response()->json($response->json());
    }
}

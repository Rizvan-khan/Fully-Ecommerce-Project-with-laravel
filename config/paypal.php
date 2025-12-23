<?php

return [

    'mode' => env('PAYPAL_MODE', 'sandbox'),

    'sandbox' => [
        'client_id' => env('PAYPAL_SANDBOX_CLIENT_ID'),
        'secret'    => env('PAYPAL_SANDBOX_SECRET'),
        'base_url'  => 'https://api-m.sandbox.paypal.com',
    ],

    'live' => [
        'client_id' => env('PAYPAL_LIVE_CLIENT_ID'),
        'secret'    => env('PAYPAL_LIVE_SECRET'),
        'base_url'  => 'https://api-m.paypal.com',
    ],
];

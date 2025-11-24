<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Midtrans Sandbox Configuration
    |--------------------------------------------------------------------------
    */

    // Server Key - PAKAI DEFAULT VALUE TANPA SB-
    'server_key' => env('MIDTRANS_SERVER_KEY', 'Mid-server-LJyYObIwMMrJodITmBRs-hoT'),

    // Client Key - PAKAI DEFAULT VALUE TANPA SB-  
    'client_key' => env('MIDTRANS_CLIENT_KEY', 'Mid-client-5s3E2HrBPogzkp5a'),

    // Merchant ID
    'merchant_id' => env('MIDTRANS_MERCHANT_ID', 'G724728516'),

    // Environment Configuration - HAPUS DUPLIKAT!
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'is_sanitized' => env('MIDTRANS_IS_SANITIZED', true),
    'is_3ds' => env('MIDTRANS_IS_3DS', true),

    // Sandbox URLs
    'base_url' => env('MIDTRANS_IS_PRODUCTION', false) 
        ? 'https://api.sandbox.midtrans.com/v2' 
        : 'https://api.sandbox.midtrans.com/v2',
    
    'snap_url' => env('MIDTRANS_IS_PRODUCTION', false) 
        ? 'https://app.sandbox.midtrans.com/snap/snap.js' 
        : 'https://app.sandbox.midtrans.com/snap/snap.js',

    // Webhook URL for notification
    'notification_url' => env('APP_URL') . '/midtrans/notification',

    // Payment callbacks
    'callbacks' => [
        'finish' => env('APP_URL') . '/payment/success',
        'unfinish' => env('APP_URL') . '/payment/pending', 
        'error' => env('APP_URL') . '/payment/failed'
    ],

    // Default settings for transactions
    'defaults' => [
        'enabled_payments' => [
            'credit_card',
            'mandiri_clickpay',
            'cimb_clicks',
            'bca_klikbca',
            'bca_klikpay', 
            'bri_epay',
            'echannel',
            'permata_va',
            'bca_va',
            'bni_va',
            'other_va',
            'gopay',
            'shopeepay',
            'indomaret',
            'alfamart'
        ],
    ]
];
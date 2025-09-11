<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Midtrans Sandbox Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Midtrans payment gateway integration
    | Set to Sandbox environment for testing
    |
    */

    // Server Key (Required for backend operations) - Sandbox
    'server_key' => env('MIDTRANS_SERVER_KEY', 'SB-Mid-server-LJyYObIwMMrJodITmBRs-hoT'),

    // Client Key (Required for frontend Snap.js) - Sandbox
    'client_key' => env('MIDTRANS_CLIENT_KEY', 'SB-Mid-client-5s3E2HrBPogzkp5a'),

    // Merchant ID (Optional, for additional validation)
    'merchant_id' => env('MIDTRANS_MERCHANT_ID', 'G724728516'),

    // Environment Configuration - Default to Sandbox
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),

    // Security Configuration
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

    // Sandbox Testing Cards & Payment Methods
    'sandbox_cards' => [
        'success' => [
            'number' => '4811 1111 1111 1114',
            'cvv' => '123',
            'exp_month' => '12',
            'exp_year' => '2025'
        ],
        'failure' => [
            'number' => '4911 1111 1111 1113',
            'cvv' => '123', 
            'exp_month' => '12',
            'exp_year' => '2025'
        ]
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
        
        'credit_card' => [
            'secure' => true,
            'channel' => 'migs',
            'bank' => 'bca',
            'installment' => [
                'required' => false,
                'terms' => [
                    'bni' => [3, 6, 12],
                    'mandiri' => [3, 6, 12],
                    'cimb' => [3],
                    'bca' => [3, 6, 12],
                    'offline' => [6, 12]
                ]
            ]
        ]
    ]
];
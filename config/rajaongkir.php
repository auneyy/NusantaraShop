<?php

return [
    /*
    |--------------------------------------------------------------------------
    | RajaOngkir API Key
    |--------------------------------------------------------------------------
    |
    | API key dari RajaOngkir yang didapat setelah registrasi
    | Simpan di file .env dengan key RAJAONGKIR_API_KEY
    |
    */
    'api_key' => env('RAJAONGKIR_API_KEY', 'Q2KxG4Jo6a6ba7bdcfe7ca16UVY3XLpV'),

    /*
    |--------------------------------------------------------------------------
    | Origin District ID
    |--------------------------------------------------------------------------
    |
    | ID kecamatan asal pengiriman (default: 3942 untuk Diwek)
    | Sesuaikan dengan lokasi toko Anda
    |
    */
    'origin_district_id' => env('RAJAONGKIR_ORIGIN_DISTRICT_ID', 3942),

    /*
    |--------------------------------------------------------------------------
    | Available Couriers
    |--------------------------------------------------------------------------
    |
    | Daftar kurir yang tersedia
    |
    */
    'couriers' => [
        'jne' => 'JNE',
        'pos' => 'POS Indonesia',
        'tiki' => 'TIKI',
        'anteraja' => 'AnterAja',
        'jnt' => 'J&T Express',
        'sicepat' => 'SiCepat',
        'sap' => 'SAP Express',
    ],
];
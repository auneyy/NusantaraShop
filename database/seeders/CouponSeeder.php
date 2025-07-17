<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Coupon;

class CouponSeeder extends Seeder
{
    public function run()
    {
        // Nonaktifkan foreign key checks untuk menghindari error saat truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Hapus data existing
        DB::table('coupons')->truncate();
        
        // Aktifkan kembali foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $coupons = [
            [
                'kode' => 'WELCOME10',
                'name' => 'Welcome Discount',
                'deskripsi' => 'Get 10% off on your first purchase', // Sesuai dengan migration
                'type' => 'percentage',
                'harga' => 10.00,
                'minimum_amount' => 100000.00,
                'limit_penggunaan' => 100, // Sesuai dengan migration
                'used_count' => 0,
                'valid_dari' => now(),
                'valid_sampai' => now()->addMonth(),
                'is_active' => true,
            ],
            [
                'kode' => 'SAVE50K',
                'name' => 'Save 50K',
                'deskripsi' => 'Get 50,000 off on purchase above 500,000', // Sesuai dengan migration
                'type' => 'fixed',
                'harga' => 50000.00,
                'minimum_amount' => 500000.00,
                'limit_penggunaan' => 50, // Konsisten dengan record pertama
                'used_count' => 0,
                'valid_dari' => now(),
                'valid_sampai' => now()->addMonths(3),
                'is_active' => true,
            ],
        ];

        foreach ($coupons as $coupon) {
            // Menggunakan updateOrCreate untuk menghindari duplicate
            Coupon::updateOrCreate(
                ['kode' => $coupon['kode']],
                array_merge($coupon, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
        
        // Alternatif menggunakan DB::table jika tidak ada Model Coupon
        /*
        foreach ($coupons as $coupon) {
            // Cek apakah kode sudah ada
            if (!DB::table('coupons')->where('kode', $coupon['kode'])->exists()) {
                DB::table('coupons')->insert(array_merge($coupon, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }
        */
    }
}
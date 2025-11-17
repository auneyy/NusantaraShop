<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;

class ProfileOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first user or create one
        $user = User::first();
        
        if (!$user) {
            $user = User::create([
                'name' => 'Ghevan Yusufa',
                'email' => 'ghevan@gmail.com',
                'password' => bcrypt('password'),
                'phone' => '+62 123-4567-890',
                'address' => 'Jalan Kembang No 19, Kota Malang'
            ]);
        }

        // Sample orders data matching the image
        $orders = [
            [
                'product_name' => 'Batik Solo',
                'quantity' => 1,
                'price' => 350000,
                'total_price' => 350000,
                'status' => 'Selesai',
                'created_at' => Carbon::parse('2024-01-02'),
                'order_date' => Carbon::parse('2024-01-02')
            ],
            [
                'product_name' => 'Batik Malang',
                'quantity' => 1,
                'price' => 400000,
                'total_price' => 400000,
                'status' => 'Dikirim',
                'created_at' => Carbon::parse('2024-02-15'),
                'order_date' => Carbon::parse('2024-02-15')
            ],
            [
                'product_name' => 'Batik Pekalongan',
                'quantity' => 1,
                'price' => 300000,
                'total_price' => 300000,
                'status' => 'Selesai',
                'created_at' => Carbon::parse('2024-06-30'),
                'order_date' => Carbon::parse('2024-06-30')
            ],
            [
                'product_name' => 'Batik Yogyakarta',
                'quantity' => 1,
                'price' => 450000,
                'total_price' => 450000,
                'status' => 'Dikirim',
                'created_at' => Carbon::parse('2024-06-01'),
                'order_date' => Carbon::parse('2024-06-01')
            ],
            [
                'product_name' => 'Batik Jambi',
                'quantity' => 1,
                'price' => 250000,
                'total_price' => 250000,
                'status' => 'Selesai',
                'created_at' => Carbon::parse('2024-06-06'),
                'order_date' => Carbon::parse('2024-06-06')
            ]
        ];

        foreach ($orders as $orderData) {
            Order::create([
                'user_id' => $user->id,
                'product_name' => $orderData['product_name'],
                'quantity' => $orderData['quantity'],
                'price' => $orderData['price'],
                'total_price' => $orderData['total_price'],
                'status' => $orderData['status'],
                'created_at' => $orderData['created_at'],
                'updated_at' => $orderData['created_at'],
                'order_date' => $orderData['order_date']
            ]);
        }
    }
}
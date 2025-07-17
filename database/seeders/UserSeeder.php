<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Nonaktifkan foreign key checks untuk menghindari error saat truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Hapus data existing
        DB::table('users')->truncate();
        
        // Aktifkan kembali foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        // Atau gunakan metode yang lebih aman dengan updateOrCreate
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );
        
        User::updateOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name' => 'Customer User',
                'password' => Hash::make('password'),
                'role' => 'customer',
                'is_active' => true,
            ]
        );
        
        // Alternatif menggunakan DB::table jika tidak ada Model
        /*
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Customer User',
                'email' => 'customer@example.com',
                'password' => Hash::make('password'),
                'role' => 'customer',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        */
    }
}
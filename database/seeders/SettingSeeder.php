<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'My E-commerce Store', 'type' => 'string'],
            ['key' => 'site_description', 'value' => 'Best online shopping experience', 'type' => 'string'],
            ['key' => 'currency', 'value' => 'IDR', 'type' => 'string'],
            ['key' => 'tax_rate', 'value' => '10', 'type' => 'number'],
            ['key' => 'free_shipping_minimum', 'value' => '100000', 'type' => 'number'],
            ['key' => 'maintenance_mode', 'value' => 'false', 'type' => 'boolean'],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->insert([
                'key' => $setting['key'],
                'value' => $setting['value'],
                'type' => $setting['type'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
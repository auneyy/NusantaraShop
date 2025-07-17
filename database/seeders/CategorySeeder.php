<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        // Nonaktifkan foreign key checks untuk menghindari error saat truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Hapus data existing
        DB::table('categories')->truncate();
        
        // Aktifkan kembali foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $categories = [
            ['name' => 'Electronics', 'deskripsi' => 'Electronic devices and gadgets'],
            ['name' => 'Fashion', 'deskripsi' => 'Clothing and accessories'],
            ['name' => 'Home & Garden', 'deskripsi' => 'Home improvement and garden supplies'],
            ['name' => 'Sports', 'deskripsi' => 'Sports equipment and accessories'],
            ['name' => 'Books', 'deskripsi' => 'Books and educational materials'],
        ];

        foreach ($categories as $category) {
            // Menggunakan updateOrCreate untuk menghindari duplicate
            Category::updateOrCreate(
                ['slug' => Str::slug($category['name'])],
                [
                    'name' => $category['name'],
                    'deskripsi' => $category['deskripsi'],
                    'is_active' => true,
                ]
            );
        }
        
        // Alternatif menggunakan DB::table jika tidak ada Model Category
        /*
        foreach ($categories as $category) {
            $slug = Str::slug($category['name']);
            
            // Cek apakah slug sudah ada
            if (!DB::table('categories')->where('slug', $slug)->exists()) {
                DB::table('categories')->insert([
                    'name' => $category['name'],
                    'slug' => $slug,
                    'deskripsi' => $category['deskripsi'],
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        */
    }
}
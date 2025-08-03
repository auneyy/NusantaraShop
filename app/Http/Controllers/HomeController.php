<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Discount;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil 4 produk terbaru untuk koleksi terbaru
        $latestProducts = Product::with(['images' => function ($q) {
            $q->where('is_primary', true);
        }])->active()->latest()->take(4)->get();

        // Ambil 8 produk untuk semua produk
        $allProducts = Product::with(['images' => function ($q) {
            $q->where('is_primary', true);
        }])->active()->latest()->take(8)->get();

        // Ambil kategori aktif untuk section kategori
        $categories = Category::active()->take(3)->get();

        // Ambil diskon yang sedang aktif
        $currentDiscount = Discount::active()->first();

        // Set primary image untuk setiap produk
        $latestProducts->each(function ($product) {
            $product->primary_image = $product->images->first()?->image_path ?? 'batik2.png';
        });

        $allProducts->each(function ($product) {
            $product->primary_image = $product->images->first()?->image_path ?? 'batik2.png';
        });

        return view('home', compact('latestProducts', 'allProducts', 'categories', 'currentDiscount'));
    }
}
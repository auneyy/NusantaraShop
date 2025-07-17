<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::with(['images' => function ($q) {
            $q->where('is_primary', true);
        }])->latest()->take(4)->get();

        // Ambil gambar utama
        $products->each(function ($product) {
            $product->primary_image = $product->images->first()?->image_path ?? 'default.jpg';
        });

        return view('home', ['products' => Product::latest()->take(8)->get()]);

    }
}

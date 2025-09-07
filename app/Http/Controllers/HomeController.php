<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Discount;
use Illuminate\Http\Request;

class HomeController extends Controller
{
   public function index()
{
    $products = Product::with('images')->latest()->take(10)->get();

    // Ambil diskon aktif (berdasarkan tanggal sekarang)
    $currentDate = now()->format('Y-m-d');
    $activeDiscounts = Discount::where('start_date', '<=', $currentDate)
        ->where('end_date', '>=', $currentDate)
        ->with('products')
        ->get();

    // Ambil 1 banner diskon terbaru/aktif
    $discountBanner = Discount::whereNotNull('banner_image')
                        ->latest()
                        ->first();

    return view('home', compact('products', 'discountBanner', 'activeDiscounts'));
}
}
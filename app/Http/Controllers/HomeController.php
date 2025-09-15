<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Discount;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil produk terbaru dengan relasi gambar
        $products = Product::with('images')->latest()->take(10)->get();

        // Ambil diskon aktif berdasarkan tanggal sekarang
        $currentDate = now()->format('Y-m-d');
        $activeDiscounts = Discount::where('start_date', '<=', $currentDate)
            ->where('end_date', '>=', $currentDate)
            ->with('products')
            ->get();

        // Ambil banner diskon terbaru yang tersedia
        $discountBanner = Discount::whereNotNull('banner_image')
            ->latest()
            ->first();

        // Ambil data user jika login, bisa null kalau guest
        $user = Auth::user();

        // Kirim semua data ke view 'home'
        return view('home', compact('products', 'activeDiscounts', 'discountBanner', 'user'));
    }
}
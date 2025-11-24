<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Discount;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index(Request $request)
    {
        $currentDate = now()->format('Y-m-d');

        // Ambil produk yang memiliki diskon aktif
        $discountedProducts = Product::whereHas('discounts', function($query) use ($currentDate) {
            $query->where('start_date', '<=', $currentDate)
                  ->where('end_date', '>=', $currentDate);
        })
        ->with(['images', 'discounts' => function($query) use ($currentDate) {
            $query->where('start_date', '<=', $currentDate)
                  ->where('end_date', '>=', $currentDate);
        }])
        ->get();

        // **SORTING BERDASARKAN HARGA SETELAH DISKON**
        $sort = $request->get('sort');
        if ($sort) {
            switch($sort) {
                case 'az':
                    $discountedProducts = $discountedProducts->sortBy('name')->values();
                    break;
                case 'za':
                    $discountedProducts = $discountedProducts->sortByDesc('name')->values();
                    break;
                case 'low_high':
                    // Sorting berdasarkan discounted_price (harga setelah diskon)
                    $discountedProducts = $discountedProducts->sortBy('discounted_price')->values();
                    break;
                case 'high_low':
                    // Sorting berdasarkan discounted_price (harga setelah diskon)
                    $discountedProducts = $discountedProducts->sortByDesc('discounted_price')->values();
                    break;
                default:
                    $discountedProducts = $discountedProducts->sortByDesc('created_at')->values();
            }
        }

        $discountCount = $discountedProducts->count();
        
        // Ambil diskon aktif untuk keperluan lain (jika needed)
        $activeDiscounts = Discount::where('start_date', '<=', $currentDate)
            ->where('end_date', '>=', $currentDate)
            ->get();

        return view('promo', compact('discountedProducts', 'discountCount', 'activeDiscounts'));
    }
}
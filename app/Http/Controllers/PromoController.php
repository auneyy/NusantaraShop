<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index(Request $request)
    {
        $discountedProducts = [];
        $currentDate = now()->format('Y-m-d');

        // Ambil semua diskon aktif beserta produk + gambarnya
        $activeDiscounts = Discount::where('start_date', '<=', $currentDate)
            ->where('end_date', '>=', $currentDate)
            ->with('products.images')
            ->get();

        // Hitung harga diskon per produk
        foreach ($activeDiscounts as $discount) {
            foreach ($discount->products as $product) {
                $discountAmount = $discount->percentage ?? 0;
                $discountPrice = $product->price - ($product->price * ($discountAmount / 100));

                // Kalau produk sudah ada, pilih harga diskon terendah
                if (isset($discountedProducts[$product->id])) {
                    $discountedProducts[$product->id]->discount_price = min(
                        $discountedProducts[$product->id]->discount_price,
                        $discountPrice
                    );
                } else {
                    $product->discount_price = $discountPrice;
                    $discountedProducts[$product->id] = $product;
                }
            }
        }

        // Ubah associative array jadi indexed array
        $discountedProducts = array_values($discountedProducts);

        // Sorting
        $sort = $request->get('sort');
        if ($sort) {
            if ($sort === 'az') {
                usort($discountedProducts, fn($a, $b) => strcmp($a->name, $b->name));
            } elseif ($sort === 'za') {
                usort($discountedProducts, fn($a, $b) => strcmp($b->name, $a->name));
            } elseif ($sort === 'low_high') {
                usort($discountedProducts, fn($a, $b) => $a->discount_price <=> $b->discount_price);
            } elseif ($sort === 'high_low') {
                usort($discountedProducts, fn($a, $b) => $b->discount_price <=> $a->discount_price);
            } elseif ($sort === 'best_selling') {
                // Kalau ada kolom penjualan
                usort($discountedProducts, fn($a, $b) => $b->sold_count <=> $a->sold_count);
            }
        }

        $discountCount = count($discountedProducts);

        return view('promo', compact('discountedProducts', 'discountCount', 'activeDiscounts'));
    }
}

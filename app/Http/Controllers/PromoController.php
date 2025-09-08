<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index()
    {
        $discountedProducts = [];
        $currentDate = now()->format('Y-m-d');

        $activeDiscounts = Discount::where('start_date', '<=', $currentDate)
            ->where('end_date', '>=', $currentDate)
            ->with('products.images')
            ->get();

        foreach ($activeDiscounts as $discount) {
            foreach ($discount->products as $product) {
                $discountedProducts[] = $product;
            }
        }

        $discountCount = count($discountedProducts);

        return view('promo', compact('discountedProducts', 'discountCount', 'activeDiscounts'));
    }
}

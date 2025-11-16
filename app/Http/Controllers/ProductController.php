<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Discount;
use App\Http\Controllers\Admin\DiscountController;

class ProductController extends Controller
{
    public function index()
    {
        $query = Product::query()->with(['category', 'images']);

        if (request()->has('category')) {
            $query->whereHas('category', function($q) {
                $q->where('slug', request('category'));
            });
        }

        $products = $query->paginate(12);
        $categories = Category::withCount('products')->get();
        
        // Dapatkan diskon aktif untuk produk
        $activeDiscounts = $this->getActiveDiscountsForProducts($products);

        return view('products', compact('products', 'categories', 'activeDiscounts'));
    }

    public function show(Product $product)
    {
        $product->load(['images', 'category']);
        
        // Dapatkan diskon aktif untuk produk ini
        $activeDiscounts = $this->getActiveDiscountsForProducts(collect([$product]));
        
        $recommendedProducts = Product::where('is_featured', 1)
            ->where('id', '!=', $product->id)
            ->with('images')
            ->inRandomOrder()
            ->limit(4)
            ->get();
            
        // Dapatkan diskon aktif untuk produk rekomendasi
        $recommendedDiscounts = $this->getActiveDiscountsForProducts($recommendedProducts);

        return view('products.show', compact('product', 'recommendedProducts', 'activeDiscounts', 'recommendedDiscounts'));
    }

    public function search()
    {
        $query = Product::query()->with(['images']);

        if (request()->has('q')) {
            $query->where('name', 'like', '%' . request('q') . '%')
                  ->orWhere('deskripsi', 'like', '%' . request('q') . '%');
        }

        $products = $query->paginate(12);
        $categories = Category::withCount('products')->get();
        
        // Dapatkan diskon aktif untuk produk
        $activeDiscounts = $this->getActiveDiscountsForProducts($products);

        return view('search', compact('products', 'categories', 'activeDiscounts'));
    }
    
    /**
     * Method untuk mendapatkan diskon aktif untuk kumpulan produk
     */
    private function getActiveDiscountsForProducts($products)
    {
        $currentDate = now()->format('Y-m-d');
        $productIds = $products->pluck('id');
        
        return Discount::where('start_date', '<=', $currentDate)
            ->where('end_date', '>=', $currentDate)
            ->whereHas('products', function($query) use ($productIds) {
                $query->whereIn('products.id', $productIds);
            })
            ->with(['products' => function($query) use ($productIds) {
                $query->whereIn('products.id', $productIds);
            }])
            ->get();
    }

}
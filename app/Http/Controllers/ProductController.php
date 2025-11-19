<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Discount;

class ProductController extends Controller
{
    /**
     * Display a listing of products
     */
    public function index()
    {
        $query = Product::query()->with(['category', 'images']);

        // Filter by category
        if (request()->has('category')) {
            $query->whereHas('category', function($q) {
                $q->where('slug', request('category'));
            });
        }

        // Filter by search
        if (request()->has('search') && request('search') != '') {
            $searchTerm = request('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('deskripsi', 'like', '%' . $searchTerm . '%');
            });
        }

        // Sort options
        if (request()->has('sort')) {
            switch (request('sort')) {
                case 'price_asc':
                    $query->orderBy('harga', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('harga', 'desc');
                    break;
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::withCount('products')->get();
        
        // Gunakan method dari Model Discount (REAL-TIME CHECK dengan WIB)
        $activeDiscounts = Discount::getActiveDiscountsForProducts($products->pluck('id'));

        return view('products', compact('products', 'categories', 'activeDiscounts'));
    }

    /**
     * Display the specified product
     */
    public function show(Product $product)
    {
        $product->load(['images', 'category']);
        
        // Cek discount aktif untuk produk ini (REAL-TIME)
        $activeDiscount = Discount::getActiveDiscountForProduct($product->id);
        
        // Hitung harga setelah discount
        $discountedPrice = null;
        $savings = null;
        
        if ($activeDiscount) {
            $discountedPrice = $activeDiscount->calculateDiscountedPrice($product->harga);
            $savings = $activeDiscount->calculateSavings($product->harga);
        }
        
        // Produk rekomendasi
        $recommendedProducts = Product::where('is_featured', 1)
            ->where('id', '!=', $product->id)
            ->with('images')
            ->inRandomOrder()
            ->limit(4)
            ->get();
            
        // Discount untuk produk rekomendasi
        $recommendedDiscounts = Discount::getActiveDiscountsForProducts($recommendedProducts->pluck('id'));

        return view('products.show', compact(
            'product', 
            'activeDiscount',
            'discountedPrice',
            'savings',
            'recommendedProducts', 
            'recommendedDiscounts'
        ));
    }

    /**
     * Search products
     */
    public function search()
    {
        $query = Product::query()->with(['images', 'category']);

        if (request()->has('q') && request('q') != '') {
            $searchTerm = request('q');
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('deskripsi', 'like', '%' . $searchTerm . '%')
                  ->orWhere('sku', 'like', '%' . $searchTerm . '%');
            });
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::withCount('products')->get();
        
        // Gunakan method dari Model (REAL-TIME CHECK)
        $activeDiscounts = Discount::getActiveDiscountsForProducts($products->pluck('id'));

        return view('search', compact('products', 'categories', 'activeDiscounts'));
    }
}
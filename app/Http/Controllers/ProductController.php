<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Review;

class ProductController extends Controller
{
    /**
     * Display a listing of products
     */
    public function index()
    {
        $query = Product::query()->with(['category', 'images', 'sizes', 'discounts']);

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

        // Sort options - sorting berdasarkan harga setelah diskon
        if (request()->has('sort')) {
            switch (request('sort')) {
                case 'price_asc':
                    // Sort by discounted price (low to high)
                    $query->orderByRaw('
                        CASE 
                            WHEN EXISTS (
                                SELECT 1 FROM product_discount 
                                JOIN discounts ON product_discount.discount_id = discounts.id 
                                WHERE product_discount.product_id = products.id 
                                AND discounts.start_date <= NOW() 
                                AND discounts.end_date >= NOW()
                            ) 
                            THEN (products.harga - (products.harga * (
                                SELECT discounts.percentage 
                                FROM product_discount 
                                JOIN discounts ON product_discount.discount_id = discounts.id 
                                WHERE product_discount.product_id = products.id 
                                AND discounts.start_date <= NOW() 
                                AND discounts.end_date >= NOW() 
                                LIMIT 1
                            ) / 100))
                            ELSE products.harga 
                        END ASC
                    ');
                    break;
                    
                case 'price_desc':
                    // Sort by discounted price (high to low)
                    $query->orderByRaw('
                        CASE 
                            WHEN EXISTS (
                                SELECT 1 FROM product_discount 
                                JOIN discounts ON product_discount.discount_id = discounts.id 
                                WHERE product_discount.product_id = products.id 
                                AND discounts.start_date <= NOW() 
                                AND discounts.end_date >= NOW()
                            ) 
                            THEN (products.harga - (products.harga * (
                                SELECT discounts.percentage 
                                FROM product_discount 
                                JOIN discounts ON product_discount.discount_id = discounts.id 
                                WHERE product_discount.product_id = products.id 
                                AND discounts.start_date <= NOW() 
                                AND discounts.end_date >= NOW() 
                                LIMIT 1
                            ) / 100))
                            ELSE products.harga 
                        END DESC
                    ');
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

        return view('products', compact('products', 'categories'));
    }

    /**
     * Display the specified product
     */
    public function show(Product $product)
    {
        // Load relationships including reviews with pagination
        $product->load(['images', 'category', 'sizes', 'discounts']);
        
        // ✅ Load reviews with pagination (10 per page)
        $reviews = Review::where('product_id', $product->id)
            ->with('user:id,name')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        // ✅ Calculate review statistics
        $totalReviews = $product->total_reviews ?? 0;
        $averageRating = $product->rating_rata ?? 0;
        
        // ✅ Get rating distribution (1-5 stars)
        $ratingDistribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $ratingDistribution[$i] = Review::where('product_id', $product->id)
                ->where('rating', $i)
                ->count();
        }
        
        // ✅ Calculate rating percentages
        $ratingPercentages = [];
        if ($totalReviews > 0) {
            foreach ($ratingDistribution as $rating => $count) {
                $ratingPercentages[$rating] = round(($count / $totalReviews) * 100, 1);
            }
        } else {
            $ratingPercentages = array_fill(1, 5, 0);
        }
        
        // Produk rekomendasi - load discounts juga
        $recommendedProducts = Product::where('is_featured', 1)
            ->where('id', '!=', $product->id)
            ->with(['images', 'sizes', 'discounts'])
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('products.show', compact(
            'product', 
            'recommendedProducts',
            'reviews',
            'totalReviews',
            'averageRating',
            'ratingDistribution',
            'ratingPercentages'
        ));
    }

    /**
     * Search products
     */
    public function search()
    {
        $query = Product::query()->with(['images', 'category', 'sizes', 'discounts']);

        if (request()->has('q') && request('q') != '') {
            $searchTerm = request('q');
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('deskripsi', 'like', '%' . $searchTerm . '%')
                  ->orWhere('sku', 'like', '%' . $searchTerm . '%');
            });
        }

        // Apply same sorting logic as index method
        if (request()->has('sort')) {
            switch (request('sort')) {
                case 'price_asc':
                    $query->orderByRaw('
                        CASE 
                            WHEN EXISTS (
                                SELECT 1 FROM product_discount 
                                JOIN discounts ON product_discount.discount_id = discounts.id 
                                WHERE product_discount.product_id = products.id 
                                AND discounts.start_date <= NOW() 
                                AND discounts.end_date >= NOW()
                            ) 
                            THEN (products.harga - (products.harga * (
                                SELECT discounts.percentage 
                                FROM product_discount 
                                JOIN discounts ON product_discount.discount_id = discounts.id 
                                WHERE product_discount.product_id = products.id 
                                AND discounts.start_date <= NOW() 
                                AND discounts.end_date >= NOW() 
                                LIMIT 1
                            ) / 100))
                            ELSE products.harga 
                        END ASC
                    ');
                    break;
                    
                case 'price_desc':
                    $query->orderByRaw('
                        CASE 
                            WHEN EXISTS (
                                SELECT 1 FROM product_discount 
                                JOIN discounts ON product_discount.discount_id = discounts.id 
                                WHERE product_discount.product_id = products.id 
                                AND discounts.start_date <= NOW() 
                                AND discounts.end_date >= NOW()
                            ) 
                            THEN (products.harga - (products.harga * (
                                SELECT discounts.percentage 
                                FROM product_discount 
                                JOIN discounts ON product_discount.discount_id = discounts.id 
                                WHERE product_discount.product_id = products.id 
                                AND discounts.start_date <= NOW() 
                                AND discounts.end_date >= NOW() 
                                LIMIT 1
                            ) / 100))
                            ELSE products.harga 
                        END DESC
                    ');
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

        return view('search', compact('products', 'categories'));
    }
}
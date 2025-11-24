<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Discount;

class SearchController extends Controller
{
    /**
     * Display search results
     */
   public function search(Request $request)
{
    $searchTerm = $request->input('q', '');
    $sortBy = $request->input('sort_by', 'latest');
    $category = $request->input('category', '');
    $minPrice = $request->input('min_price', '');
    $maxPrice = $request->input('max_price', '');
    
    // Validasi jika search kosong
    if (empty($searchTerm)) {
        return redirect()->route('products.index')->with('info', 'Masukkan kata kunci pencarian');
    }

    $query = Product::query()->with(['images', 'category', 'sizes']);

    // Query pencarian utama
    $query->where(function($q) use ($searchTerm) {
        $q->where('name', 'like', '%' . $searchTerm . '%')
          ->orWhere('deskripsi', 'like', '%' . $searchTerm . '%')
          ->orWhere('sku', 'like', '%' . $searchTerm . '%')
          ->orWhereHas('category', function($categoryQuery) use ($searchTerm) {
              $categoryQuery->where('name', 'like', '%' . $searchTerm . '%');
          });
    });

    // Filter by category
    if (!empty($category)) {
        $query->whereHas('category', function($q) use ($category) {
            $q->where('slug', $category);
        });
    }

    // Filter by price range
    if (!empty($minPrice)) {
        $query->where('harga', '>=', $minPrice);
    }
    if (!empty($maxPrice)) {
        $query->where('harga', '<=', $maxPrice);
    }

    // Sort options
    switch ($sortBy) {
        case 'price_low':
            $query->orderBy('harga', 'asc');
            break;
        case 'price_high':
            $query->orderBy('harga', 'desc');
            break;
        case 'name':
            $query->orderBy('name', 'asc');
            break;
        case 'latest':
        default:
            $query->latest();
            break;
    }

    $products = $query->paginate(12)->withQueryString();
    $categories = Category::withCount('products')->get();
    
    // Discount info
    $activeDiscounts = Discount::getActiveDiscountsForProducts($products->pluck('id'));

    return view('search-results', compact(
        'products', 
        'searchTerm', 
        'categories', 
        'activeDiscounts',
        'sortBy',
        'category',
        'minPrice',
        'maxPrice'
    ));
}

    /**
     * Advanced search
     */
    public function advancedSearch(Request $request)
    {
        // Implement advanced search logic here
        return view('search.advanced');
    }
}
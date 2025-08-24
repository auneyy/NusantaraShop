<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

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

        return view('products', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        $product->load(['images', 'category']);
        $recommendedProducts = Product::where('is_featured', 1)
    ->where('id', '!=', $product->id)
    ->with('images')
    ->inRandomOrder()
    ->limit(4)
    ->get();
        return view('product_show', compact('product', 'recommendedProducts'));
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

        return view('search', compact('products', 'categories'));
    }
}
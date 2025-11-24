<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class HelpController extends Controller
{
    /**
     * Display the help page with articles
     */
    public function index()
    {
        try {
            // Get featured articles
            $featuredArticles = Article::published()
                ->featured()
                ->ordered()
                ->take(6)
                ->get();

            // Get all published articles for search and filtering
            $allArticles = Article::published()
                ->ordered()
                ->get();

            return view('help', compact('featuredArticles', 'allArticles'));
        } catch (\Exception $e) {
            // Jika tabel belum ada atau error lain
            $featuredArticles = collect([]);
            $allArticles = collect([]);
            
            return view('help', compact('featuredArticles', 'allArticles'));
        }
    }

    /**
     * Display articles by category
     */
    public function category($category)
    {
        try {
            // Validate category
            $validCategories = ['getting-started', 'account-billing', 'troubleshooting'];
            
            if (!in_array($category, $validCategories)) {
                abort(404, 'Kategori tidak ditemukan');
            }

            // Get category name in Indonesian
            $categoryNames = [
                'getting-started' => 'Memulai',
                'account-billing' => 'Akun dan Pembayaran',
                'troubleshooting' => 'Pemecahan Masalah',
            ];

            $categoryName = $categoryNames[$category];

            // Get articles by category
            $articles = Article::published()
                ->where('category', $category)
                ->ordered()
                ->get();

            return view('help-category', compact('articles', 'category', 'categoryName'));
        } catch (\Exception $e) {
            abort(404, 'Kategori tidak ditemukan');
        }
    }
}
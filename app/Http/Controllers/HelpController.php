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
}
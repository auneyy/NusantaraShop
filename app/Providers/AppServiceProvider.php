<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Models\Article;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Route Model Binding untuk artikel
        // Ini akan otomatis bind parameter {artikel} ke model Article
        Route::model('artikel', Article::class);
    }
}
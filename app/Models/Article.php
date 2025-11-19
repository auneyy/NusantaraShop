<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'category',
        'is_featured',
        'is_published',
        'order'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
        });

        static::updating(function ($article) {
            if ($article->isDirty('title') && empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
        });
    }

    /**
     * Get category name in Indonesian
     */
    public function getCategoryNameAttribute()
    {
        $categories = [
            'getting-started' => 'Memulai',
            'account-billing' => 'Akun dan Pembayaran',
            'troubleshooting' => 'Pemecahan Masalah',
        ];

        return $categories[$this->category] ?? 'Lainnya';
    }

    /**
     * Scope for published articles
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope for featured articles
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for ordering
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')->orderBy('created_at', 'desc');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'deskripsi',
        'deskripsi_singkat',
        'harga',
        'harga_jual',
        'sku',
        'stock_kuantitas',
        'berat',
        'dimensi',
        'status',
        'is_featured',
        'rating_rata',
        'total_reviews',
        'total_penjualan',
        'meta_data'
    ];

    protected $casts = [
        'dimensi' => 'array',
        'meta_data' => 'array',
        'is_featured' => 'boolean',
        'harga' => 'decimal:2',
        'harga_jual' => 'decimal:2',
        'rating_rata' => 'decimal:2'
    ];

    // Relasi dengan Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi dengan ProductImage
    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    // Accessor untuk mendapatkan gambar utama
    public function getPrimaryImageAttribute()
    {
        $primaryImage = $this->images()->where('is_primary', true)->first();
        return $primaryImage ? $primaryImage->image_path : 'default.jpg';
    }

    // Accessor untuk harga yang sudah diformat
    public function getFormattedHargaAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    public function getFormattedHargaJualAttribute()
    {
        return $this->harga_jual ? 'Rp ' . number_format($this->harga_jual, 0, ',', '.') : null;
    }

    // Mutator untuk slug
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    // Scope untuk produk aktif
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Scope untuk produk featured
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Scope untuk produk terbaru
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'deskripsi',
        'harga',
        'sku',
        'stock_kuantitas',
        'berat',
        'status',
        'is_featured',
        'rating_rata',
        'total_reviews',
        'total_penjualan',
        'meta_data',
    ];

    protected $casts = [
        'meta_data' => 'array',
        'is_featured' => 'boolean',
        'harga' => 'decimal:2',
        'rating_rata' => 'decimal:2'
    ];

    // Tambahkan appends untuk accessor
    protected $appends = ['has_active_discount', 'discounted_price', 'active_discount'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function discounts()
    {
        return $this->belongsToMany(Discount::class, 'product_discount')->withTimestamps();
    }

    // Method untuk mendapatkan discount aktif - PERBAIKAN: hapus kondisi is_valid
    public function getActiveDiscountAttribute()
    {
        $currentDate = now()->format('Y-m-d H:i:s');
        
        return $this->discounts()
            ->where('start_date', '<=', $currentDate)
            ->where('end_date', '>=', $currentDate)
            ->orderBy('percentage', 'desc')
            ->first();
    }

    // Cek apakah punya discount aktif
    public function getHasActiveDiscountAttribute()
    {
        return !is_null($this->active_discount);
    }

    // Harga setelah discount
    public function getDiscountedPriceAttribute()
    {
        if ($this->has_active_discount) {
            return $this->harga - ($this->harga * $this->active_discount->percentage / 100);
        }
        return $this->harga;
    }

    // Persentase discount
    public function getDiscountPercentageAttribute()
    {
        return $this->has_active_discount ? $this->active_discount->percentage : 0;
    }

    // Jumlah yang dihemat
    public function getSavingsAmountAttribute()
    {
        if ($this->has_active_discount) {
            return $this->harga - $this->discounted_price;
        }
        return 0;
    }

    // Tanggal berakhir discount
    public function getDiscountEndDateAttribute()
    {
        return $this->has_active_discount ? $this->active_discount->end_date : null;
    }

    // End date dalam format ISO untuk countdown
    public function getDiscountEndDateIsoAttribute()
    {
        if ($this->has_active_discount && $this->active_discount->end_date) {
            return Carbon::parse($this->active_discount->end_date)->toISOString();
        }
        return null;
    }

    public function getFormattedHargaFinalAttribute()
    {
        return 'Rp ' . number_format($this->discounted_price, 0, ',', '.');
    }

    public function getPrimaryImageAttribute()
    {
        $primaryImage = $this->images()->where('is_primary', true)->first();
        return $primaryImage ? $primaryImage->image_path : 'default.jpg';
    }

    public function getFormattedHargaAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function sizes()
    {
        return $this->hasMany(ProductSize::class);
    }

    public function getStockForSize($size)
    {
        $sizeRecord = $this->sizes()->where('size', $size)->first();
        return $sizeRecord ? $sizeRecord->stock : 0;
    }

    public function getAvailableSizes()
    {
        return $this->sizes()
            ->where('stock', '>', 0)
            ->pluck('size')
            ->toArray();
    }
}
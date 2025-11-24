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

    /**
     * Get all reviews for the product.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function discounts()
    {
        return $this->belongsToMany(Discount::class, 'product_discount')->withTimestamps();
    }

 public function getActiveDiscountAttribute()
    {
        $currentDate = Carbon::now('Asia/Jakarta');
        
        return $this->discounts()
            ->where('start_date', '<=', $currentDate)
            ->where('end_date', '>=', $currentDate)
            ->orderBy('percentage', 'desc')
            ->first();
    }

    /**
     * End date dalam format ISO untuk countdown - PERBAIKAN: gunakan timezone
     */
    public function getDiscountEndDateIsoAttribute()
{
    if ($this->has_active_discount && $this->active_discount->end_date) {
        return Carbon::parse($this->active_discount->end_date)
            ->timezone('Asia/Jakarta')
            ->toISOString(true); // true untuk include milliseconds
    }
    return null;
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

    // ============================================
    // REVIEW RELATED METHODS
    // ============================================

    /**
     * Get average rating (override database value with live calculation)
     */
    public function getRatingRataAttribute()
    {
        // Prioritas: gunakan live calculation jika ada reviews
        $liveRating = $this->reviews()->avg('rating');
        
        if ($liveRating !== null) {
            return round($liveRating, 1);
        }
        
        // Fallback ke database value
        return $this->attributes['rating_rata'] ?? 0;
    }

    /**
     * Get total reviews count (override database value with live calculation)
     */
    public function getTotalReviewsAttribute()
    {
        // Prioritas: gunakan live count jika ada reviews
        $liveCount = $this->reviews()->count();
        
        if ($liveCount > 0) {
            return $liveCount;
        }
        
        // Fallback ke database value
        return $this->attributes['total_reviews'] ?? 0;
    }

    /**
     * Get rating distribution for all star levels
     *
     * @return array
     */
    public function getRatingDistribution()
    {
        $distribution = [];
        
        for ($i = 1; $i <= 5; $i++) {
            $distribution[$i] = $this->reviews()
                ->where('rating', $i)
                ->count();
        }
        
        return $distribution;
    }

    /**
     * Get percentage of reviews for each rating
     *
     * @return array
     */
    public function getRatingPercentages()
    {
        $total = $this->total_reviews;
        
        if ($total == 0) {
            return array_fill(1, 5, 0);
        }
        
        $distribution = $this->getRatingDistribution();
        $percentages = [];
        
        foreach ($distribution as $rating => $count) {
            $percentages[$rating] = round(($count / $total) * 100, 1);
        }
        
        return $percentages;
    }

    /**
     * Scope: Load products with review statistics
     */
    public function scopeWithReviewStats($query)
    {
        return $query->withCount('reviews')
                     ->withAvg('reviews', 'rating');
    }

    /**
     * Update product rating statistics
     * Call this method after a review is added/updated/deleted
     */
    public function updateRatingStats()
    {
        $this->rating_rata = $this->reviews()->avg('rating') ?? 0;
        $this->total_reviews = $this->reviews()->count();
        $this->save();
    }

    /**
     * Get verified reviews only
     */
    public function verifiedReviews()
    {
        return $this->reviews()->where('is_verified', true);
    }

    /**
     * Get reviews with images
     */
    public function reviewsWithImages()
    {
        return $this->reviews()->whereNotNull('images');
    }

    /**
     * Get recent reviews (last 30 days)
     */
    public function recentReviews($days = 30)
    {
        return $this->reviews()
            ->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Check if product has reviews
     *
     * @return bool
     */
    public function hasReviews()
    {
        return $this->reviews()->exists();
    }

    /**
     * Get average rating formatted
     *
     * @return string
     */
    public function getFormattedRatingAttribute()
    {
        return number_format($this->rating_rata, 1);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'percentage',
        'start_date',
        'end_date',
        'banner_image',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    // ========================================
    // RELATIONSHIPS
    // ========================================
    
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_discount')->withTimestamps();
    }

    // ========================================
    // SCOPES - Query Filters
    // ========================================
    
    /**
     * Scope untuk mendapatkan discount yang aktif (real-time check)
     */
    public function scopeActive($query)
    {
        return $query->where('start_date', '<=', Carbon::now())
                     ->where('end_date', '>=', Carbon::now());
    }

    /**
     * Scope untuk mendapatkan discount yang akan datang
     */
    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>', Carbon::now());
    }

    /**
     * Scope untuk mendapatkan discount yang sudah expired
     */
    public function scopeExpired($query)
    {
        return $query->where('end_date', '<', Carbon::now());
    }

    // ========================================
    // ACCESSORS - Computed Attributes
    // ========================================
    
    /**
     * Cek apakah discount masih valid (real-time)
     * Usage: $discount->is_valid
     */
    public function getIsValidAttribute()
    {
        $now = Carbon::now();
        return $now->between($this->start_date, $this->end_date);
    }

    /**
     * Mendapatkan status discount (upcoming/active/expired)
     * Usage: $discount->status
     */
    public function getStatusAttribute()
    {
        $now = Carbon::now();
        
        if ($now->lt($this->start_date)) {
            return 'upcoming';
        } elseif ($now->between($this->start_date, $this->end_date)) {
            return 'active';
        } else {
            return 'expired';
        }
    }

    /**
     * Mendapatkan sisa waktu dalam detik
     * Usage: $discount->time_remaining
     */
    public function getTimeRemainingAttribute()
    {
        if (!$this->is_valid) {
            return 0;
        }
        
        return Carbon::now()->diffInSeconds($this->end_date, false);
    }

    /**
     * Mendapatkan data countdown untuk timer
     * Usage: $discount->countdown_data
     */
    public function getCountdownDataAttribute()
    {
        $now = Carbon::now();
        
        if (!$this->is_valid) {
            return null;
        }

        $diff = $now->diff($this->end_date);
        
        return [
            'days' => $diff->d,
            'hours' => $diff->h,
            'minutes' => $diff->i,
            'seconds' => $diff->s,
            'total_seconds' => $now->diffInSeconds($this->end_date),
            'end_date_iso' => $this->end_date->toIso8601String(),
        ];
    }

    /**
     * Format percentage dengan simbol %
     * Usage: $discount->formatted_discount
     */
    public function getFormattedDiscountAttribute()
    {
        return $this->percentage . '%';
    }

    /**
     * Mendapatkan formatted start date
     * Usage: $discount->formatted_start_date
     */
    public function getFormattedStartDateAttribute()
    {
        return $this->start_date->format('d M Y H:i');
    }

    /**
     * Mendapatkan formatted end date
     * Usage: $discount->formatted_end_date
     */
    public function getFormattedEndDateAttribute()
    {
        return $this->end_date->format('d M Y H:i');
    }

    /**
     * Mendapatkan durasi discount dalam hari
     * Usage: $discount->duration_days
     */
    public function getDurationDaysAttribute()
    {
        return $this->start_date->diffInDays($this->end_date);
    }

    /**
     * Cek apakah discount akan expired dalam 24 jam
     * Usage: $discount->is_expiring_soon
     */
    public function getIsExpiringSoonAttribute()
    {
        if (!$this->is_valid) {
            return false;
        }
        
        return Carbon::now()->diffInHours($this->end_date) <= 24;
    }

    // ========================================
    // STATIC METHODS - Helper Functions
    // ========================================
    
    /**
     * Mendapatkan discount yang sedang aktif pertama
     */
    public static function getCurrentDiscount()
    {
        return self::active()->first();
    }

    /**
     * Mendapatkan semua discount yang aktif
     */
    public static function getAllActiveDiscounts()
    {
        return self::active()->with('products')->get();
    }

    /**
     * Mendapatkan banner discount yang aktif
     */
    public static function getActiveBanner()
    {
        return self::active()
            ->whereNotNull('banner_image')
            ->orderBy('created_at', 'desc')
            ->first();
    }

    /**
     * Mendapatkan discount aktif untuk produk tertentu
     */
    public static function getActiveDiscountsForProducts($productIds)
    {
        if ($productIds instanceof \Illuminate\Support\Collection) {
            $productIds = $productIds->pluck('id')->toArray();
        }

        return self::active()
            ->whereHas('products', function($query) use ($productIds) {
                $query->whereIn('products.id', $productIds);
            })
            ->with('products')
            ->get();
    }

    /**
     * Cek apakah produk memiliki discount aktif
     */
    public static function hasActiveDiscountForProduct($productId)
    {
        return self::active()
            ->whereHas('products', function($query) use ($productId) {
                $query->where('products.id', $productId);
            })
            ->exists();
    }

    /**
     * Mendapatkan discount aktif untuk produk spesifik
     */
    public static function getActiveDiscountForProduct($productId)
    {
        return self::active()
            ->whereHas('products', function($query) use ($productId) {
                $query->where('products.id', $productId);
            })
            ->first();
    }

    // ========================================
    // INSTANCE METHODS
    // ========================================
    
    /**
     * Cek apakah discount berlaku untuk produk tertentu
     */
    public function appliesTo($productId)
    {
        return $this->products()->where('products.id', $productId)->exists();
    }

    /**
     * Hitung harga setelah discount
     */
    public function calculateDiscountedPrice($originalPrice)
    {
        $discountAmount = ($originalPrice * $this->percentage) / 100;
        return $originalPrice - $discountAmount;
    }

    /**
     * Mendapatkan jumlah hemat
     */
    public function calculateSavings($originalPrice)
    {
        return ($originalPrice * $this->percentage) / 100;
    }

    /**
     * Cek apakah discount sudah dimulai
     */
    public function hasStarted()
    {
        return Carbon::now()->gte($this->start_date);
    }

    /**
     * Cek apakah discount sudah berakhir
     */
    public function hasEnded()
    {
        return Carbon::now()->gt($this->end_date);
    }

    /**
     * Mendapatkan waktu hingga discount dimulai (dalam detik)
     */
    public function timeUntilStart()
    {
        if ($this->hasStarted()) {
            return 0;
        }
        
        return Carbon::now()->diffInSeconds($this->start_date);
    }
}
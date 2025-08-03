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
        'fixed_amount',
        'type',
        'start_date',
        'end_date',
        'is_active',
        'banner_color',
        'text_color'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'fixed_amount' => 'decimal:2'
    ];

    // Scope untuk diskon aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now());
    }

    // Accessor untuk mendapatkan nilai diskon yang diformat
    public function getFormattedDiscountAttribute()
    {
        if ($this->type === 'percentage') {
            return $this->percentage . '%';
        } else {
            return 'Rp ' . number_format($this->fixed_amount, 0, ',', '.');
        }
    }

    // Check apakah diskon masih berlaku
    public function getIsValidAttribute()
    {
        return $this->is_active && 
               Carbon::parse($this->start_date)->lte(now()) && 
               Carbon::parse($this->end_date)->gte(now());
    }

    // Mendapatkan diskon yang sedang berlaku
    public static function getCurrentDiscount()
    {
        return self::active()->first();
    }
}
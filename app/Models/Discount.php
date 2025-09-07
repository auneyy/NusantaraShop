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

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_discount')->withTimestamps();
    }

    public function scopeActive($query)
    {
        return $query->where('start_date', '<=', now())
                     ->where('end_date', '>=', now());
    }

    public function getIsValidAttribute()
    {
        return Carbon::parse($this->start_date)->lte(now()) &&
               Carbon::parse($this->end_date)->gte(now());
    }

    public function getFormattedDiscountAttribute()
    {
        return $this->percentage . '%';
    }

    public static function getCurrentDiscount()
    {
        return self::active()->first();
    }
}

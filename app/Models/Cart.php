<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'product_id', 
        'size', 
        'kuantitas'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Accessors untuk harga diskon
    public function getProductPriceAttribute()
    {
        return $this->product->discounted_price;
    }

    public function getOriginalPriceAttribute()
    {
        return $this->product->harga;
    }

    public function getHasDiscountAttribute()
    {
        return $this->product->has_active_discount;
    }

    public function getDiscountPercentageAttribute()
    {
        return $this->product->discount_percentage;
    }

    public function getSubtotalAttribute()
    {
        return $this->kuantitas * $this->product_price;
    }

    public function getFormattedProductPriceAttribute()
    {
        return 'Rp ' . number_format($this->product_price, 0, ',', '.');
    }

    public function getFormattedOriginalPriceAttribute()
    {
        return 'Rp ' . number_format($this->original_price, 0, ',', '.');
    }

    public function getFormattedSubtotalAttribute()
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'product_price',
        'original_price', // TAMBAH: harga asli sebelum diskon
        'has_discount',   // TAMBAH: flag apakah ada diskon
        'discount_percentage', // TAMBAH: persentase diskon
        'quantity',
        'size',
        'subtotal',
    ];

    protected $casts = [
        'has_discount' => 'boolean',
        'discount_percentage' => 'decimal:2',
        'product_price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Accessors
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

    public function getSavingsAmountAttribute()
    {
        if ($this->has_discount) {
            return ($this->original_price - $this->product_price) * $this->quantity;
        }
        return 0;
    }

    public function getFormattedSavingsAttribute()
    {
        return 'Rp ' . number_format($this->savings_amount, 0, ',', '.');
    }
}
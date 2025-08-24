<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'image_path',
        'alt_text',
        'is_primary',
        'sort_order'
    ];

    protected $casts = [
        'is_primary' => 'boolean'
    ];

    // Relasi dengan Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Accessor untuk URL gambar lengkap
    public function getImageUrlAttribute()
    {
         return $this->image_path 
        ? Storage::url('product_images/'.$this->image_path) 
        : asset('images/default.jpg');
    }
}
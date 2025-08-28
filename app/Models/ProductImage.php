<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 
        'image_path', 
        'thumbnail_url',
        'file_id',      
        'is_primary', 
        'sort_order'
    ];

    protected $casts = [
        'is_primary' => 'boolean'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getImageUrlAttribute()
    {
        // Access the raw image_path value from the attributes array
        return $this->attributes['image_path'] ?? asset('images/default.jpg');
    }
    
    public function getThumbnailUrlAttribute()
    {
        // Access the raw thumbnail_url value from the attributes array
        // and fall back to the raw image_path if it's not set
        return $this->attributes['thumbnail_url'] ?? $this->attributes['image_path'];
    }
}
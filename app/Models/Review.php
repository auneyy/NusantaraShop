<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'order_id',
        'rating',
        'komentar',
        'images',
        'is_verified'
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'images' => 'array',
    ];

    // ✅ Tambahkan mutator untuk memastikan komentar tidak hanya whitespace
    public function setKomentarAttribute($value)
    {
        $this->attributes['komentar'] = (empty($value) || trim($value) === '') ? null : trim($value);
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Accessors
    public function getImageUrlsAttribute()
    {
        if (empty($this->images)) {
            return [];
        }

        return array_map(function($path) {
            return asset('storage/' . $path);
        }, $this->images);
    }

    public function getFormattedRatingAttribute()
    {
        return number_format($this->rating, 1);
    }

    // ✅ Tambahkan accessor untuk check apakah ada komentar
    public function getHasKomentarAttribute()
    {
        return !empty($this->komentar) && trim($this->komentar) !== '';
    }

    // Scopes
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeByRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    public function scopeWithImages($query)
    {
        return $query->whereNotNull('images');
    }

    // ✅ Scope untuk review dengan komentar
    public function scopeWithKomentar($query)
    {
        return $query->whereNotNull('komentar')->where('komentar', '!=', '');
    }
}

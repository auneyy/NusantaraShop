<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'birth_date', 
        'gender', 'role', 'is_active'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'birth_date' => 'date',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Check if user can review a product
     * Updated to support both 'delivered' and 'diterima' status
     *
     * @param int $productId
     * @return bool
     */
    public function canReviewProduct($productId)
    {
        // Check if user has purchased the product with delivered/diterima status
        $hasPurchased = $this->orders()
            ->whereHas('orderItems', function($query) use ($productId) {
                $query->where('product_id', $productId);
            })
            ->whereIn('status', ['delivered', 'diterima']) // Support both statuses
            ->exists();

        if (!$hasPurchased) {
            return false;
        }

        // Check if user has already reviewed this product
        $alreadyReviewed = $this->reviews()
            ->where('product_id', $productId)
            ->exists();

        return !$alreadyReviewed;
    }

    /**
     * Get order ID for review
     * Updated to support both 'delivered' and 'diterima' status
     *
     * @param int $productId
     * @return int|null
     */
    public function getOrderIdForReview($productId)
    {
        $order = $this->orders()
            ->whereHas('orderItems', function($query) use ($productId) {
                $query->where('product_id', $productId);
            })
            ->whereIn('status', ['delivered', 'diterima']) // Support both statuses
            ->whereDoesntHave('reviews', function($query) use ($productId) {
                $query->where('product_id', $productId)
                      ->where('user_id', $this->id);
            })
            ->latest()
            ->first();

        return $order ? $order->id : null;
    }

    /**
     * Get all products that can be reviewed by this user
     *
     * @return \Illuminate\Support\Collection
     */
    public function getReviewableProducts()
    {
        return $this->orders()
            ->whereIn('status', ['delivered', 'diterima'])
            ->with('orderItems.product')
            ->get()
            ->pluck('orderItems')
            ->flatten()
            ->pluck('product')
            ->unique('id')
            ->filter(function($product) {
                return $this->canReviewProduct($product->id);
            });
    }

    /**
     * Check if user has reviewed a specific product
     *
     * @param int $productId
     * @return bool
     */
    public function hasReviewedProduct($productId)
    {
        return $this->reviews()
            ->where('product_id', $productId)
            ->exists();
    }
}
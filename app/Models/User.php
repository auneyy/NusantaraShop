<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

  // Di User model, tambahkan:
protected $fillable = [
    'name', 'email', 'password', 'phone', 'birth_date', 
    'gender', 'role', 'is_active', 'profile_image', 'address_data'
];

protected $casts = [
    'email_verified_at' => 'datetime',
    'birth_date' => 'date',
    'is_active' => 'boolean',
    'address_data' => 'array', // Cast JSON to array
];

/**
 * Get formatted address from address_data
 */
public function getFormattedAddress()
{
    if (!$this->address_data) {
        return null;
    }

    $address = $this->address_data;
    
    return implode(', ', array_filter([
        $address['address'] ?? null,
        $address['district'] ?? null,
        $address['city_name'] ?? null,
        $address['province_name'] ?? null,
        $address['postal_code'] ?? null
    ]));
}

/**
 * Get address component
 */
public function getAddressComponent($key)
{
    return $this->address_data[$key] ?? null;
}

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
     * Get latest shipping address from orders
     * METHOD BARU UNTUK PROFILE PAGE
     */
    public function getLatestShippingAddress()
    {
        $latestOrder = $this->orders()
            ->whereNotNull('shipping_address')
            ->latest()
            ->first();

        if ($latestOrder) {
            return [
                'address' => $latestOrder->shipping_address,
                'city' => $latestOrder->shipping_city,
                'province' => $latestOrder->shipping_province,
                'district' => $latestOrder->shipping_district,
                'postal_code' => $latestOrder->shipping_postal_code
            ];
        }
        return null;
    }

    /**
     * Get profile image URL
     * METHOD BARU UNTUK MENAMPILKAN FOTO PROFIL
     */
    public function getProfileImageUrl()
    {
        if ($this->profile_image) {
            return asset('storage/' . $this->profile_image);
        }
        return null;
    }

    /**
     * Get initials for avatar placeholder
     * METHOD BARU JIKA TIDAK ADA FOTO PROFIL
     */
    public function getInitials()
    {
        $names = explode(' ', $this->name);
        $initials = '';
        
        if (count($names) >= 2) {
            $initials = strtoupper(substr($names[0], 0, 1) . substr($names[1], 0, 1));
        } else {
            $initials = strtoupper(substr($this->name, 0, 2));
        }
        
        return $initials;
    }

    /**
     * Check if user can review a product
     * Updated to support both 'delivered' and 'diterima' status
     */
    public function canReviewProduct($productId)
    {
        // Check if user has purchased the product with delivered/diterima status
        $hasPurchased = $this->orders()
            ->whereHas('orderItems', function($query) use ($productId) {
                $query->where('product_id', $productId);
            })
            ->whereIn('status', ['delivered', 'diterima'])
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
     */
    public function getOrderIdForReview($productId)
    {
        $order = $this->orders()
            ->whereHas('orderItems', function($query) use ($productId) {
                $query->where('product_id', $productId);
            })
            ->whereIn('status', ['delivered', 'diterima'])
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
     */
    public function hasReviewedProduct($productId)
    {
        return $this->reviews()
            ->where('product_id', $productId)
            ->exists();
    }

    /**
     * Get user's order statistics
     * METHOD BARU UNTUK DASHBOARD PROFILE
     */
    public function getOrderStatistics()
    {
        return [
            'total_orders' => $this->orders()->count(),
            'pending_orders' => $this->orders()->where('status', 'pending')->count(),
            'processing_orders' => $this->orders()->where('status', 'processing')->count(),
            'delivered_orders' => $this->orders()->whereIn('status', ['delivered', 'diterima'])->count(),
            'cancelled_orders' => $this->orders()->where('status', 'cancelled')->count(),
        ];
    }

    /**
     * Get recent orders for profile page
     * METHOD BARU UNTUK PROFIL PAGE
     */
    public function getRecentOrders($limit = 5)
    {
        return $this->orders()
            ->with(['orderItems.product.images'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
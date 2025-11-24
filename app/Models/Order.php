<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'total_amount',
        'shipping_cost',
        'grand_total',
        'payment_method',
        'payment_status',
        'snap_token',
        'midtrans_transaction_id',
        'midtrans_payment_type',
        'payment_completed_at',
        'shipping_name',
        'shipping_phone',
        'shipping_email',
        'shipping_address',
        'shipping_province',
        'shipping_city',
        'shipping_district',
        'shipping_postal_code',
        'courier_name',
        'courier_service',
        'notes',
        'order_date',
        'shipped_date',
        'delivered_date',
        'delivered_at', // Tambahkan ini
    ];

    // Dan di casts
    protected $casts = [
        'order_date' => 'datetime',
        'shipped_date' => 'datetime',
        'delivered_date' => 'datetime',
        'delivered_at' => 'datetime', // Tambahkan ini
        'payment_completed_at' => 'datetime',
        'tracking_history' => 'array',
        'estimated_delivery' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Accessors
    public function getStatusLabelAttribute()
{
    $labels = [
        'pending' => 'Menunggu Pembayaran',
        'processing' => 'Diproses',
        'shipped' => 'Dikirim',
        'dikirim' => 'Dikirim',  // Tambahkan ini
        'delivered' => 'Diterima',
        'diterima' => 'Diterima', // Tambahkan ini
        'cancelled' => 'Dibatalkan',
    ];

    return $labels[$this->status] ?? 'Unknown';
}

   public function getPaymentStatusLabelAttribute()
{
    $labels = [
        'pending' => 'Menunggu Pembayaran',
        'paid' => 'Sudah Dibayar',
        'failed' => 'Pembayaran Gagal',
        'settlement' => 'Pembayaran Berhasil',
        'capture' => 'Pembayaran Berhasil',
        'deny' => 'Pembayaran Ditolak',
        'cancel' => 'Pembayaran Dibatalkan',
        'cancelled' => 'Pembayaran Dibatalkan',
        'expire' => 'Pembayaran Kadaluarsa',
        'failure' => 'Pembayaran Gagal',
        'challenge' => 'Pembayaran Dalam Review',
    ];

    // Debug untuk cek apa yang terjadi
    if (!array_key_exists($this->payment_status, $labels)) {
        Log::warning('Unknown payment_status detected in accessor', [
            'order_number' => $this->order_number ?? 'N/A',
            'payment_status' => $this->payment_status,
            'available_labels' => array_keys($labels)
        ]);
    }

    return $labels[$this->payment_status] ?? 'Unknown';
}

    public function getPaymentMethodLabelAttribute()
    {
        $labels = [
            'bank_transfer' => 'Transfer Bank',
            'cod' => 'Cash on Delivery (COD)',
            'ewallet' => 'E-Wallet',
            'midtrans' => 'Midtrans Payment Gateway',
        ];

        return $labels[$this->payment_method] ?? 'Unknown';
    }

    // Helper methods
    public function isPaymentSuccessful()
    {
        return in_array($this->payment_status, ['paid', 'settlement', 'capture']);
    }

    public function isPaymentPending()
    {
        return $this->payment_status === 'pending';
    }

    public function isPaymentFailed()
    {
        return in_array($this->payment_status, ['failed', 'deny', 'cancel', 'expire', 'failure']);
    }

    public function isMidtransPayment()
    {
        return $this->payment_method === 'midtrans';
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopePaymentSuccessful($query)
    {
        return $query->whereIn('payment_status', ['paid', 'settlement', 'capture']);
    }

    public function scopePaymentPending($query)
    {
        return $query->where('payment_status', 'pending');
    }

    public function scopeMidtransOrders($query)
    {
        return $query->where('payment_method', 'midtrans');
    }

    public function reviews()
{
    return $this->hasMany(Review::class);
}
}

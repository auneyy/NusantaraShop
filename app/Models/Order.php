<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'snap_token', // Field tambahan untuk Midtrans
        'midtrans_transaction_id', // Field tambahan untuk Midtrans
        'midtrans_payment_type', // Field tambahan untuk Midtrans
        'payment_completed_at', // Field tambahan untuk Midtrans
        'shipping_name',
        'shipping_phone',
        'shipping_email',
        'shipping_address',
        'shipping_city',
        'shipping_postal_code',
        'notes',
        'order_date',
        'shipped_date',
        'delivered_date',
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'shipped_date' => 'datetime',
        'delivered_date' => 'datetime',
        'payment_completed_at' => 'datetime', // Cast tambahan untuk Midtrans
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

    // Accessors - tetap kompatibel dengan enum lama
    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Menunggu Pembayaran',
            'processing' => 'Diproses',
            'shipped' => 'Dikirim',
            'delivered' => 'Diterima',
            'cancelled' => 'Dibatalkan',
        ];

        return $labels[$this->status] ?? 'Unknown';
    }

    public function getPaymentStatusLabelAttribute()
    {
        $labels = [
            // Status lama (tetap support)
            'pending' => 'Menunggu Pembayaran',
            'paid' => 'Sudah Dibayar',
            'failed' => 'Pembayaran Gagal',
            
            // Status baru untuk Midtrans (jika diperlukan)
            'settlement' => 'Pembayaran Berhasil',
            'capture' => 'Pembayaran Berhasil',
            'deny' => 'Pembayaran Ditolak',
            'cancel' => 'Pembayaran Dibatalkan',
            'expire' => 'Pembayaran Kadaluarsa',
            'failure' => 'Pembayaran Gagal',
            'challenge' => 'Pembayaran Dalam Review',
        ];

        return $labels[$this->payment_status] ?? 'Unknown';
    }

    public function getPaymentMethodLabelAttribute()
    {
        $labels = [
            'bank_transfer' => 'Transfer Bank',
            'cod' => 'Cash on Delivery (COD)',
            'ewallet' => 'E-Wallet',
            'midtrans' => 'Midtrans Payment Gateway', // Tambahan untuk Midtrans
        ];

        return $labels[$this->payment_method] ?? 'Unknown';
    }

    // Helper methods untuk status pembayaran
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
}
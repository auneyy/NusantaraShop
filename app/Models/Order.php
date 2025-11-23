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
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'shipped_date' => 'datetime',
        'delivered_date' => 'datetime',
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
            'delivered' => 'Diterima',
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
        \Log::warning('Unknown payment_status detected in accessor', [
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

// Tambah constant untuk tracking status
const TRACKING_STATUSES = [
    'pending' => 'Menunggu Konfirmasi',
    'confirmed' => 'Pesanan Dikonfirmasi',
    'processing' => 'Pesanan Diproses', 
    'packed' => 'Pesanan Dikemas',
    'shipped' => 'Pesanan Dikirim',
    'in_transit' => 'Dalam Perjalanan',
    'out_for_delivery' => 'Sedang Diantar',
    'delivered' => 'Pesanan Diterima'
];

// Methods untuk tracking
public function getTrackingStatusLabelAttribute()
{
    return self::TRACKING_STATUSES[$this->current_tracking_status] ?? 'Unknown';
}

public function addTrackingHistory($status, $location, $description)
{
    $history = $this->tracking_history ?? [];
    
    $history[] = [
        'status' => $status,
        'location' => $location,
        'description' => $description,
        'timestamp' => now()->toDateTimeString()
    ];
    
    $this->update([
        'tracking_history' => $history,
        'current_tracking_status' => $status
    ]);
}

public function generateTrackingTimeline()
{
    $orderDate = $this->order_date;
    $destinationCity = $this->shipping_city;
    $courier = $this->courier_name;
    
    // Tentukan zona berdasarkan kota tujuan
    $zone = $this->getShippingZone($destinationCity);
    $estimatedDays = $this->getEstimatedDays($zone);
    
    // Generate timeline berdasarkan estimasi
    $timeline = [];
    
    // 1. Order Placed
    $timeline[] = [
        'status' => 'pending',
        'location' => 'System',
        'description' => 'Pesanan diterima dan menunggu konfirmasi',
        'timestamp' => $orderDate->toDateTimeString()
    ];
    
    // 2. Confirmed (1 jam setelah order)
    $confirmedTime = $orderDate->copy()->addHour();
    $timeline[] = [
        'status' => 'confirmed', 
        'location' => 'Jakarta',
        'description' => 'Pesanan dikonfirmasi dan sedang dipersiapkan',
        'timestamp' => $confirmedTime->toDateTimeString()
    ];
    
    // 3. Processing (3 jam setelah konfirmasi)
    $processingTime = $confirmedTime->copy()->addHours(3);
    $timeline[] = [
        'status' => 'processing',
        'location' => 'Jakarta', 
        'description' => 'Pesanan sedang diproses',
        'timestamp' => $processingTime->toDateTimeString()
    ];
    
    // 4. Packed (6 jam setelah processing)
    $packedTime = $processingTime->copy()->addHours(6);
    $timeline[] = [
        'status' => 'packed',
        'location' => 'Jakarta',
        'description' => 'Pesanan telah dikemas dan siap dikirim',
        'timestamp' => $packedTime->toDateTimeString()
    ];
    
    // 5. Shipped (hari berikutnya)
    $shippedTime = $packedTime->copy()->addDay();
    $timeline[] = [
        'status' => 'shipped',
        'location' => 'Jakarta',
        'description' => "Pesanan dikirim via {$courier} menuju {$destinationCity}",
        'timestamp' => $shippedTime->toDateTimeString()
    ];
    
    // 6. In Transit (berdasarkan estimasi zona)
    $transitTime = $shippedTime->copy()->addDays(ceil($estimatedDays * 0.6));
    $timeline[] = [
        'status' => 'in_transit',
        'location' => 'Dalam Perjalanan',
        'description' => "Pesanan dalam perjalanan ke {$destinationCity}",
        'timestamp' => $transitTime->toDateTimeString()
    ];
    
    // 7. Out for Delivery (hari H-1)
    $deliveryTime = $shippedTime->copy()->addDays($estimatedDays - 1);
    $timeline[] = [
        'status' => 'out_for_delivery',
        'location' => $destinationCity,
        'description' => 'Pesanan sedang diantar kurir',
        'timestamp' => $deliveryTime->toDateTimeString()
    ];
    
    // 8. Delivered (hari H)
    $deliveredTime = $shippedTime->copy()->addDays($estimatedDays);
    $timeline[] = [
        'status' => 'delivered',
        'location' => $this->shipping_address,
        'description' => 'Pesanan telah diterima',
        'timestamp' => $deliveredTime->toDateTimeString()
    ];
    
    // Simpan timeline dan estimasi
    $this->update([
        'tracking_history' => $timeline,
        'current_tracking_status' => 'pending',
        'estimated_delivery' => $deliveredTime
    ]);
    
    return $timeline;
}

// Helper method untuk tentukan zona
private function getShippingZone($city)
{
    $zones = [
        'JABODETABEK' => ['Jakarta', 'Bogor', 'Depok', 'Tangerang', 'Bekasi', 'South Tangerang'],
        'JAWA_BARAT' => ['Bandung', 'Cimahi', 'Cirebon', 'Sukabumi', 'Tasikmalaya', 'Banjar'],
        'JAWA_TENGAH' => ['Semarang', 'Surakarta', 'Magelang', 'Pekalongan', 'Salatiga', 'Tegal'],
        'JAWA_TIMUR' => ['Surabaya', 'Malang', 'Sidoarjo', 'Mojokerto', 'Jember', 'Banyuwangi'],
        'BALI' => ['Denpasar', 'Badung', 'Gianyar', 'Tabanan'],
        'SUMATRA' => ['Medan', 'Palembang', 'Padang', 'Pekanbaru', 'Bandar Lampung'],
        'KALIMANTAN' => ['Pontianak', 'Balikpapan', 'Samarinda', 'Banjarmasin'],
        'SULAWESI' => ['Makassar', 'Manado', 'Palu', 'Kendari'],
        'PAPUA' => ['Jayapura', 'Sorong', 'Merauke']
    ];
    
    foreach ($zones as $zone => $cities) {
        foreach ($cities as $zoneCity) {
            if (str_contains(strtolower($city), strtolower($zoneCity))) {
                return $zone;
            }
        }
    }
    
    return 'OTHER';
}

// Helper method untuk estimasi hari
private function getEstimatedDays($zone)
{
    $estimations = [
        'JABODETABEK' => 2,
        'JAWA_BARAT' => 3,
        'JAWA_TENGAH' => 3,
        'JAWA_TIMUR' => 4,
        'BALI' => 5,
        'SUMATRA' => 4,
        'KALIMANTAN' => 5,
        'SULAWESI' => 6,
        'PAPUA' => 7,
        'OTHER' => 5
    ];
    
    return $estimations[$zone] ?? 5;
}
}
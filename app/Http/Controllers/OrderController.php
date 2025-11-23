<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of user's orders.
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
                      ->with(['orderItems.product.images'])
                      ->orderBy('created_at', 'desc')
                      ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
                     ->where('user_id', Auth::id())
                     ->with(['orderItems.product.images'])
                     ->firstOrFail();

        // Check if we need to generate a new snap token for pending Midtrans payments
        $snapToken = null;
        if ($this->isPaymentPending($order) && $order->payment_method === 'midtrans') {
            try {
                $snapToken = $this->createMidtransTransaction($order);
                if ($snapToken) {
                    $order->update(['midtrans_snap_token' => $snapToken]);
                }
            } catch (\Exception $e) {
                Log::error('Failed to generate snap token for order view', [
                    'order_number' => $order->order_number,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return view('orders.show', compact('order', 'snapToken'));
    }

    /**
     * Cancel an order (supports both web and AJAX requests)
     */
    public function cancel(Request $request, $orderNumber)
    {
        try {
            DB::beginTransaction();

            $order = Order::where('order_number', $orderNumber)
                         ->where('user_id', Auth::id())
                         ->first();

            if (!$order) {
                $message = 'Pesanan tidak ditemukan.';
                
                if ($request->ajax() || $request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => $message
                    ], 404);
                }
                
                return redirect()->route('orders.index')->with('error', $message);
            }

            // Only allow cancellation if payment is pending
            if (!$this->isPaymentPending($order)) {
                $message = 'Pesanan tidak dapat dibatalkan karena pembayaran sudah diproses.';
                
                if ($request->ajax() || $request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => $message
                    ], 400);
                }
                
                return redirect()->route('orders.show', $orderNumber)->with('error', $message);
            }

            // Update order status
            $order->update([
                'status' => 'cancelled',
                'payment_status' => 'cancelled', // Changed from 'cancel' to 'cancelled'
                'cancelled_at' => now(),
                'cancelled_reason' => 'Dibatalkan oleh pelanggan'
            ]);

            // Restore stock
            $this->restoreStock($order);

            // Cancel Midtrans transaction if exists
            if ($order->payment_method === 'midtrans' && $order->midtrans_snap_token) {
                try {
                    \Midtrans\Config::$serverKey = config('midtrans.server_key');
                    \Midtrans\Config::$isProduction = config('midtrans.is_production', false);
                    
                    \Midtrans\Transaction::cancel($order->order_number);
                } catch (\Exception $e) {
                    Log::warning('Failed to cancel Midtrans transaction: ' . $e->getMessage());
                }
            }

            DB::commit();

            $message = 'Pesanan berhasil dibatalkan dan stok produk telah dikembalikan.';

            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'order' => [
                        'id' => $order->id,
                        'order_number' => $order->order_number,
                        'status' => $order->status,
                        'payment_status' => $order->payment_status
                    ]
                ]);
            }

            return redirect()->route('orders.index')->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Order cancellation failed', [
                'order_number' => $orderNumber,
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            $message = 'Terjadi kesalahan saat membatalkan pesanan. Silakan coba lagi.';

            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $message
                ], 500);
            }

            return redirect()->route('orders.index')->with('error', $message);
        }
    }

    /**
     * Helper method to check if payment is pending
     */
    private function isPaymentPending($order)
    {
        return !isset($order->payment_status) || 
               $order->payment_status === 'pending' ||
               $order->payment_status === null;
    }

    /**
     * Restore product stock when order is cancelled
     */
    private function restoreStock($order)
    {
        try {
            foreach ($order->orderItems as $item) {
                $product = \App\Models\Product::find($item->product_id);
                if ($product) {
                    $product->increment('stock_kuantitas', $item->quantity);
                    
                    Log::info('Stock restored', [
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'quantity_restored' => $item->quantity,
                        'new_stock' => $product->fresh()->stock_kuantitas
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error('Error restoring stock', [
                'order_number' => $order->order_number,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
 * Create Midtrans transaction
 */
private function createMidtransTransaction($order)
{
    try {
        // Validate Midtrans configuration
        $serverKey = config('midtrans.server_key');
        $clientKey = config('midtrans.client_key');
        
        if (!$serverKey || !$clientKey) {
            throw new \Exception('Midtrans configuration is incomplete.');
        }

        // Format phone number
        $phone = $order->shipping_phone;
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (substr($phone, 0, 1) === '1') {
            $phone = '628' . substr($phone, 1);
        } elseif (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        } elseif (strlen($phone) < 10) {
            $phone = '628123456789';
        }

        // Set Midtrans configuration
        \Midtrans\Config::$serverKey = $serverKey;
        \Midtrans\Config::$isProduction = config('midtrans.is_production', false);
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        // Calculate item total
        $itemTotal = 0;
        $itemDetails = [];

        // Add product items
        foreach ($order->orderItems as $item) {
            $itemPrice = (int) $item->product_price;
            $itemQuantity = (int) $item->quantity;
            
            $itemName = substr($item->product_name . ' (' . $item->size . ')', 0, 50);
            
            $itemDetails[] = [
                'id' => 'item_' . $item->product_id . '_' . $item->size,
                'price' => $itemPrice,
                'quantity' => $itemQuantity,
                'name' => $itemName,
            ];
            
            $itemTotal += $itemPrice * $itemQuantity;
        }

        // Add shipping cost
        $shippingCost = (int) $order->shipping_cost;
        if ($shippingCost > 0) {
            $itemDetails[] = [
                'id' => 'shipping',
                'price' => $shippingCost,
                'quantity' => 1,
                'name' => 'Ongkos Kirim',
            ];
            $itemTotal += $shippingCost;
        }

        // Validate total amount
        if ($itemTotal !== (int) $order->grand_total) {
            \Log::warning('Grand total mismatch, using calculated total', [
                'order_total' => $order->grand_total,
                'calculated_total' => $itemTotal
            ]);
        }

        $params = [
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => $itemTotal,
            ],
            'customer_details' => [
                'first_name' => $order->shipping_name,
                'email' => $order->shipping_email,
                'phone' => $phone,
            ],
            'item_details' => $itemDetails,
            'enabled_payments' => [
                'gopay', 'shopeepay', 'credit_card', 
                'bca_va', 'bni_va', 'bri_va', 'permata_va',
                'indomaret', 'alfamart',
            ],
            'expiry' => [
                'start_time' => date("Y-m-d H:i:s O"),
                'unit' => 'hours',
                'duration' => 24
            ]
        ];

        \Log::info('Midtrans Request Params', [
            'order_id' => $order->order_number,
            'gross_amount' => $itemTotal,
            'item_count' => count($itemDetails)
        ]);

        return \Midtrans\Snap::getSnapToken($params);

    } catch (\Exception $e) {
        Log::error('Midtrans transaction creation failed', [
            'order_number' => $order->order_number ?? 'unknown',
            'error_message' => $e->getMessage()
        ]);
        
        throw new \Exception('Gagal membuat transaksi pembayaran: ' . $e->getMessage());
    }
}

/**
 * Check payment status for an order - FIXED VERSION
 */
public function checkPaymentStatus($orderNumber)
{
    try {
        $order = Order::where('order_number', $orderNumber)
                     ->where('user_id', Auth::id())
                     ->first();
        
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        // ✅ JANGAN CHECK MIDTRANS JIKA SUDAH SUCCESS
        if (in_array($order->payment_status, ['settlement', 'paid', 'success'])) {
            return response()->json([
                'success' => true,
                'status' => $order->payment_status,
                'order_status' => $order->status,
                'payment_method' => $order->payment_method,
                'message' => 'Payment already completed'
            ]);
        }

        // Only check Midtrans for pending/failed payments
        if ($order->payment_method === 'midtrans' && $order->midtrans_transaction_id) {
            try {
                \Midtrans\Config::$serverKey = config('midtrans.server_key');
                \Midtrans\Config::$isProduction = config('midtrans.is_production', false);
                
                $status = \Midtrans\Transaction::status($order->order_number);
                
                Log::info('Midtrans status check', [
                    'order_number' => $order->order_number,
                    'current_db_status' => $order->payment_status,
                    'midtrans_status' => $status->transaction_status
                ]);
                
                // ✅ ONLY update if Midtrans status is more advanced than current status
                if ($this->shouldUpdateStatus($order->payment_status, $status->transaction_status)) {
                    // Panggil method dari CheckoutController atau proses manual
                    $this->updateOrderStatusFromMidtrans($order, $status);
                    $order->refresh();
                }
                
            } catch (\Exception $e) {
                Log::error('Error checking Midtrans status', [
                    'order_number' => $order->order_number,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'status' => $order->payment_status,
            'order_status' => $order->status,
            'payment_method' => $order->payment_method,
            'transaction_id' => $order->midtrans_transaction_id,
            'updated_at' => $order->updated_at->toISOString()
        ]);

    } catch (\Exception $e) {
        Log::error('Check payment status error', [
            'order_number' => $orderNumber,
            'user_id' => Auth::id(),
            'error' => $e->getMessage()
        ]);
        
        return response()->json(['error' => 'Internal server error'], 500);
    }
}

/**
 * Helper: Check if we should update status (prevent downgrading)
 */
private function shouldUpdateStatus($currentStatus, $newStatus)
{
    $statusHierarchy = [
        'pending' => 1,
        'capture' => 2, 
        'settlement' => 3,
        'success' => 3,
        'paid' => 3
    ];
    
    $currentLevel = $statusHierarchy[$currentStatus] ?? 0;
    $newLevel = $statusHierarchy[$newStatus] ?? 0;
    
    // Only update if new status is higher level
    return $newLevel > $currentLevel;
}

/**
 * Helper: Update order status from Midtrans response
 */
private function updateOrderStatusFromMidtrans($order, $status)
{
    $transactionStatus = $status->transaction_status;
    $paymentType = $status->payment_type ?? $order->midtrans_payment_type;
    $fraudStatus = $status->fraud_status ?? 'accept';
    $transactionId = $status->transaction_id ?? $order->midtrans_transaction_id;

    $updateData = [
        'midtrans_transaction_id' => $transactionId,
        'midtrans_payment_type' => $paymentType,
        'updated_at' => now()
    ];

    switch ($transactionStatus) {
        case 'capture':
        case 'settlement':
            $updateData['payment_status'] = 'settlement';
            $updateData['status'] = 'processing';
            $updateData['payment_completed_at'] = now();
            break;
            
        case 'pending':
            // Only update if currently pending
            if ($order->payment_status === 'pending') {
                $updateData['payment_status'] = 'pending';
                $updateData['status'] = 'pending';
            }
            break;
            
        case 'deny':
        case 'expire':
        case 'cancel':
        case 'failure':
            // Only update to failed if currently pending
            if ($order->payment_status === 'pending') {
                $updateData['payment_status'] = 'failed';
                $updateData['status'] = 'cancelled';
                $updateData['cancelled_at'] = now();
            }
            break;
    }

    $order->update($updateData);

    Log::info('Order status updated from checkPaymentStatus', [
        'order_number' => $order->order_number,
        'old_status' => $order->getOriginal('payment_status'),
        'new_status' => $updateData['payment_status']
    ]);
}
}
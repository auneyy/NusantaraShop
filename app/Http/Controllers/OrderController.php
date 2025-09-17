<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
     * Cancel an order (only if payment is pending)
     */
    public function cancel($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
                     ->where('user_id', Auth::id())
                     ->firstOrFail();

        // Only allow cancellation if payment is pending
        if (!$this->isPaymentPending($order)) {
            return redirect()->route('orders.show', $orderNumber)
                           ->with('error', 'Pesanan tidak dapat dibatalkan karena pembayaran sudah diproses.');
        }

        // Update order status
        $order->update([
            'status' => 'cancelled',
            'payment_status' => 'cancel'
        ]);

        // Restore stock
        $this->restoreStock($order);

        return redirect()->route('orders.index')
                        ->with('success', 'Pesanan berhasil dibatalkan dan stok produk telah dikembalikan.');
    }

    /**
     * Check payment status for an order
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

            // If using Midtrans, check status from Midtrans API
            if ($order->payment_method === 'midtrans' && $order->midtrans_transaction_id) {
                try {
                    \Midtrans\Config::$serverKey = config('midtrans.server_key');
                    \Midtrans\Config::$isProduction = config('midtrans.is_production', false);
                    
                    $status = \Midtrans\Transaction::status($order->order_number);
                    
                    // Update order if status changed
                    if ($status->transaction_status !== $order->payment_status) {
                        $this->processPaymentNotification(
                            $order, 
                            $status->transaction_status, 
                            $status->payment_type ?? $order->midtrans_payment_type,
                            $status->fraud_status ?? 'accept',
                            $status->transaction_id ?? $order->midtrans_transaction_id
                        );
                        
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
     * Helper methods (copy from CheckoutController)
     */
    private function isPaymentPending($order)
    {
        return !isset($order->payment_status) || 
               $order->payment_status === 'pending' ||
               $order->payment_status === null;
    }

    private function createMidtransTransaction($order)
    {
        try {
            // Validate Midtrans configuration
            $serverKey = config('midtrans.server_key');
            $clientKey = config('midtrans.client_key');
            
            if (!$serverKey || !$clientKey) {
                throw new \Exception('Midtrans configuration is incomplete.');
            }

            // Set Midtrans configuration
            \Midtrans\Config::$serverKey = $serverKey;
            \Midtrans\Config::$isProduction = config('midtrans.is_production', false);
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            // Prepare transaction parameters
            $params = [
                'transaction_details' => [
                    'order_id' => $order->order_number,
                    'gross_amount' => (int) $order->grand_total,
                ],
                'customer_details' => [
                    'first_name' => $order->shipping_name,
                    'email' => $order->shipping_email,
                    'phone' => $order->shipping_phone,
                ],
                'item_details' => [],
                'enabled_payments' => [
                    'credit_card', 'mandiri_clickpay', 'cimb_clicks',
                    'bca_klikbca', 'bca_klikpay', 'bri_epay', 'echannel',
                    'permata_va', 'bca_va', 'bni_va', 'bri_va', 'other_va',
                    'gopay', 'shopeepay', 'indomaret', 'alfamart'
                ],
                'expiry' => [
                    'start_time' => date("Y-m-d H:i:s O"),
                    'unit' => 'hours',
                    'duration' => 24
                ]
            ];

            // Add item details
            foreach ($order->orderItems as $item) {
                $params['item_details'][] = [
                    'id' => 'item_' . $item->product_id . '_' . $item->size,
                    'price' => (int) $item->product_price,
                    'quantity' => (int) $item->quantity,
                    'name' => substr($item->product_name . ' (' . $item->size . ')', 0, 50),
                ];
            }

            // Add shipping cost as separate item
            if ($order->shipping_cost > 0) {
                $params['item_details'][] = [
                    'id' => 'shipping',
                    'price' => (int) $order->shipping_cost,
                    'quantity' => 1,
                    'name' => 'Ongkos Kirim',
                ];
            }

            return \Midtrans\Snap::getSnapToken($params);

        } catch (\Exception $e) {
            Log::error('Midtrans transaction creation failed', [
                'order_number' => $order->order_number ?? 'unknown',
                'error_message' => $e->getMessage()
            ]);
            
            throw new \Exception('Gagal membuat transaksi pembayaran: ' . $e->getMessage());
        }
    }

    private function processPaymentNotification($order, $transactionStatus, $paymentType, $fraudStatus, $transactionId)
    {
        $updateData = [
            'midtrans_transaction_id' => $transactionId,
            'midtrans_payment_type' => $paymentType,
            'updated_at' => now()
        ];

        switch ($transactionStatus) {
            case 'capture':
                if ($paymentType == 'credit_card') {
                    $updateData['payment_status'] = ($fraudStatus == 'challenge') ? 'pending' : 'settlement';
                    $updateData['status'] = ($fraudStatus == 'challenge') ? 'pending' : 'processing';
                    if ($fraudStatus != 'challenge') {
                        $updateData['payment_completed_at'] = now();
                    }
                } else {
                    $updateData['payment_status'] = 'settlement';
                    $updateData['status'] = 'processing';
                    $updateData['payment_completed_at'] = now();
                }
                break;
                
            case 'settlement':
                $updateData['payment_status'] = 'settlement';
                $updateData['status'] = 'processing';
                $updateData['payment_completed_at'] = now();
                break;
                
            case 'pending':
                $updateData['payment_status'] = 'pending';
                $updateData['status'] = 'pending';
                break;
                
            case 'deny':
            case 'expire':
            case 'cancel':
            case 'failure':
                $updateData['payment_status'] = $transactionStatus;
                $updateData['status'] = 'cancelled';
                $this->restoreStock($order);
                break;
        }

        $order->update($updateData);
    }

    private function restoreStock($order)
    {
        try {
            foreach ($order->orderItems as $item) {
                $product = \App\Models\Product::find($item->product_id);
                if ($product) {
                    $product->increment('stock_kuantitas', $item->quantity);
                }
            }
        } catch (\Exception $e) {
            Log::error('Error restoring stock', [
                'order_number' => $order->order_number,
                'error' => $e->getMessage()
            ]);
        }
    }
}
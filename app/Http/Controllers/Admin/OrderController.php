<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user', 'orderItems');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('shipping_name', 'like', "%{$search}%")
                  ->orWhere('shipping_email', 'like', "%{$search}%")
                  ->orWhere('shipping_phone', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->has('payment_status') && $request->payment_status != '') {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter by date range
        if ($request->has('start_date') && $request->start_date != '') {
            $query->whereDate('order_date', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date != '') {
            $query->whereDate('order_date', '<=', $request->end_date);
        }

        $orders = $query->orderBy('order_date', 'desc')
                       ->paginate(10)
                       ->appends($request->except('page'));

        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['orderItems.product', 'user'])->findOrFail($id);
        
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::with('orderItems')->findOrFail($id);
        
        // Jika status sudah cancelled, tidak bisa diubah lagi
        if ($order->status === 'cancelled') {
            return redirect()->back()->with('error', 'Pesanan yang sudah dibatalkan tidak dapat diubah statusnya.');
        }
        
        $validStatuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        
        $request->validate([
            'status' => 'required|in:' . implode(',', $validStatuses)
        ]);
        
        $oldStatus = $order->status;
        $order->status = $request->status;
        
        // ✅ FIX: Hanya update field yang ADA di database
        if ($request->status === 'cancelled') {
            $order->payment_status = 'cancelled'; // ✅ Field ADA
            // ❌ HAPUS: cancelled_at, cancelled_reason (field TIDAK ADA)
            // $order->cancelled_at = now();
            // $order->cancelled_reason = $request->cancelled_reason ?? 'Dibatalkan oleh admin';
            
            // Restore stock
            $this->restoreStock($order);
            
            // Cancel Midtrans transaction jika ada
            if ($order->payment_method === 'midtrans' && $order->midtrans_transaction_id) {
                try {
                    \Midtrans\Config::$serverKey = config('midtrans.server_key');
                    \Midtrans\Config::$isProduction = config('midtrans.is_production', false);
                    
                    \Midtrans\Transaction::cancel($order->order_number);
                    
                    Log::info('Midtrans transaction cancelled by admin', [
                        'order_number' => $order->order_number,
                        'admin_id' => auth()->id()
                    ]);
                } catch (\Exception $e) {
                    Log::warning('Failed to cancel Midtrans transaction: ' . $e->getMessage());
                }
            }
            
            Log::info('Order cancelled by admin', [
                'order_number' => $order->order_number,
                'old_status' => $oldStatus,
                'admin_id' => auth()->id()
            ]);
        }
        
        // Update tanggal terkait berdasarkan status (field yang ADA)
        if ($request->status === 'shipped' && !$order->shipped_date) {
            $order->shipped_date = now(); // ✅ Field ADA
            
            Log::info('Order marked as shipped by admin', [
                'order_number' => $order->order_number,
                'admin_id' => auth()->id()
            ]);
        } 
        
        if ($request->status === 'delivered' && !$order->delivered_date) {
            $order->delivered_date = now(); // ✅ Field ADA
            
            Log::info('Order marked as delivered by admin', [
                'order_number' => $order->order_number,
                'admin_id' => auth()->id()
            ]);
        }
        
        // ❌ HAPUS: Generate tracking (field tracking tidak ada)
        // if ($request->status === 'shipped' && $oldStatus !== 'shipped') {
        //     $order->generateTrackingTimeline();
        // }
        
        $order->save();
        
        return redirect()->route('admin.orders.index')->with('success', 'Status pesanan berhasil diperbarui.');
    }

    /**
     * Restore product stock when order is cancelled
     */
    private function restoreStock($order)
    {
        try {
            foreach ($order->orderItems as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    // Update stock berdasarkan size jika ada, atau global stock
                    if ($item->size) {
                        $sizeRecord = $product->sizes()->where('size', $item->size)->first();
                        if ($sizeRecord) {
                            $sizeRecord->increment('stock', $item->quantity);
                            
                            Log::info('Size stock restored by admin cancellation', [
                                'product_id' => $product->id,
                                'product_name' => $product->name,
                                'size' => $item->size,
                                'quantity_restored' => $item->quantity,
                                'order_number' => $order->order_number
                            ]);
                        }
                    } else {
                        // Fallback ke global stock
                        $product->increment('stock_kuantitas', $item->quantity);
                        
                        Log::info('Global stock restored by admin cancellation', [
                            'product_id' => $product->id,
                            'product_name' => $product->name,
                            'quantity_restored' => $item->quantity,
                            'order_number' => $order->order_number
                        ]);
                    }
                }
            }
            
            Log::info('All stock restored for cancelled order', [
                'order_number' => $order->order_number,
                'items_count' => $order->orderItems->count()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error restoring stock in admin cancellation', [
                'order_number' => $order->order_number,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Update payment status manually
     */
    public function updatePaymentStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $validPaymentStatuses = ['pending', 'paid', 'failed', 'cancelled', 'settlement', 'expire'];
        
        $request->validate([
            'payment_status' => 'required|in:' . implode(',', $validPaymentStatuses)
        ]);
        
        $oldPaymentStatus = $order->payment_status;
        $order->payment_status = $request->payment_status;
        
        // Jika payment berhasil, update order status ke processing
        if (in_array($request->payment_status, ['paid', 'settlement']) && $order->status === 'pending') {
            $order->status = 'processing';
            $order->payment_completed_at = now(); // ✅ Field ADA
        }
        
        // Jika payment failed/cancelled, batalkan order
        if (in_array($request->payment_status, ['failed', 'cancelled', 'expire']) && $order->status !== 'cancelled') {
            $order->status = 'cancelled';
            $order->payment_status = 'cancelled';
            // ❌ HAPUS: cancelled_at, cancelled_reason (field TIDAK ADA)
            // $order->cancelled_at = now();
            // $order->cancelled_reason = 'Pembayaran ' . $request->payment_status;
            
            // Restore stock
            $this->restoreStock($order);
        }
        
        $order->save();
        
        Log::info('Payment status updated by admin', [
            'order_number' => $order->order_number,
            'old_payment_status' => $oldPaymentStatus,
            'new_payment_status' => $request->payment_status,
            'admin_id' => auth()->id()
        ]);
        
        return redirect()->route('admin.orders.show', $order->id)->with('success', 'Status pembayaran berhasil diperbarui.');
    }

    /**
     * Cancel order with reason - ❌ HAPUS METHOD INI (pakai field tidak ada)
     */
    // public function cancelOrder(Request $request, $id)
    // {
    //     // Method ini menggunakan field cancelled_at dan cancelled_reason yang tidak ada
    //     // Gunakan updateStatus() saja
    // }

    public function dashboard()
    {
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('recentOrders'));
    }
}
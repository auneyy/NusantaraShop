<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // Jika ada data dari form "Beli Sekarang"
        if ($request->has('product_id')) {
            $product = Product::with('images', 'discounts')->findOrFail($request->product_id);
            
            // Gunakan harga diskon
            $productPrice = $product->discounted_price;
            $originalPrice = $product->harga;
            $hasDiscount = $product->has_active_discount;
            $discountPercentage = $product->discount_percentage;
            
            $checkoutItems = [
                [
                    'product' => $product,
                    'quantity' => $request->quantity ?? 1,
                    'size' => $request->size ?? 'M',
                    'price' => $productPrice, // harga setelah diskon
                    'original_price' => $originalPrice, // harga asli
                    'has_discount' => $hasDiscount,
                    'discount_percentage' => $discountPercentage,
                    'subtotal' => $productPrice * ($request->quantity ?? 1) // subtotal dengan diskon
                ]
            ];
            
            $total = $checkoutItems[0]['subtotal'];
            // Hitung total berat
            $totalWeight = $product->berat * ($request->quantity ?? 1);
            $source = 'direct';
        } else {
            // Ambil dari keranjang (database)
            $cartItems = $this->getCartItems();
            
            if (empty($cartItems)) {
                return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong.');
            }
            
            $checkoutItems = [];
            $total = 0;
            $totalWeight = 0;
            
            foreach ($cartItems as $key => $item) {
                $checkoutItems[] = [
                    'product' => $item['product'],
                    'quantity' => $item['quantity'],
                    'size' => $item['size'],
                    'price' => $item['price'], // harga setelah diskon
                    'original_price' => $item['original_price'], // harga asli
                    'has_discount' => $item['has_discount'],
                    'discount_percentage' => $item['discount_percentage'],
                    'subtotal' => $item['subtotal'] // subtotal dengan diskon
                ];
                $total += $item['subtotal'];
                $totalWeight += $item['product']->berat * $item['quantity'];
            }
            
            $source = 'cart';
        }

        // Get user data for autofill
        $user = Auth::user();

        return view('checkout.index', compact('checkoutItems', 'total', 'totalWeight', 'source', 'user'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_email' => 'required|email|max:255',
            'shipping_address' => 'required|string',
            'shipping_province' => 'required|string|max:100',
            'shipping_city' => 'required|string|max:100',
            'shipping_district' => 'required|string|max:100',
            'shipping_postal_code' => 'required|string|max:10',
            'courier_service' => 'required|string',
            'courier_name' => 'required|string',
            'shipping_cost' => 'required|numeric|min:0',
            'payment_method' => 'required|in:bank_transfer,cod,ewallet,midtrans',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.size' => 'required|string',
            'total_amount' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        
        try {
            $shippingCost = $request->shipping_cost;
            $grandTotal = $request->total_amount + $shippingCost;

            // Membuat order baru
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => $this->generateOrderNumber(),
                'status' => 'pending',
                'total_amount' => $request->total_amount,
                'shipping_cost' => $shippingCost,
                'grand_total' => $grandTotal,
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'shipping_name' => $request->shipping_name,
                'shipping_phone' => $request->shipping_phone,
                'shipping_email' => $request->shipping_email,
                'shipping_address' => $request->shipping_address,
                'shipping_province' => $request->shipping_province,
                'shipping_city' => $request->shipping_city,
                'shipping_district' => $request->shipping_district,
                'shipping_postal_code' => $request->shipping_postal_code,
                'courier_name' => $request->courier_name,
                'courier_service' => $request->courier_service,
                'notes' => $request->notes,
                'order_date' => now(),
            ]);

            // Membuat order items
            foreach ($request->items as $item) {
                $product = Product::with('discounts')->findOrFail($item['product_id']);
                
              // Cek stok per size
$availableStock = $product->getStockForSize($item['size']);
if ($availableStock < $item['quantity']) {
    throw new \Exception("Stok produk {$product->name} untuk size {$item['size']} tidak mencukupi.");
}

                // Gunakan harga diskon
                $productPrice = $product->discounted_price;
                $originalPrice = $product->harga;
                $hasDiscount = $product->has_active_discount;
                $discountPercentage = $product->discount_percentage;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_price' => $productPrice, // harga setelah diskon
                    'original_price' => $originalPrice, // harga asli
                    'has_discount' => $hasDiscount,
                    'discount_percentage' => $discountPercentage,
                    'quantity' => $item['quantity'],
                    'size' => $item['size'],
                    'subtotal' => $productPrice * $item['quantity'], // subtotal dengan diskon
                ]);

               // Kurangi stok produk per size
$sizeRecord = $product->sizes()->where('size', $item['size'])->first();
if ($sizeRecord) {
    $sizeRecord->decrement('stock', $item['quantity']);
}
            }

            // Jika payment method adalah midtrans, buat snap token
            $snapToken = null;
            if ($request->payment_method === 'midtrans') {
                $snapToken = $this->createMidtransTransaction($order);
                
                // Simpan snap token ke database
                if ($snapToken) {
                    $order->update([
                        'midtrans_transaction_id' => $snapToken,
                        'midtrans_snap_token' => $snapToken
                    ]);
                }
            }

            DB::commit();

            // Jika dari keranjang, hapus keranjang setelah checkout berhasil
            if (!$request->has('direct_buy')) {
                // Hapus dari database cart
                Cart::where('user_id', Auth::id())->delete();
            }

            // Always return JSON for AJAX requests
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'snap_token' => $snapToken,
                    'order_number' => $order->order_number,
                    'payment_method' => $request->payment_method,
                    'redirect_url' => route('orders.show', $order->order_number)
                ]);
            }

            // Fallback for non-AJAX requests - redirect directly to orders
            return redirect()->route('orders.show', $order->order_number)
                            ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran untuk melanjutkan.');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Checkout Error: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'request_data' => $request->except(['_token'])
            ]);
            
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 400);
            }
            
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Enhanced success method with better status handling and redirect options
     */
    public function success(Request $request)
    {
        $orderNumber = $request->get('order');
        $status = $request->get('status', 'pending');
        $redirect = $request->get('redirect', 'success');
        
        if (!$orderNumber) {
            return redirect()->route('home')->with('error', 'Pesanan tidak ditemukan.');
        }

        $order = Order::where('order_number', $orderNumber)
                     ->where('user_id', Auth::id())
                     ->with(['orderItems.product.images'])
                     ->first();

        if (!$order) {
            return redirect()->route('home')->with('error', 'Pesanan tidak ditemukan.');
        }

        // Update payment status if coming from success callback
        if ($status === 'success') {
            $this->updateOrderPaymentStatus($order, 'settlement');
        }

        // If redirect to orders is requested, go to orders page
        if ($redirect === 'orders') {
            return redirect()->route('orders.show', $orderNumber)
                            ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran untuk melanjutkan.');
        }

        // Generate new snap token if payment is still pending and using Midtrans
        $snapToken = null;
        if ($this->isPaymentPending($order) && $order->payment_method === 'midtrans') {
            try {
                $snapToken = $this->createMidtransTransaction($order);
                if ($snapToken) {
                    $order->update(['midtrans_snap_token' => $snapToken]);
                }
            } catch (\Exception $e) {
                Log::error('Failed to generate snap token for existing order', [
                    'order_number' => $order->order_number,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return view('checkout.success', compact('order', 'snapToken'));
    }

    /**
     * Enhanced Midtrans transaction creation
     */
    private function createMidtransTransaction($order)
    {
        try {
            // Validate Midtrans configuration
            $serverKey = config('midtrans.server_key');
            $clientKey = config('midtrans.client_key');
            
            if (!$serverKey || !$clientKey) {
                throw new \Exception('Midtrans configuration is incomplete. Please check server_key and client_key.');
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
                    'billing_address' => [
                        'first_name' => $order->shipping_name,
                        'email' => $order->shipping_email,
                        'phone' => $order->shipping_phone,
                        'address' => substr($order->shipping_address, 0, 200),
                        'city' => $order->shipping_city,
                        'postal_code' => $order->shipping_postal_code,
                        'country_code' => 'IDN'
                    ],
                    'shipping_address' => [
                        'first_name' => $order->shipping_name,
                        'email' => $order->shipping_email,
                        'phone' => $order->shipping_phone,
                        'address' => substr($order->shipping_address, 0, 200),
                        'city' => $order->shipping_city,
                        'postal_code' => $order->shipping_postal_code,
                        'country_code' => 'IDN'
                    ]
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

            // Add item details - gunakan harga diskon dari order items
            foreach ($order->orderItems as $item) {
                $params['item_details'][] = [
                    'id' => 'item_' . $item->product_id . '_' . $item->size,
                    'price' => (int) $item->product_price, // harga setelah diskon
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

            // Validate total amount
            $itemsTotal = array_sum(array_map(function($item) {
                return $item['price'] * $item['quantity'];
            }, $params['item_details']));

            if ($itemsTotal !== (int) $order->grand_total) {
                Log::warning('Items total mismatch', [
                    'order_number' => $order->order_number,
                    'calculated_total' => $itemsTotal,
                    'expected_total' => $order->grand_total
                ]);
            }

            Log::info('Creating Midtrans transaction', [
                'order_number' => $order->order_number,
                'gross_amount' => $order->grand_total,
                'items_count' => count($params['item_details'])
            ]);

            // Create snap token
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            
            Log::info('Midtrans snap token created successfully', [
                'order_number' => $order->order_number,
                'snap_token_preview' => substr($snapToken, 0, 20) . '...'
            ]);

            return $snapToken;

        } catch (\Exception $e) {
            Log::error('Midtrans transaction creation failed', [
                'order_number' => $order->order_number ?? 'unknown',
                'error_message' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString()
            ]);
            
            throw new \Exception('Gagal membuat transaksi pembayaran: ' . $e->getMessage());
        }
    }

    /**
     * Enhanced webhook notification handler - SIMPLIFIED VERSION
     */
    public function midtransNotification(Request $request)
    {
        try {
            $notification = $request->all();
            
            Log::info('Midtrans Notification Received (Raw):', $notification);

            $transactionStatus = $notification['transaction_status'] ?? null;
            $paymentType = $notification['payment_type'] ?? 'unknown';
            $orderId = $notification['order_id'] ?? null;
            $fraudStatus = $notification['fraud_status'] ?? 'accept';
            $transactionId = $notification['transaction_id'] ?? null;

            if (!$orderId || !$transactionStatus) {
                Log::error('Invalid notification data', ['notification' => $notification]);
                return response()->json(['status' => 'error', 'message' => 'Invalid notification data'], 400);
            }

            Log::info('Midtrans notification processed', [
                'order_id' => $orderId,
                'transaction_status' => $transactionStatus,
                'payment_type' => $paymentType,
                'fraud_status' => $fraudStatus,
                'transaction_id' => $transactionId
            ]);

            // Find order
            $order = Order::where('order_number', $orderId)->first();
            
            if (!$order) {
                Log::error('Order not found for notification', ['order_id' => $orderId]);
                return response()->json(['status' => 'error', 'message' => 'Order not found'], 404);
            }

            // Process notification based on transaction status
            $this->processPaymentNotification($order, $transactionStatus, $paymentType, $fraudStatus, $transactionId);

            Log::info('Notification processing completed successfully', [
                'order_number' => $orderId,
                'final_payment_status' => $order->fresh()->payment_status
            ]);

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error('Midtrans notification processing error', [
                'error' => $e->getMessage(),
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Process payment notification and update order
     */
    private function processPaymentNotification($order, $transactionStatus, $paymentType, $fraudStatus, $transactionId)
    {
        $updateData = [
            'midtrans_transaction_id' => $transactionId,
            'midtrans_payment_type' => $paymentType,
            'updated_at' => now()
        ];

        $oldStatus = $order->payment_status;

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
                $updateData['payment_status'] = 'failure';
                $updateData['status'] = 'cancelled';
                $this->restoreStock($order);
                break;
                
            case 'expire':
                $updateData['payment_status'] = 'expire';
                $updateData['status'] = 'cancelled';
                $this->restoreStock($order);
                break;
                
            case 'cancel':
                $updateData['payment_status'] = 'cancel';
                $updateData['status'] = 'cancelled';
                $this->restoreStock($order);
                break;
                
            case 'failure':
                $updateData['payment_status'] = 'failure';
                $updateData['status'] = 'cancelled';
                $this->restoreStock($order);
                break;
                
            default:
                Log::warning('Unknown transaction status received', [
                    'order_number' => $order->order_number,
                    'transaction_status' => $transactionStatus
                ]);
                return;
        }

        // Update order
        $order->update($updateData);

        Log::info('Order updated from Midtrans notification', [
            'order_number' => $order->order_number,
            'old_payment_status' => $oldStatus,
            'new_payment_status' => $updateData['payment_status'],
            'transaction_status' => $transactionStatus
        ]);
    }

    /**
     * Enhanced payment status check with better error handling
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
                    
                    Log::info('Midtrans status check result', [
                        'order_number' => $order->order_number,
                        'current_status' => $order->payment_status,
                        'midtrans_status' => $status->transaction_status
                    ]);
                    
                    // Update order if status changed
                    if ($status->transaction_status !== $order->payment_status) {
                        $this->processPaymentNotification(
                            $order, 
                            $status->transaction_status, 
                            $status->payment_type ?? $order->midtrans_payment_type,
                            $status->fraud_status ?? 'accept',
                            $status->transaction_id ?? $order->midtrans_transaction_id
                        );
                        
                        // Refresh order data
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
     * Helper method to check if payment is pending
     */
    private function isPaymentPending($order)
    {
        return !isset($order->payment_status) || 
               $order->payment_status === 'pending' ||
               $order->payment_status === null;
    }

    /**
     * Helper method to update order payment status
     */
    private function updateOrderPaymentStatus($order, $status)
    {
        $updateData = [
            'payment_status' => $status,
            'updated_at' => now()
        ];

        if (in_array($status, ['settlement', 'capture'])) {
            $updateData['status'] = 'processing';
            $updateData['payment_completed_at'] = now();
        } elseif (in_array($status, ['failure', 'cancel', 'expire', 'deny'])) {
            $updateData['status'] = 'cancelled';
            $this->restoreStock($order);
        }

        $order->update($updateData);

        Log::info('Order payment status updated', [
            'order_number' => $order->order_number,
            'new_status' => $status,
            'order_status' => $updateData['status'] ?? $order->status
        ]);
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
                // Restore stock per size
                $sizeRecord = $product->sizes()->where('size', $item->size)->first();
                if ($sizeRecord) {
                    $sizeRecord->increment('stock', $item->quantity);
                    
                    Log::info('Stock restored', [
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'size' => $item->size,
                        'quantity_restored' => $item->quantity,
                        'new_stock' => $sizeRecord->fresh()->stock
                    ]);
                }
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
     * Helper method untuk mendapatkan cart items dari database
     */
    private function getCartItems()
    {
        $cartItems = [];
        
        $carts = Cart::with(['product.images', 'product.sizes', 'product.discounts'])
            ->where('user_id', Auth::id())
            ->get();

        foreach ($carts as $cart) {
            // Gunakan harga diskon
            $productPrice = $cart->product->discounted_price;
            $originalPrice = $cart->product->harga;
            $hasDiscount = $cart->product->has_active_discount;
            $discountPercentage = $cart->product->discount_percentage;
            
            $cartItems[] = [
                'cart_id' => $cart->id,
                'product' => $cart->product,
                'size' => $cart->size,
                'quantity' => $cart->kuantitas,
                'price' => $productPrice, // harga setelah diskon
                'original_price' => $originalPrice, // harga asli
                'has_discount' => $hasDiscount,
                'discount_percentage' => $discountPercentage,
                'subtotal' => $cart->kuantitas * $productPrice, // subtotal dengan diskon
                'available_stock' => $cart->product->getStockForSize($cart->size)
            ];
        }

        return $cartItems;
    }

    /**
     * Generate unique order number
     */
    private function generateOrderNumber()
    {
        do {
            $prefix = 'ORD';
            $date = now()->format('Ymd');
            $random = strtoupper(Str::random(4));
            $orderNumber = $prefix . $date . $random;
        } while (Order::where('order_number', $orderNumber)->exists());
        
        return $orderNumber;
    }

    /**
     * Handle payment return from Midtrans (for redirect flow)
     */
    public function paymentReturn(Request $request)
    {
        $orderNumber = $request->get('order_id');
        $transactionStatus = $request->get('transaction_status');
        
        if (!$orderNumber) {
            return redirect()->route('home')->with('error', 'Invalid payment return.');
        }

        $order = Order::where('order_number', $orderNumber)
                     ->where('user_id', Auth::id())
                     ->first();

        if (!$order) {
            return redirect()->route('home')->with('error', 'Order not found.');
        }

        // Map transaction status to our success page parameter
        $statusParam = 'pending';
        if (in_array($transactionStatus, ['settlement', 'capture'])) {
            $statusParam = 'success';
        } elseif (in_array($transactionStatus, ['failure', 'cancel', 'expire', 'deny'])) {
            $statusParam = 'failed';
        }

        return redirect()->route('checkout.success', [
            'order' => $orderNumber,
            'status' => $statusParam
        ]);
    }

    /**
     * Manual payment status refresh endpoint
     */
    public function refreshPaymentStatus($orderNumber)
    {
        try {
            $order = Order::where('order_number', $orderNumber)
                         ->where('user_id', Auth::id())
                         ->first();
            
            if (!$order) {
                return response()->json(['error' => 'Order not found'], 404);
            }

            // Force check from Midtrans if applicable
            if ($order->payment_method === 'midtrans') {
                try {
                    \Midtrans\Config::$serverKey = config('midtrans.server_key');
                    \Midtrans\Config::$isProduction = config('midtrans.is_production', false);
                    
                    if (!$order->midtrans_transaction_id) {
                        Log::warning("Tidak bisa cek status. Transaksi Midtrans belum dibuat.", [
                            'order_number' => $order->order_number
                        ]);
                    
                        return response()->json([
                            'status' => $order->payment_status,
                            'message' => 'Transaksi belum dibuat di Midtrans'
                        ], 200);
                    }
                    
                    
                    $status = \Midtrans\Transaction::status($order->order_number);
                    
                    $this->processPaymentNotification(
                        $order,
                        $status->transaction_status,
                        $status->payment_type ?? $order->midtrans_payment_type,
                        $status->fraud_status ?? 'accept',
                        $status->transaction_id ?? $order->midtrans_transaction_id
                    );
                    
                    $order->refresh();
                    
                    Log::info('Manual payment status refresh completed', [
                        'order_number' => $orderNumber,
                        'status' => $status->transaction_status,
                        'updated_payment_status' => $order->payment_status
                    ]);
                    
                } catch (\Exception $e) {
                    Log::error('Manual refresh failed', [
                        'order_number' => $orderNumber,
                        'error' => $e->getMessage()
                    ]);
                    
                    return response()->json([
                        'error' => 'Unable to refresh payment status',
                        'message' => 'Please try again later or contact support'
                    ], 500);
                }
            }

            return response()->json([
                'success' => true,
                'status' => $order->payment_status,
                'order_status' => $order->status,
                'message' => 'Payment status refreshed successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Refresh payment status error', [
                'order_number' => $orderNumber,
                'error' => $e->getMessage()
            ]);
            
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
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
            $product = Product::with('images')->findOrFail($request->product_id);
            
            $checkoutItems = [
                [
                    'product' => $product,
                    'quantity' => $request->quantity ?? 1,
                    'size' => $request->size ?? 'M',
                    'subtotal' => $product->harga * ($request->quantity ?? 1)
                ]
            ];
            
            $total = $checkoutItems[0]['subtotal'];
            $source = 'direct'; // Pembelian langsung
        } else {
            // Jika dari keranjang (implementasi nanti jika ada)
            // Untuk sementara redirect ke home jika tidak ada data
            return redirect()->route('home')->with('error', 'Tidak ada produk untuk checkout.');
        }

        return view('checkout.index', compact('checkoutItems', 'total', 'source'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_email' => 'required|email|max:255',
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string|max:100',
            'shipping_postal_code' => 'required|string|max:10',
            'payment_method' => 'required|in:bank_transfer,cod,ewallet,midtrans',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.size' => 'required|string',
            'total_amount' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        
        try {
            // Membuat order baru
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => $this->generateOrderNumber(),
                'status' => 'pending',
                'total_amount' => $request->total_amount,
                'shipping_cost' => 15000,
                'grand_total' => $request->total_amount + 15000,
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'shipping_name' => $request->shipping_name,
                'shipping_phone' => $request->shipping_phone,
                'shipping_email' => $request->shipping_email,
                'shipping_address' => $request->shipping_address,
                'shipping_city' => $request->shipping_city,
                'shipping_postal_code' => $request->shipping_postal_code,
                'notes' => $request->notes,
                'order_date' => now(),
            ]);

            // Membuat order items
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                
                // Cek stok
                if ($product->stock_kuantitas < $item['quantity']) {
                    throw new \Exception("Stok produk {$product->name} tidak mencukupi.");
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_price' => $product->harga,
                    'quantity' => $item['quantity'],
                    'size' => $item['size'],
                    'subtotal' => $product->harga * $item['quantity'],
                ]);

                // Kurangi stok produk
                $product->decrement('stock_kuantitas', $item['quantity']);
            }

            // FIXED: Jika payment method adalah midtrans, buat snap token
            $snapToken = null;
            if ($request->payment_method === 'midtrans') {
                $snapToken = $this->createMidtransTransaction($order);
                
                // FIXED: Simpan snap token ke database dengan kolom yang benar
                if ($snapToken) {
                    $order->update(['midtrans_transaction_id' => $snapToken]);
                }
            }

            DB::commit();

            // FIXED: Pass snapToken ke success page
            return redirect()->route('checkout.success', ['order' => $order->order_number])
                           ->with([
                               'success' => 'Pesanan berhasil dibuat!',
                               'snapToken' => $snapToken
                           ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Checkout Error: ' . $e->getMessage());
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function success(Request $request)
    {
        $orderNumber = $request->get('order');
        $order = Order::where('order_number', $orderNumber)
                     ->where('user_id', Auth::id())
                     ->with('orderItems.product')
                     ->first();

        if (!$order) {
            return redirect()->route('home')->with('error', 'Pesanan tidak ditemukan.');
        }

        // FIXED: Ambil snapToken dari session atau dari database
        $snapToken = session('snapToken') ?? $order->midtrans_transaction_id;

        return view('checkout.success', compact('order', 'snapToken'));
    }

    /**
     * FIXED: Membuat transaksi Midtrans dan mendapatkan Snap Token
     */
    private function createMidtransTransaction($order)
    {
        try {
            // FIXED: Set konfigurasi Midtrans dengan error handling
            if (!config('midtrans.server_key') || !config('midtrans.client_key')) {
                throw new \Exception('Midtrans configuration is missing');
            }

            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = config('midtrans.is_production', false);
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            // FIXED: Pastikan semua data required tersedia
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
                        'address' => $order->shipping_address,
                        'city' => $order->shipping_city,
                        'postal_code' => $order->shipping_postal_code,
                        'country_code' => 'IDN'
                    ],
                    'shipping_address' => [
                        'first_name' => $order->shipping_name,
                        'email' => $order->shipping_email,
                        'phone' => $order->shipping_phone,
                        'address' => $order->shipping_address,
                        'city' => $order->shipping_city,
                        'postal_code' => $order->shipping_postal_code,
                        'country_code' => 'IDN'
                    ]
                ],
                'item_details' => [],
                'enabled_payments' => [
                    'credit_card', 'mandiri_clickpay', 'cimb_clicks',
                    'bca_klikbca', 'bca_klikpay', 'bri_epay', 'echannel',
                    'permata_va', 'bca_va', 'bni_va', 'other_va',
                    'gopay', 'indomaret', 'danamon_online', 'akulaku'
                ]
            ];

            // FIXED: Tambahkan item details dengan validation
            foreach ($order->orderItems as $item) {
                $params['item_details'][] = [
                    'id' => 'product_' . $item->product_id,
                    'price' => (int) $item->product_price,
                    'quantity' => (int) $item->quantity,
                    'name' => substr($item->product_name . ' (Size: ' . $item->size . ')', 0, 50),
                ];
            }

            // FIXED: Tambahkan ongkos kirim sebagai item terpisah
            if ($order->shipping_cost > 0) {
                $params['item_details'][] = [
                    'id' => 'shipping_cost',
                    'price' => (int) $order->shipping_cost,
                    'quantity' => 1,
                    'name' => 'Ongkos Kirim',
                ];
            }

            // FIXED: Set expiry time yang lebih reasonable
            $params['expiry'] = [
                'start_time' => date("Y-m-d H:i:s O"),
                'unit' => 'hours',
                'duration' => 24
            ];

            // FIXED: Log untuk debugging
            Log::info('Creating Midtrans transaction', [
                'order_number' => $order->order_number,
                'gross_amount' => $order->grand_total,
                'items_count' => count($params['item_details'])
            ]);

            $snapToken = \Midtrans\Snap::getSnapToken($params);
            
            Log::info('Midtrans snap token created successfully', [
                'order_number' => $order->order_number,
                'snap_token' => substr($snapToken, 0, 20) . '...'
            ]);

            return $snapToken;

        } catch (\Exception $e) {
            Log::error('Midtrans transaction creation failed', [
                'order_number' => $order->order_number,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            throw new \Exception('Gagal membuat transaksi pembayaran: ' . $e->getMessage());
        }
    }

    /**
     * FIXED: Handle webhook notification dari Midtrans
     */
    public function midtransNotification(Request $request)
    {
        try {
            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = config('midtrans.is_production', false);

            $notif = new \Midtrans\Notification();

            $transaction = $notif->transaction_status;
            $type = $notif->payment_type;
            $orderId = $notif->order_id;
            $fraud = $notif->fraud_status ?? 'accept';

            Log::info('Midtrans notification received', [
                'order_id' => $orderId,
                'transaction_status' => $transaction,
                'payment_type' => $type,
                'fraud_status' => $fraud
            ]);

            $order = Order::where('order_number', $orderId)->first();
            
            if (!$order) {
                Log::error('Order not found for notification: ' . $orderId);
                return response()->json(['status' => 'error', 'message' => 'Order not found'], 404);
            }

            // FIXED: Update order berdasarkan status transaksi dengan logic yang lebih jelas
            $updateData = [
                'midtrans_transaction_id' => $notif->transaction_id ?? null,
                'midtrans_payment_type' => $type,
            ];

            if ($transaction == 'capture' || $transaction == 'settlement') {
                if ($type == 'credit_card' && $transaction == 'capture' && $fraud == 'challenge') {
                    // Challenge by FDS, tunggu approval manual
                    $updateData['payment_status'] = 'pending';
                } else {
                    // Payment success
                    $updateData['payment_status'] = 'settlement';
                    $updateData['status'] = 'processing';
                    $updateData['payment_completed_at'] = now();
                }
            } elseif ($transaction == 'pending') {
                $updateData['payment_status'] = 'pending';
            } elseif (in_array($transaction, ['deny', 'expire', 'cancel', 'failure'])) {
                $updateData['payment_status'] = 'failure';
            }

            $order->update($updateData);

            Log::info('Order updated from Midtrans notification', [
                'order_id' => $orderId,
                'old_status' => $order->getOriginal('payment_status'),
                'new_status' => $updateData['payment_status'] ?? $order->payment_status
            ]);

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error('Midtrans notification error', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * FIXED: Check payment status untuk AJAX
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

            return response()->json([
                'status' => $order->payment_status,
                'order_status' => $order->status,
                'payment_method' => $order->payment_method,
                'transaction_id' => $order->midtrans_transaction_id
            ]);

        } catch (\Exception $e) {
            Log::error('Check payment status error', [
                'order_number' => $orderNumber,
                'error' => $e->getMessage()
            ]);
            
            return response()->json(['error' => 'Internal server error'], 500);
        }
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
}
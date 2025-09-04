<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
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
            'payment_method' => 'required|in:bank_transfer,cod,ewallet',
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
                'shipping_cost' => 15000, // Biaya pengiriman tetap
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

            DB::commit();

            return redirect()->route('checkout.success', ['order' => $order->order_number])
                           ->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollback();
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

        return view('checkout.success', compact('order'));
    }

    private function generateOrderNumber()
    {
        $prefix = 'ORD';
        $date = now()->format('Ymd');
        $random = strtoupper(Str::random(4));
        
        return $prefix . $date . $random;
    }
}
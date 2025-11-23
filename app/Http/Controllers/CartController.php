<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cartItems = $this->getCartItems();
        $total = $this->getCartTotal();
        $originalTotal = $this->getCartOriginalTotal(); // ✅ Tambah total harga asli
        
        return view('cart.index', compact('cartItems', 'total', 'originalTotal'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'size' => 'required|string',
        ]);

        $product = Product::with('sizes', 'discounts')->findOrFail($request->product_id);
        
        // CHECK STOCK PER SIZE
        $availableStock = $product->getStockForSize($request->size);
        if ($availableStock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stok untuk size ' . $request->size . ' tidak mencukupi! Stok tersedia: ' . $availableStock
            ]);
        }

        $userId = Auth::id();
        
        // Cek apakah item sudah ada di cart
        $existingCart = Cart::where('user_id', $userId)
            ->where('product_id', $request->product_id)
            ->where('size', $request->size)
            ->first();

        if ($existingCart) {
            // Update quantity jika sudah ada
            $newQuantity = $existingCart->kuantitas + $request->quantity;
            
            // Check if new quantity exceeds stock
            if ($newQuantity > $availableStock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Total quantity melebihi stok yang tersedia untuk size ' . $request->size . '!'
                ]);
            }
            
            $existingCart->update([
                'kuantitas' => $newQuantity
            ]);
        } else {
            // Tambah item baru ke cart
            Cart::create([
                'user_id' => $userId,
                'product_id' => $request->product_id,
                'size' => $request->size,
                'kuantitas' => $request->quantity
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang!',
            'cart_count' => $this->getCartCount(),
            'cart_total' => $this->getCartTotal(),
            'cart_original_total' => $this->getCartOriginalTotal(), // ✅ Tambah total asli
            'total_savings' => $this->getTotalSavings() // ✅ Tambah total hemat
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:carts,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::with(['product.sizes', 'product.discounts'])->findOrFail($request->cart_id);
        
        // Pastikan cart milik user yang login
        if ($cart->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action!'
            ]);
        }

        // Check stock PER SIZE
        $availableStock = $cart->product->getStockForSize($cart->size);
        if ($availableStock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Quantity melebihi stok yang tersedia untuk size ' . $cart->size . '! Stok tersedia: ' . $availableStock
            ]);
        }

        // Update cart item
        $cart->update([
            'kuantitas' => $request->quantity
        ]);

        // Gunakan harga diskon untuk subtotal
        $productPrice = $cart->product->discounted_price;
        $originalPrice = $cart->product->harga;
        $itemSubtotal = $request->quantity * $productPrice;
        $itemOriginalSubtotal = $request->quantity * $originalPrice;
        $itemSavings = $itemOriginalSubtotal - $itemSubtotal;

        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil diupdate!',
            'cart_total' => $this->getCartTotal(),
            'cart_original_total' => $this->getCartOriginalTotal(),
            'total_savings' => $this->getTotalSavings(),
            'item_subtotal' => $itemSubtotal, // subtotal dengan diskon
            'item_original_subtotal' => $itemOriginalSubtotal, // subtotal tanpa diskon
            'item_savings' => $itemSavings // hemat per item
        ]);
    }

    public function remove(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:carts,id',
        ]);

        $cart = Cart::findOrFail($request->cart_id);
        
        // Pastikan cart milik user yang login
        if ($cart->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action!'
            ]);
        }

        $cart->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item berhasil dihapus dari keranjang!',
            'cart_count' => $this->getCartCount(),
            'cart_total' => $this->getCartTotal(),
            'cart_original_total' => $this->getCartOriginalTotal(),
            'total_savings' => $this->getTotalSavings()
        ]);
    }

    public function clear()
    {
        Cart::where('user_id', Auth::id())->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil dikosongkan!'
        ]);
    }

    public function getCart()
    {
        return response()->json([
            'cart_items' => $this->getCartItems(),
            'cart_count' => $this->getCartCount(),
            'cart_total' => $this->getCartTotal(),
            'cart_original_total' => $this->getCartOriginalTotal(),
            'total_savings' => $this->getTotalSavings()
        ]);
    }

    // Private helper methods - UPDATED untuk menampilkan info diskon lengkap
    private function getCartItems()
    {
        $cartItems = [];
        
        $carts = Cart::with(['product.images', 'product.sizes', 'product.discounts'])
            ->where('user_id', Auth::id())
            ->get();

        foreach ($carts as $cart) {
            // Gunakan harga diskon dari Product model
            $productPrice = $cart->product->discounted_price;
            $originalPrice = $cart->product->harga;
            $hasDiscount = $cart->product->has_active_discount;
            $discountPercentage = $cart->product->discount_percentage;
            $savingsAmount = $originalPrice - $productPrice;
            
            $cartItems[] = [
                'cart_id' => $cart->id,
                'product' => $cart->product,
                'size' => $cart->size,
                'quantity' => $cart->kuantitas,
                'price' => $productPrice, // harga setelah diskon
                'original_price' => $originalPrice, // harga asli sebelum diskon
                'has_discount' => $hasDiscount, // flag apakah ada diskon
                'discount_percentage' => $discountPercentage, // persentase diskon
                'savings_amount' => $savingsAmount, // jumlah hemat per item
                'subtotal' => $cart->kuantitas * $productPrice, // subtotal dengan diskon
                'original_subtotal' => $cart->kuantitas * $originalPrice, // subtotal tanpa diskon
                'item_savings' => $cart->kuantitas * $savingsAmount, // total hemat per item
                'available_stock' => $cart->product->getStockForSize($cart->size)
            ];
        }

        return $cartItems;
    }

    private function getCartCount()
    {
        return Cart::where('user_id', Auth::id())->sum('kuantitas');
    }

    private function getCartTotal()
    {
        $total = 0;
        $carts = Cart::with('product')->where('user_id', Auth::id())->get();
        
        foreach ($carts as $cart) {
            // Gunakan harga diskon untuk total
            $productPrice = $cart->product->discounted_price;
            $total += $cart->kuantitas * $productPrice;
        }
        
        return $total;
    }

    // ✅ NEW: Total harga asli (tanpa diskon)
    private function getCartOriginalTotal()
    {
        $total = 0;
        $carts = Cart::with('product')->where('user_id', Auth::id())->get();
        
        foreach ($carts as $cart) {
            $originalPrice = $cart->product->harga;
            $total += $cart->kuantitas * $originalPrice;
        }
        
        return $total;
    }

    // ✅ NEW: Total hemat dari diskon
    private function getTotalSavings()
    {
        return $this->getCartOriginalTotal() - $this->getCartTotal();
    }
}
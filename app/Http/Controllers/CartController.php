<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
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
        
        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'size' => 'required|string',
        ]);

        $product = Product::findOrFail($request->product_id);
        
        // Check stock
        if ($product->stock_kuantitas < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stok produk tidak mencukupi!'
            ]);
        }

        // Get current cart from session
        $cart = Session::get('cart', []);
        $cartKey = $product->id . '_' . $request->size;

        // If item already exists in cart, update quantity
        if (isset($cart[$cartKey])) {
            $newQuantity = $cart[$cartKey]['quantity'] + $request->quantity;
            
            // Check if new quantity exceeds stock
            if ($newQuantity > $product->stock_kuantitas) {
                return response()->json([
                    'success' => false,
                    'message' => 'Total quantity melebihi stok yang tersedia!'
                ]);
            }
            
            $cart[$cartKey]['quantity'] = $newQuantity;
            $cart[$cartKey]['subtotal'] = $newQuantity * $product->harga;
        } else {
            // Add new item to cart
            $cart[$cartKey] = [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_price' => $product->harga,
                'product_image' => $product->images->first()->image_path ?? '',
                'size' => $request->size,
                'quantity' => $request->quantity,
                'subtotal' => $request->quantity * $product->harga,
            ];
        }

        // Save cart to session
        Session::put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang!',
            'cart_count' => $this->getCartCount()
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'cart_key' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Session::get('cart', []);
        $cartKey = $request->cart_key;

        if (!isset($cart[$cartKey])) {
            return response()->json([
                'success' => false,
                'message' => 'Item tidak ditemukan di keranjang!'
            ]);
        }

        $product = Product::find($cart[$cartKey]['product_id']);
        
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan!'
            ]);
        }

        // Check stock
        if ($product->stock_kuantitas < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Quantity melebihi stok yang tersedia!'
            ]);
        }

        // Update cart item
        $cart[$cartKey]['quantity'] = $request->quantity;
        $cart[$cartKey]['subtotal'] = $request->quantity * $cart[$cartKey]['product_price'];

        Session::put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil diupdate!',
            'cart_total' => $this->getCartTotal(),
            'item_subtotal' => $cart[$cartKey]['subtotal']
        ]);
    }

    public function remove(Request $request)
    {
        $request->validate([
            'cart_key' => 'required|string',
        ]);

        $cart = Session::get('cart', []);
        $cartKey = $request->cart_key;

        if (isset($cart[$cartKey])) {
            unset($cart[$cartKey]);
            Session::put('cart', $cart);
        }

        return response()->json([
            'success' => true,
            'message' => 'Item berhasil dihapus dari keranjang!',
            'cart_count' => $this->getCartCount(),
            'cart_total' => $this->getCartTotal()
        ]);
    }

    public function clear()
    {
        Session::forget('cart');
        
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
            'cart_total' => $this->getCartTotal()
        ]);
    }

    // Private helper methods
    private function getCartItems()
    {
        $cart = Session::get('cart', []);
        $cartItems = [];

        foreach ($cart as $key => $item) {
            $product = Product::with('images')->find($item['product_id']);
            if ($product) {
                $cartItems[$key] = [
                    'product' => $product,
                    'size' => $item['size'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['subtotal'],
                ];
            }
        }

        return $cartItems;
    }

    private function getCartCount()
    {
        $cart = Session::get('cart', []);
        return array_sum(array_column($cart, 'quantity'));
    }

    private function getCartTotal()
    {
        $cart = Session::get('cart', []);
        return array_sum(array_column($cart, 'subtotal'));
    }
}
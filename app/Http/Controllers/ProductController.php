<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Data produk statis (dalam implementasi nyata, ini dari database)
    private $products = [
        1 => [
            'id' => 1,
            'name' => 'Baju Adat Jawa Wanita',
            'price' => 699000,
            'image' => 'storage/product_images/1.png',
            'category' => 'wanita',
            'description' => 'Baju adat Jawa untuk wanita dengan desain tradisional yang elegan.',
            'stock' => 15
        ],
        2 => [
            'id' => 2,
            'name' => 'Baju Adat Sumatera Wanita',
            'price' => 549000,
            'image' => 'storage/product_images/2.png',
            'category' => 'wanita',
            'description' => 'Baju adat Sumatera dengan motif khas dan warna yang memukau.',
            'stock' => 20
        ],
        3 => [
            'id' => 3,
            'name' => 'Baju Adat Bali Wanita',
            'price' => 779000,
            'image' => 'storage/product_images/3.png',
            'category' => 'wanita',
            'description' => 'Baju adat Bali dengan sentuhan modern yang tetap mempertahankan keaslian.',
            'stock' => 8
        ],
        4 => [
            'id' => 4,
            'name' => 'Baju Adat Kalimantan Wanita',
            'price' => 599000,
            'image' => 'storage/product_images/4.png',
            'category' => 'wanita',
            'description' => 'Baju adat Kalimantan dengan bordiran halus dan detail yang indah.',
            'stock' => 12
        ],
        5 => [
            'id' => 5,
            'name' => 'Baju Adat Sulawesi Wanita',
            'price' => 729000,
            'image' => 'storage/product_images/5.png',
            'category' => 'wanita',
            'description' => 'Baju adat Sulawesi dengan corak etnik yang khas dan berkualitas tinggi.',
            'stock' => 10
        ],
        6 => [
            'id' => 6,
            'name' => 'Baju Adat Papua Wanita',
            'price' => 659000,
            'image' => 'storage/product_images/6.png',
            'category' => 'wanita',
            'description' => 'Baju adat Papua dengan warna-warna cerah dan motif tradisional.',
            'stock' => 7
        ],
        7 => [
            'id' => 7,
            'name' => 'Baju Adat Jawa Pria',
            'price' => 319000,
            'image' => 'storage/product_images/1.png',
            'category' => 'pria',
            'description' => 'Baju adat Jawa untuk pria dengan desain klasik dan nyaman.',
            'stock' => 18
        ],
        8 => [
            'id' => 8,
            'name' => 'Baju Adat Jawa Wanita',
            'price' => 469000,
            'image' => 'storage/product_images/3.png',
            'category' => 'wanita',
            'description' => 'Variasi lain dari baju adat Jawa dengan harga lebih terjangkau.',
            'stock' => 14
        ],
        9 => [
            'id' => 9,
            'name' => 'Baju Adat Sumatera Pria',
            'price' => 389000,
            'image' => 'storage/product_images/4.png',
            'category' => 'pria',
            'description' => 'Baju adat Sumatera untuk pria dengan detail songket yang mewah.',
            'stock' => 11
        ],
        10 => [
            'id' => 10,
            'name' => 'Baju Adat Bali Pria',
            'price' => 329000,
            'image' => 'storage/product_images/2.png',
            'category' => 'pria',
            'description' => 'Baju adat Bali untuk pria dengan sentuhan modern yang elegan.',
            'stock' => 16
        ],
        11 => [
            'id' => 11,
            'name' => 'Baju Adat Kalimantan Pria',
            'price' => 349000,
            'image' => 'storage/product_images/3.png',
            'category' => 'pria',
            'description' => 'Baju adat Kalimantan untuk pria dengan kualitas premium.',
            'stock' => 9
        ],
        12 => [
            'id' => 12,
            'name' => 'Baju Adat Sulawesi Wanita',
            'price' => 599000,
            'image' => 'storage/product_images/6.png',
            'category' => 'wanita',
            'description' => 'Baju adat Sulawesi dengan desain unik dan bahan berkualitas.',
            'stock' => 13
        ]
    ];

    /**
     * Menampilkan halaman utama dengan semua produk
     */
    public function index()
    {
        return view('home', ['products' => $this->products]);
    }

    /**
     * Menampilkan detail produk berdasarkan ID
     */
    public function show($id)
    {
        // Validasi ID produk
        if (!isset($this->products[$id])) {
            abort(404, 'Produk tidak ditemukan');
        }

        $product = $this->products[$id];
        
        // Ambil produk serupa (kategori sama, exclude produk current)
        $relatedProducts = array_filter($this->products, function($p) use ($product) {
            return $p['category'] === $product['category'] && $p['id'] !== $product['id'];
        });
        
        // Batasi produk serupa maksimal 4
        $relatedProducts = array_slice($relatedProducts, 0, 4, true);

        return view('product_detail', [
            'product' => $product,
            'relatedProducts' => $relatedProducts
        ]);
    }

    /**
     * API endpoint untuk mendapatkan data produk (untuk AJAX)
     */
    public function getProduct($id)
    {
        if (!isset($this->products[$id])) {
            return response()->json(['error' => 'Produk tidak ditemukan'], 404);
        }

        return response()->json([
            'success' => true,
            'product' => $this->products[$id]
        ]);
    }

    /**
     * API endpoint untuk mendapatkan semua produk
     */
    public function getAllProducts()
    {
        return response()->json([
            'success' => true,
            'products' => $this->products
        ]);
    }

    /**
     * Pencarian produk
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        $category = $request->get('category', '');
        
        $filteredProducts = array_filter($this->products, function($product) use ($query, $category) {
            $matchesQuery = empty($query) || 
                           stripos($product['name'], $query) !== false ||
                           stripos($product['description'], $query) !== false;
            
            $matchesCategory = empty($category) || $product['category'] === $category;
            
            return $matchesQuery && $matchesCategory;
        });

        return view('products.search', [
            'products' => $filteredProducts,
            'query' => $query,
            'category' => $category
        ]);
    }

    /**
     * Filter produk berdasarkan kategori
     */
    public function filterByCategory($category)
    {
        $filteredProducts = array_filter($this->products, function($product) use ($category) {
            return $product['category'] === $category;
        });

        return view('products.category', [
            'products' => $filteredProducts,
            'category' => $category,
            'categoryName' => ucfirst($category)
        ]);
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Services\GoogleAIService;
use Illuminate\Support\Facades\Log;

class AIChatController extends Controller
{
    protected $aiService;

    public function __construct(GoogleAIService $aiService)
    {
        $this->aiService = $aiService;
    }

    /**
     * Main chat endpoint
     */
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        try {
            $userMessage = $request->message;

            // Cari produk terkait dari database
            $productContext = $this->getProductContext($userMessage);

            // Build system instruction
            $systemInstruction = $this->aiService->buildSystemInstruction([
                'products' => $productContext
            ]);

            // Kirim ke Gemini (AI)
            $response = $this->aiService->generateContent(
                systemInstruction: $systemInstruction,
                prompt: $userMessage
            );

            // Jika AI return array → ubah jadi string
            if (is_array($response)) {
                $response = json_encode($response, JSON_PRETTY_PRINT);
            }

            return response()->json([
                'success' => true,
                'message' => $response,
                'products' => array_slice($productContext, 0, 3), // Kirim max 3 produk untuk ditampilkan sebagai card
                'timestamp' => now()->toIso8601String()
            ]);

        } catch (\Exception $e) {
            Log::error('AI Chat Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Maaf, terjadi kesalahan. Silakan coba lagi.',
            ], 500);
        }
    }

    /**
     * Get product context based on user message
     */
    private function getProductContext($userMessage)
    {
        $keywords = $this->extractKeywords($userMessage);

        if (empty($keywords)) {
            // Jika tidak ada keyword spesifik, ambil produk featured/terbaru
            $products = Product::with(['category', 'images'])
                ->where('status', 'active')
                ->orderBy('is_featured', 'desc')
                ->orderBy('created_at', 'desc')
                ->limit(3)
                ->get();
        } else {
            // Cari produk berdasarkan keyword
            $products = Product::with(['category', 'images'])
                ->where('status', 'active')
                ->where(function($query) use ($keywords) {
                    foreach ($keywords as $keyword) {
                        $query->orWhere('name', 'LIKE', "%{$keyword}%")
                              ->orWhere('deskripsi', 'LIKE', "%{$keyword}%");
                    }
                })
                ->limit(5)
                ->get();
        }

        return $products->map(function($product) {
            // Hitung harga final (dengan diskon jika ada)
            $finalPrice = $this->calculateFinalPrice($product);
            $originalPrice = $product->harga;
            $discountPercentage = $this->getDiscountPercentage($product);

            return [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => $finalPrice,
                'original_price' => $originalPrice,
                'description' => substr($product->deskripsi, 0, 150), // Max 150 char
                'stock' => $product->stock_kuantitas,
                'category' => $product->category->name ?? 'Umum',
                'discount' => $discountPercentage,
                'url' => url('/products/' . $product->slug),
                'image' => $product->primary_image ? asset('storage/' . $product->primary_image) : asset('storage/product_images/default.jpg'),
            ];
        })->toArray();
    }

    /**
     * Calculate final price with discount
     */
    private function calculateFinalPrice($product)
    {
        $currentDate = now()->format('Y-m-d');

        $activeDiscount = $product->discounts()
            ->where('start_date', '<=', $currentDate)
            ->where('end_date', '>=', $currentDate)
            ->orderBy('percentage', 'desc')
            ->first();

        $price = $product->harga;

        if ($activeDiscount) {
            $price = $price - ($price * $activeDiscount->percentage / 100);
        }

        return $price;
    }

    /**
     * Get active discount percentage
     */
    private function getDiscountPercentage($product)
    {
        $currentDate = now()->format('Y-m-d');

        $activeDiscount = $product->discounts()
            ->where('start_date', '<=', $currentDate)
            ->where('end_date', '>=', $currentDate)
            ->orderBy('percentage', 'desc')
            ->first();

        return $activeDiscount ? $activeDiscount->percentage : 0;
    }

    /**
     * Extract keywords from user message
     */
    private function extractKeywords($message)
    {
        // Kata-kata umum yang diabaikan (stopwords Indonesia)
        $commonWords = [
            'saya', 'mau', 'cari', 'ada', 'yang', 'beli', 'butuh', 'perlu',
            'ingin', 'minta', 'dong', 'nih', 'kak', 'min', 'bang', 'gan',
            'produk', 'barang', 'item', 'jual', 'harga', 'berapa', 'untuk',
            'apa', 'siapa', 'dimana', 'kapan', 'kenapa', 'bagaimana', 'gimana',
            'dengan', 'dari', 'atau', 'dan', 'ini', 'itu', 'tersebut'
        ];

        $message = strtolower($message);
        $message = preg_replace('/[^\w\s]/', ' ', $message);

        $words = preg_split('/\s+/', $message);
        $keywords = array_diff($words, $commonWords);

        // Filter keywords yang panjangnya > 2 karakter
        return array_values(array_filter($keywords, fn($w) => strlen($w) > 2));
    }

    /**
     * Get product suggestions for autocomplete (optional)
     */
    public function getProductSuggestions(Request $request)
    {
        $query = $request->query('q', '');

        $products = Product::with(['category', 'images'])
            ->where('status', 'active')
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('deskripsi', 'LIKE', "%{$query}%");
            })
            ->limit(5)
            ->get()
            ->map(function($product) {
                $finalPrice = $this->calculateFinalPrice($product);
                $discountPercentage = $this->getDiscountPercentage($product);

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => 'IDR ' . number_format($finalPrice, 0, ',', '.'),
                    'image' => $product->primary_image ? asset('storage/' . $product->primary_image) : asset('storage/product_images/default.jpg'),
                    'url' => url('/products/' . $product->slug),
                    'discount' => $discountPercentage > 0 ? $discountPercentage . '%' : null,
                ];
            });

        return response()->json($products);
    }

    /**
     * Test Gemini connection (for debugging)
     */
    public function testConnection()
    {
        try {
            $isConnected = $this->aiService->testConnection();

            return response()->json([
                'success' => $isConnected,
                'message' => $isConnected ? 'Connected to Gemini API ✓' : 'Failed to connect to Gemini API ✗',
                'model' => config('services.google_ai.model'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
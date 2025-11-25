<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GoogleAIService
{
    private $apiKey;
    private $apiUrl;
    private $model;

    public function __construct()
    {
        $this->apiKey = config('services.google_ai.api_key');
        $this->model = config('services.google_ai.model', 'gemini-1.5-flash');
        $this->apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent";
        
        // Validasi API key
        if (empty($this->apiKey)) {
            Log::error('Google AI API Key tidak ditemukan di .env');
        }
    }

    /**
     * Generate AI response with conversation history
     */
    public function generateContent($systemInstruction, $prompt, $conversationHistory = [])
    {
        try {
            // Validasi input
            if (empty($prompt)) {
                throw new \Exception('Prompt tidak boleh kosong');
            }

            // Build conversation contents
            $contents = [];
            
            // Add conversation history (max 10 messages untuk menghindari token limit)
            $history = array_slice($conversationHistory, -10);
            foreach ($history as $msg) {
                if (isset($msg['role']) && isset($msg['text'])) {
                    $contents[] = [
                        "role" => $msg['role'],
                        "parts" => [["text" => $msg['text']]]
                    ];
                }
            }
            
            // Add current user message
            $contents[] = [
                "role" => "user",
                "parts" => [["text" => $prompt]]
            ];

            // Build payload
            $payload = [
                "system_instruction" => [
                    "parts" => [["text" => $systemInstruction]]
                ],
                "contents" => $contents,
                "generationConfig" => [
                    "temperature" => 0.7,
                    "maxOutputTokens" => 2048,
                    "topP" => 0.95,
                    "topK" => 40,
                ],
                "safetySettings" => [
                    [
                        "category" => "HARM_CATEGORY_HARASSMENT",
                        "threshold" => "BLOCK_MEDIUM_AND_ABOVE"
                    ],
                    [
                        "category" => "HARM_CATEGORY_HATE_SPEECH",
                        "threshold" => "BLOCK_MEDIUM_AND_ABOVE"
                    ],
                    [
                        "category" => "HARM_CATEGORY_SEXUALLY_EXPLICIT",
                        "threshold" => "BLOCK_MEDIUM_AND_ABOVE"
                    ],
                    [
                        "category" => "HARM_CATEGORY_DANGEROUS_CONTENT",
                        "threshold" => "BLOCK_MEDIUM_AND_ABOVE"
                    ]
                ]
            ];

            Log::info('Gemini API Request', [
                'model' => $this->model,
                'prompt_length' => strlen($prompt),
                'history_count' => count($history)
            ]);

            // Send request to Gemini
            $response = Http::withOptions(['verify' => false])
                ->timeout(30)
                ->withHeaders(["Content-Type" => "application/json"])
                ->post($this->apiUrl . "?key={$this->apiKey}", $payload);

            // Handle response errors
            if (!$response->successful()) {
                $errorBody = $response->json();
                Log::error("Gemini API Error", [
                    "status" => $response->status(),
                    "error" => $errorBody,
                    "url" => $this->apiUrl,
                ]);

                // Check specific error types
                if ($response->status() == 429) {
                    return "Maaf, terlalu banyak permintaan. Silakan tunggu sebentar.";
                } elseif ($response->status() == 403) {
                    return "Maaf, API key tidak valid. Silakan hubungi admin.";
                }

                return "Maaf, terjadi kesalahan koneksi ke AI. Silakan coba lagi.";
            }

            $data = $response->json();

            // Validate response structure
            if (empty($data['candidates'])) {
                Log::warning("Gemini: No candidates in response", ['data' => $data]);
                
                // Check if blocked by safety filters
                if (isset($data['promptFeedback']['blockReason'])) {
                    return "Maaf, pertanyaan Anda tidak dapat diproses karena alasan keamanan.";
                }
                
                return "Maaf, AI tidak dapat memberikan respons. Coba pertanyaan lain.";
            }

            if (empty($data['candidates'][0]['content']['parts'])) {
                Log::warning("Gemini: No parts in response", ['data' => $data]);
                return "Maaf, respons AI tidak lengkap. Coba lagi.";
            }

            // Extract text from response
            $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
            
            if (empty($text)) {
                return "Maaf, AI tidak memberikan respons teks.";
            }

            Log::info('Gemini API Success', [
                'response_length' => strlen($text)
            ]);

            return trim($text);

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error("Gemini Connection Error", [
                "error" => $e->getMessage()
            ]);
            return "Maaf, tidak dapat terhubung ke server AI. Periksa koneksi internet Anda.";
            
        } catch (\Exception $e) {
            Log::error("Gemini Request Failed", [
                "error" => $e->getMessage(),
                "trace" => $e->getTraceAsString()
            ]);
            return "Terjadi kesalahan sistem: " . $e->getMessage();
        }
    }

    /**
     * Build system instruction with product context
     */
    public function buildSystemInstruction(array $context): string
    {
        $instruction = "Kamu adalah asisten virtual NusantaraShop yang ramah dan profesional.\n\n";

        $instruction .= "INFORMASI TOKO:\n";
        $instruction .= "Nama: NusantaraShop\n";
        $instruction .= "Produk: Batik premium Indonesia (kemeja, blouse, kain, dress)\n";
        $instruction .= "Alamat: Jl. Kalimasada No. 30, Polehan, Blimbing, Malang, Jawa Timur 65121\n";
        $instruction .= "Kontak: nusantarashop@gmail.com | +62 895 4036 50987\n";
        $instruction .= "Pembayaran: Transfer Bank, E-wallet, COD\n";
        $instruction .= "Pengiriman: JNE, POS, TIKI (seluruh Indonesia)\n\n";

        if (!empty($context['products']) && count($context['products']) > 0) {
            $instruction .= "PRODUK YANG RELEVAN:\n\n";
            
            foreach ($context['products'] as $i => $product) {
                $no = $i + 1;
                $instruction .= "{$no}. {$product['name']}\n";
                $instruction .= "   Kategori: {$product['category']}\n";
                
                if (!empty($product['discount']) && $product['discount'] > 0) {
                    $instruction .= "   💰 Harga: Rp " . number_format($product['price'], 0, ',', '.') . "\n";
                    $instruction .= "   🎉 DISKON {$product['discount']}% dari Rp " . number_format($product['original_price'], 0, ',', '.') . "\n";
                    $saving = $product['original_price'] - $product['price'];
                    $instruction .= "   💵 Hemat: Rp " . number_format($saving, 0, ',', '.') . "\n";
                } else {
                    $instruction .= "   Harga: Rp " . number_format($product['price'], 0, ',', '.') . "\n";
                }
                
                $instruction .= "   Stok: " . ($product['stock'] > 0 ? "{$product['stock']} unit tersedia ✓" : "Habis ✗") . "\n";
                
                if (!empty($product['description'])) {
                    $desc = substr($product['description'], 0, 80);
                    $instruction .= "   Info: {$desc}...\n";
                }
                
                $instruction .= "   🔗 Link: {$product['url']}\n\n";
            }
        } else {
            $instruction .= "CATATAN: Tidak ada produk spesifik yang cocok dengan pertanyaan user.\n";
            $instruction .= "Sarankan user untuk melihat katalog lengkap di /products atau tanyakan kebutuhan lebih detail.\n\n";
        }

        $instruction .= "ATURAN MENJAWAB:\n";
        $instruction .= "1. Jawab pertanyaan langsung dan spesifik berdasarkan data produk di atas\n";
        $instruction .= "2. Jika user tanya produk, HANYA sebutkan produk yang ADA di list di atas\n";
        $instruction .= "3. JANGAN membuat nama produk atau harga fiktif\n";
        $instruction .= "4. Sertakan harga lengkap dengan format Rp dan info diskon jika ada\n";
        $instruction .= "5. Berikan link produk untuk memudahkan user\n";
        $instruction .= "6. Gunakan bahasa Indonesia yang ramah dan natural\n";
        $instruction .= "7. Maksimal 5-6 kalimat per respons, jangan terlalu panjang\n";
        $instruction .= "8. Jika produk stok habis, tawarkan alternatif lain\n";
        $instruction .= "9. Untuk pertanyaan di luar produk (cara pesan, pembayaran), jawab sesuai info toko\n\n";

        $instruction .= "CONTOH RESPONS YANG BAIK:\n";
        $instruction .= "User: 'Ada kemeja batik pria formal?'\n";
        $instruction .= "Bot: 'Ada kak! Kami punya [nama produk dari list] dengan harga Rp [harga sesuai list]. ";
        $instruction .= "[Deskripsi singkat]. Kakak bisa lihat detailnya di [link]. ";
        $instruction .= "Stoknya masih [jumlah] unit. Ada yang ingin ditanyakan lagi? 😊'\n\n";

        $instruction .= "Sekarang jawab pertanyaan user dengan informasi yang akurat!";

        return $instruction;
    }

    /**
     * Test connection to Gemini API
     */
    public function testConnection()
    {
        try {
            if (empty($this->apiKey)) {
                throw new \Exception('API Key tidak dikonfigurasi');
            }

            $response = Http::withOptions(['verify' => false])
                ->timeout(10)
                ->post($this->apiUrl . "?key={$this->apiKey}", [
                    "contents" => [
                        ["role" => "user", "parts" => [["text" => "Test koneksi"]]]
                    ]
                ]);

            if (!$response->successful()) {
                throw new \Exception('HTTP ' . $response->status() . ': ' . $response->body());
            }

            return true;
        } catch (\Exception $e) {
            Log::error("Gemini Connection Test Failed", [
                "error" => $e->getMessage(),
                "model" => $this->model
            ]);
            return false;
        }
    }

    /**
     * Get model name for debugging
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Check if API key is configured
     */
    public function isConfigured()
    {
        return !empty($this->apiKey);
    }
}
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
        $this->model = config('services.google_ai.model', 'gemini-2.0-flash-exp');

        // Endpoint standar Gemini generateContent v1beta
        $this->apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent";
    }

    /**
     * Fungsi utama memanggil Gemini API
     */
    public function generateContent($systemInstruction, $prompt)
    {
        try {
            $payload = [
                "contents" => [
                    [
                        "role" => "user",
                        "parts" => [
                            [
                                "text" =>
                                    $systemInstruction . // Rules + product data
                                    "\n\n" .
                                    "User: " . $prompt
                            ]
                        ]
                    ]
                ],
                "generationConfig" => [
                    "temperature" => 0.9,
                    "maxOutputTokens" => 8192,
                ]
            ];

            $response = Http::withOptions([
                    'verify' => false, // Disable SSL verification untuk development
                ])
                ->timeout(30)
                ->withHeaders([
                    "Content-Type" => "application/json",
                ])
                ->post($this->apiUrl . "?key={$this->apiKey}", $payload);

            if (!$response->successful()) {
                Log::error("Gemini API Error", [
                    "status" => $response->status(),
                    "body" => $response->body(),
                    "url" => $this->apiUrl,
                ]);

                return "Maaf, koneksi ke AI bermasalah. Silakan coba lagi.";
            }

            $data = $response->json();

            if (empty($data['candidates'][0]['content']['parts'])) {
                Log::warning("Gemini: No response parts", ['data' => $data]);
                return "Maaf, AI tidak memberikan respons. Coba lagi ya.";
            }

            foreach ($data['candidates'][0]['content']['parts'] as $part) {
                if (isset($part['text'])) {
                    return $part['text'];
                }
            }

            return "Maaf, respons AI tidak dapat dibaca.";

        } catch (\Exception $e) {
            Log::error("Gemini Request Failed", [
                "error" => $e->getMessage(),
                "trace" => $e->getTraceAsString()
            ]);
            return "Terjadi kesalahan sistem: " . $e->getMessage();
        }
    }

    /**
     * Membangun system instruction lengkap dengan konteks produk
     */
    public function buildSystemInstruction(array $context): string
    {
        $instruction = "Kamu adalah customer service virtual bernama 'Asisten NusantaraShop' untuk NusantaraShop, sebuah toko online batik premium.\n\n";

        $instruction .= "INFORMASI TOKO:\n";
        $instruction .= "- Nama toko: NusantaraShop\n";
        $instruction .= "- Produk utama: Batik berkualitas tinggi (kemeja, blouse, kain, dress, dll)\n";
        $instruction .= "- Alamat: Jl. Kalimasada Nomor 30, Polehan, Kec. Blimbing, Kota Malang, Jawa Timur 65121\n";
        $instruction .= "- Email: nusantarashop@gmail.com\n";
        $instruction .= "- Telepon: +62 895 4036 50987\n";
        $instruction .= "- Metode Pembayaran: Transfer Bank, E-wallet, COD\n";
        $instruction .= "- Pengiriman: Seluruh Indonesia via JNE, POS, TIKI\n\n";

        $instruction .= "GAYA KOMUNIKASI:\n";
        $instruction .= "- Gunakan bahasa Indonesia yang ramah, sopan, dan hangat\n";
        $instruction .= "- Tone: Friendly, helpful, dan professional\n";
        $instruction .= "- Gunakan emoji secukupnya untuk kehangatan (😊, 👍, 🎉, ✨)\n";
        $instruction .= "- Jangan terlalu formal, tapi tetap sopan\n\n";

        // =======================
        // PRODUK dari database
        // =======================
        if (!empty($context['products'])) {
            $instruction .= "PRODUK YANG TERSEDIA (dari database kami):\n\n";

            foreach ($context['products'] as $i => $product) {
                $instruction .= "Produk #" . ($i + 1) . ":\n";
                $instruction .= "├─ Nama: {$product['name']}\n";
                $instruction .= "├─ Kategori: {$product['category']}\n";
                $instruction .= "├─ Harga: IDR " . number_format($product['price'], 0, ',', '.') . "\n";

                if (!empty($product['discount']) && $product['discount'] > 0) {
                    $saving = $product['original_price'] - $product['price'];
                    $instruction .= "├─ 🎉 DISKON: {$product['discount']}%\n";
                    $instruction .= "│  Hemat: IDR " . number_format($saving, 0, ',', '.') . "\n";
                    $instruction .= "│  Harga Normal: IDR " . number_format($product['original_price'], 0, ',', '.') . "\n";
                }

                if (!empty($product['description'])) {
                    $instruction .= "├─ Deskripsi: {$product['description']}\n";
                }

                $instruction .= "├─ Stok: " . ($product['stock'] > 0 ? "{$product['stock']} unit tersedia ✓" : "Stok habis ✗") . "\n";
                $instruction .= "└─ Link Produk: {$product['url']}\n\n";
            }
        } else {
            $instruction .= "INFO: Tidak ada produk spesifik yang relevan dengan pertanyaan user.\n";
            $instruction .= "Kamu bisa menawarkan untuk melihat katalog lengkap di /products atau tanyakan kategori yang diinginkan.\n\n";
        }

        // =======================
        // TUGAS & ATURAN
        // =======================
        $instruction .= "TUGAS UTAMA KAMU:\n";
        $instruction .= "1. Membantu customer menemukan produk batik yang sesuai kebutuhan\n";
        $instruction .= "2. Memberikan rekomendasi berdasarkan preferensi customer\n";
        $instruction .= "3. Menjelaskan detail produk (harga, stok, bahan, ukuran, dll)\n";
        $instruction .= "4. Membantu proses pemesanan dan menjawab pertanyaan umum\n";
        $instruction .= "5. Memberikan informasi tentang promo, diskon, dan pengiriman\n\n";

        $instruction .= "ATURAN PENTING:\n";
        $instruction .= "❌ JANGAN membuat informasi produk palsu atau harga yang tidak ada\n";
        $instruction .= "❌ JANGAN memberikan rekomendasi produk yang tidak ada di database\n";
        $instruction .= "❌ JANGAN terlalu teknis atau formal dalam bahasa\n";
        $instruction .= "❌ JANGAN abaikan pertanyaan customer\n\n";

        $instruction .= "✅ LAKUKAN:\n";
        $instruction .= "✓ Rekomendasikan produk yang BENAR-BENAR ADA di database\n";
        $instruction .= "✓ Berikan link produk untuk memudahkan customer\n";
        $instruction .= "✓ Sebutkan harga dengan format IDR yang jelas\n";
        $instruction .= "✓ Informasikan jika ada diskon atau promo\n";
        $instruction .= "✓ Tanyakan detail lebih lanjut jika pertanyaan kurang spesifik\n";
        $instruction .= "✓ Jika produk stok habis, tawarkan alternatif serupa\n";
        $instruction .= "✓ Untuk pertanyaan kompleks (status pesanan, tracking), arahkan ke halaman profil/pesanan\n\n";

        $instruction .= "FORMAT JAWABAN:\n";
        $instruction .= "- Jawab dengan 3-6 kalimat yang to-the-point\n";
        $instruction .= "- Gunakan paragraf pendek untuk readability\n";
        $instruction .= "- Sertakan emoji untuk kehangatan\n";
        $instruction .= "- Akhiri dengan pertanyaan follow-up atau call-to-action\n\n";

        $instruction .= "CONTOH PERTANYAAN YANG BISA DIJAWAB:\n";
        $instruction .= "- 'Ada batik pria formal untuk ke kantor?'\n";
        $instruction .= "- 'Berapa harga kemeja batik yang ada diskon?'\n";
        $instruction .= "- 'Rekomendasi batik untuk acara pernikahan dong'\n";
        $instruction .= "- 'Batik wanita ukuran M ada?'\n";
        $instruction .= "- 'Gimana cara pesan dan bayarnya?'\n\n";

        $instruction .= "Sekarang, jawab pertanyaan user dengan ramah dan informatif!\n";

        return $instruction;
    }

    /**
     * Test koneksi ke Gemini API (optional untuk debugging)
     */
    public function testConnection()
    {
        try {
            $response = Http::withOptions([
                    'verify' => false, // Disable SSL verification
                ])
                ->timeout(10)
                ->post($this->apiUrl . "?key={$this->apiKey}", [
                    "contents" => [
                        [
                            "role" => "user",
                            "parts" => [["text" => "Test koneksi"]]
                        ]
                    ]
                ]);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error("Gemini Connection Test Failed", ["error" => $e->getMessage()]);
            return false;
        }
    }
}
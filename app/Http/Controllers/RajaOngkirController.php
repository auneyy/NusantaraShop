<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RajaOngkirController extends Controller
{
    /**
     * Menampilkan daftar provinsi dari API Raja Ongkir
     * Digunakan untuk view dan API endpoint
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Mengambil data provinsi dari API Raja Ongkir
        $response = Http::withOptions([
            'verify' => config('http.verify', false), // Use config value
        ])->withHeaders([
            'Accept' => 'application/json',
            'key' => config('rajaongkir.api_key'),
        ])->get('https://rajaongkir.komerce.id/api/v1/destination/province');

        // Memeriksa apakah permintaan berhasil
        if ($response->successful()) {
            $responseData = $response->json();
            $provinces = $responseData['data'] ?? [];

            // Return JSON untuk API call
            return response()->json([
                'success' => true,
                'data' => $provinces
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to fetch provinces'
        ], 500);
    }

    /**
     * Mengambil data kota berdasarkan ID provinsi
     *
     * @param int $provinceId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCities($provinceId)
    {
        $response = Http::withOptions([
            'verify' => false, // Disable SSL verification for development
        ])->withHeaders([
            'Accept' => 'application/json',
            'key' => config('rajaongkir.api_key'),
        ])->get("https://rajaongkir.komerce.id/api/v1/destination/city/{$provinceId}");

        if ($response->successful()) {
            $responseData = $response->json();
            $cities = $responseData['data'] ?? [];

            return response()->json([
                'success' => true,
                'data' => $cities
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to fetch cities'
        ], 500);
    }

    /**
     * Mengambil data kecamatan berdasarkan ID kota
     *
     * @param int $cityId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDistricts($cityId)
    {
        $response = Http::withOptions([
            'verify' => false, // Disable SSL verification for development
        ])->withHeaders([
            'Accept' => 'application/json',
            'key' => config('rajaongkir.api_key'),
        ])->get("https://rajaongkir.komerce.id/api/v1/destination/district/{$cityId}");

        if ($response->successful()) {
            $responseData = $response->json();
            $districts = $responseData['data'] ?? [];

            return response()->json([
                'success' => true,
                'data' => $districts
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to fetch districts'
        ], 500);
    }

    /**
     * Menghitung ongkos kirim berdasarkan data yang diberikan
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkOngkir(Request $request)
    {
        $request->validate([
            'destination_district_id' => 'required|integer',
            'weight' => 'required|integer|min:1',
            'courier' => 'required|string'
        ]);

        $response = Http::withOptions([
            'verify' => false, // Disable SSL verification for development
        ])->asForm()->withHeaders([
            'Accept' => 'application/json',
            'key' => config('rajaongkir.api_key'),
        ])->post('https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost', [
            'origin' => 3942, // ID kecamatan Diwek (ganti sesuai kebutuhan)
            'destination' => $request->input('destination_district_id'),
            'weight' => $request->input('weight'),
            'courier' => $request->input('courier'),
        ]);

        if ($response->successful()) {
            $responseData = $response->json();
            
            // Debug log
            \Log::info('RajaOngkir Response', [
                'full_response' => $responseData,
                'courier' => $request->input('courier')
            ]);
            
            // Extract the actual results from the nested structure
            $results = null;
            
            // Try different possible structures
            if (isset($responseData['rajaongkir']['results'])) {
                $results = $responseData['rajaongkir']['results'];
            } elseif (isset($responseData['data'])) {
                $results = $responseData['data'];
            } elseif (isset($responseData['results'])) {
                $results = $responseData['results'];
            }
            
            if ($results === null) {
                \Log::error('Could not find results in response structure', [
                    'response' => $responseData
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid response structure from shipping API',
                    'debug' => $responseData
                ], 500);
            }

            return response()->json([
                'success' => true,
                'data' => $results
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to calculate shipping cost',
            'status' => $response->status(),
            'error' => $response->body()
        ], 500);
    }
}
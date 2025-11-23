<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RajaOngkirService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('rajaongkir.api_key');
        $this->baseUrl = config('rajaongkir.base_url');
    }

    /**
     * Search city by name - PAKAI ENDPOINT YANG SAMA SEPERTI CONTROLLER
     */
    public function searchCity($cityName)
    {
        try {
            // Pakai approach yang sama seperti controller yang berhasil
            $response = Http::withOptions([
                'verify' => false, // Sama seperti controller
            ])->withHeaders([
                'Accept' => 'application/json',
                'key' => $this->apiKey,
            ])->get($this->baseUrl . 'destination/city', [
                'search' => $cityName // Coba parameter ini
            ]);

            Log::info('RajaOngkir City Search Request:', [
                'url' => $this->baseUrl . 'destination/city',
                'city' => $cityName
            ]);

            if ($response->successful()) {
                $data = $response->json();
                Log::info('RajaOngkir City Search Response:', $data);
                
                // Sesuaikan dengan struktur response dari API komerce.id
                if (isset($data['data'][0])) {
                    return $data['data'][0]; // Format: ['data' => [...]]
                }
            } else {
                Log::error('RajaOngkir City Search Failed:', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
            }
            
            return null;
            
        } catch (\Exception $e) {
            Log::error('RajaOngkir City Search Exception: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get city by ID - untuk tracking
     */
    public function getCity($cityId)
    {
        try {
            $response = Http::withOptions([
                'verify' => false,
            ])->withHeaders([
                'Accept' => 'application/json', 
                'key' => $this->apiKey,
            ])->get($this->baseUrl . 'destination/city/' . $cityId);

            if ($response->successful()) {
                $data = $response->json();
                return $data['data'] ?? null;
            }
            
            return null;
            
        } catch (\Exception $e) {
            Log::error('RajaOngkir Get City Error: ' . $e->getMessage());
            return null;
        }
    }
}
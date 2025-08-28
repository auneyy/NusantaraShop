<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class ImageKitService
{
    protected $client;
    protected $publicKey;
    protected $privateKey;
    protected $urlEndpoint;

    public function __construct()
    {
        $this->client = new Client();
        $this->publicKey = env('IMAGEKIT_PUBLIC_KEY');
        $this->privateKey = env('IMAGEKIT_PRIVATE_KEY');
        $this->urlEndpoint = env('IMAGEKIT_URL_ENDPOINT');
    }

    public function upload($file, $fileName)
    {
        try {
            $response = $this->client->post('https://upload.imagekit.io/api/v1/files/upload', [
                'auth' => [$this->privateKey, ''], // ImageKit menggunakan private key untuk auth
                'multipart' => [
                    [
                        'name' => 'file',
                        'contents' => fopen($file->getPathname(), 'r'),
                        'filename' => $fileName
                    ],
                    [
                        'name' => 'fileName',
                        'contents' => $fileName,
                    ],
                    [
                        'name' => 'useUniqueFileName',
                        'contents' => 'true', // Pastikan nama file unik
                    ]
                ],
            ]);

            $result = json_decode($response->getBody(), true);
            
            return [
                'success' => true,
                'url' => $result['url'],
                'fileId' => $result['fileId'],
                'thumbnailUrl' => $result['thumbnailUrl'] ?? $result['url']
            ];

        } catch (\Exception $e) {
            Log::error('ImageKit Upload Error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    public function delete($fileId)
    {
        try {
            $response = $this->client->delete("https://api.imagekit.io/v1/files/{$fileId}", [
                'auth' => [$this->privateKey, '']
            ]);

            return [
                'success' => true,
                'response' => json_decode($response->getBody(), true)
            ];

        } catch (\Exception $e) {
            Log::error('ImageKit Delete Error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}
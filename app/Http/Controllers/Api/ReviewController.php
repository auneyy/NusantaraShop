<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    /**
     * Get reviews for a product
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product, Request $request)
    {
        try {
            $perPage = $request->input('per_page', 10);
            
            $reviews = $product->reviews()
                ->with('user')
                ->orderBy('created_at', 'desc')
                ->paginate($perPage);

            // Check if we're expecting JSON
            if ($request->wantsJson() || $request->ajax()) {
                // Format the reviews for the view
                $html = view('products.partials.reviews_list', [
                    'reviews' => $reviews
                ])->render();

                return response()->json([
                    'success' => true,
                    'html' => $html,
                    'next_page_url' => $reviews->nextPageUrl(),
                    'current_page' => $reviews->currentPage(),
                    'last_page' => $reviews->lastPage(),
                ]);
            }

            // If not an AJAX request, return the view directly
            return view('products.show', [
                'product' => $product->load(['reviews' => function($query) use ($perPage) {
                    $query->with('user')->latest()->paginate($perPage);
                }])
            ]);

        } catch (\Exception $e) {
            Log::error('Error loading reviews: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memuat ulasan. Silakan coba lagi nanti.'
                ], 500);
            }
            
            return back()->with('error', 'Gagal memuat ulasan. Silakan coba lagi nanti.');
        }
    }
}

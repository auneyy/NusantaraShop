<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a new review
     */
    public function store(Request $request)
{
    try {
        // Log incoming request for debugging
        Log::info('Review submission received', [
            'user_id' => Auth::id(),
            'data' => $request->all()
        ]);

        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:1000',
            'images' => 'nullable|array|max:3',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Log validated data
        Log::info('Validated data', $validated);

        DB::beginTransaction();

        // Verify order belongs to user and is delivered/diterima
        $order = Order::where('id', $validated['order_id'])
                     ->where('user_id', Auth::id())
                     ->first();

        if (!$order) {
            Log::warning('Order not found or unauthorized', [
                'order_id' => $validated['order_id'],
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan.'
            ], 404);
        }

        // Check if order is delivered
        if (!in_array($order->status, ['delivered', 'diterima'])) {
            Log::warning('Order not yet delivered', [
                'order_id' => $order->id,
                'status' => $order->status
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Pesanan belum dapat direview. Status: ' . ucfirst($order->status)
            ], 400);
        }

        // Check if product is in the order
        $orderItem = $order->orderItems()
                          ->where('product_id', $validated['product_id'])
                          ->first();

        if (!$orderItem) {
            Log::warning('Product not in order', [
                'order_id' => $order->id,
                'product_id' => $validated['product_id']
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan dalam pesanan ini.'
            ], 400);
        }

        // Check if already reviewed
        $existingReview = Review::where('user_id', Auth::id())
                               ->where('product_id', $validated['product_id'])
                               ->where('order_id', $validated['order_id'])
                               ->first();

        if ($existingReview) {
            Log::warning('Product already reviewed', [
                'order_id' => $order->id,
                'product_id' => $validated['product_id'],
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Anda sudah memberikan review untuk produk ini.'
            ], 400);
        }

        // Handle image uploads
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                try {
                    $path = $image->store('reviews', 'public');
                    $imagePaths[] = $path;
                } catch (\Exception $e) {
                    Log::error('Error uploading review image', [
                        'error' => $e->getMessage()
                    ]);
                }
            }
        }

        // Pastikan komentar tidak null jika ada input
        $komentarValue = $request->input('komentar');
        if (empty($komentarValue) || trim($komentarValue) === '') {
            $komentarValue = null;
        }

        // Create review
        $review = Review::create([
            'user_id' => Auth::id(),
            'product_id' => $validated['product_id'],
            'order_id' => $validated['order_id'],
            'rating' => $validated['rating'],
            'komentar' => $komentarValue,
            'images' => !empty($imagePaths) ? json_encode($imagePaths) : null,
            'is_verified' => true,
        ]);

        // Log created review
        Log::info('Review created', [
            'review' => $review->toArray()
        ]);

        // Update product rating statistics
        $product = Product::find($validated['product_id']);
        if ($product) {
            $product->updateRatingStats();
        }

        DB::commit();

        Log::info('Review created successfully', [
            'review_id' => $review->id,
            'user_id' => Auth::id(),
            'product_id' => $validated['product_id'],
            'order_id' => $validated['order_id'],
            'rating' => $validated['rating'],
            'komentar' => $review->komentar
        ]);

        // Return JSON response
        return response()->json([
            'success' => true,
            'message' => 'Review berhasil ditambahkan! Terima kasih atas feedback Anda.',
            'review' => [
                'id' => $review->id,
                'rating' => $review->rating,
                'komentar' => $review->komentar,
                'created_at' => $review->created_at->format('d M Y')
            ]
        ], 200);

    } catch (\Illuminate\Validation\ValidationException $e) {
        DB::rollBack();

        Log::error('Validation error in review submission', [
            'errors' => $e->errors(),
            'user_id' => Auth::id()
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Data tidak valid.',
            'errors' => $e->errors()
        ], 422);

    } catch (\Exception $e) {
        DB::rollBack();

        Log::error('Error creating review', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'user_id' => Auth::id(),
            'product_id' => $request->product_id ?? null
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Gagal menambahkan review. Silakan coba lagi.',
            'error' => config('app.debug') ? $e->getMessage() : null
        ], 500);
    }
}

    /**
     * Get reviews for a product with pagination
     */
    public function getProductReviews($productId)
    {
        try {
            $product = Product::findOrFail($productId);

            // Get reviews with pagination
            $reviews = Review::where('product_id', $productId)
                ->with('user:id,name') // Only load necessary user fields
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            // Calculate statistics
            $totalReviews = $product->total_reviews;
            $averageRating = $product->rating_rata;
            $ratingDistribution = $product->getRatingDistribution();
            $ratingPercentages = $product->getRatingPercentages();

            // Return HTML view for AJAX requests
            if (request()->ajax() || request()->expectsJson()) {
                $html = view('partials.reviews_list', compact('reviews'))->render();

                return response()->json([
                    'success' => true,
                    'html' => $html,
                    'stats' => [
                        'average_rating' => $averageRating,
                        'total_reviews' => $totalReviews,
                        'rating_distribution' => $ratingDistribution,
                        'rating_percentages' => $ratingPercentages
                    ]
                ]);
            }

            return response()->json([
                'success' => true,
                'reviews' => $reviews,
                'stats' => [
                    'average_rating' => $averageRating,
                    'total_reviews' => $totalReviews,
                    'rating_distribution' => $ratingDistribution,
                    'rating_percentages' => $ratingPercentages
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching reviews', [
                'product_id' => $productId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat review.',
                'html' => view('partials.reviews_list', ['reviews' => collect()])->render()
            ], 500);
        }
    }

    /**
     * Update a review
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:1000',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'delete_images' => 'nullable|array'
        ]);

        try {
            DB::beginTransaction();

            $review = Review::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            // Handle existing images
            $existingImages = $review->images ? json_decode($review->images, true) : [];

            // Delete images if requested
            if (isset($validated['delete_images'])) {
                foreach ($validated['delete_images'] as $imagePath) {
                    if (in_array($imagePath, $existingImages)) {
                        Storage::disk('public')->delete($imagePath);
                        $existingImages = array_diff($existingImages, [$imagePath]);
                    }
                }
            }

            // Handle new image uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('reviews', 'public');
                    $existingImages[] = $path;
                }
            }

            $review->update([
                'rating' => $validated['rating'],
                'komentar' => $validated['komentar'] ?? null,
                'images' => !empty($existingImages) ? json_encode(array_values($existingImages)) : null
            ]);

            // Update product rating statistics
            $product = Product::find($review->product_id);
            if ($product) {
                $product->updateRatingStats();
            }

            DB::commit();

            Log::info('Review updated', [
                'review_id' => $review->id,
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Review berhasil diperbarui!',
                'review' => $review->load('user')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error updating review', [
                'review_id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui review.'
            ], 500);
        }
    }

    /**
     * Delete a review
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $review = Review::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $productId = $review->product_id;

            // Delete associated images
            if ($review->images) {
                $images = json_decode($review->images, true);
                foreach ($images as $imagePath) {
                    Storage::disk('public')->delete($imagePath);
                }
            }

            $review->delete();

            // Update product rating statistics
            $product = Product::find($productId);
            if ($product) {
                $product->updateRatingStats();
            }

            DB::commit();

            Log::info('Review deleted', [
                'review_id' => $id,
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Review berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error deleting review', [
                'review_id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus review.'
            ], 500);
        }
    }

    /**
     * Get user's reviews
     */
    public function getUserReviews()
    {
        try {
            $reviews = Review::where('user_id', Auth::id())
                ->with(['product', 'order'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return response()->json([
                'success' => true,
                'reviews' => $reviews
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching user reviews', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat review.'
            ], 500);
        }
    }

    /**
     * Check if user can review product from order
     */
    public function canReview(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id'
        ]);

        try {
            $order = Order::where('id', $request->order_id)
                ->where('user_id', Auth::id())
                ->first();

            if (!$order) {
                return response()->json([
                    'can_review' => false,
                    'reason' => 'Order tidak ditemukan'
                ]);
            }

            if (!in_array($order->status, ['delivered', 'diterima'])) {
                return response()->json([
                    'can_review' => false,
                    'reason' => 'Pesanan belum diterima'
                ]);
            }

            $hasReview = Review::where('user_id', Auth::id())
                ->where('product_id', $request->product_id)
                ->where('order_id', $request->order_id)
                ->exists();

            if ($hasReview) {
                return response()->json([
                    'can_review' => false,
                    'reason' => 'Sudah memberikan review'
                ]);
            }

            return response()->json([
                'can_review' => true,
                'reason' => null
            ]);
        } catch (\Exception $e) {
            Log::error('Error checking review eligibility', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'can_review' => false,
                'reason' => 'Terjadi kesalahan'
            ], 500);
        }
    }
}

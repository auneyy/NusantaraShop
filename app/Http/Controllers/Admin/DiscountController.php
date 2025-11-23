<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\ImageKitService;
use Carbon\Carbon;

class DiscountController extends Controller
{
    private $imageKitService;

    public function __construct(ImageKitService $imageKitService)
    {
        $this->imageKitService = $imageKitService;
    }

    public function index(Request $request)
    {
        $query = Discount::with('products');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('subtitle', 'like', "%{$search}%")
                  ->orWhereHas('products', function($productQuery) use ($search) {
                      $productQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $now = Carbon::now('Asia/Jakarta');
            
            if ($request->status === 'active') {
                $query->where('start_date', '<=', $now)
                      ->where('end_date', '>=', $now);
            } elseif ($request->status === 'upcoming') {
                $query->where('start_date', '>', $now);
            } elseif ($request->status === 'expired') {
                $query->where('end_date', '<', $now);
            }
        }

        // Filter by percentage range
        if ($request->has('min_percentage') && $request->min_percentage != '') {
            $query->where('percentage', '>=', $request->min_percentage);
        }

        if ($request->has('max_percentage') && $request->max_percentage != '') {
            $query->where('percentage', '<=', $request->max_percentage);
        }

        // Filter by date range
        if ($request->has('start_date_filter') && $request->start_date_filter != '') {
            $query->whereDate('start_date', '>=', $request->start_date_filter);
        }

        if ($request->has('end_date_filter') && $request->end_date_filter != '') {
            $query->whereDate('end_date', '<=', $request->end_date_filter);
        }

        $discounts = $query->orderBy('created_at', 'desc')
                          ->paginate(10)
                          ->appends($request->except('page'));

        return view('admin.discounts.index', compact('discounts'));
    }

    public function show(Discount $discount)
    {
        $discount->load('products');
        return view('admin.discounts.show', compact('discount'));
    }

    // Method untuk mendapatkan banner aktif (real-time check)
    public function getActiveBanner()
    {
        return Discount::active()
            ->whereNotNull('banner_image')
            ->orderBy('created_at', 'desc')
            ->first();
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.discounts.create', compact('products'));
    }

    // Method untuk mendapatkan discount aktif untuk produk tertentu (real-time check)
    public function getActiveDiscountsForProducts($products)
    {
        return Discount::active()
            ->whereHas('products', function($query) use ($products) {
                $query->whereIn('products.id', $products->pluck('id'));
            })
            ->with('products')
            ->get();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'percentage' => 'required|integer|min:1|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'products' => 'required|array|min:1',
            'products.*' => 'exists:products,id',
        ], [
            'end_date.after' => 'Tanggal berakhir harus setelah tanggal mulai.',
            'products.required' => 'Pilih minimal 1 produk.',
            'products.min' => 'Pilih minimal 1 produk.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $bannerUrl = null;

        if ($request->hasFile('banner_image')) {
            $fileName = 'discount_' . time() . '.' . $request->file('banner_image')->getClientOriginalExtension();
            $uploadResult = $this->imageKitService->upload($request->file('banner_image'), $fileName);

            if ($uploadResult['success']) {
                $bannerUrl = $uploadResult['url'];
            } else {
                return redirect()->back()->with('error', 'Image upload failed: ' . $uploadResult['error']);
            }
        }

        $discount = Discount::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'percentage' => $request->percentage,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'banner_image' => $bannerUrl,
        ]);

        $discount->products()->sync($request->products);

        return redirect()->route('admin.discounts.index')
            ->with('success', 'Diskon berhasil ditambahkan!');
    }

    public function edit(Discount $discount)
    {
        $products = Product::all();
        $selectedProducts = $discount->products->pluck('id')->toArray();
        
        return view('admin.discounts.edit', compact('discount', 'products', 'selectedProducts'));
    }

    public function update(Request $request, Discount $discount)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'percentage' => 'required|integer|min:1|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'products' => 'required|array|min:1',
            'products.*' => 'exists:products,id',
        ], [
            'end_date.after' => 'Tanggal berakhir harus setelah tanggal mulai.',
            'products.required' => 'Pilih minimal 1 produk.',
            'products.min' => 'Pilih minimal 1 produk.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Handle banner image update
        if ($request->hasFile('banner_image')) {
            // Delete old image if exists
            if ($discount->banner_image) {
                $fileId = $this->extractFileIdFromUrl($discount->banner_image);
                if ($fileId) {
                    $this->imageKitService->delete($fileId);
                }
            }

            // Upload new image
            $fileName = 'discount_' . time() . '.' . $request->file('banner_image')->getClientOriginalExtension();
            $uploadResult = $this->imageKitService->upload($request->file('banner_image'), $fileName);

            if ($uploadResult['success']) {
                $discount->banner_image = $uploadResult['url'];
            } else {
                return redirect()->back()->with('error', 'Image upload failed: ' . $uploadResult['error']);
            }
        }

        // Update discount details
        $discount->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'percentage' => $request->percentage,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        // Update associated products
        $discount->products()->sync($request->products);

        return redirect()->route('admin.discounts.index')
            ->with('success', 'Diskon berhasil diupdate!');
    }

    public function destroy(Discount $discount)
    {
        if ($discount->banner_image) {
            $fileId = $this->extractFileIdFromUrl($discount->banner_image);
            if ($fileId) {
                $this->imageKitService->delete($fileId);
            }
        }

        $discount->products()->detach();
        $discount->delete();

        return redirect()->route('admin.discounts.index')
            ->with('success', 'Diskon berhasil dihapus!');
    }

    private function extractFileIdFromUrl($url)
    {
        $path = parse_url($url, PHP_URL_PATH);
        $parts = explode('/', $path);
        return end($parts);
    }

    public function checkStatus(Request $request)
    {
        $productIds = $request->input('product_ids', []);
        
        $activeDiscounts = Discount::active()
            ->whereHas('products', function($query) use ($productIds) {
                $query->whereIn('products.id', $productIds);
            })
            ->with('products')
            ->get();
        
        return response()->json([
            'success' => true,
            'discounts' => $activeDiscounts->map(function($discount) {
                return [
                    'id' => $discount->id,
                    'percentage' => $discount->percentage,
                    'end_date' => $discount->end_date->toIso8601String(),
                    'time_remaining' => $discount->time_remaining,
                    'product_ids' => $discount->products->pluck('id'),
                ];
            })
        ]);
    }
}
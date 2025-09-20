<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\ImageKitService;

class DiscountController extends Controller
{
    private $imageKitService;

    public function __construct(ImageKitService $imageKitService)
    {
        $this->imageKitService = $imageKitService;
    }

    public function index()
    {
        $discounts = Discount::with('products')->paginate(10);
        return view('admin.discounts.index', compact('discounts'));
    }

    public function show(Discount $discount)
{
    $discount->load('products'); // Eager load the products relationship
    return view('admin.discounts.show', compact('discount'));
}

public function getActiveBanner()
{
    $currentDate = now()->format('Y-m-d');
    
    return Discount::where('start_date', '<=', $currentDate)
        ->where('end_date', '>=', $currentDate)
        ->whereNotNull('banner_image')
        ->orderBy('created_at', 'desc')
        ->first();
}

    public function create()
    {
        $products = Product::all();
        return view('admin.discounts.create', compact('products'));
    }

    public function getActiveDiscountsForProducts($products)
{
    $currentDate = now()->format('Y-m-d');
    
    return Discount::where('start_date', '<=', $currentDate)
        ->where('end_date', '>=', $currentDate)
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
            'end_date' => 'required|date|after_or_equal:start_date',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'products' => 'required|array|min:1',
            'products.*' => 'exists:products,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $bannerUrl = null;
        $fileId = null;

        if ($request->hasFile('banner_image')) {
            $fileName = 'discount_' . time() . '.' . $request->file('banner_image')->getClientOriginalExtension();
            $uploadResult = $this->imageKitService->upload($request->file('banner_image'), $fileName);

            if ($uploadResult['success']) {
                $bannerUrl = $uploadResult['url'];
                $fileId = $uploadResult['fileId'];
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

        return redirect()->route('admin.discounts.index');
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
            'end_date' => 'required|date|after_or_equal:start_date',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'products' => 'required|array|min:1',
            'products.*' => 'exists:products,id',
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

        return redirect()->route('admin.discounts.index');
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

        return redirect()->route('admin.discounts.index');
    }

    private function extractFileIdFromUrl($url)
    {
        $path = parse_url($url, PHP_URL_PATH);
        $parts = explode('/', $path);
        return end($parts);
    }
}
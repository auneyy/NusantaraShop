<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\ProductSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Services\ImageKitService;

class ProductController extends Controller
{
    protected $imageKitService;

    public function __construct(ImageKitService $imageKitService)
    {
        $this->imageKitService = $imageKitService;
    }

    public function index(Request $request)
    {
        $query = Product::with(['category', 'images' => function($query) {
            $query->orderBy('is_primary', 'desc')->orderBy('sort_order');
        }]);

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhereHas('category', function($categoryQuery) use ($search) {
                      $categoryQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by category
        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by featured
        if ($request->has('is_featured') && $request->is_featured != '') {
            $query->where('is_featured', $request->is_featured);
        }

        // Filter by stock (now based on product_sizes total)
        if ($request->has('stock_status') && $request->stock_status != '') {
            $query->whereHas('sizes', function($sizeQuery) use ($request) {
                if ($request->stock_status === 'low') {
                    $sizeQuery->havingRaw('SUM(stock) <= 10');
                } elseif ($request->stock_status === 'out') {
                    $sizeQuery->havingRaw('SUM(stock) = 0');
                } elseif ($request->stock_status === 'available') {
                    $sizeQuery->havingRaw('SUM(stock) > 0');
                }
            });
        }

        // Filter by price range
        if ($request->has('min_price') && $request->min_price != '') {
            $query->where('harga', '>=', $request->min_price);
        }

        if ($request->has('max_price') && $request->max_price != '') {
            $query->where('harga', '<=', $request->max_price);
        }

        $products = $query->latest()
                         ->paginate(10)
                         ->appends($request->except('page'));

        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'sku' => 'required|string|max:100|unique:products,sku',
            'harga' => 'required|numeric|min:0',
            'berat' => 'nullable|numeric|min:0',
            'status' => 'required|in:tersedia,habis,pre-order',
            'is_featured' => 'nullable|boolean',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'primary_image' => 'required|integer|min:0',
            'sizes' => 'required|array|min:1',
            'sizes.*.size' => 'required|string|max:20',
            'sizes.*.stock' => 'required|integer|min:0'
        ]);

        try {
            DB::beginTransaction();

            $slug = Str::slug($validated['name']);

            // Create product with stock_kuantitas = 0 (now using sizes)
            $product = Product::create([
                'category_id' => $validated['category_id'],
                'name' => $validated['name'],
                'slug' => $slug,
                'deskripsi' => $validated['deskripsi'],
                'harga' => $validated['harga'],
                'sku' => $validated['sku'],
                'stock_kuantitas' => 0, // Set to 0 karena sekarang pakai stock per size
                'berat' => $validated['berat'] ?? null,
                'status' => $validated['status'],
                'is_featured' => $validated['is_featured'] ?? false,
                'meta_data' => null
            ]);

            // Create product sizes
            foreach ($validated['sizes'] as $sizeData) {
                $product->sizes()->create([
                    'size' => $sizeData['size'],
                    'stock' => $sizeData['stock']
                ]);
            }
            
            // Upload images
            foreach ($request->file('images') as $index => $image) {
                try {
                    $fileName = 'product_' . $product->id . '_' . time() . '_' . $index . '.' . $image->getClientOriginalExtension();
                    
                    $uploadResult = $this->imageKitService->upload($image, $fileName);
                    
                    if (!$uploadResult['success']) {
                        throw new \Exception($uploadResult['error']);
                    }
                    
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $uploadResult['url'],
                        'thumbnail_url' => $uploadResult['thumbnailUrl'],
                        'file_id' => $uploadResult['fileId'],
                        'is_primary' => $index == $request->primary_image,
                        'sort_order' => $index
                    ]);

                } catch (\Exception $e) {
                    Log::error('ImageKit Upload Error: ' . $e->getMessage());
                    DB::rollBack();
                    return back()->withInput()->with('error', 'Gagal mengunggah gambar ke ImageKit. Silakan coba lagi.');
                }
            }
            
            DB::commit();

            return redirect()->route('admin.products.index')
                             ->with('success', 'Produk berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating product: '.$e->getMessage());
            return back()->withInput()
                         ->with('error', 'Gagal menambahkan produk. Silakan coba lagi.');
        }
    }

    /**
     * Show product sizes management page
     */
    public function sizes(Product $product)
    {
        $product->load('sizes');
        return view('admin.products.sizes', compact('product'));
    }

    /**
     * Add size to product
     */
    public function addSize(Request $request, Product $product)
    {
        $request->validate([
            'size' => 'required|string|max:20',
            'stock' => 'required|integer|min:0'
        ]);

        try {
            // Check if size already exists
            if ($product->sizes()->where('size', $request->size)->exists()) {
                return back()->with('error', 'Size sudah ada untuk produk ini!');
            }

            $product->sizes()->create([
                'size' => $request->size,
                'stock' => $request->stock
            ]);

            return back()->with('success', 'Size berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error('Error adding product size: '.$e->getMessage());
            return back()->with('error', 'Gagal menambahkan size!');
        }
    }

    /**
     * Update product size stock
     */
    public function updateSize(Request $request, Product $product, $sizeId)
    {
        $request->validate([
            'stock' => 'required|integer|min:0'
        ]);

        try {
            $size = $product->sizes()->findOrFail($sizeId);
            $size->update(['stock' => $request->stock]);

            return response()->json(['success' => true, 'message' => 'Stock berhasil diupdate!']);
        } catch (\Exception $e) {
            Log::error('Error updating product size: '.$e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal update stock!'], 500);
        }
    }

    /**
     * Remove size from product
     */
    public function removeSize(Product $product, $sizeId)
    {
        try {
            $size = $product->sizes()->findOrFail($sizeId);
            $size->delete();

            return back()->with('success', 'Size berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Error removing product size: '.$e->getMessage());
            return back()->with('error', 'Gagal menghapus size!');
        }
    }

    public function show(Product $product)
    {
        $product->load(['category', 'images' => function($query) {
            $query->orderBy('is_primary', 'desc')->orderBy('sort_order');
        }, 'sizes']);
        
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $product->load(['images', 'sizes']);
        
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function deleteImage($id)
    {
        $image = ProductImage::find($id);
        if (!$image) {
            return response()->json(['success' => false, 'message' => 'Gambar tidak ditemukan'], 404);
        }

        try {
            if ($image->file_id) {
                $deleteResult = $this->imageKitService->delete($image->file_id);
                if (!$deleteResult['success']) {
                    Log::error('ImageKit Delete Error: ' . ($deleteResult['error'] ?? 'Unknown error'));
                }
            }
            
            $image->delete();
            
            return response()->json(['success' => true, 'message' => 'Gambar berhasil dihapus']);
        } catch (\Exception $e) {
            Log::error('Error deleting product image: '.$e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal menghapus gambar'], 500);
        }
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'sku' => 'required|string|max:100|unique:products,sku,'.$product->id,
            'harga' => 'required|numeric|min:0',
            'berat' => 'nullable|numeric|min:0',
            'status' => 'required|in:tersedia,habis,pre-order',
            'is_featured' => 'nullable|boolean',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'primary_image' => 'nullable|string',
            'delete_images' => 'nullable|array',
            'sizes' => 'required|array|min:1',
            'sizes.*.size' => 'required|string|max:20',
            'sizes.*.stock' => 'required|integer|min:0'
        ]);

        try {
            DB::beginTransaction();

            $slug = $product->slug;
            if ($product->name !== $validated['name']) {
                $slug = Str::slug($validated['name']);
            }

            // Update product
            $product->update([
                'category_id' => $validated['category_id'],
                'name' => $validated['name'],
                'slug' => $slug,
                'deskripsi' => $validated['deskripsi'],
                'harga' => $validated['harga'],
                'sku' => $validated['sku'],
                'stock_kuantitas' => 0, // Set to 0 karena sekarang pakai stock per size
                'berat' => $validated['berat'] ?? null,
                'status' => $validated['status'],
                'is_featured' => $validated['is_featured'] ?? false,
                'meta_data' => null
            ]);

            // Update sizes - delete all existing and create new ones
            $product->sizes()->delete();
            foreach ($validated['sizes'] as $sizeData) {
                $product->sizes()->create([
                    'size' => $sizeData['size'],
                    'stock' => $sizeData['stock']
                ]);
            }

            // Handle image deletion
            if (isset($validated['delete_images'])) {
                foreach ($validated['delete_images'] as $imageId) {
                    $image = ProductImage::find($imageId);
                    if ($image && $image->product_id == $product->id) {
                        if ($image->file_id) {
                            $deleteResult = $this->imageKitService->delete($image->file_id);
                            if (!$deleteResult['success']) {
                                Log::error('ImageKit Delete Error: ' . ($deleteResult['error'] ?? 'Unknown error'));
                            }
                        }
                        $image->delete();
                    }
                }
            }

            // Handle new image uploads
            $newImagePaths = [];
            if ($request->hasFile('images')) {
                $maxSort = $product->images()->max('sort_order') ?? 0;
                
                foreach ($request->file('images') as $index => $image) {
                    try {
                        $fileName = 'product_' . $product->id . '_' . time() . '_' . $index . '.' . $image->getClientOriginalExtension();
                        
                        $uploadResult = $this->imageKitService->upload($image, $fileName);
                        
                        if (!$uploadResult['success']) {
                            throw new \Exception($uploadResult['error']);
                        }
                        
                        $newImagePaths[] = $uploadResult['url'];

                        ProductImage::create([
                            'product_id' => $product->id,
                            'image_path' => $uploadResult['url'],
                            'thumbnail_url' => $uploadResult['thumbnailUrl'],
                            'file_id' => $uploadResult['fileId'],
                            'is_primary' => false,
                            'sort_order' => ++$maxSort
                        ]);

                    } catch (\Exception $e) {
                        Log::error('ImageKit Upload Error: ' . $e->getMessage());
                        DB::rollBack();
                        return back()->withInput()->with('error', 'Gagal mengunggah gambar baru ke ImageKit. Silakan coba lagi.');
                    }
                }
            }

            // Handle primary image selection
            if ($request->has('primary_image')) {
                ProductImage::where('product_id', $product->id)->update(['is_primary' => false]);
                
                $primaryImageValue = $request->input('primary_image');

                if (is_numeric($primaryImageValue)) {
                    ProductImage::where('id', $primaryImageValue)
                        ->where('product_id', $product->id)
                        ->update(['is_primary' => true]);
                } else {
                    $index = explode('-', $primaryImageValue)[2];
                    if (isset($newImagePaths[$index])) {
                        ProductImage::where('product_id', $product->id)
                            ->where('image_path', $newImagePaths[$index])
                            ->update(['is_primary' => true]);
                    }
                }
            }
            
            DB::commit();

            return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating product: '.$e->getMessage());
            return back()->withInput()->with('error', 'Gagal memperbarui produk. Silakan coba lagi.');
        }
    }

    public function destroy(Product $product)
    {
        try {
            DB::beginTransaction();
            
            // Delete images
            foreach ($product->images as $image) {
                if ($image->file_id) {
                    $deleteResult = $this->imageKitService->delete($image->file_id);
                    if (!$deleteResult['success']) {
                        Log::error('ImageKit Delete Error: ' . ($deleteResult['error'] ?? 'Unknown error'));
                    }
                }
                $image->delete();
            }

            // Delete sizes
            $product->sizes()->delete();

            // Delete product
            $product->delete();
            
            DB::commit();
            
            return redirect()->route('admin.products.index')
                             ->with('success', 'Produk berhasil dihapus!');
                             
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting product: '.$e->getMessage());
            return back()->with('error', 'Gagal menghapus produk. Silakan coba lagi.');
        }
    }

    public function quickStoreCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'slug' => 'nullable|string|max:255|unique:categories,slug'
        ]);

        try {
            $category = Category::create([
                'name' => $request->name,
                'slug' => $request->slug ?? Str::slug($request->name),
                'status' => 'active'
            ]);

            return response()->json([
                'success' => true,
                'category' => $category,
                'message' => 'Kategori berhasil ditambahkan'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error creating category: '.$e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan kategori'
            ], 500);
        }
    }
}
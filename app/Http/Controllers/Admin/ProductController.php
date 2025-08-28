<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Services\ImageKitService; // Tambahkan ini

class ProductController extends Controller
{
    protected $imageKitService;

    // Inject ImageKitService melalui constructor
    public function __construct(ImageKitService $imageKitService)
    {
        $this->imageKitService = $imageKitService;
    }

    public function index()
    {
        $products = Product::with(['category', 'images' => function($query) {
            $query->orderBy('is_primary', 'desc')->orderBy('sort_order');
        }])->latest()->paginate(10);
        
        return view('admin.products.index', compact('products'));
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
            'harga_jual' => 'nullable|numeric|min:0',
            'stock_kuantitas' => 'required|integer|min:0',
            'berat' => 'nullable|numeric|min:0',
            'status' => 'required|in:tersedia,habis,pre-order',
            'is_featured' => 'nullable|boolean',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'primary_image' => 'required|integer|min:0'
        ]);

        try {
            DB::beginTransaction();

            // Generate slug
            $slug = Str::slug($validated['name']);

            $product = Product::create([
                'category_id' => $validated['category_id'],
                'name' => $validated['name'],
                'slug' => $slug,
                'deskripsi' => $validated['deskripsi'],
                'harga' => $validated['harga'],
                'harga_jual' => $validated['harga_jual'] ?? null,
                'sku' => $validated['sku'],
                'stock_kuantitas' => $validated['stock_kuantitas'],
                'berat' => $validated['berat'] ?? null,
                'status' => $validated['status'],
                'is_featured' => $validated['is_featured'] ?? false,
                'meta_data' => null
            ]);
            
            // GANTI KODE UNGGAH IMGBB DENGAN IMAGEKIT
            foreach ($request->file('images') as $index => $image) {
                try {
                    // Generate nama file yang unik
                    $fileName = 'product_' . $product->id . '_' . time() . '_' . $index . '.' . $image->getClientOriginalExtension();
                    
                    // Upload ke ImageKit
                    $uploadResult = $this->imageKitService->upload($image, $fileName);
                    
                    if (!$uploadResult['success']) {
                        throw new \Exception($uploadResult['error']);
                    }
                    
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $uploadResult['url'], // URL dari ImageKit
                        'thumbnail_url' => $uploadResult['thumbnailUrl'], // Thumbnail URL dari ImageKit
                        'file_id' => $uploadResult['fileId'], // Simpan fileId untuk keperluan delete
                        'is_primary' => $index == $request->primary_image,
                        'sort_order' => $index
                    ]);

                } catch (\Exception $e) {
                    Log::error('ImageKit Upload Error: ' . $e->getMessage());
                    // Rollback transaksi jika ada error pada unggahan gambar
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

    public function show(Product $product)
    {
        $product->load(['category', 'images' => function($query) {
            $query->orderBy('is_primary', 'desc')->orderBy('sort_order');
        }]);
        
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $product->load('images');
        
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function deleteImage($id)
    {
        $image = ProductImage::find($id);
        if (!$image) {
            return response()->json(['success' => false, 'message' => 'Gambar tidak ditemukan'], 404);
        }

        try {
            // Hapus dari ImageKit jika ada file_id
            if ($image->file_id) {
                $deleteResult = $this->imageKitService->delete($image->file_id);
                if (!$deleteResult['success']) {
                    Log::error('ImageKit Delete Error: ' . ($deleteResult['error'] ?? 'Unknown error'));
                }
            }
            
            // Hapus dari database
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
            'harga_jual' => 'nullable|numeric|min:0',
            'stock_kuantitas' => 'required|integer|min:0',
            'berat' => 'nullable|numeric|min:0',
            'status' => 'required|in:tersedia,habis,pre-order',
            'is_featured' => 'nullable|boolean',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'primary_image' => 'nullable|string',
            'delete_images' => 'nullable|array',
        ]);

        try {
            DB::beginTransaction();

            // Update slug jika nama berubah
            $slug = $product->slug;
            if ($product->name !== $validated['name']) {
                $slug = Str::slug($validated['name']);
            }

            $product->update([
                'category_id' => $validated['category_id'],
                'name' => $validated['name'],
                'slug' => $slug,
                'deskripsi' => $validated['deskripsi'],
                'harga' => $validated['harga'],
                'harga_jual' => $validated['harga_jual'] ?? null,
                'sku' => $validated['sku'],
                'stock_kuantitas' => $validated['stock_kuantitas'],
                'berat' => $validated['berat'] ?? null,
                'status' => $validated['status'],
                'is_featured' => $validated['is_featured'] ?? false,
                'meta_data' => null
            ]);

            // Hapus gambar yang dipilih
            if (isset($validated['delete_images'])) {
                foreach ($validated['delete_images'] as $imageId) {
                    $image = ProductImage::find($imageId);
                    if ($image && $image->product_id == $product->id) {
                        // Hapus dari ImageKit jika ada file_id
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

            $newImagePaths = [];
            if ($request->hasFile('images')) {
                $maxSort = $product->images()->max('sort_order') ?? 0;
                
                foreach ($request->file('images') as $index => $image) {
                    try {
                        // Generate nama file yang unik
                        $fileName = 'product_' . $product->id . '_' . time() . '_' . $index . '.' . $image->getClientOriginalExtension();
                        
                        // Upload ke ImageKit
                        $uploadResult = $this->imageKitService->upload($image, $fileName);
                        
                        if (!$uploadResult['success']) {
                            throw new \Exception($uploadResult['error']);
                        }
                        
                        $newImagePaths[] = $uploadResult['url']; // Simpan URL baru

                        ProductImage::create([
                            'product_id' => $product->id,
                            'image_path' => $uploadResult['url'], // URL dari ImageKit
                            'thumbnail_url' => $uploadResult['thumbnailUrl'], // Thumbnail URL dari ImageKit
                            'file_id' => $uploadResult['fileId'], // Simpan fileId untuk keperluan delete
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

            // Update primary image
            if ($request->has('primary_image')) {
                // Non-aktifkan semua gambar utama yang ada
                ProductImage::where('product_id', $product->id)->update(['is_primary' => false]);
                
                $primaryImageValue = $request->input('primary_image');

                if (is_numeric($primaryImageValue)) {
                    // Jika nilai adalah ID gambar yang sudah ada
                    ProductImage::where('id', $primaryImageValue)
                        ->where('product_id', $product->id)
                        ->update(['is_primary' => true]);
                } else {
                    // Jika nilai adalah gambar baru (misal: 'new-image-0')
                    $index = explode('-', $primaryImageValue)[2]; // Ekstrak index dari string
                    if (isset($newImagePaths[$index])) {
                        // Temukan record gambar baru berdasarkan path dan jadikan primary
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
            
            // Hapus semua gambar produk dari ImageKit dan database
            foreach ($product->images as $image) {
                // Hapus dari ImageKit jika ada file_id
                if ($image->file_id) {
                    $deleteResult = $this->imageKitService->delete($image->file_id);
                    if (!$deleteResult['success']) {
                        Log::error('ImageKit Delete Error: ' . ($deleteResult['error'] ?? 'Unknown error'));
                    }
                }
                // Hapus dari database
                $image->delete();
            }

            // Hapus produk
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
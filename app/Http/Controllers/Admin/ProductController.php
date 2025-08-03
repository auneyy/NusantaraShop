<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'images')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::active()->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'deskripsi_singkat' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'harga_jual' => 'nullable|numeric|min:0',
            'sku' => 'required|string|unique:products,sku',
            'stock_kuantitas' => 'required|integer|min:0',
            'berat' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,inactive,out_of_stock',
            'is_featured' => 'boolean',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'primary_image' => 'required|integer|min:0'
        ]);

        $product = Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'deskripsi' => $request->deskripsi,
            'deskripsi_singkat' => $request->deskripsi_singkat,
            'harga' => $request->harga,
            'harga_jual' => $request->harga_jual,
            'sku' => $request->sku,
            'stock_kuantitas' => $request->stock_kuantitas,
            'berat' => $request->berat,
            'status' => $request->status,
            'is_featured' => $request->boolean('is_featured')
        ]);

        // Upload gambar
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $imageName = time() . '_' . $index . '.' . $image->getClientOriginalExtension();
                $image->storeAs('product_images', $imageName, 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imageName,
                    'is_primary' => $index == $request->primary_image,
                    'sort_order' => $index
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function show(Product $product)
    {
        $product->load('category', 'images');
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::active()->get();
        $product->load('images');
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'deskripsi_singkat' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'harga_jual' => 'nullable|numeric|min:0',
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'stock_kuantitas' => 'required|integer|min:0',
            'berat' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,inactive,out_of_stock',
            'is_featured' => 'boolean',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'deskripsi' => $request->deskripsi,
            'deskripsi_singkat' => $request->deskripsi_singkat,
            'harga' => $request->harga,
            'harga_jual' => $request->harga_jual,
            'sku' => $request->sku,
            'stock_kuantitas' => $request->stock_kuantitas,
            'berat' => $request->berat,
            'status' => $request->status,
            'is_featured' => $request->boolean('is_featured')
        ]);

        // Upload gambar baru jika ada
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $imageName = time() . '_' . $index . '.' . $image->getClientOriginalExtension();
                $image->storeAs('product_images', $imageName, 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imageName,
                    'is_primary' => false,
                    'sort_order' => $product->images()->count()
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        // Hapus gambar dari storage
        foreach ($product->images as $image) {
            Storage::disk('public')->delete('product_images/' . $image->image_path);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus!');
    }

    public function deleteImage(ProductImage $image)
    {
        Storage::disk('public')->delete('product_images/' . $image->image_path);
        $image->delete();

        return response()->json(['success' => true]);
    }

    public function setPrimaryImage(ProductImage $image)
    {
        // Reset semua gambar menjadi bukan primary
        ProductImage::where('product_id', $image->product_id)->update(['is_primary' => false]);
        
        // Set gambar ini sebagai primary
        $image->update(['is_primary' => true]);

        return response()->json(['success' => true]);
    }
}
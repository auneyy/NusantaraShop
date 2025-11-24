<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::ordered()->paginate(10);
        return view('admin.artikel.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.artikel.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'nullable|string|in:getting-started,account-billing,troubleshooting',
            'order' => 'nullable|integer|min:0',
        ]);

        // Generate slug dari title
        $validated['slug'] = Str::slug($validated['title']);
        
        // Handle checkboxes - checkbox yang dicentang akan mengirim value, yang tidak dicentang tidak mengirim apapun
        $validated['is_featured'] = $request->has('is_featured') ? true : false;
        $validated['is_published'] = $request->has('is_published') ? true : false;
        
        // Set default order jika tidak ada
        $validated['order'] = $validated['order'] ?? 0;

        Article::create($validated);

        return redirect()->route('admin.artikel.index')
            ->with('success', 'Artikel berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $artikel)
    {
        return view('admin.artikel.show', compact('artikel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $artikel)
    {
        return view('admin.artikel.edit', compact('artikel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $artikel)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'nullable|string|in:getting-started,account-billing,troubleshooting',
            'order' => 'nullable|integer|min:0',
        ]);

        // Generate slug dari title
        $validated['slug'] = Str::slug($validated['title']);
        
        // Handle checkboxes
        $validated['is_featured'] = $request->has('is_featured') ? true : false;
        $validated['is_published'] = $request->has('is_published') ? true : false;
        
        // Set default order jika tidak ada
        $validated['order'] = $validated['order'] ?? 0;

        $artikel->update($validated);

        return redirect()->route('admin.artikel.index')
            ->with('success', 'Artikel berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $artikel)
    {
        $artikel->delete();

        return redirect()->route('admin.artikel.index')
            ->with('success', 'Artikel berhasil dihapus!');
    }
}
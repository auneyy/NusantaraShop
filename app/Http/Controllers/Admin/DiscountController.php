<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function index()
    {
        $discounts = Discount::latest()->paginate(10);
        return view('admin.discounts.index', compact('discounts'));
    }

    public function create()
    {
        return view('admin.discounts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'type' => 'required|in:percentage,fixed',
            'percentage' => 'required_if:type,percentage|nullable|integer|min:1|max:100',
            'fixed_amount' => 'required_if:type,fixed|nullable|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'banner_color' => 'required|string',
            'text_color' => 'required|string',
            'is_active' => 'boolean'
        ]);

        Discount::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'type' => $request->type,
            'percentage' => $request->type === 'percentage' ? $request->percentage : 0,
            'fixed_amount' => $request->type === 'fixed' ? $request->fixed_amount : null,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'banner_color' => $request->banner_color,
            'text_color' => $request->text_color,
            'is_active' => $request->boolean('is_active')
        ]);

        return redirect()->route('admin.discounts.index')->with('success', 'Diskon berhasil ditambahkan!');
    }

    public function show(Discount $discount)
    {
        return view('admin.discounts.show', compact('discount'));
    }

    public function edit(Discount $discount)
    {
        return view('admin.discounts.edit', compact('discount'));
    }

    public function update(Request $request, Discount $discount)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'type' => 'required|in:percentage,fixed',
            'percentage' => 'required_if:type,percentage|nullable|integer|min:1|max:100',
            'fixed_amount' => 'required_if:type,fixed|nullable|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'banner_color' => 'required|string',
            'text_color' => 'required|string',
            'is_active' => 'boolean'
        ]);

        $discount->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'type' => $request->type,
            'percentage' => $request->type === 'percentage' ? $request->percentage : 0,
            'fixed_amount' => $request->type === 'fixed' ? $request->fixed_amount : null,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'banner_color' => $request->banner_color,
            'text_color' => $request->text_color,
            'is_active' => $request->boolean('is_active')
        ]);

        return redirect()->route('admin.discounts.index')->with('success', 'Diskon berhasil diperbarui!');
    }

    public function destroy(Discount $discount)
    {
        $discount->delete();
        return redirect()->route('admin.discounts.index')->with('success', 'Diskon berhasil dihapus!');
    }

    public function toggleStatus(Discount $discount)
    {
        $discount->update(['is_active' => !$discount->is_active]);
        
        $status = $discount->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return response()->json([
            'success' => true,
            'message' => "Diskon berhasil {$status}!"
        ]);
    }
}
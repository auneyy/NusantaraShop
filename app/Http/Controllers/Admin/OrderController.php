<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')
            ->orderBy('order_date', 'desc')
            ->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['orderItems', 'user'])->findOrFail($id);
        
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $validStatuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        
        $request->validate([
            'status' => 'required|in:' . implode(',', $validStatuses)
        ]);
        
        $order->status = $request->status;
        $order->save();
        
        return redirect()->route('admin.orders.index');
    }

    public function dashboard()
    {
        $recentOrders = Order::latest()->take(5)->get();

        return view('admin.dashboard', compact('recentOrders'));
    }
}
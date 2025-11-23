<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Hitung statistik untuk hari ini
        $today = Carbon::today();
        
        // Total Penjualan Hari Ini (hanya yang sudah bayar)
        $totalSalesToday = Order::whereIn('payment_status', ['paid', 'settlement', 'capture'])
            ->whereDate('order_date', $today)
            ->sum('grand_total');

        // Pesanan Baru Hari Ini
        $newOrdersToday = Order::whereDate('order_date', $today)->count();

        // Pengguna Baru Hari Ini
        $newUsersToday = User::whereDate('created_at', $today)->count();

        // Total Produk Terjual Hari Ini
        $productsSoldToday = OrderItem::whereHas('order', function($query) use ($today) {
            $query->whereIn('payment_status', ['paid', 'settlement', 'capture'])
                  ->whereDate('order_date', $today);
        })->sum('quantity');

        // Perbandingan dengan kemarin
        $yesterday = Carbon::yesterday();
        
        $totalSalesYesterday = Order::whereIn('payment_status', ['paid', 'settlement', 'capture'])
            ->whereDate('order_date', $yesterday)
            ->sum('grand_total');
        
        $newOrdersYesterday = Order::whereDate('order_date', $yesterday)->count();
        $newUsersYesterday = User::whereDate('created_at', $yesterday)->count();
        
        $productsSoldYesterday = OrderItem::whereHas('order', function($query) use ($yesterday) {
            $query->whereIn('payment_status', ['paid', 'settlement', 'capture'])
                  ->whereDate('order_date', $yesterday);
        })->sum('quantity');

        // Hitung persentase perubahan
        $salesChange = $this->calculatePercentageChange($totalSalesToday, $totalSalesYesterday);
        $ordersChange = $this->calculatePercentageChange($newOrdersToday, $newOrdersYesterday);
        $usersChange = $this->calculatePercentageChange($newUsersToday, $newUsersYesterday);
        $productsChange = $this->calculatePercentageChange($productsSoldToday, $productsSoldYesterday);

        // Data untuk grafik 7 hari terakhir
        $chartData = $this->getSalesChartData(7);

        // Pesanan terbaru (10 pesanan terakhir)
        $recentOrders = Order::with('user')
            ->orderBy('order_date', 'desc')
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalSalesToday',
            'newOrdersToday',
            'newUsersToday',
            'productsSoldToday',
            'salesChange',
            'ordersChange',
            'usersChange',
            'productsChange',
            'chartData',
            'recentOrders'
        ));
    }

    private function calculatePercentageChange($current, $previous)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }
        
        return (($current - $previous) / $previous) * 100;
    }

    private function getSalesChartData($days = 7)
    {
        $startDate = Carbon::now()->subDays($days - 1);
        $endDate = Carbon::now();

        $salesData = Order::whereIn('payment_status', ['paid', 'settlement', 'capture'])
            ->whereBetween('order_date', [$startDate->startOfDay(), $endDate->endOfDay()])
            ->select(
                DB::raw('DATE(order_date) as date'),
                DB::raw('SUM(grand_total) as total_sales'),
                DB::raw('COUNT(*) as order_count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Format data untuk chart
        $labels = [];
        $sales = [];
        $orders = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $dayName = Carbon::now()->subDays($i)->translatedFormat('D');
            
            $salesRecord = $salesData->where('date', $date)->first();
            
            $labels[] = $dayName;
            $sales[] = $salesRecord ? ($salesRecord->total_sales / 1000000) : 0; // Convert to millions
            $orders[] = $salesRecord ? $salesRecord->order_count : 0;
        }

        return [
            'labels' => $labels,
            'sales' => $sales,
            'orders' => $orders
        ];
    }

    public function getChartData(Request $request)
    {
        $days = $request->get('days', 7);
        $chartData = $this->getSalesChartData($days);

        return response()->json($chartData);
    }
}
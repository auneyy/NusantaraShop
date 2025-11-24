<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function pendapatan(Request $request)
    {
        // Default periode: bulan ini
        $periode = $request->get('periode', 'bulan_ini');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        
        // Set tanggal berdasarkan periode
        switch ($periode) {
            case 'hari_ini':
                $startDate = Carbon::today();
                $endDate = Carbon::today();
                break;
            case 'minggu_ini':
                $startDate = Carbon::now()->startOfWeek();
                $endDate = Carbon::now()->endOfWeek();
                break;
            case 'bulan_ini':
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                break;
            case 'tahun_ini':
                $startDate = Carbon::now()->startOfYear();
                $endDate = Carbon::now()->endOfYear();
                break;
            case 'custom':
                if ($startDate && $endDate) {
                    $startDate = Carbon::parse($startDate);
                    $endDate = Carbon::parse($endDate);
                } else {
                    // Default ke bulan ini jika custom tapi tanggal tidak dipilih
                    $startDate = Carbon::now()->startOfMonth();
                    $endDate = Carbon::now()->endOfMonth();
                }
                break;
            default:
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                break;
        }

        // Query dasar untuk orders yang sudah dibayar
        $query = Order::with(['orderItems', 'user'])
            ->whereIn('payment_status', ['paid', 'settlement', 'capture'])
            ->whereBetween('order_date', [$startDate, $endDate]);

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by status pesanan
        if ($request->has('order_status') && $request->order_status != '') {
            $query->where('status', $request->order_status);
        }

        // Filter by payment method
        if ($request->has('payment_method') && $request->payment_method != '') {
            $query->where('payment_method', $request->payment_method);
        }

        // Filter by amount range
        if ($request->has('min_amount') && $request->min_amount != '') {
            $query->where('grand_total', '>=', $request->min_amount);
        }

        if ($request->has('max_amount') && $request->max_amount != '') {
            $query->where('grand_total', '<=', $request->max_amount);
        }

        $orders = $query->orderBy('order_date', 'desc')
                       ->paginate(10)
                       ->appends($request->except('page'));

        // Hitung statistik
        $totalPendapatanKotor = $orders->sum('grand_total');
        $totalShipping = $orders->sum('shipping_cost');
        $totalPendapatanProduk = $totalPendapatanKotor - $totalShipping;
        
        // Hitung diskon dan pendapatan asli
        $totalDiskon = 0;
        $totalPendapatanProdukAsli = 0;
        
        foreach ($orders as $order) {
            foreach ($order->orderItems as $item) {
                $totalDiskon += $item->discount_amount ?? 0;
                $totalPendapatanProdukAsli += ($item->subtotal + ($item->discount_amount ?? 0));
            }
        }
        
        $totalPendapatanBersih = $totalPendapatanProduk;
        $jumlahOrder = $orders->total();
        $rataRataOrder = $jumlahOrder > 0 ? $totalPendapatanKotor / $jumlahOrder : 0;

        return view('admin.laporan.pendapatan', compact(
            'orders',
            'periode',
            'startDate',
            'endDate',
            'totalPendapatanKotor',
            'totalPendapatanBersih',
            'totalPendapatanProduk',
            'totalPendapatanProdukAsli',
            'totalShipping',
            'totalDiskon',
            'jumlahOrder',
            'rataRataOrder'
        ));
    }

    public function exportExcel(Request $request)
    {
        // Logic untuk export Excel
        // ... (bisa ditambahkan kemudian)
    }

    public function exportPdf(Request $request)
    {
        // Logic untuk export PDF
        // ... (bisa ditambahkan kemudian)
    }
}
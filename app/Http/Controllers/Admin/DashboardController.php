<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total revenue (paid orders)
        $totalSales = Order::where('payment_status', 'paid')->sum('total_amount');

        // New orders today
        $newOrdersCount = Order::whereDate('created_at', today())->count();

        // Unverified payment orders
        $unverifiedCount = Order::where('payment_status', 'waiting_verification')->count();

        // Low stock products count
        $lowStockCount = Product::where('stock', '<=', 10)->count();

        // New customers in last 30 days
        $newCustomersCount = \App\Models\User::where('role', 'customer')->where('created_at', '>=', now()->subDays(30))->count();

        // Recent pending / processing orders
        $recentOrders = Order::with('user')->whereIn('status', ['pending', 'processing'])->latest()->take(5)->get();

        // 6-month sales data for chart
        $salesData = Order::select(
            DB::raw('SUM(total_amount) as total'),
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month")
        )
        ->where('payment_status', 'paid')
        ->where('created_at', '>=', now()->subMonths(6))
        ->groupBy('month')
        ->orderBy('month', 'asc')
        ->get();

        $chartLabels = [];
        $chartValues = [];

        foreach ($salesData as $data) {
            $chartLabels[] = date('F Y', strtotime($data->month . '-01'));
            $chartValues[] = (float) $data->total;
        }

        if (empty($chartLabels)) {
            for ($i = 5; $i >= 0; $i--) {
                $chartLabels[] = now()->subMonths($i)->format('F Y');
                $chartValues[] = 0.00;
            }
        }

        return view('admin.dashboard', compact(
            'totalSales',
            'newOrdersCount',
            'unverifiedCount',
            'lowStockCount',
            'newCustomersCount',
            'recentOrders',
            'chartLabels',
            'chartValues'
        ));
    }
}

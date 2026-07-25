<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'customer')->with('orders');

        // Search Filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Status Filter
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Order Count Filter
        if ($request->filled('order_filter')) {
            if ($request->order_filter === 'has_orders') {
                $query->has('orders');
            } elseif ($request->order_filter === 'no_orders') {
                $query->doesntHave('orders');
            }
        }

        $customers = $query->latest()->paginate(10)->withQueryString();

        return view('admin.customers.index', compact('customers'));
    }

    public function toggleStatus($id)
    {
        $customer = User::where('role', 'customer')->findOrFail($id);
        $customer->is_active = !$customer->is_active;
        $customer->save();

        $statusLabel = $customer->is_active ? 'diaktifkan kembali' : 'dinonaktifkan (diblokir)';
        return back()->with('success', "Status akun pelanggan {$customer->name} berhasil {$statusLabel}!");
    }

    public function exportCsv(Request $request)
    {
        $query = User::where('role', 'customer')->with('orders');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $customers = $query->latest()->get();

        $filename = "Daftar_Pelanggan_Toko_Roti_" . date('Y-m-d') . ".csv";

        $headers = [
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename={$filename}",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function () use ($customers) {
            $file = fopen('php://output', 'w');
            // Add UTF-8 BOM for Excel support
            fputs($file, "\xEF\xBB\xBF");

            // Header row
            fputcsv($file, [
                'ID Pelanggan',
                'Nama Lengkap',
                'Email',
                'No. Telepon',
                'Total Pesanan',
                'Total Pengeluaran (Rp)',
                'Status Akun',
                'Tanggal Bergabung'
            ]);

            foreach ($customers as $c) {
                $totalSpend = $c->orders->sum('total_amount');
                fputcsv($file, [
                    '#CUST-00' . $c->id,
                    $c->name,
                    $c->email,
                    $c->phone ?: '-',
                    $c->orders->count() . ' Pesanan',
                    number_format($totalSpend, 0, ',', '.'),
                    $c->is_active ? 'Aktif' : 'Nonaktif (Diblokir)',
                    $c->created_at->format('d/m/Y H:i')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

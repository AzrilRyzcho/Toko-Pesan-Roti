<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        $query = Order::with('user');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_code', 'like', "%{$search}%")
                  ->orWhereHas('user', function($u) use ($search) {
                      $u->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->has('status') && $request->status != '') {
            if ($request->status === 'unpaid') {
                $query->whereIn('payment_status', ['unpaid', 'waiting_verification']);
            } else {
                $query->where('status', $request->status);
            }
        }

        if ($request->has('export') && $request->export === 'csv') {
            $filename = "data-pesanan-" . date('Y-m-d') . ".csv";
            $headers = [
                "Content-type" => "text/csv",
                "Content-Disposition" => "attachment; filename=$filename",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0"
            ];
            $ordersToExport = $query->latest()->get();
            $callback = function() use($ordersToExport) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['ID Pesanan', 'Pelanggan', 'Tanggal', 'Total', 'Status Pembayaran', 'Status Pesanan']);
                foreach ($ordersToExport as $order) {
                    fputcsv($file, [
                        $order->order_code,
                        $order->user->name ?? 'Pelanggan',
                        $order->created_at->format('Y-m-d H:i'),
                        $order->total_amount,
                        $order->payment_status,
                        $order->status
                    ]);
                }
                fclose($file);
            };
            return response()->stream($callback, 200, $headers);
        }

        $orders = $query->latest()->paginate(10)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['items.product', 'user'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function verifyPayment(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'reject_reason' => 'nullable|required_if:action,reject|string|max:255'
        ]);

        try {
            $this->orderService->verifyPayment($id, $request->action, $request->reject_reason);
            $msg = $request->action === 'approve' ? 'Pembayaran berhasil disetujui!' : 'Pembayaran ditolak.';
            return back()->with('success', $msg);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        try {
            $this->orderService->updateOrderStatus($id, $request->status);
            return back()->with('success', 'Status pesanan berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}

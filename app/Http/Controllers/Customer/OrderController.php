<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentProofRequest;
use App\Models\Order;
use App\Services\OrderService;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        $orders = auth()->user()->orders()->latest()->paginate(10);
        return view('customer.orders', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['items.product', 'user'])->findOrFail($id);

        if ($order->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        // If unpaid, show payment upload card (Konfirmasi Pembayaran)
        if ($order->payment_status === 'unpaid') {
            return view('customer.order-detail', compact('order'));
        }

        // If paid or waiting verification, show Status Pesanan Anda (horizontal stepper page)
        return view('customer.order-status', compact('order'));
    }

    public function uploadProof(PaymentProofRequest $request, $id)
    {
        try {
            $this->orderService->uploadPaymentProof($id, $request->file('payment_proof'));
            
            // Redirect directly to Order Status Tracking page
            return redirect()->route('orders.show', $id)
                ->with('success', 'Bukti pembayaran berhasil diunggah! Mohon tunggu verifikasi admin.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}

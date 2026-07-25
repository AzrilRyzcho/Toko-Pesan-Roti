<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OrderService
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function createOrder(string $shippingAddress, ?string $notes = null): Order
    {
        $cartData = $this->cartService->getCartData();
        $cartItems = $cartData['items'];

        if ($cartItems->isEmpty()) {
            throw new \Exception("Keranjang belanja Anda kosong.");
        }

        return DB::transaction(function () use ($cartItems, $cartData, $shippingAddress, $notes) {
            // 1. Verify stock for all items
            foreach ($cartItems as $item) {
                $product = Product::lockForUpdate()->find($item->product_id);
                if (!$product->is_available || $product->stock < $item->quantity) {
                    throw new \Exception("Stok produk '{$product->name}' tidak mencukupi untuk checkout.");
                }
            }

            // 2. Decrement stock
            foreach ($cartItems as $item) {
                $product = Product::find($item->product_id);
                $product->decrement('stock', $item->quantity);
            }

            // 3. Generate Order Code
            $orderCode = 'TR-' . date('Ymd') . '-' . strtoupper(Str::random(5));

            // 4. Create Order
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_code' => $orderCode,
                'total_amount' => $cartData['totalAmount'],
                'shipping_address' => $shippingAddress,
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'payment_method' => 'bank_transfer',
                'notes' => $notes
            ]);

            // 5. Create Order Items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                    'notes' => $item->notes
                ]);
            }

            // 6. Clear Cart
            $this->cartService->clearCart();

            return $order;
        });
    }

    public function uploadPaymentProof(int $orderId, $file = null): Order
    {
        $order = Order::findOrFail($orderId);

        if ($order->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            throw new \Exception("Anda tidak memiliki akses ke pesanan ini.");
        }

        $path = $order->payment_proof;
        if ($file) {
            $path = $file->store('payment_proofs', 'public');
            if ($order->payment_proof && Storage::disk('public')->exists($order->payment_proof)) {
                Storage::disk('public')->delete($order->payment_proof);
            }
        } elseif (!$path) {
            $path = 'payment_proofs/default.jpg';
        }

        $order->update([
            'payment_proof' => $path,
            'payment_status' => 'waiting_verification'
        ]);

        return $order;
    }

    public function verifyPayment(int $orderId, string $action, ?string $rejectReason = null): Order
    {
        $order = Order::findOrFail($orderId);

        if ($order->payment_status !== 'waiting_verification') {
            throw new \Exception("Pembayaran pesanan ini tidak sedang menunggu verifikasi.");
        }

        if ($action === 'approve') {
            $order->update([
                'payment_status' => 'paid',
                'status' => 'processing'
            ]);
        } elseif ($action === 'reject') {
            $order->update([
                'payment_status' => 'unpaid',
                'notes' => $order->notes . "\n[System: Pembayaran ditolak karena " . ($rejectReason ?: 'bukti tidak valid') . "]"
            ]);
        } else {
            throw new \Exception("Aksi tidak dikenal.");
        }

        return $order;
    }

    public function updateOrderStatus(int $orderId, string $status): Order
    {
        $order = Order::findOrFail($orderId);
        $oldStatus = $order->status;

        if ($oldStatus === $status) {
            return $order;
        }

        return DB::transaction(function () use ($order, $status, $oldStatus) {
            // If transition is to cancelled, return stock to products
            if ($status === 'cancelled' && $oldStatus !== 'cancelled') {
                foreach ($order->items as $item) {
                    $product = Product::find($item->product_id);
                    if ($product) {
                        $product->increment('stock', $item->quantity);
                    }
                }
            }

            // If transition is from cancelled to something else, subtract stock again
            if ($oldStatus === 'cancelled' && $status !== 'cancelled') {
                foreach ($order->items as $item) {
                    $product = Product::find($item->product_id);
                    if ($product) {
                        if ($product->stock < $item->quantity) {
                            throw new \Exception("Stok untuk produk '{$product->name}' tidak cukup untuk memulihkan pesanan ini.");
                        }
                        $product->decrement('stock', $item->quantity);
                    }
                }
            }

            $order->update(['status' => $status]);
            return $order;
        });
    }
}

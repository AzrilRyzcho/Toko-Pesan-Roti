<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Services\CartService;
use App\Services\OrderService;

class CheckoutController extends Controller
{
    protected $cartService;
    protected $orderService;

    public function __construct(CartService $cartService, OrderService $orderService)
    {
        $this->cartService = $cartService;
        $this->orderService = $orderService;
    }

    public function index()
    {
        $cartData = $this->cartService->getCartData();
        
        if ($cartData['items']->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong, tidak dapat melakukan checkout.');
        }

        $user = auth()->user();

        return view('customer.checkout', array_merge($cartData, [
            'user' => $user
        ]));
    }

    public function store(CheckoutRequest $request)
    {
        try {
            $order = $this->orderService->createOrder(
                $request->shipping_address,
                $request->notes
            );
            return redirect()->route('orders.show', $order->id)->with('success', 'Pesanan Anda berhasil dibuat! Silakan lakukan pembayaran.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }
}

<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cartData = $this->cartService->getCartData();
        return view('customer.cart', $cartData);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:255'
        ]);

        try {
            $this->cartService->addToCart(
                $request->product_id,
                $request->quantity,
                $request->notes
            );
            return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        try {
            $this->cartService->updateQuantity($id, $request->quantity);
            return back()->with('success', 'Jumlah produk berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->cartService->removeItem($id);
            return back()->with('success', 'Produk berhasil dihapus dari keranjang!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function clear()
    {
        if ($this->cartService->clearCart()) {
            return redirect()->route('cart.index')->with('success', 'Keranjang berhasil dikosongkan!');
        }
        return redirect()->route('cart.index')->with('error', 'Gagal mengosongkan keranjang.');
    }
}

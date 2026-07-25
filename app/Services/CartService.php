<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartService
{
    public function getOrCreateCart(): Cart
    {
        $userId = Auth::id();
        if (!$userId) {
            throw new \Exception("User must be authenticated to access cart.");
        }

        return Cart::firstOrCreate(['user_id' => $userId]);
    }

    public function addToCart(int $productId, int $quantity = 1, ?string $notes = null): CartItem
    {
        $product = Product::findOrFail($productId);

        if (!$product->is_available || $product->stock < $quantity) {
            throw new \Exception("Stok produk '{$product->name}' tidak mencukupi atau produk tidak tersedia.");
        }

        $cart = $this->getOrCreateCart();

        // Check if item already exists in cart with same notes (or we can combine/update)
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $productId)
            ->where('notes', $notes)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $quantity;
            if ($product->stock < $newQuantity) {
                throw new \Exception("Stok produk '{$product->name}' tidak mencukupi untuk jumlah yang Anda inginkan.");
            }
            $cartItem->quantity = $newQuantity;
            $cartItem->save();
        } else {
            $cartItem = CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $productId,
                'quantity' => $quantity,
                'notes' => $notes
            ]);
        }

        return $cartItem;
    }

    public function updateQuantity(int $cartItemId, int $quantity): CartItem
    {
        if ($quantity <= 0) {
            throw new \Exception("Jumlah item harus lebih dari 0.");
        }

        $cartItem = CartItem::findOrFail($cartItemId);
        $product = $cartItem->product;

        if ($product->stock < $quantity) {
            throw new \Exception("Stok produk '{$product->name}' tidak mencukupi.");
        }

        $cartItem->quantity = $quantity;
        $cartItem->save();

        return $cartItem;
    }

    public function removeItem(int $cartItemId): bool
    {
        $cartItem = CartItem::findOrFail($cartItemId);
        return $cartItem->delete();
    }

    public function clearCart(): bool
    {
        try {
            $cart = $this->getOrCreateCart();
            CartItem::where('cart_id', $cart->id)->delete();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getCartData(): array
    {
        try {
            $cart = $this->getOrCreateCart();
            $items = $cart->items()->with('product')->get();
            $totalAmount = $items->sum(function($item) {
                return $item->quantity * $item->product->price;
            });
            $totalItems = $items->sum('quantity');

            return [
                'cart' => $cart,
                'items' => $items,
                'totalAmount' => $totalAmount,
                'totalItems' => $totalItems
            ];
        } catch (\Exception $e) {
            return [
                'cart' => null,
                'items' => collect(),
                'totalAmount' => 0,
                'totalItems' => 0
            ];
        }
    }
}

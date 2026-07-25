<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Favorite::with('product')->where('user_id', auth()->id())->latest()->get();
        return view('customer.favorites', compact('favorites'));
    }

    public function toggle($productId)
    {
        $product = Product::findOrFail($productId);
        $user = auth()->user();

        $favorite = Favorite::where('user_id', $user->id)->where('product_id', $product->id)->first();

        if ($favorite) {
            $favorite->delete();
            $status = 'removed';
            $message = "{$product->name} telah dihapus dari daftar Favorit Anda.";
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
            $status = 'added';
            $message = "{$product->name} berhasil ditambahkan ke daftar Favorit Anda!";
        }

        if (request()->wantsJson()) {
            return response()->json(['status' => $status, 'message' => $message]);
        }

        return back()->with('success', $message);
    }
}

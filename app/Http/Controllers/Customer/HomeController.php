<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $featuredProducts = Product::where('is_available', true)
            ->with('category')
            ->latest()
            ->take(6)
            ->get();

        return view('customer.home', compact('categories', 'featuredProducts'));
    }
}

<?php

use Illuminate\Support\Facades\Route;

// Customer Controllers
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\ProductController as CustomerProductController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\Customer\FavoriteController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\SettingController;

// Profile Controller
use App\Http\Controllers\ProfileController;

// Public / Guest Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [CustomerProductController::class, 'index'])->name('shop');
Route::get('/shop/{slug}', [CustomerProductController::class, 'show'])->name('shop.show');

// Admin Login Custom Route (Figma Screenshot 1)
Route::get('/admin/login', function () {
    if (auth()->check() && auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return view('admin.login');
})->name('admin.login');

// Authenticated User Routing
Route::middleware(['auth'])->group(function () {

    // Dynamic Redirect Dashboard
    Route::get('/dashboard', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('home');
    })->name('dashboard');

    // Profile Management (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Customer cart lifecycle
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // Customer Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    // Customer Orders & History
    Route::get('/orders', [CustomerOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [CustomerOrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{id}/status-tracking', function ($id) {
        $order = \App\Models\Order::with(['items.product', 'user'])->findOrFail($id);
        if ($order->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }
        return view('customer.order-status', compact('order'));
    })->name('orders.status-tracking');
    Route::post('/orders/{id}/proof', [CustomerOrderController::class, 'uploadProof'])->name('orders.proof');

    // Favorites / Wishlist
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/toggle/{productId}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

    // Product Review
    Route::post('/products/{id}/review', [CustomerProductController::class, 'storeReview'])->name('products.review');
});

// Admin ONLY Panel Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Categories CRUD (Resource Controller)
    Route::resource('categories', CategoryController::class);

    // Products CRUD (Resource Controller)
    Route::resource('products', AdminProductController::class);

    // Stock Management (Figma Screenshot 5)
    Route::get('/stock', function (\Illuminate\Http\Request $request) {
        $query = \App\Models\Product::with('category');
        
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->get('filter') === 'low') {
            $query->where('stock', '<=', 10);
        }

        $products = $query->latest()->paginate(10)->withQueryString();
        $lowStockProductsCount = \App\Models\Product::where('stock', '<=', 10)->count();
        $totalProductsCount = \App\Models\Product::count();
        return view('admin.stock.index', compact('products', 'lowStockProductsCount', 'totalProductsCount'));
    })->name('stock.index');

    // Orders Management (Figma Screenshot 1 - Turn 7)
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
    Route::post('/orders/{id}/verify-payment', [AdminOrderController::class, 'verifyPayment'])->name('orders.verify-payment');

    // Verifikasi Pembayaran Tab (Figma Screenshot 2 - Turn 7)
    Route::get('/verify-payments', function () {
        $pendingOrders = \App\Models\Order::with(['user', 'items.product'])->where('payment_status', 'waiting_verification')->latest()->paginate(10);
        return view('admin.orders.verify', compact('pendingOrders'));
    })->name('orders.verify');

    // Customers List
    Route::get('/customers', [AdminCustomerController::class, 'index'])->name('customers.index');
    Route::post('/customers/{id}/toggle-status', [AdminCustomerController::class, 'toggleStatus'])->name('customers.toggle-status');
    Route::get('/customers/export', [AdminCustomerController::class, 'exportCsv'])->name('customers.export');

    // Website Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

    // Sales Reports (Figma Screenshot 5 - Turn 7)
    Route::get('/reports', function () {
        $totalSales = \App\Models\Order::where('payment_status', 'paid')->sum('total_amount');
        $orders = \App\Models\Order::with('user')->where('payment_status', 'paid')->latest()->paginate(10);
        return view('admin.reports.index', compact('totalSales', 'orders'));
    })->name('reports.index');
});

require __DIR__.'/auth.php';

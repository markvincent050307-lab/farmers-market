<?php

use App\Http\Controllers\AdminSalesAnalyticsController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\XenditWebhookController;
use App\Http\Controllers\FarmerOrderController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FarmerSalesReportController;

Route::post('/webhooks/xendit', [
    XenditWebhookController::class,
    'handle'
])->name('webhooks.xendit');

Route::middleware(['auth'])->group(function () {
    Route::get('/farmer-sales-report', [FarmerSalesReportController::class, 'index'])
    ->name('farmer.sales.report');

    Route::get('/farmer-sales-report/export', [FarmerSalesReportController::class, 'export'])
    ->name('farmer.sales.report.export');

    Route::get('/wishlist', [WishlistController::class, 'index'])
    ->name('wishlist.index');

Route::post('/wishlist/{product}', [WishlistController::class, 'store'])
    ->name('wishlist.store');

Route::delete('/wishlist/{product}', [WishlistController::class, 'destroy'])
    ->name('wishlist.destroy');

    Route::post('/products/{product}/reviews', [ProductReviewController::class, 'store'])
    ->name('products.reviews.store');

    Route::patch('/farmer/orders/{id}/status', [
    FarmerOrderController::class,
    'updateStatus'
])->name('farmer.orders.updateStatus');

    Route::get('/farmer-orders', [FarmerOrderController::class, 'index'])
        ->name('farmer.orders.index');

    Route::get('/my-orders', [OrderController::class, 'index'])
    ->name('orders.index');

    Route::patch('/my-orders/{id}/cancel', [OrderController::class, 'cancel'])
    ->name('orders.cancel');

    Route::post('/checkout', [CheckoutController::class, 'store'])
    ->name('checkout.store');

    Route::get('/cart', [CartController::class, 'index'])
    ->name('cart.index');

Route::post('/cart/add/{product}', [CartController::class, 'add'])
    ->name('cart.add');

    Route::patch('/cart/update/{cartItem}', [CartController::class, 'updateQuantity'])
    ->name('cart.update');

Route::delete('/cart/remove/{cartItem}', [CartController::class, 'remove'])
    ->name('cart.remove');

    Route::get('/shop', [ProductController::class, 'shop'])
    ->name('shop.index');
    
    Route::get('/products', [ProductController::class, 'index'])
        ->name('products.index');

    Route::get('/products/create', [ProductController::class, 'create'])
        ->name('products.create');

        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])
    ->name('products.edit');

Route::put('/products/{product}', [ProductController::class, 'update'])
    ->name('products.update');

    Route::patch('/products/{product}/stock', [ProductController::class, 'updateStock'])
    ->name('products.updateStock');

    Route::post('/products', [ProductController::class, 'store'])
        ->name('products.store');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/products', [AdminProductController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('admin.products.index');

    // Admin Sales Analytics
Route::get('/admin/sales-analytics', [AdminSalesAnalyticsController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('admin.sales.analytics');

    // Admin Order Management
Route::get('/admin/orders', [AdminOrderController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('admin.orders.index');

Route::get('/admin/orders/{order}', [AdminOrderController::class, 'show'])
    ->middleware(['auth', 'verified'])
    ->name('admin.orders.show');

Route::delete('/admin/products/{product}', [AdminProductController::class, 'destroy'])
    ->middleware(['auth', 'verified'])
    ->name('admin.products.destroy');

    Route::get('/admin/products/{product}/edit', [AdminProductController::class, 'edit'])
    ->middleware(['auth', 'verified'])
    ->name('admin.products.edit');

Route::put('/admin/products/{product}', [AdminProductController::class, 'update'])
    ->middleware(['auth', 'verified'])
    ->name('admin.products.update');

Route::get('/admin/users', [AdminUserController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('admin.users.index');

    Route::patch('/admin/users/{user}/role', [AdminUserController::class, 'updateRole'])
    ->middleware(['auth', 'verified'])
    ->name('admin.users.updateRole');

    Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])
    ->middleware(['auth', 'verified'])
    ->name('admin.users.destroy');

    Route::patch('/admin/users/{user}/status', [AdminUserController::class, 'toggleStatus'])
    ->middleware(['auth', 'verified'])
    ->name('admin.users.toggleStatus');

Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user->role === 'admin') {
        return app(AdminDashboardController::class)->index();
    }

    if ($user->role === 'farmer') {
        $totalProducts = \App\Models\Product::where('user_id', $user->id)->count();

       

        $lowStockProducts = \App\Models\Product::where('user_id', $user->id)
    ->where('quantity', '<=', 5)
    ->orderBy('quantity', 'asc')
    ->get();

        $orderItems = \App\Models\OrderItem::where('farmer_id', $user->id);

        $totalOrders = (clone $orderItems)
            ->distinct('order_id')
            ->count('order_id');

        $pendingOrders = (clone $orderItems)
            ->where('status', 'pending')
            ->distinct('order_id')
            ->count('order_id');

            $processingOrders = (clone $orderItems)
    ->where('status', 'processing')
    ->distinct('order_id')
    ->count('order_id');

        $completedOrders = (clone $orderItems)
            ->where('status', 'completed')
            ->distinct('order_id')
            ->count('order_id');

        $totalSales = (clone $orderItems)
            ->where('status', 'completed')
            ->whereHas('order', function ($query) {
                $query->where('payment_status', 'paid')
                      ->orWhere('payment_method', 'cod');
            })
            ->sum(\Illuminate\Support\Facades\DB::raw('price * quantity'));

             // Sales for today
        $dailySales = (clone $orderItems)
            ->where('status', 'completed')
            ->whereHas('order', function ($query) {
                $query->where(function ($paymentQuery) {
                    $paymentQuery->where('payment_status', 'paid')
                                 ->orWhere('payment_method', 'cod');
                })->whereDate('created_at', today());
            })
            ->sum(\Illuminate\Support\Facades\DB::raw('price * quantity'));

        // Sales for this week
        $weeklySales = (clone $orderItems)
            ->where('status', 'completed')
            ->whereHas('order', function ($query) {
                $query->where(function ($paymentQuery) {
                    $paymentQuery->where('payment_status', 'paid')
                                 ->orWhere('payment_method', 'cod');
                })->whereBetween('created_at', [
                    now()->startOfWeek(),
                    now()->endOfWeek()
                ]);
            })
            ->sum(\Illuminate\Support\Facades\DB::raw('price * quantity'));

        // Sales for this month
        $monthlySales = (clone $orderItems)
            ->where('status', 'completed')
            ->whereHas('order', function ($query) {
                $query->where(function ($paymentQuery) {
                    $paymentQuery->where('payment_status', 'paid')
                                 ->orWhere('payment_method', 'cod');
                })->whereMonth('created_at', now()->month)
                  ->whereYear('created_at', now()->year);
            })
            ->sum(\Illuminate\Support\Facades\DB::raw('price * quantity'));

        $bestSellingProducts = \App\Models\OrderItem::select(
                'product_id',
                \Illuminate\Support\Facades\DB::raw('SUM(quantity) as total_quantity')
            )
            ->with('product')
            ->where('farmer_id', $user->id)
            ->where('status', 'completed')
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();

        // Recent orders belonging to this farmer
        $recentOrders = \App\Models\OrderItem::with(['order', 'product'])
            ->where('farmer_id', $user->id)
            ->latest('created_at')
            ->limit(5)
            ->get();

            $expirationProducts = \App\Models\Product::where('user_id', $user->id)
    ->whereNotNull('expiration_date')
    ->orderBy('expiration_date', 'asc')
    ->get();

      return view('farmer-dashboard', compact(
    'totalProducts',
    'lowStockProducts',
    'totalOrders',
    'pendingOrders',
    'processingOrders',
    'completedOrders',
    'totalSales',
    'dailySales',
    'weeklySales',
    'monthlySales',
    'bestSellingProducts',
    'recentOrders',
    'expirationProducts'
));
    }

    return view('customer-dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 leading-tight">
                    🌾 Farmer Dashboard
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Manage your agricultural marketplace.
                </p>
            </div>

            <span class="inline-flex items-center w-fit rounded-full bg-green-100 px-4 py-2 text-sm font-semibold text-green-800">
                🌱 Farmer Account
            </span>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gray-50 py-8">
        <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">

            {{-- Welcome Banner --}}
            <div class="overflow-hidden rounded-2xl bg-gradient-to-r from-green-800 to-green-600 p-6 text-white shadow-lg sm:p-8">
                <div class="flex flex-col justify-between gap-6 md:flex-row md:items-center">
                    <div>
                        <p class="mb-2 text-sm font-semibold uppercase tracking-wider text-green-100">
                            Your Farm, Your Business
                        </p>

                        <h3 class="text-2xl font-bold sm:text-3xl">
                            Welcome, {{ Auth::user()->name }}!
                        </h3>

                        <p class="mt-3 max-w-xl text-sm leading-6 text-green-50 sm:text-base">
                            Manage your products, monitor customer orders,
                            and track your agricultural sales in one place.
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('products.create') }}"
                           class="inline-flex items-center justify-center rounded-lg bg-white px-5 py-3 font-bold text-green-800 shadow-sm transition hover:bg-green-50">
                            + Add Product
                        </a>

                        <a href="{{ route('farmer.orders.index') }}"
                           class="inline-flex items-center justify-center rounded-lg border border-green-200 px-5 py-3 font-semibold text-white transition hover:bg-green-700">
                            View Orders →
                        </a>
                    </div>
                </div>
            </div>

            {{-- Sales Overview --}}
<section>
    <div class="mb-5">
        <div class="flex flex-wrap items-center gap-4">
            <h3 class="text-xl font-bold text-gray-800">
                📊 Sales Overview
            </h3>

            <a href="{{ route('farmer.sales.report') }}"
               style="display: inline-block; background-color: #287a45; color: white; padding: 9px 18px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 14px;">
                View Sales Report →
            </a>
        </div>

        <p class="mt-1 text-sm text-gray-500">
            A summary of your marketplace activity.
        </p>
    </div>

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">

                 {{-- Total Products --}}
                    <div class="rounded-xl border border-purple-100 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                        <div class="flex items-center justify-between">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-100 text-2xl">
                                🌾
                            </div>

                            <span class="text-xs font-semibold uppercase tracking-wide text-purple-700">
                                Inventory
                            </span>
                        </div>

                       

                        <p class="mt-5 text-sm font-medium text-gray-500">
                            Total Products
                        </p>

                        <p class="mt-2 text-3xl font-bold text-purple-800">
                            {{ $totalProducts }}
                        </p>

                        <p class="mt-2 text-xs text-gray-400">
                            Products listed in your marketplace
                        </p>
                    </div>

                    {{-- Total Sales --}}
                    <div class="rounded-xl border border-green-100 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                        <div class="flex items-center justify-between">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-100 text-2xl">
                                💰
                            </div>
                            <span class="text-xs font-semibold uppercase tracking-wide text-green-700">
                                Revenue
                            </span>
                        </div>

                        <p class="mt-5 text-sm font-medium text-gray-500">
                            Total Sales
                        </p>

                        <p class="mt-2 break-words text-2xl font-bold text-green-800">
                            ₱{{ number_format($totalSales, 2) }}
                        </p>

                        <p class="mt-2 text-xs text-gray-400">
                            Based on your existing sales calculation
                        </p>
                    </div>

                    {{-- Daily Sales --}}
<div class="rounded-xl border border-teal-100 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
    <div class="flex items-center justify-between">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-teal-100 text-2xl">
            📅
        </div>
        <span class="text-xs font-semibold uppercase tracking-wide text-teal-700">
            Today
        </span>
    </div>

    <p class="mt-5 text-sm font-medium text-gray-500">
        Today's Sales
    </p>

    <p class="mt-2 break-words text-2xl font-bold text-teal-800">
        ₱{{ number_format($dailySales, 2) }}
    </p>
</div>

{{-- Weekly Sales --}}
<div class="rounded-xl border border-indigo-100 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
    <div class="flex items-center justify-between">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-100 text-2xl">
            📊
        </div>
        <span class="text-xs font-semibold uppercase tracking-wide text-indigo-700">
            This Week
        </span>
    </div>

    <p class="mt-5 text-sm font-medium text-gray-500">
        Weekly Sales
    </p>

    <p class="mt-2 break-words text-2xl font-bold text-indigo-800">
        ₱{{ number_format($weeklySales, 2) }}
    </p>
</div>

{{-- Monthly Sales --}}
<div class="rounded-xl border border-orange-100 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
    <div class="flex items-center justify-between">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-orange-100 text-2xl">
            🗓️
        </div>
        <span class="text-xs font-semibold uppercase tracking-wide text-orange-700">
            This Month
        </span>
    </div>

    <p class="mt-5 text-sm font-medium text-gray-500">
        Monthly Sales
    </p>

    <p class="mt-2 break-words text-2xl font-bold text-orange-800">
        ₱{{ number_format($monthlySales, 2) }}
    </p>
</div>


                    {{-- Total Orders --}}
                    <div class="rounded-xl border border-blue-100 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                        <div class="flex items-center justify-between">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-2xl">
                                🛒
                            </div>
                            <span class="text-xs font-semibold uppercase tracking-wide text-blue-700">
                                All Orders
                            </span>
                        </div>

                        <p class="mt-5 text-sm font-medium text-gray-500">
                            Total Orders
                        </p>

                        <p class="mt-2 text-3xl font-bold text-blue-800">
                            {{ $totalOrders }}
                        </p>

                        <p class="mt-2 text-xs text-gray-400">
                            Orders containing your products
                        </p>
                    </div>

                    {{-- Pending Orders --}}
                    <div class="rounded-xl border border-amber-100 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                        <div class="flex items-center justify-between">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-100 text-2xl">
                                📦
                            </div>
                            <span class="text-xs font-semibold uppercase tracking-wide text-amber-700">
                                Needs Attention
                            </span>
                        </div>

                        <p class="mt-5 text-sm font-medium text-gray-500">
                            Pending Orders
                        </p>

                        <p class="mt-2 text-3xl font-bold text-amber-700">
                            {{ $pendingOrders }}
                        </p>

                        <p class="mt-2 text-xs text-gray-400">
                            Orders awaiting action
                        </p>
                    </div>

                       {{-- Processing Orders --}}
                    <div class="rounded-xl border border-blue-100 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                        <div class="flex items-center justify-between">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-2xl">
                                🚚
                            </div>

                            <span class="text-xs font-semibold uppercase tracking-wide text-blue-700">
                                In Progress
                            </span>
                        </div>

                        <p class="mt-5 text-sm font-medium text-gray-500">
                            Processing Orders
                        </p>

                        <p class="mt-2 text-3xl font-bold text-blue-800">
                            {{ $processingOrders }}
                        </p>

                        <p class="mt-2 text-xs text-gray-400">
                            Orders currently being prepared
                        </p>
                    </div>

                    {{-- Completed Orders --}}
                    <div class="rounded-xl border border-purple-100 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                        <div class="flex items-center justify-between">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-100 text-2xl">
                                ✅
                            </div>
                            <span class="text-xs font-semibold uppercase tracking-wide text-purple-700">
                                Finished
                            </span>
                        </div>

                        <p class="mt-5 text-sm font-medium text-gray-500">
                            Completed Orders
                        </p>

                        <p class="mt-2 text-3xl font-bold text-purple-800">
                            {{ $completedOrders }}
                        </p>

                        <p class="mt-2 text-xs text-gray-400">
                            Successfully completed orders
                        </p>
                    </div>

                </div>
            </section>

            {{-- Product Expiration Tracker --}}
<section class="overflow-hidden rounded-xl border border-orange-100 bg-white shadow-sm">

    <div class="border-b border-orange-100 bg-orange-50 px-6 py-5">
        <h3 class="text-lg font-bold text-orange-800">
            📅 Product Expiration Tracker
        </h3>

        <p class="mt-1 text-sm text-orange-700">
            Monitor the freshness and expiration of your agricultural products.
        </p>
    </div>

    @if ($expirationProducts->isNotEmpty())

        <div class="overflow-x-auto">
            <table class="w-full text-left">

                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500">
                            Product
                        </th>

                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500">
                            Harvest Date
                        </th>

                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500">
                            Expiration Date
                        </th>

                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500">
                            Freshness Status
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    @foreach ($expirationProducts as $product)

                        @php
                            $today = \Carbon\Carbon::today();
                            $expirationDate = \Carbon\Carbon::parse($product->expiration_date);
                            $daysRemaining = $today->diffInDays($expirationDate, false);

                            if ($daysRemaining < 0) {
                                $freshnessStatus = 'Expired';
                                $freshnessClass = 'bg-red-100 text-red-700';
                            } elseif ($daysRemaining <= 7) {
                                $freshnessStatus = 'Expiring Soon';
                                $freshnessClass = 'bg-amber-100 text-amber-700';
                            } else {
                                $freshnessStatus = 'Fresh';
                                $freshnessClass = 'bg-green-100 text-green-700';
                            }
                        @endphp

                        <tr class="transition hover:bg-gray-50">

                            <td class="px-6 py-4 font-semibold text-gray-800">
                                {{ $product->name }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $product->harvest_date
                                    ? \Carbon\Carbon::parse($product->harvest_date)->format('M d, Y')
                                    : 'Not provided' }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $expirationDate->format('M d, Y') }}
                            </td>

                            <td class="px-6 py-4">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $freshnessClass }}">
                                    {{ $freshnessStatus }}
                                </span>
                            </td>

                        </tr>

                    @endforeach

                </tbody>
            </table>
        </div>

    @else

        <div class="px-6 py-10 text-center">
            <div class="mb-3 text-5xl">🌱</div>

            <h4 class="font-semibold text-gray-800">
                No Expiration Dates Yet
            </h4>

            <p class="mt-2 text-sm text-gray-500">
                Products with expiration dates will appear here.
            </p>

            <a href="{{ route('products.create') }}"
               class="mt-5 inline-flex items-center rounded-lg bg-green-700 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-green-800">
                + Add Product
            </a>
        </div>

    @endif

</section>

            {{-- Low Stock Alerts --}}
<section class="overflow-hidden rounded-xl border border-red-100 bg-white shadow-sm">

    <div class="border-b border-red-100 bg-red-50 px-6 py-5">
        <h3 class="text-lg font-bold text-red-800">
            ⚠️ Low Stock Alerts
        </h3>

        <p class="mt-1 text-sm text-red-600">
            Products that need restocking.
        </p>
    </div>

    @if ($lowStockProducts->isNotEmpty())

        <div class="overflow-x-auto">
            <table class="w-full text-left">

                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500">
                            Product
                        </th>

                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500">
                            Remaining Stock
                        </th>

                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500">
                            Stock Status
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    @foreach ($lowStockProducts as $product)

                        <tr class="transition hover:bg-red-50">

                            <td class="px-6 py-4">
                                <span class="font-semibold text-gray-800">
                                    {{ $product->name }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-sm font-bold text-red-700">
                                {{ $product->quantity }} items
                            </td>

                            <td class="px-6 py-4">
                                <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-bold text-red-700">
                                    Low Stock
                                </span>
                            </td>

                        </tr>

                    @endforeach

                </tbody>
            </table>
        </div>

    @else

        <div class="px-6 py-10 text-center">

            <div class="mb-3 text-5xl">✅</div>

            <h4 class="font-semibold text-gray-800">
                All Products Are Well Stocked!
            </h4>

            <p class="mt-2 text-sm text-gray-500">
                None of your products currently have 5 or fewer items remaining.
            </p>

        </div>

    @endif

</section>

            {{-- Recent Orders --}}
<section class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">

    <div class="flex flex-col gap-2 border-b border-gray-100 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h3 class="text-lg font-bold text-gray-800">
                📦 Recent Orders
            </h3>

            <p class="mt-1 text-sm text-gray-500">
                Your five most recent order items.
            </p>
        </div>

        <a href="{{ route('farmer.orders.index') }}"
           class="text-sm font-semibold text-green-700 hover:text-green-900">
            View All Orders →
        </a>
    </div>

    @if ($recentOrders->isNotEmpty())
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="whitespace-nowrap px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500">
                            Product
                        </th>

                        <th class="whitespace-nowrap px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500">
                            Quantity
                        </th>

                        <th class="whitespace-nowrap px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500">
                            Order Status
                        </th>

                        <th class="whitespace-nowrap px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500">
                            Date
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @foreach ($recentOrders as $item)
                        <tr class="transition hover:bg-green-50">
                            <td class="px-6 py-4">
                                <span class="font-semibold text-gray-800">
                                    {{ $item->product->name ?? 'Product no longer available' }}
                                </span>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-700">
                                {{ $item->quantity }}
                            </td>

                            <td class="whitespace-nowrap px-6 py-4">
                                @php
                                    $status = strtolower($item->status ?? 'unknown');

                                    $statusClasses = [
                                        'pending' => 'bg-amber-100 text-amber-800',
                                        'processing' => 'bg-blue-100 text-blue-800',
                                        'shipped' => 'bg-indigo-100 text-indigo-800',
                                        'completed' => 'bg-green-100 text-green-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                    ];

                                    $badgeClass = $statusClasses[$status] ?? 'bg-gray-100 text-gray-700';
                                @endphp

                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $badgeClass }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                {{ $item->created_at ? $item->created_at->format('M d, Y') : 'N/A' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="px-6 py-12 text-center">
            <div class="mb-3 text-5xl">🛍️</div>

            <h4 class="font-semibold text-gray-800">
                No recent orders yet
            </h4>

            <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-gray-500">
                When customers place orders containing your products,
                their latest orders will appear here.
            </p>

            <a href="{{ route('products.index') }}"
               class="mt-5 inline-flex items-center rounded-lg bg-green-700 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-green-800">
                View My Products
            </a>
        </div>
    @endif

</section>

            {{-- Best-Selling Products --}}
            <section class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
                <div class="flex flex-col gap-2 border-b border-gray-100 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">
                            🥬 Best-Selling Products
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Your top five products by quantity sold.
                        </p>
                    </div>

                    <a href="{{ route('products.index') }}"
                       class="text-sm font-semibold text-green-700 hover:text-green-900">
                        View My Products →
                    </a>
                </div>

                @if ($bestSellingProducts->isNotEmpty())
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="whitespace-nowrap px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500">
    Order ID
</th>
                                    <th class="whitespace-nowrap px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500">
                                        Rank
                                    </th>
                                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500">
                                        Product
                                    </th>
                                    <th class="whitespace-nowrap px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-gray-500">
                                        Quantity Sold
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-100">
                                @foreach ($bestSellingProducts as $item)
                                    <tr class="transition hover:bg-green-50">
                                       <td class="whitespace-nowrap px-6 py-4">
    <div class="font-semibold text-green-700">
        #{{ $item->order_id }}
    </div>

    <a href="{{ route('farmer.orders.index') }}"
       class="mt-1 inline-block text-xs font-semibold text-blue-600 hover:text-blue-800 hover:underline">
        View Orders →
    </a>
</td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-green-100 font-bold text-green-800">
                                                {{ $loop->iteration }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-4">
                                            <span class="font-semibold text-gray-800">
                                                {{ $item->product->name ?? 'Product no longer available' }}
                                            </span>
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-4 text-right">
                                            <span class="inline-flex items-center rounded-full bg-blue-50 px-3 py-1 text-sm font-bold text-blue-700">
                                                {{ $item->total_quantity }} sold
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="px-6 py-12 text-center">
                        <div class="mb-3 text-5xl">🌱</div>
                        <h4 class="font-semibold text-gray-800">
                            No completed product sales yet
                        </h4>
                        <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-gray-500">
                            Your best-selling products will appear here when
                            customers' orders containing your products are completed.
                        </p>
                    </div>
                @endif
            </section>

            {{-- Marketplace Management --}}
            <section>
                <div class="mb-5">
                    <h3 class="text-xl font-bold text-gray-800">
                        🧑‍🌾 Manage Your Marketplace
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Quick access to your products and customer orders.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                    {{-- Product Management --}}
                    <div class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm transition hover:shadow-md">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-100 text-2xl">
                            🌾
                        </div>

                        <h4 class="mt-4 text-lg font-bold text-gray-800">
                            My Products
                        </h4>

                        <p class="mt-2 text-sm leading-6 text-gray-500">
                            Add new agricultural products, review your listings,
                            and manage the items you sell.
                        </p>

                        <div class="mt-5 flex flex-wrap gap-3">
                            <a href="{{ route('products.create') }}"
                               class="inline-flex items-center justify-center rounded-lg bg-green-700 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-green-800">
                                + Add Product
                            </a>

                            <a href="{{ route('products.index') }}"
                               class="inline-flex items-center justify-center rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                                View Products
                            </a>
                        </div>
                    </div>

                    {{-- Order Management --}}
                    <div class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm transition hover:shadow-md">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-2xl">
                            📦
                        </div>

                        <h4 class="mt-4 text-lg font-bold text-gray-800">
                            Incoming Orders
                        </h4>

                        <p class="mt-2 text-sm leading-6 text-gray-500">
                            Check customer purchases, review pending orders,
                            and update order statuses.
                        </p>

                        <div class="mt-5">
                            <a href="{{ route('farmer.orders.index') }}"
                               class="inline-flex items-center justify-center rounded-lg bg-gray-800 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-900">
                                Manage Incoming Orders →
                            </a>
                        </div>
                    </div>

                </div>
            </section>

            {{-- Dashboard Footer --}}
            <div class="border-t border-gray-200 py-4 text-center">
                <p class="text-sm text-gray-500">
                    Thank you for supporting local agriculture. 🌱
                </p>
            </div>

        </div>
    </div>
</x-app-layout>
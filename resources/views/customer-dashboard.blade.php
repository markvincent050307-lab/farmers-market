<x-app-layout>
    <x-slot name="header">
      <div>
    <h2 class="text-2xl font-extrabold tracking-tight text-green-900">
        Customer Dashboard
    </h2>
    <p class="mt-1 text-sm text-gray-500">
        Welcome to your marketplace
    </p>
</div>
    </x-slot>

   <div class="min-h-screen bg-[#f7faf7] py-8 sm:py-10 lg:py-12">
        <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">

           <!-- Welcome Banner -->
<div class="relative isolate overflow-hidden rounded-3xl p-7 sm:p-10 md:p-14 text-white shadow-2xl"
     style="background: linear-gradient(115deg, #052e16 0%, #14532d 50%, #15803d 100%);">

    <div class="pointer-events-none absolute -right-16 -top-20 h-64 w-64 rounded-full border border-white/10"></div>
    <div class="pointer-events-none absolute -right-5 -top-9 h-44 w-44 rounded-full border border-white/10"></div>
    <div class="pointer-events-none absolute -bottom-24 right-1/4 h-64 w-64 rounded-full bg-green-400/10 blur-3xl"></div>

    <div class="relative z-10 max-w-3xl">

        <span class="inline-block rounded-full border border-white/20 bg-white/10 px-4 py-2 text-xs font-bold uppercase tracking-widest text-green-100">
            🌱 The Heartbeat of Local Agriculture
        </span>

        <h1 class="mt-5 text-3xl font-extrabold leading-tight sm:text-4xl md:text-5xl">
            Hello, {{ Auth::user()->name }}! 👋
        </h1>

        <p class="mt-4 max-w-2xl text-base leading-8 text-green-50 sm:text-lg">
            Discover fresh agricultural products directly from local farmers.
            Enjoy quality produce while helping our farming community grow.
        </p>

        <a href="{{ route('shop.index') }}"
           class="mt-7 inline-flex items-center gap-2 rounded-full bg-yellow-400 px-7 py-3.5 font-bold text-green-950 shadow-lg transition duration-300 hover:-translate-y-1 hover:bg-yellow-300 hover:shadow-xl">
            🛒 Explore Products
            <span>→</span>
        </a>

    </div>

    <div class="pointer-events-none absolute -right-8 -bottom-16 select-none text-[190px] opacity-10">
        🌾
    </div>

    <div class="pointer-events-none absolute -right-10 -top-20 h-64 w-64 rounded-full border border-white/10"></div>
    <div class="pointer-events-none absolute -right-2 -top-12 h-48 w-48 rounded-full border border-white/10"></div>

</div>

<!-- Shopping Overview -->
<div class="mt-10 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">

    <!-- My Orders -->
    <a href="{{ route('orders.index') }}"
       class="group rounded-2xl border border-green-100 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-gray-500">My Orders</p>
                <h3 class="mt-2 text-3xl font-extrabold text-green-800">
                    {{ $customerOrders }}
                </h3>
                <p class="mt-1 text-xs text-gray-500">Total orders placed</p>
            </div>
            <div class="rounded-2xl bg-green-100 p-4 text-2xl">📦</div>
        </div>
    </a>

    <!-- My Cart -->
    <a href="{{ route('cart.index') }}"
       class="group rounded-2xl border border-orange-100 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-gray-500">My Cart</p>
                <h3 class="mt-2 text-3xl font-extrabold text-orange-600">
                    {{ $customerCartQuantity }}
                </h3>
                <p class="mt-1 text-xs text-gray-500">
                    {{ $customerCartItems }} different products
                </p>
            </div>
            <div class="rounded-2xl bg-orange-100 p-4 text-2xl">🛒</div>
        </div>
    </a>

    <!-- My Wishlist -->
    <a href="{{ route('wishlist.index') }}"
       class="group rounded-2xl border border-pink-100 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-gray-500">My Wishlist</p>
                <h3 class="mt-2 text-3xl font-extrabold text-pink-600">
                    {{ $customerWishlist }}
                </h3>
                <p class="mt-1 text-xs text-gray-500">Saved products</p>
            </div>
            <div class="rounded-2xl bg-pink-100 p-4 text-2xl">❤️</div>
        </div>
    </a>

</div>

           <!-- Quick Actions -->
<div class="mt-12">
    <div class="mb-7 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-bold uppercase tracking-widest text-green-600">
                Your Marketplace
            </p>
            <h3 class="mt-1 text-2xl font-extrabold text-gray-900 sm:text-3xl">
                What would you like to do?
            </h3>
            <p class="mt-2 text-sm text-gray-500">
                Everything you need for a smooth shopping experience.
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">

        <!-- Browse Products -->
        <a href="{{ route('shop.index') }}"
           class="group relative overflow-hidden rounded-3xl border border-green-100 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-2 hover:shadow-xl sm:p-7">
            <div class="flex items-center justify-between">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-green-100 text-3xl">
                    🥬
                </div>
                <span class="text-2xl text-green-600 transition group-hover:translate-x-2">
                    →
                </span>
            </div>

            <h4 class="mt-6 text-xl font-extrabold text-gray-900">
                Browse Products
            </h4>
            <p class="mt-2 text-sm leading-6 text-gray-500">
                Discover fresh fruits, vegetables, and local farm products.
            </p>

            <div class="mt-5 inline-flex items-center gap-2 text-sm font-bold text-green-700">
                Explore Marketplace
            </div>
        </a>

        <!-- My Cart -->
        <a href="{{ route('cart.index') }}"
           class="group relative overflow-hidden rounded-3xl border border-orange-100 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-2 hover:shadow-xl sm:p-7">
            <div class="flex items-center justify-between">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-orange-100 text-3xl">
                    🛒
                </div>
                <span class="text-2xl text-orange-500 transition group-hover:translate-x-2">
                    →
                </span>
            </div>

            <h4 class="mt-6 text-xl font-extrabold text-gray-900">
                My Cart
            </h4>
            <p class="mt-2 text-sm leading-6 text-gray-500">
                Review your selected products and continue to checkout.
            </p>

            <div class="mt-5 inline-flex items-center gap-2 text-sm font-bold text-orange-600">
                View Shopping Cart
            </div>
        </a>

        <!-- My Orders -->
        <a href="{{ route('orders.index') }}"
           class="group relative overflow-hidden rounded-3xl border border-blue-100 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-2 hover:shadow-xl sm:col-span-2 lg:col-span-1 sm:p-7">
            <div class="flex items-center justify-between">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-100 text-3xl">
                    📦
                </div>
                <span class="text-2xl text-blue-600 transition group-hover:translate-x-2">
                    →
                </span>
            </div>

            <h4 class="mt-6 text-xl font-extrabold text-gray-900">
                My Orders
            </h4>
            <p class="mt-2 text-sm leading-6 text-gray-500">
                Check your purchases and keep track of your orders.
            </p>

            <div class="mt-5 inline-flex items-center gap-2 text-sm font-bold text-blue-600">
                Track My Orders
            </div>
        </a>

    </div>
</div>

          <!-- Marketplace Information -->
<div class="mt-10 overflow-hidden rounded-3xl border border-green-100 bg-white shadow-sm">
    <div class="grid grid-cols-1 md:grid-cols-3">

        <div class="bg-green-900 p-7 text-white md:col-span-1">
            <div class="text-4xl">🌾</div>
            <h3 class="mt-4 text-xl font-extrabold">
                About AgriPulse
            </h3>
            <p class="mt-3 text-sm leading-7 text-green-100">
                The Heartbeat of Local Agriculture.
            </p>
        </div>

        <div class="p-7 md:col-span-2">
            <h4 class="text-lg font-extrabold text-gray-900">
                Supporting Local Farmers, One Purchase at a Time
            </h4>

            <p class="mt-3 text-sm leading-7 text-gray-600">
                AgriPulse connects customers directly with local farmers.
                Discover fresh agricultural products, support local communities,
                and enjoy a convenient shopping experience.
            </p>

            <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="flex items-start gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-green-100 text-xl">
                        🥕
                    </span>
                    <div>
                        <p class="font-bold text-gray-800">Fresh Products</p>
                        <p class="mt-1 text-xs text-gray-500">Discover local farm produce.</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-orange-100 text-xl">
                        🤝
                    </span>
                    <div>
                        <p class="font-bold text-gray-800">Support Farmers</p>
                        <p class="mt-1 text-xs text-gray-500">Help local agriculture grow.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Shopping Call to Action -->
<div class="relative mt-10 overflow-hidden rounded-3xl p-7 text-white shadow-lg sm:p-10"
     style="background: linear-gradient(110deg, #166534, #15803d, #16a34a);">

    <div class="relative z-10 flex flex-col items-start justify-between gap-6 sm:flex-row sm:items-center">
        <div class="max-w-xl">
            <p class="text-sm font-bold uppercase tracking-widest text-green-200">
                Freshness Starts Here
            </p>

            <h3 class="mt-2 text-2xl font-extrabold sm:text-3xl">
                Bring Fresh Farm Products to Your Table!
            </h3>

            <p class="mt-3 text-sm leading-6 text-green-50">
                Explore locally grown products and support the farmers
                who help feed our communities.
            </p>
        </div>

        <a href="{{ route('shop.index') }}"
           class="inline-flex shrink-0 items-center justify-center rounded-xl bg-yellow-400 px-6 py-3 font-extrabold text-green-950 shadow-md transition hover:-translate-y-1 hover:bg-yellow-300">
            Shop Now →
        </a>
    </div>
</div>

            <!-- Footer Message -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-500">
                    Fresh from local farms, delivered through your marketplace. 🌾
                </p>
            </div>

        </div>
    </div>
</x-app-layout>
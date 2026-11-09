<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-green-800 leading-tight">
            🌱 Customer Dashboard
        </h2>
    </x-slot>

    <div class="min-h-screen bg-green-50 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Welcome Banner -->
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-green-800 to-green-600 p-6 sm:p-8 md:p-12 text-white shadow-lg">
                <div class="relative z-10 max-w-3xl">
                    <p class="text-green-100 text-sm font-semibold uppercase tracking-widest mb-2">
                        Welcome to Farmers Market
                    </p>

                    <h1 class="text-3xl md:text-4xl font-extrabold mb-4">
                        Hello, {{ Auth::user()->name }}! 👋
                    </h1>

                    <p class="text-green-50 text-base md:text-lg max-w-2xl mb-7">
                        Discover fresh agricultural products from local farmers.
                        Shop for quality produce and support our farming community.
                    </p>

                    <a href="{{ route('shop.index') }}"
                       class="inline-flex items-center rounded-lg bg-white px-6 py-3 font-bold text-green-800 shadow-md transition hover:bg-green-100 hover:-translate-y-1">
                        🛒 Explore Products
                    </a>
                </div>

                <div class="absolute -right-10 -bottom-16 text-9xl opacity-10 select-none">
                    🌾
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-10">
                <div class="mb-5">
                    <h3 class="text-2xl font-bold text-gray-800">
                        Your Marketplace
                    </h3>

                    <p class="mt-1 text-gray-600">
                        What would you like to do today?
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-3">

                    <!-- Browse Products -->
                    <a href="{{ route('shop.index') }}"
                       class="group rounded-2xl border border-green-100 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-lg">
                        <div class="mb-5 flex h-14 w-14 items-center justify-center rounded-xl bg-green-100 text-3xl transition group-hover:bg-green-200">
                            🥬
                        </div>

                        <h4 class="text-xl font-bold text-gray-800 group-hover:text-green-700">
                            Browse Products
                        </h4>

                        <p class="mt-2 text-sm leading-6 text-gray-600">
                            Explore fresh vegetables, fruits, and other agricultural products offered by local farmers.
                        </p>

                        <div class="mt-5 font-semibold text-green-700">
                            Start Shopping →
                        </div>
                    </a>

                    <!-- My Cart -->
                    <a href="{{ route('cart.index') }}"
                       class="group rounded-2xl border border-yellow-100 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-lg">
                        <div class="mb-5 flex h-14 w-14 items-center justify-center rounded-xl bg-yellow-100 text-3xl transition group-hover:bg-yellow-200">
                            🛒
                        </div>

                        <h4 class="text-xl font-bold text-gray-800 group-hover:text-yellow-700">
                            My Cart
                        </h4>

                        <p class="mt-2 text-sm leading-6 text-gray-600">
                            Check the products you have selected before proceeding to checkout.
                        </p>

                        <div class="mt-5 font-semibold text-yellow-700">
                            View My Cart →
                        </div>
                    </a>

                    <!-- My Orders -->
                    <a href="{{ route('orders.index') }}"
                       class="group rounded-2xl border border-blue-100 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-lg">
                        <div class="mb-5 flex h-14 w-14 items-center justify-center rounded-xl bg-blue-100 text-3xl transition group-hover:bg-blue-200">
                            📦
                        </div>

                        <h4 class="text-xl font-bold text-gray-800 group-hover:text-blue-700">
                            My Orders
                        </h4>

                        <p class="mt-2 text-sm leading-6 text-gray-600">
                            Review your orders and check their current status.
                        </p>

                        <div class="mt-5 font-semibold text-blue-700">
                            View My Orders →
                        </div>
                    </a>

                </div>
            </div>

            <!-- Marketplace Information -->
            <div class="mt-10 rounded-2xl border border-green-100 bg-white p-6 shadow-sm md:p-8">
                <div class="flex flex-col gap-5 sm:flex-row sm:items-center">
                    <div class="flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-full bg-green-100 text-4xl">
                        🌱
                    </div>

                    <div>
                        <h3 class="text-xl font-bold text-gray-800">
                            Support Local Farmers
                        </h3>

                        <p class="mt-2 leading-7 text-gray-600">
                            Farmers Market connects customers with local agricultural sellers.
                            Browse available products, manage your cart, and keep track of your purchases in one place.
                        </p>
                    </div>
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
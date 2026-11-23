<x-app-layout>
    <div class="py-10" style="background-color: #f5f9f4; min-height: 100vh;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <h2 class="text-2xl font-bold mb-6" style="color: #245c35;">
                Sales Report
            </h2>
<!-- Date Filter -->
<div class="bg-white p-6 rounded-lg shadow mb-6">
    <form method="GET" action="{{ route('farmer.sales.report') }}"
          class="flex flex-wrap items-end gap-4">

        <div>
            <label class="block font-semibold mb-2">Start Date</label>
            <input type="date" id="start_date" name="start_date"
                   value="{{ $startDate }}"
                   max="{{ $endDate }}"
                   required
                   class="border rounded-lg p-2">
        </div>

        <div>
            <label class="block font-semibold mb-2">End Date</label>
            <input type="date" id="end_date" name="end_date"
                   value="{{ $endDate }}"
                   min="{{ $startDate }}"
                   required
                   class="border rounded-lg p-2">
        </div>

        <button type="submit"
                style="background-color: #287a45; color: white; padding: 10px 20px; border-radius: 6px;">
            Generate Report
        </button>
    </form>

    <div class="mt-4">
        <a href="{{ route('farmer.sales.report.export', [
                'start_date' => $startDate,
                'end_date' => $endDate
            ]) }}"
           style="display: inline-block; background-color: #166534; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: bold;">
            📥 Export to Excel
        </a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');

    startDate.addEventListener('change', function () {
        endDate.min = this.value;

        if (endDate.value && endDate.value < this.value) {
            endDate.value = this.value;
        }
    });

    endDate.addEventListener('change', function () {
        startDate.max = this.value;

        if (startDate.value && startDate.value > this.value) {
            startDate.value = this.value;
        }
    });
});
</script>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">

                <div class="bg-white p-6 rounded-lg shadow">
                    <p class="text-gray-500">Total Sales</p>
                    <h3 class="text-2xl font-bold text-green-700">
                        ₱{{ number_format($totalSales, 2) }}
                    </h3>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <p class="text-gray-500">Completed Orders</p>
                    <h3 class="text-2xl font-bold">
                        {{ $totalOrders }}
                    </h3>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <p class="text-gray-500">Products Sold</p>
                    <h3 class="text-2xl font-bold">
                        {{ $totalQuantity }}
                    </h3>
                </div>

            </div>

            <!-- Sales Details -->
            <div class="bg-white rounded-lg shadow overflow-hidden">

                <div class="p-6 border-b">
                    <h3 class="text-lg font-bold">Sales Details</h3>
                    <p class="text-sm text-gray-500">
                        Showing completed sales from
                        {{ \Carbon\Carbon::parse($startDate)->format('M d, Y') }}
                        to
                        {{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}
                    </p>
                </div>

                @if($salesItems->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead style="background-color: #edf5ed;">
                                <tr>
                                    <th class="p-4">Product</th>
                                    <th class="p-4">Customer</th>
                                    <th class="p-4">Quantity</th>
                                    <th class="p-4">Price</th>
                                    <th class="p-4">Subtotal</th>
                                    <th class="p-4">Order Date</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($salesItems as $item)
                                    <tr class="border-t">
                                        <td class="p-4">
                                            {{ $item->product->name ?? 'Product Unavailable' }}
                                        </td>

                                        <td class="p-4">
                                            {{ $item->order->user->name ?? 'Customer Unavailable' }}
                                        </td>

                                        <td class="p-4">
                                            {{ $item->quantity }}
                                        </td>

                                        <td class="p-4">
                                            ₱{{ number_format($item->price, 2) }}
                                        </td>

                                        <td class="p-4 font-semibold">
                                            ₱{{ number_format($item->price * $item->quantity, 2) }}
                                        </td>

                                        <td class="p-4">
                                            {{ $item->order->created_at->format('M d, Y') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-8 text-center text-gray-500">
                        No completed sales found for this date range.
                    </div>
                @endif

            </div>

            <div class="mt-6">
                <a href="{{ route('dashboard') }}"
                   style="color: #287a45; font-weight: bold; text-decoration: none;">
                    ← Back to Dashboard
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My Agricultural Products
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm rounded-lg p-6">

                @if (session('success'))
                    <div class="mb-4 rounded bg-green-100 p-4 text-green-800">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold">My Products</h3>

                    <a href="{{ route('products.create') }}"
                       class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-md">
                        + Add Product
                    </a>
                </div>

                @forelse ($products as $product)
                    <div class="border rounded-lg p-4 mb-4 flex flex-col sm:flex-row gap-4">

                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}"
                                 alt="{{ $product->name }}"
                                 class="w-40 h-40 object-cover rounded">
                        @endif

                        <div>
                            <h4 class="text-lg font-bold">
                                {{ $product->name }}
                            </h4>

                            <p class="text-green-700 font-semibold">
                                ₱{{ number_format($product->price, 2) }}
                            </p>

                           <p class="mt-1">
    Available quantity: {{ $product->quantity }}
</p>

<form action="{{ route('products.updateStock', $product->id) }}"
      method="POST"
      class="mt-3 flex flex-wrap items-end gap-2">
    @csrf
    @method('PATCH')

    <div>
        <label for="quantity-{{ $product->id }}"
               class="block text-sm font-medium text-gray-700">
            Update Stock
        </label>

        <input type="number"
               name="quantity"
               id="quantity-{{ $product->id }}"
               value="{{ $product->quantity }}"
               min="0"
               required
               class="mt-1 w-28 rounded-md border-gray-300 shadow-sm">
    </div>

   <button type="submit"
        style="background-color: #15803d; color: white; padding: 10px 16px; border: 2px solid #166534; border-radius: 6px; cursor: pointer; font-weight: bold;">
    Update Stock
</button>
</form>
<a href="{{ route('products.edit', $product->id) }}"
   style="display: inline-block; margin-top: 12px; background-color: #2563eb; color: white; padding: 10px 18px; border-radius: 6px; text-decoration: none; font-weight: bold;">
    Edit Product
</a>

                            <p class="mt-2 text-gray-600">
                                {{ $product->description }}
                            </p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-600">
                        You haven't added any products yet. Click
                        <strong>Add Product</strong> to list your first crop.
                    </p>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>
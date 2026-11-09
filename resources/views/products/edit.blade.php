<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Agricultural Product
        </h2>
    </x-slot>

<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg p-6">

            <h3 class="text-xl font-bold mb-6">
                Update Product Information
            </h3>

            @if ($errors->any())
                <div class="mb-4 rounded bg-red-100 p-4 text-red-800">
                    <strong>Please check the following:</strong>
                    <ul class="list-disc ml-5 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('products.update', $product->id) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block font-medium mb-1">Product Name</label>
                    <input type="text" name="name"
                           value="{{ old('name', $product->name) }}"
                           required
                           class="w-full rounded-md border-gray-300">
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1">Category</label>
                    <select name="category" required
                            class="w-full rounded-md border-gray-300">
                        @foreach (['Vegetables', 'Fruits', 'Grains', 'Root Crops', 'Eggs', 'Other Agricultural Products'] as $category)
                            <option value="{{ $category }}"
                                {{ old('category', $product->category) === $category ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1">Description</label>
                    <textarea name="description"
                              rows="4"
                              class="w-full rounded-md border-gray-300">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1">Price (₱)</label>
                    <input type="number" name="price" step="0.01"
                           min="0.01"
                           value="{{ old('price', $product->price) }}"
                           required
                           class="w-full rounded-md border-gray-300">
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1">Available Quantity</label>
                    <input type="number" name="quantity" min="0"
                           value="{{ old('quantity', $product->quantity) }}"
                           required
                           class="w-full rounded-md border-gray-300">
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1">Harvest Date (Optional)</label>
                    <input type="date" name="harvest_date"
                           value="{{ old('harvest_date', $product->harvest_date ? \Carbon\Carbon::parse($product->harvest_date)->format('Y-m-d') : '') }}"
                           class="w-full rounded-md border-gray-300">
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1">Expiration Date (Optional)</label>
                    <input type="date" name="expiration_date"
                           value="{{ old('expiration_date', $product->expiration_date ? \Carbon\Carbon::parse($product->expiration_date)->format('Y-m-d') : '') }}"
                           class="w-full rounded-md border-gray-300">
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-2">Current Product Photo</label>

                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}"
                             alt="{{ $product->name }}"
                             class="w-40 h-40 object-cover rounded mb-3">
                    @else
                        <p class="text-gray-500 mb-3">No product photo uploaded.</p>
                    @endif

                    <label class="block font-medium mb-1">Replace Photo (Optional)</label>
                    <input type="file" name="image"
                           accept=".jpg,.jpeg,.png,.webp"
                           class="w-full rounded-md border-gray-300">
                    <p class="text-sm text-gray-500 mt-1">
                        Leave this empty if you want to keep the current photo.
                    </p>
                </div>

                <div class="flex gap-3 mt-6">
                    <button type="submit"
                            class="bg-green-700 hover:bg-green-800 text-white px-5 py-2 rounded-md">
                        Save Changes
                    </button>

                    <a href="{{ route('products.index') }}"
                       class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-5 py-2 rounded-md">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

</x-app-layout>
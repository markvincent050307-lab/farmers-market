<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Agricultural Product
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                @if ($errors->any())
                    <div class="mb-4 rounded bg-red-100 p-4 text-red-700">
                        <p class="font-bold">Please correct the following:</p>
                        <ul class="list-disc ml-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('products.store') }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf

                    <div style="margin-bottom: 15px;">
    <label for="category" style="display: block; margin-bottom: 5px; font-weight: bold;">
        Product Category
    </label>

    <select
        name="category"
        id="category"
        required
        style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;"
    >
        <option value="">-- Select a Category --</option>
        <option value="Vegetables">Vegetables</option>
        <option value="Fruits">Fruits</option>
        <option value="Grains">Grains</option>
        <option value="Root Crops">Root Crops</option>
        <option value="Eggs">Eggs</option>
        <option value="Other Agricultural Products">Other Agricultural Products</option>
    </select>

    @error('category')
        <p style="color: red;">{{ $message }}</p>
    @enderror
</div>

                    <div class="mb-4">
                        <label for="name" class="block font-medium mb-1">
                            Product Name
                        </label>
                        <input type="text" id="name" name="name"
                               value="{{ old('name') }}"
                               class="w-full border-gray-300 rounded-md"
                               placeholder="Example: Fresh Tomatoes"
                               required>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block font-medium mb-1">
                            Description
                        </label>
                        <textarea id="description" name="description"
                                  rows="4"
                                  class="w-full border-gray-300 rounded-md"
                                  placeholder="Describe your agricultural product">{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="price" class="block font-medium mb-1">
                            Price (₱)
                        </label>
                        <input type="number" id="price" name="price"
                               value="{{ old('price') }}"
                               min="0.01" step="0.01"
                               class="w-full border-gray-300 rounded-md"
                               placeholder="Example: 50.00"
                               required>
                    </div>

                    <div class="mb-4">
                        <label for="quantity" class="block font-medium mb-1">
                            Available Quantity
                        </label>
                        <input type="number" id="quantity" name="quantity"
                               value="{{ old('quantity') }}"
                               min="0" step="1"
                               class="w-full border-gray-300 rounded-md"
                               placeholder="Example: 100"
                               required>
                    </div>

                    <div class="mb-4">
    <label for="harvest_date" class="block font-medium mb-1">
        Harvest Date (Optional)
    </label>
    <input type="date" id="harvest_date" name="harvest_date"
           value="{{ old('harvest_date') }}"
           class="w-full border-gray-300 rounded-md">
    <p class="text-sm text-gray-500 mt-1">
        Select the date when the product was harvested.
    </p>
</div>

<div class="mb-6">
    <label for="expiration_date" class="block font-medium mb-1">
        Expiration Date (Optional)
    </label>
    <input type="date" id="expiration_date" name="expiration_date"
           value="{{ old('expiration_date') }}"
           class="w-full border-gray-300 rounded-md">
    <p class="text-sm text-gray-500 mt-1">
        Select the expected expiration date, if applicable.
    </p>
</div>

                    <div class="mb-6">
                        <label for="image" class="block font-medium mb-1">
                            Product Photo
                        </label>
                        <input type="file" id="image" name="image"
                               accept=".jpg,.jpeg,.png,.webp"
                               class="w-full border-gray-300 rounded-md"
                               required>
                        <p class="text-sm text-gray-500 mt-1">
                            Upload a JPG, PNG, or WebP image up to 2 MB.
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="submit"
    style="background-color: #15803d; color: white; padding: 10px 24px; border-radius: 6px; font-weight: bold; border: none; cursor: pointer;">
    Save Product
</button>

                        <a href="{{ route('products.index') }}"
                           class="text-gray-600 hover:underline">
                            Cancel
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
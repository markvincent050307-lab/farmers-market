<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product | Farmers Marketplace</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f7f2;
            color: #263b2b;
        }

        header {
            background: #245c38;
            color: white;
            padding: 20px 5%;
        }

        header h2 {
            margin: 0;
        }

        .container {
            max-width: 700px;
            margin: 35px auto;
            padding: 0 20px;
        }

        .form-container {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0,0,0,.05);
        }

        label {
            display: block;
            margin: 16px 0 7px;
            font-weight: bold;
        }

        input, textarea, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #d5dfd6;
            border-radius: 6px;
            font-size: 15px;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        button, .back {
            display: inline-block;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
            margin-top: 20px;
        }

        button {
            background: #246b45;
            color: white;
        }

        .back {
            background: #e5ece5;
            color: #245c38;
            margin-left: 8px;
        }

        .errors {
            background: #ffe5e5;
            color: #a12626;
            padding: 12px;
            border-radius: 6px;
        }
    </style>
</head>

<body>

<header>
    <h2>🌱 Edit Marketplace Product</h2>
</header>

<div class="container">

    <div class="form-container">

        <h2>Edit Product Information</h2>
        <p>Update the details of this product listing.</p>

        @if($errors->any())
            <div class="errors">
                <strong>Please correct the following:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')

            <label>Product Name</label>
            <input type="text" name="name"
                   value="{{ old('name', $product->name) }}" required>

            <label>Description</label>
            <textarea name="description">{{ old('description', $product->description) }}</textarea>

            <label>Category</label>
            <input type="text" name="category"
                   value="{{ old('category', $product->category) }}" required>

            <label>Price (₱)</label>
            <input type="number" name="price" step="0.01" min="0"
                   value="{{ old('price', $product->price) }}" required>

            <label>Available Quantity</label>
            <input type="number" name="quantity" min="0"
                   value="{{ old('quantity', $product->quantity) }}" required>

            <label>Harvest Date</label>
            <input type="date" name="harvest_date"
                   value="{{ old('harvest_date', $product->harvest_date) }}">

            <label>Expiration Date</label>
            <input type="date" name="expiration_date"
                   value="{{ old('expiration_date', $product->expiration_date) }}">

            <button type="submit">Save Changes</button>

            <a href="{{ route('admin.products.index') }}" class="back">
                Cancel
            </a>

        </form>

    </div>

</div>

</body>
</html>     
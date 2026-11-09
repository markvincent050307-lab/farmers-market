<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management | Farmers Marketplace</title>

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
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        header h2 {
            margin: 0;
        }

        .back {
            color: white;
            text-decoration: none;
            background: #39794d;
            padding: 10px 16px;
            border-radius: 7px;
        }

        .container {
            max-width: 1250px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 18px;
            margin-bottom: 25px;
        }

        .card, .table-container {
            background: white;
            padding: 22px;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0,0,0,.05);
        }

        .card h3 {
            color: #68796b;
            font-size: 14px;
            margin: 0 0 12px;
        }

        .card p {
            font-size: 28px;
            font-weight: bold;
            margin: 0;
            color: #245c38;
        }

        .search-form {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin: 20px 0;
        }

        .search-form input,
        .search-form select {
            padding: 11px;
            border: 1px solid #d5dfd6;
            border-radius: 6px;
            font-size: 14px;
        }

        .search-form input {
            flex: 1;
            min-width: 200px;
        }

        .search-form button,
        .reset-button {
            padding: 11px 17px;
            border: none;
            border-radius: 6px;
            background: #246b45;
            color: white;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }

        .reset-button {
            background: #68796b;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 850px;
        }

        th, td {
            padding: 13px;
            text-align: left;
            border-bottom: 1px solid #e8eee8;
        }

        th {
            background: #f0f5ef;
            color: #245c38;
        }

        .product-image {
            width: 65px;
            height: 65px;
            object-fit: cover;
            border-radius: 8px;
        }

        .empty {
            text-align: center;
            padding: 25px;
            color: #777;
        }
    </style>
</head>

<body>

<header>
    <h2>🌱 Farmers Marketplace | Product Management</h2>
    <a href="{{ route('dashboard') }}" class="back">Back to Dashboard</a>
</header>

<div class="container">

    <h2>All Marketplace Products</h2>
    <p>Monitor products listed by farmers in your marketplace.</p>

    <div class="summary">
        <div class="card">
            <h3>Total Products</h3>
            <p>{{ $totalProducts }}</p>
        </div>

        <div class="card">
            <h3>Farmers with Listings</h3>
            <p>{{ $totalFarmers }}</p>
        </div>
    </div>

    <div class="table-container">

        <h3>Product Listings</h3>

        <form method="GET" action="{{ route('admin.products.index') }}" class="search-form">

            <input
                type="text"
                name="search"
                placeholder="Search product or farmer..."
                value="{{ request('search') }}"
            >

            <select name="category">
                <option value="">All Categories</option>

                @foreach($categories as $category)
                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                        {{ $category }}
                    </option>
                @endforeach
            </select>

            <button type="submit">Search / Filter</button>

            <a href="{{ route('admin.products.index') }}" class="reset-button">Reset</a>

        </form>

        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Farmer</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Expiration Date</th>
                    <th>Action</th> 
                </tr>
            </thead>

           <tbody>
    @forelse($products as $product)
        <tr>
            <td>
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}"
                         class="product-image"
                         alt="{{ $product->name }}">
                @else
                    No Image
                @endif
            </td>

            <td>{{ $product->name }}</td>
            <td>{{ $product->farmer->name ?? 'Unknown' }}</td>
            <td>{{ $product->category }}</td>
            <td>₱{{ number_format($product->price, 2) }}</td>
            <td>{{ $product->quantity }}</td>

            <td>
                {{ $product->expiration_date
                    ? \Carbon\Carbon::parse($product->expiration_date)->format('M d, Y')
                    : 'Not set' }}
            </td>

            <td>
                <a href="{{ route('admin.products.edit', $product->id) }}"
                   style="display:inline-block; background:#246b45; color:white; padding:8px 15px; border-radius:6px; text-decoration:none; margin-bottom:5px;">
                    Edit
                </a>

                <form action="{{ route('admin.products.destroy', $product->id) }}"
                      method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this product?');">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            style="background:#c0392b; color:white; padding:8px 15px; border:none; border-radius:6px; cursor:pointer;">
                        Delete
                    </button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="8" class="empty">
                No products found.
            </td>
        </tr>
    @endforelse
</tbody>
        </table>

    </div>

</div>

</body>
</html>
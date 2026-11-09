<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wishlist | Farmers Marketplace</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f7f1;
            margin: 0;
            color: #26352a;
        }

        header {
            background: #246b45;
            color: white;
            padding: 20px 7%;
        }

        header h1 { margin: 0; }

        .container {
            max-width: 1100px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .top-links {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .link-button {
            display: inline-block;
            background: #246b45;
            color: white;
            padding: 10px 15px;
            border-radius: 6px;
            text-decoration: none;
        }

        .wishlist-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 22px;
        }

        .product-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .product-card img {
            width: 100%;
            height: 190px;
            object-fit: cover;
            background: #e8eee8;
        }

        .product-info { padding: 18px; }

        .product-info h3 {
            margin-top: 0;
        }

        .price {
            color: #246b45;
            font-size: 20px;
            font-weight: bold;
        }

        .stock {
            color: #647067;
            font-size: 13px;
        }

        .actions {
            display: grid;
            gap: 10px;
            margin-top: 15px;
        }

        button, .button-link {
            width: 100%;
            padding: 11px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            box-sizing: border-box;
            cursor: pointer;
            text-decoration: none;
        }

        .cart-button {
            background: #246b45;
            color: white;
        }

        .remove-button {
            background: #dc2626;
            color: white;
        }

        .message {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 6px;
        }

        .success {
            background: #dff4e4;
            color: #176534;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        .empty-message {
            background: white;
            padding: 35px;
            text-align: center;
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <header>
        <h1>❤️ My Wishlist</h1>
        <p>Your saved agricultural products</p>
    </header>

    <main class="container">

        <div class="top-links">
            <a href="{{ route('shop.index') }}" class="link-button">
                ← Continue Shopping
            </a>

            <a href="{{ route('cart.index') }}" class="link-button">
                View My Cart
            </a>
        </div>

        @if (session('success'))
            <div class="message success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="message error">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="message error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <h2>Saved Products</h2>

        @if ($wishlists->isEmpty())
            <div class="empty-message">
                <h3>Your wishlist is empty.</h3>
                <p>Visit the shop to save products you are interested in.</p>

                <a href="{{ route('shop.index') }}" class="link-button">
                    Browse Products
                </a>
            </div>
        @else
            <div class="wishlist-grid">
                @foreach ($wishlists as $wishlist)
                    @if ($wishlist->product)
                        <article class="product-card">

                            @if ($wishlist->product->image)
                                <img
                                    src="{{ asset('storage/' . $wishlist->product->image) }}"
                                    alt="{{ $wishlist->product->name }}"
                                >
                            @else
                                <img
                                    src="https://placehold.co/600x400?text=Farm+Product"
                                    alt="No product image available"
                                >
                            @endif

                            <div class="product-info">
                                <h3>{{ $wishlist->product->name }}</h3>

                                @if ($wishlist->product->category)
                                    <p>
                                        Category:
                                        {{ $wishlist->product->category }}
                                    </p>
                                @endif

                                <p class="price">
                                    ₱{{ number_format($wishlist->product->price, 2) }}
                                </p>

                                <p class="stock">
                                    Available stock:
                                    {{ $wishlist->product->quantity }}
                                </p>

                                <p class="stock">
                                    Farmer:
                                    {{ $wishlist->product->farmer->name ?? 'Local Farmer' }}
                                </p>

                                <div class="actions">
                                    @if ($wishlist->product->quantity > 0)
                                        <form
                                            action="{{ route('cart.add', $wishlist->product->id) }}"
                                            method="POST"
                                        >
                                            @csrf

                                            <input
                                                type="hidden"
                                                name="quantity"
                                                value="1"
                                            >

                                            <button type="submit" class="cart-button">
                                                🛒 Add to Cart
                                            </button>
                                        </form>
                                    @else
                                        <button type="button" disabled>
                                            Out of Stock
                                        </button>
                                    @endif

                                    <form
                                        action="{{ route('wishlist.destroy', $wishlist->product->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Remove this product from your wishlist?');"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="remove-button">
                                            💔 Remove from Wishlist
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    @endif
                @endforeach
            </div>
        @endif
    </main>
</body>
</html>
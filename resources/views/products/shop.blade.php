<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agricultural Products | Farmers Marketplace</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f7f1;
            margin: 0;
            padding: 0;
            color: #26352a;
        }

        header {
            background: #246b45;
            color: white;
            padding: 20px 7%;
        }

        header h1 {
            margin: 0;
        }

        header p {
            margin-bottom: 0;
        }

        .header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    flex-wrap: wrap;
}

.shop-navigation {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.shop-navigation a {
    display: inline-block;
    padding: 10px 16px;
    background: white;
    color: #246b45;
    border-radius: 8px;
    text-decoration: none;
    font-weight: bold;
}

.shop-navigation a:hover {
    background: #e9f5ec;
}

        .wishlist-link {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 18px;
            background: white;
            color: #246b45;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
        }

        .wishlist-link:hover {
            background: #e9f5ec;
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .search-panel {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .filter-form {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr auto;
            gap: 12px;
        }

        input, select, button, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d9d2;
            border-radius: 6px;
            font-size: 14px;
            box-sizing: border-box;
        }

        button {
            background: #246b45;
            color: white;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover {
            background: #194d31;
        }

        .reset-link {
            display: inline-block;
            margin-top: 12px;
            color: #246b45;
            text-decoration: none;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
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

        .product-info {
            padding: 18px;
        }

        .product-info h3 {
            margin-top: 0;
            margin-bottom: 8px;
        }

        .category {
            display: inline-block;
            background: #e4f2e7;
            color: #246b45;
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 12px;
        }

        .freshness-badge {
    display: inline-block;
    padding: 5px 9px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: bold;
    margin-top: 8px;
}

.fresh-badge {
    background: #dcfce7;
    color: #166534;
}

.expiring-badge {
    background: #fef3c7;
    color: #92400e;
}

        .price {
            color: #246b45;
            font-size: 20px;
            font-weight: bold;
        }

        .description {
            color: #647067;
            line-height: 1.5;
        }

        .stock {
            font-size: 13px;
            color: #647067;
        }

        .cart-form {
            display: flex;
            gap: 8px;
            margin-top: 15px;
        }

        .cart-form input {
            width: 80px;
        }

        .cart-form button {
            flex: 1;
        }

        .rating-summary {
            margin: 12px 0;
            padding: 10px;
            background: #fff8df;
            border-radius: 6px;
        }

        .stars {
            color: #e4a11b;
            font-size: 19px;
            letter-spacing: 2px;
        }

        .rating-number {
            font-weight: bold;
            color: #26352a;
        }

        .reviews-section {
            border-top: 1px solid #e2e8e2;
            margin-top: 18px;
            padding-top: 12px;
        }

        .review {
            border-bottom: 1px solid #edf0ed;
            padding: 10px 0;
        }

        .review:last-child {
            border-bottom: none;
        }

        .reviewer {
            font-weight: bold;
            margin-bottom: 4px;
        }

        .review-comment {
            color: #647067;
            line-height: 1.5;
            overflow-wrap: anywhere;
        }

        .review-form {
            margin-top: 15px;
            padding: 12px;
            background: #f4f7f1;
            border-radius: 8px;
        }

        .review-form label {
            display: block;
            font-weight: bold;
            margin: 10px 0 6px;
        }

        .review-form textarea {
            min-height: 80px;
            resize: vertical;
        }

        .review-form button {
            margin-top: 10px;
        }

       .message {
    padding: 12px 18px;
    margin-bottom: 15px;
    border-radius: 8px;
    font-size: 14px;
    max-width: 450px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-8px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
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
            padding: 30px;
            text-align: center;
            border-radius: 10px;
        }

        @media (max-width: 750px) {
            .filter-form {
                grid-template-columns: 1fr;
            }

            header {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
   <header>
    <div class="header-content">
        <div>
            <h1>🌱 Farmers Marketplace</h1>
            <p>Find fresh agricultural products from local farmers.</p>
        </div>

        @auth
            <nav class="shop-navigation">
                <a href="{{ route('dashboard') }}">🏠 Dashboard</a>

                @if (auth()->user()->role === 'customer')
                    <a href="{{ route('cart.index') }}">🛒 My Cart</a>
                    <a href="{{ route('wishlist.index') }}">❤️ My Wishlist</a>
                @endif
            </nav>
        @endauth
    </div>
</header>

    <main class="container">

       @if (session('success'))
    <div class="message success" id="successMessage">
        ✓ {{ session('success') }}
    </div>
@endif

        @if (session('error'))
            <div class="message error">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="message error">
                <strong>Please check the following:</strong>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="search-panel">
            <h2>Find Products</h2>

            <form action="{{ route('shop.index') }}" method="GET" class="filter-form">
                <input
                    type="text"
                    name="search"
                    placeholder="Search product name..."
                    value="{{ request('search') }}"
                >

                <select name="category">
                    <option value="">All Categories</option>

                    @foreach ($categories as $category)
                        <option
                            value="{{ $category }}"
                            {{ request('category') === $category ? 'selected' : '' }}
                        >
                            {{ $category }}
                        </option>
                    @endforeach
                </select>

                <select name="sort">
                    <option value="">Newest Products</option>

                    <option
                        value="price_low"
                        {{ request('sort') === 'price_low' ? 'selected' : '' }}
                    >
                        Price: Low to High
                    </option>

                    <option
                        value="price_high"
                        {{ request('sort') === 'price_high' ? 'selected' : '' }}
                    >
                        Price: High to Low
                    </option>
                </select>

                <button type="submit">Search</button>
            </form>

            <a href="{{ route('shop.index') }}" class="reset-link">
                Clear Filters
            </a>
        </section>

        <h2>Agricultural Products</h2>

        @if ($products->isEmpty())
            <div class="empty-message">
                <h3>No products found</h3>
                <p>Try another search term or category.</p>
            </div>
        @else
            <div class="product-grid">

                @foreach ($products as $product)
                    <article class="product-card">

                        @if ($product->image)
                            <img
                                src="{{ asset('storage/' . $product->image) }}"
                                alt="{{ $product->name }}"
                            >
                        @else
                            <img
                                src="https://placehold.co/600x400?text=Farm+Product"
                                alt="No product image available"
                            >
                        @endif

                        <div class="product-info">
                            <h3>{{ $product->name }}</h3>

                            @if ($product->category)
                                <span class="category">
                                    {{ $product->category }}
                                </span>
                            @endif

                            @if ($product->expiration_date)
    @php
        $daysRemaining = \Carbon\Carbon::today()->diffInDays(
            \Carbon\Carbon::parse($product->expiration_date),
            false
        );
    @endphp

    @if ($daysRemaining <= 7)
        <br>
        <span class="freshness-badge expiring-badge">
            🟡 Expiring Soon
        </span>
    @else
        <br>
        <span class="freshness-badge fresh-badge">
            🟢 Fresh
        </span>
    @endif
@endif

                            <div class="rating-summary">

                                @if ($product->reviews->count() > 0)
                                    <div class="stars">
                                        @for ($star = 1; $star <= 5; $star++)
                                            {{ $star <= round($product->reviews_avg_rating) ? '★' : '☆' }}
                                        @endfor
                                    </div>

                                    <span class="rating-number">
                                        {{ number_format($product->reviews_avg_rating, 1) }} / 5
                                    </span>

                                    <small>
                                        ({{ $product->reviews->count() }}
                                        {{ $product->reviews->count() === 1 ? 'review' : 'reviews' }})
                                    </small>
                                @else
                                    <span>No ratings yet</span>
                                @endif

                            </div>

                            <p class="description">
                                {{ $product->description ?: 'Fresh agricultural product from a local farmer.' }}
                            </p>

                            <p class="price">
                                ₱{{ number_format($product->price, 2) }}
                            </p>

                            <p class="stock">
                                Available stock: {{ $product->quantity }}
                            </p>

                            <p class="stock">
                                Farmer: {{ $product->farmer->name ?? 'Local Farmer' }}
                            </p>

                            <form
                                action="{{ route('cart.add', $product->id) }}"
                                method="POST"
                                class="cart-form"
                            >
                                @csrf

                                <input
                                    type="number"
                                    name="quantity"
                                    min="1"
                                    max="{{ $product->quantity }}"
                                    value="1"
                                    required
                                >

                                <button type="submit">Add to Cart</button>
                            </form>

                            @auth
                                @if (auth()->user()->role === 'customer')

                                    @php
                                        $isWishlisted = \App\Models\Wishlist::where('user_id', auth()->id())
                                            ->where('product_id', $product->id)
                                            ->exists();
                                    @endphp

                                    @if ($isWishlisted)
                                        <form
                                            action="{{ route('wishlist.destroy', $product->id) }}"
                                            method="POST"
                                            style="margin-top: 10px;"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                style="background: #dc2626;"
                                            >
                                                ❤️ Saved — Remove from Wishlist
                                            </button>
                                        </form>
                                    @else
                                        <form
                                            action="{{ route('wishlist.store', $product->id) }}"
                                            method="POST"
                                            style="margin-top: 10px;"
                                        >
                                            @csrf

                                            <button
                                                type="submit"
                                                style="background: #e9f5ec; color: #246b45; border: 1px solid #246b45;"
                                            >
                                                ♡ Add to Wishlist
                                            </button>
                                        </form>
                                    @endif

                                @endif
                            @endauth

                            <section class="reviews-section">
                                <h4>Customer Reviews</h4>

                                @forelse ($product->reviews as $review)
                                    <div class="review">

                                        <div class="reviewer">
                                            {{ $review->user->name ?? 'Customer' }}
                                        </div>

                                        <div class="stars">
                                            @for ($star = 1; $star <= 5; $star++)
                                                {{ $star <= $review->rating ? '★' : '☆' }}
                                            @endfor
                                        </div>

                                        @if ($review->comment)
                                            <p class="review-comment">
                                                {{ $review->comment }}
                                            </p>
                                        @endif

                                        <small>
                                            {{ $review->created_at->format('M d, Y') }}
                                        </small>

                                    </div>
                                @empty
                                    <p class="stock">
                                        No customer reviews yet.
                                    </p>
                                @endforelse

                                @auth
                                    @if (auth()->user()->role === 'customer')

                                        @php
                                            $hasCompletedPurchase = \App\Models\OrderItem::where('product_id', $product->id)
                                                ->where('status', 'completed')
                                                ->whereHas('order', function ($query) {
                                                    $query->where('user_id', auth()->id());
                                                })
                                                ->exists();

                                            $hasReviewed = $product->reviews->contains('user_id', auth()->id());
                                        @endphp

                                        @if ($hasCompletedPurchase && !$hasReviewed)
                                            <form
                                                action="{{ route('products.reviews.store', $product->id) }}"
                                                method="POST"
                                                class="review-form"
                                            >
                                                @csrf

                                                <h4>Write a Review</h4>

                                                <label for="rating-{{ $product->id }}">
                                                    Your Rating
                                                </label>

                                                <select
                                                    name="rating"
                                                    id="rating-{{ $product->id }}"
                                                    required
                                                >
                                                    <option value="">Choose a rating</option>
                                                    <option value="5">★★★★★ - Excellent</option>
                                                    <option value="4">★★★★☆ - Very Good</option>
                                                    <option value="3">★★★☆☆ - Good</option>
                                                    <option value="2">★★☆☆☆ - Fair</option>
                                                    <option value="1">★☆☆☆☆ - Poor</option>
                                                </select>

                                                <label for="comment-{{ $product->id }}">
                                                    Your Comment (Optional)
                                                </label>

                                                <textarea
                                                    name="comment"
                                                    id="comment-{{ $product->id }}"
                                                    maxlength="1000"
                                                    placeholder="Share your experience with this product..."
                                                ></textarea>

                                                <button type="submit">Submit Review</button>
                                            </form>

                                        @elseif ($hasReviewed)
                                            <p class="stock">
                                                You have already reviewed this product.
                                            </p>

                                        @else
                                            <p class="stock">
                                                Complete an order containing this product to leave a review.
                                            </p>
                                        @endif

                                    @endif
                                @endauth

                            </section>
                        </div>
                    </article>
                @endforeach

            </div>
        @endif

    
    </main>

    <script>
    const successMessage = document.getElementById('successMessage');

    if (successMessage) {
        setTimeout(() => {
            successMessage.style.transition = 'opacity 0.5s ease';
            successMessage.style.opacity = '0';

            setTimeout(() => {
                successMessage.remove();
            }, 500);
        }, 3000);
    }
</script>

</body>
</html>
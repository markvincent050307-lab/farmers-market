<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Shopping Cart | Farmer's Market</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f7f2;
            margin: 0;
            color: #263629;
        }

        header {
            background: #276749;
            color: white;
            padding: 20px 7%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        header a {
            color: white;
            text-decoration: none;
            margin-left: 15px;
        }

        .container {
            max-width: 1000px;
            margin: 35px auto;
            padding: 0 20px;
        }

        .cart-item {
            background: white;
            padding: 20px;
            margin-bottom: 15px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: 0 2px 8px #00000010;
        }

        .cart-item img {
            width: 110px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }

        .details {
            flex: 1;
        }

        .price {
            color: #276749;
            font-weight: bold;
        }

        .message {
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 15px;
            background: #d4edda;
            color: #155724;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
        }

        .total {
            background: white;
            padding: 22px;
            border-radius: 10px;
            text-align: right;
            margin-top: 20px;
        }

        .button {
            display: inline-block;
            background: #276749;
            color: white;
            text-decoration: none;
            border: none;
            padding: 12px 18px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
        }

        .button:hover {
            background: #1f5139;
        }

        @media (max-width: 600px) {
            .cart-item {
                align-items: flex-start;
                flex-wrap: wrap;
            }
        }
    </style>
</head>
<body>

<header>
    <h2>🌾 Farmer's Market</h2>

    <nav>
        <a href="{{ route('shop.index') }}">Shop</a>
        <a href="{{ route('cart.index') }}">My Cart</a>
        <a href="{{ route('dashboard') }}">Dashboard</a>
    </nav>
</header>

<div class="container">

    <h1>🛒 My Shopping Cart</h1>
    <p>Review the products you want to purchase.</p>

    @if(session('success'))
        <div class="message">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="message error">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="message error">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div id="ajax-message" class="message" style="display: none;"></div>

    @php
        $total = 0;
    @endphp

  <div id="cart-items">

    @forelse($cartItems as $item)

        @php
            $subtotal = $item->product->price * $item->quantity;
            $total += $subtotal;
        @endphp

        <div class="cart-item"
     id="cart-item-{{ $item->id }}"
     data-subtotal="{{ $subtotal }}">

            @if($item->product->image)
                <img
                    src="{{ asset('storage/' . $item->product->image) }}"
                    alt="{{ $item->product->name }}"
                >
            @else
                <div>No image</div>
            @endif

            <div class="details">
                <h3>{{ $item->product->name }}</h3>

                <p>{{ $item->product->description }}</p>

                <p>
                    Price:
                    <span class="price">
                        ₱{{ number_format($item->product->price, 2) }}
                    </span>
                </p>

                <strong>Quantity:</strong>

                <div style="display: flex; align-items: center; gap: 10px; margin: 10px 0;">

                    <button type="button"
                        class="button quantity-btn"
                        data-stock="{{ $item->product->quantity }}"
                        data-id="{{ $item->id }}"
                        data-quantity="{{ $item->quantity - 1 }}"
                        {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                        −
                    </button>

                    <strong id="quantity-{{ $item->id }}">
                        {{ $item->quantity }}
                    </strong>

                    <button type="button"
                        class="button quantity-btn"
                        data-stock="{{ $item->product->quantity }}"
                        data-id="{{ $item->id }}"
                        data-quantity="{{ $item->quantity + 1 }}"
                        {{ $item->quantity >= $item->product->quantity ? 'disabled' : '' }}>
                        +
                    </button>

                </div>

                <p>
                    Subtotal:
                    <strong id="subtotal-{{ $item->id }}">
                        ₱{{ number_format($subtotal, 2) }}
                    </strong>
                </p>

                <button type="button"
                    class="remove-btn"
                    data-id="{{ $item->id }}"
                    style="background: #dc3545; color: white; border: none;
                           padding: 9px 14px; border-radius: 6px; cursor: pointer;">
                    🗑 Remove
                </button>

            </div>
        </div>

    @empty

        <div class="cart-item" id="cart-empty">
            <div>
                <h3>Your cart is empty.</h3>
                <p>Browse the shop and add products you want to buy.</p>

                <a href="{{ route('shop.index') }}" class="button">
                    Browse Products
                </a>
            </div>
        </div>

    @endforelse

</div>

    @if($cartItems->isNotEmpty())

       <div class="total" id="cart-summary">
            <h2 id="cart-total">
    Total: ₱{{ number_format($total, 2) }}
</h2>

            <p>Delivery fees, if applicable, are not included.</p>

            <form action="{{ route('checkout.store') }}" method="POST">
    @csrf

    <div style="margin: 20px 0;">
    <label for="delivery_address" style="display: block; margin-bottom: 8px;">
        Delivery Address
    </label>

    <textarea
        id="delivery_address"
        name="delivery_address"
        rows="3"
        required
        placeholder="Enter your complete delivery address"
        style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 6px;"
    >{{ old('delivery_address') }}</textarea>

    @error('delivery_address')
        <p style="color: red; margin-top: 5px;">{{ $message }}</p>
    @enderror
</div>

<div style="margin: 20px 0;">
    <label for="contact_number" style="display: block; margin-bottom: 8px;">
        Contact Number
    </label>

    <input
        type="tel"
        id="contact_number"
        name="contact_number"
        value="{{ old('contact_number') }}"
        required
        maxlength="30"
        placeholder="Enter your contact number"
        style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 6px;"
    >

    @error('contact_number')
        <p style="color: red; margin-top: 5px;">{{ $message }}</p>
    @enderror
</div>

        <div style="margin: 20px 0;">
    <p style="font-weight: bold; margin-bottom: 12px;">
        Choose Payment Method
    </p>

    <label style="display:flex; align-items:center; gap:12px;
        padding:15px; margin-bottom:10px; background:white;
        border:1px solid #ddd; border-radius:8px; cursor:pointer;">

        <input type="radio" name="payment_method"
            value="gcash" required>

        <img src="https://commons.wikimedia.org/wiki/Special:FilePath/GCash_logo.svg"
            alt="GCash Logo" style="width:100px; height:auto;">

        <span style="font-weight:bold;">GCash (via Xendit)</span>
    </label>

    <label style="display:flex; align-items:center; gap:12px;
        padding:15px; background:white; border:1px solid #ddd;
        border-radius:8px; cursor:pointer;">

        <input type="radio" name="payment_method"
            value="cod" required>

        <span style="font-size:25px;">💵</span>
        <span style="font-weight:bold;">Cash on Delivery</span>
    </label>
</div>
    <button type="submit" class="button">
        Proceed to Checkout
    </button>
</form>
        </div>

    @endif

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const messageBox = document.getElementById('ajax-message');
    const cartItems = document.getElementById('cart-items');
    const cartSummary = document.getElementById('cart-summary');

    const updateUrl = @json(route('cart.update', ['cartItem' => '__ID__']));
    const removeUrl = @json(route('cart.remove', ['cartItem' => '__ID__']));

    function showMessage(message, isError = false) {
        messageBox.textContent = message;
        messageBox.style.display = 'block';
        messageBox.classList.toggle('error', isError);

        if (!isError) {
            setTimeout(() => {
                messageBox.style.display = 'none';
            }, 3000);
        }
    }

    function updateTotal() {
        let total = 0;

        document.querySelectorAll('.cart-item[data-subtotal]').forEach(item => {
            total += parseFloat(item.dataset.subtotal);
        });

        document.getElementById('cart-total').textContent =
            'Total: ₱' + total.toLocaleString('en-PH', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
    }

    cartItems.addEventListener('click', async function (event) {

        const quantityButton = event.target.closest('.quantity-btn');
        const removeButton = event.target.closest('.remove-btn');

        if (quantityButton) {
            const id = quantityButton.dataset.id;
            const quantity = parseInt(quantityButton.dataset.quantity);

            quantityButton.disabled = true;

            try {
                const response = await fetch(updateUrl.replace('__ID__', id), {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ quantity: quantity })
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Unable to update quantity.');
                }

                document.getElementById('quantity-' + id).textContent = data.quantity;

                document.getElementById('subtotal-' + id).textContent =
                    '₱' + Number(data.subtotal).toLocaleString('en-PH', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });

                const item = document.getElementById('cart-item-' + id);
                item.dataset.subtotal = data.subtotal;

                const buttons = item.querySelectorAll('.quantity-btn');

                buttons.forEach(button => {
                    const isIncrease = button.textContent.trim() === '+';

                    button.dataset.quantity = isIncrease
                        ? data.quantity + 1
                        : data.quantity - 1;

                    button.disabled = isIncrease
                        ? data.quantity >= Number(button.dataset.stock)
                        : data.quantity <= 1;
                });

                updateTotal();
                showMessage(data.message);

            } catch (error) {
                showMessage(error.message, true);
           } finally {
    const item = document.getElementById('cart-item-' + id);

    if (item) {
        const currentQuantity = parseInt(
            document.getElementById('quantity-' + id).textContent
        );

        item.querySelectorAll('.quantity-btn').forEach(button => {
            const isIncrease = button.textContent.trim() === '+';

            button.disabled = isIncrease
                ? currentQuantity >= Number(button.dataset.stock)
                : currentQuantity <= 1;
        });
    }
}
        }

        if (removeButton) {
            const id = removeButton.dataset.id;

            if (!confirm('Are you sure you want to remove this product from your cart?')) {
                return;
            }

            removeButton.disabled = true;

            try {
                const response = await fetch(removeUrl.replace('__ID__', id), {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Unable to remove product.');
                }

                document.getElementById('cart-item-' + id).remove();

                const remainingItems = cartItems.querySelectorAll('.cart-item[data-subtotal]');

                if (remainingItems.length === 0) {
                    cartItems.innerHTML = `
                        <div class="cart-item">
                            <div>
                                <h3>Your cart is empty.</h3>
                                <p>Browse the shop and add products you want to buy.</p>
                                <a href="{{ route('shop.index') }}" class="button">
                                    Browse Products
                                </a>
                            </div>
                        </div>
                    `;

                    cartSummary.style.display = 'none';
                } else {
                    updateTotal();
                }

                showMessage(data.message);

            } catch (error) {
                showMessage(error.message, true);
                removeButton.disabled = false;
            }
        }

    });

});
</script>

</body>
</html>
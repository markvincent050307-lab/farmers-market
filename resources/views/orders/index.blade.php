<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders | Farmer's Market</title>

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

    .order {
        background: white;
        border-radius: 10px;
        padding: 22px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px #00000010;
    }

    .order-header {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        border-bottom: 1px solid #e5e7eb;
        padding-bottom: 12px;
    }

    .status {
        padding: 6px 12px;
        border-radius: 20px;
        display: inline-block;
        font-size: 14px;
        font-weight: bold;
    }

    .order-status {
        background: #fff3cd;
        color: #856404;
    }

    .payment-paid {
        background: #d1fae5;
        color: #065f46;
    }

    .payment-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .payment-failed {
        background: #fee2e2;
        color: #991b1b;
    }

    .payment-unpaid {
        background: #e5e7eb;
        color: #374151;
    }

    .item {
        padding: 12px 0;
        border-bottom: 1px solid #eee;
    }

    .total {
        text-align: right;
        color: #276749;
        font-size: 20px;
        font-weight: bold;
    }

    .button {
        display: inline-block;
        background: #276749;
        color: white;
        text-decoration: none;
        padding: 12px 18px;
        border-radius: 6px;
    }

    .message {
        padding: 12px;
        background: #d1fae5;
        color: #065f46;
        border-radius: 6px;
        margin-bottom: 20px;
    }
</style>

</head>

<body>

<header>
    <h2>🌾 Farmer's Market</h2>

<nav>
    <a href="{{ route('shop.index') }}">Shop</a>
    <a href="{{ route('cart.index') }}">My Cart</a>
    <a href="{{ route('orders.index') }}">My Orders</a>
    <a href="{{ route('dashboard') }}">Dashboard</a>
</nav>

</header>

<div class="container">
    <h1>📦 My Orders</h1>
    <p>View your ordered products, payment status, and order progress.</p>

@if(session('success'))
    <div class="message">
        {{ session('success') }}
    </div>
@endif

@forelse($orders as $order)
    <div class="order">

        <div class="order-header">
            <div>
                <h3>Order #{{ $order->id }}</h3>

                <p>
                    Placed on
                    {{ $order->created_at->format('M d, Y h:i A') }}
                </p>
            </div>

            <div>
                <p>
                    <strong>Order Status:</strong><br>
                    <span class="status order-status">
                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                    </span>
                </p>

                <p>
                    <strong>Payment Status:</strong><br>
                   <span class="status payment-{{ strtolower($order->payment_status ?? 'unpaid') }}">
    @if(strtolower($order->payment_status ?? '') === 'paid')
        <span style="font-weight: bold;">✓</span> Paid
    @else
        {{ ucfirst($order->payment_status ?? 'unpaid') }}
    @endif
</span>
                </p>

                <p>
                    <strong>Payment Method:</strong>
                    {{ strtoupper($order->payment_method ?? 'Not specified') }}
                </p>
            </div>
        </div>

        @foreach($order->items as $item)
            <div class="item">
                <strong>
                    {{ $item->product->name ?? 'Product no longer available' }}
                </strong>

                <p>
                    Quantity: {{ $item->quantity }}
                    &times;
                    ₱{{ number_format($item->price, 2) }}
                </p>

                <p>
                    Subtotal:
                    ₱{{ number_format($item->price * $item->quantity, 2) }}
                </p>
            </div>
        @endforeach

        <p class="total">
    Total: ₱{{ number_format($order->total_amount, 2) }}
</p>

@if ($order->status === 'pending')
    <div style="text-align: right; margin-top: 15px;">
        <form action="{{ route('orders.cancel', $order->id) }}"
              method="POST"
              onsubmit="return confirm('Are you sure you want to cancel this order?');">
            @csrf
            @method('PATCH')

            <button type="submit"
                    style="background-color: #dc2626; color: white; padding: 10px 16px; border: 2px solid #b91c1c; border-radius: 6px; cursor: pointer; font-weight: bold;">
                Cancel Order
            </button>
        </form>
    </div>
@endif

    </div>
@empty
    <div class="order">
        <h3>You haven't placed any orders yet.</h3>
        <p>Visit the shop to find products from local farmers.</p>

        <a href="{{ route('shop.index') }}" class="button">
            Browse Products
        </a>
    </div>
@endforelse

</div>

</body>
</html>
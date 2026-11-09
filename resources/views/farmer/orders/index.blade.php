<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Incoming Orders | Farmer's Market</title>

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
        max-width: 1100px;
        margin: 35px auto;
        padding: 0 20px;
    }

    .order-card {
        background: white;
        padding: 24px;
        border-radius: 12px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px #00000010;
    }

    .order-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        border-bottom: 1px solid #e5e7eb;
        padding-bottom: 12px;
    }

    .product-name {
        color: #276749;
        font-weight: bold;
        font-size: 18px;
    }

   .status {
    background: #fff3cd;
    color: #856404;
    padding: 7px 12px;
    border-radius: 20px;
    display: inline-block;
}

.status-processing {
    background: #cfe2ff;
    color: #084298;
}

.status-ready {
    background: #d1e7dd;
    color: #0f5132;
}

.status-completed {
    background: #198754;
    color: white;
}

    .empty {
        background: white;
        padding: 35px;
        border-radius: 12px;
        text-align: center;
    }

    .back-button {
        display: inline-block;
        margin-top: 15px;
        background: #276749;
        color: white;
        padding: 11px 18px;
        border-radius: 6px;
        text-decoration: none;
    }
</style>

</head>

<body>

<header>
    <h2>🌾 Farmer's Market</h2>

<nav>
    <a href="{{ route('farmer.orders.index') }}">Orders</a>
    <a href="{{ route('dashboard') }}">Dashboard</a>
</nav>

</header>

<div class="container">

<h1>📦 Incoming Orders</h1>

<p>View orders containing products you have listed.</p>

@if(session('success'))
    <div style="background: #d4edda; color: #155724; padding: 12px;
                border-radius: 6px; margin: 15px 0;">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div style="background: #f8d7da; color: #721c24; padding: 12px;
                border-radius: 6px; margin: 15px 0;">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

@forelse($orderItems as $item)

    <div class="order-card">

        <div class="order-heading">
            <div>
                <h3>Order #{{ $item->order->id }}</h3>

                <p>
                    Ordered on:
                    {{ $item->order->created_at->format('M d, Y h:i A') }}
                </p>
            </div>

            <span class="status
    {{ $item->status === 'completed' ? 'status-completed' : '' }}
    {{ $item->status === 'processing' ? 'status-processing' : '' }}
    {{ $item->status === 'ready_for_delivery' ? 'status-ready' : '' }}">
    {{ ucwords(str_replace('_', ' ', $item->status)) }}
</span>
        </div>

        <p class="product-name">
            {{ $item->product->name ?? 'Product no longer available' }}
        </p>

        <p>
            Customer:
            {{ $item->order->user->name ?? 'Customer unavailable' }}
        </p>

        <p>
            Quantity ordered: {{ $item->quantity }}
        </p>

        <p>
            Price per item:
            ₱{{ number_format($item->price, 2) }}
        </p>

        <p>
            Your product subtotal:
            <strong>
                ₱{{ number_format($item->price * $item->quantity, 2) }}
            </strong>
        </p>

        <p>
    Product fulfillment status:
    <strong>
        {{ ucwords(str_replace('_', ' ', $item->status)) }}
    </strong>
</p>

<form
    action="{{ route('farmer.orders.updateStatus', $item->id) }}"
    method="POST"
    style="margin-top: 15px;"
>
    @csrf
    @method('PATCH')

    <label for="status-{{ $item->id }}">
        Update status:
    </label>

    <select
        name="status"
        id="status-{{ $item->id }}"
        required
        style="padding: 10px; border-radius: 6px; margin: 8px;"
    >
        <option value="pending"
            {{ $item->status === 'pending' ? 'selected' : '' }}>
            Pending
        </option>

        <option value="processing"
            {{ $item->status === 'processing' ? 'selected' : '' }}>
            Processing
        </option>

        <option value="ready_for_delivery"
            {{ $item->status === 'ready_for_delivery' ? 'selected' : '' }}>
            Ready for Delivery
        </option>

        <option value="completed"
            {{ $item->status === 'completed' ? 'selected' : '' }}>
            Completed
        </option>
    </select>

    <button
        type="submit"
        style="background: #276749; color: white; padding: 10px 15px;
               border: none; border-radius: 6px; cursor: pointer;"
    >
        Save Status
    </button>
</form>

    </div>

@empty

    <div class="empty">
        <h3>No orders yet.</h3>
        <p>Orders containing your products will appear here.</p>
    </div>

@endforelse

<a href="{{ route('dashboard') }}" class="back-button">
    Back to Dashboard
</a>

</div>

</body>
</html>
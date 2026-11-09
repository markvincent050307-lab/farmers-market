<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details | Farmers Marketplace</title>

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
            max-width: 1100px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .section {
            background: white;
            padding: 24px;
            border-radius: 12px;
            margin-bottom: 22px;
            box-shadow: 0 3px 10px rgba(0,0,0,.05);
        }

        .section h3 {
            color: #245c38;
            margin-top: 0;
            margin-bottom: 18px;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 18px;
        }

        .detail {
            padding: 14px;
            background: #f4f7f2;
            border-radius: 8px;
        }

        .detail strong {
            display: block;
            color: #68796b;
            font-size: 13px;
            margin-bottom: 7px;
        }

        .detail span {
            font-weight: bold;
            overflow-wrap: anywhere;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 700px;
        }

        th, td {
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #e8eee8;
        }

        th {
            background: #f0f5ef;
            color: #245c38;
        }

        .status {
            display: inline-block;
            padding: 6px 11px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .paid, .completed, .cod {
            background: #e0f2e4;
            color: #246b38;
        }

        .pending, .processing {
            background: #fff3cd;
            color: #856404;
        }

        .failed, .cancelled {
            background: #fde2e2;
            color: #b42318;
        }

        .total {
            text-align: right;
            font-size: 22px;
            font-weight: bold;
            color: #245c38;
            margin-top: 20px;
        }

        .empty {
            text-align: center;
            padding: 25px;
            color: #777;
        }

        @media(max-width: 600px) {
            header {
                padding: 18px;
            }

            .container {
                padding: 0 12px;
            }
        }
    </style>
</head>

<body>

<header>
    <h2>Farmers Marketplace | Order Details</h2>

    <a href="{{ route('admin.orders.index') }}" class="back">
        Back to Orders
    </a>
</header>

<div class="container">

    <h2>Order #{{ $order->id }}</h2>
    <p>Complete information about this customer order.</p>

    <!-- Customer Information -->
    <div class="section">

        <h3>Customer Information</h3>

        <div class="details-grid">

            <div class="detail">
                <strong>Customer Name</strong>
                <span>{{ $order->user->name ?? 'Unknown Customer' }}</span>
            </div>

            <div class="detail">
                <strong>Email Address</strong>
                <span>{{ $order->user->email ?? 'N/A' }}</span>
            </div>

            <div class="detail">
                <strong>Order Date</strong>
                <span>{{ $order->created_at->format('M d, Y h:i A') }}</span>
            </div>

        </div>

    </div>

    <!-- Payment Information -->
    <div class="section">

        <h3>Payment Information</h3>

        <div class="details-grid">

            <div class="detail">
                <strong>Payment Method</strong>
                <span>{{ strtoupper($order->payment_method ?? 'N/A') }}</span>
            </div>

            <div class="detail">
                <strong>Payment Status</strong>

                @php
                    $paymentStatus = strtolower($order->payment_status ?? 'pending');
                @endphp

                <span class="status {{ $paymentStatus }}">
                    {{ ucfirst($paymentStatus) }}
                </span>
            </div>

            <div class="detail">
                <strong>Payment Reference</strong>
                <span>{{ $order->payment_reference ?? 'N/A' }}</span>
            </div>

        </div>

    </div>

    <!-- Purchased Products -->
    <div class="section">

        <h3>Purchased Products</h3>

        <div class="table-wrapper">

            <table>

                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Farmer</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Item Status</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($order->items as $item)

                        <tr>

                            <td>
                                {{ $item->product->name ?? 'Deleted Product' }}
                            </td>

                            <td>
                                {{ $item->farmer->name ?? 'Unknown Farmer' }}
                            </td>

                            <td>
                                ₱{{ number_format($item->price, 2) }}
                            </td>

                            <td>
                                {{ $item->quantity }}
                            </td>

                            <td>
                                ₱{{ number_format($item->price * $item->quantity, 2) }}
                            </td>

                            <td>
                                @php
                                    $itemStatus = strtolower($item->status ?? 'pending');
                                @endphp

                                <span class="status {{ $itemStatus }}">
                                    {{ ucfirst(str_replace('_', ' ', $itemStatus)) }}
                                </span>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="empty">
                                No products found in this order.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="total">
            Total Order Amount:
            ₱{{ number_format($order->total_amount, 2) }}
        </div>

    </div>

</div>

</body>
</html>
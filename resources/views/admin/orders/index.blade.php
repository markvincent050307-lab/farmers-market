<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management | Farmers Marketplace</title>

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
            max-width: 1300px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 18px;
            margin: 25px 0;
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
            border: 1px solid #ccd8cc;
            border-radius: 6px;
            min-width: 180px;
        }

        .search-form input {
            flex: 1;
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
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #e8eee8;
        }

        th {
            background: #f0f5ef;
            color: #245c38;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        .status {
            display: inline-block;
            padding: 6px 11px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .paid {
            background: #e0f2e4;
            color: #246b38;
        }

        .pending {
            background: #fff3cd;
            color: #856404;
        }

        .failed {
            background: #fde2e2;
            color: #b42318;
        }

        .view-button {
            display: inline-block;
            padding: 8px 13px;
            background: #246b45;
            color: white;
            text-decoration: none;
            border-radius: 5px;
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
    <h2>Farmers Marketplace | Order Management</h2>
    <a href="{{ route('dashboard') }}" class="back">Back to Dashboard</a>
</header>

<div class="container">

    <h2>All Customer Orders</h2>
    <p>Monitor customer purchases, order information, and payment statuses.</p>

    <div class="summary">

        <div class="card">
            <h3>Total Orders</h3>
            <p>{{ $totalOrders }}</p>
        </div>

        <div class="card">
            <h3>Paid Orders</h3>
            <p>{{ $paidOrders }}</p>
        </div>

        <div class="card">
            <h3>Pending Payments</h3>
            <p>{{ $pendingPayments }}</p>
        </div>

    </div>

    <div class="table-container">

        <h3>Order Records</h3>

        <form method="GET" action="{{ route('admin.orders.index') }}" class="search-form">

            <input
                type="text"
                name="search"
                placeholder="Search by order ID or customer name..."
                value="{{ request('search') }}"
            >

            <select name="payment_status">
                <option value="">All Payment Statuses</option>
                <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>
                    Paid
                </option>
                <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>
                    Pending
                </option>
                <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>
                    Failed
                </option>
            </select>

            <button type="submit">Search / Filter</button>

            <a href="{{ route('admin.orders.index') }}" class="reset-button">Reset</a>

        </form>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Total Amount</th>
                        <th>Payment Method</th>
                        <th>Payment Status</th>
                        <th>Order Date</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>

                            <td>
                                {{ $order->user->name ?? 'Unknown Customer' }}
                            </td>

                            <td>
                                ₱{{ number_format($order->total_amount, 2) }}
                            </td>

                            <td>
                                {{ strtoupper($order->payment_method ?? 'N/A') }}
                            </td>

                            <td>
                                @php
                                    $paymentStatus = strtolower($order->payment_status ?? 'pending');
                                @endphp

                                <span class="status {{ $paymentStatus }}">
                                    {{ ucfirst($paymentStatus) }}
                                </span>
                            </td>

                            <td>
                                {{ $order->created_at->format('M d, Y h:i A') }}
                            </td>

                            <td>
                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                   class="view-button">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty">
                                No orders found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</div>

</body>
</html>
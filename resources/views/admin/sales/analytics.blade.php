<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Analytics | Farmers Marketplace</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f7f2;
            margin: 0;
            color: #26352b;
        }

        header {
            background: #245c35;
            color: white;
            padding: 22px 5%;
        }

        header h1 {
            margin: 0;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 30px auto;
        }

        .back-button {
            display: inline-block;
            margin-bottom: 20px;
            background: #e4eee4;
            color: #245c35;
            padding: 10px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
            gap: 18px;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            padding: 22px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }

        .card h3 {
            color: #66756a;
            font-size: 14px;
            margin: 0 0 12px;
        }

        .card h2 {
            color: #245c35;
            font-size: 27px;
            margin: 0;
        }

        .section {
            background: white;
            padding: 22px;
            border-radius: 10px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            overflow-x: auto;
        }

        .section h2 {
            color: #245c35;
            margin-top: 0;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 550px;
        }

        th, td {
            padding: 13px;
            border-bottom: 1px solid #e5e9e5;
            text-align: left;
        }

        th {
            background: #edf4ed;
            color: #245c35;
        }

        .empty {
            text-align: center;
            color: #777;
            padding: 25px;
        }

        @media (max-width: 600px) {
            .container {
                width: 94%;
            }

            .card h2 {
                font-size: 23px;
            }
        }
    </style>
</head>

<body>

<header>
    <h1>📊 Admin Sales Analytics</h1>
    <p>Monitor Farmers Marketplace sales performance</p>
</header>

<div class="container">

    <a href="{{ route('dashboard') }}" class="back-button">
        ← Back to Admin Dashboard
    </a>

    <div class="stats">

        <div class="card">
            <h3>💰 Total Revenue</h3>
            <h2>₱{{ number_format($totalRevenue, 2) }}</h2>
        </div>

        <div class="card">
            <h3>📦 Products Sold</h3>
            <h2>{{ number_format($totalProductsSold) }}</h2>
        </div>

        <div class="card">
            <h3>🛒 Completed Orders</h3>
            <h2>{{ number_format($totalCompletedOrders) }}</h2>
        </div>

        <div class="card">
            <h3>📅 Today's Sales</h3>
            <h2>₱{{ number_format($todaySales, 2) }}</h2>
        </div>

        <div class="card">
            <h3>📆 This Week's Sales</h3>
            <h2>₱{{ number_format($weeklySales, 2) }}</h2>
        </div>

        <div class="card">
            <h3>🗓️ This Month's Sales</h3>
            <h2>₱{{ number_format($monthlySales, 2) }}</h2>
        </div>

    </div>

    <div class="section">
        <h2>🏆 Best-Selling Products</h2>

        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity Sold</th>
                    <th>Total Revenue</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($bestSellingProducts as $item)
                    <tr>
                        <td>{{ $item->product?->name ?? 'Deleted Product' }}</td>
                        <td>{{ number_format($item->total_sold) }}</td>
                        <td>₱{{ number_format($item->total_revenue, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="empty">
                            No completed sales available yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="section">
        <h2>🌾 Top-Performing Farmers</h2>

        <table>
            <thead>
                <tr>
                    <th>Farmer Name</th>
                    <th>Products Sold</th>
                    <th>Total Revenue</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($topFarmers as $farmer)
                    <tr>
                        <td>{{ $farmer->farmer?->name ?? 'Deleted Farmer' }}</td>
                        <td>{{ number_format($farmer->total_sold) }}</td>
                        <td>₱{{ number_format($farmer->total_revenue, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="empty">
                            No farmer sales available yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

</body>
</html>
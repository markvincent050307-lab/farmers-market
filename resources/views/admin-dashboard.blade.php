<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Farmers Marketplace</title>

    <style>
        * {
            box-sizing: border-box;
        }

        .management-button {
    display: inline-block;
    margin-top: 12px;
    padding: 12px 20px;
    background: #246b45;
    color: white;
    text-decoration: none;
    border-radius: 7px;
    font-weight: bold;
    transition: 0.2s;
}

.management-button:hover {
    background: #194d30;
}

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f7f2;
            color: #26352a;
        }

        header {
            background: #246b45;
            color: white;
            padding: 22px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        header h1 {
            margin: 0;
            font-size: 24px;
        }

        header p {
            margin: 6px 0 0;
            color: #e0eee4;
        }

        .logout-button {
            background: white;
            color: #246b45;
            border: none;
            padding: 10px 18px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 30px auto;
        }

        .welcome {
            margin-bottom: 25px;
        }

        .welcome h2 {
            margin-bottom: 5px;
        }

        .welcome p {
            color: #718076;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
            gap: 20px;
        }

        .stat-card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.05);
            border-left: 5px solid #246b45;
        }

        .stat-card p {
            color: #718076;
            margin: 0 0 12px;
        }

        .stat-card h2 {
            font-size: 27px;
            margin: 0;
            color: #246b45;
        }

        .section {
            background: white;
            padding: 25px;
            border-radius: 12px;
            margin-top: 30px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.05);
            overflow-x: auto;
        }

        .section h3 {
            margin-top: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 650px;
        }

        th, td {
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #edf0ed;
        }

        th {
            background: #f4f7f2;
            color: #246b45;
        }

        .empty {
            text-align: center;
            color: #888;
            padding: 25px;
        }

        @media (max-width: 600px) {
            header h1 {
                font-size: 20px;
            }

            .container {
                width: 94%;
            }
        }
    </style>
</head>

<body>

<header>
    <div>
        <h1>🌱 Farmers Marketplace</h1>
        <p>Administrator Dashboard</p>
    </div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="logout-button">Logout</button>
    </form>
</header>

<div class="container">

    <div class="welcome">
    <h2>Welcome, Admin {{ Auth::user()->name }}!</h2>
    <p>Monitor and manage your entire marketplace.</p>

    <a href="{{ route('admin.users.index') }}" class="management-button">
        👥 User Management
    </a>

    <a href="{{ route('admin.products.index') }}" class="management-button">
    📦 Product Management
</a>

<a href="{{ route('admin.orders.index') }}" class="management-button">
    🛒 Order Management
</a>

<a href="{{ route('admin.sales.analytics') }}" class="management-button">
    📊 Sales Analytics
</a>
</div>

    <div class="stats">

        <div class="stat-card">
            <p>👨‍🌾 Total Farmers</p>
            <h2>{{ $totalFarmers }}</h2>
        </div>

        <div class="stat-card">
            <p>👥 Total Customers</p>
            <h2>{{ $totalCustomers }}</h2>
        </div>

        <div class="stat-card">
            <p>📦 Total Products</p>
            <h2>{{ $totalProducts }}</h2>
        </div>

        <div class="stat-card">
            <p>🛒 Total Orders</p>
            <h2>{{ $totalOrders }}</h2>
        </div>

        <div class="stat-card">
            <p>💰 Total Marketplace Sales</p>
            <h2>₱{{ number_format($totalSales, 2) }}</h2>
        </div>

        <div class="stat-card">
            <p>✅ Completed Orders</p>
            <h2>{{ $completedOrders }}</h2>
        </div>

        <div class="stat-card">
            <p>⏳ Pending Orders</p>
            <h2>{{ $pendingOrders }}</h2>
        </div>

        <div class="stat-card">
            <p>🌾 Products Sold</p>
            <h2>{{ $totalProductsSold }}</h2>
        </div>

    </div>

  <div class="section">
    <h3>📊 Farmer Sales Performance</h3>

    <div style="margin-bottom: 20px;">
        <button type="button" onclick="changeSalesPeriod('day')" class="sales-filter">Day</button>
        <button type="button" onclick="changeSalesPeriod('week')" class="sales-filter">Week</button>
        <button type="button" onclick="changeSalesPeriod('month')" class="sales-filter">Month</button>
    </div>

    <div style="width: 100%; height: 350px;">
        <canvas id="farmerSalesChart"></canvas>
    </div>

    @if($farmerSales->isEmpty())
        <p class="empty">No farmer sales data available yet.</p>
    @endif
</div>

    <div class="section">
        <h3>📋 Recent Marketplace Orders</h3>

        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Total Amount</th>
                    <th>Payment Method</th>
                    <th>Payment Status</th>
                    <th>Order Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($recentOrders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->user->name ?? 'Unknown' }}</td>
                        <td>₱{{ number_format($order->total_amount, 2) }}</td>
                        <td>{{ strtoupper($order->payment_method ?? 'N/A') }}</td>
                        <td>{{ ucfirst($order->payment_status ?? 'N/A') }}</td>
                        <td>{{ ucfirst($order->status ?? 'N/A') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty">
                            No orders found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
  <!-- Recent Registrations -->
    <div class="section">
        <h3>👥 Recent User Registrations</h3>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Registered At</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($recentRegistrations as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>{{ $user->created_at->format('M d, Y h:i A') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="empty">
                            No registrations found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Recent Login Activity -->
    <div class="section">
        <h3>🔐 Recent Login Activity</h3>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Last Login</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($recentLogins as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>{{ \Carbon\Carbon::parse($user->last_login_at)->format('M d, Y h:i A') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="empty">
                            No login activity found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const salesData = @json($farmerSales);

    const ctx = document.getElementById('farmerSalesChart');

    let farmerSalesChart;

    function changeSalesPeriod(period) {
        const now = new Date();

        let labels = [];
        let totals = [];

        if (period === 'day') {
            labels = Array.from({ length: 24 }, (_, i) =>
                String(i).padStart(2, '0') + ':00'
            );
            totals = Array(24).fill(0);
        }

        if (period === 'week') {
            labels = ['Sunday', 'Monday', 'Tuesday', 'Wednesday',
                      'Thursday', 'Friday', 'Saturday'];
            totals = Array(7).fill(0);
        }

        if (period === 'month') {
            const days = new Date(
                now.getFullYear(),
                now.getMonth() + 1,
                0
            ).getDate();

            labels = Array.from({ length: days }, (_, i) => i + 1);
            totals = Array(days).fill(0);
        }

        salesData.forEach(sale => {
            const date = new Date(sale.sale_date);

            if (
                date.getFullYear() !== now.getFullYear() ||
                date.getMonth() !== now.getMonth()
            ) {
                if (period === 'month') return;
            }

            if (period === 'day') {
                if (date.toDateString() === now.toDateString()) {
                    totals[date.getHours()] += Number(sale.total_sales);
                }
            }

            if (period === 'week') {
                const startOfWeek = new Date(now);
                startOfWeek.setDate(now.getDate() - now.getDay());
                startOfWeek.setHours(0, 0, 0, 0);

                const endOfWeek = new Date(startOfWeek);
                endOfWeek.setDate(startOfWeek.getDate() + 7);

                if (date >= startOfWeek && date < endOfWeek) {
                    totals[date.getDay()] += Number(sale.total_sales);
                }
            }

            if (period === 'month') {
                totals[date.getDate() - 1] += Number(sale.total_sales);
            }
        });

        if (farmerSalesChart) {
            farmerSalesChart.destroy();
        }

        farmerSalesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Farmer Sales (₱)',
                    data: totals,
                    backgroundColor: '#246b45',
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: value => '₱' + value.toLocaleString()
                        }
                    }
                }
            }
        });
    }

    changeSalesPeriod('day');
</script>

</body>
</html>
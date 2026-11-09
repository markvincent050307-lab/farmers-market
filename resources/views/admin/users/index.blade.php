<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management | Farmers Marketplace</title>

    <style>
        * {
            box-sizing: border-box;
        }

        .search-form input {
    flex: 1;
    min-width: 200px;
}

.delete-button {
    padding: 8px 13px;
    background: #dc3545;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.delete-button:hover {
    background: #b52a37;
}

.update-button {
    padding: 8px 12px;
    background: #246b45;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 5px;
}

.update-button:hover {
    background: #194d30;
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
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 18px;
            margin-bottom: 25px;
        }

        .card {
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

        .table-container {
            background: white;
            padding: 22px;
            border-radius: 12px;
            overflow-x: auto;
            box-shadow: 0 3px 10px rgba(0,0,0,.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 650px;
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

        .role {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .farmer {
            background: #e0f2e4;
            color: #246b38;
        }

        .customer {
            background: #e3efff;
            color: #245a9a;
        }

        .admin {
            background: #f3e5ff;
            color: #7137a0;
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
    <h2>Farmers Marketplace | User Management</h2>
    <a href="{{ route('dashboard') }}" class="back">Back to Dashboard</a>
</header>

<div class="container">

    <h2>Registered Users</h2>
    <p>View all farmers, customers, and administrators registered in the marketplace.</p>

    <div class="summary">

        <div class="card">
            <h3>Total Farmers</h3>
            <p>{{ $totalFarmers }}</p>
        </div>

        <div class="card">
            <h3>Total Customers</h3>
            <p>{{ $totalCustomers }}</p>
        </div>

        <div class="card">
            <h3>Total Administrators</h3>
            <p>{{ $totalAdmins }}</p>
        </div>

        <div class="card">
            <h3>Total Registered Users</h3>
            <p>{{ $users->count() }}</p>
        </div>

    </div>

  <div class="table-container">

    <h3>All User Accounts</h3>

    @if(session('success'))
    <p style="color: green; font-weight: bold;">
        {{ session('success') }}
    </p>
@endif

@if(session('error'))
    <p style="color: red; font-weight: bold;">
        {{ session('error') }}
    </p>
@endif

    <form method="GET" action="{{ route('admin.users.index') }}" class="search-form">

        <input
            type="text"
            name="search"
            placeholder="Search by name or email..."
            value="{{ request('search') }}"
        >

        <select name="role">
            <option value="">All Roles</option>
            <option value="farmer" {{ request('role') == 'farmer' ? 'selected' : '' }}>Farmers</option>
            <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Customers</option>
            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrators</option>
        </select>

        <button type="submit">Search / Filter</button>

        <a href="{{ route('admin.users.index') }}" class="reset-button">Reset</a>

    </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email Address</th>
                   <th>Role</th>
<th>Account Status</th>
<th>Date Registered</th>
<th>Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
    @if($user->id === Auth::id())
        <span class="role admin">Your Account</span>
    @else
        <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST">
            @csrf
            @method('PATCH')

            <select name="role" required>
                <option value="farmer" {{ $user->role === 'farmer' ? 'selected' : '' }}>Farmer</option>
                <option value="customer" {{ $user->role === 'customer' ? 'selected' : '' }}>Customer</option>
                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>

            <button type="submit" class="update-button">Update</button>
        </form>
    @endif
</td>
                        <td>
    @if($user->is_active)
        <span style="background:#e0f2e4;color:#246b38;padding:6px 12px;border-radius:20px;font-size:12px;font-weight:bold;">
            Active
        </span>
    @else
        <span style="background:#fde2e2;color:#b42318;padding:6px 12px;border-radius:20px;font-size:12px;font-weight:bold;">
            Suspended
        </span>
    @endif
</td>

<td>{{ $user->created_at->format('M d, Y') }}</td>
                        <td>

                        @if($user->id !== Auth::id() && $user->role !== 'admin')
    <form action="{{ route('admin.users.toggleStatus', $user->id) }}"
          method="POST"
          onsubmit="return confirm('Are you sure you want to change this account status?');"
          style="margin-bottom: 8px;">

        @csrf
        @method('PATCH')

        @if($user->is_active)
            <button type="submit"
                    style="padding:8px 12px;background:#dc3545;color:white;border:none;border-radius:5px;cursor:pointer;">
                Suspend
            </button>
        @else
            <button type="submit"
                    style="padding:8px 12px;background:#246b45;color:white;border:none;border-radius:5px;cursor:pointer;">
                Reactivate
            </button>
        @endif
    </form>
@endif
    @if($user->id !== Auth::id())
        <form action="{{ route('admin.users.destroy', $user->id) }}"
              method="POST"
              onsubmit="return confirm('Are you sure you want to delete this user account? This action cannot be undone.');">

            @csrf
            @method('DELETE')

            <button type="submit" class="delete-button">
                Delete
            </button>
        </form>
    @else
        <span style="color: #888;">Current Account</span>
    @endif
</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty">
                            No registered users found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>

</div>

</body>
</html>
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(Auth::user()->role === 'admin', 403);

        $query = User::query();

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by account role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->get();

        $totalFarmers = User::where('role', 'farmer')->count();
        $totalCustomers = User::where('role', 'customer')->count();
        $totalAdmins = User::where('role', 'admin')->count();

        return view('admin.users.index', compact(
            'users',
            'totalFarmers',
            'totalCustomers',
            'totalAdmins'
        ));

    }

    public function updateRole(Request $request, User $user)
{
    abort_unless(Auth::user()->role === 'admin', 403);

    $request->validate([
        'role' => 'required|in:farmer,customer,admin',
    ]);

    // Prevent the administrator from changing their own role
    if ($user->id === Auth::id()) {
        return back()->with('error', 'You cannot change your own administrator role.');
    }

    // Prevent removing the last administrator
    if (
        $user->role === 'admin' &&
        $request->role !== 'admin' &&
        User::where('role', 'admin')->count() <= 1
    ) {
        return back()->with('error', 'You cannot remove the last administrator.');
    }

    $user->update([
        'role' => $request->role,
    ]);

    return back()->with('success', 'User role updated successfully!');
}

public function destroy(User $user)
{
    abort_unless(Auth::user()->role === 'admin', 403);

    // Prevent deleting your own account
    if ($user->id === Auth::id()) {
        return back()->with('error', 'You cannot delete your own administrator account.');
    }

    // Prevent deleting the last administrator
    if (
        $user->role === 'admin' &&
        User::where('role', 'admin')->count() <= 1
    ) {
        return back()->with('error', 'You cannot delete the last administrator.');
    }

    $user->delete();

    return back()->with('success', 'User account deleted successfully!');
}

public function toggleStatus(User $user)
{
    abort_unless(Auth::user()->role === 'admin', 403);

    // Prevent suspending your own account
    if ($user->id === Auth::id()) {
        return back()->with('error', 'You cannot suspend your own account.');
    }

    // Prevent suspending administrator accounts
    if ($user->role === 'admin') {
        return back()->with('error', 'Administrator accounts cannot be suspended.');
    }

    $user->update([
        'is_active' => !$user->is_active,
    ]);

    $message = $user->is_active
        ? 'User account reactivated successfully!'
        : 'User account suspended successfully!';

    return back()->with('success', $message);
}
}
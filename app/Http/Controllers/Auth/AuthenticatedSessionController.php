<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
   public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();

    $user = Auth::user();

if (!$user->is_active) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return back()->withErrors([
        'email' => 'Your account has been suspended. Please contact the administrator.',
    ])->onlyInput('email');
}

    $request->session()->regenerate();

    $user = Auth::user();

    $user->update([
    'last_login_at' => now(),
]);

    Mail::raw(
        "Hello {$user->name},\n\nA login to your Farmers Marketplace account was detected.\n\nLogin Date: " . now()->format('F d, Y h:i A') . "\n\nIf this was you, no action is needed. If you don't recognize this activity, please reset your password.\n\nFarmers Marketplace Team",
        function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('New Login to Your Farmers Marketplace Account');
        }
    );

    return redirect()->intended(route('dashboard', absolute: false));
}

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

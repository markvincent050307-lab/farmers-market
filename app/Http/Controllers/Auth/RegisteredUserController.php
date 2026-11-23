<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:125'],
            'last_name' => ['required', 'string', 'max:125'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:' . User::class,
            ],
            'password' => [
                'required',
                'confirmed',
                Rules\Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
            'role' => ['required', 'in:farmer,customer'],
            'terms' => ['accepted'],
        ]);

        // Combine first name and last name
        $fullName = trim(
            $request->first_name . ' ' . $request->last_name
        );

        $user = User::create([
            'name' => $fullName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        event(new Registered($user));

        // Send welcome email
        Mail::raw(
            "Hello {$user->name},\n\nWelcome to Farmers Marketplace!\n\nYour account has been successfully registered. You can now log in and start using our website.\n\nThank you for joining us!\n\nFarmers Marketplace Team",
            function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Welcome to Farmers Marketplace!');
            }
        );

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
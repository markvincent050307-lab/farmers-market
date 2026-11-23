<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $login = trim($this->input('email'));

        $user = filter_var($login, FILTER_VALIDATE_EMAIL)
            ? User::where('email', strtolower($login))->first()
            : User::whereRaw('LOWER(name) = ?', [strtolower($login)])->first();

        if (
            ! $user ||
            ! Auth::attempt([
                'email' => $user->email,
                'password' => $this->input('password'),
            ], $this->boolean('remember'))
        ) {
            RateLimiter::hit($this->throttleKey(), 600);

           if (RateLimiter::attempts($this->throttleKey()) >= 3) {
    RateLimiter::clear($this->throttleKey());
    RateLimiter::clear($this->lockoutKey());
    RateLimiter::hit($this->lockoutKey(), 180);
}

            throw ValidationException::withMessages([
                'email' => 'Incorrect email/name or password.',
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        RateLimiter::clear($this->lockoutKey());
    }

    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->lockoutKey(), 1)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->lockoutKey());

        throw ValidationException::withMessages([
            'email' => 'Too many incorrect attempts. Please try again in '
                . ceil($seconds / 60) . ' minute(s).',
        ]);
    }

    public function throttleKey(): string
    {
        return Str::transliterate(
            Str::lower(trim($this->input('email'))) . '|' . $this->ip()
        );
    }

    private function lockoutKey(): string
    {
        return $this->throttleKey() . ':lockout';
    }
}
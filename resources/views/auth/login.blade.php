<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email or Full Name -->
        <div>
            <x-input-label for="email" :value="__('Email Address or Full Name')" />

            <x-text-input
                id="email"
                class="block mt-1 w-full"
                type="text"
                name="email"
                :value="old('email')"
                placeholder="Enter your email or full name"
                required
                autofocus
                autocomplete="username"
            />

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

      <!-- Password -->
<div class="mt-4">
    <x-input-label for="password" :value="__('Password')" />

    <div class="flex items-center mt-1 border border-gray-300 rounded-md overflow-hidden focus-within:ring-2 focus-within:ring-green-500">
        <input
            id="password"
            type="password"
            name="password"
            required
            autocomplete="current-password"
            class="block w-full border-0 focus:ring-0"
        >

        <button
            type="button"
            onclick="toggleLoginPassword()"
            id="togglePasswordButton"
            class="px-4 py-2 text-gray-600 hover:text-green-600 bg-white"
            aria-label="Show password"
        >
            <svg id="eyeIcon"
                xmlns="http://www.w3.org/2000/svg"
                width="22"
                height="22"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7C20.268 16.057 16.477 19 12 19s-8.268-2.943-9.542-7z"/>
                <circle cx="12" cy="12" r="3"/>
            </svg>
        </button>
    </div>

    <x-input-error :messages="$errors->get('password')" class="mt-2" />
</div>

<script>
    function toggleLoginPassword() {
        const password = document.getElementById('password');
        const button = document.getElementById('togglePasswordButton');

        password.type = password.type === 'password' ? 'text' : 'password';

        button.setAttribute(
            'aria-label',
            password.type === 'password' ? 'Show password' : 'Hide password'
        );
    }
</script>
       <!-- Remember Me -->
<div class="flex items-center mt-4">
    <label for="remember_me" class="inline-flex items-center">
        <input
            id="remember_me"
            type="checkbox"
            class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500"
            name="remember"
        >
        <span class="ms-2 text-sm text-gray-600">
            {{ __('Remember me') }}
        </span>
    </label>
</div>
        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}"
                >
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
        <div class="text-center mt-5">
    <span class="text-sm text-gray-600">
        Don't have an account yet?
    </span>

    <a href="{{ route('register') }}"
       class="text-sm font-semibold text-green-600 hover:text-green-700 underline">
        Register now.
    </a>
</div>
    </form>
</x-guest-layout>
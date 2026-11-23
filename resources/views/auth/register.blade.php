<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" id="register-form">
        @csrf

        <!-- Hidden combined name for the existing database -->
        <input type="hidden" id="name" name="name" value="{{ old('name') }}">

        <!-- First Name -->
        <div>
            <x-input-label for="first_name" :value="__('First Name')" />
            <x-text-input id="first_name" class="block mt-1 w-full"
                type="text" name="first_name" :value="old('first_name')"
                required autofocus autocomplete="given-name" />
            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
        </div>

        <!-- Second Name -->
        <div class="mt-4">
            <x-input-label for="last_name" :value="__('Last Name')" />
            <x-text-input id="last_name" class="block mt-1 w-full"
                type="text" name="last_name" :value="old('last_name')"
                required autocomplete="family-name" />
            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Role -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('Register As')" />

            <select id="role" name="role"
                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                required>
                <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                <option value="farmer" {{ old('role') == 'farmer' ? 'selected' : '' }}>Farmer</option>
            </select>

            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full"
                type="email" name="email" :value="old('email')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <div style="position: relative;">
                <x-text-input id="password" class="block mt-1 w-full"
                    style="padding-right: 45px;"
                    type="password" name="password"
                    required autocomplete="new-password" />

                <button type="button" onclick="togglePassword('password', this)"
                    style="position:absolute; right:12px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:#6b7280;"
                    aria-label="Show password">
                    <svg class="eye-icon" xmlns="http://www.w3.org/2000/svg"
                        width="21" height="21" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7-10-7-10-7Z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </button>
            </div>

            <!-- Password Strength Line Bar -->
            <div style="margin-top: 15px; width: 100%;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                    <span style="font-size: 14px; font-weight: 500; color: #374151;">
                        Password Strength
                    </span>

                    <span id="password-strength-text"
                        style="font-size: 14px; font-weight: bold; color: #6b7280;">
                        Not entered
                    </span>
                </div>

                <div style="display: flex; gap: 6px; width: 100%; height: 9px;">
                    <div id="strength-line-1"
                        style="flex: 1; height: 9px; background: #e5e7eb; border-radius: 10px; transition: background 0.3s;">
                    </div>

                    <div id="strength-line-2"
                        style="flex: 1; height: 9px; background: #e5e7eb; border-radius: 10px; transition: background 0.3s;">
                    </div>

                    <div id="strength-line-3"
                        style="flex: 1; height: 9px; background: #e5e7eb; border-radius: 10px; transition: background 0.3s;">
                    </div>
                </div>

                <p style="font-size: 12px; color: #6b7280; margin-top: 9px;">
                    At least 8 characters, uppercase, lowercase, number,
                    and special character required.
                </p>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <div style="position: relative;">
                <x-text-input id="password_confirmation"
                    class="block mt-1 w-full"
                    style="padding-right: 45px;"
                    type="password" name="password_confirmation"
                    required autocomplete="new-password" />

                <button type="button" onclick="togglePassword('password_confirmation', this)"
                    style="position:absolute; right:12px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:#6b7280;"
                    aria-label="Show password">
                    <svg class="eye-icon" xmlns="http://www.w3.org/2000/svg"
                        width="21" height="21" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7-10-7-10-7Z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Terms and Agreement -->
<div class="mt-6">
    <label class="flex items-start gap-2">
        <input type="checkbox"
            name="terms"
            value="1"
            required
            class="mt-1 rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500">

        <span class="text-sm text-gray-600">
            I have read and agree to the
            <a href="{{ route('terms') }}"
               target="_blank"
               class="text-green-600 font-semibold underline">
                Terms and Conditions
            </a>
            and
            <a href="{{ route('privacy') }}"
               target="_blank"
               class="text-green-600 font-semibold underline">
                Privacy Policy
            </a>.
        </span>
    </label>

    <x-input-error :messages="$errors->get('terms')" class="mt-2" />
</div>

        <!-- Buttons -->
        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        // Show or hide password
        function togglePassword(fieldId, button) {
            const field = document.getElementById(fieldId);

            if (field.type === 'password') {
                field.type = 'text';
                button.setAttribute('aria-label', 'Hide password');
                button.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg"
                        width="21" height="21" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 3l18 18"/>
                        <path d="M10.6 10.6a2 2 0 0 0 2.8 2.8"/>
                        <path d="M9.9 5.2A10.8 10.8 0 0 1 12 5c6.4 0 10 7 10 7a15.8 15.8 0 0 1-4 4.7"/>
                        <path d="M6.2 6.2C3.5 8 2 12 2 12s3.6 7 10 7a10.7 10.7 0 0 0 4-.8"/>
                    </svg>`;
            } else {
                field.type = 'password';
                button.setAttribute('aria-label', 'Show password');
                button.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg"
                        width="21" height="21" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7-10-7-10-7Z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>`;
            }
        }

        // Password strength bar
        document.addEventListener('DOMContentLoaded', function () {
            const password = document.getElementById('password');
            const text = document.getElementById('password-strength-text');

            const lines = [
                document.getElementById('strength-line-1'),
                document.getElementById('strength-line-2'),
                document.getElementById('strength-line-3')
            ];

            password.addEventListener('input', function () {
                const value = password.value;
                let score = 0;

                if (value.length >= 8) score++;
                if (/[a-z]/.test(value)) score++;
                if (/[A-Z]/.test(value)) score++;
                if (/[0-9]/.test(value)) score++;
                if (/[^A-Za-z0-9]/.test(value)) score++;

                let activeLines = 0;
                let color = '#dc2626';
                let label = 'Weak';

                if (value.length === 0) {
                    activeLines = 0;
                    label = 'Not entered';
                    color = '#6b7280';
                } else if (score <= 2) {
                    activeLines = 1;
                } else if (score <= 4) {
                    activeLines = 2;
                    color = '#f59e0b';
                    label = 'Medium';
                } else {
                    activeLines = 3;
                    color = '#16a34a';
                    label = 'Strong';
                }

                lines.forEach((line, index) => {
                    line.style.backgroundColor =
                        index < activeLines ? color : '#e5e7eb';
                });

                text.textContent = label;
                text.style.color = color;
            });
        });

        // Combine first and second name before registration
        document.getElementById('register-form').addEventListener('submit', function () {
            const firstName = document.getElementById('first_name').value.trim();
            const last_name = document.getElementById('last_name').value.trim();

            document.getElementById('name').value =
                firstName + ' ' + last_name;
        });
    </script>
</x-guest-layout>
@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md bg-white/90 backdrop-blur rounded-2xl shadow-xl p-6 sm:p-8">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold">Create your account</h2>
            <p class="text-sm text-gray-500">Sign up to start managing products and sales</p>
        </div>

        @if ($errors->any())
            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 text-red-700 px-4 py-3 text-sm">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-5" id="registerForm">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <div class="mt-1">
                    <input type="text" name="name" id="name" value="{{ old('name') }}" autocomplete="name"
                           class="w-full rounded-lg border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <div class="mt-1 relative">
                    <input type="email" name="email" id="email" value="{{ old('email') }}" autocomplete="email"
                           class="w-full rounded-lg border-gray-300 pl-10 pr-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    <span class="absolute left-3 top-2.5 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2Zm-1.4 3-6.6 4.95L5.4 7h13.2ZM4 18V8.25l7.2 5.4a1 1 0 0 0 1.2 0L20 8.25V18H4Z"/></svg>
                    </span>
                </div>
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <div class="mt-1 relative">
                    <input type="password" name="password" id="password" autocomplete="new-password"
                           class="w-full rounded-lg border-gray-300 pl-10 pr-10 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    <span class="absolute left-3 top-2.5 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 1a5 5 0 0 0-5 5v3H6a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8a2 2 0 0 0-2-2h-1V6a5 5 0 0 0-5-5Zm-3 8V6a3 3 0 0 1 6 0v3H9Z"/></svg>
                    </span>
                    <button type="button" id="togglePassword" class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600" aria-label="Toggle password visibility">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 5c-7 0-10 7-10 7s3 7 10 7 10-7 10-7-3-7-10-7Zm0 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10Z"/></svg>
                    </button>
                </div>
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <div class="mt-1 relative">
                    <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password"
                           class="w-full rounded-lg border-gray-300 pl-10 pr-10 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    <span class="absolute left-3 top-2.5 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 1a5 5 0 0 0-5 5v3H6a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8a2 2 0 0 0-2-2h-1V6a5 5 0 0 0-5-5Zm-3 8V6a3 3 0 0 1 6 0v3H9Z"/></svg>
                    </span>
                    <button type="button" id="togglePassword2" class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600" aria-label="Toggle confirm password visibility">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 5c-7 0-10 7-10 7s3 7 10 7 10-7 10-7-3-7-10-7Zm0 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10Z"/></svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2.5 rounded-lg hover:bg-blue-700 transition disabled:opacity-70 disabled:cursor-not-allowed">
                <span id="submitLabel">Create account</span>
            </button>
        </form>

        @auth
        <div class="mt-6">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full bg-gray-100 text-gray-800 py-2 rounded-lg hover:bg-gray-200">
                    Logout
                </button>
            </form>
            <p class="mt-2 text-center text-sm text-gray-600">
                You are already logged in as <span class="font-semibold">{{ auth()->user()->email }}</span>.
            </p>
        </div>
        @endauth

        <p class="mt-6 text-center text-sm text-gray-600">
            Already have an account?
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login</a>
        </p>
    </div>
</div>

<script>
    (function () {
        const form = document.getElementById('registerForm');
        const submitLabel = document.getElementById('submitLabel');
        const toggle1 = document.getElementById('togglePassword');
        const toggle2 = document.getElementById('togglePassword2');
        const pwd1 = document.getElementById('password');
        const pwd2 = document.getElementById('password_confirmation');

        if (form) {
            form.addEventListener('submit', function () {
                form.querySelector('button[type=\'submit\']').setAttribute('disabled', 'disabled');
                if (submitLabel) submitLabel.textContent = 'Creating…';
            });
        }

        if (toggle1 && pwd1) {
            toggle1.addEventListener('click', function () {
                const t = pwd1.getAttribute('type') === 'password' ? 'text' : 'password';
                pwd1.setAttribute('type', t);
            });
        }
        if (toggle2 && pwd2) {
            toggle2.addEventListener('click', function () {
                const t = pwd2.getAttribute('type') === 'password' ? 'text' : 'password';
                pwd2.setAttribute('type', t);
            });
        }
    })();
</script>
@endsection

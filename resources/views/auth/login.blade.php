@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full p-6 bg-white rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
        
        @if (session('status'))
            <div class="mb-4 text-green-600 text-center">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" name="email" id="email" class="w-full px-3 py-2 border rounded-lg" required>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" name="password" id="password" class="w-full px-3 py-2 border rounded-lg" required>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">
                Login
            </button>
        </form>
        
        @auth
        <div class="mt-6">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full bg-gray-200 text-gray-800 py-2 rounded-lg hover:bg-gray-300">
                    Logout
                </button>
            </form>
            <p class="mt-2 text-center text-sm text-gray-600">
                You are already logged in as <span class="font-semibold">{{ auth()->user()->email }}</span>.
            </p>
        </div>
        @endauth
        <p class="mt-4 text-center">
            Don't have an account? <a href="{{ route('register') }}" class="text-blue-500">Register</a>
        </p>
    </div>
</div>
@endsection

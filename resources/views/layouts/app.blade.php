<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Laravel POS System') }}</title>
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="min-h-screen flex flex-col">
        <!-- App Header -->
        <header class="bg-white/90 backdrop-filter backdrop-blur border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center gap-3">
                        <a href="{{ url('/') }}" class="flex items-center gap-3">
                            <div class="h-9 w-9 rounded-lg bg-blue-600 flex items-center justify-center text-white font-bold">
                                POS
                            </div>
                            <div>
                                <h1 class="text-lg font-semibold text-gray-900">{{ config('app.name', 'Laravel POS System') }}</h1>
                                <p class="text-xs text-gray-500 hidden sm:block">Fast billing • Simple inventory • Clear reporting</p>
                            </div>
                        </a>
                    </div>
                    <nav class="hidden md:flex items-center gap-2">
                        <a href="{{ route('products.index') }}" class="px-3 py-2 rounded-lg hover:bg-gray-100 text-gray-700">Manage Products</a>
                        <a href="{{ route('sales.index') }}" class="px-3 py-2 rounded-lg hover:bg-gray-100 text-gray-700">View Sales</a>
                        <a href="{{ route('sales.create') }}" class="px-3 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">Record Sale</a>
                    </nav>
                    <div class="hidden md:flex items-center gap-3">
                        @auth
                            <span class="text-sm text-gray-600">Hi, <span class="font-medium">{{ auth()->user()->name ?? auth()->user()->email }}</span></span>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="px-3 py-2 rounded-lg border border-gray-300 hover:bg-gray-50">Logout</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="px-3 py-2 rounded-lg border border-gray-300 hover:bg-gray-50">Login</a>
                            <a href="{{ route('register') }}" class="px-3 py-2 rounded-lg bg-gray-900 text-white hover:bg-black">Register</a>
                        @endauth
                    </div>
                    <!-- Mobile menu button -->
                    <button id="mobileMenuBtn" class="md:hidden p-2 rounded-lg border border-gray-300" aria-label="Toggle menu">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
                <!-- Mobile menu -->
                <div id="mobileMenu" class="md:hidden hidden pb-4">
                    <nav class="flex flex-col gap-2">
                        <a href="{{ route('products.index') }}" class="px-3 py-2 rounded-lg hover:bg-gray-100 text-gray-700">Manage Products</a>
                        <a href="{{ route('sales.index') }}" class="px-3 py-2 rounded-lg hover:bg-gray-100 text-gray-700">View Sales</a>
                        <a href="{{ route('sales.create') }}" class="px-3 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">Record Sale</a>
                    </nav>
                    <div class="mt-3 flex items-center gap-3">
                        @auth
                            <span class="text-sm text-gray-600">Hi, <span class="font-medium">{{ auth()->user()->name ?? auth()->user()->email }}</span></span>
                            <form method="POST" action="{{ route('logout') }}" class="inline w-full">
                                @csrf
                                <button type="submit" class="px-3 py-2 rounded-lg border border-gray-300 hover:bg-gray-50 w-full">Logout</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="flex-1 text-center px-3 py-2 rounded-lg border border-gray-300 hover:bg-gray-50">Login</a>
                            <a href="{{ route('register') }}" class="flex-1 text-center px-3 py-2 rounded-lg bg-gray-900 text-white hover:bg-black">Register</a>
                        @endauth
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                {{-- Global flash/status messages --}}
                @if(session('success'))
                    <div class="mb-4 rounded-lg border border-green-200 bg-green-50 text-green-700 px-4 py-3">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('status'))
                    <div class="mb-4 rounded-lg border border-blue-200 bg-blue-50 text-blue-700 px-4 py-3">
                        {{ session('status') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 text-red-700 px-4 py-3">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>

        <!-- Footer -->
        <footer class="border-t bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 text-sm text-gray-500 flex items-center justify-between">
                <p>© {{ date('Y') }} {{ config('app.name', 'Laravel POS System') }}</p>
                <p>Built with <span class="font-medium">Laravel</span> &amp; <span class="font-medium">Tailwind CSS</span></p>
            </div>
        </footer>
    </div>

    <script>
        (function () {
            const btn = document.getElementById('mobileMenuBtn');
            const menu = document.getElementById('mobileMenu');
            if (!btn || !menu) return;
            btn.addEventListener('click', function () {
                menu.classList.toggle('hidden');
            });
        })();
    </script>
</body>
</html>

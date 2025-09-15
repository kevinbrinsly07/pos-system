@extends('welcome')

@section('content')
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        {{-- Top Bar --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-bold">Add Product</h2>
                <p class="text-sm text-gray-500">Create a new product and set its details.</p>
            </div>
            @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-50">
                    Logout
                </button>
            </form>
            @endauth
        </div>

        {{-- Flash messages --}}
        @if ($errors->any())
            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 text-red-700 px-4 py-3">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('products.store') }}" method="POST" class="bg-white p-6 rounded-xl shadow space-y-6">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 px-4 py-2 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                <input type="number" name="price" id="price" step="0.01" value="{{ old('price') }}" class="mt-1 px-4 py-2 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div>
                <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
                <input type="number" name="stock" id="stock" value="{{ old('stock') }}" class="mt-1 px-4 py-2 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div class="flex justify-end">
                <a href="{{ route('products.index') }}" class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-50 mr-2">Cancel</a>
                <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">Save Product</button>
            </div>
        </form>
    </div>
@endsection
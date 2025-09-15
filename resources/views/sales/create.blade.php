@extends('welcome')

@section('content')
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        {{-- Top Bar --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-bold">Record Sale</h2>
                <p class="text-sm text-gray-500">Add a new sale to the system.</p>
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
        <form action="{{ route('sales.store') }}" method="POST" class="bg-white p-6 rounded-xl shadow space-y-6">
            @csrf
            <div>
                <label for="product_id" class="block text-sm font-medium text-gray-700">Product</label>
                <select name="product_id" id="product_id" class="mt-1 px-4 py-2 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" @if(empty($products)) disabled @endif required>
                    <option value="" selected disabled>{{ empty($products) ? 'No products available' : 'Select a product' }}</option>
                    @forelse ($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->name }} (${{ number_format($product->price, 2) }})
                        </option>
                    @empty
                    @endforelse
                </select>
                @if (empty($products))
                    <p class="text-sm text-gray-500 mt-1">
                        No products found. <a href="{{ route('products.create') }}" class="text-blue-600 underline">Add a product</a> first.
                    </p>
                @endif
            </div>
            <div>
                <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                <input type="number" name="quantity" id="quantity" class="mt-1 px-4 py-2 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" min="1" required>
            </div>
            <div class="flex justify-end">
                <a href="{{ route('sales.index') }}" class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-50 mr-2">Cancel</a>
                <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">Record Sale</button>
            </div>
        </form>
    </div>
@endsection
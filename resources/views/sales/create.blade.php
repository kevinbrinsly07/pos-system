@extends('welcome')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Record Sale</h2>
    <form action="{{ route('sales.store') }}" method="POST" class="bg-white p-4 shadow rounded">
        @csrf
        <div class="mb-4">
            <label for="product_id" class="block text-sm font-medium">Product</label>
            <select name="product_id" id="product_id" class="w-full border rounded p-2" required>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }} (${{ number_format($product->price, 2) }})</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="quantity" class="block text-sm font-medium">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="w-full border rounded p-2" required>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Record Sale</button>
    </form>
@endsection
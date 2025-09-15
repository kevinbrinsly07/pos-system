@extends('welcome')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Add Product</h2>
    <form action="{{ route('products.store') }}" method="POST" class="bg-white p-4 shadow rounded">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium">Product Name</label>
            <input type="text" name="name" id="name" class="w-full border rounded p-2" required>
        </div>
        <div class="mb-4">
            <label for="price" class="block text-sm font-medium">Price</label>
            <input type="number" name="price" id="price" step="0.01" class="w-full border rounded p-2" required>
        </div>
        <div class="mb-4">
            <label for="stock" class="block text-sm font-medium">Stock</label>
            <input type="number" name="stock" id="stock" class="w-full border rounded p-2" required>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save Product</button>
    </form>
@endsection
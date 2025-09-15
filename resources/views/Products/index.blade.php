@extends('welcome')

@section('content')
  @auth
  <form method="POST" action="{{ route('logout') }}" class="mb-4">
      @csrf
      <button type="submit" class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300">
          Logout
      </button>
  </form>
  @endauth
    <h2 class="text-2xl font-bold mb-4">Products</h2>
    <a href="{{ route('products.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Add Product</a>
    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">{{ session('success') }}</div>
    @endif
    <table class="w-full bg-white shadow rounded">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2">Name</th>
                <th class="p-2">Price</th>
                <th class="p-2">Stock</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td class="p-2">{{ $product->name }}</td>
                    <td class="p-2">${{ number_format($product->price, 2) }}</td>
                    <td class="p-2">{{ $product->stock }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
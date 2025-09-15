@extends('welcome')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Sales History</h2>
    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">{{ session('error') }}</div>
    @endif
    <table class="w-full bg-white shadow rounded">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2">Product</th>
                <th class="p-2">Quantity</th>
                <th class="p-2">Total Price</th>
                <th class="p-2">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $sale)
                <tr>
                    <td class="p-2">{{ $sale->product->name }}</td>
                    <td class="p-2">{{ $sale->quantity }}</td>
                    <td class="p-2">${{ number_format($sale->total_price, 2) }}</td>
                    <td class="p-2">{{ $sale->created_at->format('Y-m-d H:i:s') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
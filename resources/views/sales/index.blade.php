@extends('welcome')

@section('content')
<div class="max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8 py-6">
    {{-- Top Bar --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold">Sales History</h2>
            <p class="text-sm text-gray-500">Track past sales and transactions.</p>
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
    @if (session('success'))
    <div class="mb-4 rounded-lg border border-green-200 bg-green-50 text-green-700 px-4 py-3">
        {{ session('success') }}
    </div>
    @endif
    @if (session('error'))
    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 text-red-700 px-4 py-3">
        {{ session('error') }}
    </div>
    @endif

    {{-- Table --}}
    <div class="overflow-hidden rounded-xl border bg-white">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left">
                <thead class="bg-gray-50 sticky top-0">
                    <tr>
                        <th class="p-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Product</th>
                        <th class="p-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Quantity</th>
                        <th class="p-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Price</th>
                        <th class="p-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="p-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Invoice</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($sales as $sale)
                    <tr class="hover:bg-gray-50">
                        <td class="p-3 font-medium text-gray-800">{{ $sale->product->name }}</td>
                        <td class="p-3">{{ $sale->quantity }}</td>
                        <td class="p-3">${{ number_format($sale->total_price, 2) }}</td>
                        <td class="p-3">{{ $sale->created_at->format('Y-m-d H:i:s') }}</td>
                        <td class="p-3">
                            <div class="flex items-center gap-2">
                                <a
                                    class="inline-flex items-center px-3 py-1.5 text-sm rounded-lg border border-gray-300 hover:bg-gray-50"
                                    target="_blank"
                                    href="{{ route('sales.invoice.pdf', $sale->id) }}"
                                    title="Open PDF invoice">
                                    View PDF
                                </a>
                                <a
                                    class="inline-flex items-center px-3 py-1.5 text-sm rounded-lg bg-blue-600 text-white hover:bg-blue-700"
                                    href="{{ route('sales.invoice.download', $sale->id) }}"
                                    title="Download invoice">
                                    Download
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-6 text-center text-gray-500">No sales found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex flex-row gap-3 justify-end mt-5">
        <a href="{{ route('sales.combined_invoice') }}" class="btn btn-primary inline-flex items-center px-3 py-1.5 text-sm rounded-lg border border-gray-300 hover:bg-gray-50">View Full Invoice</a>
        <a href="{{ route('sales.combined_invoice') }}?download=1" class="btn btn-secondary inline-flex items-center px-3 py-1.5 text-sm rounded-lg bg-blue-600 text-white hover:bg-blue-700">Download Full Invoice</a>
    </div>
</div>
@endsection
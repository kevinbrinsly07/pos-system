@extends('welcome')

@section('content')
  <div class="max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8 py-6">
      {{-- Top Bar --}}
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
          <div>
              <h2 class="text-2xl font-bold">Products</h2>
              <p class="text-sm text-gray-500">Manage your catalog and stock at a glance.</p>
          </div>
          <div class="flex items-center gap-3">
              @auth
              <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-50">
                      Logout
                  </button>
              </form>
              @endauth
              <a href="{{ route('products.create') }}" class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M13 11V6a1 1 0 1 0-2 0v5H6a1 1 0 1 0 0 2h5v5a1 1 0 1 0 2 0v-5h5a1 1 0 1 0 0-2h-5z"/></svg>
                  Add Product
              </a>
          </div>
      </div>

      {{-- Flash messages --}}
      @if (session('success'))
          <div class="mb-4 rounded-lg border border-green-200 bg-green-50 text-green-700 px-4 py-3">
              {{ session('success') }}
          </div>
      @endif

      {{-- Quick Stats --}}
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
          <div class="p-4 rounded-xl border bg-white shadow-sm">
              <p class="text-sm text-gray-500">Total Products</p>
              <p class="text-2xl font-semibold mt-1">{{ $products->count() }}</p>
          </div>
          <div class="p-4 rounded-xl border bg-white shadow-sm">
              <p class="text-sm text-gray-500">Total Stock</p>
              <p class="text-2xl font-semibold mt-1">
                  {{ method_exists($products, 'sum') ? $products->sum('stock') : collect($products)->sum('stock') }}
              </p>
          </div>
          <div class="p-4 rounded-xl border bg-white shadow-sm">
              <p class="text-sm text-gray-500">Average Price</p>
              <p class="text-2xl font-semibold mt-1">
                  $
                  {{
                      number_format(
                          (method_exists($products, 'avg') ? $products->avg('price') : collect($products)->avg('price')) ?? 0,
                      2)
                  }}
              </p>
          </div>
      </div>

      {{-- Toolbar --}}
      <div class="flex flex-col md:flex-row md:items-center gap-3 mb-4">
          <form method="GET" action="{{ url()->current() }}" class="flex-1">
              <div class="relative">
                  <input
                      type="text"
                      name="q"
                      value="{{ request('q') }}"
                      placeholder="Search products by name…"
                      class="w-full rounded-lg border-gray-300 pl-10 pr-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                  >
                  <span class="absolute left-3 top-2.5 text-gray-400">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M10 4a6 6 0 1 1 3.81 10.64l3.77 3.77a1 1 0 0 1-1.42 1.42l-3.77-3.77A6 6 0 0 1 10 4zm0 2a4 4 0 1 0 0 8 4 4 0 0 0 0-8z"/></svg>
                  </span>
              </div>
          </form>
          <div class="flex items-center gap-2">
              <button id="toggleViewBtn" type="button" class="px-3 py-2 rounded-lg border border-gray-300 hover:bg-gray-50">
                  Toggle Cards/Table
              </button>
          </div>
      </div>

      @php
          $list = $products instanceof \Illuminate\Pagination\AbstractPaginator ? $products->items() : $products;
          $collection = collect($list);
      @endphp

      {{-- Empty State --}}
      @if ($collection->isEmpty())
          <div class="text-center bg-white border rounded-xl py-16">
              <div class="text-5xl mb-4">📦</div>
              <h3 class="text-lg font-semibold mb-2">No products yet</h3>
              <p class="text-gray-500 mb-6">Get started by adding your first product.</p>
              <a href="{{ route('products.create') }}" class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                  Add Product
              </a>
          </div>
      @else
          {{-- Cards (mobile-first) --}}
          <div id="cardView" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:hidden">
              @foreach ($products as $product)
                  <div class="bg-white border rounded-xl p-4 shadow-sm">
                      <div class="flex items-start justify-between">
                          <h4 class="font-semibold text-lg">{{ $product->name }}</h4>
                          @php $low = ($product->stock ?? 0) <= 5; @endphp
                          <span class="text-xs px-2 py-1 rounded-full {{ $low ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                              {{ $low ? 'Low stock' : 'In stock' }}
                          </span>
                      </div>
                      <div class="mt-3 space-y-1 text-sm text-gray-600">
                          <div><span class="text-gray-500">Price:</span> ${{ number_format($product->price, 2) }}</div>
                          <div><span class="text-gray-500">Stock:</span> {{ $product->stock }}</div>
                      </div>
                  </div>
              @endforeach
          </div>

          {{-- Table (desktop) --}}
          <div id="tableView" class="hidden md:block">
              <div class="overflow-hidden rounded-xl border bg-white">
                  <div class="overflow-x-auto">
                      <table class="min-w-full text-left">
                          <thead class="bg-gray-50 sticky top-0">
                              <tr>
                                  <th class="p-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Name</th>
                                  <th class="p-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Price</th>
                                  <th class="p-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Stock</th>
                                  <th class="p-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                              </tr>
                          </thead>
                          <tbody class="divide-y divide-gray-100">
                              @foreach ($products as $product)
                                  @php $low = ($product->stock ?? 0) <= 5; @endphp
                                  <tr class="hover:bg-gray-50">
                                      <td class="p-3 font-medium text-gray-800">{{ $product->name }}</td>
                                      <td class="p-3">${{ number_format($product->price, 2) }}</td>
                                      <td class="p-3">{{ $product->stock }}</td>
                                      <td class="p-3">
                                          <span class="text-xs px-2 py-1 rounded-full {{ $low ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                              {{ $low ? 'Low stock' : 'In stock' }}
                                          </span>
                                      </td>
                                  </tr>
                              @endforeach
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
      @endif

      {{-- Pagination (if available) --}}
      @if ($products instanceof \Illuminate\Pagination\LengthAwarePaginator)
          <div class="mt-6">
              {{ $products->withQueryString()->links() }}
          </div>
      @endif
  </div>

  <script>
      (function () {
          const btn = document.getElementById('toggleViewBtn');
          const table = document.getElementById('tableView');
          const cards = document.getElementById('cardView');
          if (!btn || !table || !cards) return;

          btn.addEventListener('click', function () {
              const tableHidden = table.classList.contains('hidden');
              if (tableHidden) {
                  table.classList.remove('hidden');
                  cards.classList.add('md:hidden');
                  cards.classList.add('hidden');
              } else {
                  table.classList.add('hidden');
                  cards.classList.remove('hidden');
                  cards.classList.remove('md:hidden');
              }
          });
      })();
  </script>
@endsection
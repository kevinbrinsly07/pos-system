<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel POS System</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">Laravel POS System</h1>
        <nav class="mb-4">
            <a href="{{ route('products.index') }}" class="text-blue-500 hover:underline">Manage Products</a> |
            <a href="{{ route('sales.index') }}" class="text-blue-500 hover:underline">View Sales</a> |
            <a href="{{ route('sales.create') }}" class="text-blue-500 hover:underline">Record Sale</a>
        </nav>
        @yield('content')
    </div>
</body>
</html>
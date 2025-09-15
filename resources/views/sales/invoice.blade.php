<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Invoice #{{ $sale->id }}</title>
<style>
  @page { margin: 24mm 16mm; }
  body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; font-size: 12px; color: #111; }
  .grid { display: table; width: 100%; }
  .col  { display: table-cell; vertical-align: top; }
  .text-right { text-align:right; } .text-center { text-align:center; }
  .title { font-size:20px; font-weight:700; }
  .muted { color:#666; } .strong { font-weight:700; }
  table { width:100%; border-collapse:collapse; }
  th, td { padding:8px; border-bottom:1px solid #e5e5e5; }
  th { background:#f6f6f6; text-align:left; }
  .totals td { border:0; padding:6px 8px; }
</style>
</head>
<body>
  {{-- Header --}}
  <div class="grid" style="margin-bottom:16px;">
    <div class="col" style="width:60%;">
      <div class="title">{{ $biz['name'] }}</div>
      <div class="muted">
        {{ $biz['address'] }}<br>
        {{ $biz['phone'] }} · {{ $biz['email'] }}
      </div>
    </div>
    <div class="col text-right" style="width:40%;">
      <div class="strong">Invoice #{{ $sale->id }}</div>
      <div class="muted">Date: {{ $sale->created_at?->format('Y-m-d H:i') }}</div>
    </div>
  </div>

  {{-- Bill To (optional) --}}
  <div style="margin: 0 0 14px 0;">
    <div class="strong">Bill To</div>
    <div class="muted">Walk-in Customer</div>
  </div>

  {{-- Items --}}
  <table>
    <thead>
      <tr>
        <th>Item</th>
        <th class="text-right" style="width:15%;">Qty</th>
        <th class="text-right" style="width:20%;">Unit Price</th>
        <th class="text-right" style="width:20%;">Amount</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>{{ $product->name }}</td>
        <td class="text-right">{{ number_format($quantity) }}</td>
        <td class="text-right">{{ number_format($unit_price, 2) }}</td>
        <td class="text-right">{{ number_format($total_price, 2) }}</td>
      </tr>
    </tbody>
  </table>

  {{-- Totals --}}
  <table class="totals" style="margin-top:8px;">
    <tr>
      <td class="text-right strong" style="width:80%;">Total:</td>
      <td class="text-right strong" style="width:20%;">{{ number_format($total_price, 2) }}</td>
    </tr>
  </table>

  <p class="text-center" style="margin-top:16px;">
    Thank you for your purchase!
  </p>
</body>
</html>
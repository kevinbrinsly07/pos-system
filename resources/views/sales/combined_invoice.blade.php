<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 20px; }
        .invoice-box { max-width: 800px; margin: auto; padding: 20px; border: 1px solid #eee; }
        .invoice-box table { width: 100%; border-collapse: collapse; }
        .invoice-box table th, .invoice-box table td { padding: 8px; border: 1px solid #ddd; }
        .invoice-box table th { background-color: #f2f2f2; text-align: left; }
        .header { margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 24px; }
        .header p { margin: 5px 0; }
        .footer { margin-top: 20px; text-align: right; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <!-- Business Information -->
        <div class="header">
            <h1>{{ $biz['name'] }}</h1>
            <p>{{ $biz['address'] }}</p>
            <p>Phone: {{ $biz['phone'] }}</p>
            <p>Email: {{ $biz['email'] }}</p>
            <hr>
            <h2>Invoice</h2>
            <p>Invoice Number: {{ $invoice_number }}</p>
            <p>Date: {{ $invoice_date }}</p>
        </div>

        <!-- Sales Table -->
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Unit Price (LKR)</th>
                    <th>Total Price (LKR)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales as $sale)
                    <tr>
                        <td>{{ $sale->product->name }}</td>
                        <td>{{ $sale->quantity }}</td>
                        <td>{{ number_format($sale->product->price, 2) }}</td>
                        <td>{{ number_format($sale->total_price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: right; font-weight: bold;">Grand Total:</td>
                    <td>{{ number_format($grand_total, 2) }}</td>
                </tr>
            </tfoot>
        </table>

        <!-- Footer -->
        <div class="footer">
            <p>Thank you for your business!</p>
        </div>
    </div>
</body>
</html>
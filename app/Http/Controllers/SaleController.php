<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('product')->get();
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $products = Product::all();
        return view('sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        if ($product->stock < $request->quantity) {
            return redirect()->back()->with('error', 'Insufficient stock.');
        }

        $total_price = $product->price * $request->quantity;
        Sale::create([
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'total_price' => $total_price,
        ]);

        $product->stock -= $request->quantity;
        $product->save();

        return redirect()->route('sales.index')->with('success', 'Sale recorded successfully.');
    }

    public function invoicePdf(Sale $sale)
    {
        $sale->load('product');

        $data = [
            'sale'        => $sale,
            'product'     => $sale->product,
            'unit_price'  => (float)$sale->product->price,
            'quantity'    => (int)$sale->quantity,
            'total_price' => (float)$sale->total_price,
            // add your business info here or pass from config
            'biz' => [
                'name'    => config('app.name', 'My Shop'),
                'address' => '123 Main Street, Colombo',
                'phone'   => '011-1234567',
                'email'   => 'hello@myshop.lk',
            ],
        ];

        $pdf = Pdf::loadView('sales.invoice', $data)->setPaper('A4');
        return $pdf->stream("invoice-{$sale->id}.pdf");
    }

    public function invoiceDownload(Sale $sale)
    {
        $sale->load('product');

        $data = [
            'sale'        => $sale,
            'product'     => $sale->product,
            'unit_price'  => (float)$sale->product->price,
            'quantity'    => (int)$sale->quantity,
            'total_price' => (float)$sale->total_price,
            'biz' => [
                'name'    => config('app.name', 'My Shop'),
                'address' => '123 Main Street, Colombo',
                'phone'   => '011-1234567',
                'email'   => 'hello@myshop.lk',
            ],
        ];

        $pdf = Pdf::loadView('sales.invoice', $data)->setPaper('A4');
        return $pdf->download("invoice-{$sale->id}.pdf");
    }

    public function generateCombinedInvoice(Request $request)
    {
        // Fetch sales (you can modify the query based on your needs, e.g., date range)
        $sales = Sale::with('product')->get(); // Example: Get all sales

        // Prepare data for the invoice
        $data = [
            'sales' => $sales,
            'grand_total' => $sales->sum('total_price'),
            'biz' => [
                'name'    => config('app.name', 'My Shop'),
                'address' => '123 Main Street, Colombo',
                'phone'   => '011-1234567',
                'email'   => 'hello@myshop.lk',
            ],
            'invoice_date' => now()->format('Y-m-d'), // Add invoice date
            'invoice_number' => 'INV-' . now()->format('YmdHis'), // Unique invoice number
        ];

        // Load the view and generate the PDF
        $pdf = Pdf::loadView('sales.combined_invoice', $data)->setPaper('A4');
        
        // Return the PDF as a stream or download
        if ($request->has('download')) {
            return $pdf->download("combined-invoice-{$data['invoice_number']}.pdf");
        }
        
        return $pdf->stream("combined-invoice-{$data['invoice_number']}.pdf");
    }
}

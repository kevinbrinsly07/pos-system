<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/', function () {
        return view('welcome');
    })->name('welcome');
});

Route::resource('products', ProductController::class)->only(['index', 'create', 'store']);
Route::resource('sales', SaleController::class)->only(['index', 'create', 'store']);

Route::get('/sales/{sale}/invoice.pdf', [SaleController::class, 'invoicePdf'])
    ->name('sales.invoice.pdf');          // view/print in browser

Route::get('/sales/{sale}/invoice/download', [SaleController::class, 'invoiceDownload'])
    ->name('sales.invoice.download');     // force download

Route::get('/sales/combined-invoice', [SaleController::class, 'generateCombinedInvoice'])->name('sales.combined_invoice');

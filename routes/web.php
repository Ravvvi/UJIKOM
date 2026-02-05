<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index'])->name('products.index');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Transaksi & Pembayaran
Route::get('/checkout/{id}', [OrderController::class, 'checkout'])->name('orders.checkout');
Route::post('/store-order', [OrderController::class, 'storeOrder'])->name('orders.store');
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/payment/success/{id}', [OrderController::class, 'paymentSuccess'])->name('payment.success');
Route::post('/webhook/xendit', [OrderController::class, 'handleWebhook']);

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
    Route::post('/update/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::get('/delete/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/confirm-manual/{id}', [OrderController::class, 'confirmOrder'])->name('order.confirm');
});

Route::post('/create-invoice', [PaymentController::class, 'createInvoice'])->name('payment.create');
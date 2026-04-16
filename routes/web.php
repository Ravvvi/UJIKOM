<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

// --- PUBLIC ROUTES ---
Route::get('/', [ProductController::class, 'index'])->name('products.index');

// --- GUEST ROUTES ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Forget Password
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'updatePassword'])->name('password.update');
});

// --- AUTHENTICATED ROUTES ---
Route::middleware('auth')->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // --- TRANSAKSI & PEMBAYARAN USER ---
    Route::get('/checkout/{id}', [OrderController::class, 'checkout'])->name('orders.checkout');
    Route::post('/store-order', [OrderController::class, 'storeOrder'])->name('orders.store');
    
    Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('user.orders');
    
    Route::redirect('/orders', '/my-orders');

    // Payment & Xendit Flow
    Route::get('/payment/success/{id}', [OrderController::class, 'paymentSuccess'])->name('payment.success');
    Route::post('/create-invoice', [PaymentController::class, 'createInvoice'])->name('payment.create');

    // --- KHUSUS ROLE ADMIN ---
    Route::prefix('admin')->group(function () {
        
        Route::get('/', function () {
            return redirect()->route('admin.dashboard');
        });

        // Dashboard & Riwayat
        Route::get('/dashboard', [ProductController::class, 'adminIndex'])->name('admin.dashboard');
        Route::get('/transactions', [OrderController::class, 'index'])->name('admin.transactions');

        // CRUD Produk
        Route::get('/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/store', [ProductController::class, 'store'])->name('products.store');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
        
        // PERBAIKAN: Ganti POST menjadi PUT supaya sinkron dengan @method('PUT') di form edit
        Route::put('/update/{id}', [ProductController::class, 'update'])->name('products.update');
        
        Route::delete('/delete/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

        // Manajemen Transaksi Manual
        Route::get('/confirm-manual/{id}', [OrderController::class, 'confirmOrder'])->name('order.confirm');
        Route::put('/orders/{id}', [OrderController::class, 'update'])->name('orders.update');
        Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
    });
});

// --- WEBHOOK XENDIT ---
Route::post('/api/xendit/callback', [OrderController::class, 'handleWebhook']);
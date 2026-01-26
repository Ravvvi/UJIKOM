<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

Route::post('/create-invoice', [PaymentController::class, 'createInvoice'])->name('payment.create');
Route::get('/', [ProductController::class, 'index']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/checkout/{id}', [OrderController::class, 'checkout']);
Route::post('/store-order', [OrderController::class, 'storeOrder']);

Route::middleware('auth')->group(function () {
    Route::get('/create', [ProductController::class, 'create']);
    Route::post('/store', [ProductController::class, 'store']);
    Route::get('/edit/{id}', [ProductController::class, 'edit']);
    Route::post('/update/{id}', [ProductController::class, 'update']);
    Route::get('/delete/{id}', [ProductController::class, 'destroy']);
});

Route::get('/payment/success/{id}', [OrderController::class, 'paymentSuccess'])->name('payment.success');

Route::post('/confirm-order', [OrderController::class, 'confirmOrder']);
Route::post('/webhook/xendit', [OrderController::class, 'handleWebhook']);

Route::get('/confirm-manual/{id}', [OrderController::class, 'confirmOrder'])->name('order.confirm');
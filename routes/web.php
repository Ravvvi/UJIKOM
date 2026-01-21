<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', [ProductController::class, 'index']);
Route::get('/create', [ProductController::class, 'create']);
Route::post('/store', [ProductController::class, 'store']);
Route::get('/delete/{id}', [ProductController::class, 'destroy']);
Route::get('/edit/{id}', [ProductController::class, 'edit']);
Route::post('/update/{id}', [ProductController::class, 'update']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/delete/{id}', [ProductController::class, 'destroy']);
Route::get('/checkout/{id}', [OrderController::class, 'checkout']);
Route::post('/store-order', [OrderController::class, 'storeOrder']);
Route::get('/orders', [OrderController::class, 'index']);
<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function checkout($id)
    {
        $product = Product::findOrFail($id);
        return view('checkout', compact('product'));
    }

    //fungsi untuk menampilkan ringkasan pembayaran (sebelum di simpan ke DB)
    public function storeOrder(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity;
        $total_price = $product->price * $quantity;

        //melempar data ke halaman pembayaran
        return view('orders.payment', [
            'product' => $product,
            'customer_name' => $request->customer_name,
            'address' => $request->address,
            'quantity' => $quantity,
            'total_price' => $total_price
        ]);
    }

    //fungsi final menyimpan ke DB dan potong stok
    public function confirmOrder(Request $request)
    {
        //menyimpan data ke tabel orders
        Order::create([
            'product_id' => $request->product_id,
            'customer_name' => $request->customer_name,
            'address' => $request->address,
            'quantity' => $request->quantity,
            'total_price' => $request->total_price,
            'status' => 'Menunggu Pembayaran',
        ]);

        //stock otomatis berkurang
        $product = Product::findOrFail($request->product_id);
        $product->decrement('stock', $request->quantity);

        return redirect('/')->with('success', 'Pesanan berhasil dikonfirmasi! Silakan lakukan pembayaran.');
    }

    public function index()
    {
        $orders = Order::with('product')->latest()->get();
        return view('orders.index', compact('orders'));
    }
}
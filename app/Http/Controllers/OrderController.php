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

    public function storeOrder(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        
        $total_price = $product->price * $request->quantity;

        Order::create([
            'product_id' => $product->id,
            'customer_name' => $request->customer_name,
            'address' => $request->address,
            'quantity' => $request->quantity,
            'total_price' => $total_price,
            'status' => 'Menunggu Pembayaran',
        ]);

        $product->decrement('stock', $request->quantity);

        return redirect('/')->with('success', 'Pesanan berhasil dibuat!');
    }

    public function index()
    {
        $orders = Order::with('product')->latest()->get();
        return view('orders.index', compact('orders'));
    }
}
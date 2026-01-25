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

    public function index()
    {
        $orders = Order::with('product')->latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function storeOrder(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $total_price = $product->price * $request->quantity;

        $order = Order::create([
            'product_id' => $request->product_id,
            'customer_name' => $request->customer_name,
            'address' => $request->address,
            'quantity' => $request->quantity,
            'total_price' => $total_price,
            'status' => 'Pending',
        ]);

        return redirect()->action(
            [PaymentController::class, 'createInvoice'], 
            ['order_id' => $order->id]
        );
    }

    public function confirmOrder($order_id)
    {
        $order = Order::findOrFail($order_id);
        
        if ($order->status !== 'Sudah Terbayar') {
            $order->update(['status' => 'Sudah Terbayar']);

            $product = Product::findOrFail($order->product_id);
            $product->decrement('stock', $order->quantity);
        }

        return redirect('/orders')->with('success', 'Pembayaran Berhasil Dikonfirmasi!');
    }
}
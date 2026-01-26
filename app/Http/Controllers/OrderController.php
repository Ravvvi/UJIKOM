<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\PaymentController; 

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
        $request->validate([
            'product_id' => 'required',
            'customer_name' => 'required',
            'quantity' => 'required|numeric|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $total_price = $product->price * $request->quantity;

        $duplicate = Order::where('customer_name', $request->customer_name)
            ->where('product_id', $request->product_id)
            ->where('created_at', '>=', now()->subSeconds(5))
            ->first();

        if ($duplicate) {
            return redirect('/orders');
        }

        $order = Order::create([
            'product_id' => $request->product_id,
            'customer_name' => $request->customer_name,
            'address' => $request->address,
            'quantity' => $request->quantity,
            'total_price' => $total_price,
            'status' => 'Menunggu Pembayaran', 
        ]);

        $request->merge([
            'order_id' => $order->id,
            'total_price' => $total_price,
            'product_name' => $product->name
        ]);
        
        return (new PaymentController())->createInvoice($request);
    }

    public function paymentSuccess($id)
    {
        $order = Order::findOrFail($id); 
        
        if ($order->status == 'Menunggu Pembayaran') {
            $order->update(['status' => 'Sudah Terbayar']); //
            
            $product = Product::find($order->product_id);
            if($product) {
                $product->decrement('stock', $order->quantity);
            }
        }
        
        return redirect('/orders')->with('success', 'Pembayaran Berhasil! Status otomatis diperbarui.');
    }
}
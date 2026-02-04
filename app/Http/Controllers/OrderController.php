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

        if ($product->stock < $request->quantity) {
            return redirect()->back()->with('error', 'Maaf, stok tidak mencukupi!');
        }

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
            'sukses' => 'Sudah Terbayar', 
        ]);

        $product->decrement('stock', $request->quantity);

        $request->merge([
            'order_id' => $order->id,
            'total_price' => $total_price,
            'product_name' => $product->name
        ]);
        
        return (new PaymentController())->createInvoice($request);
    }

    public function handleWebhook(Request $request)
    {
        $externalId = $request->external_id;
        $status = $request->status;

        $order = Order::find($externalId);

        if ($order && ($status === 'PAID' || $status === 'SETTLED')) {
            if ($order->status == 'Menunggu Pembayaran') {
                $this->finalizeOrder($order);
            }
        }

        return response()->json(['status' => 'success']);
    }

    private function finalizeOrder($order)
    {
        $order->update(['status' => 'Sudah Terbayar']);
    }
}
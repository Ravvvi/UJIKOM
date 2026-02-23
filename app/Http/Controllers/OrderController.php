<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\PaymentController; 

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('product')->latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function checkout($id)
    {
        $product = Product::findOrFail($id);
        return view('checkout', compact('product')); 
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

        $order = new Order();
        $order->product_id = $request->product_id;
        $order->customer_name = $request->customer_name;
        $order->address = $request->address;
        $order->quantity = $request->quantity;
        $order->total_price = $total_price;
        $order->status = '1'; 
        $order->save();

        $product->decrement('stock', $request->quantity);

        $request->merge([
            'order_id' => $order->id,
            'total_price' => $total_price,
            'product_name' => $product->name
        ]);
            
        return (new PaymentController())->createInvoice($request);
    }

    // --- FUNGSI UPDATE BARU ---
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update($request->all());

        return response()->json([
            'message' => 'Data berhasil diperbarui!',
            'data' => $order
        ]);
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json([
            'message' => 'Data berhasil dihapus!'
        ]);
    }
}
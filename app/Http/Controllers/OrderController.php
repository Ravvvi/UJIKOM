<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\PaymentController; 
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /* Menampilkan semua riwayat transaksi untuk Admin */
    public function index()
    {
        $orders = Order::with('product')->latest()->get();
        // Sesuai folder resources/views/admin/transactions.blade.php
        return view('admin.transactions', compact('orders'));
    }

    /* Fungsi Riwayat untuk User (SUDAH DIPERBAIKI) */
    public function myOrders()
    {
        $orders = Order::with('product')
            ->where('user_id', Auth::id()) 
            ->latest()
            ->get();

        // GANTI INI: Dari 'user.orders' ke 'orders.index' 
        // Karena di folder views lo, filenya ada di orders/index.blade.php
        return view('orders.index', compact('orders'));
    }

    public function checkout($id)
    {
        $product = Product::findOrFail($id);
        // Sesuai folder resources/views/checkout.blade.php
        return view('checkout', compact('product')); 
    }

    public function paymentSuccess($id)
    {
        $order = Order::with('product')->findOrFail($id);
        // Sesuai folder resources/views/orders/payment.blade.php
        return view('orders.payment', compact('order'));
    }

    public function storeOrder(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'customer_name' => 'required',
            'address' => 'required',
            'quantity' => 'required|numeric|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return redirect()->back()->with('error', 'Maaf, stok tidak mencukupi!');
        }

        $total_price = $product->price * $request->quantity;

        $order = new Order();
        $order->user_id = Auth::id();
        $order->product_id = $request->product_id;
        $order->customer_name = $request->customer_name;
        $order->address = $request->address;
        $order->quantity = $request->quantity;
        $order->total_price = $total_price;
        $order->status = 'pending';
        $order->save();

        $product->decrement('stock', $request->quantity);

        $request->merge([
            'order_id' => $order->id,
            'total_price' => $total_price,
            'product_name' => $product->name
        ]);
            
        return (new PaymentController())->createInvoice($request);
    }

    /* Update data transaksi */
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update($request->all());

        return response()->json([
            'message' => 'Data berhasil diperbarui!',
            'data' => $order
        ]);
    }

    /* Hapus riwayat transaksi */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->back()->with('success', 'Riwayat transaksi berhasil dihapus!');
    }
}
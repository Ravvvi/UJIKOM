<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;
use Xendit\Invoice\CreateInvoiceRequest;
use App\Models\Order;

class PaymentController extends Controller
{
    public function __construct()
    {
        Configuration::setXenditKey(env('XENDIT_SECRET_KEY'));
    }

    public function createInvoice(Request $request)
    {
        $apiInstance = new InvoiceApi();

        $orderId = $request->order_id; 

        $create_invoice_request = new CreateInvoiceRequest([
            'external_id' => 'ORD-' . $orderId . '-' . time(),
            'amount' => (float) $request->total_price,
            'description' => 'Pembayaran ' . $request->product_name . ' (Order #' . $orderId . ')',
            'invoice_duration' => 86400,
            'success_redirect_url' => url('/my-orders'), 
            'failure_redirect_url' => url('/my-orders'),
            'currency' => 'IDR',
        ]);

        try {
            $result = $apiInstance->createInvoice($create_invoice_request);
            return redirect($result['invoice_url']);
        } catch (\Exception $e) {
            return "sorry there's something error: " . $e->getMessage();
        }
    }

    public function handleCallback(Request $request)
    {
        $callbackData = $request->all();
        $externalId = $callbackData['external_id'];
        $parts = explode('-', $externalId);
        $orderId = $parts[1]; 
        $order = Order::find($orderId);

        if ($order && $callbackData['status'] === 'PAID') {
            $order->status = 'Selesai';
            $order->save();
            
            return response()->json(['message' => 'Status berhasil diperbarui'], 200);
        }

        return response()->json(['message' => 'Data diterima, tapi tidak ada perubahan'], 200);
    }
}
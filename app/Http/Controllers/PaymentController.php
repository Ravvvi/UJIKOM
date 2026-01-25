<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;
use Xendit\Invoice\CreateInvoiceRequest;

class PaymentController extends Controller
{
    public function __construct()
    {
        Configuration::setXenditKey(env('XENDIT_SECRET_KEY'));
    }

    public function createInvoice(Request $request)
    {
        $apiInstance = new InvoiceApi();

        $create_invoice_request = new CreateInvoiceRequest([
            'external_id' => 'ORD-' . time(),
            'amount' => $request->total_price,
            'description' => 'Pembayaran ' . $request->product_name,
            'invoice_duration' => 86400,
            'success_redirect_url' => url('/'),
        ]);

        try {
            $result = $apiInstance->createInvoice($create_invoice_request);
            // membuka halaman pembayaran Xendit
            return redirect($result['invoice_url']);
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
}
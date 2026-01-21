<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - Sparepart PC Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h5 class="mb-0">Ringkasan Pembayaran</h5>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-info border-0">
                        <small class="d-block text-uppercase fw-bold mb-1">Total yang harus dibayar:</small>
                        <h3 class="mb-0 fw-bold">Rp {{ number_format($total_price, 0, ',', '.') }}</h3>
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-bold border-bottom pb-2">Detail Pesanan</h6>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Produk:</span>
                            <span class="fw-bold">{{ $product->name }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Jumlah:</span>
                            <span>{{ $quantity }} Unit</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Penerima:</span>
                            <span>{{ $customer_name }}</span>
                        </div>
                    </div>

                    <div class="bg-light p-3 rounded mb-4 border text-center">
                        <h6 class="fw-bold mb-3"><i class="bi bi-qr-code-scan"></i> Bayar Pakai QRIS</h6>
    
                        <div class="mb-3">
                            <img src="{{ asset('images/gopay.jpeg') }}" alt="QRIS Pembayaran" class="img-fluid rounded shadow-sm" style="max-width: 250px;">
                        </div>
    
                            <p class="mb-1 small text-muted">Scan QRIS di atas dengan aplikasi m-banking atau e-wallet (GoPay, OVO, Dana, dll) sebesar:</p>
                            <h4 class="fw-bold text-primary">Rp {{ number_format($total_price, 0, ',', '.') }}</h4>
                            <p class="mb-0 x-small text-danger">*Pastikan nominal sesuai agar pesanan cepat diproses</p>
                        </div>

                    <form action="/confirm-order" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="customer_name" value="{{ $customer_name }}">
                        <input type="hidden" name="address" value="{{ $address }}">
                        <input type="hidden" name="quantity" value="{{ $quantity }}">
                        <input type="hidden" name="total_price" value="{{ $total_price }}">

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg fw-bold">Saya Sudah Transfer</button>
                            <a href="/" class="btn btn-link text-muted">Batalkan Pesanan</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
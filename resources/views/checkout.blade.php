<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Sparepart PC Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white p-3">
                    <h5 class="mb-0">Konfirmasi Pesanan & Pembayaran</h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4 p-3 border rounded">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="rounded me-3" style="width: 70px; height: 70px; object-fit: cover;">
                        @endif
                        <div>
                            <h6 class="mb-1 fw-bold">{{ $product->name }}</h6>
                            <p class="text-success mb-0 fw-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            <small class="text-muted">Stok: {{ $product->stock }}</small>
                        </div>
                    </div>

                    <form action="{{ route('payment.create') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="product_name" value="{{ $product->name }}">
                        <input type="hidden" name="total_price" value="{{ $product->price }}"> <div class="mb-3">
                            <label class="form-label fw-bold">Nama Penerima</label>
                            <input type="text" name="customer_name" class="form-control" placeholder="Nama lengkap Anda" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Alamat Pengiriman</label>
                            <textarea name="address" class="form-control" rows="3" placeholder="Alamat lengkap tujuan" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Jumlah Beli</label>
                            <input type="number" name="quantity" class="form-control" value="1" min="1" max="{{ $product->stock }}" required>
                        </div>

                        <div class="alert alert-info">
                            <small>Setelah klik tombol di bawah, Anda akan diarahkan ke gerbang pembayaran aman <strong>Xendit</strong>.</small>
                        </div>

                        <hr>
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold">Bayar Sekarang via Xendit</button>
                            <a href="/" class="btn btn-light">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
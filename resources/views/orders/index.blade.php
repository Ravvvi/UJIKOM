<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - Sparepart PC Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .card { border-radius: 15px; overflow: hidden; }
        .table thead { background-color: #212529; color: white; }
        .badge { font-weight: 500; padding: 0.5em 0.8em; cursor: pointer; transition: 0.3s; }
        .badge-link:hover { opacity: 0.8; transform: scale(1.05); }
        .id-column { min-width: 80px; }
    </style>
</head>
<body class="bg-light">
<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">
            <i class="bi bi-clock-history me-2"></i> Riwayat Pesanan
        </h2>
        <a href="/" class="btn btn-outline-dark shadow-sm">
            <i class="bi bi-house-door me-1"></i> Kembali ke Katalog
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert" style="border-radius: 10px;">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4 id-column">ID</th>
                            <th>Nama Pembeli</th>
                            <th>Produk</th>
                            <th class="text-center">Jumlah</th>
                            <th>Total Harga</th>
                            <th>Status Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td class="ps-4 fw-bold text-secondary">
                                #{{ $order->getKey() ?? '?' }}
                            </td>
                            <td>{{ $order->customer_name }}</td>
                            <td>
                                <span class="d-block fw-semibold">{{ $order->product->name ?? 'Produk Tidak Ditemukan' }}</span>
                                <small class="text-muted small">ID Produk: {{ $order->product_id }}</small>
                            </td>
                            <td class="text-center">{{ $order->quantity }} pcs</td>
                            <td class="fw-bold text-primary">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </td>
                            <td>
                                @if($order->status == 'Sudah Terbayar')
                                    <span class="badge bg-success rounded-pill shadow-sm">
                                        <i class="bi bi-check-circle me-1"></i> Sudah Terbayar
                                    </span>
                                @else
                                    {{-- 
                                        ANTI-ERROR: Cek dulu apakah ID ada. 
                                        Kalau tidak ada, tampilkan tombol tapi jangan kasih link dulu biar gak error 500.
                                    --}}
                                    @if($order->getKey())
                                        <a href="{{ route('payment.success', $order->getKey()) }}" class="text-decoration-none badge-link">
                                            <span class="badge bg-warning text-dark rounded-pill shadow-sm">
                                                <i class="bi bi-hourglass-split me-1"></i> Menunggu Pembayaran
                                            </span>
                                        </a>
                                    @else
                                        <span class="badge bg-secondary text-white rounded-pill shadow-sm">
                                            ID Bermasalah
                                        </span>
                                    @endif
                                    
                                    <div style="font-size: 10px;" class="text-muted mt-1 ps-1 italic">
                                        <i class="bi bi-info-circle me-1"></i>Klik untuk simulasi bayar
                                    </div>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-cart-x fs-1 d-block mb-2"></i>
                                Belum ada riwayat pemesanan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
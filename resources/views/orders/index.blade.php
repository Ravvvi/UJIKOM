<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - PC Master Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .card { border-radius: 15px; overflow: hidden; }
        .table thead { background-color: #212529; color: white; }
        .badge { font-weight: 500; padding: 0.5em 0.8em; transition: 0.3s; }
        .id-column { min-width: 80px; }
        .table-hover tbody tr:hover { background-color: rgba(0,0,0,0.02); }
    </style>
</head>
<body class="bg-light">
<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">
            <i class="bi bi-clock-history me-2"></i> Riwayat Transaksi Sparepart
        </h2>
        <a href="/" class="btn btn-outline-dark shadow-sm px-4 rounded-pill">
            <i class="bi bi-house-door me-1"></i> Kembali ke Katalog
        </a>
    </div>

    <div class="card shadow border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4 id-column">No. Pesanan</th>
                            <th>Nama Pelanggan</th>
                            <th>Komponen PC</th>
                            <th class="text-center">Jumlah</th>
                            <th>Total Pembayaran</th>
                            <th class="text-center">Status Konfirmasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        @php 
                            $status = strtolower(trim($order->status)); 
                        @endphp
                        <tr>
                            <td class="ps-4 fw-bold text-secondary">#{{ $order->id }}</td>
                            <td>{{ $order->customer_name }}</td>
                            <td>
                                <span class="d-block fw-semibold">{{ $order->product->name ?? 'Produk' }}</span>
                                <small class="text-muted small">Kategori: {{ $order->product->category ?? 'Sparepart' }}</small>
                            </td>
                            <td class="text-center">{{ $order->quantity }} unit</td>
                            <td class="fw-bold text-primary">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td class="text-center">
                                {{-- CEK SEMUA VARIASI: termasuk 'pending' yang bikin lo pusing tadi --}}
                                @if($status == '1' || $status == 'paid' || $status == 'sudah terbayar' || $status == 'menunggu pembayaran' || $status == 'pending')
                                    <span class="badge bg-success rounded-pill shadow-sm text-white px-3">
                                        <i class="bi bi-check-circle-fill me-1"></i> Pembayaran Berhasil
                                    </span>
                                @else
                                    <span class="badge bg-danger rounded-pill shadow-sm text-white px-3">
                                        <i class="bi bi-x-circle-fill me-1"></i> Gagal ({{ $order->status }})
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">Belum ada transaksi.</td>
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
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .navbar { backdrop-filter: blur(10px); }
        .card { border-radius: 15px; }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="bi bi-cpu"></i> Sparepart PC Shop (Admin)
            </a>
            <div class="ms-auto">
                <a href="/" class="btn btn-outline-light btn-sm rounded-pill px-3">
                    <i class="bi bi-arrow-left"></i> Ke Toko
                </a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark"><i class="bi bi-receipt text-primary"></i> Kelola Semua Transaksi</h2>
        </div>

        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4 py-3">ID Pesanan</th>
                            <th>Nama Produk</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td class="ps-4 fw-bold text-primary">#{{ $order->id }}</td>
                            <td>{{ $order->product->name ?? 'Produk Dihapus' }}</td>
                            <td class="fw-bold text-success">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td>
                                @if($order->status == 'pending')
                                    <span class="badge bg-warning text-dark rounded-pill">Pending</span>
                                @else
                                    <span class="badge bg-success rounded-pill px-3">Selesai</span>
                                @endif
                            </td>
                            <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                            <td class="text-center">
                                <form action="{{ url('/orders/'.$order->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger border-0" onclick="return confirm('Hapus riwayat?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">Belum ada transaksi masuk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
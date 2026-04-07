<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - PC Master Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
        }
        .card-hover {
            transition: all 0.3s ease;
            border-radius: 15px;
            overflow: hidden;
        }
        .navbar {
            backdrop-filter: blur(10px);
        }
        .badge-category {
            font-size: 0.7rem;
            letter-spacing: 1px;
        }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-cpu"></i> Sparepart PC Shop
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="ms-auto d-flex align-items-center gap-2">
                    <a href="/" class="btn btn-outline-light btn-sm rounded-pill px-3">Lihat Toko</a>
                    <a href="{{ route('admin.transactions') }}" class="btn btn-outline-info btn-sm rounded-pill px-3">
                        <i class="bi bi-receipt"></i> Riwayat
                    </a>
                    <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm rounded-pill px-3">+ Tambah</a>
                    
                    <form action="{{ route('logout') }}" method="POST" class="d-inline ms-2">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm rounded-circle shadow-sm" title="Logout">
                            <i class="bi bi-box-arrow-right"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-dark">Manajemen Katalog Produk</h2>
            <p class="text-muted">Kelola stok dan harga sparepart PC di sini.</p>
            <div class="mx-auto" style="max-width: 500px;">
                <form action="{{ route('admin.dashboard') }}" method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control me-2 rounded-pill shadow-sm border-0 py-2 px-4" placeholder="Cari sparepart..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-dark rounded-pill px-4 shadow-sm">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            @forelse($products as $p)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 border-0 shadow-sm card-hover">
                    
                    <div class="position-relative">
                        @if($p->image)
                            <img src="{{ asset('storage/' . $p->image) }}" style="height: 220px; object-fit: cover; width: 100%;" alt="{{ $p->name }}">
                        @else
                            <img src="https://via.placeholder.com/400x300?text=No+Image" style="height: 220px; object-fit: cover; width: 100%;">
                        @endif
                        <span class="position-absolute top-0 start-0 m-3 badge bg-dark badge-category px-3 py-2 rounded-pill shadow-sm text-uppercase">
                            {{ $p->category }}
                        </span>
                    </div>

                    <div class="card-body d-flex flex-column p-4">
                        <h5 class="card-title fw-bold text-dark mb-1">{{ $p->name }}</h5>
                        <p class="card-text text-muted small flex-grow-1">{{ Str::limit($p->description, 80) }}</p>
                        
                        <div class="d-flex justify-content-between align-items-center mt-3 mb-4">
                            <div>
                                <small class="text-muted d-block">Harga</small>
                                <h5 class="text-success mb-0 fw-bold">Rp {{ number_format($p->price, 0, ',', '.') }}</h5>
                            </div>
                            <div class="text-end">
                                <small class="text-muted d-block">Stok</small>
                                <span class="badge {{ $p->stock > 0 ? 'bg-light text-dark border' : 'bg-danger' }}">
                                    {{ $p->stock }} Unit
                                </span>
                            </div>
                        </div>

                        <div class="row g-2">
                            <div class="col-6">
                                <a href="{{ route('products.edit', $p->id) }}" class="btn btn-warning w-100 py-2 shadow-sm fw-bold rounded-pill text-white">
                                    <i class="bi bi-pencil-square me-1"></i> Edit
                                </a>
                            </div>
                            <div class="col-6">
                                <form action="{{ route('products.destroy', $p->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger w-100 py-2 fw-bold shadow-sm rounded-pill" onclick="return confirm('Yakin ingin menghapus produk ini?')">
                                        <i class="bi bi-trash me-1"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="mb-3">
                    <i class="bi bi-box-seam text-muted" style="font-size: 4rem;"></i>
                </div>
                <h4 class="text-muted">Barang tidak ditemukan.</h4>
                <a href="{{ route('products.create') }}" class="btn btn-primary rounded-pill px-4 mt-2">Tambah Barang Pertama</a>
            </div>
            @endforelse
        </div>
    </div>

    <footer class="text-center py-4 mt-5 text-muted small">
        &copy; 2026 PC Master Hub - Admin Panel.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
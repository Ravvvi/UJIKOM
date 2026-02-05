<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sparepart PC Shop - PC Master Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; }
        .card-product { transition: 0.3s; border: none; border-radius: 15px; overflow: hidden; }
        .card-product:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .product-img { height: 200px; object-fit: cover; width: 100%; } 
        .search-bar { max-width: 500px; margin: 0 auto 30px auto; }
        .navbar-brand { font-size: 1.5rem; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm sticky-top">
    <div class="container">
        <div class="d-flex align-items-center">
            <a href="/orders" class="btn btn-outline-light btn-sm me-3">
                <i class="bi bi-clock-history"></i> Riwayat
            </a>
            <a class="navbar-brand fw-bold" href="/">Sparepart PC Shop</a>
        </div>
        
        <div class="ms-auto d-flex align-items-center">
            @auth
                <span class="text-light small me-3 d-none d-md-inline">
                    Admin: <strong>{{ Auth::user()->name }}</strong>
                </span>
                <a href="/create" class="btn btn-primary btn-sm me-2">+ Tambah Produk</a>
                <form action="/logout" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin logout?')">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            @else
                <a href="/login" class="btn btn-outline-light btn-sm rounded-pill px-3">
                    <i class="bi bi-person-lock me-1"></i> Admin Login
                </a>
            @endauth
        </div>
    </div>
</nav>

<div class="container">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <h2 class="text-center mb-4 fw-bold text-dark">Katalog Produk Terbaru</h2>

    <div class="search-bar">
        <form action="/" method="GET" class="d-flex">
            <input class="form-control me-2 shadow-sm border-0" type="search" name="search" placeholder="Cari sparepart atau kategori..." value="{{ request('search') }}">
            <button class="btn btn-dark shadow-sm px-4" type="submit">Cari</button>
            @if(request('search'))
                <a href="/" class="btn btn-link text-decoration-none text-muted">Reset</a>
            @endif
        </form>
    </div>
    
    <div class="row">
        @foreach($products as $p)
        <div class="col-md-4 mb-4">
            <div class="card card-product h-100 shadow-sm">
                @if($p->image)
                    <img src="{{ asset('storage/' . $p->image) }}" class="product-img" alt="{{ $p->name }}">
                @else
                    <img src="https://via.placeholder.com/400x300?text=No+Image" class="product-img" alt="No Image">
                @endif

                <div class="card-body d-flex flex-column">
                    <div class="mb-2">
                        <span class="badge bg-primary px-3 rounded-pill">{{ $p->category }}</span>
                    </div>
                    
                    <h5 class="card-title fw-bold text-dark mb-2">{{ $p->name }}</h5>
                    <p class="card-text text-muted small flex-grow-1">{{ Str::limit($p->description, 80) }}</p>
                    
                    <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
                        <h5 class="text-success mb-0 fw-bold">Rp {{ number_format($p->price, 0, ',', '.') }}</h5>
                        <span class="badge bg-light text-dark border">Stok: {{ $p->stock }}</span>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="/checkout/{{ $p->id }}" class="btn btn-dark shadow-sm">
                            <i class="bi bi-cart-plus me-1"></i> Beli Sekarang
                        </a>

                        @auth
                        <div class="btn-group gap-1 mt-1">
                            <a href="/edit/{{ $p->id }}" class="btn btn-warning btn-sm fw-bold rounded">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <form action="/delete/{{ $p->id }}" method="POST" class="d-inline flex-grow-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm fw-bold rounded w-100" onclick="return confirm('Yakin ingin menghapus {{ $p->name }}?')">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if($products->isEmpty())
        <div class="text-center mt-5 p-5 bg-white rounded shadow-sm border">
            <i class="bi bi-search fs-1 text-muted mb-3"></i>
            <h4 class="text-muted">Oops! Sparepart "{{ request('search') }}" tidak ditemukan.</h4>
            <a href="/" class="btn btn-primary mt-3">Lihat Semua Produk</a>
        </div>
    @endif
</div>

<footer class="text-center mt-5 mb-4 text-muted">
    <hr class="container mb-4">
    <p class="small mb-0">&copy; 2026 <strong>PC Master Hub</strong> - Sparepart PC Shop</p>
    <p class="x-small">Ujikom Project Implementation</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
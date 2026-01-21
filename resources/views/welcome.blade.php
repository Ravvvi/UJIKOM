<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sparepart PC Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .card-product { transition: 0.3s; border: none; border-radius: 15px; overflow: hidden; }
        .card-product:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        /* Style untuk gambar agar seragam ukurannya */
        .product-img { height: 200px; object-fit: cover; width: 100%; } 
        .btn-add { border-radius: 10px; padding: 10px 20px; font-weight: bold; }
        .search-bar { max-width: 500px; margin: 0 auto 30px auto; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/"> Sparepart PC Shop</a>
        <div class="d-flex align-items-center">
            @auth
                <a href="/create" class="btn btn-primary btn-sm me-2">+ Tambah Produk</a>
                <form action="/logout" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Logout</button>
                </form>
            @else
                <a href="/login" class="btn btn-outline-light btn-sm">Admin Login</a>
            @endauth
        </div>
    </div>
</nav>

<div class="container">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <h2 class="text-center mb-4 font-weight-bold">Katalog Produk Terbaru</h2>

    <div class="search-bar">
        <form action="/" method="GET" class="d-flex">
            <input class="form-control me-2 shadow-sm" type="search" name="search" placeholder="Cari sparepart atau kategori..." value="{{ request('search') }}">
            <button class="btn btn-dark shadow-sm" type="submit">Cari</button>
            @if(request('search'))
                <a href="/" class="btn btn-link text-decoration-none">Reset</a>
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
                        <span class="badge bg-primary">{{ $p->category }}</span>
                    </div>
                    
                    <h5 class="card-title fw-bold text-dark">{{ $p->name }}</h5>
                    <p class="card-text text-muted small flex-grow-1">{{ Str::limit($p->description, 100) }}</p>
                    
                    <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
                        <h5 class="text-success mb-0 fw-bold">Rp {{ number_format($p->price, 0, ',', '.') }}</h5>
                        <span class="badge bg-secondary text-white">Stok: {{ $p->stock }}</span>
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn btn-dark">Beli Sekarang</button>

                        @auth
                        <div class="btn-group gap-1">
                            <a href="/edit/{{ $p->id }}" class="btn btn-warning btn-sm fw-bold rounded">Edit</a>
                            <a href="/delete/{{ $p->id }}" 
                               class="btn btn-outline-danger btn-sm fw-bold rounded" 
                               onclick="return confirm('Yakin ingin menghapus {{ $p->name }}?')">Hapus</a>
                        </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if($products->isEmpty())
        <div class="text-center mt-5 p-5 bg-white rounded shadow-sm">
            <h4 class="text-muted">Oops! Sparepart "{{ request('search') }}" tidak ditemukan.</h4>
            <a href="/" class="btn btn-primary mt-3">Lihat Semua Produk</a>
        </div>
    @endif
</div>

<footer class="text-center mt-5 mb-4 text-muted">
    <small>&copy; 2026 Sparepart PC Shop - Ujikom Project</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
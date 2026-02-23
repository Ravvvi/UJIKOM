<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - PC Master Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/admin">
            <i class="bi bi-cpu"></i> Dashboard Admin
        </a>
        <div class="ms-auto d-flex align-items-center">
            <a href="/" class="btn btn-outline-light btn-sm me-2 rounded-pill px-3">Lihat Toko</a>
            <a href="/create" class="btn btn-primary btn-sm me-2 rounded-pill px-3">+ Tambah Produk</a>
            <form action="/logout" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm rounded-circle" onclick="return confirm('Yakin ingin logout?')">
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>
</nav>

<div class="container">
    <div class="mb-4 mx-auto" style="max-width: 500px;">
        <form action="/admin" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2 rounded-pill shadow-sm border-0 py-2" placeholder="Cari barang atau kategori..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-dark rounded-pill px-4 shadow-sm">Cari</button>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        @forelse($products as $p)
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm" 
                 style="border-radius: 15px; overflow: hidden; transition: 0.3s ease;"
                 onmouseover="this.style.transform='translateY(-8px)'; this.className='card h-100 border-0 shadow-lg';"
                 onmouseout="this.style.transform='translateY(0)'; this.className='card h-100 border-0 shadow-sm';">
                
                @if($p->image)
                    <img src="{{ asset('storage/' . $p->image) }}" style="height: 200px; object-fit: cover; width: 100%;" alt="{{ $p->name }}">
                @else
                    <img src="https://via.placeholder.com/400x300?text=No+Image" style="height: 200px; object-fit: cover; width: 100%;">
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

                    <div class="row g-2">
                        <div class="col-6">
                            <a href="/edit/{{ $p->id }}" class="btn btn-warning w-100 py-2 shadow-sm fw-bold rounded-pill">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                        </div>
                        <div class="col-6">
                            <form action="/delete/{{ $p->id }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger w-100 py-2 fw-bold shadow-sm rounded-pill" onclick="return confirm('Yakin ingin hapus?')">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <h4 class="text-muted">Barang tidak ditemukan.</h4>
            <a href="/admin" class="btn btn-link">Kembali ke Daftar Semua Barang</a>
        </div>
        @endforelse
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sparepart PC Shop - PC Master Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/">
            <i class="bi bi-cpu"></i> Sparepart PC Shop
        </a>
        
        <div class="ms-auto d-flex align-items-center">
            <a href="/orders" class="btn btn-outline-light btn-sm rounded-pill px-3 me-2">
                <i class="bi bi-clock-history"></i> Riwayat
            </a>

            @auth
                <span class="text-light small me-3 d-none d-md-inline">
                    {{ Auth::user()->role == 'admin' ? 'Admin:' : 'User:' }} <strong>{{ Auth::user()->name }}</strong>
                </span>

                @if(Auth::user()->role == 'admin')
                    <a href="/create" class="btn btn-primary btn-sm me-2">+ Tambah</a>
                @endif

                <form action="/logout" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin logout?')">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            @else
                <a href="/login" class="btn btn-outline-light btn-sm rounded-pill px-3">
                    <i class="bi bi-person-lock"></i> Login
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

    <div class="search-bar mb-4 mx-auto" style="max-width: 500px;">
        <form action="/" method="GET" class="d-flex">
            <input class="form-control me-2 shadow-sm border-0 py-2" type="search" name="search" placeholder="Cari sparepart atau kategori..." value="{{ request('search') }}">
            <button class="btn btn-dark shadow-sm px-4" type="submit">Cari</button>
            @if(request('search'))
                <a href="/" class="btn btn-link text-decoration-none text-muted">Reset</a>
            @endif
        </form>
    </div>
    
    <div class="row">
        @forelse($products as $p)
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm" 
                 style="border-radius: 15px; overflow: hidden; transition: 0.3s;"
                 onmouseover="this.style.transform='translateY(-8px)'; this.className='card h-100 border-0 shadow-lg';"
                 onmouseout="this.style.transform='translateY(0)'; this.className='card h-100 border-0 shadow-sm';">
                
                @if($p->image)
                    <img src="{{ asset('storage/' . $p->image) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{ $p->name }}">
                @else
                    <img src="https://via.placeholder.com/400x300?text=No+Image" class="card-img-top" style="height: 200px; object-fit: cover;" alt="No Image">
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
                        <a href="/checkout/{{ $p->id }}" class="btn {{ $p->stock > 0 ? 'btn-dark' : 'btn-secondary disabled' }} shadow-sm">
                            <i class="bi bi-cart-plus me-1"></i> {{ $p->stock > 0 ? 'Beli Sekarang' : 'Stok Habis' }}
                        </a>

                        @auth
                            @if(Auth::user()->role == 'admin')
                            <div class="btn-group gap-1 mt-1">
                                <a href="/edit/{{ $p->id }}" class="btn btn-warning btn-sm fw-bold rounded">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="/delete/{{ $p->id }}" method="POST" class="d-inline flex-grow-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm fw-bold rounded w-100" onclick="return confirm('Yakin ingin hapus?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <p class="text-muted">Produk yang lo cari nggak ketemu, bro...</p>
        </div>
        @endforelse
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
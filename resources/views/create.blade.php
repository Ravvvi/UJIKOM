<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Sparepart - Sparepart PC Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .card-form { border-radius: 15px; border: none; }
        .form-header { background-color: #212529; color: white; border-radius: 15px 15px 0 0; padding: 15px; }
    </style>
</head>
<body>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-form shadow">
                <div class="form-header text-center">
                    <h4 class="mb-0">Tambah Produk Sparepart Baru</h4>
                </div>
                <div class="card-body p-4">
                    
                    {{-- Alert untuk Error Validasi --}}
                    @if ($errors->any())
                        <div class="alert alert-danger shadow-sm border-0">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Alert untuk Session Error --}}
                    @if(session('error'))
                        <div class="alert alert-danger shadow-sm border-0">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="fw-bold">Nama Barang</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Contoh: NVIDIA RTX 4060" required>
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold">Kategori</label>
                            <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                                <option value="">-- Pilih Kategori Sparepart --</option>
                                <option value="GPU" {{ old('category') == 'GPU' ? 'selected' : '' }}>GPU (Graphics Card)</option>
                                <option value="CPU" {{ old('category') == 'CPU' ? 'selected' : '' }}>CPU (Processor)</option>
                                <option value="RAM" {{ old('category') == 'RAM' ? 'selected' : '' }}>RAM (Memory)</option>
                                <option value="Storage" {{ old('category') == 'Storage' ? 'selected' : '' }}>Storage (SSD/HDD)</option>
                                <option value="Motherboard" {{ old('category') == 'Motherboard' ? 'selected' : '' }}>Motherboard</option>
                                <option value="PSU" {{ old('category') == 'PSU' ? 'selected' : '' }}>PSU (Power Supply)</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Harga (Rp)</label>
                                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" placeholder="0" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Stok</label>
                                <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock') }}" placeholder="0" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="fw-bold">Unggah Foto Produk</label>
                            {{-- Perubahan: accept="image/*" memastikan browser memfilter file gambar --}}
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/png, image/jpeg, image/jpg" required>
                            <small class="text-muted d-block mt-1">Format: JPG, PNG, JPEG (Maks. 2MB)</small>
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold">Spesifikasi Singkat</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4" placeholder="Jelaskan detail barang..." required>{{ old('description') }}</textarea>
                        </div>

                        <hr>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary fw-bold py-2 shadow-sm">Simpan ke Database</button>
                            <a href="/" class="btn btn-outline-secondary py-2">Batal & Kembali</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - Sparepart PC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<div class="container mt-5 pb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-header bg-dark text-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i>Edit Produk: {{ $product->name }}</h5>
                </div>
                <div class="card-body p-4">
                    
                    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <div class="mb-3">
                            <label class="form-label fw-bold">Nama Barang</label>
                            <input type="text" name="name" class="form-control py-2" value="{{ old('name', $product->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Kategori</label>
                            <select name="category" class="form-select py-2" required>
                                <option value="">-- Pilih Kategori Sparepart --</option>
                                @php $categories = ['GPU', 'CPU', 'RAM', 'SSD', 'HDD', 'Motherboard', 'PSU', 'CASE']; @endphp
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ $product->category == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Harga (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="price" class="form-control py-2" value="{{ old('price', $product->price) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Stok</label>
                                <input type="number" name="stock" class="form-control py-2" value="{{ old('stock', $product->stock) }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="3" required>{{ old('description', $product->description) }}</textarea>
                        </div>

                        <div class="mb-4 p-3 border rounded bg-light">
                            <label class="form-label fw-bold d-block text-primary">Foto Produk</label>
                            
                            @if($product->image)
                                <div class="mb-2">
                                    <small class="text-muted d-block mb-1">Foto saat ini:</small>
                                    <img src="{{ asset('storage/' . $product->image) }}" class="img-thumbnail shadow-sm" style="height: 120px; border-radius: 10px;">
                                </div>
                            @endif

                            <input type="file" name="image" class="form-control">
                            <small class="text-muted italic small">Format: JPG/PNG, Maks 2MB. Kosongkan jika tetap pakai foto lama.</small>
                        </div>

                        <div class="d-flex justify-content-between pt-3">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary px-4">Batal</a>
                            <button type="submit" class="btn btn-warning fw-bold px-4">
                                <i class="bi bi-save me-1"></i> Update Data
                            </button>
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
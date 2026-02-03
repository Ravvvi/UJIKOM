<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - Sparepart PC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Edit Produk: {{ $product->name }}</h5>
                </div>
                <div class="card-body p-4">
                    <form action="/update/{{ $product->id }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Barang</label>
                            <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Kategori</label>
                            <select name="category" class="form-select" required>
                                <option value="VGA" {{ $product->category == 'VGA' ? 'selected' : '' }}>VGA</option>
                                <option value="Processor" {{ $product->category == 'Processor' ? 'selected' : '' }}>Processor</option>
                                <option value="RAM" {{ $product->category == 'RAM' ? 'selected' : '' }}>RAM</option>
                                <option value="Motherboard" {{ $product->category == 'Motherboard' ? 'selected' : '' }}>Motherboard</option>
                                <option value="PSU" {{ $product->category == 'PSU' ? 'selected' : '' }}>PSU</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Harga (Rp)</label>
                                <input type="number" name="price" class="form-control" value="{{ $product->price }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Stok</label>
                                <input type="number" name="stock" class="form-control" value="{{ $product->stock }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="3" required>{{ $product->description }}</textarea>
                        </div>

                        <div class="mb-4 p-3 border rounded bg-light">
                            <label class="form-label fw-bold d-block text-primary">Foto Produk</label>
                            
                            @if($product->image)
                                <div class="mb-2">
                                    <small class="text-muted d-block mb-1">Foto saat ini:</small>
                                    <img src="{{ asset('storage/' . $product->image) }}" class="img-thumbnail" style="height: 120px;">
                                </div>
                            @endif

                            <input type="file" name="image" class="form-control">
                            <small class="text-muted">Kosongkan jika tidak ingin mengganti foto. (Format: JPG/PNG, Maks 2MB)</small>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="/" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-warning fw-bold">Update Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
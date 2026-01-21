<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Sparepart Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f0f2f5; }
        .card { border-radius: 15px; }
        .card-header { border-radius: 15px 15px 0 0 !important; }
        .btn { border-radius: 10px; }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow border-0">
                    <div class="card-header bg-dark text-white text-center py-3">
                        <h4 class="mb-0">🛠️ Tambah Sparepart Baru</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="/store" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Barang</label>
                                <input type="text" name="name" class="form-control" placeholder="Contoh: NVIDIA RTX 4060" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Kategori</label>
                                <select name="category" class="form-select" required>
                                    <option value="" disabled selected>-- Pilih Kategori Sparepart --</option>
                                    <option value="Processor">Processor</option>
                                    <option value="VGA">VGA</option>
                                    <option value="RAM">RAM</option>
                                    <option value="PSU">Power Supply/PSU</option>
                                    <option value="Motherboard">Motherboard</option>
                                    <option value="Case">Case</option>
                                    <option value="Fan">Fan</option>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label fw-bold">Harga (Rp)</label>
                                    <input type="number" name="price" class="form-control" placeholder="0" required>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label fw-bold">Stok</label>
                                    <input type="number" name="stock" class="form-control" placeholder="0" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Spesifikasi Singkat</label>
                                <textarea name="description" class="form-control" rows="3" placeholder="Jelaskan detail barang..." required></textarea>
                            </div>

                            <hr>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary fw-bold">Simpan ke Database</button>
                                <a href="/" class="btn btn-outline-secondary">Batal & Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
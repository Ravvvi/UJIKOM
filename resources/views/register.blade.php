<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Sparepart PC Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { 
            background: linear-gradient(135deg, #1e1e1e 0%, #343a40 100%);
            height: 100vh;
            display: flex;
            align-items: center;
        }
        .register-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.4);
            overflow: hidden;
            background: #ffffff;
        }
        .register-header {
            background: #212529;
            color: white;
            padding: 30px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card register-card">
                <div class="register-header">
                    <h3 class="fw-bold mb-0">Gabung Sekarang</h3>
                    <p class="small text-secondary mb-0">Mulai rakit PC impianmu di sini</p>
                </div>
                <div class="card-body p-4">
                    <form action="/register" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-person"></i></span>
                                <input type="text" name="name" class="form-control bg-light border-start-0" placeholder="Contoh: Andi Wijaya" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" class="form-control bg-light border-start-0" placeholder="nama@email.com" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-dark">Password Baru</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password" class="form-control bg-light border-start-0" placeholder="Minimal 5 Karakter" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-dark w-100 fw-bold py-2 mb-3 shadow-sm">
                            DAFTAR AKUN
                        </button>

                        <div class="text-center">
                            <small class="text-muted">Sudah punya akun? <a href="/login" class="text-dark fw-bold text-decoration-none">Login di sini</a></small>
                        </div>
                    </form>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="/" class="text-light-50 text-decoration-none small text-white-50">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Katalog Produk
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
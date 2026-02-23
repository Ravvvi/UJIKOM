<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sparepart PC Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { 
            background: linear-gradient(135deg, #1e1e1e 0%, #343a40 100%);
            height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.4);
            overflow: hidden;
            background: #ffffff;
        }
        .login-header {
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
            <div class="card login-card">
                <div class="login-header">
                    <h3 class="fw-bold mb-0">Selamat Datang</h3>
                    <p class="small text-secondary mb-0">Masuk untuk mulai belanja atau kelola stok</p>
                </div>
                <div class="card-body p-4">
                    
                    @if(session('error'))
                        <div class="alert alert-danger py-2 small">{{ session('error') }}</div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success py-2 small">
                            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
                        </div>
                    @endif

                    <form action="/login" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" class="form-control bg-light border-start-0" placeholder="nama@email.com" required>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="form-label small fw-bold text-dark">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password" class="form-control bg-light border-start-0" placeholder="••••••••" required>
                            </div>
                        </div>

                        <div class="text-end mb-4">
                            <a href="{{ route('password.request') }}" class="text-decoration-none small text-muted">
                                Lupa Password?
                            </a>
                        </div>

                        <button type="submit" class="btn btn-dark w-100 fw-bold py-2 mb-3 shadow-sm">
                            MASUK SEKARANG
                        </button>

                        <div class="text-center">
                            <small class="text-muted">Belum punya akun? <a href="/register" class="text-dark fw-bold text-decoration-none">Daftar di sini</a></small>
                        </div>
                    </form>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="/" class="text-decoration-none small text-white-50">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Katalog Produk
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
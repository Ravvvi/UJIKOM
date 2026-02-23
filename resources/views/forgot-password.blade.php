<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - PC Master Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f7f6; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card { border-radius: 15px; border: none; width: 400px; }
    </style>
</head>
<body>
    <div class="card shadow">
        <div class="card-body p-4">
            <h4 class="text-center fw-bold mb-3">Lupa Password?</h4>
            <p class="text-muted text-center small mb-4">Masukan email lo yang terdaftar buat cari akun.</p>

            @if(session('error'))
                <div class="alert alert-danger py-2 small">{{ session('error') }}</div>
            @endif

            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label small">Alamat Email</label>
                    <input type="email" name="email" class="form-control" placeholder="nama@gmail.com" required>
                </div>
                <button type="submit" class="btn btn-dark w-100 py-2">Cari Akun</button>
                <div class="text-center mt-3">
                    <a href="/login" class="text-decoration-none small">Kembali ke Login</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
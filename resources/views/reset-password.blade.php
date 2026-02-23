<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Ulang Password - PC Master Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background: #343a40; height: 100vh; display: flex; align-items: center; justify-content: center; font-family: sans-serif; }
        .card { border-radius: 20px; border: none; width: 400px; overflow: hidden; }
        .card-header { background: #212529; color: white; text-align: center; padding: 30px 20px; border: none; }
        .btn-dark { background: #212529; border: none; border-radius: 8px; font-weight: bold; transition: 0.3s; }
        .btn-dark:hover { background: #000; transform: translateY(-2px); }
        .form-control { border-radius: 8px; padding: 10px 15px; background: #f8f9fa; }
    </style>
</head>
<body>
    <div class="card shadow-lg">
        <div class="card-header">
            <h3 class="fw-bold mb-1">Password Baru</h3>
            <p class="small mb-0 opacity-75">Bikin password baru yang kuat, bro!</p>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                
                <div class="mb-3">
                    <label class="form-label small fw-bold text-dark">Email Anda</label>
                    <input type="email" name="email" class="form-control" value="{{ session('reset_email') }}" readonly required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold text-dark">Password Baru</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-lock text-muted"></i></span>
                        <input type="password" name="password" class="form-control border-start-0" placeholder="Minimal 5 karakter" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-bold text-dark">Konfirmasi Password Baru</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-shield-lock text-muted"></i></span>
                        <input type="password" name="password_confirmation" class="form-control border-start-0" placeholder="Ulangi password" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-dark w-100 py-2 shadow-sm">
                    UPDATE PASSWORD SEKARANG
                </button>
            </form>
        </div>
    </div>
</body>
</html>
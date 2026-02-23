<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Ulang Password - PC Master Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f7f6; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card { border-radius: 15px; border: none; width: 400px; }
    </style>
</head>
<body>
    <div class="card shadow">
        <div class="card-body p-4">
            <h4 class="text-center fw-bold mb-3">Password Baru</h4>
            <p class="text-muted text-center small mb-4">Bikin password baru yang gampang diinget tapi susah ditebak.</p>

            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                
                <div class="mb-3">
                    <label class="form-label small">Email Anda</label>
                    <input type="email" name="email" class="form-control" value="{{ session('reset_email') }}" readonly required>
                </div>

                <div class="mb-3">
                    <label class="form-label small">Password Baru</label>
                    <input type="password" name="password" class="form-control" placeholder="Minimal 5 karakter" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2">Update Password</button>
            </form>
        </div>
    </div>
</body>
</html>
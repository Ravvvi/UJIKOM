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
        .input-group-text { background-color: #f8f9fa; }
        #admin-code-section { transition: all 0.3s ease; }
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
                    @if(session('error'))
                        <div class="alert alert-danger py-2 small border-0 shadow-sm mb-3">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                        </div>
                    @endif

                    <form action="/register" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text border-end-0"><i class="bi bi-person"></i></span>
                                <input type="text" name="name" class="form-control bg-light border-start-0" placeholder="Contoh: Andi Wijaya" value="{{ old('name') }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text border-end-0"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" class="form-control bg-light border-start-0" placeholder="nama@gmail.com" value="{{ old('email') }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark">Password Baru</label>
                            <div class="input-group">
                                <span class="input-group-text border-end-0"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password" class="form-control bg-light border-start-0" placeholder="Minimal 5 Karakter" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark">Daftar Sebagai</label>
                            <div class="input-group">
                                <span class="input-group-text border-end-0"><i class="bi bi-shield-lock"></i></span>
                                <select name="role" id="role-select" class="form-select bg-light border-start-0" onchange="toggleAdminCode()">
                                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Pembeli (User)</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Pengelola (Admin)</option>
                                </select>
                            </div>
                        </div>

                        <div id="admin-code-section" class="mb-4" style="display: none;">
                            <label class="form-label small fw-bold text-danger">Kode Rahasia Admin</label>
                            <div class="input-group border border-danger rounded">
                                <span class="input-group-text border-end-0 text-danger bg-white"><i class="bi bi-key-fill"></i></span>
                                <input type="password" name="admin_code" id="admin-input" class="form-control bg-white border-start-0" placeholder="Masukkan Kode rahasia admin">
                            </div>
                            <small class="text-muted" style="font-size: 10px">*Wajib diisi jika mendaftar sebagai Pengelola</small>
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
        </div>
    </div>
</div>

<script>
    function toggleAdminCode() {
        const role = document.getElementById('role-select').value;
        const codeSection = document.getElementById('admin-code-section');
        const adminInput = document.getElementById('admin-input');

        if (role === 'admin') {
            codeSection.style.display = 'block';
            adminInput.setAttribute('required', 'required');
            adminInput.focus();
        } else {
            codeSection.style.display = 'none';
            adminInput.removeAttribute('required');
            adminInput.value = '';
        }
    }

    window.onload = toggleAdminCode;
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
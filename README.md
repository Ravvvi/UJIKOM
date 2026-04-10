# Sparepart PC Ujikom

Aplikasi e-commerce sederhana untuk penjualan sparepart PC. Dibangun dengan Laravel, aplikasi ini memungkinkan:

- Pencarian dan tampilan katalog produk untuk pengguna.
- CRUD produk oleh admin: tambah, edit, hapus.
- Pemesanan produk oleh user terautentikasi.
- Integrasi pembayaran Xendit untuk membuat invoice.

---

## Fitur Utama Produk

- `ProductController@index`: menampilkan katalog produk di halaman depan.
- `ProductController@adminIndex`: dashboard admin untuk melihat semua produk.
- `ProductController@create`, `store`, `edit`, `update`, `destroy`: alur CRUD produk.
- Gambar produk disimpan di storage publik (`storage/app/public/products`).
- `Product` model mengizinkan atribut:
  - `name`
  - `category`
  - `price`
  - `stock`
  - `description`
  - `image`

---

## Fitur Order dan Pembayaran

- `OrderController@checkout`: menampilkan halaman checkout untuk produk.
- `OrderController@storeOrder`: validasi dan simpan pesanan, kurangi stok produk, lalu arahkan ke Xendit invoice.
- `OrderController@myOrders`: menampilkan riwayat order pengguna yang sedang login.
- `PaymentController@createInvoice`: membuat invoice Xendit dengan data pesanan.
- Xendit callback diproses pada endpoint `/api/xendit/callback`.

---

## Struktur Rute Penting

- `/` - katalog produk depan.
- `/login`, `/register` - autentikasi pengguna.
- `/checkout/{id}` - checkout produk.
- `/store-order` - simpan pesanan.
- `/my-orders` - riwayat order user.
- `/admin/dashboard` - dashboard produk admin.
- `/admin/create`, `/admin/edit/{id}`, `/admin/delete/{id}` - manajemen produk admin.
- `/create-invoice` - buat invoice Xendit.
- `/api/xendit/callback` - callback Xendit.

---

## Konfigurasi Penting

APP_NAME="Sparepart PC Ujikom"
APP_ENV=local
APP_KEY=base64:cIzDom2A8IdlWgssSnQMKveft3l/QLLDxElYgaKXa+o=
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_LEVEL=debug

# --- SETTING DATABASE LOKAL ---
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ujikom
DB_USERNAME=root
DB_PASSWORD=
# --------------------------------------

SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=public
QUEUE_CONNECTION=sync

CACHE_STORE=file

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

FILESYSTEM_DISK=public

VITE_APP_NAME="${APP_NAME}"

# --- SETTING XENDIT ---
XENDIT_SECRET_KEY=xnd_development_Ecf7F8q4VGSXB1gdHdWD0Pwpponxe5mSJjRLPuFrUHV2YrUAzJhUtRjpoC5nWbD

Semua data sensitif disimpan di file `.env`, termasuk API key Xendit. Jangan letakkan API key langsung di README.

Contoh pengaturan Xendit di `.env`:

```env
XENDIT_SECRET_KEY=your_xendit_secret_key_here
```

Aplikasi sudah menggunakan key ini di `PaymentController`:

```php
Configuration::setXenditKey(env('XENDIT_SECRET_KEY'));
```

---

## Instalasi

1. Salin `.env.example` ke `.env` (atau gunakan `.env` yang sudah ada).
2. Isi pengaturan database:
   - `DB_CONNECTION`
   - `DB_HOST`
   - `DB_PORT`
   - `DB_DATABASE`
   - `DB_USERNAME`
   - `DB_PASSWORD`
3. Tambahkan key Xendit di `.env`:
   - `XENDIT_SECRET_KEY`
4. Jalankan:

```bash
composer install
php artisan key:generate
php artisan migrate
php artisan storage:link
```

5. Jalankan server lokal:

```bash
php artisan serve
```

---

## Catatan Keamanan

- Jangan commit `.env` ke repositori.
- API key harus disimpan di `.env` dan tidak dituliskan secara publik di README.
- Backup database dan file storage sesuai kebutuhan.

---

## Analisis Singkat Produk

Aplikasi ini mengelola produk dengan: `name`, `category`, `price`, `stock`, `description`, dan `image`.

- CRUD produk hanya bisa diakses oleh admin.
- Produk ditampilkan pada halaman depan untuk pembeli.
- Order memvalidasi stok sebelum menyimpan pesanan dan mengurangi jumlah stok.
- Pembayaran menggunakan Xendit invoice yang diarahkan ke URL invoice.

---

## Pengembangan

- Jika ingin menambah API publik, buat route dan controller baru untuk endpoint JSON.
- Untuk menambahkan notifikasi pembayaran, perlu integrasi webhook lebih lanjut dan update status order.
- Pastikan `APP_DEBUG=false` di produksi.

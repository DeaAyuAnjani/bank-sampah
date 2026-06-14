# 🗑️ Website Bank Sampah

Sistem informasi Bank Sampah berbasis web yang menghubungkan masyarakat sebagai penjual sampah dengan pengelola Bank Sampah.

## 🚀 Fitur Utama

### Admin
- Dashboard dengan grafik statistik
- Manajemen jenis sampah & harga per kg
- Kelola permintaan pickup & verifikasi antar sendiri
- Manajemen data nasabah
- Manajemen transaksi
- Export laporan PDF
- Pengaturan sistem (lokasi, WhatsApp, tarif pickup)

### Nasabah
- Lihat harga sampah terbaru
- Ajukan pickup sampah
- Antar sendiri + upload foto timbangan
- Riwayat transaksi + QR Code bukti
- Wallet saldo & poin reward
- Ajukan penarikan saldo

## 🛠️ Teknologi
- **Backend**: Laravel 12, PHP 8.3
- **Frontend**: Blade Template, Tailwind CSS
- **Database**: MySQL
- **Library**: DomPDF, SimpleQrCode, Chart.js
- **Auth**: Laravel Breeze

## ⚙️ Instalasi

### Prasyarat
- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL

### Langkah Instalasi

1. Clone repository
```bash
git clone https://github.com/DeaAyuAnjani/bank-sampah.git
cd bank-sampah
```

2. Install dependencies
```bash
composer install
npm install
```

3. Copy file environment
```bash
cp .env.example .env
php artisan key:generate
```

4. Setup database di `.env`
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bank_sampah
DB_USERNAME=root
DB_PASSWORD=
```

5. Jalankan migration & seeder
```bash
php artisan migrate
php artisan db:seed
php artisan storage:link
```

6. Build assets
```bash
npm run build
```

7. Jalankan server
```bash
php artisan serve
```

8. Akses di browser: `http://127.0.0.1:8000`

## 👤 Akun Default

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@banksampah.com | password123 |

## 📁 Struktur Fitur
├── Admin

│   ├── Dashboard (grafik & statistik)

│   ├── Jenis Sampah (CRUD + foto)

│   ├── Harga Sampah (CRUD + riwayat)

│   ├── Pickup (kelola & update status)

│   ├── Antar Sendiri (verifikasi)

│   ├── Nasabah (CRUD)

│   ├── Transaksi (detail & update)

│   ├── Laporan (export PDF)

│   └── Settings

└── Nasabah

├── Dashboard

├── Harga Sampah

├── Pickup (ajukan)

├── Antar Sendiri (ajukan + foto)

├── Riwayat Transaksi (+ QR Code)

└── Wallet (saldo, poin, penarikan)
## 📄 Lisensi

MIT License
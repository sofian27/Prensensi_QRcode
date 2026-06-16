# Sistem Informasi Kehadiran Guru Berbasis QR Code

Framework: Laravel 12

---

# Generate Project

```bash
composer create-project laravel/laravel presensi-guru-qrcode
```

Masuk ke project:

```bash
cd presensi-guru-qrcode
```

---

# Generate Model + Migration + Controller

## User

```bash
php artisan make:model User -m
```

## Guru

```bash
php artisan make:model Guru -mcr
```

## Presensi

```bash
php artisan make:model Presensi -mcr
```

## Pengajuan

```bash
php artisan make:model Pengajuan -mcr
```

## Notifikasi

```bash
php artisan make:model Notifikasi -mcr
```

---

# Generate Controller

## Admin

```bash
php artisan make:controller Admin/DashboardController
php artisan make:controller Admin/GuruController --resource
php artisan make:controller Admin/PresensiController
php artisan make:controller Admin/LaporanController
php artisan make:controller Admin/QRCodeController
```

## Guru

```bash
php artisan make:controller Guru/DashboardController
php artisan make:controller Guru/PresensiController
php artisan make:controller Guru/PengajuanController
php artisan make:controller Guru/RiwayatController
```

## Kepala Sekolah

```bash
php artisan make:controller KepalaSekolah/DashboardController
php artisan make:controller KepalaSekolah/MonitoringController
php artisan make:controller KepalaSekolah/PersetujuanController
php artisan make:controller KepalaSekolah/LaporanController
```

---

# Generate Middleware

```bash
php artisan make:middleware AdminMiddleware
php artisan make:middleware GuruMiddleware
php artisan make:middleware KepalaSekolahMiddleware
```

---

# Generate Seeder

```bash
php artisan make:seeder AdminSeeder
php artisan make:seeder GuruSeeder
```

---

# Generate Factory

```bash
php artisan make:factory GuruFactory
php artisan make:factory PresensiFactory
```

---

# Generate Request Validation

```bash
php artisan make:request StoreGuruRequest
php artisan make:request UpdateGuruRequest

php artisan make:request StorePengajuanRequest
```

---

# Generate Service Folder

Buat manual:

```text
app/
└── Services/
    ├── QRCodeService.php
    ├── PresensiService.php
    ├── LaporanService.php
    └── NotificationService.php
```

---

# Struktur Folder Final

```text
presensi-guru-qrcode/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │
│   │   ├── Admin/
│   │   │   ├── DashboardController.php
│   │   │   ├── GuruController.php
│   │   │   ├── PresensiController.php
│   │   │   ├── QRCodeController.php
│   │   │   └── LaporanController.php
│   │   │
│   │   ├── Guru/
│   │   │   ├── DashboardController.php
│   │   │   ├── PresensiController.php
│   │   │   ├── PengajuanController.php
│   │   │   └── RiwayatController.php
│   │   │
│   │   └── KepalaSekolah/
│   │       ├── DashboardController.php
│   │       ├── MonitoringController.php
│   │       ├── PersetujuanController.php
│   │       └── LaporanController.php
│   │
│   ├── Middleware/
│   │   ├── AdminMiddleware.php
│   │   ├── GuruMiddleware.php
│   │   └── KepalaSekolahMiddleware.php
│   │
│   ├── Requests/
│   │
│   └── Services/
│       ├── QRCodeService.php
│       ├── PresensiService.php
│       ├── LaporanService.php
│       └── NotificationService.php
│
├── Models/
│   ├── User.php
│   ├── Guru.php
│   ├── Presensi.php
│   ├── Pengajuan.php
│   └── Notifikasi.php
│
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
│
├── resources/
│   └── views/
│
│       ├── layouts/
│       │   ├── admin.blade.php
│       │   ├── guru.blade.php
│       │   └── kepsek.blade.php
│       │
│       ├── admin/
│       │   ├── dashboard/
│       │   ├── guru/
│       │   ├── presensi/
│       │   ├── qrcode/
│       │   └── laporan/
│       │
│       ├── guru/
│       │   ├── dashboard/
│       │   ├── presensi/
│       │   ├── pengajuan/
│       │   └── riwayat/
│       │
│       ├── kepsek/
│       │   ├── dashboard/
│       │   ├── monitoring/
│       │   ├── persetujuan/
│       │   └── laporan/
│       │
│       └── components/
│           ├── navbar.blade.php
│           ├── sidebar.blade.php
│           ├── footer.blade.php
│           └── alert.blade.php
│
├── routes/
│   ├── web.php
│   ├── admin.php
│   ├── guru.php
│   └── kepsek.php
│
├── public/
│   └── assets/
│       ├── css/
│       ├── js/
│       ├── images/
│       ├── qrcode/
│       └── audio/
│
├── storage/
│   ├── app/
│   │   ├── qrcode/
│   │   ├── surat/
│   │   └── laporan/
│
└── tests/
```

---

# Package Laravel Yang Direkomendasikan

Login:

```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install
npm run build
php artisan migrate
```

QR Code:

```bash
composer require simplesoftwareio/simple-qrcode
```

Excel:

```bash
composer require maatwebsite/excel
```

PDF:

```bash
composer require barryvdh/laravel-dompdf
```

---

# Role Sistem

Admin

* Kelola Guru
* Generate QR
* Laporan

Guru

* Presensi
* Riwayat
* Pengajuan

Kepala Sekolah

* Monitoring
* Persetujuan
* Statistik
* Laporan

```
```

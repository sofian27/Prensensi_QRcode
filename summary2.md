# Summary Implementasi Sistem Presensi Guru QR Code

Tanggal pengerjaan: 2 Juni 2026

## Yang Telah Dibuat

### 1. Struktur Role Sistem

Sistem disiapkan untuk 3 role utama sesuai `SUMMARY.md`:

- Admin
- Guru
- Kepala Sekolah

Kolom `role` dan `is_active` ditambahkan pada tabel `users`.

### 2. Model dan Relasi

Model yang dibuat dan diisi:

- `App\Models\Guru`
- `App\Models\Presensi`
- `App\Models\Pengajuan`
- `App\Models\Notifikasi`

Relasi utama:

- User memiliki satu Guru.
- Guru memiliki banyak Presensi.
- Guru memiliki banyak Pengajuan.
- Pengajuan dapat diproses oleh User sebagai approver.
- Notifikasi dimiliki oleh User.

### 3. Migration Database

Migration yang dibuat:

- `create_gurus_table`
- `create_presensis_table`
- `create_pengajuans_table`
- `create_notifikasis_table`
- `add_role_fields_to_users_table`

Isi tabel sudah mencakup data penting seperti NIP guru, presensi masuk/pulang, status pengajuan, status presensi, dan notifikasi.

### 4. Controller

Controller Admin:

- `Admin\DashboardController`
- `Admin\GuruController`
- `Admin\PresensiController`
- `Admin\QRCodeController`
- `Admin\LaporanController`

Controller Guru:

- `Guru\DashboardController`
- `Guru\PresensiController`
- `Guru\PengajuanController`
- `Guru\RiwayatController`

Controller Kepala Sekolah:

- `KepalaSekolah\DashboardController`
- `KepalaSekolah\MonitoringController`
- `KepalaSekolah\PersetujuanController`
- `KepalaSekolah\LaporanController`

### 5. Middleware

Middleware role dibuat dan diaktifkan melalui alias Laravel 12:

- `admin`
- `guru`
- `kepsek`

Middleware ini membatasi akses halaman berdasarkan role user login.

### 6. Route

Route dipisahkan sesuai struktur:

- `routes/web.php`
- `routes/admin.php`
- `routes/guru.php`
- `routes/kepsek.php`

Route yang tersedia meliputi dashboard, kelola guru, presensi, generate QR payload, pengajuan, persetujuan, monitoring, dan laporan.

### 7. Request Validation

Request validation yang dibuat:

- `StoreGuruRequest`
- `UpdateGuruRequest`
- `StorePengajuanRequest`

Validasi mencakup NIP unik, status guru, jenis pengajuan, tanggal pengajuan, alasan, dan lampiran surat.

### 8. Service Layer

Folder `app/Services` dibuat dengan service berikut:

- `QRCodeService`
- `PresensiService`
- `LaporanService`
- `NotificationService`

Service digunakan untuk memisahkan logic generate payload QR, simpan presensi, rekap laporan, dan pembuatan notifikasi.

### 9. View dan Layout

Layout dibuat:

- `layouts/admin.blade.php`
- `layouts/guru.blade.php`
- `layouts/kepsek.blade.php`

Komponen dibuat:

- `components/sidebar.blade.php`
- `components/navbar.blade.php`
- `components/footer.blade.php`
- `components/alert.blade.php`

Halaman utama dibuat untuk:

- Dashboard Admin
- Kelola Guru
- Data Presensi Admin
- Generate QR Code
- Laporan Admin
- Dashboard Guru
- Presensi Guru
- Pengajuan Guru
- Riwayat Guru
- Dashboard Kepala Sekolah
- Monitoring Presensi
- Persetujuan Pengajuan
- Laporan Kepala Sekolah

### 10. Asset dan Folder Storage

Folder asset publik dibuat:

- `public/assets/css`
- `public/assets/js`
- `public/assets/images`
- `public/assets/qrcode`
- `public/assets/audio`

Folder storage aplikasi dibuat:

- `storage/app/qrcode`
- `storage/app/surat`
- `storage/app/laporan`

File CSS dasar dibuat di `public/assets/css/app.css`.

### 11. Seeder dan Factory

Seeder dibuat:

- `AdminSeeder`
- `GuruSeeder`

Data demo yang dibuat:

- Admin: `admin@sma-cipasung.test` / `password`
- Kepala Sekolah: `kepsek@sma-cipasung.test` / `password`
- Guru: `guru@sma-cipasung.test` / `password`

Factory yang dibuat:

- `GuruFactory`
- `PresensiFactory`

### 12. Database dan Verifikasi

Perintah yang sudah dijalankan:

- `php artisan migrate`
- `php artisan db:seed`
- `php artisan route:list`
- `php artisan test`

Hasil test:

- 2 test bawaan Laravel berhasil.
- Route aplikasi berhasil terdaftar.

## Catatan

Package rekomendasi di `SUMMARY.md` seperti Breeze, Simple QRCode, Excel, dan DomPDF belum di-install. Kerangka aplikasi sudah dibuat agar siap dilanjutkan ke tahap login Breeze, QR visual, export Excel, dan export PDF.

## Update Desain

Pada tahap desain, file tampilan diperbarui agar aplikasi tidak lagi memakai tampilan scaffold bawaan Laravel:

- Halaman welcome Laravel diganti menjadi halaman depan khusus `SMA Cipasung Presensi`.
- Layout admin, guru, dan kepala sekolah diberi sidebar, topbar, status tanggal, tombol keluar, kartu statistik, tabel, dan form yang konsisten.
- Sidebar dibuat aktif berdasarkan route yang sedang dibuka.
- CSS utama ditulis ulang di `public/assets/css/app.css`.
- Halaman login sederhana dibuat di `resources/views/auth/login.blade.php`.
- Controller login sederhana dibuat di `App\Http\Controllers\Auth\LoginController`.
- Route login/logout ditambahkan di `routes/web.php`.

Verifikasi tambahan:

- `/` berhasil diakses dengan status 200.
- `/login` berhasil diakses dengan status 200.
- `/admin/dashboard` tanpa login redirect ke login dengan status 302.
- `php artisan test` berhasil dengan 2 test passed.

## Update QR Code Otomatis dan Scanner Kamera

Sesuai alur presensi QR, fitur QR diperbarui:

- Package `simplesoftwareio/simple-qrcode` ditambahkan agar sistem dapat membuat gambar QR otomatis.
- Model dan migration `PresensiQrCode` dibuat untuk menyimpan QR aktif harian.
- Admin sekarang dapat generate QR presensi `masuk` atau `pulang`.
- QR lama untuk jenis yang sama otomatis dinonaktifkan saat admin membuat QR baru.
- QR berisi link scan sistem: `/scan-qrcode/{token}`.
- Service `QRCodeService` diperbarui untuk membuat token, payload link, dan SVG QR.
- Service `PresensiService` diperbarui agar dapat memvalidasi token QR dan menyimpan presensi otomatis.
- Controller `ScanQrCodeController` dibuat untuk membaca token QR.
- Jika QR dibuka oleh guru login, presensi langsung disimpan.
- Jika QR dibuka tanpa login, token disimpan sementara lalu diproses setelah guru login.
- Halaman awal `/` sekarang memiliki area kamera untuk scan QR.
- Scanner menggunakan `BarcodeDetector` browser dan menyediakan input manual sebagai fallback.

Verifikasi tambahan QR:

- Migration `presensi_qr_codes` berhasil dijalankan di MySQL.
- Generator QR berhasil menghasilkan SVG.
- `/scan-qrcode/TESTTOKEN` tanpa login redirect ke login dengan status 302.
- `/` tetap berhasil diakses dengan status 200.
- `php artisan test` tetap berhasil dengan 2 test passed.

## Update Desain Profesional Sistem

Tahap desain terbaru difokuskan pada tampilan sistem yang terlihat siap digunakan:

- Halaman awal `/` dibangun ulang menjadi landing internal resmi SMA Islam Cipasung.
- Asset sekolah digunakan langsung dari `public/assets/images/logo.jpeg` dan `public/assets/images/benner.jpeg`.
- Tampilan welcome lama berbasis preview/dummy dihapus.
- Area scanner kamera di halaman awal disembunyikan dari desain utama karena logic scan akan dilanjutkan pada tahap berikutnya.
- Halaman login dibangun ulang menjadi layout dua panel dengan banner gedung sekolah dan form akses resmi.
- Informasi akun demo dihapus dari halaman login.
- Sidebar dashboard memakai logo resmi sekolah.
- Seluruh CSS utama di `public/assets/css/app.css` ditulis ulang dengan gaya formal, rapi, responsif, dan konsisten untuk dashboard admin, guru, dan kepala sekolah.
- Nama data awal `Guru Demo` diganti menjadi `Guru Matematika` agar tidak terlihat seperti data contoh mentah.

Verifikasi desain:

- Tidak ada teks `demo`, `Guru Demo`, atau `Akun demo` pada view dan CSS.
- `/` berhasil diakses dengan status 200.
- `/login` berhasil diakses dengan status 200.
- `php artisan test` berhasil dengan 2 test passed.

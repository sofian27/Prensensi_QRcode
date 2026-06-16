# Panduan Scan QR Guru dengan Scanner Acanlogic

## Akun Admin Bawaan

Gunakan akun berikut jika database diisi dari seeder bawaan:

- Email: `admin@sma-cipasung.test`
- Username: `admin`
- Password: `cipasung123`

Login bisa memakai email atau username.

## Cara Admin Membuat Kartu QR Guru

1. Buka aplikasi:
   `http://localhost/sma_cipasung-main/public`
2. Klik `Masuk`.
3. Login sebagai admin.
4. Buka menu `Data Guru`.
5. Klik `Tambah Guru`.
6. Isi data guru:
   - Nama
   - Username
   - NIP
   - Mata pelajaran
   - Nomor HP
   - Alamat
   - Status `aktif`
7. Simpan data guru.
8. Setelah guru tersimpan, sistem otomatis membuat `token_qr` unik untuk guru tersebut.
9. Di tabel `Data Guru`, klik tombol `QR`.
10. Cetak atau download kartu QR guru.

Catatan: password awal guru mengikuti NIP guru.

## Cara Guru Melakukan Presensi

Guru tidak perlu login untuk scan presensi.

1. Operator/admin membuka halaman terminal scan:
   `http://localhost/sma_cipasung-main/public`
   atau login admin lalu buka menu `Direktori Guru`.
2. Colok scanner Acanlogic ke komputer.
3. Pastikan scanner berada di mode `USB HID Keyboard Mode`.
4. Pilih mode presensi:
   - `Scan Masuk`
   - `Scan Pulang`
5. Guru menempelkan atau mengarahkan kartu QR ke scanner Acanlogic.
6. Scanner akan mengirim isi QR ke input `qr_code`.
7. Scanner mengirim ENTER.
8. Sistem otomatis menyimpan presensi.

Jika berhasil, halaman akan menampilkan pesan berhasil scan masuk atau pulang.

## Cara Test Scanner Acanlogic

1. Colok scanner ke komputer.
2. Buka Notepad.
3. Scan kartu QR guru.
4. Jika kode muncul di Notepad dan kursor turun/baris baru, scanner sudah benar.
5. Jika kode muncul tapi tidak submit di aplikasi, aktifkan suffix ENTER pada scanner.

## Logika Sistem Saat Scan

Alur sistem:

```text
Kartu QR Guru
    ->
Scanner Acanlogic
    ->
Input qr_code di halaman web
    ->
POST /terminal-scan
    ->
TerminalScanController
    ->
PresensiService
    ->
Cari guru berdasarkan token_qr
    ->
Validasi status guru aktif
    ->
Validasi izin/sakit/cuti/dinas hari ini
    ->
Simpan presensi masuk atau pulang
```

## Logika Admin dan QR Code

Saat admin membuat guru baru:

1. Data user guru dibuat.
2. Data profil guru dibuat.
3. Sistem menjalankan `QRCodeService::ensureGuruToken($guru)`.
4. Jika guru belum memiliki token QR, sistem membuat token unik seperti:
   `GURU-XXXXXXXXXXXXXXXX`
5. Token disimpan ke kolom `gurus.token_qr`.
6. Saat admin membuka kartu QR, sistem membuat QR dari token tersebut.

File terkait:

- Controller data guru: `app/Http/Controllers/Admin/GuruController.php`
- Controller kartu QR: `app/Http/Controllers/Admin/GuruCardController.php`
- Service QR: `app/Services/QRCodeService.php`
- Controller scan: `app/Http/Controllers/Admin/TerminalScanController.php`
- Service presensi: `app/Services/PresensiService.php`
- Halaman terminal admin: `resources/views/admin/scan/index.blade.php`
- Halaman terminal publik: `resources/views/welcome.blade.php`

## Aturan Presensi

- Scan masuk membuat atau memperbarui presensi hari ini.
- Scan pulang hanya bisa dilakukan jika guru sudah scan masuk.
- Guru dengan status tidak aktif tidak bisa scan.
- Guru yang memiliki pengajuan disetujui hari ini tidak dicatat hadir dari scan alat.
- Data presensi tersimpan di tabel `presensis`.


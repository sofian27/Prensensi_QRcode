# Dokumentasi Revisi Sistem Presensi Guru

Sumber acuan: `revisi.md`

## Konsep Utama

Sistem memakai kartu QR fisik milik guru.

Guru tidak memindai QR dari halaman web. Guru hanya menunjukkan kartu QR ke terminal kamera di sekolah.

## Role dan Hak Akses

### Admin

Admin adalah operator teknis.

Fitur admin:

- CRUD data guru.
- Membuat akun guru.
- Username ditentukan admin.
- Password guru otomatis sama dengan NIP.
- Menerbitkan/cetak kartu QR guru.
- Membuka terminal scan presensi di sekolah.
- Melihat data presensi.
- Melihat laporan.

### Guru

Guru adalah subjek presensi.

Fitur guru:

- Login ke aplikasi.
- Melihat status/riwayat presensi.
- Mengajukan izin jika tidak hadir.
- Mengunggah bukti PDF/JPG/JPEG/PNG.

Guru tidak membuat QR dan tidak scan QR dari halaman web.

### Kepala Sekolah

Kepala sekolah adalah pengambil keputusan.

Fitur kepala sekolah:

- Monitoring kehadiran.
- Melihat pengajuan guru.
- Menyetujui/menolak pengajuan.
- Melihat laporan.

## Alur Presensi Hadir

1. Admin menambahkan guru.
2. Sistem membuat akun guru dan token QR unik.
3. Admin mencetak kartu QR guru.
4. Guru datang ke sekolah.
5. Operator memilih mode `Scan Masuk` atau `Scan Pulang`.
6. Guru menunjukkan kartu QR ke terminal scan sekolah.
7. Sistem membaca token QR.
8. Sistem mencari guru berdasarkan token QR.
9. Jika guru aktif dan tidak memiliki pengajuan disetujui hari ini, sistem mencatat `jam_masuk` atau `jam_pulang`.
10. Jika kartu discan ulang, jam pertama tidak ditimpa.
11. Setelah scan berhasil, browser membacakan ucapan terima kasih.

## Alur Pengajuan Izin

1. Guru login.
2. Guru membuka menu Pengajuan.
3. Guru memilih jenis: `izin`, `sakit`, `cuti`, atau `dinas_luar`.
4. Guru mengisi tanggal, alasan, dan lampiran jika ada.
5. Kepala sekolah menyetujui atau menolak.
6. Jika disetujui, sistem otomatis membuat presensi harian dengan:
   - `status` sesuai jenis pengajuan.
   - `metode_input` = `Form Web`.
   - `keterangan` = alasan pengajuan.

## Aturan Anti Double Logging

Jika guru sudah memiliki pengajuan yang disetujui pada tanggal hari ini, scan kartu QR tidak akan dicatat sebagai hadir.

Tujuannya agar guru tidak tercatat dua status dalam satu hari, misalnya `sakit` dan `hadir` sekaligus.

## Akun Default

| Role | Username | Password |
| --- | --- | --- |
| Admin | `admin` | `cipasung123` |
| Kepala Sekolah | `kepsek` | `cipasung123` |
| Guru Demo | `guru001` | `GURU-001` |

## File Penting

- CRUD guru: `app/Http/Controllers/Admin/GuruController.php`
- Cetak kartu QR guru: `app/Http/Controllers/Admin/GuruCardController.php`
- Terminal scan sekolah: `app/Http/Controllers/Admin/TerminalScanController.php`
- Service QR kartu guru: `app/Services/QRCodeService.php`
- Service presensi dan sinkronisasi izin: `app/Services/PresensiService.php`
- Persetujuan kepala sekolah: `app/Http/Controllers/KepalaSekolah/PersetujuanController.php`
- View kartu QR guru: `resources/views/admin/guru/kartu.blade.php`
- View terminal scan: `resources/views/admin/scan/index.blade.php`

## Catatan Teknis

Kolom penting:

- `gurus.token_qr`: token unik yang masuk ke QR kartu guru.
- `presensis.metode_input`: asal data presensi, misalnya `Scan Alat` atau `Form Web`.

Scanner kamera memakai library `html5-qrcode` agar lebih stabil dan mendukung lebih banyak browser. Jika kamera tetap tidak terbaca, admin dapat memakai input manual token QR.

Suara scan memakai Web Speech API browser:

- Scan masuk: `Terima kasih Bapak atau Ibu. Presensi masuk berhasil.`
- Scan pulang: `Terima kasih Bapak dan Ibu. Presensi pulang berhasil.`

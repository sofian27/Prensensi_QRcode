## Tujuan Perubahan

Project Laravel sudah berjalan.

Saat ini proses presensi belum menggunakan alat scanner QR/Barcode Acanlogic.

Target perubahan adalah agar pengguna dapat melakukan presensi dengan scan kartu QR menggunakan scanner fisik.

---

## Kebutuhan

Scanner:

* Acanlogic 1D/2D QR Barcode Scanner
* USB HID Keyboard Mode

Scanner harus dapat mengirim hasil scan langsung ke aplikasi web.

---

## Logika Yang Diinginkan

```text
Kartu QR
    ↓
Scanner Acanlogic
    ↓
Input Scan
    ↓
Laravel
    ↓
Validasi Pengguna
    ↓
Simpan Presensi
```

---

## Yang Harus Diubah

### Halaman Presensi

Tambahkan input khusus scanner.

Contoh:

```html
<input
    type="text"
    id="scanner"
    name="qr_code"
    autofocus
>
```

Input harus selalu aktif (focus).

---

### Auto Submit

Setelah scanner mengirim data dan ENTER:

```text
USR001
```

Form otomatis diproses.

Tidak perlu klik tombol.

---

### Controller

Pastikan controller menerima:

```php
$request->qr_code
```

Lalu:

1. Cari pengguna berdasarkan kode.
2. Validasi data.
3. Simpan presensi.

---

## Yang Harus Dicek

### Route

Cari route presensi:

```text
routes/web.php
```

### View

Cari halaman:

```text
resources/views
```

yang digunakan untuk scan.

### Controller

Cari controller yang menyimpan presensi.

---

## Pengujian

### Test Scanner

1. Colok scanner.
2. Buka Notepad.
3. Scan kartu QR.

Jika hasil QR muncul di Notepad maka scanner berfungsi.

### Test Web

1. Buka halaman presensi.
2. Fokus pada input scanner.
3. Scan kartu.

Expected:

```text
Scan berhasil
```

dan data tersimpan ke database.

---

## Hasil Akhir

Operator cukup:

1. Membuka halaman presensi.
2. Scan kartu QR.
3. Data presensi tersimpan otomatis.

Tanpa mengetik manual dan tanpa menggunakan kamera browser.
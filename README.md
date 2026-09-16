# Aplikasi Slip Gaji Karyawan (SlipGaji)

Aplikasi web sederhana untuk mengelola slip gaji karyawan. Dibuat untuk latihan Ujikom Junior Web Programmer, menggunakan **PHP Native** (tanpa framework) supaya mudah dipahami dan dijelaskan saat live coding.

## Teknologi yang Dipakai

- **PHP Native** — logika backend (proses login, simpan data, hitung gaji, dll)
- **MySQL** — database
- **HTML & CSS** — tampilan halaman
- **JavaScript sederhana** — hitung otomatis, popup, show/hide password, fitur share
- **XAMPP** — web server lokal untuk menjalankan project

## Alur Aplikasi (Flow)

```
LOGIN
  ↓
DASHBOARD (lihat daftar semua slip gaji)
  ↓
Klik "+ Tambah Data"
  ↓
POPUP PILIH PERIODE (pilih Bulan & Tahun gajian)
  ↓
FORM TAMBAH DATA (isi Nama, NIK, Jabatan, Gaji Pokok, Lembur, Pinjaman + Captcha)
  ↓
Klik "Submit" → data dihitung & disimpan ke database
  ↓
Kembali ke DASHBOARD (data baru muncul di tabel)
  ↓
Klik "Lihat" → DETAIL SLIP GAJI (tampilan slip yang rapi)
  ↓
Klik "Share" → pilih WhatsApp / Gmail / Cetak-PDF
```

**Alur Lupa Password:**
```
LOGIN → klik "LUPA KATA SANDI"
  ↓
Masukkan EMAIL
  ↓
Sistem cek apakah email terdaftar
  ↓
Kalau ketemu → masuk ke halaman RESET PASSWORD
  ↓
Isi password baru → Simpan
  ↓
Kembali ke halaman LOGIN
```

## Struktur Database

Nama database: **`ukk`**

### Tabel `users`
Menyimpan akun untuk login.

| Kolom      | Tipe          | Keterangan                    |
|------------|---------------|--------------------------------|
| id         | INT (PK)      | ID unik, otomatis bertambah   |
| username   | VARCHAR(50)   | Nama akun untuk login          |
| password   | VARCHAR(255)  | Password (sudah di-hash)       |
| email      | VARCHAR(100)  | Email, dipakai untuk fitur lupa password |

### Tabel `gaji`
Menyimpan data slip gaji yang sudah dibuat.

| Kolom              | Tipe          | Keterangan                          |
|--------------------|---------------|--------------------------------------|
| id                 | INT (PK)      | ID unik, otomatis bertambah         |
| nama               | VARCHAR(100)  | Nama karyawan                       |
| nik                | VARCHAR(30)   | NIK karyawan                        |
| jabatan            | VARCHAR(50)   | Jabatan karyawan                    |
| periode            | VARCHAR(100)  | Periode gajian, contoh: "25 November 2025 - 25 Desember 2025" |
| gaji_pokok         | INT           | Gaji pokok karyawan                 |
| lembur             | INT           | Uang lembur                         |
| pinjaman           | INT           | Potongan pinjaman karyawan          |
| total_penghasilan  | INT           | Hasil dari gaji_pokok + lembur      |
| total_potongan     | INT           | Sama dengan nilai pinjaman          |
| gaji_bersih        | INT           | Hasil dari total_penghasilan - total_potongan |

## Daftar File dan Fungsinya

| File                       | Fungsi                                                              |
|-----------------------------|----------------------------------------------------------------------|
| `koneksi.php`               | Menghubungkan PHP ke database MySQL                                 |
| `login.php`                 | Menampilkan form login (judul "MASUK")                              |
| `proses_login.php`          | Mengecek username/email & password, lalu membuat session            |
| `lupa_password.php`         | Form input email untuk fitur lupa password                          |
| `proses_lupa_password.php`  | Mengecek apakah email terdaftar di database                         |
| `reset_password.php`        | Form untuk membuat password baru                                    |
| `proses_reset_password.php` | Menyimpan password baru (sudah di-hash) ke database                 |
| `logout.php`                | Menghapus session, kembali ke halaman login                         |
| `dashboard.php`             | Halaman utama: tabel daftar slip gaji + popup pilih periode + fitur share |
| `tambah.php`                | Form tambah data slip gaji baru, lengkap dengan captcha              |
| `simpan.php`                | Mengecek captcha, menghitung gaji, lalu menyimpan ke database        |
| `detail.php`                | Menampilkan 1 slip gaji secara rapi, ada tombol Share & Cetak/PDF     |
| `hapus.php`                 | Menghapus 1 data slip gaji dari database                             |
| `style.css`                 | Semua tampilan/warna aplikasi (tema ungu/lavender)                   |
| `ukk.sql`                   | Script untuk membuat database `ukk` beserta tabelnya secara otomatis |

## Penjelasan Fitur Utama

### 1. Login & Session
Menggunakan `session_start()` untuk mengingat siapa yang sedang login. Password disimpan dalam bentuk **hash** (`password_hash()`), bukan teks polos, supaya lebih aman. Saat login, password yang diinput dicocokkan pakai `password_verify()`.

### 2. Popup Pilih Periode
Sebelum masuk ke form tambah data, muncul popup untuk memilih **Bulan** dan **Tahun** gajian. Tanggal gajian selalu tanggal 25, jadi periode otomatis dihitung, contoh: pilih **November 2025** → jadi **"25 Oktober 2025 - 25 November 2025"**.

### 3. Perhitungan Gaji
Rumus yang dipakai:
```
Total Penghasilan = Gaji Pokok + Lembur
Total Potongan    = Pinjaman Karyawan
Gaji Bersih       = Total Penghasilan - Total Potongan
```
Perhitungan ditampilkan otomatis di form pakai JavaScript (`oninput`), tapi perhitungan **yang sebenarnya tetap dihitung ulang di PHP** (`simpan.php`) supaya tidak bisa dimanipulasi dari sisi browser.

### 4. Captcha
Sebelum data bisa disimpan, user harus menjawab soal perkalian sederhana (misalnya "7 x 5"). Jawaban yang benar disimpan sementara di `session`, lalu dicocokkan di `simpan.php`. Kalau salah, user dikembalikan ke form dengan pesan error.

### 5. Fitur Share
- **WhatsApp** — membuka `https://wa.me/?text=...` dengan isi slip gaji yang sudah otomatis terisi
- **Gmail** — menanyakan email tujuan lewat `prompt()`, lalu membuka halaman compose Gmail (`https://mail.google.com/mail/?view=cm...`) dengan subjek dan isi otomatis
- **PDF / Cetak** — memakai `window.print()`, memanfaatkan fitur print bawaan browser (user bisa pilih "Save as PDF")

## Cara Menjalankan Project (XAMPP)

1. Extract/copy folder project ke `C:\xampp\htdocs\ukk`
2. Buka **XAMPP Control Panel**, klik **Start** pada Apache dan MySQL
3. Buka `http://localhost/phpmyadmin`, klik tab **Import**, pilih file `ukk.sql`, klik **Go**
   (ini otomatis membuat database `ukk` beserta tabel `users` dan `gaji`, plus 1 akun default)
4. Buka browser, akses `http://localhost/ukk/login.php`
5. Login menggunakan akun default:
   - **Username:** `admin`
   - **Password:** `admin123`

## Urutan Live Coding yang Disarankan

1. Buat database (import `ukk.sql` atau bikin manual kalau diminta dari nol)
2. `koneksi.php` — pastikan koneksi ke database berhasil
3. `login.php` + `proses_login.php` — pastikan login berfungsi
4. `dashboard.php` — tampilkan tabel data (boleh kosong dulu)
5. Popup pilih periode + `tambah.php` — coba isi form dan submit
6. `simpan.php` — pastikan data tersimpan & perhitungan benar
7. `detail.php` — cek tampilan slip gaji
8. `hapus.php` — cek data bisa dihapus
9. Fitur Share (WhatsApp/Gmail/PDF)
10. Fitur lupa password (kalau waktu masih cukup)

## Catatan

- Password default (`admin123`) sebaiknya diganti setelah aplikasi benar-benar dipakai.
- Fitur Share ke Gmail hanya membuka draft email yang sudah terisi otomatis — pengiriman tetap harus dilakukan manual oleh pengguna dengan klik tombol "Kirim" di Gmail.
- Perhitungan gaji sengaja dihitung ulang di PHP (bukan hanya JavaScript) untuk mencegah manipulasi data dari sisi browser.

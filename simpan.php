<?php
// File ini menghitung dan menyimpan data slip gaji ke database
session_start();
include "koneksi.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// ===== CEK CAPTCHA DULU =====
// Jawaban yang benar sudah disimpan di session saat halaman tambah.php dibuka
$captcha_input = $_POST['captcha'];
$bulan = $_POST['bulan'];
$tahun = $_POST['tahun'];
if ($captcha_input != $_SESSION['captcha_jawaban']) {
    // Kalau jawaban captcha salah, kembali ke form tambah data (bulan/tahun ikut dibawa lagi)
    header("Location: tambah.php?bulan=$bulan&tahun=$tahun&captcha_error=1");
    exit;
}

// Ambil data dari form tambah.php
$nama = $_POST['nama'];
$nik = $_POST['nik'];
$jabatan = $_POST['jabatan'];
$periode = $_POST['periode'];
$gaji_pokok = $_POST['gaji_pokok'];
$lembur = $_POST['lembur'];
$pinjaman = $_POST['pinjaman'];

// ===== RUMUS PERHITUNGAN GAJI =====
$total_penghasilan = $gaji_pokok + $lembur;   // Gaji Pokok + Lembur
$total_potongan = $pinjaman;                   // Pinjaman Karyawan
$gaji_bersih = $total_penghasilan - $total_potongan; // Penghasilan - Potongan

// Simpan data ke tabel gaji
$sql = "INSERT INTO gaji (nama, nik, jabatan, periode, gaji_pokok, lembur, pinjaman, total_penghasilan, total_potongan, gaji_bersih)
        VALUES ('$nama', '$nik', '$jabatan', '$periode', '$gaji_pokok', '$lembur', '$pinjaman', '$total_penghasilan', '$total_potongan', '$gaji_bersih')";

mysqli_query($koneksi, $sql);

// Setelah tersimpan, kembali ke dashboard
header("Location: dashboard.php");
exit;
?>

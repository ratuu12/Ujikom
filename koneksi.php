<?php
// ===== FILE KONEKSI KE DATABASE =====
// File ini isinya cuma untuk menyambungkan PHP ke MySQL
// Nanti file lain tinggal "include" atau "require" file ini

$host = "localhost";   // alamat server database (biasanya localhost)
$user = "root";        // username database (default Laragon = root)
$pass = "";             // password database (default Laragon = kosong)
$nama_database = "ukk";

// Membuat koneksi ke MySQL
$koneksi = mysqli_connect($host, $user, $pass, $nama_database);

// Jika koneksi gagal, program berhenti dan tampilkan pesan error
if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
?>

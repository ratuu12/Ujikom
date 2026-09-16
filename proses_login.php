<?php
// File ini dipanggil saat form login di-submit
session_start();
include "koneksi.php";

// Ambil data yang dikirim dari form login.php
$username = $_POST['username'];
$password = $_POST['password'];

// Cari user berdasarkan username ATAU email yang dimasukkan
$sql = "SELECT * FROM users WHERE username = '$username' OR email = '$username'";
$hasil = mysqli_query($koneksi, $sql);

// Jika data user ditemukan
if (mysqli_num_rows($hasil) > 0) {
    $data_user = mysqli_fetch_assoc($hasil);

    // Cocokkan password yang diinput dengan password di database (yang sudah terenkripsi)
    if (password_verify($password, $data_user['password'])) {
        // Password cocok -> simpan data ke session, lalu masuk dashboard
        $_SESSION['username'] = $data_user['username'];
        $_SESSION['id_user'] = $data_user['id'];
        header("Location: dashboard.php");
        exit;
    }
}

// Jika username tidak ditemukan atau password salah -> kembali ke login dengan pesan error
header("Location: login.php?error=1");
exit;
?>

<?php
// File ini mengecek apakah email yang diinput terdaftar di database
session_start();
include "koneksi.php";

$email = $_POST['email'];

$sql = "SELECT * FROM users WHERE email = '$email'";
$hasil = mysqli_query($koneksi, $sql);

if (mysqli_num_rows($hasil) > 0) {
    // Email ditemukan -> simpan email ke session supaya bisa dipakai di reset_password.php
    $_SESSION['email_reset'] = $email;
    header("Location: reset_password.php");
    exit;
} else {
    // Email tidak ditemukan -> kembali dengan pesan error
    header("Location: lupa_password.php?error=1");
    exit;
}
?>

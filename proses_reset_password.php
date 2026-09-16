<?php
// File ini menyimpan password baru ke database
session_start();
include "koneksi.php";

// Kalau belum ada email di session, tidak boleh akses file ini
if (!isset($_SESSION['email_reset'])) {
    header("Location: lupa_password.php");
    exit;
}

$email = $_SESSION['email_reset'];
$password_baru = $_POST['password_baru'];

// Enkripsi password baru sebelum disimpan (jangan simpan password asli/polos)
$password_hash = password_hash($password_baru, PASSWORD_DEFAULT);

$sql = "UPDATE users SET password = '$password_hash' WHERE email = '$email'";
mysqli_query($koneksi, $sql);

// Hapus session email_reset karena sudah tidak dipakai lagi
unset($_SESSION['email_reset']);

header("Location: login.php?reset=1");
exit;
?>

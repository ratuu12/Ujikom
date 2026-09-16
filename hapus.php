<?php
// File ini menghapus data slip gaji berdasarkan id
session_start();
include "koneksi.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];

$sql = "DELETE FROM gaji WHERE id = '$id'";
mysqli_query($koneksi, $sql);

header("Location: dashboard.php");
exit;
?>

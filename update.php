<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$id = $_POST['id'];
$nama = $_POST['nama'];
$nik = $_POST['nik'];
$jabatan = $_POST['jabatan'];
$periode = $_POST['periode'];
$gaji_pokok = $_POST['gaji_pokok'];
$lembur = $_POST['lembur'];
$pinjaman = $_POST['pinjaman'];

$total_penghasilan = $gaji_pokok + $lembur;
$total_potongan = $pinjaman;
$gaji_bersih = $total_penghasilan - $total_potongan;

$sql = "UPDATE gaji SET
            nama = '$nama',
            nik = '$nik',
            jabatan = '$jabatan',
            periode = '$periode',
            gaji_pokok = '$gaji_pokok',
            lembur = '$lembur',
            pinjaman = '$pinjaman',
            total_penghasilan = '$total_penghasilan',
            total_potongan = '$total_potongan',
            gaji_bersih = '$gaji_bersih'
        WHERE id = '$id'";

mysqli_query($koneksi, $sql);

header("Location: dashboard.php");
exit;
?>
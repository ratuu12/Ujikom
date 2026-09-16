<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Ambil id data dari URL, contoh: detail.php?id=1
$id = $_GET['id'];

$sql = "SELECT * FROM gaji WHERE id = '$id'";
$hasil = mysqli_query($koneksi, $sql);
$data = mysqli_fetch_assoc($hasil);

// Kalau data tidak ada, kembali ke dashboard
if (!$data) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Slip Gaji - SlipGaji</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="navbar no-print">
    <div class="brand">SlipGaji</div>
    <div class="user-info">
        Halo, <?php echo $_SESSION['username']; ?> &nbsp;
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="container">
    <div class="card slip-box">
        <h2>SLIP GAJI KARYAWAN</h2>
        <p style="text-align:center; color:#7c4dff; font-weight:bold; margin-bottom:20px; margin-top:-15px;">
            PERIODE <?php echo strtoupper($data['periode']); ?>
        </p>

        <div class="slip-row">
            <span>Nama Karyawan</span>
            <span><?php echo $data['nama']; ?></span>
        </div>
        <div class="slip-row">
            <span>NIK</span>
            <span><?php echo $data['nik']; ?></span>
        </div>
        <div class="slip-row">
            <span>Jabatan</span>
            <span><?php echo $data['jabatan']; ?></span>
        </div>
        <div class="slip-row">
            <span>Gaji Pokok</span>
            <span>Rp<?php echo number_format($data['gaji_pokok'], 0, ',', '.'); ?></span>
        </div>
        <div class="slip-row">
            <span>Lembur</span>
            <span>Rp<?php echo number_format($data['lembur'], 0, ',', '.'); ?></span>
        </div>
        <div class="slip-row">
            <span>Total Penghasilan</span>
            <span>Rp<?php echo number_format($data['total_penghasilan'], 0, ',', '.'); ?></span>
        </div>
        <div class="slip-row">
            <span>Pinjaman</span>
            <span>Rp<?php echo number_format($data['pinjaman'], 0, ',', '.'); ?></span>
        </div>
        <div class="slip-row">
            <span>Total Potongan</span>
            <span>Rp<?php echo number_format($data['total_potongan'], 0, ',', '.'); ?></span>
        </div>

        <div class="slip-total">
            <span>GAJI BERSIH</span>
            <span>Rp<?php echo number_format($data['gaji_bersih'], 0, ',', '.'); ?></span>
        </div>

        <div class="slip-buttons no-print">
            <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
            <button type="button" class="btn" onclick="shareWhatsApp()">Share WA</button>
            <button type="button" class="btn" onclick="window.print()">Cetak / PDF</button>
        </div>
    </div>
</div>

<script>
// Share detail slip gaji ini ke WhatsApp
function shareWhatsApp() {
    var teks = "SLIP GAJI KARYAWAN\n" +
        "Nama: <?php echo $data['nama']; ?>\n" +
        "Gaji Pokok: Rp<?php echo number_format($data['gaji_pokok'], 0, ',', '.'); ?>\n" +
        "Lembur: Rp<?php echo number_format($data['lembur'], 0, ',', '.'); ?>\n" +
        "Pinjaman: Rp<?php echo number_format($data['pinjaman'], 0, ',', '.'); ?>\n" +
        "Gaji Bersih: Rp<?php echo number_format($data['gaji_bersih'], 0, ',', '.'); ?>";
    var url = "https://wa.me/?text=" + encodeURIComponent(teks);
    window.open(url, "_blank");
}
</script>

</body>
</html>

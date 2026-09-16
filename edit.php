<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Ambil id data dari URL, contoh: edit.php?id=1
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
    <title>Edit Data - SlipGaji</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="navbar">
    <div class="brand">SlipGaji</div>
    <div class="user-info">
        Halo, <?php echo $_SESSION['username']; ?> &nbsp;
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="container">
    <div class="page-header">
        <h2>Edit Data Slip Gaji</h2>
    </div>

    <h3 style="text-align:center; color:#4a2f9a; margin-bottom:5px;">SLIP GAJI KARYAWAN</h3>

    <div class="card" style="max-width:550px; margin:0 auto;">
        <form action="update.php" method="POST" id="formGaji">
            <input type="hidden" name="id" value="<?php echo $data['id']; ?>">

            <div class="form-inline">
                <label>PERIODE</label>
                <input type="text" name="periode" id="periode" value="<?php echo $data['periode']; ?>" required>
            </div>

            <div class="form-inline">
                <label>NAMA</label>
                <input type="text" name="nama" id="nama" value="<?php echo $data['nama']; ?>" placeholder="Nama karyawan" required>
            </div>
            <div class="form-inline">
                <label>NIK</label>
                <input type="text" name="nik" id="nik" value="<?php echo $data['nik']; ?>" placeholder="NIK karyawan" required>
            </div>
            <div class="form-inline">
                <label>JABATAN</label>
                <input type="text" name="jabatan" id="jabatan" value="<?php echo $data['jabatan']; ?>" placeholder="Jabatan karyawan" required>
            </div>

            <div class="dua-kolom">
                <div>
                    <div class="kolom-judul">PENGHASILAN</div>
                    <div class="form-group">
                        <label>Gaji Pokok</label>
                        <input type="number" name="gaji_pokok" id="gaji_pokok" value="<?php echo $data['gaji_pokok']; ?>" oninput="hitungGaji()" required>
                    </div>
                    <div class="form-group">
                        <label>Lembur</label>
                        <input type="number" name="lembur" id="lembur" value="<?php echo $data['lembur']; ?>" oninput="hitungGaji()" required>
                    </div>
                    <div class="form-group">
                        <label>Total Penghasilan</label>
                        <input type="text" id="hasilPenghasilan" value="Rp0" disabled>
                    </div>
                </div>
                <div>
                    <div class="kolom-judul">POTONGAN</div>
                    <div class="form-group">
                        <label>Pinjaman Karyawan</label>
                        <input type="number" name="pinjaman" id="pinjaman" value="<?php echo $data['pinjaman']; ?>" oninput="hitungGaji()" required>
                    </div>
                    <div class="form-group">
                        <label>Total Potongan</label>
                        <input type="text" id="hasilPotongan" value="Rp0" disabled>
                    </div>
                </div>
            </div>

            <div class="gaji-bersih-bar">
                <span>Gaji Bersih</span>
                <span id="hasilBersih">Rp0</span>
            </div>

            <div class="slip-buttons">
                <a href="dashboard.php" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
function hitungGaji() {
    var gajiPokok = parseInt(document.getElementById('gaji_pokok').value) || 0;
    var lembur = parseInt(document.getElementById('lembur').value) || 0;
    var pinjaman = parseInt(document.getElementById('pinjaman').value) || 0;

    var totalPenghasilan = gajiPokok + lembur;
    var totalPotongan = pinjaman;
    var gajiBersih = totalPenghasilan - totalPotongan;

    document.getElementById('hasilPenghasilan').value = "Rp" + totalPenghasilan.toLocaleString('id-ID');
    document.getElementById('hasilPotongan').value = "Rp" + totalPotongan.toLocaleString('id-ID');
    document.getElementById('hasilBersih').innerText = "Rp" + gajiBersih.toLocaleString('id-ID');
}

hitungGaji();
</script>

</body>
</html>
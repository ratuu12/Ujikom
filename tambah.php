<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Kalau belum pilih periode (bulan & tahun) dari popup di dashboard, tolak akses langsung
if (!isset($_GET['bulan']) || !isset($_GET['tahun'])) {
    header("Location: dashboard.php");
    exit;
}

$bulan = $_GET['bulan'];   // angka 1-12
$tahun = $_GET['tahun'];

// Daftar nama bulan dalam bahasa Indonesia
$nama_bulan = [1=>"Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];

// Menghitung bulan & tahun sebelumnya (buat awal periode)
$bulan_sebelumnya = $bulan - 1;
$tahun_sebelumnya = $tahun;
if ($bulan_sebelumnya < 1) {
    $bulan_sebelumnya = 12;
    $tahun_sebelumnya = $tahun - 1;
}

// Menyusun teks periode, contoh: PERIODE 25 NOVEMBER 2025 - 25 DESEMBER 2025
$periode = "25 " . $nama_bulan[$bulan_sebelumnya] . " " . $tahun_sebelumnya . " - 25 " . $nama_bulan[$bulan] . " " . $tahun;

// ===== BUAT SOAL CAPTCHA SEDERHANA (perkalian dengan angka 5) =====
$angka1 = rand(1, 10);
$angka2 = 5;
// Jawaban yang benar disimpan di session, nanti dicek lagi di simpan.php
$_SESSION['captcha_jawaban'] = $angka1 * $angka2;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Data - SlipGaji</title>
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
        <h2>Tambah Data Slip Gaji</h2>
    </div>

    <h3 style="text-align:center; color:#4a2f9a; margin-bottom:5px;">SLIP GAJI KARYAWAN</h3>
    <p style="text-align:center; color:#7c4dff; font-weight:bold; margin-bottom:15px;">
        Periode: <?php echo $periode; ?>
    </p>

    <div class="card" style="max-width:550px; margin:0 auto;">
        <?php
        if (isset($_GET['captcha_error'])) {
            echo '<div class="alert alert-error">Jawaban captcha salah, coba lagi!</div>';
        }
        ?>
        <form action="simpan.php" method="POST" id="formGaji">
            <!-- Periode dikirim tersembunyi, sudah dipilih dari popup sebelumnya -->
            <input type="hidden" name="periode" value="<?php echo $periode; ?>">
            <input type="hidden" name="bulan" value="<?php echo $bulan; ?>">
            <input type="hidden" name="tahun" value="<?php echo $tahun; ?>">

            <!-- Data karyawan: NAMA, NIK, JABATAN -->
            <div class="form-inline">
                <label>NAMA</label>
                <input type="text" name="nama" id="nama" placeholder="Nama karyawan" required>
            </div>
            <div class="form-inline">
                <label>NIK</label>
                <input type="text" name="nik" id="nik" placeholder="NIK karyawan" required>
            </div>
            <div class="form-inline">
                <label>JABATAN</label>
                <input type="text" name="jabatan" id="jabatan" placeholder="Jabatan karyawan" required>
            </div>

            <!-- Dua kolom: PENGHASILAN di kiri, POTONGAN di kanan -->
            <div class="dua-kolom">
                <div>
                    <div class="kolom-judul">PENGHASILAN</div>
                    <div class="form-group">
                        <label>Gaji Pokok</label>
                        <input type="number" name="gaji_pokok" id="gaji_pokok" placeholder="0" oninput="hitungGaji()" required>
                    </div>
                    <div class="form-group">
                        <label>Lembur</label>
                        <input type="number" name="lembur" id="lembur" placeholder="0" oninput="hitungGaji()" required>
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
                        <input type="number" name="pinjaman" id="pinjaman" placeholder="0" oninput="hitungGaji()" required>
                    </div>
                    <div class="form-group">
                        <label>Total Potongan</label>
                        <input type="text" id="hasilPotongan" value="Rp0" disabled>
                    </div>
                </div>
            </div>

            <!-- Gaji Bersih -->
            <div class="gaji-bersih-bar">
                <span>Gaji Bersih</span>
                <span id="hasilBersih">Rp0</span>
            </div>

            <!-- Captcha sederhana, harus diisi sebelum data bisa disimpan -->
            <div class="captcha-box">
                <div class="captcha-soal">
                    <span>Captcha : <?php echo $angka1 . " x " . $angka2; ?></span>
                    <a href="javascript:void(0)" onclick="window.location.reload()" title="Ganti soal">&#8635;</a>
                </div>
                <input type="number" name="captcha" placeholder="Jawab soal di atas" required style="width:100%; padding:9px 12px; border:1px solid #ddd; border-radius:8px;">
            </div>

            <button type="submit" class="btn">Submit</button>
        </form>
    </div>
</div>

<script>
// Fungsi ini menghitung otomatis setiap kali user mengisi angka di form
// Perhitungan ini hanya untuk TAMPILAN saja, perhitungan asli tetap dihitung ulang di PHP (simpan.php)
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
</script>

</body>
</html>

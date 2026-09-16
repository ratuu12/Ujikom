<?php
session_start();
include "koneksi.php";

// Kalau belum login, tidak boleh buka dashboard
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Ambil semua data gaji dari database, urutkan dari yang terbaru
$sql = "SELECT * FROM gaji ORDER BY id DESC";
$hasil = mysqli_query($koneksi, $sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - SlipGaji</title>
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
        <h2>Dashboard</h2>
        <button type="button" class="btn-tambah" onclick="bukaPopupPeriode()">+ Tambah Data</button>
    </div>

    <div class="card">
        <table>
            <thead>
               <tr>
                 <th>No</th>
                 <th>Nama Karyawan</th>
                 <th>Jabatan</th>
                 <th>Periode</th>
                 <th>Gaji Bersih</th>
                 <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                // Looping menampilkan setiap baris data gaji
                while ($baris = mysqli_fetch_assoc($hasil)) {
                ?>
                <tr>
                    <tr>
    <td data-label="No"><?php echo $no++; ?></td>
    <td data-label="Nama"><?php echo $baris['nama']; ?></td>
    <td data-label="Jabatan"><?php echo $baris['jabatan']; ?></td>
    <td data-label="Periode"><?php echo $baris['periode']; ?></td>
                    <td data-label="Gaji Bersih">Rp<?php echo number_format($baris['gaji_bersih'], 0, ',', '.'); ?></td>
                    <td data-label="Aksi" class="aksi">
                        <a href="detail.php?id=<?php echo $baris['id']; ?>" class="lihat">Lihat</a>
                        <a href="hapus.php?id=<?php echo $baris['id']; ?>" class="hapus" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>

                        <div class="share-dropdown">
                            <button type="button" class="share" onclick="toggleShare(<?php echo $baris['id']; ?>)">Share</button>
                            <div class="share-menu" id="shareMenu<?php echo $baris['id']; ?>">
                                <a href="#" onclick="shareWhatsApp('<?php echo $baris['nama']; ?>', '<?php echo $baris['jabatan']; ?>', '<?php echo $baris['periode']; ?>', <?php echo $baris['gaji_bersih']; ?>); return false;">WhatsApp</a>
                                <a href="#" onclick="shareGmail('<?php echo $baris['nama']; ?>', '<?php echo $baris['jabatan']; ?>', '<?php echo $baris['periode']; ?>', <?php echo $baris['gaji_bersih']; ?>); return false;">Gmail</a>
                                <a href="detail.php?id=<?php echo $baris['id']; ?>">PDF / Cetak</a>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

    </div>
</div>

<!-- ===== POPUP PILIH PERIODE ===== -->
<!-- Muncul dulu sebelum masuk ke form tambah data -->
<div class="modal-overlay" id="popupPeriode">
    <div class="modal-box">
        <h3>Pilih Periode Gajian</h3>
        <p class="subtitle" style="text-align:left; margin-bottom:15px;">Tanggal gajian selalu tanggal 25, jadi cukup pilih bulan dan tahunnya saja.</p>

        <div class="form-group">
            <label>Bulan</label>
            <select id="pilihBulan">
                <option value="1">Januari</option>
                <option value="2">Februari</option>
                <option value="3">Maret</option>
                <option value="4">April</option>
                <option value="5">Mei</option>
                <option value="6">Juni</option>
                <option value="7">Juli</option>
                <option value="8">Agustus</option>
                <option value="9">September</option>
                <option value="10">Oktober</option>
                <option value="11" selected>November</option>
                <option value="12">Desember</option>
            </select>
        </div>
        <div class="form-group">
            <label>Tahun</label>
            <input type="number" id="pilihTahun" value="2025">
        </div>

        <div class="slip-buttons">
            <button type="button" class="btn btn-secondary" onclick="tutupPopupPeriode()">Batal</button>
            <button type="button" class="btn" onclick="lanjutKeForm()">Lanjut</button>
        </div>
    </div>
</div>

<script>
// Menampilkan/menyembunyikan menu Share saat tombol Share diklik
function toggleShare(id) {
    var menu = document.getElementById('shareMenu' + id);
    menu.classList.toggle('tampil');
}

// Fungsi share ke WhatsApp: membuka wa.me dengan teks yang sudah diisi otomatis
function shareWhatsApp(nama, jabatan, periode, gajiBersih) {
    var teks = "Slip Gaji Karyawan\nNama: " + nama + "\nJabatan: " + jabatan + "\nPeriode: " + periode + "\nGaji Bersih: Rp" + gajiBersih.toLocaleString('id-ID');
    var url = "https://wa.me/?text=" + encodeURIComponent(teks);
    window.open(url, "_blank");
}

// Fungsi share ke Gmail: membuka jendela compose email baru dengan isi otomatis
function shareGmail(nama, jabatan, periode, gajiBersih) {
    // Menanyakan alamat email tujuan lewat popup kecil
    var emailTujuan = prompt("Kirim ke email siapa?");
    if (emailTujuan === null || emailTujuan === "") {
        return; // kalau dibatalkan atau dikosongkan, tidak lanjut
    }

    var subjek = "Slip Gaji - " + nama;
    var isi = "Nama: " + nama + "\nJabatan: " + jabatan + "\nPeriode: " + periode + "\nGaji Bersih: Rp" + gajiBersih.toLocaleString('id-ID');
    var url = "https://mail.google.com/mail/?view=cm&fs=1&to=" + encodeURIComponent(emailTujuan) + "&su=" + encodeURIComponent(subjek) + "&body=" + encodeURIComponent(isi);
    window.open(url, "_blank");
}

// Menampilkan popup pilih periode
function bukaPopupPeriode() {
    document.getElementById('popupPeriode').classList.add('tampil');
}

// Menyembunyikan popup pilih periode
function tutupPopupPeriode() {
    document.getElementById('popupPeriode').classList.remove('tampil');
}

// Setelah bulan & tahun dipilih, lanjut ke halaman form tambah data
function lanjutKeForm() {
    var bulan = document.getElementById('pilihBulan').value;
    var tahun = document.getElementById('pilihTahun').value;
    window.location.href = "tambah.php?bulan=" + bulan + "&tahun=" + tahun;
}
</script>

</body>
</html>

<?php
// Session dipakai untuk mengingat siapa yang sedang login
session_start();

// Kalau user sudah login, langsung lempar ke dashboard
if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - SlipGaji</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="center-page">
    <div class="card-login">
        <h1 class="logo-app" style="font-size:20px;">MASUK</h1>
        <p class="subtitle">Silahkan masukkan username dan password</p>

        <?php
        // Menampilkan pesan error kalau login gagal
        if (isset($_GET['error'])) {
            echo '<div class="alert alert-error">Username atau password salah!</div>';
        }
        // Menampilkan pesan sukses setelah reset password
        if (isset($_GET['reset'])) {
            echo '<div class="alert alert-success">Password berhasil diubah, silakan login.</div>';
        }
        ?>

        <form action="proses_login.php" method="POST">
            <div class="form-group">
                <label>EMAIL</label>
                <input type="text" name="username" placeholder="Masukkan email/username" required>
            </div>
            <div class="form-group">
                <label>SANDI</label>
                <div style="position:relative;">
    <input type="password" name="password" id="inputSandi" placeholder="Masukkan sandi" required style="padding-right:40px;">
    <span onclick="toggleSandi()" id="ikonMata" style="position:absolute; right:12px; top:9px; cursor:pointer; user-select:none;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#888" stroke-width="2">
            <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/>
            <circle cx="12" cy="12" r="3"/>
        </svg>
    </span>
</div>
            </div>

            <p style="text-align:right; margin-bottom:18px;">
                <a href="lupa_password.php" style="color:#7c4dff; font-size:13px;">LUPA KATA SANDI</a>
            </p>

            <button type="submit" class="btn">LOGIN</button>
        </form>
    </div>
</div>

<script>
// Menampilkan/menyembunyikan tulisan sandi saat ikon mata diklik
function toggleSandi() {
    var input = document.getElementById('inputSandi');
    var ikon = document.getElementById('ikonMata');

    if (input.type === 'password') {
        input.type = 'text';
        // Ganti jadi ikon mata dicoret (sandi sedang terlihat)
        ikon.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#888" stroke-width="2"><path d="M17.94 17.94A10.94 10.94 0 0 1 12 19c-7 0-11-7-11-7a18.5 18.5 0 0 1 5.06-5.94M9.9 4.24A10.94 10.94 0 0 1 12 4c7 0 11 7 11 7a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>';
    } else {
        input.type = 'password';
        // Balik lagi ke ikon mata biasa (sandi disembunyikan)
        ikon.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#888" stroke-width="2"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/><circle cx="12" cy="12" r="3"/></svg>';
    }
}
</script>

</body>
</html>

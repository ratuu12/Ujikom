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
                    <span onclick="toggleSandi()" style="position:absolute; right:12px; top:11px; cursor:pointer; font-size:16px;">👁</span>
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
    input.type = (input.type === 'password') ? 'text' : 'password';
}
</script>

</body>
</html>

<?php
session_start();

// Kalau belum melewati proses cek email, tidak boleh buka halaman ini langsung
if (!isset($_SESSION['email_reset'])) {
    header("Location: lupa_password.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password - SlipGaji</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="center-page">
    <div class="card-login">
        <h1 class="logo-app">Buat Password Baru</h1>
        <p class="subtitle">Untuk akun: <?php echo $_SESSION['email_reset']; ?></p>

        <form action="proses_reset_password.php" method="POST">
            <div class="form-group">
                <label>Password Baru</label>
                <input type="password" name="password_baru" placeholder="Masukkan password baru" required>
            </div>
            <button type="submit" class="btn">Simpan Password</button>
        </form>
    </div>
</div>

</body>
</html>

<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lupa Password - SlipGaji</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="center-page">
    <div class="card-login">
        <h1 class="logo-app">Lupa Kata Sandi</h1>
        <p class="subtitle">Masukkan email akun kamu</p>

        <?php
        if (isset($_GET['error'])) {
            echo '<div class="alert alert-error">Email tidak ditemukan!</div>';
        }
        ?>

        <form action="proses_lupa_password.php" method="POST">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="Masukkan email terdaftar" required>
            </div>
            <button type="submit" class="btn">Cari Akun</button>
        </form>

        <p class="link-center">
            <a href="login.php">Kembali ke Login</a>
        </p>
    </div>
</div>

</body>
</html>

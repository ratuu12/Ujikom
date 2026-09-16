<?php
// Menghapus semua session (keluar dari akun)
session_start();
session_destroy();
header("Location: login.php");
exit;
?>

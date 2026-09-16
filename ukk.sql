-- File ini dipakai untuk membuat database "ukk" beserta tabelnya
-- Cara pakai: buka phpMyAdmin (dari Laragon) -> klik menu Import -> pilih file ini -> klik Go

CREATE DATABASE IF NOT EXISTS ukk;
USE ukk;

-- Tabel untuk menyimpan akun login
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL
);

-- Tabel untuk menyimpan data slip gaji
CREATE TABLE gaji (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    nik VARCHAR(30) NOT NULL,
    jabatan VARCHAR(50) NOT NULL,
    periode VARCHAR(100) NOT NULL,
    gaji_pokok INT NOT NULL,
    lembur INT NOT NULL,
    pinjaman INT NOT NULL,
    total_penghasilan INT NOT NULL,
    total_potongan INT NOT NULL,
    gaji_bersih INT NOT NULL
);

-- Akun default untuk login
-- Username : admin
-- Password : admin123
-- (password di bawah sudah dalam bentuk terenkripsi/hash dari "admin123")
INSERT INTO users (username, password, email) VALUES
('admin', '$2y$10$g6gudXbvYa.XxFlb3.Kjb.Zd/RBcu5BBzVWeooxTOAZn/AXquD5.C', 'admin@gmail.com');

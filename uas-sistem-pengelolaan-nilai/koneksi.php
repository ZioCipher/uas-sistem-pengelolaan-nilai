<?php
// Pengaturan koneksi ke database
$host = "localhost";
$user = "root";
$pass = ""; // Biarkan kosong seperti ini
$db   = "db_nilai_kuliah"; // Nama database yang sudah kamu buat

// Membuat hubungan
$koneksi = mysqli_connect($host, $user, $pass, $db);

// Cek jika gagal terhubung
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
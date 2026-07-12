<?php
//Memulai sesi yang sedang berjalan
session_start();

//Menghapus semua data sesi login
session_unset();
session_destroy();

//langsung kembali ke halaman login
header("location: index.php");
exit;
?>
<?php
include "koneksi.php"; //[cite: 4]
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    mysqli_query($koneksi, "DELETE FROM nilai WHERE id_nilai = '$id'"); //[cite: 2]
    header("Location: nilai.php"); //[cite: 8]
    exit;
}
?>
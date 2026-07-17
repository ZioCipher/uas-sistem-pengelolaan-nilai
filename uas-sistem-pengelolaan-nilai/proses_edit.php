<?php
include "koneksi.php"; //[cite: 4]
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $tugas = $_POST['tugas'];
    $uts = $_POST['uts'];
    $uas = $_POST['uas'];

    // Update data ke database[cite: 2]
    mysqli_query($koneksi, "UPDATE nilai SET nilai_tugas='$tugas', nilai_uts='$uts', nilai_uas='$uas' WHERE id_nilai='$id'");
    
    header("Location: nilai.php"); //[cite: 8]
    exit;
}
?>
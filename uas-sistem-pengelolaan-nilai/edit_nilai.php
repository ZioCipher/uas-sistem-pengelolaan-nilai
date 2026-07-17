<?php
include "koneksi.php"; //[cite: 4]
$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM nilai WHERE id_nilai = '$id'"); //[cite: 2]
$d = mysqli_fetch_array($query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Nilai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">
    <h3>Edit Data Nilai</h3>
    <form action="proses_edit.php" method="POST">
        <input type="hidden" name="id" value="<?= $d['id_nilai']; ?>">
        <div class="mb-3">
            <label>Nilai Tugas</label>
            <input type="number" name="tugas" class="form-control" value="<?= $d['nilai_tugas']; ?>" required>
        </div>
        <div class="mb-3">
            <label>Nilai UTS</label>
            <input type="number" name="uts" class="form-control" value="<?= $d['nilai_uts']; ?>" required>
        </div>
        <div class="mb-3">
            <label>Nilai UAS</label>
            <input type="number" name="uas" class="form-control" value="<?= $d['nilai_uas']; ?>" required>
        </div>
        <button type="submit" name="update" class="btn btn-primary">Simpan Perubahan</button>
        <a href="nilai.php" class="btn btn-secondary">Kembali</a>
    </form>
</body>
</html>
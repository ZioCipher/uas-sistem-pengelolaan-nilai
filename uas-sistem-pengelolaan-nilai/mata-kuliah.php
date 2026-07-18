<?php 
session_start();
if (!isset($_SESSION['login'])){
    header("Location: index.php");
    exit;
}
include "koneksi.php"; 

// Logika Simpan Data
if (isset($_POST['simpan'])) {
    $kode = $_POST['kode_mk'];
    $nama = $_POST['nama_mk'];
    $sks = $_POST['sks'];
    $dosen = $_POST['dosen_pengampu'];
    $sem = $_POST['semester'];
    mysqli_query($koneksi, "INSERT INTO mata_kuliah (kode_mk, nama_mk, sks, dosen_pengampu, semester) VALUES ('$kode', '$nama', '$sks', '$dosen', '$sem')");
    echo "<script>window.location='mata-kuliah.php';</script>";
}

// Logika Update Data
if (isset($_POST['update'])) {
    $id = $_POST['id_mata_kuliah'];
    $kode = $_POST['kode_mk'];
    $nama = $_POST['nama_mk'];
    $sks = $_POST['sks'];
    $dosen = $_POST['dosen_pengampu'];
    $sem = $_POST['semester'];
    mysqli_query($koneksi, "UPDATE mata_kuliah SET kode_mk='$kode', nama_mk='$nama', sks='$sks', dosen_pengampu='$dosen', semester='$sem' WHERE id_mata_kuliah='$id'");
    echo "<script>window.location='mata-kuliah.php';</script>";
}

// Logika Hapus Data
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM mata_kuliah WHERE id_mata_kuliah = '$id'");
    echo "<script>window.location='mata-kuliah.php';</script>";
}

// Logika Ambil Data untuk Edit
$mode_edit = false;
$data_edit = ['id_mata_kuliah'=>'', 'kode_mk'=>'', 'nama_mk'=>'', 'sks'=>'', 'dosen_pengampu'=>'', 'semester'=>''];
if (isset($_GET['edit'])) {
    $mode_edit = true;
    $id = $_GET['edit'];
    $query_edit = mysqli_query($koneksi, "SELECT * FROM mata_kuliah WHERE id_mata_kuliah = '$id'");
    $data_edit = mysqli_fetch_array($query_edit);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Mata Kuliah | Sistem Nilai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar tetap sama -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="dashboard.html">Sistem Nilai Kuliah</a>
            <div class="ms-auto d-flex flex-wrap gap-2">
                <a class="nav-link" href="dashboard.php">Dashboard</a>
                <a class="nav-link" href="mahasiswa.php">Mahasiswa</a>
                <a class="nav-link active" href="mata-kuliah.php">Mata Kuliah</a>
                <a class="nav-link" href="nilai.php">Data Nilai</a>
                <a class="nav-link text-danger" href="logout.php" onclick="return confirm('Keluar?');">Logout</a>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        <h2>Data Mata Kuliah</h2>
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="content-card">
                    <h5 class="section-title mb-3"><?= $mode_edit ? 'Edit Mata Kuliah' : 'Form Mata Kuliah' ?></h5>
                    <form action="" method="POST">
                        <input type="hidden" name="id_mata_kuliah" value="<?= $data_edit['id_mata_kuliah'] ?>">
                        <div class="mb-3">
                            <label>Kode MK</label>
                            <input type="text" name="kode_mk" value="<?= $data_edit['kode_mk'] ?>" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Nama MK</label>
                            <input type="text" name="nama_mk" value="<?= $data_edit['nama_mk'] ?>" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>SKS</label>
                            <select name="sks" class="form-select">
                                <?php foreach([2,3,4] as $s) echo "<option value='$s' ".($data_edit['sks']==$s ? 'selected':'').">$s</option>"; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Dosen</label>
                            <input type="text" name="dosen_pengampu" value="<?= $data_edit['dosen_pengampu'] ?>" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Semester</label>
                            <select name="semester" class="form-select">
                                <?php for($i=1; $i<=8; $i++) echo "<option value='$i' ".($data_edit['semester']==$i ? 'selected':'').">$i</option>"; ?>
                            </select>
                        </div>
                        <div class="d-grid gap-2">
                            <?php if($mode_edit): ?>
                                <button type="submit" name="update" class="btn btn-warning">Update Data</button>
                                <a href="mata-kuliah.php" class="btn btn-secondary">Batal</a>
                            <?php else: ?>
                                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="content-card">
                    <table class="table table-hover">
                        <thead>
                            <tr><th>No</th><th>Kode</th><th>Nama</th><th>SKS</th><th>Dosen</th><th>Semester</th><th>Aksi</th></tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $query = mysqli_query($koneksi, "SELECT * FROM mata_kuliah");
                            while($data = mysqli_fetch_array($query)) {
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $data['kode_mk']; ?></td>
                                <td><?= $data['nama_mk']; ?></td>
                                <td><?= $data['sks']; ?></td>
                                <td><?= $data['dosen_pengampu']; ?></td>
                                <td><?= $data['semester']; ?></td>
                                <td>
                                    <a href="mata-kuliah.php?edit=<?= $data['id_mata_kuliah']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="mata-kuliah.php?hapus=<?= $data['id_mata_kuliah']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus?');">Hapus</a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
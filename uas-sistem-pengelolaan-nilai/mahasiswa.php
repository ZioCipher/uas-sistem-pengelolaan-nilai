<?php 
session_start();
if (!isset($_SESSION['login'])){
    header("Location: index.php");
    exit;
}
include "koneksi.php"; 

// Logika Simpan Data
if (isset($_POST['simpan'])) {
    $nim = $_POST['nim'];
    $nama = $_POST['nama_mahasiswa'];
    $jk = $_POST['jenis_kelamin'];
    $prodi = $_POST['prodi'];
    $sem = $_POST['semester'];
    $hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];
    mysqli_query($koneksi, "INSERT INTO mahasiswa (nim, nama_mahasiswa, jenis_kelamin, prodi, semester, no_hp, alamat) VALUES ('$nim', '$nama', '$jk', '$prodi', '$sem', '$hp', '$alamat')");
    echo "<script>window.location='mahasiswa.php';</script>";
}

// Logika Update Data
if (isset($_POST['update'])) {
    $id = $_POST['id_mahasiswa'];
    $nim = $_POST['nim'];
    $nama = $_POST['nama_mahasiswa'];
    $jk = $_POST['jenis_kelamin'];
    $prodi = $_POST['prodi'];
    $sem = $_POST['semester'];
    $hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];
    mysqli_query($koneksi, "UPDATE mahasiswa SET nim='$nim', nama_mahasiswa='$nama', jenis_kelamin='$jk', prodi='$prodi', semester='$sem', no_hp='$hp', alamat='$alamat' WHERE id_mahasiswa='$id'");
    echo "<script>window.location='mahasiswa.php';</script>";
}

// Logika Hapus Data
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM mahasiswa WHERE id_mahasiswa = '$id'");
    echo "<script>window.location='mahasiswa.php';</script>";
}

// Logika Ambil Data untuk Edit
$mode_edit = false;
$data_edit = ['id_mahasiswa'=>'', 'nim'=>'', 'nama_mahasiswa'=>'', 'jenis_kelamin'=>'', 'prodi'=>'', 'semester'=>'', 'no_hp'=>'', 'alamat'=>''];
if (isset($_GET['edit'])) {
    $mode_edit = true;
    $id = $_GET['edit'];
    $query_edit = mysqli_query($koneksi, "SELECT * FROM mahasiswa WHERE id_mahasiswa = '$id'");
    $data_edit = mysqli_fetch_array($query_edit);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Mahasiswa | Sistem Nilai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="dashboard.html">Sistem Nilai Kuliah</a>
            <div class="ms-auto d-flex flex-wrap gap-2">
                <a class="nav-link" href="dashboard.php">Dashboard</a>
                <a class="nav-link active" href="mahasiswa.php">Mahasiswa</a>
                <a class="nav-link" href="mata-kuliah.php">Mata Kuliah</a>
                <a class="nav-link text-danger" href="logout.php" onclick="return confirm('Keluar?');">Logout</a>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        <h2>Data Mahasiswa</h2>
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="content-card">
                    <h5 class="section-title mb-3"><?= $mode_edit ? 'Edit Mahasiswa' : 'Form Mahasiswa' ?></h5>
                    <form action="" method="POST">
                        <input type="hidden" name="id_mahasiswa" value="<?= $data_edit['id_mahasiswa'] ?>">
                        <div class="mb-3">
                            <label>NIM</label>
                            <input type="text" name="nim" value="<?= $data_edit['nim'] ?>" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Nama Mahasiswa</label>
                            <input type="text" name="nama_mahasiswa" value="<?= $data_edit['nama_mahasiswa'] ?>" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select">
                                <option value="Laki-laki" <?= $data_edit['jenis_kelamin']=='Laki-laki' ? 'selected':'' ?>>Laki-laki</option>
                                <option value="Perempuan" <?= $data_edit['jenis_kelamin']=='Perempuan' ? 'selected':'' ?>>Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Program Studi</label>
                            <input type="text" name="prodi" value="<?= $data_edit['prodi'] ?>" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Semester</label>
                            <select name="semester" class="form-select">
                                <?php for($i=1; $i<=8; $i++) echo "<option value='$i' ".($data_edit['semester']==$i ? 'selected':'').">$i</option>"; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>No. HP</label>
                            <input type="text" name="no_hp" value="<?= $data_edit['no_hp'] ?>" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Alamat</label>
                            <textarea name="alamat" class="form-control" rows="2" required><?= $data_edit['alamat'] ?></textarea>
                        </div>
                        <div class="d-grid gap-2">
                            <?php if($mode_edit): ?>
                                <button type="submit" name="update" class="btn btn-warning">Update Data</button>
                                <a href="mahasiswa.php" class="btn btn-secondary">Batal</a>
                            <?php else: ?>
                                <button type="submit" name="simpan" class="btn btn-primary">Simpan Data</button>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="content-card">
                    <table class="table table-hover">
                        <thead>
                            <tr><th>No</th><th>NIM</th><th>Nama</th><th>Prodi</th><th>Sem</th><th>JK</th><th>Aksi</th></tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $query = mysqli_query($koneksi, "SELECT * FROM mahasiswa");
                            while($data = mysqli_fetch_array($query)) {
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $data['nim']; ?></td>
                                <td><?= $data['nama_mahasiswa']; ?></td>
                                <td><?= $data['prodi']; ?></td>
                                <td><?= $data['semester']; ?></td>
                                <td><?= $data['jenis_kelamin']; ?></td>
                                <td>
                                    <a href="mahasiswa.php?edit=<?= $data['id_mahasiswa']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="mahasiswa.php?hapus=<?= $data['id_mahasiswa']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus?');">Hapus</a>
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
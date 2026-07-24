<?php 
// MULAI SESI PENGELOLAAN AKUN
session_start();
// VALIDASI AKSES: HARUS SUDAH LOGIN
if (!isset($_SESSION['login'])){
    header("Location: index.php");
    exit;
}
// HUBUNGKAN KE PANGKALAN DATA
include "koneksi.php"; 

// === PROSES PENGINPUTAN DAN PERUBAHAN DATA ===
if(isset($_POST['simpan'])){
    $nim = trim($_POST['nim']);
    $nama = trim($_POST['nama_mahasiswa']);
    $jk = $_POST['jenis_kelamin'];
    $prodi = trim($_POST['prodi']);
    $semester = $_POST['semester'];
    $hp = trim($_POST['no_hp']);
    $alamat = trim($_POST['alamat']);
    $id = $_POST['id_mahasiswa'];

    // PERIKSA KEUNGGULAN NIM AGAR TIDAK GANDA
    $cek = mysqli_query($koneksi, "SELECT * FROM mahasiswa WHERE nim='$nim' AND id_mahasiswa!='$id'");
    if(mysqli_num_rows($cek) > 0){
        echo "<script>alert('NIM SUDAH TERDAFTAR! GUNAKAN NIM LAIN.'); history.back();</script>";
        exit;
    }

    if(!empty($id)){
        // MEMPERBARUI DATA YANG SUDAH ADA
        mysqli_query($koneksi, "UPDATE mahasiswa SET 
            nim='$nim', nama_mahasiswa='$nama', jenis_kelamin='$jk', prodi='$prodi', 
            semester='$semester', no_hp='$hp', alamat='$alamat' 
            WHERE id_mahasiswa='$id'");
        echo "<script>alert('DATA MAHASISWA BERHASIL DIPERBARUI!'); window.location='mahasiswa.php';</script>";
    }else{
        // MENYIMPAN DATA BARU KE DALAM TABEL
        mysqli_query($koneksi, "INSERT INTO mahasiswa 
            (nim, nama_mahasiswa, jenis_kelamin, prodi, semester, no_hp, alamat) 
            VALUES ('$nim','$nama','$jk','$prodi','$semester','$hp','$alamat')");
        echo "<script>alert('DATA MAHASISWA BERHASIL DISIMPAN!'); window.location='mahasiswa.php';</script>";
    }
}

// === PROSES PENGHAPUSAN DATA ===
if(isset($_GET['hapus'])){
    mysqli_query($koneksi, "DELETE FROM mahasiswa WHERE id_mahasiswa='$_GET[hapus]'");
    echo "<script>alert('DATA MAHASISWA BERHASIL DIHAPUS!'); window.location='mahasiswa.php';</script>";
}

// === MENGAMBIL DATA UNTUK DIPERBAIKI ===
$edit = null;
if(isset($_GET['edit'])){
    $edit = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM mahasiswa WHERE id_mahasiswa='$_GET[edit]'"));
}

// === SISTEM PENCARIAN DATA ===
$cari = isset($_GET['cari']) ? trim($_GET['cari']) : '';
$where = "";
if(!empty($cari)){
    $where = "WHERE nim LIKE '%$cari%' OR nama_mahasiswa LIKE '%$cari%'";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa | Sistem Nilai Mata Kuliah</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">Sistem Nilai Kuliah</a>

            <div class="ms-auto d-flex flex-wrap gap-2">
                <a class="nav-link" href="dashboard.php">Dashboard</a>
                <a class="nav-link active" href="mahasiswa.php">Mahasiswa</a>
                <a class="nav-link" href="mata-kuliah.php">Mata Kuliah</a>
                <a class="nav-link" href="nilai.php">Data Nilai</a>
                <a class="nav-link" href="rekap-nilai.php">Rekap Nilai</a>
                <a class="nav-link text-danger" href="logout.php" onclick="return confirm('Apakah kamu yakin ingin keluar dari sistem?');">Logout</a>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        <section class="page-header">
            <h2>Data Mahasiswa</h2>
            <p class="mb-0">Kelola data mahasiswa untuk kebutuhan input nilai mata kuliah.</p>
        </section>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="content-card">
                    <h5 class="section-title mb-3"><?= $edit ? 'Ubah Data Mahasiswa' : 'Form Mahasiswa' ?></h5>

                    <form method="POST" action="">
                        <input type="hidden" name="id_mahasiswa" value="<?= $edit['id_mahasiswa'] ?? '' ?>">

                        <div class="mb-3">
                            <label class="form-label">NIM</label>
                            <input type="text" name="nim" class="form-control" placeholder="Masukkan NIM" required value="<?= $edit['nim'] ?? '' ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Mahasiswa</label>
                            <input type="text" name="nama_mahasiswa" class="form-control" placeholder="Masukkan nama mahasiswa" required value="<?= $edit['nama_mahasiswa'] ?? '' ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="">Pilih jenis kelamin</option>
                                <option value="Laki-laki" <?= (isset($edit['jenis_kelamin']) && $edit['jenis_kelamin']=='Laki-laki')?'selected':'' ?>>Laki-laki</option>
                                <option value="Perempuan" <?= (isset($edit['jenis_kelamin']) && $edit['jenis_kelamin']=='Perempuan')?'selected':'' ?>>Perempuan</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Program Studi</label>
                            <input type="text" name="prodi" class="form-control" value="<?= $edit['prodi'] ?? 'PTI' ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Semester</label>
                            <select name="semester" class="form-select" required>
                                <option value="">Pilih Semester</option>
                                <?php for($i=1; $i<=8; $i++): ?>
                                <option value="<?= $i ?>" <?= (isset($edit['semester']) && $edit['semester']==$i)?'selected':'' ?>><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">No. HP</label>
                            <input type="text" name="no_hp" class="form-control" placeholder="Masukkan nomor HP" value="<?= $edit['no_hp'] ?? '' ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat"><?= $edit['alamat'] ?? '' ?></textarea>
                        </div>

                        <div class="d-grid gap-2">
                            <button name="simpan" class="btn <?= $edit ? 'btn-success' : 'btn-primary' ?>" type="submit">
                                <?= $edit ? 'Perbarui Data' : 'Simpan Data' ?>
                            </button>
                            <?php if($edit): ?>
                                <a href="mahasiswa.php" class="btn btn-outline-secondary">Batal Ubah</a>
                            <?php else: ?>
                                <button class="btn btn-outline-secondary" type="reset">Reset Form</button>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="content-card">
                    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-3">
                        <h5 class="section-title mb-0">Daftar Mahasiswa</h5>

                        <form class="d-flex gap-2" method="GET" action="">
                            <input type="text" name="cari" class="form-control" placeholder="Cari nama atau NIM" value="<?= $cari ?>">
                            <button class="btn btn-primary" type="submit">Cari</button>
                            <?php if(!empty($cari)): ?>
                            <a href="mahasiswa.php" class="btn btn-outline-secondary">Reset</a>
                            <?php endif; ?>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Prodi</th>
                                    <th>Semester</th>
                                    <th>JK</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                $tampil = mysqli_query($koneksi, "SELECT * FROM mahasiswa $where ORDER BY nama_mahasiswa");
                                if(mysqli_num_rows($tampil) > 0):
                                    while($r = mysqli_fetch_assoc($tampil)):
                                ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $r['nim']; ?></td>
                                    <td><?= $r['nama_mahasiswa']; ?></td>
                                    <td><?= $r['prodi']; ?></td>
                                    <td><?= $r['semester']; ?></td>
                                    <td><?= substr($r['jenis_kelamin'],0,1); ?></td>
                                    <td>
                                        <a href="mahasiswa.php?edit=<?= $r['id_mahasiswa']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="mahasiswa.php?hapus=<?= $r['id_mahasiswa']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('YAKIN INGIN MENGHAPUS DATA INI?');">Hapus</a>
                                    </td>
                                </tr>
                                <?php endwhile; else: ?>
                                <tr><td colspan="7" class="text-center text-muted py-3">Data tidak ditemukan atau belum ada data.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>
</html>
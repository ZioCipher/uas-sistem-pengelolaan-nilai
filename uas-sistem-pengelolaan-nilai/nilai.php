<?php 
session_start();
if (!isset($_SESSION['login'])){
    header("Location: index.php");
    exit;
}
include "koneksi.php"; 

// --- PROSES SIMPAN / UBAH DATA ---
if(isset($_POST['simpan'])){
    $id_mahasiswa = $_POST['id_mahasiswa'];
    $id_mata_kuliah = $_POST['id_mata_kuliah'];
    $tahun = $_POST['tahun_akademik'];
    $semester = $_POST['semester_akademik'];
    $tugas = $_POST['nilai_tugas'];
    $uts = $_POST['nilai_uts'];
    $uas = $_POST['nilai_uas'];
    $id_nilai = $_POST['id_nilai'];

    // PENGECEKAN DATA GANDA
    $cek = mysqli_query($koneksi, "SELECT * FROM nilai WHERE id_mahasiswa='$id_mahasiswa' AND id_mata_kuliah='$id_mata_kuliah' AND tahun_akademik='$tahun' AND semester_akademik='$semester' AND id_nilai != '$id_nilai'");
    if(mysqli_num_rows($cek) > 0){
        echo "<script>alert('DATA NILAI UNTUK MAHASISWA, MATA KULIAH, TAHUN & SEMESTER TERSEBUT SUDAH ADA!'); history.back();</script>";
        exit;
    }

    if(!empty($id_nilai)){
        // --- PROSES UBAH DATA ---
        $ubah = mysqli_query($koneksi, "UPDATE nilai SET id_mahasiswa='$id_mahasiswa', id_mata_kuliah='$id_mata_kuliah', tahun_akademik='$tahun', semester_akademik='$semester', nilai_tugas='$tugas', nilai_uts='$uts', nilai_uas='$uas' WHERE id_nilai='$id_nilai'");
        if($ubah){
            echo "<script>alert('DATA NILAI BERHASIL DIPERBARUI!'); window.location='nilai.php';</script>";
        } else {
            echo "<script>alert('GAGAL MEMPERBARUI DATA NILAI!'); history.back();</script>";
        }
    } else {
        // --- PROSES TAMBAH DATA BARU ---
        $simpan = mysqli_query($koneksi, "INSERT INTO nilai (id_mahasiswa, id_mata_kuliah, tahun_akademik, semester_akademik, nilai_tugas, nilai_uts, nilai_uas) VALUES ('$id_mahasiswa', '$id_mata_kuliah', '$tahun', '$semester', '$tugas', '$uts', '$uas')");
        if($simpan){
            echo "<script>alert('DATA NILAI BERHASIL DISIMPAN!'); window.location='nilai.php';</script>";
        } else {
            echo "<script>alert('GAGAL MENYIMPAN DATA NILAI!'); history.back();</script>";
        }
    }
}

// --- PROSES HAPUS DATA ---
if(isset($_GET['hapus'])){
    $id_hapus = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM nilai WHERE id_nilai='$id_hapus'");
    echo "<script>alert('DATA NILAI BERHASIL DIHAPUS!'); window.location='nilai.php';</script>";
}

// --- AMBIL DATA UNTUK DIEDIT ---
$edit = null;
if(isset($_GET['edit'])){
    $id_edit = $_GET['edit'];
    $ambil = mysqli_query($koneksi, "SELECT * FROM nilai WHERE id_nilai='$id_edit'");
    $edit = mysqli_fetch_assoc($ambil);
}

// --- FITUR PENCARIAN ---
$cari = isset($_GET['cari']) ? trim($_GET['cari']) : '';
$where = "";
if(!empty($cari)){
    $where = "WHERE nama_mahasiswa LIKE '%$cari%' OR nim LIKE '%$cari%'";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Nilai | Sistem Nilai Mata Kuliah</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">Sistem Nilai Kuliah</a>

            <div class="ms-auto d-flex flex-wrap gap-2">
                <a class="nav-link" href="dashboard.php">Dashboard</a>
                <a class="nav-link" href="mahasiswa.php">Mahasiswa</a>
                <a class="nav-link" href="mata-kuliah.php">Mata Kuliah</a>
                <a class="nav-link active" href="nilai.php">Data Nilai</a>
                <a class="nav-link" href="rekap-nilai.php">Rekap Nilai</a>
                <a class="nav-link text-danger" href="logout.php" onclick="return confirm('Apakah kamu yakin ingin keluar dari sistem?');">Logout</a>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        <section class="page-header">
            <h2>Input dan Kelola Nilai Mahasiswa</h2>
            <p class="mb-0">
                Input nilai tugas, UTS, dan UAS. Nilai akhir dihitung dengan formula 20%, 30%, dan 50%.
            </p>
        </section>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="content-card">
                    <h5 class="section-title mb-3"><?= $edit ? 'Ubah Data Nilai' : 'Form Input Nilai' ?></h5>

                    <form method="POST" action="">
                        <input type="hidden" name="id_nilai" value="<?= $edit['id_nilai'] ?? '' ?>">

                        <div class="mb-3">
                            <label class="form-label">Mahasiswa</label>
                            <select name="id_mahasiswa" class="form-select" required <?= $edit ? 'disabled' : '' ?>>
                                <option value="">Pilih mahasiswa</option>
                                <?php 
                                $q_mhs = mysqli_query($koneksi, "SELECT * FROM mahasiswa ORDER BY nama_mahasiswa");
                                while($d_mhs = mysqli_fetch_assoc($q_mhs)){
                                    $pilih = (isset($edit['id_mahasiswa']) && $edit['id_mahasiswa'] == $d_mhs['id_mahasiswa']) ? 'selected' : '';
                                    echo "<option value='".$d_mhs['id_mahasiswa']."' $pilih>".$d_mhs['nim']." - ".$d_mhs['nama_mahasiswa']."</option>";
                                }
                                ?>
                            </select>
                            <?php if($edit): ?>
                                <input type="hidden" name="id_mahasiswa" value="<?= $edit['id_mahasiswa'] ?>">
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mata Kuliah</label>
                            <select name="id_mata_kuliah" class="form-select" required <?= $edit ? 'disabled' : '' ?>>
                                <option value="">Pilih mata kuliah</option>
                                <?php 
                                $q_mk = mysqli_query($koneksi, "SELECT * FROM mata_kuliah ORDER BY nama_mk");
                                while($d_mk = mysqli_fetch_assoc($q_mk)){
                                    $pilih = (isset($edit['id_mata_kuliah']) && $edit['id_mata_kuliah'] == $d_mk['id_mata_kuliah']) ? 'selected' : '';
                                    echo "<option value='".$d_mk['id_mata_kuliah']."' $pilih>".$d_mk['kode_mk']." - ".$d_mk['nama_mk']."</option>";
                                }
                                ?>
                            </select>
                            <?php if($edit): ?>
                                <input type="hidden" name="id_mata_kuliah" value="<?= $edit['id_mata_kuliah'] ?>">
                            <?php endif; ?>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tahun Akademik</label>
                                <input name="tahun_akademik" type="text" class="form-control" value="<?= $edit['tahun_akademik'] ?? '2025/2026' ?>" required <?= $edit ? 'readonly' : '' ?>>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Semester</label>
                                <select name="semester_akademik" class="form-select" required <?= $edit ? 'disabled' : '' ?>>
                                    <option value="Ganjil" <?= (isset($edit['semester_akademik']) && $edit['semester_akademik']=='Ganjil')?'selected':'' ?>>Ganjil</option>
                                    <option value="Genap" <?= (isset($edit['semester_akademik']) && $edit['semester_akademik']=='Genap')?'selected':'' ?>>Genap</option>
                                </select>
                                <?php if($edit): ?>
                                    <input type="hidden" name="semester_akademik" value="<?= $edit['semester_akademik'] ?>">
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nilai Tugas</label>
                            <input name="nilai_tugas" type="number" min="0" max="100" class="form-control" placeholder="0 - 100" value="<?= $edit['nilai_tugas'] ?? '' ?>" required>
                            <div class="form-text">Bobot 20%</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nilai UTS</label>
                            <input name="nilai_uts" type="number" min="0" max="100" class="form-control" placeholder="0 - 100" value="<?= $edit['nilai_uts'] ?? '' ?>" required>
                            <div class="form-text">Bobot 30%</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nilai UAS</label>
                            <input name="nilai_uas" type="number" min="0" max="100" class="form-control" placeholder="0 - 100" value="<?= $edit['nilai_uas'] ?? '' ?>" required>
                            <div class="form-text">Bobot 50%</div>
                        </div>

                        <div class="grade-box mb-3">
                            <p class="mb-0 text-success fw-bold">Sistem akan memproses hasil akhir secara otomatis setelah data disimpan.</p>
                        </div>

                        <div class="d-grid gap-2">
                            <button name="simpan" class="btn <?= $edit ? 'btn-success' : 'btn-primary' ?>" type="submit">
                                <?= $edit ? 'Perbarui Nilai' : 'Simpan Nilai' ?>
                            </button>
                            <?php if($edit): ?>
                                <a href="nilai.php" class="btn btn-outline-secondary">Batal Ubah</a>
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
                        <h5 class="section-title mb-0">Daftar Nilai Mahasiswa</h5>

                        <form class="d-flex gap-2" method="GET" action="">
                            <input name="cari" type="text" class="form-control" placeholder="Cari nama atau NIM" value="<?= $cari; ?>">
                            <button class="btn btn-primary" type="submit">Cari</button>
                            <?php if(!empty($cari)): ?>
                                <a href="nilai.php" class="btn btn-outline-secondary">Reset</a>
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
                                    <th>Mata Kuliah</th>
                                    <th>Tugas</th>
                                    <th>UTS</th>
                                    <th>UAS</th>
                                    <th>Akhir</th>
                                    <th>Grade</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                $tampil = mysqli_query($koneksi, "SELECT * FROM view_nilai_lengkap $where ORDER BY id_nilai DESC");
                                if(mysqli_num_rows($tampil) > 0){
                                    while($r = mysqli_fetch_assoc($tampil)){
                                ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $r['nim']; ?></td>
                                    <td><?= $r['nama_mahasiswa']; ?></td>
                                    <td><?= $r['nama_mk']; ?></td>
                                    <td><?= $r['nilai_tugas']; ?></td>
                                    <td><?= $r['nilai_uts']; ?></td>
                                    <td><?= $r['nilai_uas']; ?></td>
                                    <td><?= $r['nilai_akhir']; ?></td>
                                    <td><span class="badge badge-soft-<?= ($r['status_kelulusan']=='Lulus')?'success':'danger'; ?>"><?= $r['grade']; ?></span></td>
                                    <td><span class="badge badge-soft-<?= ($r['status_kelulusan']=='Lulus')?'success':'danger'; ?>"><?= $r['status_kelulusan']; ?></span></td>
                                    <td>
                                        <a href="nilai.php?edit=<?= $r['id_nilai']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="nilai.php?hapus=<?= $r['id_nilai']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin mau hapus data ini?');">Hapus</a>
                                    </td>
                                </tr>
                                <?php 
                                    }
                                } else {
                                    echo "<tr><td colspan='11' class='text-center text-muted py-3'>Data tidak ditemukan atau belum ada data.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <p class="small-muted mb-0">
                        Pada database MySQL, nilai akhir, grade, dan status kelulusan dihitung otomatis melalui generated column.
                    </p>
                </div>
            </div>
        </div>
    </main>

</body>
</html>
<?php 
session_start();
if (!isset($_SESSION['login'])){
    header("Location: index.php");
    exit;
}
include "koneksi.php"; 

// PROSES SIMPAN DATA BARU
if(isset($_POST['simpan'])){
    $kode_mk = trim($_POST['kode_mk']);
    $nama_mk = trim($_POST['nama_mk']);
    $sks = $_POST['sks'];
    $dosen_pengampu = trim($_POST['dosen_pengampu']);
    $semester = $_POST['semester'];

    // Cek Kode MK GANDA
    $cek = mysqli_query($koneksi, "SELECT * FROM mata_kuliah WHERE kode_mk = '$kode_mk'");
    if(mysqli_num_rows($cek) > 0){
        echo "<script>alert('Kode Mata Kuliah SUDAH TERDAFTAR! Gunakan kode lain.'); window.location='mata-kuliah.php'</script>";
    }else{
        mysqli_query($koneksi, "INSERT INTO mata_kuliah (kode_mk, nama_mk, sks, dosen_pengampu, semester) 
                                 VALUES ('$kode_mk', '$nama_mk', '$sks', '$dosen_pengampu', '$semester')");
        echo "<script>alert('Data Mata Kuliah BERHASIL DISIMPAN!'); window.location='mata-kuliah.php'</script>";
    }
}

// PROSES UBAH DATA
if(isset($_POST['ubah'])){
    $id = $_POST['id_mata_kuliah'];
    $kode_mk = trim($_POST['kode_mk']);
    $nama_mk = trim($_POST['nama_mk']);
    $sks = $_POST['sks'];
    $dosen_pengampu = trim($_POST['dosen_pengampu']);
    $semester = $_POST['semester'];

    // Cek Kode MK GANDA KECUALI DIRINYA SENDIRI
    $cek = mysqli_query($koneksi, "SELECT * FROM mata_kuliah WHERE kode_mk = '$kode_mk' AND id_mata_kuliah != '$id'");
    if(mysqli_num_rows($cek) > 0){
        echo "<script>alert('Kode Mata Kuliah SUDAH ADA di data lain!'); window.location='mata-kuliah.php'</script>";
    }else{
        mysqli_query($koneksi, "UPDATE mata_kuliah SET 
                                 kode_mk = '$kode_mk', nama_mk = '$nama_mk', sks = '$sks', 
                                 dosen_pengampu = '$dosen_pengampu', semester = '$semester' 
                                 WHERE id_mata_kuliah = '$id'");
        echo "<script>alert('DATA BERHASIL DIPERBARUI!'); window.location='mata-kuliah.php'</script>";
    }
}

// PROSES HAPUS DATA
if(isset($_GET['hapus'])){
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM mata_kuliah WHERE id_mata_kuliah = '$id'");
    echo "<script>alert('Data BERHASIL DIHAPUS!'); window.location='mata-kuliah.php'</script>";
}

// PROSES PENCARIAN
$cari = "";
if(isset($_GET['cari']) && !empty(trim($_GET['cari']))){
    $cari = trim($_GET['cari']);
    $query = "SELECT * FROM mata_kuliah 
              WHERE kode_mk LIKE '%$cari%' OR nama_mk LIKE '%$cari%' OR dosen_pengampu LIKE '%$cari%' 
              ORDER BY nama_mk ASC";
}else{
    $query = "SELECT * FROM mata_kuliah ORDER BY nama_mk ASC";
}
$ambil = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mata Kuliah | Sistem Nilai Mata Kuliah</title>

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
                <a class="nav-link active" href="mata-kuliah.php">Mata Kuliah</a>
                <a class="nav-link" href="nilai.php">Data Nilai</a>
                <a class="nav-link" href="rekap-nilai.php">Rekap Nilai</a>
                <a class="nav-link text-danger" href="logout.php" onclick="return confirm('Apakah kamu yakin ingin keluar dari sistem?');">Logout</a>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        <section class="page-header">
            <h2>Data Mata Kuliah</h2>
            <p class="mb-0">Kelola data mata kuliah yang digunakan pada input nilai mahasiswa.</p>
        </section>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="content-card">
                    <h5 class="section-title mb-3" id="judul-form">Form Mata Kuliah</h5>

                    <form method="POST" action="">
                        <input type="hidden" name="id_mata_kuliah" id="id_mata_kuliah">

                        <div class="mb-3">
                            <label class="form-label">Kode Mata Kuliah</label>
                            <input type="text" name="kode_mk" id="kode_mk" class="form-control" placeholder="Contoh: PTI301" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Mata Kuliah</label>
                            <input type="text" name="nama_mk" id="nama_mk" class="form-control" placeholder="Contoh: Pemrograman Web" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">SKS</label>
                            <select name="sks" id="sks" class="form-select" required>
                                <option value="">-- Pilih SKS --</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Dosen Pengampu</label>
                            <input type="text" name="dosen_pengampu" id="dosen_pengampu" class="form-control" placeholder="Nama lengkap dosen">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Semester</label>
                            <select name="semester" id="semester" class="form-select" required>
                                <option value="">-- Pilih Semester --</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2">
                            <button class="btn btn-primary" type="submit" name="simpan" id="btn-aksi">Simpan Mata Kuliah</button>
                            <button class="btn btn-outline-secondary" type="reset" id="btn-reset">Reset Form</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="content-card">
                    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-3">
                        <h5 class="section-title mb-0">Daftar Mata Kuliah</h5>

                        <form class="d-flex gap-2" method="GET" action="">
                            <input type="text" name="cari" class="form-control" placeholder="Cari kode atau nama MK..." value="<?= $cari ?>">
                            <button class="btn btn-primary" type="submit">Cari</button>
                            <?php if(!empty($cari)){ ?>
                            <a href="mata-kuliah.php" class="btn btn-outline-secondary">Reset</a>
                            <?php } ?>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="12%">Kode MK</th>
                                    <th>Nama Mata Kuliah</th>
                                    <th width="8%">SKS</th>
                                    <th>Dosen Pengampu</th>
                                    <th width="10%">Semester</th>
                                    <th width="13%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                while($data = mysqli_fetch_assoc($ambil)){
                                ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= $data['kode_mk'] ?></td>
                                    <td><?= $data['nama_mk'] ?></td>
                                    <td><?= $data['sks'] ?></td>
                                    <td><?= $data['dosen_pengampu'] ?></td>
                                    <td><?= $data['semester'] ?></td>
                                    <td>
                                        <a href="#" 
                                           onclick="editData(
                                               '<?= $data['id_mata_kuliah'] ?>',
                                               '<?= $data['kode_mk'] ?>',
                                               '<?= $data['nama_mk'] ?>',
                                               '<?= $data['sks'] ?>',
                                               '<?= $data['dosen_pengampu'] ?>',
                                               '<?= $data['semester'] ?>'
                                           )" 
                                           class="btn btn-sm btn-warning me-1">Edit</a>
                                        
                                        <a href="mata-kuliah.php?hapus=<?= $data['id_mata_kuliah'] ?>" 
                                           onclick="return confirm('Yakin ingin menghapus data ini?')" 
                                           class="btn btn-sm btn-danger">Hapus</a>
                                    </td>
                                </tr>
                                <?php $no++; } ?>

                                <?php if(mysqli_num_rows($ambil) == 0){ ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        Data mata kuliah tidak ditemukan.
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

<script>
// FUNGSI ISI FORM SAAT KLIK EDIT
function editData(id, kode, nama, sks, dosen, smt){
    document.getElementById('id_mata_kuliah').value = id;
    document.getElementById('kode_mk').value = kode;
    document.getElementById('nama_mk').value = nama;
    document.getElementById('sks').value = sks;
    document.getElementById('dosen_pengampu').value = dosen;
    document.getElementById('semester').value = smt;

    document.getElementById('judul-form').textContent = "Ubah Data Mata Kuliah";
    document.getElementById('btn-aksi').name = "ubah";
    document.getElementById('btn-aksi').textContent = "Perbarui Mata Kuliah";
    document.getElementById('btn-aksi').className = "btn btn-success";

    window.scrollTo({top: 0, behavior: 'smooth'});
}

// KEMBALIKAN KE FORM TAMBAH SAAT RESET
document.querySelector('button[type="reset"]').addEventListener('click', function(){
    setTimeout(() => {
        document.getElementById('judul-form').textContent = "Form Mata Kuliah";
        document.getElementById('btn-aksi').name = "simpan";
        document.getElementById('btn-aksi').textContent = "Simpan Mata Kuliah";
        document.getElementById('btn-aksi').className = "btn btn-primary";
    }, 50);
});
</script>

</body>
</html>
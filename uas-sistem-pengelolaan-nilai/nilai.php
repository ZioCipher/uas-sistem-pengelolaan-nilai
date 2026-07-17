<?php 
// 1. wajib mulai sesi login DULU
session_start();
// 2. Cek apakah sudah login, kalau belum lempar ke login
if (!isset($_SESSION['login'])){
    header("Location: index.php");
    exit;
}
// 3.Baru hubungkan ke database
include "koneksi.php"; ?>
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
            <a class="navbar-brand" href="dashboard.html">Sistem Nilai Kuliah</a>

            <div class="ms-auto d-flex flex-wrap gap-2">
                <a class="nav-link" href="dashboard.php">Dashboard</a>
                <a class="nav-link" href="mahasiswa.php">Mahasiswa</a>
                <a class="nav-link" href="mata-kuliah.php">Mata Kuliah</a>
                <a class="nav-link active" href="nilai.php">Data Nilai</a>
                <a class="nav-link" href="rekap-nilai.php">Rekap Nilai</a>
                <a class="nav-link text-danger" href="logout.php"onclick="return confirm('Apakah kamu yakin ingin keluar dari sistem?');">Logout</a>
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
                    <h5 class="section-title mb-3">Form Input Nilai</h5>

                    <form>
                        <div class="mb-3">
                            <label class="form-label">Mahasiswa</label>
                            <select class="form-select">
                                <option>Pilih mahasiswa</option>
                                <option>230101001 - Ahmad Zikri</option>
                                <option>230101002 - Siti Rahmah</option>
                                <option>230101003 - Muhammad Fajri</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mata Kuliah</label>
                            <select class="form-select">
                                <option>Pilih mata kuliah</option>
                                <option>PTI301 - Pemrograman Web</option>
                                <option>PTI302 - Basis Data</option>
                                <option>PTI303 - Algoritma dan Pemrograman</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tahun Akademik</label>
                                <input type="text" class="form-control" value="2025/2026">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Semester</label>
                                <select class="form-select">
                                    <option selected>Ganjil</option>
                                    <option>Genap</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nilai Tugas</label>
                            <input type="number" class="form-control" placeholder="0 - 100">
                            <div class="form-text">Bobot 20%</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nilai UTS</label>
                            <input type="number" class="form-control" placeholder="0 - 100">
                            <div class="form-text">Bobot 30%</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nilai UAS</label>
                            <input type="number" class="form-control" placeholder="0 - 100">
                            <div class="form-text">Bobot 50%</div>
                        </div>

                        <div class="grade-box mb-3">
                            <strong>Contoh Perhitungan</strong>
                            <p class="mb-1 small-muted mt-2">Tugas 90, UTS 85, UAS 88</p>
                            <p class="mb-0 small-muted">Nilai akhir = 18 + 25.5 + 44 = 87.5</p>
                        </div>

                        <div class="d-grid gap-2">
                            <button class="btn btn-primary" type="button">Simpan Nilai</button>
                            <button class="btn btn-outline-secondary" type="reset">Reset Form</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="content-card">
                    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-3">
                        <h5 class="section-title mb-0">Daftar Nilai Mahasiswa</h5>

                        <form class="d-flex gap-2">
                            <input type="text" class="form-control" placeholder="Cari nama atau NIM">
                            <button class="btn btn-primary" type="button">Cari</button>
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
    // Mengambil data dari view yang sudah dibuat di database[cite: 3]
    $query = mysqli_query($koneksi, "SELECT * FROM view_nilai_lengkap"); 
    while ($d = mysqli_fetch_array($query)) {
    ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $d['nim']; ?></td>
            <td><?= $d['nama_mahasiswa']; ?></td>
            <td><?= $d['nama_mk']; ?></td>
            <td><?= $d['nilai_tugas']; ?></td>
            <td><?= $d['nilai_uts']; ?></td>
            <td><?= $d['nilai_uas']; ?></td>
            <td><?= $d['nilai_akhir']; ?></td>
            <td><span class="badge badge-soft-primary"><?= $d['grade']; ?></span></td>
            <td><span class="badge badge-soft-success"><?= $d['status_kelulusan']; ?></span></td>
            <td>
<td>
    <a href="edit_nilai.php?id=<?= $d['id_nilai']; ?>" class="btn btn-sm btn-warning">Edit</a>
    <a href="hapus_nilai.php?id=<?= $d['id_nilai']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</a>
</td>
            </td>
        </tr>
    <?php } ?>
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

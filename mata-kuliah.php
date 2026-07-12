<?php include "koneksi.php"; ?>
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
            <a class="navbar-brand" href="dashboard.html">Sistem Nilai Kuliah</a>

            <div class="ms-auto d-flex flex-wrap gap-2">
                <a class="nav-link" href="dashboard.php">Dashboard</a>
                <a class="nav-link" href="mahasiswa.php">Mahasiswa</a>
                <a class="nav-link active" href="mata-kuliah.php">Mata Kuliah</a>
                <a class="nav-link" href="nilai.php">Data Nilai</a>
                <a class="nav-link" href="rekap-nilai.php">Rekap Nilai</a>
                <a class="nav-link text-danger" href="#">Logout</a>
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
                    <h5 class="section-title mb-3">Form Mata Kuliah</h5>

                    <form>
                        <div class="mb-3">
                            <label class="form-label">Kode Mata Kuliah</label>
                            <input type="text" class="form-control" placeholder="Contoh: PTI301">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Mata Kuliah</label>
                            <input type="text" class="form-control" placeholder="Contoh: Pemrograman Web">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">SKS</label>
                            <select class="form-select">
                                <option>2</option>
                                <option selected>3</option>
                                <option>4</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Dosen Pengampu</label>
                            <input type="text" class="form-control" placeholder="Nama dosen pengampu">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Semester</label>
                            <select class="form-select">
                                <option>1</option>
                                <option>2</option>
                                <option selected>3</option>
                                <option>4</option>
                                <option>5</option>
                                <option>6</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2">
                            <button class="btn btn-primary" type="button">Simpan Mata Kuliah</button>
                            <button class="btn btn-outline-secondary" type="reset">Reset Form</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="content-card">
                    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-3">
                        <h5 class="section-title mb-0">Daftar Mata Kuliah</h5>

                        <form class="d-flex gap-2">
                            <input type="text" class="form-control" placeholder="Cari kode atau nama MK">
                            <button class="btn btn-primary" type="button">Cari</button>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode MK</th>
                                    <th>Nama Mata Kuliah</th>
                                    <th>SKS</th>
                                    <th>Dosen</th>
                                    <th>Semester</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>PTI301</td>
                                    <td>Pemrograman Web</td>
                                    <td>3</td>
                                    <td>Ridwan, M.T</td>
                                    <td>3</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="#" class="btn btn-sm btn-danger">Hapus</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>PTI302</td>
                                    <td>Basis Data</td>
                                    <td>3</td>
                                    <td>Ridwan, M.T</td>
                                    <td>3</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="#" class="btn btn-sm btn-danger">Hapus</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>PTI303</td>
                                    <td>Algoritma dan Pemrograman</td>
                                    <td>3</td>
                                    <td>Ridwan, M.T</td>
                                    <td>3</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="#" class="btn btn-sm btn-danger">Hapus</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </main>

</body>
</html>

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
            <a class="navbar-brand" href="dashboard.html">Sistem Nilai Kuliah</a>

            <div class="ms-auto d-flex flex-wrap gap-2">
                <a class="nav-link" href="dashboard.php">Dashboard</a>
                <a class="nav-link active" href="mahasiswa.php">Mahasiswa</a>
                <a class="nav-link" href="mata-kuliah.php">Mata Kuliah</a>
                <a class="nav-link" href="nilai.php">Data Nilai</a>
                <a class="nav-link" href="rekap-nilai.php">Rekap Nilai</a>
                <a class="nav-link text-danger" href="#">Logout</a>
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
                    <h5 class="section-title mb-3">Form Mahasiswa</h5>

                    <form>
                        <div class="mb-3">
                            <label class="form-label">NIM</label>
                            <input type="text" class="form-control" placeholder="Masukkan NIM">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Mahasiswa</label>
                            <input type="text" class="form-control" placeholder="Masukkan nama mahasiswa">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <select class="form-select">
                                <option>Pilih jenis kelamin</option>
                                <option>Laki-laki</option>
                                <option>Perempuan</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Program Studi</label>
                            <input type="text" class="form-control" value="Pendidikan Teknologi Informasi">
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
                                <option>7</option>
                                <option>8</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">No. HP</label>
                            <input type="text" class="form-control" placeholder="Masukkan nomor HP">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control" rows="3" placeholder="Masukkan alamat"></textarea>
                        </div>

                        <div class="d-grid gap-2">
                            <button class="btn btn-primary" type="button">Simpan Data</button>
                            <button class="btn btn-outline-secondary" type="reset">Reset Form</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="content-card">
                    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-3">
                        <h5 class="section-title mb-0">Daftar Mahasiswa</h5>

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
                                    <th>Prodi</th>
                                    <th>Semester</th>
                                    <th>JK</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>230101001</td>
                                    <td>Ahmad Zikri</td>
                                    <td>PTI</td>
                                    <td>3</td>
                                    <td>Laki-laki</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="#" class="btn btn-sm btn-danger">Hapus</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>230101002</td>
                                    <td>Siti Rahmah</td>
                                    <td>PTI</td>
                                    <td>3</td>
                                    <td>Perempuan</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="#" class="btn btn-sm btn-danger">Hapus</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>230101003</td>
                                    <td>Muhammad Fajri</td>
                                    <td>PTI</td>
                                    <td>3</td>
                                    <td>Laki-laki</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="#" class="btn btn-sm btn-danger">Hapus</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <p class="small-muted mb-0">
                        Fitur pencarian dan tombol aksi membutuhkan backend agar dapat bekerja secara dinamis.
                    </p>
                </div>
            </div>
        </div>
    </main>

</body>
</html>
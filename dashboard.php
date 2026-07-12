<?php include "koneksi.php"; ?>
<!DOCTYPE html> 
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Sistem Nilai Mata Kuliah</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="dashboard.html">Sistem Nilai Kuliah</a>

            <div class="ms-auto d-flex flex-wrap gap-2">
                <a class="nav-link active" href="dashboard.php">Dashboard</a>
                <a class="nav-link" href="mahasiswa.php">Mahasiswa</a>
                <a class="nav-link" href="mata-kuliah.php">Mata Kuliah</a>
                <a class="nav-link" href="nilai.php">Data Nilai</a>
                <a class="nav-link" href="rekap-nilai.php">Rekap Nilai</a>
                <a class="nav-link text-danger" href="#">Logout</a>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        <section class="page-header">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2>Dashboard Pengelolaan Nilai</h2>
                    <p class="mb-0">
                        Pantau data mahasiswa, mata kuliah, nilai akhir, grade, dan status kelulusan secara ringkas.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <span class="badge bg-light text-primary p-3">Tahun Akademik 2025/2026</span>
                </div>
            </div>
        </section>

        <section class="row g-4 mb-4">
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-icon bg-blue">M</div>
                    <p class="small-muted mb-1">Total Mahasiswa</p>
                    <h3 class="fw-bold mb-0">128</h3>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-icon bg-green">MK</div>
                    <p class="small-muted mb-1">Mata Kuliah</p>
                    <h3 class="fw-bold mb-0">12</h3>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-icon bg-orange">A</div>
                    <p class="small-muted mb-1">Rata-rata Nilai</p>
                    <h3 class="fw-bold mb-0">82.45</h3>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-icon bg-red">%</div>
                    <p class="small-muted mb-1">Kelulusan</p>
                    <h3 class="fw-bold mb-0">91%</h3>
                </div>
            </div>
        </section>

        <section class="row g-4">
            <div class="col-lg-8">
                <div class="content-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="section-title mb-0">Nilai Terbaru</h5>
                        <a href="nilai.html" class="btn btn-sm btn-primary">Kelola Nilai</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Mata Kuliah</th>
                                    <th>Nilai Akhir</th>
                                    <th>Grade</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>230101001</td>
                                    <td>Ahmad Zikri</td>
                                    <td>Pemrograman Web</td>
                                    <td>87.50</td>
                                    <td><span class="badge badge-soft-success">A</span></td>
                                    <td><span class="badge badge-soft-success">Lulus</span></td>
                                </tr>
                                <tr>
                                    <td>230101002</td>
                                    <td>Siti Rahmah</td>
                                    <td>Pemrograman Web</td>
                                    <td>82.90</td>
                                    <td><span class="badge badge-soft-primary">A-</span></td>
                                    <td><span class="badge badge-soft-success">Lulus</span></td>
                                </tr>
                                <tr>
                                    <td>230101003</td>
                                    <td>Muhammad Fajri</td>
                                    <td>Pemrograman Web</td>
                                    <td>71.90</td>
                                    <td><span class="badge badge-soft-warning">B</span></td>
                                    <td><span class="badge badge-soft-success">Lulus</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="content-card">
                    <h5 class="section-title mb-3">Skala Konversi Grade</h5>

                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>A</span>
                        <strong>85 - 100</strong>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>A-</span>
                        <strong>80 - 84</strong>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>B+</span>
                        <strong>75 - 79</strong>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>B</span>
                        <strong>70 - 74</strong>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>C+</span>
                        <strong>65 - 69</strong>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>C</span>
                        <strong>60 - 64</strong>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>D</span>
                        <strong>50 - 59</strong>
                    </div>
                    <div class="d-flex justify-content-between py-2">
                        <span>E</span>
                        <strong>0 - 49</strong>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer text-center">
        Sistem Pengelolaan Nilai Mata Kuliah
    </footer>

</body>
</html>

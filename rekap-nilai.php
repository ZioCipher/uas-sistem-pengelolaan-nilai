<?php include "koneksi.php"; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Nilai | Sistem Nilai Mata Kuliah</title>

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
                <a class="nav-link" href="nilai.php">Data Nilai</a>
                <a class="nav-link active" href="rekap-nilai.php">Rekap Nilai</a>
                <a class="nav-link text-danger" href="#">Logout</a>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        <section class="page-header">
            <h2>Rekap Nilai Mata Kuliah</h2>
            <p class="mb-0">
                Lihat ringkasan nilai berdasarkan mata kuliah, tahun akademik, semester, rata-rata nilai, dan jumlah kelulusan.
            </p>
        </section>

        <section class="row g-4 mb-4">
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-icon bg-blue">R</div>
                    <p class="small-muted mb-1">Rata-rata Kelas</p>
                    <h3 class="fw-bold mb-0">81.20</h3>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-icon bg-green">L</div>
                    <p class="small-muted mb-1">Total Lulus</p>
                    <h3 class="fw-bold mb-0">118</h3>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-icon bg-orange">A</div>
                    <p class="small-muted mb-1">Grade A</p>
                    <h3 class="fw-bold mb-0">34</h3>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-icon bg-red">TL</div>
                    <p class="small-muted mb-1">Tidak Lulus</p>
                    <h3 class="fw-bold mb-0">10</h3>
                </div>
            </div>
        </section>

        <section class="content-card mb-4">
            <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-3">
                <h5 class="section-title mb-0">Filter Rekap Nilai</h5>

                <form class="d-flex flex-wrap gap-2">
                    <select class="form-select">
                        <option>Semua Mata Kuliah</option>
                        <option>Pemrograman Web</option>
                        <option>Basis Data</option>
                        <option>Algoritma dan Pemrograman</option>
                    </select>

                    <select class="form-select">
                        <option>2025/2026</option>
                        <option>2024/2025</option>
                    </select>

                    <select class="form-select">
                        <option>Ganjil</option>
                        <option>Genap</option>
                    </select>

                    <button class="btn btn-primary" type="button">Tampilkan</button>
                </form>
            </div>
        </section>

        <section class="content-card">
            <h5 class="section-title mb-3">Tabel Rekap Nilai</h5>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Mata Kuliah</th>
                            <th>Tahun Akademik</th>
                            <th>Semester</th>
                            <th>Jumlah Mahasiswa</th>
                            <th>Rata-rata</th>
                            <th>Tertinggi</th>
                            <th>Terendah</th>
                            <th>Grade A</th>
                            <th>Lulus</th>
                            <th>Tidak Lulus</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Pemrograman Web</td>
                            <td>2025/2026</td>
                            <td>Ganjil</td>
                            <td>42</td>
                            <td>82.45</td>
                            <td>96.00</td>
                            <td>48.00</td>
                            <td>12</td>
                            <td><span class="badge badge-soft-success">39</span></td>
                            <td><span class="badge badge-soft-danger">3</span></td>
                        </tr>

                        <tr>
                            <td>2</td>
                            <td>Basis Data</td>
                            <td>2025/2026</td>
                            <td>Ganjil</td>
                            <td>40</td>
                            <td>80.10</td>
                            <td>94.00</td>
                            <td>55.00</td>
                            <td>9</td>
                            <td><span class="badge badge-soft-success">37</span></td>
                            <td><span class="badge badge-soft-danger">3</span></td>
                        </tr>

                        <tr>
                            <td>3</td>
                            <td>Algoritma dan Pemrograman</td>
                            <td>2025/2026</td>
                            <td>Ganjil</td>
                            <td>46</td>
                            <td>78.85</td>
                            <td>92.00</td>
                            <td>50.00</td>
                            <td>7</td>
                            <td><span class="badge badge-soft-success">42</span></td>
                            <td><span class="badge badge-soft-danger">4</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <h6 class="fw-bold">Contoh Query Rekap Nilai</h6>

                <pre class="bg-light p-3 rounded"><code>SELECT * FROM view_rekap_nilai;</code></pre>

                <h6 class="fw-bold mt-4">Contoh Query Pencarian Nama atau NIM</h6>

                <pre class="bg-light p-3 rounded"><code>SELECT *
FROM view_nilai_lengkap
WHERE nama_mahasiswa LIKE '%Ahmad%'
   OR nim LIKE '%230101001%';</code></pre>
            </div>
        </section>
    </main>

</body>
</html>

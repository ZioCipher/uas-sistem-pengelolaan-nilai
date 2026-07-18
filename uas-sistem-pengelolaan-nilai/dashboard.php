<?php 
// 1. wajib mulai sesi login DULU
session_start();
// 2. Cek apakah sudah login, kalau belum lempar ke login
if (!isset($_SESSION['login'])){
    header("Location: index.php");
    exit;
}
// 3.Baru hubungkan ke database
include "koneksi.php"; 

// --- AMBIL DATA RINGKASAN (STATS) ---
// 1. Total Mahasiswa
$query_mhs = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM mahasiswa");
$data_mhs = mysqli_fetch_assoc($query_mhs);
$total_mahasiswa = $data_mhs['total'];

// 2. Total Mata Kuliah
$query_mk = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM mata_kuliah");
$data_mk = mysqli_fetch_assoc($query_mk);
$total_mk = $data_mk['total'];

// 3. Rata-rata Nilai (Asumsi kolom bernama 'nilai_akhir' di tabel 'nilai')
$query_avg = mysqli_query($koneksi, "SELECT AVG(nilai_akhir) AS rata_rata FROM nilai");
$data_avg = mysqli_fetch_assoc($query_avg);
$rata_rata_nilai = number_format($data_avg['rata_rata'], 2);

// 4. Persentase Kelulusan (Asumsi status 'Lulus' dihitung dari total data nilai)
$query_total_nilai = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM nilai");
$data_total_nilai = mysqli_fetch_assoc($query_total_nilai);
$total_nilai = $data_total_nilai['total'];

$query_lulus = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM nilai WHERE status_kelulusan = 'Lulus'");
$data_lulus = mysqli_fetch_assoc($query_lulus);
$total_lulus = $data_lulus['total'];

// Mencegah error pembagian dengan angka 0 jika data nilai masih kosong
$persentase_kelulusan = $total_nilai > 0 ? round(($total_lulus / $total_nilai) * 100) : 0;
?>
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
            <a class="navbar-brand" href="dashboard.php">Sistem Nilai Kuliah</a>

            <div class="ms-auto d-flex flex-wrap gap-2">
                <a class="nav-link active" href="dashboard.php">Dashboard</a>
                <a class="nav-link" href="mahasiswa.php">Mahasiswa</a>
                <a class="nav-link" href="mata-kuliah.php">Mata Kuliah</a>
                <a class="nav-link" href="nilai.php">Data Nilai</a>
                <a class="nav-link" href="rekap-nilai.php">Rekap Nilai</a>
                <a class="nav-link text-danger" href="logout.php"onclick="return confirm('Apakah kamu yakin ingin keluar dari sistem?');">Logout</a>
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
                    <h3 class="fw-bold mb-0"><?= $total_mahasiswa; ?></h3>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-icon bg-green">MK</div>
                    <p class="small-muted mb-1">Mata Kuliah</p>
                    <h3 class="fw-bold mb-0"><?= $total_mk; ?></h3>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-icon bg-orange">A</div>
                    <p class="small-muted mb-1">Rata-rata Nilai</p>
                    <h3 class="fw-bold mb-0"><?= $rata_rata_nilai; ?></h3>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-icon bg-red">%</div>
                    <p class="small-muted mb-1">Kelulusan</p>
                    <h3 class="fw-bold mb-0"><?= $persentase_kelulusan; ?>%</h3>
                </div>
            </div>
        </section>

        <section class="row g-4">
            <div class="col-lg-8">
                <div class="content-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="section-title mb-0">Nilai Terbaru</h5>
                        <a href="nilai.php" class="btn btn-sm btn-primary">Kelola Nilai</a>
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
                                <?php
                                // mengambil data langsung dari tabel nilai secara murni
                                $query_nilai = mysqli_query($koneksi, "SELECT * FROM nilai ORDER BY id_nilai DESC LIMIT 5");
    
                                if(mysqli_num_rows($query_nilai) > 0) {
                                    while($row = mysqli_fetch_assoc($query_nilai)) {
                                        // Menentukan warna badge berdasarkan grade
                                        $badge_class = ($row['grade'] == 'A' || $row['grade'] == 'A-' || $row['grade'] == 'B+') ? 'success' : (($row['grade'] == 'B' || $row['grade'] == 'C+') ? 'primary' : 'warning');
            
                                        // Menentukan warna badge berdasarkan data status_kelulusan
                                        $status_class = ($row['status_kelulusan'] == 'Lulus') ? 'success' : 'danger';
                                        
                                        // --- AMBIL DATA MAHASISWA (NIM & NAMA) ---
                                        $id_mhs = $row['id_mahasiswa'];
                                        $nim_tampil = "-"; // Default kosong/strip kalau tidak ketemu
                                        $nama_mahasiswa_tampil = "-"; // Default kosong/strip kalau tidak ketemu
                                        
                                        $cari_mhs = mysqli_query($koneksi, "SELECT * FROM mahasiswa WHERE id_mahasiswa = '$id_mhs'");
                                        if($cari_mhs && mysqli_num_rows($cari_mhs) > 0) {
                                            $data_mhs_ketemu = mysqli_fetch_assoc($cari_mhs);
                                            
                                            // Ambil NIM asli mahasiswa (otomatis deteksi huruf besar/kecil)
                                            if(isset($data_mhs_ketemu['nim'])) $nim_tampil = $data_mhs_ketemu['nim'];
                                            elseif(isset($data_mhs_ketemu['NIM'])) $nim_tampil = $data_mhs_ketemu['NIM'];
                                            
                                            // Ambil Nama mahasiswa
                                            if(isset($data_mhs_ketemu['nama'])) $nama_mahasiswa_tampil = $data_mhs_ketemu['nama'];
                                            elseif(isset($data_mhs_ketemu['nama_mahasiswa'])) $nama_mahasiswa_tampil = $data_mhs_ketemu['nama_mahasiswa'];
                                            elseif(isset($data_mhs_ketemu['nama_mhs'])) $nama_mahasiswa_tampil = $data_mhs_ketemu['nama_mhs'];
                                        }

                                        // --- AMBIL DATA MATA KULIAH ---
                                        $id_mk = $row['id_mata_kuliah'];
                                        $nama_mk_tampil = "-"; // Default kosong/strip kalau tidak ketemu
                                        
                                        $cari_mk = mysqli_query($koneksi, "SELECT * FROM mata_kuliah WHERE id_mata_kuliah = '$id_mk'");
                                        if($cari_mk && mysqli_num_rows($cari_mk) > 0) {
                                            $data_mk_ketemu = mysqli_fetch_assoc($cari_mk);
                                            if(isset($data_mk_ketemu['nama_mk'])) $nama_mk_tampil = $data_mk_ketemu['nama_mk'];
                                            elseif(isset($data_mk_ketemu['nama_mata_kuliah'])) $nama_mk_tampil = $data_mk_ketemu['nama_mata_kuliah'];
                                            elseif(isset($data_mk_ketemu['mata_kuliah'])) $nama_mk_tampil = $data_mk_ketemu['mata_kuliah'];
                                        }
                                ?>
                                <tr>
                                <!-- menampilkan NIM -->
                                <td><?= $nim_tampil; ?></td>
                                <td><?= $nama_mahasiswa_tampil; ?></td>
                                <td><?= $nama_mk_tampil; ?></td>
                                <td><?= number_format($row['nilai_akhir'], 2); ?></td>
                                <td><span class="badge badge-soft-<?= $badge_class; ?>"><?= $row['grade']; ?></span></td>
                                <td><span class="badge badge-soft-<?= $status_class; ?>"><?= $row['status_kelulusan']; ?></span></td>
                            </tr>
                            <?php 
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center text-muted'>Belum ada data nilai terbaru.</td></tr>";
                            }
                            ?>
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
<?php 
// 1. Wajib mulai sesi login DULU
session_start();
// 2. Cek apakah sudah login, kalau belum lempar ke login
if (!isset($_SESSION['login'])){
    header("Location: index.php");
    exit;
}
// 3. Baru hubungkan ke database
include "koneksi.php"; 

// --- MEMBACA FILTER & PENCARIAN ---
$filter_mhs = isset($_GET['id_mahasiswa']) ? mysqli_real_escape_string($koneksi, $_GET['id_mahasiswa']) : '';
$filter_mk = isset($_GET['mata_kuliah']) ? mysqli_real_escape_string($koneksi, $_GET['mata_kuliah']) : '';
$filter_tahun = isset($_GET['tahun']) ? mysqli_real_escape_string($koneksi, $_GET['tahun']) : '';
$filter_semester = isset($_GET['semester']) ? mysqli_real_escape_string($koneksi, $_GET['semester']) : '';

// --- LOGIKA FILTER PENCARIAN INDIVIDU ---
$where_clauses_indiv = [];
if (!empty($filter_mhs)) {
    $where_clauses_indiv[] = "id_mahasiswa = '$filter_mhs'";
}
if (!empty($filter_mk)) {
    $where_clauses_indiv[] = "id_mata_kuliah = '$filter_mk'";
}
if (!empty($filter_tahun)) {
    $where_clauses_indiv[] = "tahun_akademik = '$filter_tahun'"; 
}
if (!empty($filter_semester)) {
    $where_clauses_indiv[] = "semester_akademik = '$filter_semester'";
}

$where_sql_indiv = "";
if (!empty($where_clauses_indiv)) {
    $where_sql_indiv = "WHERE " . implode(" AND ", $where_clauses_indiv);
}

// --- GLOBAL STATS (UNTUK 4 CARD ATAS) ---
$query_stats = mysqli_query($koneksi, "SELECT * FROM nilai");
$total_rows = mysqli_num_rows($query_stats);

$total_nilai = 0;
$total_lulus = 0;
$total_grade_a = 0;
$total_tidak_lulus = 0;

while ($r_stat = mysqli_fetch_assoc($query_stats)) {
    $total_nilai += $r_stat['nilai_akhir'];
    if (trim($r_stat['status_kelulusan']) == 'Lulus') $total_lulus++;
    else $total_tidak_lulus++;
    
    if (in_array(trim($r_stat['grade']), ['A', 'A-', 'B+'])) $total_grade_a++;
}
$rata_rata_kelas = $total_rows > 0 ? number_format($total_nilai / $total_rows, 2) : "0.00";
?>
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
            <a class="navbar-brand" href="dashboard.php">Sistem Nilai Kuliah</a>

            <div class="ms-auto d-flex flex-wrap gap-2">
                <a class="nav-link" href="dashboard.php">Dashboard</a>
                <a class="nav-link" href="mahasiswa.php">Mahasiswa</a>
                <a class="nav-link" href="mata-kuliah.php">Mata Kuliah</a>
                <a class="nav-link" href="nilai.php">Data Nilai</a>
                <a class="nav-link active" href="rekap-nilai.php">Rekap Nilai</a>
                <a class="nav-link text-danger" href="logout.php"onclick="return confirm('Apakah kamu yakin ingin keluar dari sistem?');">Logout</a>
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
                    <h3 class="fw-bold mb-0"><?= $rata_rata_kelas; ?></h3>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-icon bg-green">L</div>
                    <p class="small-muted mb-1">Total Lulus</p>
                    <h3 class="fw-bold mb-0"><?= $total_lulus; ?></h3>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-icon bg-orange">A</div>
                    <p class="small-muted mb-1">Grade A</p>
                    <h3 class="fw-bold mb-0"><?= $total_grade_a; ?></h3>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-icon bg-red">TL</div>
                    <p class="small-muted mb-1">Tidak Lulus</p>
                    <h3 class="fw-bold mb-0"><?= $total_tidak_lulus; ?></h3>
                </div>
            </div>
        </section>

        <!-- FILTER & HASIL PENCARIAN MAHASISWA -->
        <section class="content-card mb-4">
            <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-4">
                <h5 class="section-title mb-0">Filter Rekap Nilai</h5>

                <form class="d-flex flex-wrap gap-2" method="GET" action="rekap-nilai.php">
                    <!-- Dropdown NIM / Nama -->
                    <select name="id_mahasiswa" class="form-select" style="min-width: 200px;">
                        <option value="">Semua NIM / Nama</option>
                        <?php 
                        $q_dropdown_mhs = mysqli_query($koneksi, "SELECT * FROM mahasiswa");
                        while($r_drop_mhs = mysqli_fetch_assoc($q_dropdown_mhs)) {
                            $mhs_nim = isset($r_drop_mhs['nim']) ? $r_drop_mhs['nim'] : (isset($r_drop_mhs['NIM']) ? $r_drop_mhs['NIM'] : '');
                            $mhs_nama = isset($r_drop_mhs['nama']) ? $r_drop_mhs['nama'] : (isset($r_drop_mhs['nama_mahasiswa']) ? $r_drop_mhs['nama_mahasiswa'] : '');
                            
                            $selected = ($filter_mhs == $r_drop_mhs['id_mahasiswa']) ? 'selected' : '';
                            echo "<option value='".$r_drop_mhs['id_mahasiswa']."' $selected>".$mhs_nim." - ".$mhs_nama."</option>";
                        }
                        ?>
                    </select>

                    <!-- Dropdown Mata Kuliah -->
                    <select name="mata_kuliah" class="form-select">
                        <option value="">Semua Mata Kuliah</option>
                        <?php 
                        $q_list_mk = mysqli_query($koneksi, "SELECT * FROM mata_kuliah");
                        while($r_list_mk = mysqli_fetch_assoc($q_list_mk)) {
                            $selected = ($filter_mk == $r_list_mk['id_mata_kuliah']) ? 'selected' : '';
                            echo "<option value='".$r_list_mk['id_mata_kuliah']."' $selected>".$r_list_mk['nama_mk']."</option>";
                        }
                        ?>
                    </select>

                    <!-- Dropdown Tahun -->
                    <select name="tahun" class="form-select">
                        <option value="">Semua Tahun</option>
                        <option value="2025/2026" <?= $filter_tahun == '2025/2026' ? 'selected' : ''; ?>>2025/2026</option>
                        <option value="2024/2025" <?= $filter_tahun == '2024/2025' ? 'selected' : ''; ?>>2024/2025</option>
                    </select>

                    <!-- Dropdown Semester -->
                    <select name="semester" class="form-select">
                        <option value="">Semua Semester</option>
                        <option value="Ganjil" <?= $filter_semester == 'Ganjil' ? 'selected' : ''; ?>>Ganjil</option>
                        <option value="Genap" <?= $filter_semester == 'Genap' ? 'selected' : ''; ?>>Genap</option>
                    </select>

                    <button class="btn btn-primary" type="submit">Tampilkan</button>
                    <?php if(!empty($filter_mhs) || !empty($filter_mk) || !empty($filter_tahun) || !empty($filter_semester)): ?>
                        <a href="rekap-nilai.php" class="btn btn-secondary">Reset</a>
                    <?php endif; ?>
                </form>
            </div>

            <!-- HASIL FILTER DATA -->
            <?php if (!empty($filter_mhs) || !empty($filter_mk) || !empty($filter_tahun) || !empty($filter_semester)): ?>
                <hr>
                <h6 class="fw-bold mb-3 text-primary">Hasil Pencarian Filter Data:</h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>Mata Kuliah</th>
                                <th>Tahun Akademik</th>
                                <th>Semester</th>
                                <th>Nilai Akhir</th>
                                <th>Grade</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $q_indiv = mysqli_query($koneksi, "SELECT * FROM nilai $where_sql_indiv");
                            if ($q_indiv && mysqli_num_rows($q_indiv) > 0) {
                                while ($r_indiv = mysqli_fetch_assoc($q_indiv)) {
                                    $id_mk_indiv = $r_indiv['id_mata_kuliah'];
                                    
                                    // Cari nama MK
                                    $nama_mk_indiv = "MK ID: " . $id_mk_indiv;
                                    $c_mk_ind = mysqli_query($koneksi, "SELECT * FROM mata_kuliah WHERE id_mata_kuliah = '$id_mk_indiv'");
                                    if($c_mk_ind && mysqli_num_rows($c_mk_ind) > 0) {
                                        $d_mk_ind = mysqli_fetch_assoc($c_mk_ind);
                                        $nama_mk_indiv = isset($d_mk_ind['nama_mk']) ? $d_mk_ind['nama_mk'] : $nama_mk_indiv;
                                    }
                                    
                                    $b_class = (in_array($r_indiv['grade'], ['A', 'A-', 'B+'])) ? 'success' : 'primary';
                                    $s_class = ($r_indiv['status_kelulusan'] == 'Lulus') ? 'success' : 'danger';
                                    ?>
                                    <tr>
                                        <td><?= $nama_mk_indiv; ?></td>
                                        <td><?= $r_indiv['tahun_akademik']; ?></td>
                                        <td><?= $r_indiv['semester_akademik']; ?></td>
                                        <td><?= number_format($r_indiv['nilai_akhir'], 2); ?></td>
                                        <td><span class="badge bg-<?= $b_class; ?>"><?= $r_indiv['grade']; ?></span></td>
                                        <td><span class="badge bg-<?= $s_class; ?>"><?= $r_indiv['status_kelulusan']; ?></span></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center text-muted'>Tidak ada data nilai yang cocok dengan kombinasi filter ini.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </section>

        <!-- TABEL REKAP NILAI KESELURUHAN -->
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
                        <?php
                        // Menampilkan rekap per mata kuliah 
                        $query_rekap = mysqli_query($koneksi, "SELECT id_mata_kuliah, 
                                                                      tahun_akademik, 
                                                                      semester_akademik,
                                                                      COUNT(*) as jml_mhs,
                                                                      AVG(nilai_akhir) as avg_nilai,
                                                                      MAX(nilai_akhir) as max_nilai,
                                                                      MIN(nilai_akhir) as min_nilai
                                                               FROM nilai 
                                                               GROUP BY id_mata_kuliah, tahun_akademik, semester_akademik");
                        
                        if($query_rekap && mysqli_num_rows($query_rekap) > 0) {
                            $no = 1;
                            while($row = mysqli_fetch_assoc($query_rekap)) {
                                $id_mk_loop = $row['id_mata_kuliah'];
                                $thn_loop = $row['tahun_akademik'];
                                $sms_loop = $row['semester_akademik'];

                                // Cari nama mata kuliah
                                $nama_mk_tampil = "MK ID: " . $id_mk_loop;
                                $c_mk = mysqli_query($koneksi, "SELECT * FROM mata_kuliah WHERE id_mata_kuliah = '$id_mk_loop'");
                                if($c_mk && mysqli_num_rows($c_mk) > 0) {
                                    $d_mk = mysqli_fetch_assoc($c_mk);
                                    $nama_mk_tampil = isset($d_mk['nama_mk']) ? $d_mk['nama_mk'] : $nama_mk_tampil;
                                }

                                // Detail hitung status kelulusan di grup ini
                                $q_detail = mysqli_query($koneksi, "SELECT grade, status_kelulusan FROM nilai WHERE id_mata_kuliah='$id_mk_loop' AND tahun_akademik='$thn_loop' AND semester_akademik='$sms_loop'");
                                $group_lulus = 0;
                                $group_tidak = 0;
                                $group_a = 0;
                                
                                while($r_det = mysqli_fetch_assoc($q_detail)){
                                    if(trim($r_det['status_kelulusan']) == 'Lulus') $group_lulus++;
                                    else $group_tidak++;

                                    if(in_array(trim($r_det['grade']), ['A', 'A-'])) $group_a++;
                                }
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $nama_mk_tampil; ?></td>
                            <td><?= $thn_loop; ?></td>
                            <td><?= $sms_loop; ?></td>
                            <td><?= $row['jml_mhs']; ?></td>
                            <td><?= number_format($row['avg_nilai'], 2); ?></td>
                            <td><?= number_format($row['max_nilai'], 2); ?></td>
                            <td><?= number_format($row['min_nilai'], 2); ?></td>
                            <td><?= $group_a; ?></td>
                            <td><span class="badge badge-soft-success"><?= $group_lulus; ?></span></td>
                            <td><span class="badge badge-soft-danger"><?= $group_tidak; ?></span></td>
                        </tr>
                        <?php 
                            }
                        } else {
                            echo "<tr><td colspan='11' class='text-center text-muted py-3'>Belum ada data rekap nilai di database.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

</body>
</html>
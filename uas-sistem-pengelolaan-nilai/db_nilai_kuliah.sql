-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2026 at 05:26 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_nilai_kuliah`
--

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id_mahasiswa` int(11) NOT NULL,
  `nim` varchar(30) NOT NULL,
  `nama_mahasiswa` varchar(100) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `prodi` varchar(100) NOT NULL,
  `semester` int(11) NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`id_mahasiswa`, `nim`, `nama_mahasiswa`, `jenis_kelamin`, `prodi`, `semester`, `no_hp`, `alamat`, `created_at`) VALUES
(1, '230101001', 'Ahmad Zikri', 'Laki-laki', 'Pendidikan Teknologi Informasi', 3, '081234567001', 'Banda Aceh', '2026-07-01 02:09:08'),
(2, '230101002', 'Siti Rahmah', 'Perempuan', 'Pendidikan Teknologi Informasi', 3, '081234567002', 'Aceh Besar', '2026-07-01 02:09:08'),
(3, '230101003', 'Muhammad Fajri', 'Laki-laki', 'Pendidikan Teknologi Informasi', 3, '081234567003', 'Pidie', '2026-07-01 02:09:08');

-- --------------------------------------------------------

--
-- Table structure for table `mata_kuliah`
--

CREATE TABLE `mata_kuliah` (
  `id_mata_kuliah` int(11) NOT NULL,
  `kode_mk` varchar(20) NOT NULL,
  `nama_mk` varchar(100) NOT NULL,
  `sks` int(11) NOT NULL,
  `dosen_pengampu` varchar(100) DEFAULT NULL,
  `semester` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mata_kuliah`
--

INSERT INTO `mata_kuliah` (`id_mata_kuliah`, `kode_mk`, `nama_mk`, `sks`, `dosen_pengampu`, `semester`, `created_at`) VALUES
(1, 'PTI301', 'Pemrograman Web', 3, 'Ridwan, M.T', 3, '2026-07-01 02:09:08'),
(2, 'PTI302', 'Basis Data', 3, 'Ridwan, M.T', 3, '2026-07-01 02:09:08'),
(3, 'PTI303', 'Algoritma dan Pemrograman', 3, 'Ridwan, M.T', 3, '2026-07-01 02:09:08');

-- --------------------------------------------------------

--
-- Table structure for table `nilai`
--

CREATE TABLE `nilai` (
  `id_nilai` int(11) NOT NULL,
  `id_mahasiswa` int(11) NOT NULL,
  `id_mata_kuliah` int(11) NOT NULL,
  `tahun_akademik` varchar(20) NOT NULL,
  `semester_akademik` enum('Ganjil','Genap') NOT NULL,
  `nilai_tugas` decimal(5,2) DEFAULT 0.00,
  `nilai_uts` decimal(5,2) DEFAULT 0.00,
  `nilai_uas` decimal(5,2) DEFAULT 0.00,
  `nilai_akhir` decimal(5,2) GENERATED ALWAYS AS (`nilai_tugas` * 0.20 + `nilai_uts` * 0.30 + `nilai_uas` * 0.50) STORED,
  `grade` varchar(2) GENERATED ALWAYS AS (case when `nilai_tugas` * 0.20 + `nilai_uts` * 0.30 + `nilai_uas` * 0.50 >= 85 then 'A' when `nilai_tugas` * 0.20 + `nilai_uts` * 0.30 + `nilai_uas` * 0.50 >= 80 then 'A-' when `nilai_tugas` * 0.20 + `nilai_uts` * 0.30 + `nilai_uas` * 0.50 >= 75 then 'B+' when `nilai_tugas` * 0.20 + `nilai_uts` * 0.30 + `nilai_uas` * 0.50 >= 70 then 'B' when `nilai_tugas` * 0.20 + `nilai_uts` * 0.30 + `nilai_uas` * 0.50 >= 65 then 'C+' when `nilai_tugas` * 0.20 + `nilai_uts` * 0.30 + `nilai_uas` * 0.50 >= 60 then 'C' when `nilai_tugas` * 0.20 + `nilai_uts` * 0.30 + `nilai_uas` * 0.50 >= 50 then 'D' else 'E' end) STORED,
  `status_kelulusan` varchar(20) GENERATED ALWAYS AS (case when `nilai_tugas` * 0.20 + `nilai_uts` * 0.30 + `nilai_uas` * 0.50 >= 60 then 'Lulus' else 'Tidak Lulus' end) STORED,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nilai`
--

INSERT INTO `nilai` (`id_nilai`, `id_mahasiswa`, `id_mata_kuliah`, `tahun_akademik`, `semester_akademik`, `nilai_tugas`, `nilai_uts`, `nilai_uas`, `created_at`) VALUES
(1, 1, 1, '2025/2026', 'Ganjil', 90.00, 85.00, 88.00, '2026-07-01 02:09:08'),
(2, 2, 1, '2025/2026', 'Ganjil', 82.00, 80.00, 85.00, '2026-07-01 02:09:08'),
(3, 3, 1, '2025/2026', 'Ganjil', 70.00, 68.00, 75.00, '2026-07-01 02:09:08');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','dosen') DEFAULT 'admin',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama_lengkap`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'Administrator Sistem', 'admin', 'admin123', 'admin', '2026-07-01 02:09:08'),
(2, 'Dosen Pengampu', 'dosen', 'dosen123', 'dosen', '2026-07-01 02:09:08');

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_nilai_lengkap`
-- (See below for the actual view)
--
CREATE TABLE `view_nilai_lengkap` (
`id_nilai` int(11)
,`nim` varchar(30)
,`nama_mahasiswa` varchar(100)
,`prodi` varchar(100)
,`semester` int(11)
,`kode_mk` varchar(20)
,`nama_mk` varchar(100)
,`sks` int(11)
,`tahun_akademik` varchar(20)
,`semester_akademik` enum('Ganjil','Genap')
,`nilai_tugas` decimal(5,2)
,`nilai_uts` decimal(5,2)
,`nilai_uas` decimal(5,2)
,`nilai_akhir` decimal(5,2)
,`grade` varchar(2)
,`status_kelulusan` varchar(20)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_rekap_nilai`
-- (See below for the actual view)
--
CREATE TABLE `view_rekap_nilai` (
`nama_mk` varchar(100)
,`tahun_akademik` varchar(20)
,`semester_akademik` enum('Ganjil','Genap')
,`jumlah_mahasiswa` bigint(21)
,`rata_rata_nilai` decimal(6,2)
,`nilai_tertinggi` decimal(5,2)
,`nilai_terendah` decimal(5,2)
,`jumlah_grade_a` decimal(22,0)
,`jumlah_grade_b` decimal(22,0)
,`jumlah_lulus` decimal(22,0)
,`jumlah_tidak_lulus` decimal(22,0)
);

-- --------------------------------------------------------

--
-- Structure for view `view_nilai_lengkap`
--
DROP TABLE IF EXISTS `view_nilai_lengkap`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_nilai_lengkap`  AS SELECT `nilai`.`id_nilai` AS `id_nilai`, `mahasiswa`.`nim` AS `nim`, `mahasiswa`.`nama_mahasiswa` AS `nama_mahasiswa`, `mahasiswa`.`prodi` AS `prodi`, `mahasiswa`.`semester` AS `semester`, `mata_kuliah`.`kode_mk` AS `kode_mk`, `mata_kuliah`.`nama_mk` AS `nama_mk`, `mata_kuliah`.`sks` AS `sks`, `nilai`.`tahun_akademik` AS `tahun_akademik`, `nilai`.`semester_akademik` AS `semester_akademik`, `nilai`.`nilai_tugas` AS `nilai_tugas`, `nilai`.`nilai_uts` AS `nilai_uts`, `nilai`.`nilai_uas` AS `nilai_uas`, `nilai`.`nilai_akhir` AS `nilai_akhir`, `nilai`.`grade` AS `grade`, `nilai`.`status_kelulusan` AS `status_kelulusan` FROM ((`nilai` join `mahasiswa` on(`nilai`.`id_mahasiswa` = `mahasiswa`.`id_mahasiswa`)) join `mata_kuliah` on(`nilai`.`id_mata_kuliah` = `mata_kuliah`.`id_mata_kuliah`)) ;

-- --------------------------------------------------------

--
-- Structure for view `view_rekap_nilai`
--
DROP TABLE IF EXISTS `view_rekap_nilai`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_rekap_nilai`  AS SELECT `mata_kuliah`.`nama_mk` AS `nama_mk`, `nilai`.`tahun_akademik` AS `tahun_akademik`, `nilai`.`semester_akademik` AS `semester_akademik`, count(`nilai`.`id_nilai`) AS `jumlah_mahasiswa`, round(avg(`nilai`.`nilai_akhir`),2) AS `rata_rata_nilai`, max(`nilai`.`nilai_akhir`) AS `nilai_tertinggi`, min(`nilai`.`nilai_akhir`) AS `nilai_terendah`, sum(case when `nilai`.`grade` = 'A' then 1 else 0 end) AS `jumlah_grade_a`, sum(case when `nilai`.`grade` = 'B' or `nilai`.`grade` = 'B+' then 1 else 0 end) AS `jumlah_grade_b`, sum(case when `nilai`.`status_kelulusan` = 'Lulus' then 1 else 0 end) AS `jumlah_lulus`, sum(case when `nilai`.`status_kelulusan` = 'Tidak Lulus' then 1 else 0 end) AS `jumlah_tidak_lulus` FROM (`nilai` join `mata_kuliah` on(`nilai`.`id_mata_kuliah` = `mata_kuliah`.`id_mata_kuliah`)) GROUP BY `mata_kuliah`.`nama_mk`, `nilai`.`tahun_akademik`, `nilai`.`semester_akademik` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id_mahasiswa`),
  ADD UNIQUE KEY `nim` (`nim`);

--
-- Indexes for table `mata_kuliah`
--
ALTER TABLE `mata_kuliah`
  ADD PRIMARY KEY (`id_mata_kuliah`),
  ADD UNIQUE KEY `kode_mk` (`kode_mk`);

--
-- Indexes for table `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id_nilai`),
  ADD UNIQUE KEY `unique_nilai_mahasiswa_mk` (`id_mahasiswa`,`id_mata_kuliah`,`tahun_akademik`,`semester_akademik`),
  ADD KEY `fk_nilai_mata_kuliah` (`id_mata_kuliah`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id_mahasiswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mata_kuliah`
--
ALTER TABLE `mata_kuliah`
  MODIFY `id_mata_kuliah` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id_nilai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `nilai`
--
ALTER TABLE `nilai`
  ADD CONSTRAINT `fk_nilai_mahasiswa` FOREIGN KEY (`id_mahasiswa`) REFERENCES `mahasiswa` (`id_mahasiswa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_nilai_mata_kuliah` FOREIGN KEY (`id_mata_kuliah`) REFERENCES `mata_kuliah` (`id_mata_kuliah`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 09, 2024 at 10:26 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kampus`
--

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `nim` bigint NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kelamin` enum('L','P') NOT NULL,
  `password` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`nim`, `nama`, `kelamin`, `password`) VALUES
(1000000001, 'Ahmad Subroto', 'L', 'MhsPass12345678'),
(1000000002, 'Siti Aminah', 'P', 'MhsPass87654321');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `pid` bigint NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kelamin` enum('L','P') NOT NULL,
  `role` enum('dosen','staff') NOT NULL,
  `password` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`pid`, `nama`, `kelamin`, `role`, `password`) VALUES
(2000000001, 'Bambang Suharto', 'L', 'dosen', 'DsnPass12345678'),
(2000000002, 'Indah Permatasari', 'P', 'dosen', 'DsnPass87654321'),
(2000000003, 'Tono Susanto', 'L', 'staff', 'StfPass12345678'),
(2000000004, 'Ayu Wulandari', 'P', 'staff', 'StfPass87654321');

-- --------------------------------------------------------

--
-- Table structure for table `surat_pengantar`
--

CREATE TABLE `surat_pengantar` (
  `id` int NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `uploaded_by` bigint NOT NULL,
  `upload_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `surat_pengantar`
--

INSERT INTO `surat_pengantar` (`id`, `file_path`, `uploaded_by`, `upload_date`) VALUES
(1, 'uploads/surat_pengantar/1.pdf', 2000000003, '2024-11-09 15:23:42');

-- --------------------------------------------------------

--
-- Table structure for table `tugas_akhir`
--

CREATE TABLE `tugas_akhir` (
  `id` int NOT NULL,
  `judul` varchar(255) NOT NULL,
  `abstrak` text NOT NULL,
  `status` enum('Diajukan','Diterima','Ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `keterangan` text,
  `nim_mahasiswa` bigint NOT NULL,
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `status_pembayaran` enum('belum bayar','sudah bayar') DEFAULT 'belum bayar'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tugas_akhir`
--

INSERT INTO `tugas_akhir` (`id`, `judul`, `abstrak`, `status`, `keterangan`, `nim_mahasiswa`, `bukti_pembayaran`, `status_pembayaran`) VALUES
(1, 'Siapa', 'Kamu', 'Diterima', 'Oke', 1000000001, 'uploads/bg zoom webinar 2024.png', 'sudah bayar'),
(2, 'Aku', 'Dimana', 'Diterima', 'Masuk', 1000000001, 'uploads/1704345670483.jpg', 'belum bayar'),
(3, 'Halo', 'Ini', 'Diterima', 'Masuk', 1000000002, 'uploads/6i52w6d2.png', 'sudah bayar'),
(4, 'Aku', 'Dimana', 'Diajukan', 'Masuk', 1000000001, '', 'belum bayar'),
(5, 'A', 'B', NULL, NULL, 1000000002, NULL, 'belum bayar'),
(6, 'asw', 'dsa', 'Diterima', 'gg', 1000000002, 'uploads/IMG_5069.jpg', 'sudah bayar');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`nim`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `surat_pengantar`
--
ALTER TABLE `surat_pengantar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tugas_akhir`
--
ALTER TABLE `tugas_akhir`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nim_mahasiswa` (`nim_mahasiswa`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `nim` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000000003;

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `pid` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2000000005;

--
-- AUTO_INCREMENT for table `surat_pengantar`
--
ALTER TABLE `surat_pengantar`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tugas_akhir`
--
ALTER TABLE `tugas_akhir`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tugas_akhir`
--
ALTER TABLE `tugas_akhir`
  ADD CONSTRAINT `tugas_akhir_ibfk_1` FOREIGN KEY (`nim_mahasiswa`) REFERENCES `mahasiswa` (`nim`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

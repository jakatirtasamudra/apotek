-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2025 at 03:29 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `klinik`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_diskon`
--

CREATE TABLE `tbl_diskon` (
  `id_diskon` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `nominal` int(11) NOT NULL,
  `tgl` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_diskon`
--

INSERT INTO `tbl_diskon` (`id_diskon`, `keterangan`, `nominal`, `tgl`) VALUES
(1, 'nama keterangan', 10000, '2025-05-21'),
(2, 'nama keterangan', 10000, '2025-05-21'),
(3, 'test', 500, '2025-05-24');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kategori`
--

CREATE TABLE `tbl_kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_kategori`
--

INSERT INTO `tbl_kategori` (`id_kategori`, `nama`, `create_at`, `update_at`) VALUES
(1, 'Ringan', '2025-05-01 15:22:38', NULL),
(2, 'Keras', '2025-05-01 15:22:48', NULL),
(3, 'Anak-Anak', '2025-05-01 15:22:59', NULL),
(4, 'Dewasa', '2025-05-01 15:23:03', NULL),
(5, 'Ibu Hamil', '2025-05-01 15:23:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_login`
--

CREATE TABLE `tbl_login` (
  `id_login` int(11) NOT NULL,
  `user_login` varchar(100) DEFAULT NULL,
  `pass_login` varchar(50) DEFAULT NULL,
  `nama_login` varchar(150) DEFAULT NULL,
  `level_login` varchar(50) DEFAULT NULL,
  `status_login` varchar(1) DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_login`
--

INSERT INTO `tbl_login` (`id_login`, `user_login`, `pass_login`, `nama_login`, `level_login`, `status_login`, `create_at`, `update_at`) VALUES
(1, 'Admin', 'Admin123', 'Administrator', 'admin', '1', '2025-05-01 06:11:01', NULL),
(2, 'jakatirta', 'jakatirta', 'jaka tirta samudra', 'Pegawai', '1', '2025-05-01 11:26:59', NULL),
(5, 'ubahdata', 'ubahdata', 'ubah data', 'Pegawai', NULL, '2025-05-01 11:36:56', '2025-05-21 14:36:12'),
(6, 'kasir123', 'kasir123', 'Akun Kasir', 'Kasir', NULL, '2025-05-01 11:37:24', '2025-05-21 11:11:58'),
(9, 'jakatirta123', 'jakatirta123', 'jakatirta', 'Kasir', '1', '2025-05-01 14:39:03', '2025-05-21 14:36:18');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_obat`
--

CREATE TABLE `tbl_obat` (
  `id_obat` int(11) NOT NULL,
  `kategori` varchar(255) DEFAULT NULL,
  `nama_obat` varchar(255) DEFAULT NULL,
  `jumlah_obat` int(11) DEFAULT NULL,
  `exp_obat` date DEFAULT NULL,
  `beli_obat` int(11) DEFAULT NULL,
  `jual_obat` int(11) DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_obat`
--

INSERT INTO `tbl_obat` (`id_obat`, `kategori`, `nama_obat`, `jumlah_obat`, `exp_obat`, `beli_obat`, `jual_obat`, `create_at`, `update_at`) VALUES
(1, 'Dewasa', 'Paracetamol', 100, '2029-09-19', 2500, 3500, '2025-05-01 15:49:32', '2025-05-01 22:54:20'),
(2, 'Ringan', 'Amcidal', 50, '2030-05-01', 4000, 5000, '2025-05-01 15:50:25', NULL),
(4, 'Dewasa', 'Amosilin', 20, '2028-05-01', 4000, 5500, '2025-05-01 16:15:21', NULL),
(5, 'Anak-Anak', 'Proce D', 55, '2028-05-01', 156000, 183500, '2025-05-01 16:15:51', NULL),
(6, 'Ringan', 'Milanta', 44, '2027-12-01', 47000, 54000, '2025-05-01 16:16:20', NULL),
(7, 'Ibu Hamil', 'Amoxilin', 110, '2028-05-01', 7800, 10000, '2025-05-01 17:18:04', '2025-05-02 00:25:07'),
(8, 'Anak-Anak', 'Antangin', 21, '2035-05-02', 1500, 2500, '2025-05-01 19:49:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pembeli`
--

CREATE TABLE `tbl_pembeli` (
  `id_pembeli` bigint(20) NOT NULL,
  `hp` varchar(15) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_pembeli`
--

INSERT INTO `tbl_pembeli` (`id_pembeli`, `hp`, `nama`, `create_at`, `update_at`) VALUES
(1, '082274748215', 'beli obat', '2025-05-01 16:59:36', '2025-05-02 10:07:35'),
(2, '1312312312', 'asdasdasd', '2025-05-02 05:35:08', NULL),
(3, '1231', 'dads', '2025-05-02 07:16:49', NULL),
(4, '123', 'tesst', '2025-05-03 04:18:19', '2025-05-07 08:56:35'),
(5, '0823123', 'SMIMAB', '2025-05-03 07:22:22', NULL),
(6, '900918203', 'asdasdas', '2025-05-07 01:55:15', NULL),
(7, '123123', 'asd', '2025-05-10 10:07:12', NULL),
(8, '08909123', '6SIC2', '2025-05-10 10:19:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transaksi`
--

CREATE TABLE `tbl_transaksi` (
  `id_transaksi` bigint(20) NOT NULL,
  `hp` varchar(15) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `id_obat` varchar(255) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `tgl` timestamp NOT NULL DEFAULT current_timestamp(),
  `bayar` varchar(1) DEFAULT NULL,
  `tglbayar` datetime DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_transaksi`
--

INSERT INTO `tbl_transaksi` (`id_transaksi`, `hp`, `nama`, `id_obat`, `jumlah`, `harga`, `tgl`, `bayar`, `tglbayar`, `create_at`, `update_at`) VALUES
(7, '082274748215', 'beli obat', '6', 1, 54000, '2025-05-02 02:21:41', NULL, '2025-05-02 09:43:41', '2025-05-01 19:17:56', '2025-05-02 12:12:56'),
(10, '082274748215', 'beli obat', '8', 1, 2500, '2025-05-01 19:49:13', '1', '2025-05-01 09:43:41', '2025-05-01 19:49:13', '2025-05-02 09:20:00'),
(13, '082274748215', 'beli obat', '2', 2, 5000, '2025-05-01 23:52:51', '1', '2025-05-02 09:43:41', '2025-05-01 23:52:51', '2025-05-02 09:20:05'),
(15, '082274748215', 'beli obat', '8', 2, 2500, '2025-05-02 02:43:31', '1', '2025-05-01 09:43:41', '2025-05-02 02:43:31', '2025-05-02 09:43:36'),
(16, '082274748215', 'beli obat', '5', 1, 183500, '2025-05-02 02:43:32', '1', '2025-04-30 09:43:41', '2025-05-02 02:43:32', NULL),
(18, '1312312312', 'asdasdasd', '2', 1, 5000, '2025-05-02 05:35:18', '1', '2025-05-02 12:35:25', '2025-05-02 05:35:18', NULL),
(19, '1312312312', 'asdasdasd', '1', 1, 3500, '2025-05-02 05:35:19', '1', '2025-05-02 12:35:25', '2025-05-02 05:35:19', NULL),
(20, '1312312312', 'asdasdasd', '4', 2, 5500, '2025-05-02 05:35:21', '1', '2025-05-02 12:35:25', '2025-05-02 05:35:21', '2025-05-02 12:35:22'),
(21, '1231', 'dads', '6', 1, 54000, '2025-05-02 07:16:57', '1', '2025-05-02 14:17:05', '2025-05-02 07:16:57', NULL),
(22, '1231', 'dads', '7', 1, 10000, '2025-05-02 07:16:58', '1', '2025-05-02 14:17:05', '2025-05-02 07:16:58', NULL),
(23, '1231', 'dads', '8', 1, 2500, '2025-05-02 07:16:58', '1', '2025-05-02 14:17:05', '2025-05-02 07:16:58', NULL),
(24, '1231', 'dads', '1', 2, 3500, '2025-05-02 07:17:00', '1', '2025-05-02 14:17:05', '2025-05-02 07:17:00', '2025-05-02 14:17:02'),
(25, '1231', 'dads', '2', 1, 5000, '2025-05-02 07:17:01', '1', '2025-05-02 14:17:05', '2025-05-02 07:17:01', NULL),
(26, '123', 'tesst', '6', 1, 54000, '2025-05-03 04:18:22', '1', '2025-05-03 11:18:27', '2025-05-03 04:18:22', NULL),
(27, '123', 'tesst', '7', 1, 10000, '2025-05-03 04:18:23', '1', '2025-05-03 11:18:27', '2025-05-03 04:18:23', NULL),
(28, '123', 'tesst', '2', 1, 5000, '2025-05-03 04:18:24', '1', '2025-05-03 11:18:27', '2025-05-03 04:18:24', NULL),
(29, '123', 'tesst', '4', 1, 5500, '2025-05-03 04:18:24', '1', '2025-05-03 11:18:27', '2025-05-03 04:18:24', NULL),
(32, '0823123', 'SMIMAB', '6', 2, 54000, '2025-05-03 07:23:06', '1', '2025-05-03 14:23:34', '2025-05-03 07:23:06', '2025-05-03 14:23:08'),
(34, '0823123', 'SMIMAB', '8', 1, 2500, '2025-05-03 07:23:11', '1', '2025-05-03 14:23:34', '2025-05-03 07:23:11', NULL),
(35, '900918203', 'asdasdas', '8', 1, 2500, '2025-05-07 01:55:17', '1', '2025-05-07 08:55:22', '2025-05-07 01:55:17', NULL),
(36, '900918203', 'asdasdas', '7', 1, 10000, '2025-05-07 01:55:18', '1', '2025-05-07 08:55:22', '2025-05-07 01:55:18', NULL),
(37, '123123', 'asd', '7', 1, 10000, '2025-05-10 10:07:14', '1', '2025-05-10 17:07:17', '2025-05-10 10:07:14', NULL),
(38, '123123', 'asd', '6', 1, 54000, '2025-05-10 10:07:15', '1', '2025-05-10 17:07:17', '2025-05-10 10:07:15', NULL),
(39, '08909123', '6SIC2', '7', 1, 10000, '2025-05-10 10:20:00', '1', '2025-05-10 17:20:36', '2025-05-10 10:20:00', NULL),
(40, '08909123', '6SIC2', '6', 1, 54000, '2025-05-10 10:20:00', '1', '2025-05-10 17:20:36', '2025-05-10 10:20:00', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_diskon`
--
ALTER TABLE `tbl_diskon`
  ADD PRIMARY KEY (`id_diskon`);

--
-- Indexes for table `tbl_kategori`
--
ALTER TABLE `tbl_kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `tbl_login`
--
ALTER TABLE `tbl_login`
  ADD PRIMARY KEY (`id_login`);

--
-- Indexes for table `tbl_obat`
--
ALTER TABLE `tbl_obat`
  ADD PRIMARY KEY (`id_obat`);

--
-- Indexes for table `tbl_pembeli`
--
ALTER TABLE `tbl_pembeli`
  ADD PRIMARY KEY (`id_pembeli`);

--
-- Indexes for table `tbl_transaksi`
--
ALTER TABLE `tbl_transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_diskon`
--
ALTER TABLE `tbl_diskon`
  MODIFY `id_diskon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_kategori`
--
ALTER TABLE `tbl_kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_login`
--
ALTER TABLE `tbl_login`
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_obat`
--
ALTER TABLE `tbl_obat`
  MODIFY `id_obat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_pembeli`
--
ALTER TABLE `tbl_pembeli`
  MODIFY `id_pembeli` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_transaksi`
--
ALTER TABLE `tbl_transaksi`
  MODIFY `id_transaksi` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

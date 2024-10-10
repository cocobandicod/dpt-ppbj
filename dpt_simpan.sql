-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 10, 2024 at 03:21 PM
-- Server version: 10.3.39-MariaDB-0ubuntu0.20.04.2
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dpt_simpan`
--

-- --------------------------------------------------------

--
-- Table structure for table `akta`
--

CREATE TABLE `akta` (
  `id` smallint(2) NOT NULL,
  `id_profil` smallint(6) NOT NULL,
  `jenis` enum('Akta-Pendirian','Akta-Perubahan') NOT NULL,
  `nomor` varchar(50) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `nama_notaris` varchar(100) DEFAULT NULL,
  `file` varchar(100) NOT NULL,
  `status` enum('Pending','Waiting','Verified') NOT NULL,
  `id_operator` smallint(2) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `akta`
--

INSERT INTO `akta` (`id`, `id_profil`, `jenis`, `nomor`, `tanggal`, `nama_notaris`, `file`, `status`, `id_operator`, `catatan`, `timestamp`) VALUES
(1, 1, 'Akta-Pendirian', '1', '2020-11-02', 'Firman Adnan Pakaya, SH., M.Kn', '644a753bcb6c9.pdf', 'Verified', 2, 'VALID', '2023-04-27 13:14:35'),
(2, 2, 'Akta-Pendirian', '34', '2006-01-16', 'HASNA MOKOGINTA, SH', '644b7440b73f7.pdf', 'Verified', 2, 'valid', '2023-04-28 07:22:40'),
(3, 3, 'Akta-Pendirian', '22', '1997-03-07', 'Drs. Atrino Leswara, SH', '644b78c52e2b9.pdf', 'Verified', 2, 'valid', '2023-04-28 07:41:57'),
(4, 3, 'Akta-Perubahan', '217', '2021-02-04', 'Hambit Maseh, SH', '644b793b28a56.pdf', 'Verified', 2, 'valid', '2023-04-28 07:43:55'),
(5, 6, 'Akta-Pendirian', '20', '1988-02-08', 'Ny. Yetty Taher SH', '64536f5fcd451.pdf', 'Verified', 2, 'VALID', '2023-05-04 08:39:59'),
(6, 6, 'Akta-Perubahan', '718', '2021-10-15', 'Otty Hari Chandra Ubayani, SH', '64536fbae1af2.pdf', 'Verified', 2, 'valid', '2023-05-04 08:41:30'),
(7, 9, 'Akta-Pendirian', '12', '1987-11-03', 'E.Sianipar, SH', '6458b5073c6ef.pdf', 'Verified', 2, 'valid', '2023-05-08 08:38:31'),
(8, 9, 'Akta-Perubahan', '21', '2023-04-11', 'N. Nurhayati, SH, MKn', '6458b826843ec.pdf', 'Verified', 2, 'valid', '2023-05-08 08:51:50'),
(9, 8, 'Akta-Pendirian', '18', '1998-08-18', 'Ny. Nany Werdiningsih Sutopo, SH', '6458ba313dfa8.pdf', 'Verified', 2, 'valid', '2023-05-08 09:00:33'),
(10, 8, 'Akta-Perubahan', '1', '2022-01-03', 'Marliansyah, SH', '6458bb170102b.pdf', 'Verified', 2, 'valid', '2023-05-08 09:04:23'),
(11, 4, 'Akta-Perubahan', '04', '2016-06-10', 'AGUNG SETIAWAN BADARUDIN, SH', '6458f83e4be95.pdf', 'Verified', 2, 'VALID', '2023-05-08 13:25:18'),
(12, 4, 'Akta-Pendirian', '136', '1984-11-28', 'SOETOMO RAMELAN, SH', '6458fa0fa72aa.pdf', 'Verified', 2, 'VALID', '2023-05-08 13:33:03'),
(13, 11, 'Akta-Pendirian', '82', '1999-02-15', 'Drs. Atrino  Leswara, SH', '645b4f3a65030.pdf', 'Verified', 2, 'ok', '2023-05-10 08:00:58'),
(14, 11, 'Akta-Perubahan', '4', '2020-04-29', 'Juniarty Baryadi, SH, M.kn', '645b5170aac7d.pdf', 'Verified', 2, 'ok', '2023-05-10 08:10:24'),
(15, 12, 'Akta-Pendirian', '138', '1952-10-27', 'MR. RD. SOEDJA', '6462f5ed95dea.pdf', 'Verified', 2, 'ok', '2023-05-16 03:18:05'),
(17, 12, 'Akta-Perubahan', '06', '2022-02-27', 'RADEN REINA RAF\'ALDINI, SH', '6462f67865284.pdf', 'Verified', 2, 'ok', '2023-05-16 03:20:24'),
(18, 17, 'Akta-Pendirian', '9', '2023-07-06', 'FIRMAN ADNAN PAKAYA,SH,M.Kn', '64c897b4789aa.pdf', 'Pending', NULL, NULL, '2023-08-01 05:27:16');

-- --------------------------------------------------------

--
-- Table structure for table `akun_penyedia`
--

CREATE TABLE `akun_penyedia` (
  `id_akun` smallint(6) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `token` varchar(100) NOT NULL,
  `konfirmasi` enum('Yes','No') NOT NULL,
  `last_login` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `akun_penyedia`
--

INSERT INTO `akun_penyedia` (`id_akun`, `username`, `email`, `password`, `token`, `konfirmasi`, `last_login`) VALUES
(1, 'bengkel', 'bengkelitgorontalo@gmail.com', 'fdb28763c569927d644fc081c598ac09', '0ytA5wsjSZ7opoDZhwHuhrZnvTZ8KU', 'Yes', '2023-04-27 12:48:26'),
(2, 'GAMMATEKNIK', 'cv_gtk@yahoo.com', 'ce69a32b960ff74eb3ff3f6d61d14de1', 'rHO5byRaj942B2y9PfjEEjtmQK69ub', 'Yes', '2023-04-28 06:27:49'),
(3, 'bennatin', 'bennagroup@yahoo.com', '0b24a3ff9d821ed831f9b6437afd4a3f', 'r6eEp6bN9rcfPPepOf9td7Kar03wxf', 'Yes', '2023-04-28 06:29:59'),
(4, 'Bennanta', 'bennanta@yahoo.co.id', '2dd54d60d9c5a3c475bec323360d617a', 'kc9fKRdVeNp0KrDIV5I3sfVTg8osJP', 'Yes', '2023-04-28 07:28:10'),
(5, 'swastikapc', 'swastikapc@yahoo.com', '3c3a3a5c613a88b26bdc183101fe60e9', '2grexi9jsCr2tp98LEZegcmtT9jFDH', 'Yes', '2023-05-04 03:33:47'),
(6, 'griksacipta', 'info@griksa.com', '3ca7d57ad6e5f7f0a3bef992465e4ac8', '0TR4Eoux5HgJIg8WGKmuTrNGvzyiTn', 'Yes', '2023-05-04 06:01:02'),
(7, 'multikaradigunajasa', 'multkaradigunajasa@yahoo.com', '57ff637e93d387df53223f51c6542154', '6T4aR86UIf6GWPSYkPy9ITrnje2lIy', 'No', '2023-05-06 02:11:09'),
(8, 'artefakarkindo', 'artefakarkindo@yahoo.com', '6b348309fdc6c85998e15a0833837d2c', 'ztXQWLuz7NWevETK1vwNPjbuNEuhcA', 'Yes', '2023-05-08 06:49:40'),
(9, 'mkj-jakarta', 'multikaradigunajasa@yahoo.com', '1e53abad77d1bc727d7ae68960d439a8', 'rc5vii6QQd70oVpfqnVm4SjHPwZ2wY', 'Yes', '2023-05-08 07:04:27'),
(10, 'sangkuriang_pt', 'sangkurianglelang@yahoo.com', '6b20e04a0669aad77b7d43095f12982f', 'mk0Cso9rTX9w5YbmM0JDWO1lkd63zv', 'No', '2023-05-09 05:12:09'),
(11, 'Angelia', 'anoman_pt@yahoo.co.id', 'e7b56164506df605327f1b57cc8684a4', 'rkINwdX2eQ70kcc7GVUiFxdQkE8YKF', 'Yes', '2023-05-10 06:15:10'),
(12, 'pt_sangkuriang', 'sangkuriang_pt@yahoo.com', 'f350f55ca24fd5b5cd3a05511b0d848f', 'Dpao4ujPXYyWQY5nafFDCNQMroZQYx', 'Yes', '2023-05-15 08:48:41'),
(13, 'paradhiguna', 'paradhiguna@gmail.com', '8ec6079f5f4c3e05d5ce8cd0cc761646', 'ym3ETp5ePn33P8QAMTwobUd56LcoSO', 'Yes', '2023-05-23 05:48:30'),
(14, 'borneoinsankreasi', 'borneoinsankreasi@gmail.com', '6674a97b9bba581b106a0315092f1938', 'FEjQrYULJ1SOlHYJ0BMY6qsEhJpY1K', 'Yes', '2023-05-26 03:45:57'),
(15, 'Cahayasekawannusantara', 'cahayasekawannusantara@gmail.com', 'c93e6ccc657d03bcef236d037e6a2871', '3dlsejM6e4WAJINullLdyfitnKOEBp', 'Yes', '2023-05-28 20:59:01'),
(16, 'student', 'info@sdone.co.id', 'a9f23a4f28d97479efe474ecef8cf5c1', 'wLIKbK8sIhaDg6VsPjs7vCDPh8cdyO', 'Yes', '2023-07-08 03:18:29'),
(17, 'Ovira', 'cvpradiptaraya@gmail.com', 'd7277147c7a97413fa724c7b16c9773f', 'hWn9V0uoZG00emvTJSgfozMgaxIJ3R', 'Yes', '2023-07-31 07:59:08'),
(18, 'sesasi', 'info@sesasi.id', '5b670a49bb9e5ca89e11ece49122dd23', '6S2RhiD0rvranOo43J5UDOyZMZjHCU', 'Yes', '2024-02-29 06:22:47'),
(19, 'PTTriDayaPrima', 'marketingtdp@gmail.com', 'be066e119d22e9ed3bc0e5345eb63ccd', 'nKuMDYzarSTN0WWyVRW5FskrWZAKDN', 'Yes', '2024-03-22 04:05:48'),
(20, 'Vanadia22', 'sales@vanadia.co.id', '7ad835808d1a80165d2819f8c2f24a49', 'I85TN68hM4QTaTCsiXwpmDx6SP8NJp', 'No', '2024-05-21 02:58:21'),
(21, 'PASCV', 'pratamaabadi.sejahtera01@gmail.com', '55a811a6c4d8ba6e637fb2e0ee524e85', 'TqRqmgLkfyjvIcXGIpduWas4zLCtkO', 'Yes', '2024-07-08 06:40:43'),
(22, 'CARUNIA', 'cahaya.carunia22@gmail.com', 'd1f7a1291fe902c0356de677dd75734d', 'OSf2H9VgKUe0DQOgkPodzrKtmOY5Ae', 'Yes', '2024-07-20 06:52:25'),
(23, 'BKJ', 'binakaryajaya.cv@gmail.com', '0551c57aef7714c8fb5149aef750e7da', '3I1SEogBqkjrgRZphK30bsnzOk6RKa', 'Yes', '2024-07-21 12:06:18'),
(24, 'hartonoanugerahaudio', 'hartonoanugerahaudio.gto@gmail.com', 'e01e713d9c0813a8323bccc1c86f552b', 'F5UMayEqbMIPNiC4dpaLbr8FRWg9KZ', 'Yes', '2024-08-06 05:16:43');

-- --------------------------------------------------------

--
-- Table structure for table `catatan`
--

CREATE TABLE `catatan` (
  `id_catatan` int(11) NOT NULL,
  `id` smallint(6) NOT NULL,
  `menu` varchar(25) NOT NULL,
  `id_profil` smallint(6) NOT NULL,
  `catatan` text NOT NULL,
  `status` enum('Pending','Waiting','Verified') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `catatan`
--

INSERT INTO `catatan` (`id_catatan`, `id`, `menu`, `id_profil`, `catatan`, `status`) VALUES
(1, 3, 'npwp', 2, 'valid', 'Verified'),
(2, 2, 'domisili', 2, 'valid', 'Verified'),
(3, 4, 'npwp', 3, 'valid', 'Verified'),
(4, 2, 'tdp', 3, 'valid\r\n', 'Verified'),
(5, 4, 'akta', 3, 'valid', 'Verified'),
(6, 3, 'akta', 3, 'valid', 'Verified'),
(7, 5, 'pengurus', 3, 'valid', 'Verified'),
(8, 7, 'pengurus', 3, 'valid', 'Verified'),
(9, 8, 'pengurus', 3, 'valid', 'Verified'),
(10, 6, 'pengurus', 3, 'valid', 'Verified'),
(11, 3, 'pemilik_saham', 3, 'valid', 'Verified'),
(12, 4, 'pemilik_saham', 3, 'valid', 'Verified'),
(13, 5, 'pemilik_saham', 3, 'valid', 'Verified'),
(14, 6, 'pemilik_saham', 3, 'valid', 'Verified'),
(15, 3, 'izin_usaha', 3, 'valid', 'Verified'),
(16, 2, 'pajak', 3, 'valid', 'Verified'),
(17, 3, 'domisili', 3, 'valid', 'Verified'),
(18, 2, 'izin_usaha', 2, 'valid\r\n', 'Verified'),
(19, 1, 'tdp', 2, 'valid', 'Verified'),
(20, 2, 'akta', 2, 'valid', 'Verified'),
(21, 3, 'pengurus', 2, 'valid', 'Verified'),
(22, 4, 'pengurus', 2, 'valid', 'Verified'),
(23, 1, 'pemilik_saham', 2, 'valid', 'Verified'),
(24, 2, 'pemilik_saham', 2, 'valid', 'Verified'),
(25, 1, 'pajak', 2, 'valid', 'Verified'),
(26, 2, 'npwp', 1, 'VALID', 'Verified'),
(27, 1, 'domisili', 1, 'VALID', 'Verified'),
(28, 1, 'akta', 1, 'VALID', 'Verified'),
(29, 1, 'pengurus', 1, 'VALID', 'Verified'),
(30, 2, 'pengurus', 1, 'VALID', 'Verified'),
(31, 1, 'izin_usaha', 1, 'VALID', 'Verified'),
(32, 4, 'izin_usaha', 4, 'VALID', 'Verified'),
(33, 5, 'npwp', 4, 'VALID', 'Verified'),
(34, 3, 'tdp', 4, 'VALID', 'Verified'),
(35, 6, 'npwp', 6, 'VALID', 'Verified'),
(36, 5, 'domisili', 6, 'VALID', 'Verified'),
(37, 4, 'tdp', 6, 'VALID', 'Verified'),
(38, 5, 'akta', 6, 'VALID', 'Verified'),
(39, 3, 'pajak', 6, 'VALID', 'Verified'),
(40, 9, 'pengurus', 6, 'VALID', 'Verified'),
(41, 10, 'pengurus', 6, 'VALID', 'Verified'),
(42, 11, 'pengurus', 6, 'VALID', 'Verified'),
(43, 7, 'pemilik_saham', 6, 'VALID', 'Verified'),
(44, 8, 'pemilik_saham', 6, 'VALID', 'Verified'),
(45, 9, 'pemilik_saham', 6, 'VALID', 'Verified'),
(46, 10, 'pemilik_saham', 6, 'VALID', 'Verified'),
(47, 11, 'pemilik_saham', 6, 'VALID', 'Verified'),
(48, 5, 'izin_usaha', 6, 'VALID', 'Verified'),
(49, 6, 'izin_usaha', 6, 'VALID', 'Verified'),
(50, 7, 'izin_usaha', 6, 'Valid', 'Verified'),
(51, 8, 'izin_usaha', 6, 'valid', 'Verified'),
(52, 9, 'izin_usaha', 6, 'valid', 'Verified'),
(53, 10, 'izin_usaha', 6, 'valid', 'Verified'),
(54, 11, 'izin_usaha', 6, 'valid', 'Verified'),
(55, 12, 'izin_usaha', 6, 'valid', 'Verified'),
(56, 6, 'akta', 6, 'valid', 'Verified'),
(57, 12, 'pengurus', 6, 'valid', 'Verified'),
(58, 13, 'pengurus', 6, 'valid', 'Verified'),
(59, 11, 'akta', 4, 'VALID', 'Verified'),
(60, 12, 'akta', 4, 'VALID', 'Verified'),
(61, 26, 'pengurus', 4, 'VALID', 'Verified'),
(62, 27, 'pengurus', 4, 'VALID\r\n', 'Verified'),
(63, 28, 'pengurus', 4, 'VALID', 'Verified'),
(64, 21, 'pemilik_saham', 4, 'VALID', 'Verified'),
(65, 22, 'pemilik_saham', 4, 'VALID', 'Verified'),
(66, 23, 'pemilik_saham', 4, 'VALID', 'Verified'),
(67, 6, 'pajak', 4, 'VALID', 'Verified'),
(68, 4, 'domisili', 4, 'valid', 'Verified'),
(69, 14, 'izin_usaha', 8, 'valid', 'Verified'),
(70, 15, 'izin_usaha', 8, 'valid', 'Verified'),
(71, 13, 'izin_usaha', 8, 'VALID', 'Verified'),
(72, 16, 'izin_usaha', 8, 'VALID', 'Verified'),
(73, 17, 'izin_usaha', 8, 'VALID', 'Verified'),
(74, 18, 'izin_usaha', 8, 'VALID', 'Verified'),
(75, 19, 'izin_usaha', 8, 'VALID', 'Verified'),
(76, 8, 'npwp', 8, 'VALID', 'Verified'),
(77, 7, 'domisili', 8, 'valid', 'Verified'),
(78, 6, 'tdp', 8, 'valid', 'Verified'),
(79, 9, 'akta', 8, 'valid', 'Verified'),
(80, 10, 'akta', 8, 'valid', 'Verified'),
(81, 17, 'pengurus', 8, 'valid', 'Verified'),
(82, 18, 'pengurus', 8, 'valid', 'Verified'),
(83, 19, 'pengurus', 8, 'valid', 'Verified'),
(84, 20, 'pengurus', 8, 'valid', 'Verified'),
(85, 5, 'pajak', 8, 'valid', 'Verified'),
(86, 21, 'pengurus', 8, 'valid', 'Verified'),
(87, 22, 'pengurus', 8, 'valid', 'Verified'),
(88, 23, 'pengurus', 8, 'valid', 'Verified'),
(89, 24, 'pengurus', 8, 'valid', 'Verified'),
(90, 25, 'pengurus', 8, 'valid', 'Verified'),
(91, 20, 'izin_usaha', 8, 'valid', 'Verified'),
(92, 21, 'izin_usaha', 8, 'valid', 'Verified'),
(93, 23, 'izin_usaha', 8, 'valid', 'Verified'),
(94, 28, 'izin_usaha', 8, 'valid', 'Verified'),
(95, 34, 'izin_usaha', 8, 'valid', 'Verified'),
(96, 15, 'pemilik_saham', 8, 'valid', 'Verified'),
(97, 16, 'pemilik_saham', 8, 'valid', 'Verified'),
(98, 17, 'pemilik_saham', 8, 'valid', 'Verified'),
(99, 18, 'pemilik_saham', 8, 'valid', 'Verified'),
(100, 19, 'pemilik_saham', 8, 'valid', 'Verified'),
(101, 20, 'pemilik_saham', 8, 'valid', 'Verified'),
(102, 6, 'domisili', 9, 'valid', 'Verified'),
(103, 22, 'izin_usaha', 9, 'valid', 'Verified'),
(104, 24, 'izin_usaha', 9, 'valid', 'Verified'),
(105, 25, 'izin_usaha', 9, 'valid', 'Verified'),
(106, 26, 'izin_usaha', 9, 'valid', 'Verified'),
(107, 27, 'izin_usaha', 9, 'valid', 'Verified'),
(108, 29, 'izin_usaha', 9, 'valid', 'Verified'),
(109, 30, 'izin_usaha', 9, 'valid', 'Verified'),
(110, 31, 'izin_usaha', 9, 'valid', 'Verified'),
(111, 32, 'izin_usaha', 9, 'valid', 'Verified'),
(112, 33, 'izin_usaha', 9, 'valid', 'Verified'),
(113, 7, 'npwp', 9, 'valid', 'Verified'),
(114, 8, 'akta', 9, 'valid', 'Verified'),
(115, 14, 'pengurus', 9, 'valid', 'Verified'),
(116, 15, 'pengurus', 9, 'valid', 'Verified'),
(117, 16, 'pengurus', 9, 'valid', 'Verified'),
(118, 7, 'akta', 9, 'valid', 'Verified'),
(119, 5, 'tdp', 9, 'valid', 'Verified'),
(120, 13, 'pemilik_saham', 9, 'valid', 'Verified'),
(121, 4, 'pajak', 9, 'valid', 'Verified'),
(122, 14, 'pemilik_saham', 9, 'valid', 'Verified'),
(123, 12, 'pemilik_saham', 9, 'VALID', 'Verified'),
(124, 35, 'izin_usaha', 11, 'valid', 'Verified'),
(125, 9, 'npwp', 11, 'valid', 'Verified'),
(126, 7, 'tdp', 11, 'valid', 'Verified'),
(127, 14, 'akta', 11, 'ok', 'Verified'),
(128, 13, 'akta', 11, 'ok', 'Verified'),
(129, 8, 'domisili', 11, 'ok', 'Verified'),
(130, 29, 'pengurus', 11, 'ok', 'Verified'),
(131, 30, 'pengurus', 11, 'ok', 'Verified'),
(132, 31, 'pengurus', 11, 'ok', 'Verified'),
(133, 32, 'pengurus', 11, 'ok', 'Verified'),
(134, 24, 'pemilik_saham', 11, 'ok', 'Verified'),
(135, 25, 'pemilik_saham', 11, 'ok', 'Verified'),
(136, 26, 'pemilik_saham', 11, 'ok', 'Verified'),
(137, 36, 'izin_usaha', 12, 'ok', 'Verified'),
(138, 37, 'izin_usaha', 12, 'ok', 'Verified'),
(139, 38, 'izin_usaha', 12, 'ok', 'Verified'),
(140, 9, 'domisili', 12, 'ok', 'Verified'),
(141, 15, 'akta', 12, 'ok', 'Verified'),
(142, 17, 'akta', 12, 'ok', 'Verified'),
(143, 33, 'pengurus', 12, 'ok', 'Verified'),
(144, 34, 'pengurus', 12, 'ok', 'Verified'),
(145, 27, 'pemilik_saham', 12, 'ok', 'Verified'),
(146, 7, 'pajak', 12, 'ok', 'Verified'),
(147, 28, 'pemilik_saham', 12, 'ok', 'Verified'),
(148, 30, 'pemilik_saham', 12, 'ok', 'Verified'),
(149, 29, 'pemilik_saham', 12, 'ok', 'Verified'),
(150, 31, 'pemilik_saham', 12, 'ok', 'Verified'),
(151, 32, 'pemilik_saham', 12, 'ok', 'Verified'),
(152, 11, 'npwp', 12, 'ok', 'Verified'),
(153, 8, 'tdp', 12, 'ok', 'Verified');

-- --------------------------------------------------------

--
-- Table structure for table `company_profile`
--

CREATE TABLE `company_profile` (
  `id` smallint(2) NOT NULL,
  `id_profil` smallint(6) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `file` varchar(100) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company_profile`
--

INSERT INTO `company_profile` (`id`, `id_profil`, `judul`, `file`, `timestamp`) VALUES
(1, 2, 'Company Profile', '644b7dad6611e.pdf', '2023-04-28 08:02:53'),
(2, 3, 'Sertifikat Badan Usaha (SBU)', '6453262e8d96b.pdf', '2023-05-04 03:27:42'),
(3, 3, 'Sertifikat ISO 9001:2015', '645327554971f.pdf', '2023-05-04 03:32:37'),
(4, 3, 'Sertifikat ISO 14001:2015', '645327720d7d3.pdf', '2023-05-04 03:33:06'),
(5, 3, 'Sertifikat ISO 45001:2018', '6453278c8132e.pdf', '2023-05-04 03:33:32'),
(6, 3, 'Cover Company Profil', '645327f3a4504.pdf', '2023-05-04 03:35:15'),
(7, 3, 'KTA INKINDO', '645328224fc47.pdf', '2023-05-04 03:36:02'),
(8, 3, 'KTA KADIN', '64532885060f6.pdf', '2023-05-04 03:37:41'),
(9, 3, 'List Pengalaman BSC', '645328bb827ed.pdf', '2023-05-04 03:38:35'),
(10, 6, 'COMPANY PROFILE PT GRIKSA CIPTA', '645374f4673eb.pdf', '2023-05-04 09:03:48'),
(11, 8, '1 COMPANY PROFIL PT ARTEFAK ARKINDO ', '64589f9e4d202.pdf', '2023-05-08 07:07:10'),
(12, 8, '1 GAMBAR KARYA /PENGALAMAN PT ARTEFAK ARKINDO', '6458a2b984a0b.pdf', '2023-05-08 07:20:25'),
(13, 8, '2 GAMPAR PENGALAMAN PT ARTEFAK ARKINDO ', '6458a2d9b7fb2.pdf', '2023-05-08 07:20:57'),
(14, 8, '3 GAMBAR KARYA /PENGALAMAN PT ARTEFAK ARKINDO', '6458a2f4792e5.pdf', '2023-05-08 07:21:24'),
(15, 9, 'Company Profile - AHU MKJ', '6458be6c9b9a1.pdf', '2023-05-08 09:18:36'),
(16, 9, 'Company Profile MKJ - 2023', '6458c3a4dfba6.pdf', '2023-05-08 09:40:52'),
(17, 12, 'COMPANY PROFILE', '64631235eaaf3.pdf', '2023-05-16 05:18:45'),
(18, 16, 'Company Profile - PT. Solusi Data Diawan', '64a8df95edf19.pdf', '2023-07-08 04:01:25'),
(19, 12, 'sdfsdf', '6648a17fbec89.jpg', '2024-05-18 12:39:27');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` smallint(6) NOT NULL,
  `isi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `isi`) VALUES
(1, '<p>Daftar Penyedia Terpilih Pengelola Pengadaan Barang dan Jasa Universitas Negeri Gorontalo<br>Alamat: Jl. Jend. Sudirman No.6, Dulalowo Tim., Kec. Kota Tengah, Kota Gorontalo, Gorontalo 96128<br>Telepon:<br>Email:</p>');

-- --------------------------------------------------------

--
-- Table structure for table `dokumen_verifikasi`
--

CREATE TABLE `dokumen_verifikasi` (
  `id` smallint(6) NOT NULL,
  `id_profil` smallint(6) NOT NULL,
  `file_keikutsertaan` varchar(100) DEFAULT NULL,
  `file_surat_kuasa` varchar(100) DEFAULT NULL,
  `file_penunjukan_admin` varchar(100) DEFAULT NULL,
  `file_verifikasi` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dokumen_verifikasi`
--

INSERT INTO `dokumen_verifikasi` (`id`, `id_profil`, `file_keikutsertaan`, `file_surat_kuasa`, `file_penunjukan_admin`, `file_verifikasi`) VALUES
(1, 1, NULL, NULL, NULL, NULL),
(2, 2, NULL, NULL, NULL, NULL),
(3, 3, '644b75a91b69f.pdf', '644b75a91e4d9.pdf', '644b75a920588.pdf', '64534773c4794.pdf'),
(4, 4, '6459fd8e7c050.pdf', '645b4fef2d860.pdf', '6459fd8e7fbfa.pdf', '645c8ba0811ca.pdf'),
(5, 5, NULL, NULL, NULL, NULL),
(6, 6, '6453784f2d6d9.pdf', '6453784f33259.pdf', '6453784f36922.pdf', '6454a123bc1e0.pdf'),
(7, 7, NULL, NULL, NULL, NULL),
(8, 8, '6458f05862f19.pdf', '6458f05868e0f.pdf', '6458f0586ddd9.jpg', '645b47473c279.pdf'),
(9, 9, '645df682d0d3b.pdf', '645df682d3312.pdf', '645df682d4e04.pdf', '64618a709e4e9.pdf'),
(10, 10, NULL, NULL, NULL, NULL),
(11, 11, NULL, NULL, NULL, NULL),
(12, 12, '6648a150a4518.pdf', '6462f0797f62a.pdf', '6462f07981e47.pdf', '64631898df563.pdf'),
(13, 13, NULL, NULL, NULL, NULL),
(14, 14, NULL, NULL, NULL, NULL),
(15, 15, NULL, NULL, NULL, NULL),
(16, 16, NULL, NULL, NULL, NULL),
(17, 17, NULL, NULL, NULL, NULL),
(18, 18, NULL, NULL, NULL, NULL),
(19, 19, NULL, NULL, NULL, NULL),
(20, 20, NULL, NULL, NULL, NULL),
(21, 21, NULL, NULL, NULL, NULL),
(22, 22, NULL, NULL, NULL, NULL),
(23, 23, NULL, NULL, NULL, NULL),
(24, 24, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `domisili`
--

CREATE TABLE `domisili` (
  `id` smallint(2) NOT NULL,
  `id_profil` smallint(6) NOT NULL,
  `nomor` varchar(50) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `masa_berlaku` date DEFAULT NULL,
  `file` varchar(100) NOT NULL,
  `status` enum('Pending','Waiting','Verified') NOT NULL,
  `id_operator` smallint(2) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `domisili`
--

INSERT INTO `domisili` (`id`, `id_profil`, `nomor`, `tanggal`, `masa_berlaku`, `file`, `status`, `id_operator`, `catatan`, `timestamp`) VALUES
(1, 1, '470/Pem-Bld/1694/2020', '2020-11-05', '2025-11-05', '644a785c6df58.pdf', 'Verified', 2, 'VALID', '2023-04-27 13:27:56'),
(2, 2, '474.4/DS-LH/VII/1016/2019', '2019-08-09', '0001-01-01', '644b72034cedf.pdf', 'Verified', 2, 'valid', '2023-04-28 07:13:07'),
(3, 3, 'Surat Perjanjian Sewa', '2022-12-15', '2023-12-15', '644b775810204.pdf', 'Verified', 2, 'valid', '2023-04-28 07:35:52'),
(4, 4, 'Surat Perjanjian Sewa Kantor', '2022-12-21', '2023-12-21', '645a0abdb0b1d.pdf', 'Verified', 2, 'valid', '2023-05-04 06:12:15'),
(5, 6, '9120206821346', '2019-08-14', '2035-12-31', '645370083db9d.pdf', 'Verified', 2, 'VALID', '2023-05-04 08:42:48'),
(6, 9, '9120300762446', '2019-07-24', '9999-12-31', '6458b27bb18cc.pdf', 'Verified', 2, 'valid', '2023-05-08 08:27:39'),
(7, 8, '13/27.1BU/31.74.04.1005/-071562/e/2019', '2019-04-16', '2024-04-16', '6458b917f210b.pdf', 'Verified', 2, 'valid', '2023-05-08 08:55:51'),
(8, 11, 'ganesa Blok8', '2022-12-27', '2023-12-27', '645b3988cd749.pdf', 'Verified', 2, 'ok', '2023-05-10 06:28:24'),
(9, 12, '9120318080235', '2022-07-28', '2023-07-27', '6462f5945e7de.pdf', 'Verified', 2, 'ok', '2023-05-16 03:16:36'),
(10, 22, '581/Ekbang/Bwu/442', '2022-03-11', '2030-03-11', '669b60ef521f6.pdf', 'Pending', NULL, NULL, '2024-07-20 07:02:07');

-- --------------------------------------------------------

--
-- Table structure for table `download`
--

CREATE TABLE `download` (
  `id` smallint(2) NOT NULL,
  `nama_file` varchar(200) NOT NULL,
  `file` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `info_penting`
--

CREATE TABLE `info_penting` (
  `id` smallint(6) NOT NULL,
  `judul` text NOT NULL,
  `isi` text NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `info_penting`
--

INSERT INTO `info_penting` (`id`, `judul`, `isi`, `tanggal`) VALUES
(3, 'Unit Layanan Registrasi (Universitas Negeri Gorontalo)', '<h4>Universitas Negeri Gorontalo</h4><p>Alamat: Jl. Jend. Sudirman No.6, Dulalowo Tim., Kec. Kota Tengah, Kota Gorontalo, Gorontalo 96128</p>', '2023-04-29'),
(5, 'PENGUMUMAN SELEKSI JASA KONSULTAN', '<p><strong>KEMENTERIAN PENDIDIKAN, KEBUDAYAAN,&nbsp;RISET DAN TEKNOLOGI</strong></p><p><strong>BADAN LAYANAN UMUM</strong></p><p><strong>UNIVERSITAS NEGERI GORONTALO</strong></p><p><strong>Jl. Jenderal Sudirman No. 6 Telp. (0435) - 821125, Fax (0435)&nbsp;–&nbsp;821752 Kota Gorontalo</strong></p><p>&nbsp;</p><p><strong>PENGUMUMAN SELEKSI JASA KONSULTAN</strong></p><p><strong>PERENCANAAN&nbsp;GEDUNG LABORATORIUM DAN GEDUNG PENDIDIKAN</strong></p><p><strong>No. 1011/UN47.M/001.01/2023&nbsp; &nbsp;</strong></p><p>&nbsp;</p><p>Unit Pelaksana Pengadaan Barang dan Jasa Badan Layanan Umum Universitas Negeri Gorontalo, akan melaksanakan seleksi Jasa Konsultansi sebagai berikut:</p><figure class=\"table\"><table><tbody><tr><td>Nama Paket Pekerjaan</td><td>:</td><td>Paket Konsultan&nbsp;Perencanaan Gedung Laboratorium Terpadu Kemaritiman</td></tr><tr><td>Nilai HPS</td><td>:</td><td>Rp. 4.147.764.000,-</td></tr><tr><td>Sumber Pendanaan</td><td>:</td><td>DIPA BLU Universitas Negeri Gorontalo Tahun 2023</td></tr><tr><td>Jadwal Pelaksanaan</td><td>:</td><td>Mulai Tanggal 8 Mei 2023</td></tr></tbody></table></figure><p>&nbsp;</p><figure class=\"table\"><table><tbody><tr><td>Nama Paket Pekerjaan</td><td>:</td><td>Perencanaan Pembangunan Gedung Pendidikan Universitas Negeri Gorontalo</td></tr><tr><td>Nilai HPS</td><td>:</td><td>Rp. 5.386.034.000,-</td></tr><tr><td>Sumber Pendanaan</td><td>:</td><td>DIPA BLU Universitas Negeri Gorontalo Tahun 2023</td></tr><tr><td>Jadwal Pelaksanaan</td><td>:</td><td>Mulai Tanggal 8 Mei 2023</td></tr></tbody></table></figure><p>&nbsp;</p><p>Bagi calon penyedia yang ingin mengikuti Seleksi Jasa Konsultan Perencanaan&nbsp; Gedung Laboratorium dan Gedung Pendidikan harus sudah terdaftar pada Daftar Penyedia Terpilih (DPT) Badan Layanan Umum Universitas Negeri Gorontalo&nbsp;<a href=\"https://dpt.ppbj.ung.ac.id\">https://dpt.ppbj.ung.ac.id</a>&nbsp;</p><p>Bagi calon penyedia yang berminat dapat mengambil dokumen Pra Kualifikasi dengan menunjukan bukti (<i>print out</i>) telah terdaftar dan terverifikasi di DPT Badan Layanan Umum Universitas Negeri Gorontalo.</p><p>Pengambilan dokumen Pra Kualifikasi dilaksanakan pada tanggal 09 Mei 2023 sampai dengan 17 Mei 2023 bertempat di:</p><p>&nbsp;</p><p>Kantor &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : UPPBJ Badan Layanan Umum Universitas Negeri Gorontalo&nbsp;</p><p>Alamat&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : Jalan Jenderal Sudirman No. 6 Kota Gorontalo</p><p>Waktu&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : Pukul 10.00 – 16.00 wita</p><p>E-mail&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : ppbj@ung.ac.id</p><p>No Telp&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: 085396212323</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p><p>Gorontalo, 8 Mei 2023</p><p><strong>Ketua PPBJ</strong></p>', '2023-05-08');

-- --------------------------------------------------------

--
-- Table structure for table `izin_usaha`
--

CREATE TABLE `izin_usaha` (
  `id` smallint(2) NOT NULL,
  `id_profil` smallint(6) NOT NULL,
  `jenis_izin` varchar(100) NOT NULL,
  `nomor` varchar(50) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `masa_berlaku` date DEFAULT NULL,
  `instansi_pemberi` varchar(100) NOT NULL,
  `grade` varchar(100) NOT NULL,
  `file` varchar(100) NOT NULL,
  `status` enum('Pending','Waiting','Verified') NOT NULL,
  `id_operator` smallint(2) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `izin_usaha`
--

INSERT INTO `izin_usaha` (`id`, `id_profil`, `jenis_izin`, `nomor`, `tanggal`, `masa_berlaku`, `instansi_pemberi`, `grade`, `file`, `status`, `id_operator`, `catatan`, `timestamp`) VALUES
(1, 1, 'Nomor-Induk-Berusaha-(NIB)', '0226010111817', '2020-11-10', '2024-12-31', ' Badan Koordinasi Penanaman Modal', 'Perusahaan-Kecil', '644b53dc90221.pdf', 'Verified', 2, 'VALID', '2023-04-28 01:00:31'),
(2, 2, 'Surat-Izin-Usaha-Jasa-Konstruksi-(SIUJK)', '8120114180194', '2018-09-08', '0001-01-01', 'PEMERINTAH REPUBLIK INDONESIA', 'Perusahaan-Kecil', '644b7096bf526.pdf', 'Verified', 2, 'valid\r\n', '2023-04-28 07:07:02'),
(3, 3, 'Nomor-Induk-Berusaha-(NIB)', '9120312152126', '2019-11-22', '2100-11-22', 'Menteri Investasi/ Kepala Badan Koordinasi Penanaman Modal', 'Perusahaan-Besar', '644b767dc0786.pdf', 'Verified', 2, 'valid', '2023-04-28 07:32:13'),
(4, 4, 'Nomor-Induk-Berusaha-(NIB)', '9120408931525', '2019-09-12', '2025-09-12', 'PEMERINTAH REPUBLIK INDONESIA', 'Perusahaan-Besar', '64534b8c06304.pdf', 'Verified', 2, 'VALID', '2023-05-04 06:07:08'),
(5, 6, 'Nomor-Induk-Berusaha-(NIB)', '9120206821346', '2019-08-14', '2035-12-31', 'Lembaga Pengelola dan Penyelenggara OSS', 'Perusahaan-Besar', '64536cfe7269e.pdf', 'Verified', 2, 'VALID', '2023-05-04 08:29:50'),
(6, 6, 'Surat-Izin-Usaha-Jasa-Konstruksi-(SIUJK)', '9120206821346', '2019-08-14', '2035-12-31', 'Lembaga Pengelola dan Penyelenggara OSS', 'Perusahaan-Besar', '64536d4808b50.pdf', 'Verified', 2, 'VALID', '2023-05-04 08:31:04'),
(7, 6, 'Sertifikat-Badan-Usaha-(SBU)', '1-3171-01-008-1-09-083171', '2021-07-26', '2024-07-25', 'Lembaga Pengembangan Jasa Konstruksi Nasional (LPJK)', 'Perusahaan-Besar', '64536e112a752.pdf', 'Verified', 2, 'Valid', '2023-05-04 08:34:25'),
(8, 6, 'Sertifikat-Badan-Usaha-(SBU)', '1-3171-02-008-1-09-083171', '2021-07-26', '2024-07-25', 'Lembaga Pengembangan Jasa Konstruksi Nasional (LPJK)', 'Perusahaan-Besar', '64536e4b225cd.pdf', 'Verified', 2, 'valid', '2023-05-04 08:35:23'),
(9, 6, 'Sertifikat-Badan-Usaha-(SBU)', '1-3171-03-008-1-09-083171', '2021-07-26', '2024-07-25', 'Lembaga Pengembangan Jasa Konstruksi Nasional (LPJK)', 'Perusahaan-Besar', '64536e76b86ea.pdf', 'Verified', 2, 'valid', '2023-05-04 08:36:06'),
(10, 6, 'Sertifikat-Badan-Usaha-(SBU)', '2-3171-13-008-1-09-083171', '2021-07-26', '2024-07-25', 'Lembaga Pengembangan Jasa Konstruksi Nasional (LPJK)', 'Perusahaan-Besar', '64536e9f29f5b.pdf', 'Verified', 2, 'valid', '2023-05-04 08:36:47'),
(11, 6, 'Sertifikat-Badan-Usaha-(SBU)', '2-3171-14-008-1-09-083171', '2021-07-26', '2024-07-25', 'Lembaga Pengembangan Jasa Konstruksi Nasional (LPJK)', 'Perusahaan-Besar', '64536ec5951bb.pdf', 'Verified', 2, 'valid', '2023-05-04 08:37:25'),
(12, 6, 'Sertifikat-Badan-Usaha-(SBU)', '4-3171-04-008-1-09-083171', '2021-07-26', '2024-07-25', 'Lembaga Pengembangan Jasa Konstruksi Nasional (LPJK)', 'Perusahaan-Besar', '64536ee6063aa.pdf', 'Verified', 2, 'valid', '2023-05-04 08:37:58'),
(13, 8, 'Surat-Ijin-Usaha-Perdagangan-(SIUP)', '77/AC.1/31.74/-1.824.27/e/2018', '2018-05-15', '2028-05-15', 'Unit Pelaksana Pelayanan Terpadu Satu Pintu Kota Administrasi Jakarta Selatan', 'Perusahaan-Besar', '6458a5d931122.pdf', 'Verified', 2, 'VALID', '2023-05-08 07:33:45'),
(14, 8, 'Sertifikat-Badan-Usaha-(SBU)', '912020059058200150011', '2022-05-25', '2025-05-25', 'OSS (KEMENTERIAN INVESTASI/BKPM)', 'Perusahaan-Besar', '6458a6fa374ef.pdf', 'Verified', 2, 'valid', '2023-05-08 07:38:34'),
(15, 8, 'Sertifikat-Badan-Usaha-(SBU)', '912020059058200150007', '2022-05-25', '2025-05-25', 'OSS (KEMENTERIAN INVESTASI/BKPM)', 'Perusahaan-Besar', '6458a75a6f9fe.pdf', 'Verified', 2, 'valid', '2023-05-08 07:40:10'),
(16, 8, 'Sertifikat-Badan-Usaha-(SBU)', '912020059058200150012', '2022-05-25', '2025-05-25', 'OSS (KEMENTERIAN INVESTASI/BKPM)', 'Perusahaan-Besar', '6458a79671aea.pdf', 'Verified', 2, 'VALID', '2023-05-08 07:41:10'),
(17, 8, 'Sertifikat-Badan-Usaha-(SBU)', '912020059058200150009', '2022-05-25', '2025-05-25', 'OSS (KEMENTERIAN INVESTASI/BKPM)', 'Perusahaan-Kecil', '6458a89320ea6.pdf', 'Verified', 2, 'VALID', '2023-05-08 07:45:23'),
(18, 8, 'Sertifikat-Badan-Usaha-(SBU)', '912020059058200150008', '2022-05-25', '2025-05-25', 'OSS (KEMENTERIAN INVESTASI/BKPM)', 'Perusahaan-Kecil', '6458aaebbe5a4.pdf', 'Verified', 2, 'VALID', '2023-05-08 07:55:23'),
(19, 8, 'Sertifikat-Badan-Usaha-(SBU)', '912020059058200150006', '2022-05-25', '2025-05-25', 'OSS (KEMENTERIAN INVESTASI/BKPM)', 'Perusahaan-Besar', '6458ab361a86b.pdf', 'Verified', 2, 'VALID', '2023-05-08 07:56:38'),
(20, 8, 'Sertifikat-Badan-Usaha-(SBU)', '912020059058200150010', '2022-05-25', '2025-05-25', 'OSS (KEMENTERIAN INVESTASI/BKPM)', 'Perusahaan-Besar', '6458abae08a72.pdf', 'Verified', 2, 'valid', '2023-05-08 07:58:38'),
(21, 8, 'Surat-Izin-Usaha-Jasa-Konstruksi-(SIUJK)', '9120200590582', '2019-08-06', '2025-05-25', 'OSS (KEMENTERIAN INVESTASI/BKPM)', 'Perusahaan-Besar', '6458ac9acd743.pdf', 'Verified', 2, 'valid', '2023-05-08 08:02:34'),
(22, 9, 'Nomor-Induk-Berusaha-(NIB)', '9120300762446', '2019-07-24', '9999-12-31', 'Lembaga OSS - Kementerian Investasi/BKPM', 'Perusahaan-Besar', '6458ad9da986b.pdf', 'Verified', 2, 'valid', '2023-05-08 08:06:53'),
(23, 8, 'Surat-Izin-Tempat-Usaha-(SITU)', '9120200590582', '2019-08-06', '2025-05-25', 'OSS (KEMENTERIAN INVESTASI/BKPM)', 'Perusahaan-Besar', '6458adcae736d.pdf', 'Verified', 2, 'valid', '2023-05-08 08:07:38'),
(24, 9, 'Surat-Ijin-Usaha-Perdagangan-(SIUP)', '9120300762446', '2019-10-21', '9999-12-31', 'Lembaga OSS - Kementerian Investasi/BKPM', 'Perusahaan-Besar', '6458ae213f99d.pdf', 'Verified', 2, 'valid', '2023-05-08 08:09:05'),
(25, 9, 'Surat-Izin-Tempat-Usaha-(SITU)', '9120300762446', '2019-07-24', '9999-12-31', 'Lembaga OSS - Kementerian Investasi/BKPM', 'Perusahaan-Besar', '6458ae742846b.pdf', 'Verified', 2, 'valid', '2023-05-08 08:10:28'),
(26, 9, 'Surat-Izin-Usaha-Jasa-Konstruksi-(SIUJK)', '201912-2921-2010-6522-091', '2019-07-24', '9999-12-31', 'Lembaga OSS - Kementerian Investasi/BKPM', 'Perusahaan-Besar', '6458af25cca16.pdf', 'Verified', 2, 'valid', '2023-05-08 08:13:25'),
(27, 9, 'Surat-Izin-Usaha-Jasa-Konstruksi-(SIUJK)', '201912-2921-2010-6577-092', '2019-07-24', '9999-12-31', 'Lembaga OSS - Kementerian Investasi/BKPM', 'Perusahaan-Besar', '6458af62c3833.pdf', 'Verified', 2, 'valid', '2023-05-08 08:14:26'),
(28, 8, 'Izin-Akuntan-Publik', '00495/2.0921/AU.2/05/0514-3/1/V/2022', '2022-05-31', '2023-05-31', 'ABDUL AZIZ FIBY ARIZA (KAP- AAFA)', 'Perusahaan-Besar', '6458b042a8f0a.pdf', 'Verified', 2, 'valid', '2023-05-08 08:18:10'),
(29, 9, 'Sertifikat-Badan-Usaha-(SBU)', '912030076244600080001', '2022-05-25', '2025-05-24', 'INKINDO', 'Perusahaan-Besar', '6458b05c9276b.pdf', 'Verified', 2, 'valid', '2023-05-08 08:18:36'),
(30, 9, 'Sertifikat-Badan-Usaha-(SBU)', '912030076244600080002', '2022-05-25', '2025-05-24', 'INKINDO', 'Perusahaan-Besar', '6458b0b3ea5f6.pdf', 'Verified', 2, 'valid', '2023-05-08 08:20:03'),
(31, 9, 'Sertifikat-Badan-Usaha-(SBU)', '912030076244600080003', '2022-05-25', '2025-05-24', 'INKINDO', 'Perusahaan-Besar', '6458b15362dc9.pdf', 'Verified', 2, 'valid', '2023-05-08 08:22:43'),
(32, 9, 'Sertifikat-Badan-Usaha-(SBU)', '912030076244600080004', '2022-05-25', '2025-05-24', 'INKINDO', 'Perusahaan-Besar', '6458b1d00dc72.pdf', 'Verified', 2, 'valid', '2023-05-08 08:24:48'),
(33, 9, 'Sertifikat-Badan-Usaha-(SBU)', '912030076244600080005', '2022-05-25', '2025-05-24', 'INKINDO', 'Perusahaan-Besar', '6458b214724a4.pdf', 'Verified', 2, 'valid', '2023-05-08 08:25:56'),
(34, 8, 'Nomor-Induk-Berusaha-(NIB)', '9120200590582', '2022-05-27', '2028-05-27', 'OSS (KEMENTERIAN INVESTASI/BKPM)', 'Perusahaan-Besar', '6458b7c8a4272.pdf', 'Verified', 2, 'valid', '2023-05-08 08:50:16'),
(35, 11, 'Sertifikat-Badan-Usaha-(SBU)', 'F.3.01.AR.M.02.2022.0000348', '2022-02-01', '2025-02-28', 'Inkindo', '3', '645b5bd4e13a6.pdf', 'Verified', 2, 'valid', '2023-05-10 08:54:44'),
(36, 12, 'Nomor-Induk-Berusaha-(NIB)', '9120318080235', '2022-07-28', '2025-07-27', 'PEMERINTAH REPUBLIK INDONESIA', 'Perusahaan-Besar', '6462f202564d7.pdf', 'Verified', 2, 'ok', '2023-05-16 03:01:22'),
(37, 12, 'Sertifikat-Badan-Usaha-(SBU)', '912031808023500050NaN', '2022-07-28', '2025-07-27', 'PEMERINTAH REPUBLIK INDONESIA', 'Perusahaan-Besar', '6462f26794950.pdf', 'Verified', 2, 'ok', '2023-05-16 03:03:03'),
(38, 12, 'Sertifikat-Badan-Usaha-(SBU)', '912031808023500060001', '2022-07-28', '2025-07-27', 'PEMERINTAH REPUBLIK INDONESIA', 'Perusahaan-Besar', '6462f2b4ef4c2.pdf', 'Verified', 2, 'ok', '2023-05-16 03:04:20'),
(39, 16, 'Nomor-Induk-Berusaha-(NIB)', '1812210000798', '2021-11-16', '2060-12-31', 'Lembaga OSS', 'Perusahaan-Kecil', '64a8d6fd998ae.pdf', 'Pending', NULL, NULL, '2023-07-08 03:24:45'),
(40, 17, 'Sertifikat-Badan-Usaha-(SBU)', '140723002424600000001', '2023-07-29', '2026-07-28', 'Mentri pekerjaan umum dan perumahan rakyat', 'Perusahaan-Kecil', '64c88cd6a386e.pdf', 'Pending', NULL, NULL, '2023-08-01 04:40:54'),
(41, 22, 'Sertifikat-Badan-Usaha-(SBU)', '170322006450700110003', '2022-06-13', '2025-06-12', 'ASPEKINDO', 'Perusahaan-Kecil', '669b6041112ac.pdf', 'Pending', NULL, NULL, '2024-07-20 06:59:13');

-- --------------------------------------------------------

--
-- Table structure for table `npwp`
--

CREATE TABLE `npwp` (
  `id` smallint(2) NOT NULL,
  `id_profil` smallint(6) NOT NULL,
  `npwp` varchar(50) NOT NULL,
  `file` varchar(100) NOT NULL,
  `status` enum('Pending','Waiting','Verified') NOT NULL,
  `id_operator` smallint(2) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `npwp`
--

INSERT INTO `npwp` (`id`, `id_profil`, `npwp`, `file`, `status`, `id_operator`, `catatan`, `timestamp`) VALUES
(2, 1, '96.400.205.9-822.000', '644a7455c88cc.pdf', 'Verified', 2, 'VALID', '2023-04-27 13:10:45'),
(3, 2, '02.394.728.6-822.00', '644b7130968ea.pdf', 'Verified', 2, 'valid', '2023-04-28 07:09:36'),
(4, 3, '01.802.120.4-017.000', '644b76ce05c06.pdf', 'Verified', 2, 'valid', '2023-04-28 07:33:34'),
(5, 4, '01.945.382.8-061.000', '64534c007e05b.jpeg', 'Verified', 2, 'VALID', '2023-05-04 06:09:04'),
(6, 6, '01.332.587.3-017.000', '64536efe9dea9.pdf', 'Verified', 2, 'VALID', '2023-05-04 08:38:22'),
(7, 9, '01.328.217.3-013.000', '6458b2490c0bc.pdf', 'Verified', 2, 'valid', '2023-05-08 08:26:49'),
(8, 8, '01.802.390.3-019.000', '6458b85bc6177.pdf', 'Verified', 2, 'VALID', '2023-05-08 08:52:43'),
(9, 11, '01.888.517.8-061.000', '645b39045923b.pdf', 'Verified', 2, 'valid', '2023-05-10 06:26:12'),
(11, 12, '01.118.581.6-428.000', '6462f35f8d8fd.pdf', 'Verified', 2, 'ok', '2023-05-16 03:07:11'),
(12, 16, '53.262.827.8-403.000', '64a8d7ae1f882.jpg', 'Pending', NULL, NULL, '2023-07-08 03:27:42'),
(13, 17, '39.518.584.6-822.000', '64c88dc0bf879.jpeg', 'Pending', NULL, NULL, '2023-08-01 04:44:48'),
(14, 22, '63.685.349.1-822.000', '669b607d188e6.pdf', 'Pending', NULL, NULL, '2024-07-20 07:00:13');

-- --------------------------------------------------------

--
-- Table structure for table `operator`
--

CREATE TABLE `operator` (
  `id_operator` smallint(6) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `nip` varchar(30) DEFAULT NULL,
  `no_sk` varchar(30) DEFAULT NULL,
  `tgl_sk` date DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `hp` varchar(25) DEFAULT NULL,
  `level` enum('Admin','Operator') DEFAULT NULL,
  `status_aktif` enum('Aktif','Tidak-Aktif') NOT NULL,
  `token` varchar(100) NOT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `operator`
--

INSERT INTO `operator` (`id_operator`, `nama`, `username`, `password`, `email`, `nip`, `no_sk`, `tgl_sk`, `alamat`, `hp`, `level`, `status_aktif`, `token`, `last_login`) VALUES
(2, 'Jafar Katili', 'un_gorontalo', 'fdb28763c569927d644fc081c598ac09', 'jafar.katili@yahoo.co.id', '197411152006041003', '12/SK/UNG/2023', '0000-00-00', 'Jalan Jend. Sudirman No.6 Kota Gorontalo', '081244663298', 'Admin', 'Aktif', 'sDZvZXOKlKlTeCDCGhi2uC12La1gFl', NULL),
(3, 'Norman Diah Hamidun, SE., M.Si', 'norman', '82c531a250b94cf3cc2eb956cc04e353', 'norman@ung.ac.id', '197411152006041003', '1338/UN47/KU/2020', '0000-00-00', 'Jalan Jend. Sudirman No. 6 Kota Gorontalo', '081345676578', 'Admin', 'Aktif', 'Jsim6wnuEZ97hh0OvPflL5G1lheiLn', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pajak`
--

CREATE TABLE `pajak` (
  `id` smallint(2) NOT NULL,
  `id_profil` smallint(6) NOT NULL,
  `nomor` varchar(50) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `jenis_laporan` enum('Pajak-Tahun-Terakhir') DEFAULT NULL,
  `file` varchar(100) NOT NULL,
  `status` enum('Pending','Waiting','Verified') NOT NULL,
  `id_operator` smallint(2) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pajak`
--

INSERT INTO `pajak` (`id`, `id_profil`, `nomor`, `tanggal`, `jenis_laporan`, `file`, `status`, `id_operator`, `catatan`, `timestamp`) VALUES
(1, 2, '03286406504232005701', '2023-05-04', 'Pajak-Tahun-Terakhir', '644b77f035112.pdf', 'Verified', 2, 'valid', '2023-04-28 07:38:24'),
(2, 3, '20204306482231029711', '2023-03-29', 'Pajak-Tahun-Terakhir', '644b7f8887c03.pdf', 'Verified', 2, 'valid', '2023-04-28 08:10:48'),
(3, 6, '65873206512221025811', '2022-02-25', 'Pajak-Tahun-Terakhir', '6453728bde081.pdf', 'Verified', 2, 'VALID', '2023-05-04 08:53:31'),
(4, 9, '45173506428221011731', '2022-05-11', 'Pajak-Tahun-Terakhir', '6458bda9e60dd.pdf', 'Verified', 2, 'valid', '2023-05-08 09:15:21'),
(5, 8, '05903406559231012601', '2023-04-12', 'Pajak-Tahun-Terakhir', '6458cbfaa188c.pdf', 'Verified', 2, 'valid', '2023-05-08 10:16:26'),
(6, 4, '13828406454221025851', '2022-04-25', 'Pajak-Tahun-Terakhir', '6458fec5d2374.jpeg', 'Verified', 2, 'VALID', '2023-05-08 13:53:09'),
(7, 12, '90816406458231030451', '2023-04-30', 'Pajak-Tahun-Terakhir', '6463013aa6339.jpeg', 'Verified', 2, 'ok', '2023-05-16 04:06:18'),
(8, 16, '20278406556223521300', '2022-04-21', 'Pajak-Tahun-Terakhir', '64a8ddaf0b147.jpg', 'Pending', NULL, NULL, '2023-07-08 03:53:19'),
(9, 16, '61278406583233530320', '2022-04-30', 'Pajak-Tahun-Terakhir', '64a8de25703fb.jpg', 'Pending', NULL, NULL, '2023-07-08 03:55:17');

-- --------------------------------------------------------

--
-- Table structure for table `panduan`
--

CREATE TABLE `panduan` (
  `id` smallint(6) NOT NULL,
  `judul` text NOT NULL,
  `file` varchar(100) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pemilik_saham`
--

CREATE TABLE `pemilik_saham` (
  `id` smallint(2) NOT NULL,
  `id_profil` smallint(6) NOT NULL,
  `nomor_ktp` varchar(50) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `persen_saham` varchar(10) NOT NULL,
  `tipe_saham` enum('Perorangan','Badan-Usaha') NOT NULL,
  `file` varchar(100) NOT NULL,
  `status` enum('Pending','Waiting','Verified') NOT NULL,
  `id_operator` smallint(2) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pemilik_saham`
--

INSERT INTO `pemilik_saham` (`id`, `id_profil`, `nomor_ktp`, `nama`, `alamat`, `persen_saham`, `tipe_saham`, `file`, `status`, `id_operator`, `catatan`, `timestamp`) VALUES
(1, 2, '7501021812820001', 'IBRAHIM GOBEL, SE', 'DUSUN II, DESA LUHU, KECAMATAN TELAGA, KABUPATEN GORONTALO', '80', 'Badan-Usaha', '644b7695cfb74.pdf', 'Verified', 2, 'valid', '2023-04-28 07:32:37'),
(2, 2, '7501171011800001', 'HAMZAH RIFAI', 'JL. BOTULIODU, KELURAHAN POHE, KECAMATAN HULOTHALANGI', '20', 'Badan-Usaha', '644b76fa40a14.pdf', 'Verified', 2, 'valid', '2023-04-28 07:34:18'),
(3, 3, '6109030609700004', 'Pensong, SE, M.Si', 'Dusun Tanjung RT.003/002 Nanga Taman, Sekadau, Kalimantan Barat', '78%', 'Perorangan', '644b7e6002a5b.pdf', 'Verified', 2, 'valid', '2023-04-28 08:05:52'),
(4, 3, '3174081612660005', 'Atin Prihatin ', 'Jl. Rawajati Timur II No.27 Pancoran Jakarta Selatan', '7%', 'Perorangan', '644b7e8e8f98e.pdf', 'Verified', 2, 'valid', '2023-04-28 08:06:38'),
(5, 3, '6171031807800006', 'Abang Masri', 'Jl. Masjid At Taqwa Rt 004 / 001 Kel. Mungguk Kec. Sekadau Hilir Kalimantan Barat', '11%', 'Perorangan', '644b7ec96084d.pdf', 'Verified', 2, 'valid', '2023-04-28 08:07:37'),
(6, 3, '3171081809690006', 'Wajarwati', 'Jl. Kp. Pulo Gundul Johar Baru Jakarta Pusat', '4%', 'Perorangan', '644b7f0093705.pdf', 'Verified', 2, 'valid', '2023-04-28 08:08:32'),
(7, 6, '3174041501430003', 'Ir. Asdarianto Asmoeadji, IAI', 'Jl. Ampera III-23, Jakarta 12550', '32', 'Perorangan', '645371343d480.pdf', 'Verified', 2, 'VALID', '2023-05-04 08:47:48'),
(8, 6, '3174050803770009', 'Ikhsan Asikin, SE', 'Komp. Deplu Cidodol No.31A Jakarta Selatan', '12,8', 'Perorangan', '6453716234ab4.pdf', 'Verified', 2, 'VALID', '2023-05-04 08:48:34'),
(9, 6, '3174040610750010', 'Aswin Griksa Fitranto, ST', 'Jl. Masjid Al-Ridwan No. 34, Jatipadang, Pasar Minggu Jakarta Selatan 12540', '20,8', 'Perorangan', '6453718c9780f.pdf', 'Verified', 2, 'VALID', '2023-05-04 08:49:16'),
(10, 6, '3174045207730008', 'Asdiani Safitri Dewi, ST', 'Jl. Ampera III-23, Jakarta 12550', '16', 'Perorangan', '645371cab1172.pdf', 'Verified', 2, 'VALID', '2023-05-04 08:50:18'),
(11, 6, '3174046003460002', 'Ir. Intan Asdarianto, IAI', 'Jl. Ampera III-23, Jakarta 12550', '18,4', 'Perorangan', '645371f46c7c0.pdf', 'Verified', 2, 'VALID', '2023-05-04 08:51:00'),
(12, 9, '3174052908650004', 'Drs. A. Muas, Akt', 'Jl. Pondok Pinang VI RT.008 RW.002 Pondok Pinang Jakarta Selatan', '55', 'Perorangan', '6458bbf6e6584.pdf', 'Verified', 2, 'VALID', '2023-05-08 09:08:06'),
(13, 9, '3174050201980010', 'Geodie Muas', 'Jl. Pondok Pinang VI RT.008 RW.002 Pondok Pinang Jakarta Selatan', '44.5', 'Perorangan', '6458bc2d4ccf5.pdf', 'Verified', 2, 'valid', '2023-05-08 09:09:01'),
(14, 9, '3171042809970001', 'Farhan Muhammad Ashardi', 'Kramat Sentiong RT.006 RW.006 Kelurahan Kramat Kecamatan Senen', '0.5', 'Perorangan', '645df656eea3c.pdf', 'Verified', 2, 'valid', '2023-05-08 09:09:47'),
(15, 8, '3275022708540007', 'Ir. Bagustanto. IAI 1', 'Jl Cendana Raya No. 59 Kel. Jakasampurna Kec. Bekasi Barat, Kota Bekasi - Jawa Barat', '26%', 'Badan-Usaha', '6458cd87b727c.jpg', 'Verified', 2, 'valid', '2023-05-08 10:23:03'),
(16, 8, '3674062511600013', 'Ir. Bambang Suprihadi', 'Jl. Benda Timur 3 E-69/7  Pamulang Tangerang\r\n', '24%', 'Badan-Usaha', '6458cdc8bc245.jpg', 'Verified', 2, 'valid', '2023-05-08 10:24:08'),
(17, 8, '3674030810590001', 'Ir. H. Budiono Askandar, MBA', ' Jl. Puter II ED. 2/2 Bintaro V Kota Tangerang Selatan', '13%', 'Badan-Usaha', '6458ce1a03316.jpg', 'Verified', 2, 'valid', '2023-05-08 10:25:30'),
(18, 8, '3173070708530013', 'Ir. Agus Sudjatmiko', ' Jl. Anggrek Cendrawasih II/16  Jakarta Barat', '13%', 'Badan-Usaha', '6458ce5de298e.jpg', 'Verified', 2, 'valid', '2023-05-08 10:26:37'),
(19, 8, '3175030401510001', 'Ir. Sayoeti Soekamdi', 'Jl. Cakrawala XII B G/6 Jakarta Timur', '12', 'Badan-Usaha', '6458ce9a4d36c.jpg', 'Verified', 2, 'valid', '2023-05-08 10:27:38'),
(20, 8, '3174041106510001', 'Ir. Ismunandar', 'Jl. Siaga Raya No. 17 A Pasar Minggu - Jaksel', '12%', 'Badan-Usaha', '6458ced11ced9.jpg', 'Verified', 2, 'valid', '2023-05-08 10:28:33'),
(21, 4, '3201131706810006', 'EKO YUNIANTO', 'KP. SAWAH RT. 03/01 KEL. RAGAJAYA KEC. BOJONGGEDE KAB BOGOR', '1', 'Badan-Usaha', '6458fcfe665e0.jpeg', 'Verified', 2, 'VALID', '2023-05-08 13:45:34'),
(22, 4, '3174084703650005', 'NUZULLAH H', 'JL. KALIBATA UTARA I NO.48 RT.01/02 KEL. KALIBATA KEC. PANCORAN JAKARTA SELATAN', '52', 'Badan-Usaha', '6458fd5ce5980.jpg', 'Verified', 2, 'VALID', '2023-05-08 13:47:08'),
(23, 4, '6109011508710005', 'MAMAT', 'Jl. Masjid At-Taqwa\r\nRT.004/002, Kel. Mungguk,\r\nSekadau Hilir - Sekadau\r\n', '47', 'Badan-Usaha', '6458fd9d2d296.jpeg', 'Verified', 2, 'VALID', '2023-05-08 13:48:13'),
(24, 11, '6109014510780001', 'Dayang Jamilah', 'Jalan Masjid At-Taqwa, Rt.004 Rw. 001, Mungguk, Sekadau Hilir  Kalimantan Barat', '29,608', 'Badan-Usaha', '645b57cb691be.pdf', 'Verified', 2, 'ok', '2023-05-10 08:37:31'),
(25, 11, '6109012804780003', 'AB. Iwan Supardi', 'Jalan Keluarga, Rt.008 Rw, 002, Mungguk, Sekadau Hilir, Kalimantan Barat', '26.815', 'Badan-Usaha', '645b59cc0fecd.pdf', 'Verified', 2, 'ok', '2023-05-10 08:46:04'),
(26, 11, '3174043009770011', 'Mohammad Napis', 'Kebagusan Besar No. 38, Rt.009 Rw. 007, Kelurahan Kebagusan Kecamatan Pasar Minggu', '1.750', 'Badan-Usaha', '645b5a49ae314.pdf', 'Verified', 2, 'ok', '2023-05-10 08:48:09'),
(27, 12, '3277035704620005', 'JUTTAMI AVIANTY', 'JL. SANGKURIANG NO.7', '94,64 %', 'Badan-Usaha', '6462fb7f13e23.pdf', 'Verified', 2, 'ok', '2023-05-16 03:41:51'),
(28, 12, '3277031711600001', 'H. FEDDY ACHYANABADA', 'JL. SANGKURIANG NO. 7', '1,2 %', 'Badan-Usaha', '6462fc1d7f260.pdf', 'Verified', 2, 'ok', '2023-05-16 03:44:29'),
(29, 12, '3273182410660001', 'IR. DARWIN', 'JL. CIGADUNG RAYA BARAT NO. 143 ', '1 %', 'Badan-Usaha', '6462fe0469d8c.pdf', 'Verified', 2, 'ok', '2023-05-16 03:52:36'),
(30, 12, '3204060605530001', 'HENDAR SUHENDAR', 'JL. LIGAR AGUNG NO 17', '1 %', 'Badan-Usaha', '6462fe84b7a06.pdf', 'Verified', 2, 'ok', '2023-05-16 03:54:44'),
(31, 12, '3273020611920007', 'KIM NOFERIAN HERMANIE', 'JL. SANGKURIANG NO 7 ', '1 %', 'Badan-Usaha', '6462ff0ad40d5.pdf', 'Verified', 2, 'ok', '2023-05-16 03:56:58'),
(32, 12, '0903072109540038', 'ACHMAD HENDRA KOWARA', 'GANDARIA 8 OFFICE TOWER SUITE 17 K JL. SULTAN ISKANDAR JAKARTA SELATAN', '1 %', 'Badan-Usaha', '6462fffb7bd7f.jpg', 'Verified', 2, 'ok', '2023-05-16 04:00:59'),
(33, 16, '3172020104940001', 'PASKASIUS AGUNG APRILIAN', 'JL. M SANUN NO. 57, HARAPAN JAYA', '100', 'Perorangan', '64a8dc4144f7c.jpg', 'Pending', NULL, NULL, '2023-07-08 03:47:13'),
(34, 17, '7172024410940003', 'OKTAVIRA MARSELA LIMPONG', 'Jl.jendral sudirman\r\nKecamata Kota tengah\r\nKeluraha  Wumialo\r\nKota Gorontalo', '95% ', 'Perorangan', '64c899680e8f4.pdf', 'Pending', NULL, NULL, '2023-08-01 05:34:32');

-- --------------------------------------------------------

--
-- Table structure for table `pengalaman`
--

CREATE TABLE `pengalaman` (
  `id` smallint(6) NOT NULL,
  `id_profil` smallint(6) NOT NULL,
  `nama_pekerjaan` varchar(100) NOT NULL,
  `bidang_pekerjaan` text NOT NULL,
  `lokasi` text NOT NULL,
  `nama_pemberi` varchar(100) NOT NULL,
  `alamat_pemberi` text NOT NULL,
  `telepon_pemberi` varchar(100) NOT NULL,
  `no_kontrak` varchar(100) NOT NULL,
  `tgl_kontrak` varchar(100) NOT NULL,
  `nilai_kontrak` varchar(100) NOT NULL,
  `tgl_selesai` date NOT NULL,
  `tgl_berita_acara` date NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengalaman`
--

INSERT INTO `pengalaman` (`id`, `id_profil`, `nama_pekerjaan`, `bidang_pekerjaan`, `lokasi`, `nama_pemberi`, `alamat_pemberi`, `telepon_pemberi`, `no_kontrak`, `tgl_kontrak`, `nilai_kontrak`, `tgl_selesai`, `tgl_berita_acara`, `timestamp`) VALUES
(2, 6, 'DETAIL ENGINEERING DESIGN CONSULTANT TO SUPPORT UNIVERSITY OF JAMBI - SUMATERA (CSJ-02)', 'PERENCANA', 'Jambi', 'Universitas Jambi - Program Asian Development Bank', 'Jl. Raya Jambi-Muara Bulian KM.15 Mendalo Indah, Muaro Jambi, Jambi', '-', '02/UN21/ADB-UNJA/2020', '2020-12-28', '15204235080', '2024-04-28', '2021-11-09', '2023-05-04 09:05:08'),
(3, 6, 'Pengadaan Jasa Konsultansi Perencanaan Pembangunan Tower C Pusat Kanker Nasional RS. Kanker Dharmais', 'PERENCANA', 'Jakarta', 'RS. Kanker Dharmais', 'Jl. Let. Jend. S. Parman Kav. 84-86, Jakarta', '(021) 5681570', 'KN.01.01/7/891/2021', '2021-04-12', '8471867800', '2021-10-27', '2021-10-27', '2023-05-04 09:06:51'),
(4, 6, 'Pengawas Pekerjaan Pembuatan Patung, Plaza dan Pedestal Patung Ir. H. Soekarno di POLDER Semarang', 'Pengawasan', 'Semarang', 'PT. Kereta Api Indonesia (PERSERO)', 'Kantor Pusat Jakarta', '-', 'KM.201/VII/25/KA-2020 ', '2020-07-17', '488620000', '2021-04-09', '2021-04-08', '2023-05-04 09:08:40'),
(5, 8, 'PERENCANAAN DED DAN MASTER PLAN KAMPUS POLTEKPAR JAWA TENGAH', 'AR001 DAN RK001', '  Daerah  Kelurahan  Kwangen  dan Ngembatpadas,  Kecamatan  Gemolong Sragen - Jawa Tengah ', 'Politeknik Pariwisata Bali', 'Jl. Dharmawangsa Kampial, Kel. Benoa Kec. Kuta Selatan - Prov. Bali  ', '(0361) 773537', 'KU.103-BM-SP/04/PTP-II/KEMPAR/2022', '2022-09-16', '8344289000', '2022-12-29', '2022-12-29', '2023-05-08 11:19:52'),
(6, 8, 'PENYUSUNAN BLOK PLAN KAMPUS SEKARAN DAN DED TERPILIH UNIVERSITAS NEGERI SEMARANG TAHUN ANGGARAN 2022', 'AR001 DAN RK001', 'kampus  UNNES  di Semarang dan Tegal JATENG', 'Universitas Negeri Semarang', 'Kampus Sekaran, Gunung Pati, Semarang - Jateng ', '(024) 8508078', '1.26.8/UN37/PPK.2.6/2022', '2022-08-26', '7235202000', '2022-12-23', '2022-12-23', '2023-05-08 11:23:23'),
(7, 8, 'PERENCANAAN DED SARANA DAN PRASARANA PENUNJANG SERTA INFRASTRUKTUR SEKOLAH TINGGI PARIWISATA BANDUNG', 'AR001 DAN RK001', 'Bandung - Jawa Barat', 'Sekolah Tinggi Pariwisata Bandung', 'Jl. Dr. Setiabudhi No. 186 Bandung', '-', '004/KONTRAK/PPK/STPB/01/2022', '2022-01-06', '5725549500', '2022-07-04', '2022-07-04', '2023-05-08 11:27:47'),
(8, 8, 'DED PEMBANGUNAN KAWASAN PENGEMBANGAN MENTALITAS PANCASILA TAHUN 2022 (UNIVERSITAS NEGERI MANADO)', 'AR001 DAN RK001', 'Jl.  Kampus  Unima Tondano - Sulawesu Utara ', 'Universitas Negeri Manado', 'Jl.  Kampus  Unima Tondano - Sulawesu Utara ', ' (0431) 321845', '233/UN41/042.01.08/2022', '2022-02-04', '3433767700', '2023-05-04', '2022-05-04', '2023-05-08 11:29:48'),
(9, 8, 'PEKERJAAN JASA KONSULTANSI PERENCANA PEMBANGUNAN GEDUNG PARKIR POLRES METRO JAKARTA BARAT T.A. 2022', 'AR001 DAN RK001', 'Jl.  Daan  Mogot  , Kel.  Kedoya,  Kec.  Kebon  Jeruk,  Kota  Administrasi Jakarta Barat', 'Biro  Logistik Polda Metro Jaya', 'Jl. Jenderal Sudirman No.55 - Jakarta 12190', '-', 'SPKP/25/II/2022/APBN/ROLOG', '2022-02-02', '2718298000', '2022-04-03', '2022-04-04', '2023-05-08 11:31:32'),
(10, 8, 'PERENCANAAN PEMBANGUNAN GEDUNG KULIAH DIGITAL TERPADU UNDANA (UNIVERSITAS NUSA CENDANA)', 'AR001 DAN RK001', '  Jl.  Adisucipto-Penfui- Kupang-Nusa Tenggara Timur', 'Universitas Nusa  Cendana  Kupang', ' Jl.  Adisucipto-Penfui- Kupang-Nusa Tenggara Timur', '-', '42/un15.PPK/KTR/VI/2022', '2022-06-13', '5146083000', '2022-11-10', '2022-11-10', '2023-05-08 11:33:30');

-- --------------------------------------------------------

--
-- Table structure for table `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id` smallint(6) NOT NULL,
  `pekerjaan` text NOT NULL,
  `nama_perusahaan` varchar(100) NOT NULL,
  `nilai` int(11) NOT NULL,
  `tahun_anggaran` smallint(4) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengurus`
--

CREATE TABLE `pengurus` (
  `id` smallint(2) NOT NULL,
  `id_profil` smallint(6) NOT NULL,
  `jabatan` enum('Komisaris-Utama','Komisaris','Direktur-Utama','Direktur','Wakil-Direktur') NOT NULL,
  `nomor_ktp` varchar(50) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `file` varchar(100) NOT NULL,
  `status` enum('Pending','Waiting','Verified') NOT NULL,
  `id_operator` smallint(2) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengurus`
--

INSERT INTO `pengurus` (`id`, `id_profil`, `jabatan`, `nomor_ktp`, `nama`, `alamat`, `file`, `status`, `id_operator`, `catatan`, `timestamp`) VALUES
(1, 1, 'Direktur', '7501031002870002', 'Febriyanto Rifandy Ishak', 'Jl. Bandeng, Kel. Ipilo Kec. Kota Timur Kota Gorontalo', '644a76019b728.pdf', 'Verified', 2, 'VALID', '2023-04-27 13:17:53'),
(2, 1, 'Wakil-Direktur', '7571016107910001', 'Anita Yuliyana Djakatara', 'Jl. Raja Eyato 3, Kel. Buladu Kec. Kota Barat Kota Gorontalo', '644a765ad1574.pdf', 'Verified', 2, 'VALID', '2023-04-27 13:19:22'),
(3, 2, 'Direktur', '7501021812820001', 'IBRAHIM GOBEL, SE', 'DUSUN II, KELURAHAN LUHU, KECAMATAN TELAGA, KABUPATEN GORONTALO', '644b750d82e50.pdf', 'Verified', 2, 'valid', '2023-04-28 07:26:05'),
(4, 2, 'Wakil-Direktur', '7501171011800001', 'HAMZAH RIFAI', 'JL. BOTULIODU, RT. 003/RW. 001, POHE, HULOTHALANGI', '644b760358ffe.pdf', 'Verified', 2, 'valid', '2023-04-28 07:30:11'),
(5, 3, 'Komisaris-Utama', '6109012807900005', 'Abang Masri', 'Jl. Masjid At Taqwa Rt 004 / 001 Kel. Mungguk Kec. Sekadau Hilir Kalimantan Barat', '644b79a35a4ea.pdf', 'Verified', 2, 'valid', '2023-04-28 07:45:39'),
(6, 3, 'Komisaris', '3171084512590002', 'Wajarwati', 'Jl. Kp. Pulo Gundul Johar Baru Jakarta Pusat', '644b79d083d2e.pdf', 'Verified', 2, 'valid', '2023-04-28 07:46:24'),
(7, 3, 'Direktur-Utama', '6109030609700004', 'Pensong, SE, M.Si', 'Dusun Tanjung RT.003/002 Nanga Taman, Sekadau, Kalimantan Barat', '644b79f498a50.pdf', 'Verified', 2, 'valid', '2023-04-28 07:47:00'),
(8, 3, 'Direktur', '3174081612660005', 'Atin Prihatin ', 'Jl. Rawajati Timur II No.27 Pancoran Jakarta Selatan', '644b7a13efa2e.pdf', 'Verified', 2, 'valid', '2023-04-28 07:47:31'),
(9, 6, 'Komisaris-Utama', '3174041501430003', 'Ir. Asdarianto Asmoeadji, IAI', 'Jl. Ampera III-23, Jakarta 12550', '6453705d197f2.pdf', 'Verified', 2, 'VALID', '2023-05-04 08:44:13'),
(10, 6, 'Komisaris', '3174050803770009', 'Ikhsan Asikin, SE', 'Komp. Deplu Cidodol No.31A Jakarta Selatan', '6453707ad7d48.pdf', 'Verified', 2, 'VALID', '2023-05-04 08:44:42'),
(11, 6, 'Direktur-Utama', '3174040610750010', 'Aswin Griksa Fitranto, ST', 'Jl. Masjid Al-Ridwan No. 34, Jatipadang, Pasar Minggu Jakarta Selatan 12540', '6453709b86db3.pdf', 'Verified', 2, 'VALID', '2023-05-04 08:45:15'),
(12, 6, 'Direktur', '3174045207730008', 'Asdiani Safitri Dewi, ST', 'Jl. Ampera III-23, Jakarta 12550', '645370c038b1c.pdf', 'Verified', 2, 'valid', '2023-05-04 08:45:52'),
(13, 6, 'Direktur', '3174046003460002', 'Ir. Intan Asdarianto, IAI', 'Jl. Ampera III-23, Jakarta 12550', '645370de4e259.pdf', 'Verified', 2, 'valid', '2023-05-04 08:46:22'),
(14, 9, 'Direktur-Utama', '3174052908650004', 'Drs. A. Muas, Akt', 'Jl. Pondok Pinang VI RT.008 RW.002 Pondok Pinang Jakarta Selatan', '6458b960c98d5.pdf', 'Verified', 2, 'valid', '2023-05-08 08:57:04'),
(15, 9, 'Direktur', '1173022807950006', 'Riefky Miharja, ST', 'Peutua Rumoh Rayeuk No.56 Tumpok Teungoh, Banda Sakti, Lhokseumawe, Aceh', '6458ba845284d.pdf', 'Verified', 2, 'valid', '2023-05-08 09:01:56'),
(16, 9, 'Direktur', '3578090610740001', 'Eko Hendra Kurniawan, ST, MT', 'Jl. Winguna Selatan VI/34 Rt.001/005, Gunung Anyar Tambak, Kota Surabaya', '6458bba8d401a.jpg', 'Verified', 2, 'valid', '2023-05-08 09:06:48'),
(17, 8, 'Komisaris-Utama', '3175030401510001', 'Ir. Sayoeti Soekamdi', 'Jl. Cakrawijaya XII B.G/6 Rt.001/012, Kel. Cipinang Muara Kec. Jatinegara, Jakarta Timur - DKI Jakarta', '6458bd53867d8.pdf', 'Verified', 2, 'valid', '2023-05-08 09:13:55'),
(18, 8, 'Komisaris', '3174041106510001', 'Ir. Ismunandar', 'Jl. Siaga Raya No. 17 A Pasar Minggu, Jakarta Selatan - DKI Jakarta', '6458bdbdb74a4.pdf', 'Verified', 2, 'valid', '2023-05-08 09:15:41'),
(19, 8, 'Direktur-Utama', '3275022708540007', 'Ir. Bagustanto. IAI 1', 'Jl. Cendana Raya No.59 Kel. Jakasampurna, Bekasi Barat, Kota Bekasi - Jawa Barat\r\n', '6458be1d91993.pdf', 'Verified', 2, 'valid', '2023-05-08 09:17:17'),
(20, 8, 'Direktur', '3674030810590001', 'Ir. H. Budiono Askandar, MBA ', 'Jl. Puter II ED. 2/2 Bintaro V Kota Tangerang Selatan - Prov Banten\r\n', '6458be86605a3.pdf', 'Verified', 2, 'valid', '2023-05-08 09:19:02'),
(21, 8, 'Direktur', '3674062511600013', 'Ir. Bambang Suprihadi', ' Jl. Benda Timur 3 E-69/7 Pamulang Tangerang -Prov Banten\r\n', '6458bef78f6ec.pdf', 'Verified', 2, 'valid', '2023-05-08 09:20:55'),
(22, 8, 'Direktur', '3173070708530013', 'Ir. Agus Sudjatmiko ', ' Jl. Anggrek Cendrawasih II/16  Jakarta Barat - DKI Jakarta\r\n', '6458ca0ca563a.pdf', 'Verified', 2, 'valid', '2023-05-08 10:08:12'),
(23, 8, 'Direktur', '3171071309700002 ', 'Nana Arthana Hamid. ST ', 'Jl. PAM Baru IV No. 23 RT. 015/006 Bendungan Hilir, Tanah Abang, Jakarta Pusat - DKI Jakarta\r\n', '6458ca8286398.jpg', 'Verified', 2, 'valid', '2023-05-08 10:10:10'),
(24, 8, 'Direktur', '3175071906570008', 'Ir. Sudirman Sibuea ', ' Jl. Taman Malaka Brt Blok E6 No. 18 Rt.001/009 \r\nMalaka Sari, Duren Sawit - Jakarta Timur\r\n', '6458cae93546d.jpg', 'Verified', 2, 'valid', '2023-05-08 10:11:53'),
(25, 8, 'Direktur', '3274090610730005', 'Pongky Hari Sulistyo. ST', ' Gg. Paso Srengseng Sawah Rt.011/009 Srengseg Sawah, Jagakarsa - Jakarta Selatan', '6458cb1e87b24.jpg', 'Verified', 2, 'valid', '2023-05-08 10:12:46'),
(26, 4, 'Direktur-Utama', '3201131706810006', 'EKO YUNIANTO', 'KP. SAWAH RT. 03/01 RAGAJAYA  KEC. BOJONG GEDE KAB BOGOR', '6458fada8124e.jpeg', 'Verified', 2, 'VALID', '2023-05-08 13:36:26'),
(27, 4, 'Direktur', '3174081602800003', 'ZULFIQAR RIFKY', 'JL. REMAJA NO. 82 RT.06/06 KEL. MAMPANG KEC . PANCORAN MAS DEPOK', '6458fb4fe0307.jpg', 'Verified', 2, 'VALID\r\n', '2023-05-08 13:38:23'),
(28, 4, 'Komisaris-Utama', '3174084703650005', 'NUZULLAH H', 'JL. KALIBATA UTARA I RT.01/02 KEL. KALIBATA KEC. PANCORAN JAKARTA SELATAN', '6458fbc712517.jpg', 'Verified', 2, 'VALID', '2023-05-08 13:40:23'),
(29, 11, 'Komisaris-Utama', '6109012804780003', 'Abang Iwan Supardi', 'Jalan Keluarga Rt.008 Rw. 002, Mungguk, Sekadau Provinsi Kalimantan Barat', '645b529cc83b9.jpeg', 'Verified', 2, 'ok', '2023-05-10 08:15:24'),
(30, 11, 'Komisaris', '3174043009770011', 'Mohammad Napis', 'Kebagusan Besar No. 38 Rt.009 Rw.007 Kebagusan Pasar Minggu, Jakarta Selatan', '645b534b4cdd6.jpeg', 'Verified', 2, 'ok', '2023-05-10 08:18:19'),
(31, 11, 'Direktur', '6109014510780001', 'Dayang Jamilah', 'Jl. Masji At-Taqwa Rt.004 Rw.001, Mungguk Sekadau Hilir, Kalimantan Barat', '645b53d3ae351.jpg', 'Verified', 2, 'ok', '2023-05-10 08:20:35'),
(32, 11, 'Direktur-Utama', '3276071003690001', 'Budi Supriantoro', 'Blok Rambutan, Rt.001 Rw.004, Cipayung Kota Depok, Jawa Barat', '645b5448adaf5.jpg', 'Verified', 2, 'ok', '2023-05-10 08:22:32'),
(33, 12, 'Direktur', '3273182410660001', 'IR. DARWIN', 'JL. CIGADUNG RAYA BARAT NO 143', '6462f8be2d66a.pdf', 'Verified', 2, 'ok', '2023-05-16 03:30:06'),
(34, 12, 'Komisaris', '3204060605530001', 'HENDAR SUHENDAR', 'JL. LIGAR AGUNG 17 CIBEUNYING', '6462f953a964c.pdf', 'Verified', 2, 'ok', '2023-05-16 03:32:35'),
(36, 16, 'Direktur-Utama', '3172020104940001', 'PASKASIUS AGUNG APRILIAN', 'KELAPA DUA, DEPOK', '64a8dc22626c7.jpg', 'Pending', NULL, NULL, '2023-07-08 03:46:42'),
(37, 17, 'Direktur-Utama', '7172024410940003', 'OKTAVIRA MARSELA LIMPONG', 'Jl.jendran sudirman kel.Wumialo kec.kota Tengah, Gorontalo', '64c898257b8a0.jpeg', 'Pending', NULL, NULL, '2023-08-01 05:29:09');

-- --------------------------------------------------------

--
-- Table structure for table `peralatan`
--

CREATE TABLE `peralatan` (
  `id` smallint(6) NOT NULL,
  `id_profil` smallint(6) NOT NULL,
  `jenis_peralatan` varchar(100) NOT NULL,
  `jumlah` varchar(50) NOT NULL,
  `kapasitas` varchar(100) NOT NULL,
  `merek` varchar(100) NOT NULL,
  `tahun` varchar(10) NOT NULL,
  `kondisi` varchar(100) NOT NULL,
  `lokasi` varchar(100) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peralatan`
--

INSERT INTO `peralatan` (`id`, `id_profil`, `jenis_peralatan`, `jumlah`, `kapasitas`, `merek`, `tahun`, `kondisi`, `lokasi`, `timestamp`) VALUES
(1, 3, 'Printer', '8', 'Standart', 'HP, Canonn', '2019', '90', 'Jakarta', '2023-05-04 03:41:33'),
(2, 3, 'Monitor', '15', 'Standart', 'Advan, Samsung, LG', '2018', '80', 'Jakarta', '2023-05-04 03:42:29'),
(3, 3, 'Meeting Table', '2', 'Standart', 'IKEA', '2016', '80', 'Jakarta', '2023-05-04 03:43:44'),
(4, 3, 'Laptop/Nootbook', '10', 'Standart', 'HP, Asus, Dell, Accer', '2017', '80', 'Jakarta', '2023-05-04 03:45:06'),
(5, 3, 'Infocus/Proyektor ', '2', 'Standart', 'Samsung', '2019', '90', 'Jakarta', '2023-05-04 03:45:39'),
(6, 3, 'CPU/Komputer', '12', 'Standart', 'AMD, Intel', '2017', '80', 'Jakarta', '2023-05-04 03:47:00'),
(7, 3, 'Waterpass', '3', 'Standart', 'Nikon AE 3, Japan,46686 ', '2015', '70', 'Jakarta', '2023-05-04 03:47:54'),
(8, 3, 'Universal Theodolte', '3', 'Standart', 'Wild T2, 256744', '2015', '80', 'Jakarta', '2023-05-04 03:48:36'),
(9, 3, 'Kamera', '5', 'Standart', 'Canonn', '2018', '80', 'Jakarta', '2023-05-04 03:49:27'),
(10, 3, 'Drafting Table', '5', 'Standart', 'Mutoh, MU95', '2015', '70', 'Jakarta', '2023-05-04 03:50:30'),
(11, 3, 'Light Table ', '6', 'Standart', 'Phillips', '2015', '70', 'Jakarta', '2023-05-04 03:51:12'),
(12, 3, 'Drafting Machines ', '7', 'Standart', 'Mutoh,Japan, MVF - 110', '2017', '80', 'Jakarta', '2023-05-04 03:52:03'),
(13, 6, 'Mesin Foto Copy Canon iR 3245 + Scanner', '1', 'A4, F4, dan A3', 'Canon', '2014', '100', 'Jakarta', '2023-05-04 09:19:38'),
(14, 8, 'Komputer / PC', '25', '500 GB', 'Intel Core i3', '2019', '95%', 'Jakarta', '2023-05-08 11:13:34'),
(15, 4, 'Computer ', '6', 'Cukup memadai', 'Thosiba', '2013', '80', 'Jakarta', '2023-05-10 03:19:34'),
(16, 4, 'Laptop & Note Book', '4', 'Cukup memadai', 'Asus, Toshiba, Acer', '2019', '95', 'Jakarta', '2023-05-10 03:20:38'),
(17, 4, 'Printer + Scaner', '4', 'Cukup memadai', 'Epson & Cannon ', '2017', '90', 'Jakarta', '2023-05-10 03:22:05'),
(18, 4, 'Camera', '2', 'Cukup memadai', 'Canon', '2017', '90', 'Jakarta', '2023-05-10 03:22:52'),
(19, 4, 'Kendaraaan Roda 4 ', '2', 'Cukup memadai', 'Toyota', '2017', '85', 'Jakarta', '2023-05-10 03:23:30'),
(20, 4, 'Kendaraaan Roda 2', '6', 'Cukup memadai', 'Honda & Yamaha', '2019', '90', 'Jakarta', '2023-05-10 03:24:33'),
(21, 4, 'Digitizer', '2', 'Cukup memadai', 'Summgraphic', '2017', '80', 'Jakarta', '2023-05-10 03:25:17'),
(22, 4, 'Plotter', '2', 'Cukup memadai', 'Teckjet Roll Ploter', '2013', '80', 'Jakarta', '2023-05-10 03:25:50'),
(23, 4, 'Universal Theodolite', '2', 'Cukup memadai', 'Wild T2, 256744', '2013', '80', 'Jakarta', '2023-05-10 03:26:33'),
(24, 4, 'GPS Geodetic ', '2', 'Cukup memadai', 'WGS 84', '2012', '80', 'Jakarta', '2023-05-10 03:27:01'),
(25, 16, 'KOMPUTER SERVER', '1', '1 TB', 'LENOVO', '2020', '85', 'CIBINONG', '2023-07-08 04:03:35');

-- --------------------------------------------------------

--
-- Table structure for table `profil_badan_usaha`
--

CREATE TABLE `profil_badan_usaha` (
  `id_profil` smallint(6) NOT NULL,
  `id_akun` smallint(6) NOT NULL,
  `npwp` varchar(50) NOT NULL,
  `badan_usaha` varchar(50) NOT NULL,
  `nama_perusahaan` varchar(100) NOT NULL,
  `status_usaha` enum('Pusat','Cabang') NOT NULL,
  `alamat` text NOT NULL,
  `provinsi` varchar(100) NOT NULL,
  `kab_kota` varchar(100) NOT NULL,
  `kode_pos` varchar(10) NOT NULL,
  `telepon` varchar(25) NOT NULL,
  `fax` varchar(25) NOT NULL,
  `website` varchar(100) NOT NULL,
  `contact_person` varchar(100) NOT NULL,
  `telepon_cp` varchar(25) NOT NULL,
  `status` enum('Belum-Verifikasi','Terverifikasi') NOT NULL,
  `verifikasi_oleh` smallint(6) NOT NULL,
  `registrasi` datetime DEFAULT NULL,
  `verifikasi_tgl` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profil_badan_usaha`
--

INSERT INTO `profil_badan_usaha` (`id_profil`, `id_akun`, `npwp`, `badan_usaha`, `nama_perusahaan`, `status_usaha`, `alamat`, `provinsi`, `kab_kota`, `kode_pos`, `telepon`, `fax`, `website`, `contact_person`, `telepon_cp`, `status`, `verifikasi_oleh`, `registrasi`, `verifikasi_tgl`) VALUES
(1, 1, '96.400.205.9-822.000', 'CV', 'Bengkel IT', 'Pusat', 'Jl. Raja Eyato 3, Kel. Buladu Kec. Kota Barat', 'Gorontalo', 'Kota Gorontalo', '96136', '085240049387', '', '', 'Febriyanto R. Ishak', '', 'Belum-Verifikasi', 0, '2023-04-27 12:46:08', NULL),
(2, 2, '02.394.728.6-822.000', 'CV', 'CV. GAMMA TEKNIK KONSULTAN', 'Pusat', 'JALAN LOKAKARYA PERUMAHAN TAMAN INDAH BLOK F, NO. 6, KELURAHAN WONGKADITI BARAT', 'GORONTALO', 'Kota Gorontalo', '96122', '081241555506', '', '', 'DANANG HADI', '081241555506', 'Belum-Verifikasi', 0, '2023-04-28 14:27:49', NULL),
(3, 3, '01.802.120.4-017.000', 'PT', 'BENNATIN SURYA CIPTA', 'Pusat', 'Jl. Raya Pasar Minggu KM.18 No.1 RT.002 RW,001 Kelurahan Pejaten Barat, Kecamatan Pasar Minggu', 'DKI Jakarta', 'Jakarta Selatan', '12510', '081536621040', '', '', 'Pensong, SE, MSi', '0217981546', 'Terverifikasi', 2, '2023-04-28 14:29:59', '2023-05-04 15:49:37'),
(4, 4, '01.945.382.8-061.000', 'PT', 'BENNANTA JASINDO', 'Pusat', 'Gedung Ganesa No. 8 Lt. 4 Jl. Raya Pasar Minggu 234, Duren Tiga, Pancoran - Jakarta Selatan', 'DKI Jakarta', 'Jakarta Selatan', '12740', '0217981028', '0217981028', '-', 'Zulfiqar Rifky', '081316553005', 'Terverifikasi', 2, '2023-04-28 15:28:10', '2023-05-11 14:31:02'),
(5, 5, '02.314.256.5-061.000', 'PT', 'SWASTIKA PERDANA CONSULTANT', 'Pusat', 'Gd. ILP Center L2-23, Jl. Raya Pasar Minggu No. 39A', 'DKI Jakarta', 'Jakarta Selatan', '12780', '08129232817', '', '', 'Bismo Bayu', '087782578121', 'Belum-Verifikasi', 0, '2023-05-04 11:33:47', NULL),
(6, 6, '01.332.587.3-017.000', 'PT', 'GRIKSA CIPTA', 'Pusat', 'Ruko Pelangi Jalan Kalibata Raya No.11-12 Blok C-D Kel. Rawajati, Kec. Pancoran', 'DKI JAKARTA', 'Kota Jakarta Selatan', '12750', '0217806162', '0217891936', 'www.griksa.com', 'ARIF PURWO PRASETYO', '082122819414', 'Terverifikasi', 2, '2023-05-04 14:01:02', '2023-05-05 14:24:46'),
(7, 7, '01.328.217.3-013.000', 'PT', 'Multi Karadiguna Jasa', 'Pusat', 'Jl. Ciputat Raya No.18B Rt.009 Rw.002, Pondok Pinang - Kebayoran  Lama', 'DKI Jakarta', 'Jakarta Selatan', '12310', '62217665828', '', '', 'Drs. A. Muas, Akt', '6282231497875', 'Belum-Verifikasi', 0, '2023-05-06 10:11:09', NULL),
(8, 8, '01.802.390.3-019.000', 'PT', 'PT. ARTEFAK ARKINDO', 'Pusat', 'ITS Tower Park Lt. 9 Unit 8, Jl. Raya Pasar MInggu No. 18 Pejaten Timur Pasar Minggu, Jakarta Selatan - DKI Jakarta', 'DKI Jakarta', 'Jakarta Selatan', '12740', '081298080767', '0217972084', 'https://www.artefakarkindo.co.id/', 'Kirpi Dwinawa Mrangguli', '082299144449', 'Terverifikasi', 2, '2023-05-08 14:49:40', '2023-05-10 15:27:25'),
(9, 9, '01.328.217.3-013.000', 'PT', 'Multi Karadiguna Jasa', 'Pusat', 'Jl. Ciputat Raya No.18B Rt.009 Rw.002, Pondok Pinang, Kebayoran Lama', 'DKI Jakarta', 'Jakarta Selatan', '12310', '7665828', '', '', 'A. Muas, Akt', '082231497875', 'Terverifikasi', 2, '2023-05-08 15:04:27', '2023-05-15 09:27:58'),
(10, 10, '01.118.581.6-428.000', 'PT', 'PT. BIRO ARSITEK DAN INSINJUR SANGKURIANG', 'Pusat', 'JL. KARANG TINGGAL NO 23, SUKAJADI ', 'JAWA BARAT', 'BANDUNG', '40162', '2031789', '2031787', 'www.sangkuriangpt.com', 'PRASETYO TEGUH PURNOMO', '088232712572', 'Belum-Verifikasi', 0, '2023-05-09 13:12:09', NULL),
(11, 11, '01.888.517.8-061.000', 'PT', 'PT. Angelia Oerip Mandiri', 'Pusat', 'Gedung Ganesa 3, Jalan Raya Pasar Minggu No.234, Kelurahan Duren Tiga, Kecamatan Pancoran, Jakarta Selatan ', 'DKI Jakarta', 'Jakarta Selatan', '12740', '02179187622', '', '-', '', '', 'Belum-Verifikasi', 0, '2023-05-10 14:15:10', NULL),
(12, 12, '01.118.581.6-428.000', 'PT', 'PT. BIRO ARSITEK DAN INSINJUR SANGKURIANG', 'Pusat', 'JL. Karang Tinggal No. 23', 'JAWA BARAT', 'BANDUNG', '40162', '2031789', '2031789', 'www.sangkuriangpt.com', 'PRASETYO TEGUH PURNOMO', '088232712572', 'Terverifikasi', 2, '2023-05-15 16:48:41', '2023-05-16 13:47:15'),
(13, 13, '72.003.128.5-822.000', 'PT', 'PARADHIGUNA DWIPANTARA LOKA', 'Pusat', 'Jalan Bali', 'Gorontalo', 'Gorontalo', '96127', '08114316979', '', '', 'Erick Rahmat Hippy', '08114316979', 'Belum-Verifikasi', 0, '2023-05-23 13:48:30', NULL),
(14, 14, '95.465.684.9-822.000', 'PT', 'PT. Borneo Insan Kreasi', 'Pusat', 'Jl. Rusli Datau II, Perumahan Griya Dulomo Indah Blok K3', 'Gorontalo', 'Gorontalo', '96123', '085157440137', '', '', 'Sunarti Akuba', '085157440137', 'Belum-Verifikasi', 0, '2023-05-26 11:45:57', NULL),
(15, 15, '65.320.376.0-822.000', 'CV', 'Cahaya Sekawan Nusantara', 'Pusat', 'Dusun Moronjoe Timur, Desa Tenilo', 'Gorontalo', 'Boalemo', '96261', '087844681540', '', '', 'Raffy', '087844681540', 'Belum-Verifikasi', 0, '2023-05-29 04:59:01', NULL),
(16, 16, '53.262.827.8-403.000', 'PT', 'PT. SOLUSI DATA DIAWAN', 'Pusat', 'JL. M SANUN NO. 57 RT 04 RW 08, HARAPAN JAYA', 'JAWA BARAT', 'KAB. BOGOR', '16914', '087770001494', '', 'https://sdone.co.id', 'PASKASIUS AGUNG APRILIAN', '087770001494', 'Belum-Verifikasi', 0, '2023-07-08 11:18:29', NULL),
(17, 17, '60.121.304.4-822.000', 'CV', 'CV PRADIPTA RAYA', 'Pusat', 'Jl.jendral sudirman \r\nKel.wumialo\r\nKec.kota Tengah\r\nGorontalo', 'Gorontalo', 'Kota Gorontalo', '96138', '089609192999', '', '', 'Ovira', '089609192999', 'Belum-Verifikasi', 0, '2023-07-31 15:59:08', NULL),
(18, 18, '43.017.866.5-542.000', 'CV', 'Segitiga Sama Sisi', 'Pusat', 'Gg Melati 1 No 419A, Kayen, Depok, Sleman, Yogyakarta, Indonesia', 'Yogyakarta', 'Sleman', '55281', '081228055842', '00000000', 'sesasi.id', 'Arvyno Rausan Fikri', '082236003707', 'Belum-Verifikasi', 0, '2024-02-29 14:22:46', NULL),
(19, 19, '02.319.254.5-432.000', 'PT', 'PT Tri Daya Prima', 'Pusat', 'Jl. Jend. A. Yani Ruko Mutiara Center Blok B10 No.2', 'Jawa Barat', 'Kota Bekasi', '17141', '02188967054', '', '', 'Junita', '082374451209', 'Belum-Verifikasi', 0, '2024-03-22 12:05:48', NULL),
(20, 20, '01.849.470.8-047.000', 'PT', 'PT VANADIA UTAMA', 'Pusat', 'Komplek Sentra Industri Terpadu Pantai Indah Kapuk Blok G1 No. 5 Jakarta Utara 14470', 'DKI Jakarta', 'Jakarta Utara', '14470', '02156982988', '02156982989', 'www.vanadia.co.id', 'Harry Prasetio', '085692917125', 'Belum-Verifikasi', 0, '2024-05-21 10:58:21', NULL),
(21, 21, '03.223.724.0-643.000', 'CV', 'PRATAMA ABADI SEJAHTERA', 'Pusat', 'Ruko Waru Sentra kav 16\r\nJl. Brigjen Katamso - Waru', 'JAWA TIMUR', 'Sidoarjo', '61256', '081333117903', '', '', 'Oktavia Madasari', '082233418746', 'Belum-Verifikasi', 0, '2024-07-08 14:40:43', NULL),
(22, 22, '63.685.349.1-822.000', 'CV', 'CAHAYA CARUNIA', 'Pusat', 'Jln. Gunung Boliohuto', 'Gorontalo', 'Kota Gorontalo', '96115', '081356534363', '', '', 'TAUFIK MAKANGIRAS', '081356534363', 'Belum-Verifikasi', 0, '2024-07-20 14:52:25', NULL),
(23, 23, '01.416.626.8-822.000', 'CV', 'Bina Karya JAya', 'Pusat', 'Jl.jaksa agung suptapto', 'Gorontalo', 'Kota gorontalo', '96115', '081243494500', '', '', 'Marwan Soleman', '', 'Belum-Verifikasi', 0, '2024-07-21 20:06:18', NULL),
(24, 24, '02.347.387.9-822.000', 'CV', 'CV Hartono Anugerah Audio', 'Pusat', 'Jl. Pengeran Diponegoro 95 Kel. Limba B Kec. Kota Selatan', 'Gorontalo', 'Kota Gorontalo', '96115', '082291471571', '04358536877', 'tidak ada', 'Herlina Terisno', '08123204440', 'Belum-Verifikasi', 0, '2024-08-06 13:16:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tdp`
--

CREATE TABLE `tdp` (
  `id` smallint(2) NOT NULL,
  `id_profil` smallint(6) NOT NULL,
  `nomor` varchar(50) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `masa_berlaku` date DEFAULT NULL,
  `file` varchar(100) NOT NULL,
  `status` enum('Pending','Waiting','Verified') NOT NULL,
  `id_operator` smallint(2) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tdp`
--

INSERT INTO `tdp` (`id`, `id_profil`, `nomor`, `tanggal`, `masa_berlaku`, `file`, `status`, `id_operator`, `catatan`, `timestamp`) VALUES
(1, 2, '8120114180194', '2018-09-08', '0001-01-01', '644b732b867dd.pdf', 'Verified', 2, 'valid', '2023-04-28 07:18:03'),
(2, 3, 'Nomor Induk Berusaha', '2019-11-22', '2100-11-22', '644b779551c21.pdf', 'Verified', 2, 'valid\r\n', '2023-04-28 07:36:53'),
(3, 4, '9120408931525', '2019-09-12', '2025-09-12', '64534d09e1a9e.pdf', 'Verified', 2, 'VALID', '2023-05-04 06:13:29'),
(4, 6, '9120206821346', '2019-08-14', '2035-12-31', '6453702ce3815.pdf', 'Verified', 2, 'VALID', '2023-05-04 08:43:24'),
(5, 9, '9120300762446', '2019-07-24', '9999-12-31', '6458b3b08afe1.pdf', 'Verified', 2, 'valid', '2023-05-08 08:32:48'),
(6, 8, '9120200590582', '2022-03-28', '2027-03-28', '6458b9a70bece.pdf', 'Verified', 2, 'valid', '2023-05-08 08:58:15'),
(7, 11, '0220106640942', '2020-06-03', '2023-12-03', '645b3abb7305d.pdf', 'Verified', 2, 'valid', '2023-05-10 06:33:31'),
(8, 12, '9120318080235', '2022-07-28', '2025-07-27', '646315554768f.pdf', 'Verified', 2, 'ok', '2023-05-16 05:32:05'),
(9, 17, '1407230024246', '2023-07-14', '2026-07-13', '64c88ee4a3159.pdf', 'Pending', NULL, NULL, '2023-08-01 04:49:40');

-- --------------------------------------------------------

--
-- Table structure for table `tenaga_ahli`
--

CREATE TABLE `tenaga_ahli` (
  `id` smallint(6) NOT NULL,
  `id_profil` smallint(6) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `pendidikan` varchar(100) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `pengalaman` text NOT NULL,
  `keahlian` text NOT NULL,
  `tahun_ijazah` smallint(6) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tenaga_ahli`
--

INSERT INTO `tenaga_ahli` (`id`, `id_profil`, `nama`, `tgl_lahir`, `pendidikan`, `jabatan`, `pengalaman`, `keahlian`, `tahun_ijazah`, `timestamp`) VALUES
(1, 3, 'rudi', '1987-09-12', 'S1', 'tenaga ahli', '15', 'Arsitek', 2006, '2023-05-04 06:45:49'),
(2, 6, 'Gita Ollinda Yuanita, ST', '1976-06-06', 'Sarjana ( S-1 ) Teknik Arsitektur', 'Ahli Arsitektur', '19', 'Ahli Arsitektur', 1999, '2023-05-04 08:54:58'),
(3, 6, 'Rini Setyowati, ST', '1989-08-11', 'Sarjana ( S-1 ) Teknik Arsitektur', 'Ahli Arsitektur', '7', 'Ahli Arsitektur', 2011, '2023-05-04 08:55:39'),
(4, 8, 'Ir. Moeslem Yunus', '1966-09-26', 'S1 ', 'TA. Arsitektur Team Leader', '27', 'TA. Arsitektur ', 1995, '2023-05-08 10:46:29'),
(5, 12, 'IR. NUR ACHMAD', '1967-09-27', 'S1 TEKNIK SIPIL, INSTITUT TEKNOLOGI BUDI UTOMO', 'TENAGA AHLI', '30', 'AHLI STRUKTUR', 1993, '2023-05-16 04:16:28'),
(6, 12, 'DORY ARDIANTOKO P, ST., MT', '1977-06-10', 'S2 TEKNIK ARSITEKTUR, ITB', 'TENAGA AHLI', '21', 'AHLI ARSITEKTUR', 2006, '2023-05-16 04:18:10'),
(7, 12, 'IR. ANDI GUNADI', '1968-04-24', 'S1 TEKNIK ARSITEKUR, ITENAS', 'TENAGA AHLI', '30', 'AHLI ARSITEKTUR', 1993, '2023-05-16 04:19:14'),
(8, 12, 'IPAN SETIAWAN', '1984-10-15', 'S1 TEKNIK ARSITEKUR, UNIKOM', 'TENAGA AHLI', '12', 'AHLI ARSITEKTUR', 2008, '2023-05-16 04:20:18'),
(9, 12, 'TEGUH CAHYONO, ST', '1963-06-03', 'S1 TEKNIK MESIN, UNIVERSITAS PASUNDAN', 'TENAGA AHLI', '24', 'AHLI MEKANIKAL', 1997, '2023-05-16 04:21:49'),
(10, 12, 'IR. MUHAMAD AMINUDIN', '1963-10-06', 'S1 TEKNIK ELETRO, ITENAS', 'TENAGA AHLI', '33', 'AHLI ELEKTRIKAL', 1990, '2023-05-16 04:24:23'),
(11, 12, 'DONI ROMDHONI, ST., MT', '1976-11-23', 'S2 MAGISTER TEKNIK, UNIVERSITAS SANGGA BUANA', 'TENAGA AHLI', '17', 'AHLI LINGKUNGAN', 2017, '2023-05-16 04:26:40'),
(12, 16, 'PASKASIUS AGUNG APRILIAN', '1994-04-01', 'S1', 'DIREKTUR UTAMA', '10', 'TEKNIK INFORMATIKA', 2012, '2023-07-08 04:02:57'),
(13, 17, 'SYAHRUL PRAYOGI LIGAWA', '2000-03-14', 'Sarjana teknik sipil', 'Penanggung jawab teknik (PJT)', '2023', 'Pelaksana pemeliharaan jalan', 2021, '2023-08-01 05:46:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akta`
--
ALTER TABLE `akta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `akun_penyedia`
--
ALTER TABLE `akun_penyedia`
  ADD PRIMARY KEY (`id_akun`);

--
-- Indexes for table `catatan`
--
ALTER TABLE `catatan`
  ADD PRIMARY KEY (`id_catatan`);

--
-- Indexes for table `company_profile`
--
ALTER TABLE `company_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dokumen_verifikasi`
--
ALTER TABLE `dokumen_verifikasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `domisili`
--
ALTER TABLE `domisili`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `download`
--
ALTER TABLE `download`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `info_penting`
--
ALTER TABLE `info_penting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `izin_usaha`
--
ALTER TABLE `izin_usaha`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `npwp`
--
ALTER TABLE `npwp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `operator`
--
ALTER TABLE `operator`
  ADD PRIMARY KEY (`id_operator`);

--
-- Indexes for table `pajak`
--
ALTER TABLE `pajak`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `panduan`
--
ALTER TABLE `panduan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pemilik_saham`
--
ALTER TABLE `pemilik_saham`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengalaman`
--
ALTER TABLE `pengalaman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengurus`
--
ALTER TABLE `pengurus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `peralatan`
--
ALTER TABLE `peralatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profil_badan_usaha`
--
ALTER TABLE `profil_badan_usaha`
  ADD PRIMARY KEY (`id_profil`);

--
-- Indexes for table `tdp`
--
ALTER TABLE `tdp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tenaga_ahli`
--
ALTER TABLE `tenaga_ahli`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akta`
--
ALTER TABLE `akta`
  MODIFY `id` smallint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `akun_penyedia`
--
ALTER TABLE `akun_penyedia`
  MODIFY `id_akun` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `catatan`
--
ALTER TABLE `catatan`
  MODIFY `id_catatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT for table `company_profile`
--
ALTER TABLE `company_profile`
  MODIFY `id` smallint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `dokumen_verifikasi`
--
ALTER TABLE `dokumen_verifikasi`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `domisili`
--
ALTER TABLE `domisili`
  MODIFY `id` smallint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `download`
--
ALTER TABLE `download`
  MODIFY `id` smallint(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `info_penting`
--
ALTER TABLE `info_penting`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `izin_usaha`
--
ALTER TABLE `izin_usaha`
  MODIFY `id` smallint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `npwp`
--
ALTER TABLE `npwp`
  MODIFY `id` smallint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `operator`
--
ALTER TABLE `operator`
  MODIFY `id_operator` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pajak`
--
ALTER TABLE `pajak`
  MODIFY `id` smallint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `panduan`
--
ALTER TABLE `panduan`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pemilik_saham`
--
ALTER TABLE `pemilik_saham`
  MODIFY `id` smallint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `pengalaman`
--
ALTER TABLE `pengalaman`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengurus`
--
ALTER TABLE `pengurus`
  MODIFY `id` smallint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `peralatan`
--
ALTER TABLE `peralatan`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `profil_badan_usaha`
--
ALTER TABLE `profil_badan_usaha`
  MODIFY `id_profil` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tdp`
--
ALTER TABLE `tdp`
  MODIFY `id` smallint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tenaga_ahli`
--
ALTER TABLE `tenaga_ahli`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

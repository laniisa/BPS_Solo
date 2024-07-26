-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 26, 2024 at 04:08 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dispos_bps`
--

-- --------------------------------------------------------

--
-- Table structure for table `berkas`
--

CREATE TABLE `berkas` (
  `id` int(11) NOT NULL,
  `id_surat` int(11) NOT NULL,
  `author` int(11) NOT NULL,
  `berkas` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kepala`
--

CREATE TABLE `kepala` (
  `id` int(11) NOT NULL,
  `catatan_kepala` int(11) NOT NULL,
  `tindak_lanjut` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_surat` int(11) NOT NULL,
  `catatan` text NOT NULL,
  `tindak_lanjut` text NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surat`
--

CREATE TABLE `surat` (
  `id` int(11) NOT NULL,
  `no_disposisi` varchar(20) NOT NULL,
  `no_surat` varchar(100) NOT NULL,
  `tgl_surat` date NOT NULL,
  `tgl_input` date NOT NULL,
  `tgl_disposisi` date NOT NULL,
  `tgl_dilaksanakan` date NOT NULL,
  `perihal` text NOT NULL,
  `asal` varchar(100) NOT NULL,
  `jenis_surat` varchar(7) NOT NULL,
  `berkas` varchar(50) NOT NULL,
  `status` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `surat`
--

INSERT INTO `surat` (`id`, `no_disposisi`, `no_surat`, `tgl_surat`, `tgl_input`, `tgl_disposisi`, `tgl_dilaksanakan`, `perihal`, `asal`, `jenis_surat`, `berkas`, `status`) VALUES
(3, '76', '09', '2024-07-10', '2024-07-23', '2024-07-20', '2024-07-22', 'polimila', 'prov', 'resmi', '', 'd'),
(4, '89', '738', '2024-07-02', '2024-07-24', '2024-07-13', '2024-07-13', 'mila', 'dncjc', 'nsjhd', 'nbkj', 'k'),
(5, 'kk', '89', '2024-07-09', '2024-07-24', '2024-07-20', '2024-07-06', 'jis', 'nammna', 'ajh', 'ina', 'n'),
(6, '88', '666', '2024-07-10', '2024-07-25', '2024-07-03', '2024-07-11', 'jn', 'huh', 'ii', 'uu', 'h'),
(7, '11', '11', '2024-07-25', '2024-07-25', '2024-07-25', '2024-07-25', 'mad', 'ank', 'na', '1481-4640-1-PB.pdf', 'm'),
(8, '12390', '33', '2024-07-25', '2024-07-25', '2024-07-25', '2024-07-25', 'amewe', 'a ,', 'ma', '770-Article_Text-2680-2-10-20220701_(1).pdf', 'm'),
(9, '', '5', '2024-07-25', '2024-07-25', '0000-00-00', '0000-00-00', 'mla', 'mls', 'xa', '125998854.pdf', 'd');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `email` varchar(50) NOT NULL,
  `password` varchar(300) NOT NULL,
  `id_role` int(11) DEFAULT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `role` varchar(6) NOT NULL,
  `status` varchar(7) NOT NULL,
  `usr` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `whatsApp` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama`, `role`, `status`, `usr`, `email`, `whatsApp`, `password`) VALUES
(1, 'lani', '1', 'Active', 'laniisa', 'lan@gmail.com', '0876543', '$2y$10$PAN8FquBxZJ5tQjUN9r06uePvj9EFN.d6..WJd.kaUvoB2maJJqJK'),
(2, 'Mila', '3', 'active', 'mila', 'mila@gmail.com', '0897654', '$2y$10$rcndayKmtvoTzxVvReqnFOq.HXEWVZEcv6q3BDLmvRK4lfhgdO3GW'),
(3, 'laniiii', '2', 'active', 'sa', 'sa@gmail.com', '09876', 'sa'),
(4, 'kami', '1', 'active', 'kami', 'kami@gmail.com', '08765', 'kami'),
(6, 'Lani', 'Operat', 'Active', 'lllll', 'lll@gmail.com', '0765', '$2y$10$ITMBlP5woVeLknzNkRO5j.eCs/av2w12AYb8yGSLggT.evgY0WFoi'),
(8, 'Lani', 'Operat', 'Active', 'lllll', 'lisaaa@gmail.com', '0765', '$2y$10$de2Ual3gJlQE99AUxwQE3eZ6z5Mbpa1LtNOaJsrFxxjz6t.CFXBFq'),
(9, 'kamm', '3', 'active', 'kamm', 'kamm@gmail.com', '0785842', '$2y$10$acNJsFhnmUnRnAltjahoUeza7Hc44wuTU7KTstwfjCAU7kNBHrpYq');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(0, 'admin'),
(1, 'struktural'),
(2, 'fungsional'),
(3, 'operator');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `berkas`
--
ALTER TABLE `berkas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kepala`
--
ALTER TABLE `kepala`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surat`
--
ALTER TABLE `surat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `berkas`
--
ALTER TABLE `berkas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kepala`
--
ALTER TABLE `kepala`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `surat`
--
ALTER TABLE `surat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

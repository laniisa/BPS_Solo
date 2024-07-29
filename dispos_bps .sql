-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 28, 2024 at 03:05 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

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
-- Table structure for table `kepala`
--

CREATE TABLE `kepala` (
  `id_ds_kepala` int(11) NOT NULL,
  `catatan_kepala` int(11) NOT NULL,
  `tindak_lanjut` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kepala`
--

INSERT INTO `kepala` (`id_ds_kepala`, `catatan_kepala`, `tindak_lanjut`, `id_user`) VALUES
(1, 0, 0, 1);

--
-- Triggers `kepala`
--
DELIMITER $$
CREATE TRIGGER `after_kepala_insert` AFTER INSERT ON `kepala` FOR EACH ROW BEGIN
  INSERT INTO role (id_user, id_user_role) VALUES (NEW.id_user, 1);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id_ds_pegawai` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_surat` int(11) NOT NULL,
  `catatan` text NOT NULL,
  `tindak_lanjut` text NOT NULL,
  `tanggal` date NOT NULL,
  `id_ds_kepala` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_user_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `surat`
--

CREATE TABLE `surat` (
  `id_ds_surat` int(11) NOT NULL,
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
  `status` char(1) NOT NULL,
  `id_ds_kepala` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `surat`
--

INSERT INTO `surat` (`id_ds_surat`, `no_disposisi`, `no_surat`, `tgl_surat`, `tgl_input`, `tgl_disposisi`, `tgl_dilaksanakan`, `perihal`, `asal`, `jenis_surat`, `berkas`, `status`, `id_ds_kepala`) VALUES
(3, '76', '09', '2024-07-10', '2024-07-23', '2024-07-20', '2024-07-22', 'poli', 'prov', 'resmi', 'ko', 'd', 1),
(4, '89', '738', '2024-07-02', '2024-07-24', '2024-07-13', '2024-07-13', 'mila', 'dncjc', 'nsjhd', 'nbkj', 'k', 1),
(5, 'kk', '89', '2024-07-09', '2024-07-24', '2024-07-20', '2024-07-06', 'jis', 'nammna', 'ajh', 'ina', 'n', 1),
(6, '88', '666', '2024-07-10', '2024-07-25', '2024-07-03', '2024-07-11', 'jn', 'huh', 'ii', 'uu', 'h', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usr` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `whatsApp` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama`, `role`, `status`, `usr`, `email`, `whatsApp`, `password`) VALUES
(1, 'laniio', 'Admin', 'Active', 'lanii', 'lan@gmail.com', '0876543', '$2y$10$MXkLH6Hadi67vU/rjmOh..r9K/Q2cd.i7jJnnhomjZPknQzh1Pcv.'),
(2, 'Mila', '3', 'active', 'mila', 'mila@gmail.com', '0897654', '$2y$10$rcndayKmtvoTzxVvReqnFOq.HXEWVZEcv6q3BDLmvRK4lfhgdO3GW'),
(3, 'laniiii', '2', 'active', 'sa', 'sa@gmail.com', '09876', 'sa'),
(4, 'kami', '1', 'active', 'kami', 'kami@gmail.com', '08765', 'kami'),
(7, 'k', 'Strukt', 'Active', 'kk', 'k@gmail.com', '00', '$2y$10$SI1Jylejbx7VVcdL8Smfgeg6fL3EHlLaUgwFUkh0h3c4u3h27wKPm');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id_user_role` int(11) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id_user_role`, `role`) VALUES
(0, 'admin'),
(1, 'struktural'),
(2, 'fungsional'),
(3, 'operator');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kepala`
--
ALTER TABLE `kepala`
  ADD PRIMARY KEY (`id_ds_kepala`),
  ADD KEY `fk_id_kepala` (`id_user`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id_ds_pegawai`),
  ADD KEY `fk_kepala` (`id_ds_kepala`),
  ADD KEY `fk_id_user` (`id_user`),
  ADD KEY `fk_id_surat` (`id_surat`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_role_user` (`id_user`),
  ADD KEY `fk_id_user_role` (`id_user_role`);

--
-- Indexes for table `surat`
--
ALTER TABLE `surat`
  ADD PRIMARY KEY (`id_ds_surat`),
  ADD KEY `fk_id_ds_kepala` (`id_ds_kepala`);

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
  ADD PRIMARY KEY (`id_user_role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kepala`
--
ALTER TABLE `kepala`
  MODIFY `id_ds_kepala` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id_ds_pegawai` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `surat`
--
ALTER TABLE `surat`
  MODIFY `id_ds_surat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kepala`
--
ALTER TABLE `kepala`
  ADD CONSTRAINT `fk_id_kepala` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `fk_id_surat` FOREIGN KEY (`id_surat`) REFERENCES `surat` (`id_ds_surat`),
  ADD CONSTRAINT `fk_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `fk_kepala` FOREIGN KEY (`id_ds_kepala`) REFERENCES `kepala` (`id_ds_kepala`);

--
-- Constraints for table `role`
--
ALTER TABLE `role`
  ADD CONSTRAINT `fk_id_role_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `fk_id_user_role` FOREIGN KEY (`id_user_role`) REFERENCES `user_role` (`id_user_role`);

--
-- Constraints for table `surat`
--
ALTER TABLE `surat`
  ADD CONSTRAINT `fk_id_ds_kepala` FOREIGN KEY (`id_ds_kepala`) REFERENCES `kepala` (`id_ds_kepala`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

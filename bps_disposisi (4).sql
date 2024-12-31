-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 31, 2024 at 03:42 AM
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
-- Database: `bps_disposisi`
--

-- --------------------------------------------------------

--
-- Table structure for table `disposisi`
--

CREATE TABLE `disposisi` (
  `no_disposisi` int NOT NULL,
  `id_ds_surat` int NOT NULL,
  `id_disposisi` int DEFAULT NULL,
  `user_tujuan` int DEFAULT NULL,
  `status` varchar(11) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `disposisi`
--

INSERT INTO `disposisi` (`no_disposisi`, `id_ds_surat`, `id_disposisi`, `user_tujuan`, `status`) VALUES
(185, 122, 171, 18, 'diteruskan'),
(186, 122, 172, 14, 'diteruskan'),
(197, 122, 183, NULL, 'dilaksanaka'),
(198, 124, 184, 18, 'diteruskan'),
(199, 124, 185, 14, 'diteruskan'),
(200, 124, 186, 14, 'diteruskan'),
(201, 125, 187, 18, 'diteruskan'),
(202, 125, 188, 14, 'diteruskan'),
(203, 126, 189, 12, 'diteruskan'),
(204, 126, 189, 18, 'diteruskan'),
(205, 126, 190, 14, 'diteruskan'),
(206, 124, 191, 12, 'diteruskan'),
(207, 125, 192, 12, 'diteruskan'),
(208, 126, 193, NULL, 'dilaksanaka'),
(209, 127, 194, 18, 'diteruskan'),
(210, 127, 195, NULL, 'dilaksanaka'),
(211, 128, 196, 18, 'diteruskan'),
(212, 129, 197, 18, 'diteruskan'),
(213, 130, 198, 18, 'diteruskan'),
(214, 136, 199, 18, 'diteruskan'),
(215, 131, 200, 14, 'diteruskan'),
(216, 128, 201, NULL, 'dilaksanaka'),
(217, 129, 202, 14, 'diteruskan'),
(218, 132, 203, 18, 'diteruskan'),
(219, 130, 204, 14, 'diteruskan'),
(220, 136, 205, NULL, 'dilaksanaka'),
(221, 133, 206, 12, 'diteruskan'),
(222, 133, 206, 14, 'diteruskan'),
(223, 133, 206, 18, 'diteruskan'),
(224, 132, 207, 14, 'diteruskan'),
(225, 133, 208, NULL, 'dilaksanaka'),
(226, 134, 209, NULL, 'dilaksanaka'),
(227, 135, 210, 18, 'diteruskan'),
(228, 135, 211, 14, 'diteruskan'),
(229, 135, 212, NULL, 'dilaksanaka'),
(230, 132, 213, NULL, 'dilaksanaka'),
(231, 131, 214, NULL, 'dilaksanaka'),
(232, 137, 215, 12, 'diteruskan'),
(233, 129, 216, NULL, 'dilaksanaka');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id_disposisi` int NOT NULL,
  `id_user` int NOT NULL,
  `id_surat` int NOT NULL,
  `catatan` text COLLATE utf8mb4_general_ci,
  `tindak_lanjut` text COLLATE utf8mb4_general_ci,
  `tanggal` date DEFAULT NULL,
  `action_click` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id_disposisi`, `id_user`, `id_surat`, `catatan`, `tindak_lanjut`, `tanggal`, `action_click`) VALUES
(171, 9, 122, 'tolong di handle persiapannya ya', 'diteruskan', '2024-12-05', 1),
(172, 18, 122, NULL, 'diteruskan', '2024-12-05', 1),
(183, 14, 122, 'sukses', 'dilaksanakan', '2024-12-08', 2),
(184, 9, 124, 'Dipersiapkan data datanya yaa', 'diteruskan', '2024-12-08', 1),
(185, 18, 124, NULL, 'diteruskan', '2024-12-08', 1),
(186, 18, 124, NULL, 'diteruskan', '2024-12-08', 1),
(187, 9, 125, 'Dibaca yaa', 'diteruskan', '2024-12-08', 1),
(188, 18, 125, NULL, 'diteruskan', '2024-12-08', 1),
(189, 9, 126, 'ini bisa dibaca', 'diteruskan', '2024-12-08', 1),
(190, 18, 126, NULL, 'diteruskan', '2024-12-08', 1),
(191, 14, 124, NULL, 'diteruskan', '2024-12-08', 1),
(192, 14, 125, NULL, 'diteruskan', '2024-12-08', 1),
(193, 14, 126, 'sukses', 'dilaksanakan', '2024-12-08', 2),
(194, 9, 127, 'tolong dilaksanakan ya', 'diteruskan', '2024-12-08', 1),
(195, 18, 127, 'sukses', 'dilaksanakan', '2024-12-08', 1),
(196, 9, 128, 'm', 'diteruskan', '2024-12-08', 1),
(197, 9, 129, 'l', 'diteruskan', '2024-12-08', 1),
(198, 9, 130, 'f', 'diteruskan', '2024-12-08', 1),
(199, 9, 136, 'kk', 'diteruskan', '2024-12-08', 1),
(200, 9, 131, 'ini ya', 'diteruskan', '2024-12-08', 1),
(201, 18, 128, 'sukses', 'dilaksanakan', '2024-12-08', 1),
(202, 18, 129, NULL, 'diteruskan', '2024-12-08', 1),
(203, 9, 132, 'ini tolong di handle yaa', 'diteruskan', '2024-12-11', 1),
(204, 18, 130, NULL, 'diteruskan', '2024-12-11', 1),
(205, 18, 136, 'sukses', 'dilaksanakan', '2024-12-11', 1),
(206, 9, 133, 'tolong yaa', 'diteruskan', '2024-12-11', 1),
(207, 18, 132, NULL, 'diteruskan', '2024-12-11', 1),
(208, 18, 133, 'sukses', 'dilaksanakan', '2024-12-11', 1),
(209, 9, 134, 'sukses', 'dilaksanakan', '2024-12-12', 0),
(210, 9, 135, 'laksanakan ya', 'diteruskan', '2024-12-12', 1),
(211, 18, 135, NULL, 'diteruskan', '2024-12-12', 1),
(212, 14, 135, 'sukses', 'dilaksanakan', '2024-12-12', 2),
(213, 14, 132, 'sukses', 'dilaksanakan', '2024-12-21', 2),
(214, 14, 131, 'sukses', 'dilaksanakan', '2024-12-21', 1),
(215, 9, 137, 'tolong yaa', 'diteruskan', '2024-12-31', 1),
(216, 14, 129, 'sukses', 'dilaksanakan', '2024-12-31', 2);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int NOT NULL,
  `id_user` int NOT NULL,
  `id_user_role` int NOT NULL,
  `jabatan` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surat`
--

CREATE TABLE `surat` (
  `id_ds_surat` int NOT NULL,
  `no_surat` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tgl_surat` date NOT NULL,
  `tgl_input` date NOT NULL,
  `tgl_dilaksanakan` date NOT NULL,
  `perihal` text COLLATE utf8mb4_general_ci NOT NULL,
  `asal` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `jenis_surat` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `berkas` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `status` text COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `surat`
--

INSERT INTO `surat` (`id_ds_surat`, `no_surat`, `tgl_surat`, `tgl_input`, `tgl_dilaksanakan`, `perihal`, `asal`, `jenis_surat`, `berkas`, `status`, `user_id`) VALUES
(122, '1', '2024-12-05', '2024-12-05', '2024-12-08', 'Rapat di BPS Pusat', 'BPS Pusat', 'Formal', '2024-2024-12-052.pdf', 'dilaksanakan', 9),
(124, '2', '2024-12-01', '2024-12-08', '0000-00-00', 'Pengumpulan Data Statistik Bulanan', 'BPS Jawa Tengah', 'Formal', '2024-2024-12-01.pdf', 'diteruskan', 9),
(125, '3', '2024-12-06', '2024-12-08', '0000-00-00', 'Pedoman Pelaksanaan survei', 'BPS Pusat', 'Semi Fo', '2024-2024-12-062.pdf', 'diteruskan', 9),
(126, '4', '2025-01-04', '2024-12-08', '2024-12-08', 'Pengambilan Paper Survei Kemiskinan', 'BPS Semarang', 'Semi Fo', '2025-2025-01-041.pdf', 'dilaksanakan', 9),
(127, '5', '2024-12-13', '2024-12-08', '2024-12-08', 'Rapat Survei Kesejahteraan Masyarakat', 'BPS Semarang', 'Formal', '2024-2024-12-136.pdf', 'dilaksanakan', 9),
(128, '6', '2024-12-17', '2024-12-08', '2024-12-08', 'HUT BPS Se-Soloraya', 'BPS Surakarta', 'Non for', '2024-2024-12-17.pdf', 'dilaksanakan', 9),
(129, '7', '2024-12-10', '2024-12-08', '2024-12-31', 'Surat Pemberitahuan Survei Gizi', 'BPS Purbalingga', 'Formal', '2024-2024-12-10.pdf', 'dilaksanakan', 9),
(130, '8', '2024-12-18', '2024-12-08', '0000-00-00', 'Surat Kerjasama Pembuatan Survei Kemajuan Masyarakat', 'BPS Purwokerto', 'resmi', '2024-2024-12-181.pdf', 'diteruskan', 9),
(131, '9', '2024-12-25', '2024-12-08', '2024-12-21', 'Surat Perintah Observasi Lapangan ke Sulawesi', 'BPS Pusat', 'Resmi', '2024-2024-12-25.pdf', 'dilaksanakan', 9),
(132, '10', '2024-12-18', '2024-12-08', '2024-12-21', 'Surat Perekrutan Pegawai BPS Baru', 'BPS Semarang', 'Formal', '2024-2024-12-182.pdf', 'dilaksanakan', 9),
(133, '11', '2024-12-13', '2024-12-08', '2024-12-11', 'Surat Pelatihan Pegawai Baru', 'BPS Jawa Tengah', 'Resmi', '2024-2024-12-137.pdf', 'dilaksanakan', 9),
(134, '12', '2024-12-07', '2024-12-08', '2024-12-12', 'Surat Pengunduran Diri ', 'Soedarmono', 'Urgent', '2024-2024-12-073.pdf', 'dilaksanakan', 9),
(135, '13', '2024-12-07', '2024-12-08', '2024-12-12', 'Surat Pengajuan Magang', 'Universitas Jenderal Soedirman', 'Resmi', '2024-2024-12-074.pdf', 'dilaksanakan', 9),
(136, '14', '2024-12-12', '2024-12-08', '2024-12-11', 'Surat Pelamaran pekerjaan', 'Siti Munawaroh', 'Resmi', '2024-2024-12-122.pdf', 'dilaksanakan', 9),
(137, '15', '2024-12-27', '2024-12-21', '0000-00-00', 'Surat Perintah Upacara HUT RI', 'BPS Pusat', 'Formal', '2024-2024-12-27.pdf', 'diteruskan', 9);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` int NOT NULL,
  `status` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `usr` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `whatsApp` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama`, `role`, `status`, `usr`, `jabatan`, `email`, `whatsApp`, `password`, `foto`) VALUES
(1, 'lanii lanii', 0, 'active', 'lanii', 'kepala', 'lanii@gmail.com', '0876543', '$2y$10$MXkLH6Hadi67vU/rjmOh..r9K/Q2cd.i7jJnnhomjZPknQzh1Pcv.', 'WhatsApp_Image_2024-03-17_at_21_55_29_d4402d7b1.jp'),
(2, 'Mila', 0, 'active', 'mila', '', 'mila@gmail.com', '0897654', '$2y$10$rcndayKmtvoTzxVvReqnFOq.HXEWVZEcv6q3BDLmvRK4lfhgdO3GW', ''),
(8, 'sephi', 3, 'active', 'sephi', '', 'sephi@gmail.com', '0882682', '$2y$10$caTmcwJnH4T0nE.zVDtvm.jj1zLYiC.TCCEwHXYVdjttiSiz5F53.', ''),
(9, 'lisss', 1, 'active', 'liss', '', 'liss@gmail.com', '082962', '$2y$10$TSko0M0VyhGeaD5q9.e/MuxpzqNrKK4d2HNDSFA5EOQ0xOYhoXWha', ''),
(12, 'kamii', 2, 'active', 'kamila', '', 'kamila@gmail.com', '00', '$2y$10$KkCxFqfO.FWicYTcjMVnheeJXR8muI.AHZql9FMFmRwgmAdNKyOrq', ''),
(14, 'kami', 2, 'active', 'kamila', '', 'milaa@gmail.com', '0000', '$2y$10$XdFjYTuVIbgPMdL0M5AFyOfuJEG9zzBO6zK.L9kS44wBn6L3utBHu', ''),
(15, 'kasa', 1, 'active', 'kaka', '', 'kaka@gmail.com', '00', '$2y$10$4YqF4wkTgWGzsKohHV9r..eYiB8HBS2fXgylJyKuYdk/eF9EhBvXe', ''),
(16, 'Sikar', 0, 'active', 'sikar', 'staff', 'sikar@gmail.com', '082962', '$2y$10$5jO9O5U6UUwGnMx4vUAxBu1B0GJ4W.tdR8bqrnYshYwFO1MeKsz6m', 'WhatsApp_Image_2024-02-21_at_14_40_21_7c37fd28.jpg'),
(17, 'lanisaa', 1, 'active', 'lanisaa', 'kepala', 'lanisaa@gmail.com', '0987654', '$2y$10$hPXROOK8penqeVmlXTiNk.eynJKE4ptIHsxkIpJR1iI84at.pTlAi', 'WhatsApp_Image_2024-03-13_at_19_36_41_23e7536b.jpg'),
(18, 'sepilani', 2, 'active', 'sepilani', 'kepala', 'sepilani@gmail.com', '087654', '$2y$10$m6Sfm62XyWUO.1VO3sYk3evP5Q8gfMl3tvYlWi8h.5f1sLMFqSzPW', 'WhatsApp_Image_2024-02-21_at_14_40_21_7a84bffe.jpg'),
(19, 'lanisepi', 3, 'active', 'lanisepi', 'staff', 'lanisepi@gmail.com', '087654', '$2y$10$Ol2PPDcSo3JVOxtZlMqRKuI4mrn5uhrP/oVUSa4.zdx/Cl.nqUmdK', 'my+.jpg'),
(20, 'milakami', 0, 'active', 'milakami', 'kepala', 'milakami@gmail.com', '0786543', '$2y$10$rutfu9Hd.qNWijvO4eWUOuT9mc5ItIyGnEjBhNcBfULvO8WSpfAvC', 'WhatsApp_Image_2024-03-11_at_17_19_15_29343429.jpg'),
(21, 'Admin', 0, 'active', 'Admin', 'lainnya', 'admin@gmail.com', '089', '$2y$10$ndztA.y4rQaTAe4zjSWxqOTVMfdsInRqjbl6CfB15xhJzFXpbkarq', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id_user_role` int NOT NULL,
  `role` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Indexes for table `disposisi`
--
ALTER TABLE `disposisi`
  ADD PRIMARY KEY (`no_disposisi`),
  ADD KEY `fk_id_surat_disposisi` (`id_ds_surat`),
  ADD KEY `fk_id_pegawai_disposisi` (`id_disposisi`) USING BTREE;

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id_disposisi`) USING BTREE,
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
  ADD KEY `fk_user_id` (`user_id`);

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
-- AUTO_INCREMENT for table `disposisi`
--
ALTER TABLE `disposisi`
  MODIFY `no_disposisi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=234;

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id_disposisi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=217;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `surat`
--
ALTER TABLE `surat`
  MODIFY `id_ds_surat` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `disposisi`
--
ALTER TABLE `disposisi`
  ADD CONSTRAINT `fk_id_pegawai_disposisi` FOREIGN KEY (`id_disposisi`) REFERENCES `pegawai` (`id_disposisi`),
  ADD CONSTRAINT `fk_id_surat_disposisi` FOREIGN KEY (`id_ds_surat`) REFERENCES `surat` (`id_ds_surat`);

--
-- Constraints for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `fk_id_surat` FOREIGN KEY (`id_surat`) REFERENCES `surat` (`id_ds_surat`),
  ADD CONSTRAINT `fk_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

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
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

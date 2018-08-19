-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 15, 2018 at 07:55 AM
-- Server version: 10.1.34-MariaDB-0ubuntu0.18.04.1
-- PHP Version: 5.6.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `edisposisi`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_disposisi_surat` (IN `p_id_surat` INT, IN `p_level` ENUM('s','kb'), IN `p_id_bidang` INT)  NO SQL
BEGIN

IF (p_level = 's') THEN
    UPDATE surat
    SET level = p_level,
    status = 'd'
    WHERE id_surat = p_id_surat;
    
    INSERT INTO log_surat
    SET id_surat = p_id_surat,
    waktu = now(),
    aksi = 'd';
ELSEIF (p_level = 'kb') THEN
    UPDATE surat
    SET level = p_level,
    id_bidang = p_id_bidang,
    status = 'd'
    WHERE id_surat = p_id_surat;
    
    INSERT INTO log_surat
    SET id_surat = p_id_surat,
    waktu = now(),
    aksi = 'd',
    id_bidang = p_id_bidang;
END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_flush_surat` ()  NO SQL
BEGIN

DELETE FROM log_surat;

DELETE FROM surat;

END$$

CREATE DEFINER=`admin`@`localhost` PROCEDURE `sp_hapus_surat` (IN `p_id_surat` INT)  NO SQL
BEGIN

DELETE FROM log_surat
WHERE id_surat=  p_id_surat;

DELETE FROM surat
WHERE id_surat=  p_id_surat;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_proses_surat` (IN `p_id_surat` INT)  NO SQL
BEGIN

UPDATE surat
SET status = 'p'
WHERE id_surat = p_id_surat;

INSERT INTO log_surat
SET id_surat = p_id_surat,
waktu = now(),
aksi = 'p',
id_bidang = (SELECT id_bidang
             FROM surat
             WHERE id_surat = p_id_surat);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_selesai_surat` (IN `p_id_surat` INT)  NO SQL
BEGIN

UPDATE surat
SET status = 's'
WHERE id_surat = p_id_surat;

INSERT INTO log_surat
SET id_surat = p_id_surat,
waktu = now(),
aksi = 's',
id_bidang = (SELECT id_bidang
             FROM surat
             WHERE id_surat = p_id_surat);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tambah_surat` (IN `p_nosurat` VARCHAR(191), IN `p_tanggal_surat` DATE, IN `p_pengirim` VARCHAR(191), IN `p_perihal` VARCHAR(191), IN `p_nama_file` VARCHAR(191))  NO SQL
BEGIN

DECLARE v_id int(11);

INSERT INTO surat
SET nosurat = p_nosurat,
tanggal_surat = p_tanggal_surat,
pengirim = p_pengirim,
perihal = p_perihal,
nama_file = p_nama_file,
level = 'kd',
id_bidang = null,
status = 'm';

SELECT last_insert_id() INTO v_id;

INSERT INTO log_surat
SET id_surat = v_id,
waktu = now(),
aksi = 'm',
id_bidang = null;

SELECT v_id id;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `bidang`
--

CREATE TABLE `bidang` (
  `id_bidang` int(11) NOT NULL,
  `bidang` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bidang`
--

INSERT INTO `bidang` (`id_bidang`, `bidang`) VALUES
(11, 'Perekonomian dan Sumber Daya Alam'),
(12, 'Sosial Budaya dan Pemerintahan'),
(13, 'Infrastruktur dan Pengembangan Wilayah'),
(14, 'Pengendalian dan Litbang');

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE `config` (
  `judul_aplikasi` varchar(191) NOT NULL,
  `judul_menu` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`judul_aplikasi`, `judul_menu`) VALUES
('Bintang PAOK', 'KEMPLO');

-- --------------------------------------------------------

--
-- Table structure for table `log_surat`
--

CREATE TABLE `log_surat` (
  `id_log_surat` int(11) NOT NULL,
  `id_surat` int(11) NOT NULL,
  `waktu` datetime NOT NULL,
  `aksi` enum('d','p','s','m','t') NOT NULL,
  `id_bidang` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `log_surat`
--

INSERT INTO `log_surat` (`id_log_surat`, `id_surat`, `waktu`, `aksi`, `id_bidang`) VALUES
(1, 1, '2018-08-14 23:33:05', 'm', NULL),
(2, 2, '2018-08-14 23:33:44', 'm', NULL),
(3, 3, '2018-08-14 23:34:13', 'm', NULL),
(4, 2, '2018-08-14 23:54:46', 'p', NULL),
(5, 2, '2018-08-14 23:55:09', 'p', NULL),
(6, 2, '2018-08-14 23:55:14', 'p', NULL),
(7, 2, '2018-08-14 23:55:17', 'p', NULL),
(8, 1, '2018-08-14 23:56:32', 'p', NULL),
(9, 1, '2018-08-14 23:58:55', 's', NULL),
(10, 2, '2018-08-14 23:58:59', 's', NULL),
(11, 4, '2018-08-14 23:59:59', 'm', NULL),
(12, 5, '2018-08-15 00:07:43', 'm', NULL),
(13, 4, '2018-08-15 00:34:31', 'd', NULL),
(14, 4, '2018-08-15 00:36:25', 'd', 12),
(15, 4, '2018-08-15 00:36:59', 'p', 12),
(16, 4, '2018-08-15 00:37:04', 's', 12),
(17, 3, '2018-08-15 00:39:53', 'd', 14),
(18, 3, '2018-08-15 01:19:07', 'd', NULL),
(19, 3, '2018-08-15 01:19:26', 'd', 14),
(20, 3, '2018-08-15 01:19:40', 'p', 14),
(21, 3, '2018-08-15 01:19:47', 's', 14),
(22, 5, '2018-08-15 12:46:41', 'd', 12),
(23, 5, '2018-08-15 12:47:07', 'p', 12),
(24, 5, '2018-08-15 12:47:08', 's', 12),
(25, 6, '2018-08-15 12:47:26', 'm', NULL),
(26, 6, '2018-08-15 12:51:01', 't', NULL),
(27, 7, '2018-08-15 12:54:34', 'm', NULL),
(28, 7, '2018-08-15 12:54:52', 'd', 12),
(29, 7, '2018-08-15 12:55:07', 'p', 12),
(30, 7, '2018-08-15 12:55:09', 's', 12);

-- --------------------------------------------------------

--
-- Table structure for table `surat`
--

CREATE TABLE `surat` (
  `id_surat` int(11) NOT NULL,
  `nosurat` varchar(191) NOT NULL,
  `tanggal_surat` date NOT NULL,
  `pengirim` varchar(191) NOT NULL,
  `perihal` varchar(191) NOT NULL,
  `nama_file` varchar(191) NOT NULL,
  `level` enum('kd','s','kb') NOT NULL DEFAULT 'kd',
  `id_bidang` int(11) DEFAULT NULL,
  `status` enum('m','d','p','s','t') NOT NULL DEFAULT 'm'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `surat`
--

INSERT INTO `surat` (`id_surat`, `nosurat`, `tanggal_surat`, `pengirim`, `perihal`, `nama_file`, `level`, `id_bidang`, `status`) VALUES
(1, '132', '2018-08-14', 'Bapeda Lampung Timur', 'Undangan', 'Capture 2.PNG', 'kd', NULL, 's'),
(2, '123', '2018-08-12', 'Bapeda Lambar', 'Laporan', 'Capture 3.PNG', 'kd', NULL, 's'),
(3, '142', '2018-08-16', 'Bapeda Tuba', 'Undangan', 'Capture.PNG', 'kb', 14, 's'),
(4, '123', '2018-08-07', 'pundung', 'membuat penasaran', 'Koala.jpg', 'kb', 12, 's'),
(5, '125', '2018-08-17', 'agunngs', 'Laporan', 'Jellyfish.jpg', 'kb', 12, 's'),
(6, '78i', '2018-08-15', 'safasf', 'fdfsa', 'Screenshot from 2018-07-27 10-35-25.png', 'kd', NULL, 't'),
(7, '12312eqwasfdsf', '2018-08-15', 'qewfsegdfm', 'wqwafesg', 'halaman login.png', 'kb', 12, 's');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(191) NOT NULL,
  `password` varchar(191) NOT NULL,
  `nama` varchar(191) NOT NULL,
  `level` enum('a','kd','s','kb','o') NOT NULL,
  `id_bidang` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama`, `level`, `id_bidang`) VALUES
(1, 'admin', 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec', 'Administrator', 'a', NULL),
(2, 'sekertaris', 'd404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db', 'Sekertaris', 's', NULL),
(3, 'operator', 'd404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db', 'Operator', 'o', NULL),
(4, 'sosmbut', 'd404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db', 'Sos Mbut', 'kb', 12),
(5, 'kadis', 'd404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db', 'Kadis', 'kd', NULL),
(6, 'tika', '70b30dea1d4ba10adc90573c5b32b56e3d503f45f4cf8c55abc46cb2d963545f7f7e9930ea1297fd41c6153ba2808cc38f712b27b97df3364f53450863d95ab2', 'Tika Jembris', 'kb', 14);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bidang`
--
ALTER TABLE `bidang`
  ADD PRIMARY KEY (`id_bidang`);

--
-- Indexes for table `log_surat`
--
ALTER TABLE `log_surat`
  ADD PRIMARY KEY (`id_log_surat`),
  ADD KEY `surat_id` (`id_surat`),
  ADD KEY `bidang_id` (`id_bidang`);

--
-- Indexes for table `surat`
--
ALTER TABLE `surat`
  ADD PRIMARY KEY (`id_surat`),
  ADD KEY `bidang_id` (`id_bidang`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `bidang_id` (`id_bidang`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bidang`
--
ALTER TABLE `bidang`
  MODIFY `id_bidang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `log_surat`
--
ALTER TABLE `log_surat`
  MODIFY `id_log_surat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `surat`
--
ALTER TABLE `surat`
  MODIFY `id_surat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `log_surat`
--
ALTER TABLE `log_surat`
  ADD CONSTRAINT `log_surat_ibfk_1` FOREIGN KEY (`id_bidang`) REFERENCES `bidang` (`id_bidang`),
  ADD CONSTRAINT `log_surat_ibfk_2` FOREIGN KEY (`id_surat`) REFERENCES `surat` (`id_surat`);

--
-- Constraints for table `surat`
--
ALTER TABLE `surat`
  ADD CONSTRAINT `surat_ibfk_1` FOREIGN KEY (`id_bidang`) REFERENCES `bidang` (`id_bidang`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_bidang`) REFERENCES `bidang` (`id_bidang`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

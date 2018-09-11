-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 11, 2018 at 06:27 PM
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_disposisi_surat` (IN `p_id_surat` INT, IN `p_level` ENUM('kd','kb'), IN `p_id_bidang` INT)  NO SQL
BEGIN

IF (p_level = 'kd') THEN
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_hapus_surat` (IN `p_id_surat` INT)  NO SQL
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tambah_surat` (IN `p_nosurat` VARCHAR(191), IN `p_tanggal_surat` DATE, IN `p_pengirim` VARCHAR(191), IN `p_perihal` VARCHAR(191), IN `p_nama_file` VARCHAR(191), IN `p_id_jenis` INT, IN `p_prioritas` ENUM('st','t','n'))  NO SQL
BEGIN

DECLARE v_id int(11);

INSERT INTO surat
SET nosurat = p_nosurat,
tanggal_surat = p_tanggal_surat,
pengirim = p_pengirim,
perihal = p_perihal,
nama_file = p_nama_file,
level = 's',
id_bidang = null,
status = 'm',
id_jenis = p_id_jenis,
prioritas = p_prioritas;

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
-- Table structure for table `jenis`
--

CREATE TABLE `jenis` (
  `id_jenis` int(11) NOT NULL,
  `jenis` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jenis`
--

INSERT INTO `jenis` (`id_jenis`, `jenis`) VALUES
(1, 'Surat Undangan'),
(2, 'Surat Edaran'),
(3, 'Pengumuman'),
(4, 'Permohonan'),
(5, 'Memo');

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
(37, 15, '2018-09-11 22:38:38', 'm', NULL),
(38, 15, '2018-09-11 22:52:16', 'd', NULL),
(39, 15, '2018-09-11 22:53:43', 'd', 12),
(45, 18, '2018-09-11 23:02:57', 'm', NULL),
(46, 19, '2018-09-11 23:16:59', 'm', NULL),
(47, 20, '2018-09-11 23:18:18', 'm', NULL),
(48, 18, '2018-09-11 23:21:04', 'p', NULL);

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
  `id_jenis` int(11) NOT NULL,
  `prioritas` enum('st','t','n') NOT NULL,
  `status` enum('m','d','p','s','t') NOT NULL DEFAULT 'm'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `surat`
--

INSERT INTO `surat` (`id_surat`, `nosurat`, `tanggal_surat`, `pengirim`, `perihal`, `nama_file`, `level`, `id_bidang`, `id_jenis`, `prioritas`, `status`) VALUES
(15, '0101003', '2018-09-11', 'Sekretariat DPRD', 'Undangan Rapat Paripurna', 'Surat merupakan salah satu media komunikasi yang sangat penting dalam suatu instansi (Repaired) (Repaired).pdf', 'kb', 12, 1, 'st', 'd'),
(18, '0102003', '2018-09-11', 'Sekretariat Keuangan', 'Undangan Rapat Paripurna', 'METODE PELAKSANAAN.pdf', 's', NULL, 2, 't', 'p'),
(19, '0103003', '2018-09-11', 'Dinas Perhubungan', 'Permohonan Pencairan Dana', 'fixv1.docx', 's', NULL, 4, 'n', 'm'),
(20, '0103004', '2018-09-11', 'Dinas Perikanan', 'Permohonan Pencairan Dana', 'fix.docx', 's', NULL, 2, 'st', 'm');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(191) NOT NULL,
  `password` varchar(191) NOT NULL,
  `nama` varchar(191) NOT NULL,
  `level` enum('kd','s','kb','o') NOT NULL,
  `id_bidang` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama`, `level`, `id_bidang`) VALUES
(2, 'sekertaris', 'd404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db', 'Sekertaris', 's', NULL),
(3, 'operator', 'd404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db', 'Operator', 'o', NULL),
(4, 'sosbud', 'd404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db', 'Sosbud', 'kb', 12),
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
-- Indexes for table `jenis`
--
ALTER TABLE `jenis`
  ADD PRIMARY KEY (`id_jenis`);

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
  ADD KEY `bidang_id` (`id_bidang`),
  ADD KEY `id_jenis` (`id_jenis`);

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
-- AUTO_INCREMENT for table `jenis`
--
ALTER TABLE `jenis`
  MODIFY `id_jenis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `log_surat`
--
ALTER TABLE `log_surat`
  MODIFY `id_log_surat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `surat`
--
ALTER TABLE `surat`
  MODIFY `id_surat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
  ADD CONSTRAINT `surat_ibfk_1` FOREIGN KEY (`id_bidang`) REFERENCES `bidang` (`id_bidang`),
  ADD CONSTRAINT `surat_ibfk_2` FOREIGN KEY (`id_jenis`) REFERENCES `jenis` (`id_jenis`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_bidang`) REFERENCES `bidang` (`id_bidang`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 03, 2025 at 04:38 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `movies_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `chitiethd`
--

DROP TABLE IF EXISTS `chitiethd`;
CREATE TABLE IF NOT EXISTS `chitiethd` (
  `mahd` int NOT NULL,
  `maphim` int NOT NULL,
  `soluong` int DEFAULT '1',
  `gia` float DEFAULT NULL,
  PRIMARY KEY (`mahd`,`maphim`),
  KEY `fk_ct_phim` (`maphim`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `danhgia`
--

DROP TABLE IF EXISTS `danhgia`;
CREATE TABLE IF NOT EXISTS `danhgia` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(50) DEFAULT NULL,
  `maphim` int DEFAULT NULL,
  `sao` tinyint DEFAULT NULL,
  `noidung` text,
  `ngay` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_dg_kh` (`email`),
  KEY `fk_dg_phim` (`maphim`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `daodien`
--

DROP TABLE IF EXISTS `daodien`;
CREATE TABLE IF NOT EXISTS `daodien` (
  `madd` int NOT NULL AUTO_INCREMENT,
  `tendd` varchar(100) NOT NULL,
  PRIMARY KEY (`madd`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `daodien`
--

INSERT INTO `daodien` (`madd`, `tendd`) VALUES
(1, 'Christopher Nolan'),
(2, 'Hayao Miyazaki'),
(3, 'Bong Joon-ho'),
(4, 'Lam Duc Hiep');

-- --------------------------------------------------------

--
-- Table structure for table `hoadon`
--

DROP TABLE IF EXISTS `hoadon`;
CREATE TABLE IF NOT EXISTS `hoadon` (
  `mahd` int NOT NULL AUTO_INCREMENT,
  `email` varchar(50) DEFAULT NULL,
  `ngaylap` datetime DEFAULT CURRENT_TIMESTAMP,
  `trangthai` tinyint DEFAULT '0',
  PRIMARY KEY (`mahd`),
  KEY `fk_hd_kh` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `khachhang`
--

DROP TABLE IF EXISTS `khachhang`;
CREATE TABLE IF NOT EXISTS `khachhang` (
  `email` varchar(50) NOT NULL,
  `matkhau` varchar(255) DEFAULT NULL,
  `tenkh` varchar(100) DEFAULT NULL,
  `dienthoai` varchar(15) DEFAULT NULL,
  `diachi` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `phim`
--

DROP TABLE IF EXISTS `phim`;
CREATE TABLE IF NOT EXISTS `phim` (
  `maphim` int NOT NULL AUTO_INCREMENT,
  `tenphim` varchar(250) NOT NULL,
  `mota` text,
  `namsx` int DEFAULT NULL,
  `thoiluong` int DEFAULT NULL,
  `gia` float DEFAULT NULL,
  `poster` varchar(255) DEFAULT NULL,
  `madd` int DEFAULT NULL,
  `maloai` varchar(5) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`maphim`),
  KEY `fk_phim_dd` (`madd`),
  KEY `fk_phim_loai` (`maloai`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `phim`
--

INSERT INTO `phim` (`maphim`, `tenphim`, `mota`, `namsx`, `thoiluong`, `gia`, `poster`, `madd`, `maloai`, `created_at`) VALUES
(2, 'Spirited Away', 'During her family\'s move...', 2001, 125, 90000, 'spirited.jpg', 2, 'L03', '2025-12-03 03:15:32'),
(3, 'Parasite', 'Greed and class discrimination...', 2019, 132, 110000, 'parasite.jpg', 3, 'L02', '2025-12-03 03:15:32'),
(7, '31', '123', 3, 23, 3, NULL, NULL, NULL, '2025-12-03 03:47:13'),
(9, '13', '213', 213, 31, 123, 'p_692fb53dc693d.png', NULL, NULL, '2025-12-03 03:57:49'),
(10, 'adsasdad', '41', 2015, 123, 123, NULL, 1, 'L03', '2025-12-03 04:23:57');

-- --------------------------------------------------------

--
-- Table structure for table `theloai`
--

DROP TABLE IF EXISTS `theloai`;
CREATE TABLE IF NOT EXISTS `theloai` (
  `maloai` varchar(5) NOT NULL,
  `tenloai` varchar(50) NOT NULL,
  PRIMARY KEY (`maloai`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `theloai`
--

INSERT INTO `theloai` (`maloai`, `tenloai`) VALUES
('L02', 'Tâm lý'),
('L03', 'Hoạt hình');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chitiethd`
--
ALTER TABLE `chitiethd`
  ADD CONSTRAINT `fk_ct_hd` FOREIGN KEY (`mahd`) REFERENCES `hoadon` (`mahd`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ct_phim` FOREIGN KEY (`maphim`) REFERENCES `phim` (`maphim`) ON DELETE RESTRICT;

--
-- Constraints for table `danhgia`
--
ALTER TABLE `danhgia`
  ADD CONSTRAINT `fk_dg_kh` FOREIGN KEY (`email`) REFERENCES `khachhang` (`email`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_dg_phim` FOREIGN KEY (`maphim`) REFERENCES `phim` (`maphim`) ON DELETE CASCADE;

--
-- Constraints for table `hoadon`
--
ALTER TABLE `hoadon`
  ADD CONSTRAINT `fk_hd_kh` FOREIGN KEY (`email`) REFERENCES `khachhang` (`email`) ON DELETE SET NULL;

--
-- Constraints for table `phim`
--
ALTER TABLE `phim`
  ADD CONSTRAINT `fk_phim_dd` FOREIGN KEY (`madd`) REFERENCES `daodien` (`madd`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_phim_loai` FOREIGN KEY (`maloai`) REFERENCES `theloai` (`maloai`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

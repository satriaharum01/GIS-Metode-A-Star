-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 05, 2023 at 09:10 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel_meidy`
--

-- --------------------------------------------------------

--
-- Table structure for table `bus`
--

CREATE TABLE `bus` (
  `id` int(11) NOT NULL,
  `tipe` varchar(100) NOT NULL,
  `lambung` varchar(100) NOT NULL,
  `sumber_energi` varchar(50) NOT NULL,
  `jam_operasional` varchar(15) NOT NULL,
  `muatan` int(4) NOT NULL,
  `foto` varchar(250) NOT NULL DEFAULT 'none.jpg',
  `koridor_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bus`
--

INSERT INTO `bus` (`id`, `tipe`, `lambung`, `sumber_energi`, `jam_operasional`, `muatan`, `foto`, `koridor_id`, `created_at`, `updated_at`) VALUES
(4, 'Hino RK1 JSNL', 'TB-VII-01', 'DIESEL', '07.00 - 20.00', 25, 'Hino RK1_JSNL-TB-VII-01-.jpg', 10, '2023-03-06 02:37:07', '2023-05-22 20:03:45'),
(5, 'Hino RK1 JSNL', 'TB-VII-02', 'DIESEL', '07.00 - 20.00', 25, 'Hino RK1_JSNL-TB-VII-02-.jpg', 10, '2023-03-12 16:10:45', '2023-05-22 20:03:51'),
(6, 'Hino RK1 JSNL', 'TB-VII-03', 'DIESEL', '07.00 - 20.00', 25, 'Hino RK1_JSNL-TB-VII-03-.jpg', 10, '2023-03-12 16:13:08', '2023-05-22 20:03:56'),
(7, 'Hino RK1 JSNL', 'TB-VII-04', 'DIESEL', '07.00 - 20.00', 25, 'Hino RK1_JSNL-TB-VII-04-.jpg', 10, '2023-03-12 16:14:36', '2023-05-22 20:04:04'),
(8, 'Hino RK1 JSNL', 'TB-VII-05', 'DIESEL', '07.00 - 20.00', 25, 'Hino RK1_JSNL-TB-VII-05-.jpg', 10, '2023-03-12 16:15:19', '2023-05-22 20:04:10'),
(9, 'Hino RK1 JSNL', 'TB-VI-01', 'DIESEL', '07.00 - 20.00', 25, 'Hino RK1_JSNL-TB-VI-01-.jpg', 7, '2023-03-12 16:14:36', '2023-05-22 20:04:15'),
(10, 'Hino RK1 JSNL', 'TB-VI-02', 'DIESEL', '07.00 - 20.00', 25, 'Hino RK1_JSNL-TB-VI-02-.jpg', 7, '2023-03-12 16:14:36', '2023-05-22 20:04:22'),
(11, 'Hino RK1 JSNL', 'TB-VI-03', 'DIESEL', '07.00 - 20.00', 25, 'Hino RK1_JSNL-TB-VI-03-.jpg', 7, '2023-03-12 16:14:36', '2023-05-22 20:04:30'),
(12, 'Hino RK1 JSNL', 'TB-VI-04', 'DIESEL', '07.00 - 20.00', 25, 'Hino RK1_JSNL-TB-VI-04-.jpg', 7, '2023-03-12 16:14:36', '2023-05-22 20:04:39'),
(13, 'Hino RK1 JSNL', 'TB-VI-05', 'DIESEL', '07.00 - 20.00', 25, 'Hino RK1_JSNL-TB-VI-05-.jpg', 7, '2023-03-12 16:14:36', '2023-05-22 20:04:47'),
(14, 'Hino RK1 JSNL', 'TB-VI-06', 'DIESEL', '07.00 - 20.00', 25, 'Hino RK1_JSNL-TB-VI-06-.jpg', 7, '2023-03-12 16:14:36', '2023-05-22 20:04:55');

-- --------------------------------------------------------

--
-- Table structure for table `cordinat`
--

CREATE TABLE `cordinat` (
  `id_cords` int(11) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `halte_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cordinat`
--

INSERT INTO `cordinat` (`id_cords`, `latitude`, `longitude`, `keterangan`, `halte_id`, `created_at`, `updated_at`) VALUES
(2, 3.517706659737443, 98.6100793881656, 'Titik B', 18, '2023-02-25 23:32:44', '2023-02-25 23:32:44'),
(3, 3.51813729908721, 98.61041948841293, 'Titik C', 18, '2023-02-25 23:34:07', '2023-02-25 23:34:07'),
(4, 3.5184712973570105, 98.6100056680004, 'Titik D', 18, '2023-02-25 23:35:38', '2023-02-25 23:35:38'),
(10, 3.5174278575840665, 98.60953137644177, 'Titik E', 18, '2023-02-25 23:54:05', '2023-02-25 23:54:05'),
(11, 3.5178362996545247, 98.60990128829847, 'Titik F', 18, '2023-02-25 23:54:18', '2023-02-25 23:54:18'),
(12, 3.518117596697815, 98.61017710067837, 'Titik G', 18, '2023-02-25 23:54:24', '2023-02-25 23:54:24'),
(13, 3.5183371233198626, 98.60989278652279, 'Titik H', 18, '2023-02-25 23:54:29', '2023-02-25 23:54:29'),
(67, 3.4969523538659897, 98.59091562904801, 'B', 122, '2023-03-12 19:37:24', '2023-03-12 19:37:24'),
(60, 3.6062657809554137, 98.70969293295983, 'B', 33, '2023-03-05 18:18:48', '2023-03-05 18:18:48'),
(61, 3.606384047622083, 98.70687426903967, 'C', 33, '2023-03-05 18:19:34', '2023-03-05 18:19:34'),
(62, 3.603717146919561, 98.70676476061995, 'D', 33, '2023-03-05 18:20:19', '2023-03-05 18:20:19'),
(63, 3.5981452120174144, 98.70649249948427, 'E', 33, '2023-03-05 18:20:59', '2023-03-05 18:20:59'),
(64, 3.5979850490332903, 98.70663733877107, 'F', 33, '2023-03-05 18:21:20', '2023-03-05 18:21:20'),
(65, 3.603594433077294, 98.70960491876181, 'H', 33, '2023-03-05 18:22:13', '2023-03-05 18:22:13'),
(68, 3.495205636496593, 98.59193645182593, 'C', 122, '2023-03-12 19:37:51', '2023-03-12 19:37:51'),
(69, 3.4953341446747013, 98.59470646260628, 'D', 122, '2023-03-12 19:38:10', '2023-03-12 19:38:10'),
(70, 3.49229722769335, 98.59782387210342, 'E', 122, '2023-03-12 19:38:27', '2023-03-12 19:38:27'),
(71, 3.4920428168360274, 98.59819724480226, 'F', 122, '2023-03-12 19:39:06', '2023-03-12 19:39:06'),
(72, 3.493919718465178, 98.59888134879324, 'G', 122, '2023-03-12 19:39:17', '2023-03-12 19:39:17'),
(73, 3.494192290389601, 98.59845758296281, 'H', 122, '2023-03-12 19:39:26', '2023-03-12 19:39:26'),
(74, 3.6062702404811424, 98.70969465002447, 'B', 74, '2023-03-12 19:57:56', '2023-03-12 19:57:56'),
(75, 3.606375368882993, 98.70687382966953, 'C', 74, '2023-03-12 19:58:17', '2023-03-12 19:58:17'),
(76, 3.6037192923393127, 98.70675641545307, 'D', 74, '2023-03-12 19:58:41', '2023-03-12 19:58:41'),
(82, 3.5979194928535834, 98.70635994648009, 'F', 74, '2023-03-12 20:22:09', '2023-03-12 20:22:09'),
(81, 3.597912436025822, 98.7064527552084, 'E', 74, '2023-03-12 20:22:02', '2023-03-12 20:22:02'),
(80, 3.60359296834693, 98.7096098659454, 'H', 74, '2023-03-12 20:14:06', '2023-03-12 20:14:06'),
(83, 3.5991865890455133, 98.68119324819963, 'B', 25, '2023-03-12 20:48:53', '2023-03-12 20:48:53'),
(84, 3.598240000787727, 98.6815207557438, 'C', 25, '2023-03-12 20:49:09', '2023-03-12 20:49:09'),
(85, 3.599786961666431, 98.68266221657937, 'D', 25, '2023-03-12 20:51:22', '2023-03-12 20:51:22'),
(86, 3.598790062424751, 98.68303069163288, 'E', 25, '2023-03-12 20:51:35', '2023-03-12 20:51:35'),
(87, 3.598254781499596, 98.68153061678242, 'E1', 79, '2023-05-22 20:10:33', '2023-05-22 20:10:33'),
(88, 3.598872614740851, 98.68372144490934, 'E2', 79, '2023-05-22 20:10:42', '2023-05-22 20:10:42'),
(89, 3.5985005205732827, 98.69156092475686, 'E3', 79, '2023-05-22 20:10:58', '2023-05-22 20:10:58'),
(90, 3.5991799499701997, 98.68121864528538, 'E0', 79, '2023-05-22 20:12:49', '2023-05-22 20:12:49'),
(91, 3.59974210272337, 98.68266918372419, 'E4', 79, '2023-05-22 20:12:54', '2023-05-22 20:12:54'),
(92, 3.598778706586209, 98.68304311346425, 'E5', 79, '2023-05-22 20:13:16', '2023-05-22 20:13:16');

-- --------------------------------------------------------

--
-- Table structure for table `graf`
--

CREATE TABLE `graf` (
  `id` int(11) UNSIGNED NOT NULL,
  `start` int(11) UNSIGNED NOT NULL,
  `end` int(11) UNSIGNED NOT NULL,
  `rute` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `graf`
--

INSERT INTO `graf` (`id`, `start`, `end`, `rute`) VALUES
(37, 175, 54, '[\"60\",\"61\",\"62\",\"63\",\"64\"]'),
(40, 175, 54, '[\"60\",\"65\",\"62\",\"63\",\"64\"]'),
(41, 211, 153, '[\"67\",\"68\",\"69\",\"70\"]'),
(42, 211, 153, '[\"67\",\"68\",\"69\",\"70\",\"71\",\"72\",\"73\"]'),
(49, 213, 198, '[\"83\",\"84\"]'),
(50, 213, 198, '[\"83\",\"85\",\"86\"]'),
(51, 175, 105, '[\"74\",\"75\",\"76\",\"81\",\"82\"]'),
(52, 175, 105, '[\"74\",\"80\",\"76\",\"81\",\"82\"]'),
(53, 213, 209, '[\"87\",\"88\",\"89\"]'),
(54, 213, 209, '[\"90\",\"91\",\"92\",\"88\",\"89\"]');

-- --------------------------------------------------------

--
-- Table structure for table `halte`
--

CREATE TABLE `halte` (
  `id` int(11) UNSIGNED NOT NULL,
  `koridor` int(11) UNSIGNED NOT NULL,
  `kode` varchar(10) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `lokasi` varchar(250) NOT NULL,
  `keterangan` enum('Kecil','Sedang','Besar') NOT NULL DEFAULT 'Kecil',
  `node_id` int(11) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `halte`
--

INSERT INTO `halte` (`id`, `koridor`, `kode`, `nama`, `lokasi`, `keterangan`, `node_id`, `created_at`, `updated_at`) VALUES
(20, 11, 'H-1', 'Halte Lapangan Merdeka Pusat', 'Lapangan Merdeka Pusat', 'Sedang', 41, '2023-03-01 08:29:40', '2023-03-01 17:47:55'),
(21, 10, 'VII-1', 'Halte HM. Yamin', 'HM. Yamin', 'Sedang', 194, '2023-03-01 08:40:06', '2023-03-12 12:33:35'),
(22, 10, 'VII-2', 'Halte Paramount Convention Center', 'Paramount Convention Center', 'Kecil', 195, '2023-03-01 08:47:57', '2023-03-12 12:38:47'),
(23, 10, 'VII-3', 'Halte Maju Bersama Perintis Kemerdekaan', 'Maju Bersama Perintis Kemerdekaan', 'Kecil', 196, '2023-03-01 08:52:19', '2023-03-12 12:40:04'),
(24, 10, 'VII-4', 'Halte Universitas HKBP Nommensen', 'Universitas HKBP Nommensen', 'Sedang', 197, '2023-03-01 08:54:00', '2023-03-12 12:41:00'),
(25, 10, 'VII-5', 'Halte SMK N 11 Medan', 'SMK N 11 Medan', 'Kecil', 198, '2023-03-01 08:55:26', '2023-03-12 12:44:30'),
(27, 10, 'VII-7', 'Halte Methodis 3', 'Methodis 3', 'Sedang', 199, '2023-03-01 08:59:13', '2023-03-12 12:48:04'),
(31, 10, 'VII-11', 'Halte Sentosa Lama', 'Sentosa Lama', 'Kecil', 200, '2023-03-01 09:14:02', '2023-03-12 13:00:04'),
(33, 10, 'VII-13', 'Halte Simpang Aksara', 'Simpang Aksara', 'Kecil', 54, '2023-03-01 09:24:59', '2023-03-01 09:24:59'),
(35, 10, 'VII-15', 'Halte Simpang Mandala By Pass', 'Simpang Mandala By Pass', 'Kecil', 201, '2023-03-01 09:29:00', '2023-03-12 13:04:11'),
(37, 10, 'VII-17', 'Halte Sukses Letda Sujono', 'Sukses Letda Sujono', 'Sedang', 202, '2023-03-01 09:32:19', '2023-03-12 13:09:35'),
(38, 10, 'VII-18', 'Halte Simpang Sosro', 'Simpang Sosro', 'Kecil', 203, '2023-03-01 09:33:33', '2023-03-12 13:11:43'),
(39, 10, 'VII-19', 'Halte Letda Sujono', 'Letda Sujono', 'Sedang', 204, '2023-03-01 09:36:18', '2023-03-12 13:14:03'),
(42, 10, 'VII-22', 'Halte Pejuang Letda Sujono', 'Pejuang Letda Sujono', 'Kecil', 205, '2023-03-01 09:40:41', '2023-03-12 13:17:55'),
(43, 10, 'VII-23', 'Halte Prayatna', 'Prayatna', 'Sedang', 206, '2023-03-01 09:42:44', '2023-03-12 13:19:14'),
(62, 9, 'VII-24', 'Halte SPBU Titi Sewa', 'SPBU Titi Sewa', 'Kecil', 93, '2023-03-01 11:08:42', '2023-03-01 11:08:42'),
(68, 9, 'VII-27', 'Halte SBC-1 Bandar Selamat', 'SBC-1 Bandar Selamat', 'Sedang', 98, '2023-03-01 16:42:32', '2023-03-01 16:42:32'),
(69, 9, 'VII-28', 'Halte SMA Budi Satrya', 'SMA Budi Satrya', 'Sedang', 99, '2023-03-01 16:45:01', '2023-03-01 16:45:01'),
(72, 9, 'VII-31', 'Halte Simpang Mandala By Pass 2', 'Simpang Mandala By Pass 2', 'Kecil', 102, '2023-03-01 16:54:03', '2023-03-01 16:54:03'),
(74, 9, 'VII-33', 'Halte Simpang Aksara 2', 'Simpang Aksara 2', 'Kecil', 105, '2023-03-01 16:57:57', '2023-03-01 16:58:40'),
(76, 9, 'VII-35', 'Halte Masjid Al-Amin', 'Masjid Al-Amin', 'Kecil', 207, '2023-03-01 17:08:28', '2023-03-12 13:35:11'),
(78, 9, 'VII-37', 'Halte Simpang Kelambir', 'Simpang Kelambir', 'Sedang', 208, '2023-03-01 17:15:47', '2023-03-12 13:39:25'),
(79, 9, 'VII-38', 'Halte RSUD Pringadi', 'RSUD Pringadi', 'Kecil', 209, '2023-03-01 17:17:08', '2023-03-12 13:41:16'),
(82, 9, 'VII-41', 'Halte Simpang Jawa', 'Simpang Jawa', 'Kecil', 210, '2023-03-01 17:22:03', '2023-03-12 13:46:14'),
(122, 7, 'VI-38', 'Halte Transmetro Deli Terminal', 'Transmetro Deli Terminal', 'Besar', 153, '2023-03-02 09:30:59', '2023-03-02 09:30:59'),
(123, 7, 'VI-39', 'Halte Hairos 2', 'Hairos 2', 'Sedang', 154, '2023-03-02 09:41:25', '2023-03-02 09:41:25'),
(124, 7, 'VI-40', 'Halte Simpang Panutia Raya-Jamin Ginting', 'Simpang Panutia Raya-Jamin Ginting', 'Kecil', 155, '2023-03-02 09:48:24', '2023-03-02 09:48:24'),
(125, 7, 'VI-41', 'Halte Masjid Al-iklab 2', 'Masjid Al-iklab 2', 'Kecil', 156, '2023-03-02 09:51:26', '2023-03-02 09:51:26'),
(127, 7, 'VI-43', 'Halte Jamin Ginting 181', 'Jamin Ginting 181', 'Kecil', 158, '2023-03-02 10:08:06', '2023-03-02 10:08:06'),
(128, 7, 'VI-44', 'Halte Pangkalan Titi Kuning', 'Pangkalan Titi Kuning', 'Kecil', 159, '2023-03-02 10:19:26', '2023-03-02 10:19:26'),
(129, 7, 'VI-45', 'Halte Pasar VII Jamin Ginting', 'Pasar VII Jamin Ginting', 'Kecil', 160, '2023-03-02 10:23:07', '2023-03-02 10:23:07'),
(130, 7, 'VI-46', 'Halte Citra Medan Garden', 'Citra Medan Garden', 'Kecil', 161, '2023-03-02 10:26:35', '2023-03-02 10:26:35'),
(131, 7, 'VI-47', 'Halte Simpang Harmonika 2', 'Simpang Harmonika 2', 'Kecil', 162, '2023-03-02 10:29:30', '2023-03-02 10:29:30'),
(132, 7, 'VI-48', 'Halte Pajus 2', 'Pajus 2', 'Kecil', 163, '2023-03-02 10:32:14', '2023-03-02 10:32:14'),
(133, 7, 'VI-49', 'Halte SDN Jamin Ginting 2', 'SDN Jamin Ginting 2', 'Kecil', 164, '2023-03-02 10:36:39', '2023-03-02 10:36:39'),
(134, 7, 'VI-50', 'Halte RS. Siti Hajar', 'RS. Siti Hajar', 'Kecil', 165, '2023-03-02 10:41:45', '2023-03-02 10:41:45'),
(135, 7, 'VI-51', 'Halte Kapt. Patimura 1', 'Kapt. Patimura 1', 'Kecil', 166, '2023-03-02 10:44:28', '2023-03-02 10:44:28'),
(136, 7, 'VI-52', 'Halte BPJS Ketenagakerjaan', 'BPJS Ketenagakerjaan', 'Sedang', 167, '2023-03-02 10:47:01', '2023-03-02 10:51:47'),
(137, 7, 'VI-53', 'Halte Simpang Cik Ditiro - Sudirman', 'Simpang Cik Ditiro - Sudirman', 'Kecil', 168, '2023-03-02 10:49:38', '2023-03-02 10:52:06'),
(138, 7, 'VI-54', 'Halte Le Polonia', 'Le Polonia', 'Kecil', 169, '2023-03-02 10:53:17', '2023-03-02 10:53:17'),
(139, 7, 'VI-55', 'Halte PTPN IV', 'PTPN IV', 'Kecil', 170, '2023-03-02 10:56:27', '2023-03-02 10:56:27'),
(140, 7, 'VI-56', 'Halte Paddini', 'Paddini', 'Kecil', 170, '2023-03-02 10:58:32', '2023-03-02 10:58:32'),
(141, 7, 'VI-57', 'Halte Kesawan', 'Kesawan', 'Kecil', 171, '2023-03-02 11:05:09', '2023-03-02 11:05:58'),
(142, 12, 'II-31', 'Halte Cirebon', 'Jl. Cirebon', 'Kecil', 177, '2023-03-12 09:39:38', '2023-03-12 09:39:38'),
(143, 12, 'VI-3', 'Halte Taman Ahmad Yamin', 'Jl. Letjen Suprapto', 'Sedang', 178, '2023-03-12 09:50:18', '2023-03-12 09:50:18'),
(144, 12, 'VI-4', 'Halte Taman Beringin', 'Jl, Jendral Sudirman', 'Sedang', 179, '2023-03-12 09:57:32', '2023-03-12 09:57:32'),
(145, 12, 'VI-5', 'Halte Simpang Patimura - Jamin Ginting', 'Simpang Patimura - Jamin Ginting', 'Kecil', 180, '2023-03-12 10:03:13', '2023-03-12 10:03:13'),
(146, 12, 'VI-6', 'Halte Simpang Dr. Mansyur', 'Simpang Dr. Mansyur', 'Kecil', 181, '2023-03-12 10:09:11', '2023-03-12 10:09:11'),
(147, 12, 'VI-7', 'Halte SDN Jamin Ginting', 'SDN Jamin Ginting', 'Kecil', 182, '2023-03-12 10:11:56', '2023-03-12 10:11:56'),
(148, 12, 'VI-8', 'Halte Pajus', 'Pajus', 'Kecil', 183, '2023-03-12 10:14:15', '2023-03-12 10:14:15'),
(149, 12, 'VI-9', 'Halte Simpang Harmonika', 'Simpang Harmonika', 'Kecil', 184, '2023-03-12 10:19:28', '2023-03-12 10:19:28'),
(150, 12, 'VI-10', 'Halte Jamin Ginting 6', 'Jamin Ginting 6', 'Kecil', 185, '2023-03-12 10:27:14', '2023-03-12 10:27:14'),
(151, 12, 'VI-11', 'Halte Masjid Nurul Huda', 'Masjid Nurul Huda', 'Kecil', 186, '2023-03-12 10:30:40', '2023-03-12 10:30:40'),
(152, 12, 'VI-12', 'Halte Simpang Kapitan Purba', 'Simpang Kapitan Purba', 'Kecil', 187, '2023-03-12 10:44:37', '2023-03-12 10:44:37'),
(153, 12, 'VI-13', 'Halte Jamin Ginting 7', 'Jamin Ginting 7', 'Kecil', 188, '2023-03-12 10:48:18', '2023-03-12 10:48:18'),
(154, 12, 'VI-14', 'Halte GBI Jamin Ginting', 'GBI Jamin Ginting', 'Kecil', 189, '2023-03-12 10:51:54', '2023-03-12 10:51:54'),
(155, 12, 'VI-15', 'Halte Masjid Iklab', 'Masjid Iklab', 'Kecil', 190, '2023-03-12 10:57:16', '2023-03-12 10:57:16'),
(156, 12, 'VI-16', 'Halte Simpang Jl. Bunga Malem', 'Simpang Jl. Bunga Malem', 'Kecil', 191, '2023-03-12 10:58:54', '2023-03-12 10:58:54'),
(157, 12, 'VI-17', 'Halte Jamin Ginting 9', 'Jamin Ginting 9', 'Kecil', 192, '2023-03-12 11:01:14', '2023-03-12 11:01:14'),
(158, 12, 'VI-18', 'Halte Hairos', 'Hairos', 'Kecil', 193, '2023-03-12 11:03:47', '2023-03-12 11:03:47');

-- --------------------------------------------------------

--
-- Table structure for table `koridor`
--

CREATE TABLE `koridor` (
  `id` int(11) UNSIGNED NOT NULL,
  `kode` varchar(191) NOT NULL,
  `nama` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `koridor`
--

INSERT INTO `koridor` (`id`, `kode`, `nama`) VALUES
(7, 'VI-2', 'Medan Tuntungan - Lapangan Merdeka'),
(9, 'VII-2', 'Tembung - Lapangan Merdeka'),
(10, 'VII-1', 'Lapangan Merdeka - Tembung'),
(11, 'X', 'Pusat Koridor'),
(12, 'VI-1', 'Lapangan Merdeka - Medan Tuntungan');

-- --------------------------------------------------------

--
-- Table structure for table `node`
--

CREATE TABLE `node` (
  `id` int(11) UNSIGNED NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `node`
--

INSERT INTO `node` (`id`, `latitude`, `longitude`) VALUES
(41, 3.59119, 98.67938),
(52, 3.59855, 9870054),
(54, 3.59799, 98.70706),
(93, 3.59691, 98.7387),
(98, 3.59727, 98.72723),
(99, 3.59734, 98.72187),
(102, 3.59769, 98.71125),
(105, 3.59792, 98.70564),
(153, 3.49333, 98.59817),
(154, 3.49582, 98.60832),
(155, 3.50745, 98.61386),
(156, 3.51282, 98.6151),
(158, 3.5371, 98.65106),
(159, 3.54142, 98.65483),
(160, 3.54321, 98.65635),
(161, 3.54815, 98.65954),
(162, 3.55517, 98.66126),
(163, 3.55997, 98.6617),
(164, 3.56383, 98.66226),
(165, 3.57115, 98.66037),
(166, 3.57349, 98.6623),
(167, 3.57568, 98.66597),
(168, 3.57618, 98.66881),
(169, 3.5764, 98.67516),
(170, 3.58087, 98.68144),
(171, 3.58519, 98.68026),
(175, 3.605928994663209, 98.72111353186112),
(177, 3.583501, 98.684102),
(178, 3.57718, 98.67658),
(179, 3.57604, 98.66876),
(180, 3.57131, 98.66067),
(181, 3.56695, 98.66127),
(182, 3.56387, 98.66239),
(183, 3.56051, 98.66214),
(184, 3.55454, 98.66106),
(185, 3.53709, 98.65121),
(186, 3.53304, 98.64696),
(187, 3.52604, 98.63281),
(188, 3.52304, 98.62615),
(189, 3.52107, 98.62153),
(190, 3.51272, 98.61522),
(191, 3.5076, 98.61402),
(192, 3.50015, 98.61165),
(193, 3.49561, 98.60798),
(194, 3.59313, 98.67714),
(195, 3.59606, 98.6762),
(196, 3.59726, 98.67878),
(197, 3.59799, 98.68076),
(198, 3.59844, 98.68203),
(199, 3.59878, 98.68842),
(200, 3.59825, 98.70079),
(201, 3.5978, 98.71239),
(202, 3.5976, 98.71792),
(203, 3.59749, 98.72246),
(204, 3.5973, 98.72726),
(205, 3.59709, 98.73374),
(206, 3.59703, 98.73626),
(207, 3.59817, 98.70057),
(208, 3.5984, 98.69529),
(209, 3.59793, 98.69014),
(210, 3.59488, 98.682),
(211, 3.4977752792590286, 98.58772312766712),
(213, 3.600077117424429, 98.68085302405638);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `full_name`, `password`, `created_at`, `updated_at`) VALUES
(1, 'admin@admin.com', 'admin', 'Admin', '$2y$10$.zyv.mN4ewS36HGJcBDXWua88yylf2MwZRK3603IZfRfoNZhJEvHy', '2023-02-18 07:55:43', '2023-02-18 07:55:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bus`
--
ALTER TABLE `bus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cordinat`
--
ALTER TABLE `cordinat`
  ADD PRIMARY KEY (`id_cords`);

--
-- Indexes for table `graf`
--
ALTER TABLE `graf`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `graf_start_foreign` (`start`) USING BTREE,
  ADD KEY `graf_end_foreign` (`end`) USING BTREE;

--
-- Indexes for table `halte`
--
ALTER TABLE `halte`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `halte_koridor_foreign` (`koridor`) USING BTREE,
  ADD KEY `halte_node_id_foreign` (`node_id`) USING BTREE;

--
-- Indexes for table `koridor`
--
ALTER TABLE `koridor`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `node`
--
ALTER TABLE `node`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `email` (`email`) USING BTREE,
  ADD UNIQUE KEY `username` (`username`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bus`
--
ALTER TABLE `bus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `cordinat`
--
ALTER TABLE `cordinat`
  MODIFY `id_cords` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `graf`
--
ALTER TABLE `graf`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `halte`
--
ALTER TABLE `halte`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT for table `koridor`
--
ALTER TABLE `koridor`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `node`
--
ALTER TABLE `node`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=216;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `graf`
--
ALTER TABLE `graf`
  ADD CONSTRAINT `graf_end_foreign` FOREIGN KEY (`end`) REFERENCES `node` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `graf_start_foreign` FOREIGN KEY (`start`) REFERENCES `node` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `halte`
--
ALTER TABLE `halte`
  ADD CONSTRAINT `halte_koridor_foreign` FOREIGN KEY (`koridor`) REFERENCES `koridor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `halte_node_id_foreign` FOREIGN KEY (`node_id`) REFERENCES `node` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

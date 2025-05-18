-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 18, 2025 at 07:03 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_deviota`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`) VALUES
(1, 'admin123', '$2y$12$CUCtb3U9U8OgnXCHtJ.LGumtJIzK4o4zAPUnXGf...UrojQz40Kca');

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` int NOT NULL,
  `nama_barang` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_kategori` int NOT NULL,
  `stok` int DEFAULT '0',
  `lokasi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `tipe` enum('Barang Dipinjam','Barang Diambil','Barang Diambil dan Dipinjam') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `stok_minimum` int DEFAULT NULL,
  `harga` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`, `id_kategori`, `stok`, `lokasi`, `deskripsi`, `tipe`, `stok_minimum`, `harga`) VALUES
(17, 'DHT11', 2, 15, 'Rak A1', 'Sensor suhu dan kelembaban untuk proyek IoT.', 'Barang Dipinjam', 20, 349999.99),
(18, 'Arduino Uno R3', 2, 41, 'Rak B2', 'Mikrokontroler populer untuk pemula dan proyek IoT.', 'Barang Dipinjam', 5, 85000.00),
(19, 'ESP8266 WiFi Module', 3, 73, 'Rak C1', 'Modul WiFi yang umum digunakan dalam IoT.', 'Barang Dipinjam', 10, 30000.00),
(20, 'Relay 5V 1 Channel', 4, 116, 'Rak D3', 'Modul relay untuk mengendalikan perangkat listrik.', 'Barang Diambil', 19, 120000.00),
(21, 'Power Supply 5V 2A', 5, 29, 'Rak E2', 'Catu daya untuk proyek IoT.', 'Barang Diambil', 5, 45000.00),
(22, 'Ultrasonic Sensor HC-SR04', 1, 72, 'Rak A3', 'Sensor jarak menggunakan gelombang ultrasonik.', 'Barang Dipinjam', 10, 180000.00),
(23, 'NodeMCU ESP32', 2, 58, 'Rak B4', 'Mikrokontroler dengan konektivitas WiFi & Bluetooth.', 'Barang Dipinjam', 8, 95000.00),
(24, 'Bluetooth HC-05 Module', 3, 85, 'Rak C3', 'Modul komunikasi Bluetooth serial.', 'Barang Dipinjam', 10, 280000.00),
(25, 'Test', 1, 45, '-', '-', 'Barang Diambil dan Dipinjam', 5, 99.98),
(26, 'gas', 6, 56, '-', '-', 'Barang Diambil', 3, 200000.00);

-- --------------------------------------------------------

--
-- Table structure for table `barang_foto`
--

CREATE TABLE `barang_foto` (
  `id_foto` int NOT NULL,
  `id_barang` int NOT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang_foto`
--

INSERT INTO `barang_foto` (`id_foto`, `id_barang`, `foto`) VALUES
(5, 17, 'uploads/EbdIusZBnMNeKvYVVv1iHX5fVH1QIkr8YooRAzR0.jpg'),
(6, 18, 'uploads/ZGA60Z5sDrLKxsz4HRLaNlWP9yw9UHvIDZS1Txy9.jpg'),
(7, 19, 'uploads/P2gJ8QNPbtVrpmJs4slLDgoLs11wAki8O1II2irz.jpg'),
(8, 20, 'uploads/Cpj9HbLF1YN351PuFCBFVPzIUVQgGJKnupHjBk8S.jpg'),
(9, 21, 'uploads/q5iYTvBb8eeQn5yuZyJVJsnVKX0a4FDOFPj72sqs.jpg'),
(10, 22, 'uploads/ljGyUAVH2ol5Olmr7j25Qgo4hmTzuML7cJWcgj5v.jpg'),
(11, 23, 'uploads/J4t1tGS0MlDYA46NH11IPu4y4eehnvtCMLTJxGc1.jpg'),
(12, 24, 'uploads/U0MFgoaACMnh9nlH6E6mBH3wUUvy7ZRl2wUfwdVM.jpg'),
(13, 25, 'uploads/SdpdBNwbP7NdWyRXf7TwfVu0bBTUvwhAED3QUDxl.jpg'),
(14, 26, 'uploads/sTKLCMJcwuzwnntk1GyjDDQGg7WxccK1l8rEoAkc.jpg'),
(15, 26, 'uploads/kXyC8xW7KRk28OgSN7eOSpTQrfSoCSM8H7LtEXGu.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `id_masuk` int NOT NULL,
  `id_barang` int NOT NULL,
  `id_supplier` int DEFAULT NULL,
  `jumlah` int NOT NULL,
  `tanggal_masuk` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang_masuk`
--

INSERT INTO `barang_masuk` (`id_masuk`, `id_barang`, `id_supplier`, `jumlah`, `tanggal_masuk`) VALUES
(45, 17, NULL, 100, '2025-05-08 13:45:29'),
(46, 18, NULL, 50, '2025-05-08 13:48:02'),
(47, 19, NULL, 75, '2025-05-08 13:49:42'),
(48, 20, NULL, 119, '2025-05-08 13:50:53'),
(49, 21, NULL, 40, '2025-05-08 13:52:11'),
(50, 22, NULL, 80, '2025-05-08 13:53:06'),
(51, 23, NULL, 60, '2025-05-08 13:53:50'),
(52, 24, NULL, 69, '2025-05-08 13:54:45'),
(53, 24, NULL, 81, '2025-05-10 13:48:35'),
(54, 25, NULL, 50, '2025-05-17 21:52:58'),
(55, 26, NULL, 56, '2025-05-18 12:45:02');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `foto_pengembalian`
--

CREATE TABLE `foto_pengembalian` (
  `id_foto` int NOT NULL,
  `id_peminjaman` int NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_upload` datetime DEFAULT CURRENT_TIMESTAMP,
  `keterangan` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `foto_pengembalian`
--

INSERT INTO `foto_pengembalian` (`id_foto`, `id_peminjaman`, `foto`, `tanggal_upload`, `keterangan`) VALUES
(1, 63, 'uploads/pengembalian/zWJOQdEklXfPtaa28YjghfLw4NBAeaIl78uajkac.jpg', '2025-05-17 12:13:15', 'Pengembalian sebagian'),
(2, 63, 'uploads/pengembalian/qnBZPwSSLLU7pZyt0dc6HX84VNvP5IolgcnDRcVF.jpg', '2025-05-17 12:17:33', 'Pengembalian semua barang'),
(3, 63, 'uploads/pengembalian/fK8puleUgMzkSZOYv6iSZlTS3HgbmEBbcGIoeYa0.jpg', '2025-05-17 12:17:33', 'Pengembalian semua barang'),
(4, 64, 'uploads/pengembalian/qnBZPwSSLLU7pZyt0dc6HX84VNvP5IolgcnDRcVF.jpg', '2025-05-17 12:17:33', 'Pengembalian semua barang'),
(5, 64, 'uploads/pengembalian/fK8puleUgMzkSZOYv6iSZlTS3HgbmEBbcGIoeYa0.jpg', '2025-05-17 12:17:33', 'Pengembalian semua barang'),
(6, 65, 'uploads/pengembalian/2S1DffcR2nNLgZWjOhq3OfePyYICHUHthWCcXG0j.jpg', '2025-05-17 13:53:04', 'Pengembalian semua barang'),
(7, 66, 'uploads/pengembalian/bkQUuec9KIgA6NYVS0jvUQMXHxiOECK8uhgiVX60.jpg', '2025-05-17 14:00:34', 'Pengembalian sebagian'),
(8, 66, 'uploads/pengembalian/MYissZdflVg3bZXUJCLsbMqfpweWDAPnY2pmBCwc.jpg', '2025-05-17 14:01:12', 'Pengembalian semua barang'),
(9, 66, 'uploads/pengembalian/yGQ0YDRp4YH6BLYMEAA60EUJA46ZYWXkJjQng9Ws.jpg', '2025-05-17 14:01:12', 'Pengembalian semua barang'),
(10, 67, 'uploads/pengembalian/wmZdFuxsAO3PqyyXMlFEH8xA9hpQQzFkFKV3KX0t.jpg', '2025-05-17 14:25:52', 'Pengembalian sebagian'),
(11, 67, 'uploads/pengembalian/R8y8wa2FBked21Kskgt7LqRQ3XbO2FtRiHda4niq.jpg', '2025-05-17 14:26:24', 'Pengembalian semua barang'),
(12, 67, 'uploads/pengembalian/fUC58uUrnKuklZ0fHxc8uNBuDoAXF6Fu6l1B2ZKW.jpg', '2025-05-17 14:26:24', 'Pengembalian semua barang'),
(13, 69, 'uploads/pengembalian/jDSItC7t3l2ddjbNMNjPxRwsWSeaTzkNX1b2jT44.jpg', '2025-05-17 14:38:51', 'Pengembalian sebagian'),
(14, 69, 'uploads/pengembalian/gxJKoKHdXoYXkmKBrWKhOH9sNPruD3DYXfhwohpM.jpg', '2025-05-17 14:39:46', 'Pengembalian semua barang'),
(15, 70, 'uploads/pengembalian/CiWIAfkl7nm7VdfXZ2D212inFNDs6zaYJGgCt36v.jpg', '2025-05-17 15:00:51', 'Pengembalian semua barang'),
(16, 71, 'uploads/pengembalian/OQhlBicbGRMCeb9YmcLwe0o2Azag7yWo8E3zLx73.png', '2025-05-18 06:28:15', 'Pengembalian semua barang'),
(17, 72, 'uploads/pengembalian/OQhlBicbGRMCeb9YmcLwe0o2Azag7yWo8E3zLx73.png', '2025-05-18 06:28:15', 'Pengembalian semua barang'),
(18, 68, 'uploads/pengembalian/UImvkhzFqmZ9oN21IA7EeCH58Rfp3Km2D3nfyJh6.jpg', '2025-05-18 06:29:25', 'Pengembalian semua barang'),
(19, 68, 'uploads/pengembalian/rjR7HCk39IapVSlq2bJDAa2xCjjQlNQPrnYL7kXe.jpg', '2025-05-18 06:29:25', 'Pengembalian semua barang'),
(20, 68, 'uploads/pengembalian/Wkj7eVZZD4c3xw3ECNv9XliEKlCuxlGfy581yw8b.jpg', '2025-05-18 06:29:25', 'Pengembalian semua barang'),
(21, 68, 'uploads/pengembalian/HaWRhUzwkXlaY8GxbmbiDtA2Dyj78diDIOcWAdy0.jpg', '2025-05-18 06:29:25', 'Pengembalian semua barang'),
(22, 68, 'uploads/pengembalian/Slt2thFyQPjQmGo50zWAFFlzIraBBCcifl9a3Rrd.jpg', '2025-05-18 06:29:25', 'Pengembalian semua barang'),
(23, 68, 'uploads/pengembalian/qZW2TR5u7wQuFvTMYVKlGAK2dwNnMGO4gJqzuEr9.jpg', '2025-05-18 06:29:25', 'Pengembalian semua barang'),
(24, 68, 'uploads/pengembalian/ewQHOvyM0aIS5A3nysl0LukNftfWM3eFUPLJS4V2.jpg', '2025-05-18 06:29:25', 'Pengembalian semua barang');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int NOT NULL,
  `nama_kategori` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Elektronik'),
(2, 'Sensor'),
(3, 'Mikrokontroler'),
(4, 'Modul Komunikasi'),
(5, 'Aktuator'),
(6, 'Power Supply'),
(14, 'tools'),
(15, 'Cek');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id_mahasiswa` int NOT NULL,
  `nim` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_mahasiswa` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kontak` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`id_mahasiswa`, `nim`, `nama_mahasiswa`, `kontak`) VALUES
(1, '220001', 'Budi Santoso', '081234567890'),
(2, '220002', 'Siti Aminah', '081298765432'),
(3, '220003', 'Joko Widodo', '081376543210'),
(4, '220004', 'Ani Rahmawati', '081265432198'),
(5, '220005', 'Dedi Kusuma', '081278945612'),
(6, '23', 'KAKA', '098737'),
(7, '3', 'F', '4'),
(8, '2310978', 'Marco', '098737'),
(9, '2300001', 'Faiz', '098737'),
(10, '344444', 'Rauf', '098737'),
(11, '230109399', 'Alfi', '0888888'),
(12, '230199928', 'Alfi', '0888352'),
(13, '230303', 'Marco', '098737'),
(14, '234214', 'Rumah', '098737'),
(15, '2000000', 'Burung', '0999'),
(16, '12222', 'sadn', '09873744'),
(17, '23099999', 'Woko', '098737'),
(18, '2093901280', 'Woko', '104802747017240'),
(19, '2308080', 'Woko', '807659'),
(20, '2311175', 'Asep', '0812345678910'),
(21, '23019883', 'Marco', '098737'),
(22, '230000000', 'f', '09'),
(23, '14', 'R', '9'),
(24, '54', 'Haniel Septian', '4'),
(25, '1111', 'GTW', '6'),
(26, '5', '5', '5'),
(27, '7', '7', '7'),
(28, '911', '911', '911'),
(29, '2301222', 'Kurniawan', '0892991829'),
(30, '333', '333', '333'),
(31, '222', '222', '222'),
(32, '111', '111', '111'),
(33, '33', '33', '33'),
(34, '2301103', 'Rauf', '081234567'),
(35, '2000', 'Tes', 'Tes'),
(36, '0', '0', '0'),
(37, '555', '555', '555'),
(38, '444', '444', '444'),
(39, '777', '777', '777'),
(40, '230102390', 'Abdurrahman Rauf Budiman', '081828281');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_peminjaman` int NOT NULL,
  `id_barang` int NOT NULL,
  `id_mahasiswa` int NOT NULL,
  `jumlah` int NOT NULL,
  `tanggal_pinjam` datetime DEFAULT CURRENT_TIMESTAMP,
  `tanggal_pengembalian` datetime DEFAULT NULL,
  `tanggal_kembali` datetime DEFAULT NULL,
  `status` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `foto_pengembalian` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id_peminjaman`, `id_barang`, `id_mahasiswa`, `jumlah`, `tanggal_pinjam`, `tanggal_pengembalian`, `tanggal_kembali`, `status`, `foto_pengembalian`) VALUES
(1, 23, 30, 4, '2025-05-14 21:16:24', NULL, '2025-05-14 21:16:33', 'Dikembalikan', NULL),
(2, 17, 30, 5, '2025-05-14 21:23:09', NULL, '2025-05-14 21:23:27', 'Dikembalikan', NULL),
(3, 17, 37, 5, '2025-05-14 21:28:58', NULL, '2025-05-14 21:29:08', 'Dikembalikan', NULL),
(4, 17, 31, 5, '2025-05-14 21:42:48', NULL, '2025-05-14 21:43:32', 'Dikembalikan', NULL),
(6, 17, 32, 5, '2025-05-14 21:58:50', '2025-05-12 00:00:00', '2025-05-16 13:45:42', 'Dikembalikan', NULL),
(7, 17, 39, 4, '2025-05-14 22:02:44', '2025-05-16 00:00:00', '2025-05-14 22:03:00', 'Dikembalikan', NULL),
(8, 17, 32, 4, '2025-05-14 22:03:26', '2025-05-13 00:00:00', '2025-05-16 13:45:42', 'Dikembalikan', NULL),
(9, 17, 32, 5, '2025-05-14 22:23:45', '2025-05-13 00:00:00', '2025-05-16 13:45:42', 'Dikembalikan', NULL),
(10, 19, 32, 4, '2025-05-14 22:27:33', '2025-05-12 00:00:00', '2025-05-16 13:45:42', 'Dikembalikan', NULL),
(11, 17, 32, 5, '2025-05-14 22:35:45', '2025-05-13 00:00:00', '2025-05-16 13:45:42', 'Dikembalikan', NULL),
(12, 17, 32, 5, '2025-05-14 22:37:25', '2025-05-13 00:00:00', '2025-05-16 13:45:42', 'Dikembalikan', NULL),
(13, 17, 32, 5, '2025-05-14 22:44:34', '2025-05-13 00:00:00', '2025-05-16 13:45:42', 'Dikembalikan', NULL),
(14, 17, 32, 5, '2025-05-14 22:45:08', '2025-05-22 00:00:00', '2025-05-14 22:45:17', 'Dikembalikan', NULL),
(15, 17, 32, 5, '2025-05-14 23:48:48', '2025-05-13 00:00:00', '2025-05-16 13:45:42', 'Dikembalikan', NULL),
(16, 17, 32, 3, '2025-05-14 23:54:59', '2025-05-16 00:00:00', '2025-05-16 13:45:42', 'Dikembalikan', NULL),
(17, 17, 32, 5, '2025-05-16 13:49:18', NULL, '2025-05-16 13:53:11', 'Dikembalikan', NULL),
(18, 17, 32, 5, '2025-05-16 13:52:58', NULL, '2025-05-16 13:53:11', 'Dikembalikan', NULL),
(19, 17, 32, 5, '2025-05-16 13:53:50', NULL, '2025-05-16 13:53:58', 'Dikembalikan', NULL),
(20, 17, 32, 1, '2025-05-16 13:58:06', NULL, '2025-05-16 13:58:35', 'Dikembalikan', NULL),
(21, 17, 32, 5, '2025-05-16 14:00:30', NULL, '2025-05-16 14:07:17', 'Dikembalikan', NULL),
(22, 18, 32, 1, '2025-05-16 14:01:04', NULL, '2025-05-16 14:07:17', 'Dikembalikan', NULL),
(23, 17, 32, 5, '2025-05-16 14:06:58', NULL, '2025-05-16 14:07:17', 'Dikembalikan', NULL),
(24, 17, 32, 5, '2025-05-16 14:23:29', '1111-11-11 00:00:00', '2025-05-16 14:23:54', 'Dikembalikan', NULL),
(25, 17, 32, 5, '2025-05-16 15:10:47', '2025-05-13 00:00:00', '2025-05-16 17:03:30', 'Dikembalikan', NULL),
(26, 17, 32, 5, '2025-05-16 15:11:31', '2025-05-14 00:00:00', '2025-05-16 17:03:30', 'Dikembalikan', NULL),
(27, 17, 32, 5, '2025-05-16 15:12:55', '2025-05-17 00:00:00', '2025-05-16 15:13:01', 'Dikembalikan', NULL),
(28, 17, 32, 5, '2025-05-16 15:13:25', '2025-05-14 00:00:00', '2025-05-16 17:03:30', 'Dikembalikan', NULL),
(29, 17, 32, 5, '2025-05-16 15:14:32', '2025-05-15 00:00:00', '2025-05-16 17:03:30', 'Dikembalikan', NULL),
(30, 17, 32, 5, '2025-05-16 15:17:37', '2025-05-14 00:00:00', '2025-05-16 17:03:30', 'Dikembalikan', NULL),
(31, 17, 32, 5, '2025-05-16 15:21:16', '1111-11-11 00:00:00', '2025-05-16 17:03:30', 'Dikembalikan', NULL),
(32, 17, 32, 5, '2025-05-16 15:21:31', '1111-11-11 00:00:00', '2025-05-16 17:03:30', 'Dikembalikan', NULL),
(33, 17, 32, 5, '2025-05-16 15:23:23', '2025-05-15 00:00:00', '2025-05-16 17:03:30', 'Dikembalikan', NULL),
(34, 17, 32, 5, '2025-05-16 15:24:38', '2025-05-15 00:00:00', '2025-05-16 17:03:30', 'Dikembalikan', NULL),
(35, 17, 32, 4, '2025-05-16 15:25:54', '2025-05-17 00:00:00', '2025-05-16 15:26:25', 'Dikembalikan', NULL),
(36, 17, 32, 4, '2025-05-16 15:26:54', '2025-05-17 00:00:00', '2025-05-16 15:27:36', 'Dikembalikan', NULL),
(37, 18, 32, 1, '2025-05-16 15:26:54', '2025-05-17 00:00:00', '2025-05-16 15:27:01', 'Dikembalikan', NULL),
(38, 17, 32, 4, '2025-05-16 15:33:23', '1111-11-11 00:00:00', '2025-05-16 17:03:30', 'Dikembalikan', NULL),
(39, 17, 32, 5, '2025-05-16 16:00:11', '1111-11-11 00:00:00', '2025-05-16 17:03:30', 'Dikembalikan', NULL),
(40, 17, 32, 5, '2025-05-16 16:04:13', '1111-11-11 00:00:00', '2025-05-16 17:03:30', 'Dikembalikan', NULL),
(41, 17, 32, 5, '2025-05-16 16:07:00', '1111-11-11 00:00:00', '2025-05-16 17:03:30', 'Dikembalikan', NULL),
(42, 17, 32, 10, '2025-05-16 16:15:59', '1111-11-11 00:00:00', '2025-05-16 17:03:30', 'Dikembalikan', NULL),
(43, 17, 32, 5, '2025-05-16 17:02:08', '1111-11-11 00:00:00', '2025-05-16 17:03:30', 'Dikembalikan', NULL),
(44, 17, 32, 5, '2025-05-16 17:03:15', '1111-11-11 00:00:00', '2025-05-16 17:03:30', 'Dikembalikan', NULL),
(45, 17, 32, 5, '2025-05-16 17:06:49', '1111-11-11 00:00:00', '2025-05-16 17:06:59', 'Dikembalikan', NULL),
(46, 17, 32, 5, '2025-05-16 17:08:11', '1111-11-11 00:00:00', '2025-05-16 17:08:46', 'Dikembalikan', NULL),
(47, 17, 32, 5, '2025-05-16 17:09:09', '1111-11-11 00:00:00', '2025-05-16 17:09:18', 'Dikembalikan', NULL),
(48, 17, 32, 5, '2025-05-16 17:09:50', '1111-11-11 00:00:00', '2025-05-16 17:10:16', 'Dikembalikan', NULL),
(49, 17, 32, 5, '2025-05-16 17:12:18', '1111-11-11 00:00:00', '2025-05-16 17:12:32', 'Telat', NULL),
(50, 17, 32, 5, '2025-05-16 17:13:36', '1111-11-11 00:00:00', '2025-05-16 17:13:57', 'Telat', NULL),
(51, 17, 32, 5, '2025-05-16 17:18:54', '1111-11-11 00:00:00', '2025-05-16 17:19:16', 'Telat', NULL),
(52, 17, 32, 6, '2025-05-16 17:19:48', '1111-11-11 00:00:00', '2025-05-16 17:20:04', 'Telat', NULL),
(53, 17, 32, 1, '2025-05-16 17:20:43', '1111-11-11 00:00:00', '2025-05-16 17:21:13', 'Telat', NULL),
(54, 17, 32, 1, '2025-05-16 17:32:55', '1111-11-11 00:00:00', '2025-05-16 17:33:02', 'Telat', NULL),
(55, 17, 32, 5, '2025-05-16 17:34:22', '1111-11-11 00:00:00', '2025-05-16 17:34:45', 'Telat', NULL),
(56, 17, 32, 4, '2025-05-16 17:38:34', '1111-11-11 00:00:00', '2025-05-16 17:38:56', 'Telat', NULL),
(57, 17, 32, 7, '2025-05-16 17:44:06', '1111-11-11 00:00:00', '2025-05-16 17:44:32', 'Telat', NULL),
(58, 17, 32, 7, '2025-05-17 16:52:58', '1111-11-11 00:00:00', '2025-05-17 16:53:34', 'Telat', 'uploads/pengembalian/2EwkNa1Ma1eqhnsTmfdkgubQEdXBR7f2MNpSwbBJ.jpg'),
(59, 17, 32, 4, '2025-05-17 16:54:24', '1111-11-11 00:00:00', '2025-05-17 16:56:26', 'Telat', 'uploads/pengembalian/qTfHugXGNqdhdtqt5dbMKoeLQiY8QVZ3b1RpN9pJ.jpg'),
(60, 18, 32, 5, '2025-05-17 16:54:24', '1111-11-11 00:00:00', '2025-05-17 16:56:26', 'Telat', 'uploads/pengembalian/qTfHugXGNqdhdtqt5dbMKoeLQiY8QVZ3b1RpN9pJ.jpg'),
(61, 17, 32, 7, '2025-05-17 16:56:56', '1111-11-11 00:00:00', '2025-05-17 17:00:41', 'Telat', 'uploads/pengembalian/3k3jAeV3x3SNHI7dOeTHpbmiVYnqlUzwH2A8Bimr.jpg'),
(62, 18, 32, 1, '2025-05-17 16:56:56', '1111-11-11 00:00:00', '2025-05-17 17:00:43', 'Telat', NULL),
(63, 17, 32, 2, '2025-05-17 17:09:57', '2025-05-22 00:00:00', '2025-05-17 19:17:33', 'Dikembalikan', 'uploads/pengembalian/jeCDH1AsErSNqF200foodlIkomECD2pJI1Tc9qqJ.jpg'),
(64, 18, 32, 1, '2025-05-17 17:09:57', '2025-05-22 00:00:00', '2025-05-17 19:17:33', 'Dikembalikan', NULL),
(65, 17, 32, 7, '2025-05-17 20:52:33', '0111-11-13 00:00:00', '2025-05-17 20:53:04', 'Telat', NULL),
(66, 17, 32, 6, '2025-05-17 20:59:39', '2025-05-23 00:00:00', '2025-05-17 21:01:12', 'Dikembalikan', NULL),
(67, 17, 32, 4, '2025-05-17 21:24:39', '2025-05-23 00:00:00', '2025-05-17 21:26:24', 'Dikembalikan', NULL),
(68, 17, 40, 7, '2025-05-17 21:29:50', '2025-05-23 00:00:00', '2025-05-18 13:29:25', 'Dikembalikan', NULL),
(69, 19, 32, 2, '2025-05-17 21:38:32', '2025-05-22 00:00:00', '2025-05-17 21:39:46', 'Dikembalikan', NULL),
(70, 25, 32, 5, '2025-05-17 21:58:45', '2025-05-22 00:00:00', '2025-05-17 22:00:51', 'Dikembalikan', NULL),
(71, 19, 32, 3, '2025-05-17 22:33:00', '2025-05-23 00:00:00', '2025-05-18 13:28:15', 'Dikembalikan', NULL),
(72, 19, 32, 5, '2025-05-18 13:27:49', '2025-05-20 00:00:00', '2025-05-18 13:28:15', 'Dikembalikan', NULL);

--
-- Triggers `peminjaman`
--
DELIMITER $$
CREATE TRIGGER `after_update_peminjaman` AFTER UPDATE ON `peminjaman` FOR EACH ROW BEGIN
        -- Only run if not explicitly disabled
        IF @disable_triggers IS NULL OR @disable_triggers = 0 THEN
            -- Hanya tambahkan stok jika status berubah dari 'Dipinjam' ke status pengembalian
            IF (NEW.status = 'Dikembalikan' OR NEW.status = 'Telat') AND 
               (OLD.status = 'Dipinjam' OR OLD.status = 'Dikembalikan Sebagian') THEN
                UPDATE barang
                SET stok = stok + NEW.jumlah
                WHERE id_barang = NEW.id_barang;
            END IF;
        END IF;
    END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_insert_peminjaman` BEFORE INSERT ON `peminjaman` FOR EACH ROW BEGIN
    DECLARE kategori_barang INT;

    -- Ambil id_kategori dari barang yang dipinjam
    SELECT id_kategori INTO kategori_barang FROM barang WHERE id_barang = NEW.id_barang;

    -- Jika kategori barang adalah 1 (misalnya kategori peminjaman), set status menjadi 'dipinjam'
    IF kategori_barang = 1 THEN
        SET NEW.status = 'Dipinjam';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pengambilan`
--

CREATE TABLE `pengambilan` (
  `id_pengambilan` int NOT NULL,
  `id_barang` int NOT NULL,
  `id_mahasiswa` int NOT NULL,
  `jumlah` int NOT NULL,
  `tanggal_ambil` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengambilan`
--

INSERT INTO `pengambilan` (`id_pengambilan`, `id_barang`, `id_mahasiswa`, `jumlah`, `tanggal_ambil`) VALUES
(1, 21, 31, 5, '2025-05-12 21:21:12'),
(2, 20, 31, 3, '2025-05-12 21:21:12'),
(3, 25, 32, 5, '2025-05-17 22:04:47');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('9NEzs0Fx4OjlBDodbFdb2TivoU9kRkbzDSUWiL5L', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaDBMVTBGa2V2QlZhSUFtaWoyTXd5MFRxY1hCSkdVV2JSM3ZUUGhJSCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbkRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NDoiY2FydCI7Tjt9', 1747550363),
('P5KXewl2yCe6FXpt3m8shNUDtDi1xAmHqFGWUaRL', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYWIwSzhUV1FtSWRkYUxCckpkVjZYQW12ZGZJelNPWTZrdnZTSFYzQyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747545105);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int NOT NULL,
  `nama_supplier` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kontak` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama_supplier`, `kontak`, `alamat`) VALUES
(1, 'PT. Teknologi Maju', '08123456789', 'Jakarta, Indonesia'),
(2, 'CV. Peralatan Sejahtera', '08198765432', 'Bandung, Indonesia'),
(3, 'PT. Teknologi Maju', '08123456789', 'Jakarta, Indonesia'),
(4, 'CV. Peralatan Sejahtera', '08198765432', 'Bandung, Indonesia');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `barang_foto`
--
ALTER TABLE `barang_foto`
  ADD PRIMARY KEY (`id_foto`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id_masuk`),
  ADD KEY `id_barang` (`id_barang`),
  ADD KEY `id_supplier` (`id_supplier`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `foto_pengembalian`
--
ALTER TABLE `foto_pengembalian`
  ADD PRIMARY KEY (`id_foto`),
  ADD KEY `fk_peminjaman_foto` (`id_peminjaman`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id_mahasiswa`),
  ADD UNIQUE KEY `nim` (`nim`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `id_barang` (`id_barang`),
  ADD KEY `mahasiswa_ibfk_1` (`id_mahasiswa`);

--
-- Indexes for table `pengambilan`
--
ALTER TABLE `pengambilan`
  ADD PRIMARY KEY (`id_pengambilan`),
  ADD KEY `id_barang` (`id_barang`),
  ADD KEY `mahasiswa_ibfk_2` (`id_mahasiswa`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `barang_foto`
--
ALTER TABLE `barang_foto`
  MODIFY `id_foto` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  MODIFY `id_masuk` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `foto_pengembalian`
--
ALTER TABLE `foto_pengembalian`
  MODIFY `id_foto` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id_mahasiswa` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_peminjaman` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `pengambilan`
--
ALTER TABLE `pengambilan`
  MODIFY `id_pengambilan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE CASCADE;

--
-- Constraints for table `barang_foto`
--
ALTER TABLE `barang_foto`
  ADD CONSTRAINT `barang_foto_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE;

--
-- Constraints for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD CONSTRAINT `barang_masuk_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE,
  ADD CONSTRAINT `barang_masuk_ibfk_2` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`) ON DELETE SET NULL;

--
-- Constraints for table `foto_pengembalian`
--
ALTER TABLE `foto_pengembalian`
  ADD CONSTRAINT `fk_peminjaman_foto` FOREIGN KEY (`id_peminjaman`) REFERENCES `peminjaman` (`id_peminjaman`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

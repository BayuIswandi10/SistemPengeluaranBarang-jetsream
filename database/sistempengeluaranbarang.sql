-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 21 Feb 2025 pada 09.17
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistempengeluaranbarang`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('179845883e6780f5bf74203fb2db9e01', 'i:1;', 1740121858),
('179845883e6780f5bf74203fb2db9e01:timer', 'i:1740121858;', 1740121858),
('3f82d132b6d01207bfe6b93027c34cb5', 'i:2;', 1740121943),
('3f82d132b6d01207bfe6b93027c34cb5:timer', 'i:1740121943;', 1740121943),
('43123ab03c24138545dd841dff624392', 'i:1;', 1740118316),
('43123ab03c24138545dd841dff624392:timer', 'i:1740118316;', 1740118316),
('4cf32a74f3274bd657afceac061b5bdf', 'i:1;', 1740121805),
('4cf32a74f3274bd657afceac061b5bdf:timer', 'i:1740121805;', 1740121805),
('50b35761b661b81e8c9cb27afeed3162', 'i:1;', 1738724066),
('50b35761b661b81e8c9cb27afeed3162:timer', 'i:1738724066;', 1738724066),
('62dee1539b65f68adde7812bc7126b20', 'i:1;', 1740117064),
('62dee1539b65f68adde7812bc7126b20:timer', 'i:1740117064;', 1740117064),
('a68c34b1c2386383217c4b7686d97968', 'i:1;', 1738726294),
('a68c34b1c2386383217c4b7686d97968:timer', 'i:1738726294;', 1738726294),
('a99d6df10ddbd75c1d6f38df573ff094', 'i:1;', 1738728535),
('a99d6df10ddbd75c1d6f38df573ff094:timer', 'i:1738728535;', 1738728535),
('acef33835d6d1342788d595b9e12535f', 'i:1;', 1740038650),
('acef33835d6d1342788d595b9e12535f:timer', 'i:1740038650;', 1740038650),
('d4089148a49aecfef58964d5f82b3b5c', 'i:1;', 1739247244),
('d4089148a49aecfef58964d5f82b3b5c:timer', 'i:1739247244;', 1739247244),
('d6249c59f0cbc7c38536604b14440e5d', 'i:1;', 1740124789),
('d6249c59f0cbc7c38536604b14440e5d:timer', 'i:1740124789;', 1740124789),
('dffd097a8bb312b130684e844014dfbb', 'i:2;', 1738801384),
('dffd097a8bb312b130684e844014dfbb:timer', 'i:1738801384;', 1738801384),
('f31623e71eae7a0c66107b48eb782db2', 'i:1;', 1738722045),
('f31623e71eae7a0c66107b48eb782db2:timer', 'i:1738722045;', 1738722045);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_01_09_082052_add_two_factor_columns_to_users_table', 1),
(5, '2025_01_09_082142_create_personal_access_tokens_table', 1),
(6, '2025_01_12_052714_create_barang_keluars_table', 1),
(7, '2025_01_12_052851_create_pengeluaran_barangs_table', 1),
(8, '2025_01_12_052921_create_approvals_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('64wQlb5CfXFWc6r4W4LDXaFy5IyHKuuu2xzYBhA6', 5, '10.2.42.249', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 Edg/133.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoicmpmQ3QzOHdaTGZXUTZ3eDRjRGV1QUNtTndhd2NPYmxSZVlSdjdlTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xMC4yLjQyLjIwOTo4MTExL3NlY3VyaXR5Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO3M6MzoiMDA1IjtzOjIxOiJwYXNzd29yZF9oYXNoX3NhbmN0dW0iO3M6NjA6IiQyeSQxMiRVSkxhWVFkd1F1RWRSV0hWNzdMbUhlTGdWR3pGeGRTcDRiWDl3aTJITjhiSGZidzFwMnhhbSI7fQ==', 1740119324),
('KNS4RiFQAVVLFwSsjTyVYi2yRODvT1lgLTDBwDYk', 4, '10.2.42.209', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 Edg/133.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNERBaDkyMkxFeU9hNWE4WmtxUm5sV0Ywb3ppZnQzYzB1MEZhRmJvSiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMC4yLjQyLjIwOTo4MTExL2xvZ2luIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO3M6MzoiMDA0Ijt9', 1740121884),
('kr7franO803T6iSav9RwKhXiWJl6gQOD8nHR5Uui', NULL, '10.2.42.209', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 Edg/133.0.0.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiRjljWUp6ZW1zZjVlbGZ3QlBiVGV5QnZGOE82QjVTSEVrRk1BNHdqNyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1740121848),
('L9B5GiEDqyn16ILOXbtuKdNr9drsE1qpkBuXLo08', 5, '10.2.42.209', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 Edg/133.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiSzdJSjRHTHI5dksxOGl6MElzRnhzUmZycFg1MUExcjdBUG1NaUhrTiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly8xMC4yLjQyLjIwOTo4MTExL3NjYW4iO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7czozOiIwMDUiO3M6MjE6InBhc3N3b3JkX2hhc2hfc2FuY3R1bSI7czo2MDoiJDJ5JDEyJFVKTGFZUWR3UXVFZFJXSFY3N0xtSGVMZ1ZHekZ4ZFNwNGJYOXdpMkhOOGJIZmJ3MXAyeGFtIjt9', 1740125614);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_approval`
--

CREATE TABLE `tb_approval` (
  `approval_id` bigint(20) UNSIGNED NOT NULL,
  `pengeluaran_barang_id` varchar(35) NOT NULL,
  `created_by` varchar(35) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status_approval` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tb_approval`
--

INSERT INTO `tb_approval` (`approval_id`, `pengeluaran_barang_id`, `created_by`, `created_date`, `status_approval`) VALUES
(1, '001 / IT / P2 / II / 2025', '001', '2025-02-04 19:19:03', 'Level 1'),
(2, '001 / IT / P2 / II / 2025', '002', '2025-02-04 19:46:51', 'Level 2'),
(4, '001 / IT / P2 / II / 2025', '003', '2025-02-04 19:52:56', 'Level 3'),
(5, '001 / IT / P2 / II / 2025', '004', '2025-02-04 19:53:43', 'Level 4'),
(7, '002 / Produksi / P2 / II / 2025', '006', '2025-02-04 21:06:35', 'Level 1'),
(8, '001 / IT / P2 / II / 2025', '005', '2025-02-05 01:46:43', 'Level 5'),
(9, '003 / IT / P2 / II / 2025', '001', '2025-02-10 18:27:57', 'Level 1'),
(10, '003 / IT / P2 / II / 2025', '002', '2025-02-10 18:28:08', 'Level 2'),
(11, '003 / IT / P2 / II / 2025', '003', '2025-02-10 18:41:02', 'Level 3'),
(12, '003 / IT / P2 / II / 2025', '004', '2025-02-10 18:45:46', 'Level 0'),
(13, '002 / Produksi / P2 / II / 2025', '007', '2025-02-10 21:12:36', 'Level 2'),
(14, '002 / Produksi / P2 / II / 2025', '008', '2025-02-10 21:13:20', 'Level 3'),
(15, '002 / Produksi / P2 / II / 2025', '004', '2025-02-10 21:14:04', 'Level 4'),
(16, '004 / IT / P1 / II / 2025', '002', '2025-02-19 21:46:34', 'Level 1'),
(17, '004 / IT / P1 / II / 2025', '002', '2025-02-19 21:48:12', 'Level 2'),
(18, '004 / IT / P1 / II / 2025', '003', '2025-02-19 21:49:13', 'Level 3'),
(19, '004 / IT / P1 / II / 2025', '004', '2025-02-19 21:49:50', 'Level 4'),
(20, '002 / Produksi / P2 / II / 2025', '005', '2025-02-20 18:28:39', 'Level 5'),
(21, '004 / IT / P1 / II / 2025', '005', '2025-02-20 18:29:31', 'Level 5'),
(22, '005 / IT / P2 / II / 2025', '002', '2025-02-21 00:08:53', 'Level 1'),
(23, '005 / IT / P2 / II / 2025', '002', '2025-02-21 00:09:19', 'Level 2'),
(24, '005 / IT / P2 / II / 2025', '003', '2025-02-21 00:10:37', 'Level 3'),
(25, '005 / IT / P2 / II / 2025', '004', '2025-02-21 00:13:14', 'Level 4');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_barang_keluar`
--

CREATE TABLE `tb_barang_keluar` (
  `barang_keluar_id` bigint(20) UNSIGNED NOT NULL,
  `nama_barang` varchar(50) NOT NULL,
  `jumlah_barang` bigint(20) NOT NULL,
  `satuan_barang` varchar(35) NOT NULL,
  `keterangan_barang` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tb_barang_keluar`
--

INSERT INTO `tb_barang_keluar` (`barang_keluar_id`, `nama_barang`, `jumlah_barang`, `satuan_barang`, `keterangan_barang`) VALUES
(4, 'Monitor', 10, 'unit', 'Baik'),
(5, 'Knalpot', 30, 'unit', 'Baik'),
(6, 'Cakram', 70, 'unit', 'Baik'),
(7, 'Tas', 200, 'unit', 'Baik'),
(8, 'Buku', 100, 'unit', '28 halaman baik'),
(9, 'Laptop Asus', 5, 'pcs', 'Layak Pakai'),
(10, 'Mouse', 5, 'pcs', '-'),
(11, 'Keyboard', 5, 'pcs', '-'),
(12, 'Monitor', 5, 'pcs', '-'),
(13, 'Flash Drive (USB Drive)', 10, 'pcs', '10 Giga Byte'),
(14, 'Hard Disk Eksternal', 8, 'pcs', '1 Tera Byte'),
(15, 'Headset', 2, 'pcs', '-'),
(16, 'Kabel LAN (Ethernet Kabel)', 10, 'pcs', '1 Meter'),
(17, 'Router', 2, 'pcs', '-'),
(18, 'Power Bank', 10, 'pcs', '-'),
(19, 'Printer', 2, 'unit', 'Baik'),
(20, 'Cisco', 5, 'pcs', 'Baik'),
(21, 'Kamera', 1, 'unit', 'Baik');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_detail_pengeluaran`
--

CREATE TABLE `tb_detail_pengeluaran` (
  `detail_pengeluaran_id` bigint(20) UNSIGNED NOT NULL,
  `barang_keluar_id` bigint(20) UNSIGNED NOT NULL,
  `pengeluaran_barang_id` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tb_detail_pengeluaran`
--

INSERT INTO `tb_detail_pengeluaran` (`detail_pengeluaran_id`, `barang_keluar_id`, `pengeluaran_barang_id`) VALUES
(1, 4, '001 / IT / P2 / II / 2025'),
(2, 5, '002 / Produksi / P2 / II / 2025'),
(3, 6, '002 / Produksi / P2 / II / 2025'),
(4, 7, '003 / IT / P2 / II / 2025'),
(5, 8, '003 / IT / P2 / II / 2025'),
(6, 9, '004 / IT / P1 / II / 2025'),
(7, 10, '004 / IT / P1 / II / 2025'),
(8, 11, '004 / IT / P1 / II / 2025'),
(9, 12, '004 / IT / P1 / II / 2025'),
(10, 13, '004 / IT / P1 / II / 2025'),
(11, 14, '004 / IT / P1 / II / 2025'),
(12, 15, '004 / IT / P1 / II / 2025'),
(13, 16, '004 / IT / P1 / II / 2025'),
(14, 17, '004 / IT / P1 / II / 2025'),
(15, 18, '004 / IT / P1 / II / 2025'),
(16, 19, '005 / IT / P2 / II / 2025'),
(17, 20, '005 / IT / P2 / II / 2025'),
(18, 21, '005 / IT / P2 / II / 2025');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pengeluaran_barang`
--

CREATE TABLE `tb_pengeluaran_barang` (
  `pengeluaran_barang_id` varchar(35) NOT NULL,
  `created_by` varchar(35) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `lokasi_barang_keluar` varchar(35) NOT NULL,
  `tujuan_pengeluaran_barang` varchar(35) NOT NULL,
  `jenis_kendaraan` varchar(35) NOT NULL,
  `no_polisi` varchar(35) DEFAULT NULL,
  `status` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tb_pengeluaran_barang`
--

INSERT INTO `tb_pengeluaran_barang` (`pengeluaran_barang_id`, `created_by`, `created_date`, `lokasi_barang_keluar`, `tujuan_pengeluaran_barang`, `jenis_kendaraan`, `no_polisi`, `status`) VALUES
('001 / IT / P2 / II / 2025', '001', '2025-02-05 02:19:03', 'P2', 'P1', 'SP. MOTOR', 'B 1277 FJS', 'Level 5'),
('002 / Produksi / P2 / II / 2025', '006', '2025-02-05 04:06:35', 'P2', 'AHM', 'PICK UP', 'B 2424 KTU', 'Level 5'),
('003 / IT / P2 / II / 2025', '001', '2025-02-11 01:27:57', 'P2', 'P1', 'PICK UP', NULL, 'Level 0'),
('004 / IT / P1 / II / 2025', '002', '2025-02-20 04:46:34', 'P1', 'P2', 'PICK UP', 'B 2352FFA', 'Level 5'),
('005 / IT / P2 / II / 2025', '002', '2025-02-21 07:08:53', 'P2', 'P1', 'JEEP', 'B 7980 KJG', 'Level 4');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `nrp_karyawan` varchar(35) NOT NULL,
  `name` varchar(35) NOT NULL,
  `seksi` varchar(35) NOT NULL,
  `departemen` varchar(20) NOT NULL,
  `level` varchar(15) NOT NULL,
  `email` varchar(35) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`nrp_karyawan`, `name`, `seksi`, `departemen`, `level`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
('001', 'Bayu', 'Infrastructur', 'IT', 'Level 1', 'bayuiswandi1008@gmail.com', NULL, '$2y$12$p.5jfF5.Cq.24TYKYqd/HOYuS8NuzcMEfjOe5SdgyjJXLQqMCwNI.', NULL, NULL, NULL, NULL, NULL, NULL, '2025-01-17 01:44:20', '2025-01-17 01:44:20'),
('002', 'Ojan', 'Developer', 'IT', 'Level 2', 'jan@gmail.com', NULL, '$2y$12$aMr3NHFao7G4bG8rEo/Pi.0t2ctQv1At3WvZbTpX60CUtkjyr0/w.', NULL, NULL, NULL, NULL, NULL, NULL, '2025-01-17 01:46:09', '2025-01-17 01:46:09'),
('003', 'Candra', 'Manajer', 'IT', 'Level 3', 'can@gmail.com', NULL, '$2y$12$ZikqOKm/dVKvzeJL87KHReQOPYTtxiym8yD7dcqXkcK2TNANkJO/S', NULL, NULL, NULL, NULL, NULL, NULL, '2025-01-17 01:48:20', '2025-01-17 01:48:20'),
('004', 'Roni', 'Manajer', 'GA', 'Level 4', 'ron@gmail.com', NULL, '$2y$12$3Z06FVIMP9u1W36fjgKHb.x4nEDYvAyfP.GP5a5qc6F.RF2c..Z7q', NULL, NULL, NULL, NULL, NULL, NULL, '2025-01-17 01:49:38', '2025-01-17 01:49:38'),
('005', 'Liaw', 'Staff', 'Security', 'Level 5', 'liaw@gmail.com', NULL, '$2y$12$UJLaYQdwQuEdRWHV77LmHeLgVGzFxdSp4bX9wi2HN8bHfbw1p2xam', NULL, NULL, NULL, NULL, NULL, NULL, '2025-01-17 01:50:45', '2025-01-17 01:50:45'),
('006', 'Jajang', 'Produksi 1', 'Produksi', 'Level 1', 'jang@gmail.com', NULL, '$2y$12$XTbjUBEdIzSryNot5lp3Z.p624p1FEai3rsFWdTGURfqDPxCO76/C', NULL, NULL, NULL, NULL, NULL, NULL, '2025-01-17 01:51:44', '2025-01-17 01:51:44'),
('007', 'Kucrit', 'Produksi 2', 'Produksi', 'Level 2', 'kuc@gmail.com', NULL, '$2y$12$ZoUZ3rKaBXDcuaZ/VVcnUuOqwjJqD79h7K0aSgsyaqjovoakBuLYm', NULL, NULL, NULL, NULL, NULL, NULL, '2025-01-17 01:52:34', '2025-01-17 01:52:34'),
('008', 'Nonok', 'Manajer', 'Produksi', 'Level 3', 'nok@gmail.com', NULL, '$2y$12$MO2jV1Y6r08hoNHJjhhUjOTITt9Ih6XZ7KvslbWXq/vBB8V6ixzSG', NULL, NULL, NULL, NULL, NULL, NULL, '2025-01-17 01:53:15', '2025-01-17 01:53:15');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `tb_approval`
--
ALTER TABLE `tb_approval`
  ADD PRIMARY KEY (`approval_id`),
  ADD KEY `tb_approval_pengeluaran_barang_id_foreign` (`pengeluaran_barang_id`),
  ADD KEY `tb_approval_created_by_foreign` (`created_by`);

--
-- Indeks untuk tabel `tb_barang_keluar`
--
ALTER TABLE `tb_barang_keluar`
  ADD PRIMARY KEY (`barang_keluar_id`);

--
-- Indeks untuk tabel `tb_detail_pengeluaran`
--
ALTER TABLE `tb_detail_pengeluaran`
  ADD PRIMARY KEY (`detail_pengeluaran_id`),
  ADD KEY `tb_detail_pengeluaran_barang_keluar_id_foreign` (`barang_keluar_id`),
  ADD KEY `tb_detail_pengeluaran_pengeluaran_barang_id_foreign` (`pengeluaran_barang_id`);

--
-- Indeks untuk tabel `tb_pengeluaran_barang`
--
ALTER TABLE `tb_pengeluaran_barang`
  ADD PRIMARY KEY (`pengeluaran_barang_id`),
  ADD KEY `tb_pengeluaran_barang_created_by_foreign` (`created_by`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`nrp_karyawan`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_approval`
--
ALTER TABLE `tb_approval`
  MODIFY `approval_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `tb_barang_keluar`
--
ALTER TABLE `tb_barang_keluar`
  MODIFY `barang_keluar_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `tb_detail_pengeluaran`
--
ALTER TABLE `tb_detail_pengeluaran`
  MODIFY `detail_pengeluaran_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_approval`
--
ALTER TABLE `tb_approval`
  ADD CONSTRAINT `tb_approval_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`nrp_karyawan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_approval_pengeluaran_barang_id_foreign` FOREIGN KEY (`pengeluaran_barang_id`) REFERENCES `tb_pengeluaran_barang` (`pengeluaran_barang_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_detail_pengeluaran`
--
ALTER TABLE `tb_detail_pengeluaran`
  ADD CONSTRAINT `tb_detail_pengeluaran_barang_keluar_id_foreign` FOREIGN KEY (`barang_keluar_id`) REFERENCES `tb_barang_keluar` (`barang_keluar_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_detail_pengeluaran_pengeluaran_barang_id_foreign` FOREIGN KEY (`pengeluaran_barang_id`) REFERENCES `tb_pengeluaran_barang` (`pengeluaran_barang_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_pengeluaran_barang`
--
ALTER TABLE `tb_pengeluaran_barang`
  ADD CONSTRAINT `tb_pengeluaran_barang_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`nrp_karyawan`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

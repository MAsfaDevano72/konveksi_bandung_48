-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 13, 2026 at 12:59 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `konveksi-bandung-48`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-livewire-rate-limiter:23cd9ac273f49c7de29f40d58c41fc9d933a94b9', 'i:1;', 1767523434),
('laravel-cache-livewire-rate-limiter:23cd9ac273f49c7de29f40d58c41fc9d933a94b9:timer', 'i:1767523434;', 1767523434),
('laravel-cache-livewire-rate-limiter:949d30ea22f107bd43d44ad537056dcc17429d84', 'i:1;', 1767513377),
('laravel-cache-livewire-rate-limiter:949d30ea22f107bd43d44ad537056dcc17429d84:timer', 'i:1767513377;', 1767513377),
('laravel-cache-livewire-rate-limiter:a17961fa74e9275d529f489537f179c05d50c2f3', 'i:1;', 1767848539),
('laravel-cache-livewire-rate-limiter:a17961fa74e9275d529f489537f179c05d50c2f3:timer', 'i:1767848539;', 1767848539),
('laravel-cache-livewire-rate-limiter:bb45610b7c06fdf05f1c358235d33787bf4ae796', 'i:1;', 1767609544),
('laravel-cache-livewire-rate-limiter:bb45610b7c06fdf05f1c358235d33787bf4ae796:timer', 'i:1767609544;', 1767609544),
('laravel-cache-livewire-rate-limiter:dc2f81e1f1286b53da6aa4291c1578046c7f524b', 'i:1;', 1767598534),
('laravel-cache-livewire-rate-limiter:dc2f81e1f1286b53da6aa4291c1578046c7f524b:timer', 'i:1767598534;', 1767598534),
('laravel-cache-livewire-rate-limiter:e2125394b5bf88852a05a6b5f00d51532c7809f6', 'i:1;', 1767695562),
('laravel-cache-livewire-rate-limiter:e2125394b5bf88852a05a6b5f00d51532c7809f6:timer', 'i:1767695561;', 1767695562),
('laravel-cache-spatie.permission.cache', 'a:3:{s:5:\"alias\";a:0:{}s:11:\"permissions\";a:0:{}s:5:\"roles\";a:0:{}}', 1767895719);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `start_date` date NOT NULL,
  `job_desk` enum('Owner','Admin','Cutting','Tailor','QC/Packing') COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate_per_pcs` decimal(10,2) DEFAULT '0.00',
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `phone`, `email`, `address`, `start_date`, `job_desk`, `rate_per_pcs`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Sulis/Andri', '0819-1077-0777', 'owner@konveksibandung48.com', 'Jl. Situgunting Timur II No.48, Bandung', '2025-12-18', 'Owner', 0.00, 'active', '2025-12-17 17:36:37', '2025-12-17 17:36:37'),
(2, 'Admin Konveksi', '081990770777', 'admin@konveksibandung48.com', 'Jl.Situgunting Timur II No.48, Bandung', '2025-12-18', 'Admin', 10000.00, 'active', '2025-12-17 17:36:38', '2026-01-02 18:05:00'),
(3, 'Haris', '081234567890', 'haris@konveksibandung48.com', 'Garut', '2025-12-19', 'Tailor', 0.00, 'active', '2025-12-19 03:45:29', '2025-12-19 03:45:29'),
(4, 'Herman', '08123456789', 'herman@konveksibandung48.com', 'Bandung', '2025-12-29', 'Tailor', 0.00, 'active', '2025-12-29 16:35:41', '2026-01-06 14:51:47'),
(5, 'Devano', '081234567890', 'devano@konveksibandung48.com', 'Cikampek', '2026-01-01', 'QC/Packing', 12000.00, 'active', '2026-01-01 03:02:50', '2026-01-07 19:51:02'),
(6, 'Reyvan', '081234567890', 'reyvan@konveksibandung48.com', 'Cikampek', '2026-01-06', 'QC/Packing', 10000.00, 'active', '2026-01-06 12:55:20', '2026-01-06 12:55:20'),
(7, 'Rafa', '081234567890', 'rafa@konveksibandung48.com', 'Bandung', '2026-01-06', 'Admin', 10000.00, 'active', '2026-01-06 13:40:08', '2026-01-06 13:40:08');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventories`
--

CREATE TABLE `inventories` (
  `id` bigint UNSIGNED NOT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('Kain','Benang','Aksesoris') COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stock` double NOT NULL,
  `length` float DEFAULT NULL,
  `unit` enum('Kg','Meter','Pcs','Rol','Pack') COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `min_stock` double NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventories`
--

INSERT INTO `inventories` (`id`, `sku`, `name`, `type`, `color`, `stock`, `length`, `unit`, `price`, `min_stock`, `created_at`, `updated_at`) VALUES
(1, 'KN001-181225', 'Kain Sutra', 'Kain', 'Putih', 8, NULL, 'Rol', 50000.00, 5, '2025-12-18 16:09:14', '2026-01-02 03:40:56'),
(2, 'KN001-191225', 'Sabrina', 'Kain', 'Maroon', 3, 30, 'Rol', 10000.00, 0, '2025-12-19 03:28:38', '2026-01-06 14:41:04'),
(3, 'KN003-221225', 'Dry-FIT (Polyester)', 'Kain', 'Putih', 0, 20, 'Rol', 100000.00, 0, '2025-12-23 02:29:22', '2026-01-02 03:43:49'),
(4, 'KN25221226', 'Sabrina', 'Kain', 'Navy', 0, 80, 'Rol', 100000.00, 0, '2025-12-25 18:34:27', '2026-01-01 15:48:36'),
(5, 'KN25221227', 'Kain Sutra', 'Kain', 'Pink', 0, 70, 'Rol', 100000.00, 0, '2025-12-25 18:47:30', '2026-01-01 15:44:02'),
(6, 'BNG6-395739', 'Benang Fiber', 'Benang', 'Putih', 10, NULL, 'Pcs', 10000.00, 0, '2026-01-02 03:51:29', '2026-01-02 03:51:29'),
(7, 'AKS7-972497', 'kancing Baju', 'Aksesoris', 'Merah', 10, NULL, 'Pack', 5000.00, 0, '2026-01-06 13:01:34', '2026-01-06 13:54:22'),
(8, 'KN8-184680', 'Kain Polyester', 'Kain', 'Merah', 0, 10, 'Rol', 0.00, 0, '2026-01-06 13:51:27', '2026-01-10 23:29:22');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_histories`
--

CREATE TABLE `inventory_histories` (
  `id` bigint UNSIGNED NOT NULL,
  `inventory_id` bigint UNSIGNED NOT NULL,
  `type` enum('Masuk','Keluar','Terpakai') COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` double NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory_histories`
--

INSERT INTO `inventory_histories` (`id`, `inventory_id`, `type`, `quantity`, `notes`, `created_at`, `updated_at`) VALUES
(1, 2, 'Masuk', 10, NULL, '2025-12-25 18:25:59', '2025-12-25 18:25:59'),
(2, 1, 'Masuk', 10, NULL, '2025-12-25 18:27:02', '2025-12-25 18:27:02'),
(3, 3, 'Masuk', 10, NULL, '2025-12-25 18:30:29', '2025-12-25 18:30:29'),
(4, 2, 'Keluar', 2, 'Barang Rusak', '2025-12-25 18:32:32', '2025-12-25 18:32:32'),
(5, 5, 'Masuk', 5, NULL, '2025-12-25 19:27:43', '2025-12-25 19:27:43'),
(6, 4, 'Terpakai', 2, 'Produksi SPK: SPK-20251226-872 | Model: Kemeja', '2025-12-26 05:58:15', '2025-12-26 05:58:15'),
(7, 3, 'Terpakai', 1, 'Produksi SPK: SPK-20251227-439 | Model: TEESSS', '2025-12-30 03:22:23', '2025-12-30 03:22:23'),
(8, 1, 'Terpakai', 1, 'Produksi SPK: SPK-20251227-439 | Model: Seragam', '2026-01-01 04:40:12', '2026-01-01 04:40:12'),
(9, 4, 'Terpakai', 2, 'Produksi SPK: SPK-20251227-439 | Model: TES', '2026-01-01 06:15:57', '2026-01-01 06:15:57'),
(10, 4, 'Terpakai', 1, 'Produksi SPK: SPK-20251227-439 | Model: TEESSS', '2026-01-01 07:02:37', '2026-01-01 07:02:37'),
(11, 1, 'Keluar', 4, NULL, '2026-01-01 15:05:49', '2026-01-01 15:05:49'),
(12, 1, 'Keluar', 4, NULL, '2026-01-01 15:05:50', '2026-01-01 15:05:50'),
(13, 5, 'Keluar', 4, NULL, '2026-01-01 15:07:04', '2026-01-01 15:07:04'),
(14, 5, 'Keluar', 4, NULL, '2026-01-01 15:07:04', '2026-01-01 15:07:04'),
(15, 5, 'Masuk', 2, NULL, '2026-01-01 15:43:05', '2026-01-01 15:43:05'),
(16, 5, 'Masuk', 2, 'Stok masuk dari suplier\n', '2026-01-01 15:43:05', '2026-01-01 15:43:05'),
(17, 5, 'Keluar', 2, NULL, '2026-01-01 15:44:01', '2026-01-01 15:44:01'),
(18, 5, 'Keluar', 2, 'Barang rusak', '2026-01-01 15:44:02', '2026-01-01 15:44:02'),
(19, 1, 'Keluar', 5, NULL, '2026-01-01 15:47:21', '2026-01-01 15:47:21'),
(20, 1, 'Keluar', 5, NULL, '2026-01-01 15:47:22', '2026-01-01 15:47:22'),
(21, 4, 'Keluar', 5, NULL, '2026-01-01 15:48:36', '2026-01-01 15:48:36'),
(22, 4, 'Keluar', 5, NULL, '2026-01-01 15:48:36', '2026-01-01 15:48:36'),
(23, 3, 'Keluar', 9, NULL, '2026-01-01 16:08:51', '2026-01-01 16:08:51'),
(24, 3, 'Keluar', 9, NULL, '2026-01-01 16:08:51', '2026-01-01 16:08:51'),
(25, 2, 'Keluar', 2, NULL, '2026-01-02 03:30:18', '2026-01-02 03:30:18'),
(26, 2, 'Keluar', 2, NULL, '2026-01-02 03:30:18', '2026-01-02 03:30:18'),
(27, 1, 'Masuk', 10, NULL, '2026-01-02 03:37:42', '2026-01-02 03:37:42'),
(28, 1, 'Keluar', 2, 'Barang Rusak digigt tikus', '2026-01-02 03:40:56', '2026-01-02 03:40:56'),
(29, 6, 'Masuk', 10, NULL, '2026-01-02 03:51:29', '2026-01-02 03:51:29'),
(30, 7, 'Masuk', 10, NULL, '2026-01-06 13:01:35', '2026-01-06 13:01:35'),
(31, 7, 'Masuk', 10, NULL, '2026-01-06 13:02:34', '2026-01-06 13:02:34'),
(32, 7, 'Keluar', 5, 'Barang rusak', '2026-01-06 13:03:47', '2026-01-06 13:03:47'),
(33, 2, 'Terpakai', 2, 'Produksi SPK: SPK-20260106-528 | Model: Seragam Olahraga', '2026-01-06 13:13:07', '2026-01-06 13:13:07'),
(34, 8, 'Masuk', 2, NULL, '2026-01-06 13:51:27', '2026-01-06 13:51:27'),
(35, 8, 'Masuk', 2, 'Pembelian dari suplier A', '2026-01-06 13:52:53', '2026-01-06 13:52:53'),
(36, 7, 'Keluar', 5, 'Barang Rusak', '2026-01-06 13:54:23', '2026-01-06 13:54:23'),
(37, 2, 'Terpakai', 2, 'Produksi SPK: SPK-20260106-239 | Model: Seragama Prodi', '2026-01-06 14:41:04', '2026-01-06 14:41:04'),
(38, 8, 'Terpakai', 2, 'Produksi SPK: SPK-20260110-117 | Model: Tshirt Tour', '2026-01-10 13:26:14', '2026-01-10 13:26:14'),
(39, 8, 'Terpakai', 2, 'Produksi SPK: SPK-20260111-776 | Model: Hoodie', '2026-01-10 23:29:22', '2026-01-10 23:29:22');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `material_usages`
--

CREATE TABLE `material_usages` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `inventory_id` bigint UNSIGNED NOT NULL,
  `quantity_used` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2025_12_16_020926_create_employees_table', 1),
(4, '2025_12_16_020954_create_inventories_table', 1),
(5, '2025_12_16_020958_create_orders_table', 1),
(6, '2025_12_16_021103_create_production_logs_table', 1),
(7, '2025_12_16_021106_create_inventory_histories_table', 1),
(8, '2025_12_16_021110_create_material_usages_table', 1),
(9, '2025_12_16_021113_create_settings_table', 1),
(10, '2025_12_16_041602_create_permission_tables', 1),
(11, '2025_12_17_000001_create_users_table', 1),
(12, '2025_12_17_112406_create_notifications_table', 1),
(13, '2025_12_27_182625_create_production_outputs_table', 2),
(14, '2026_01_02_131217_create_settings_table', 3),
(15, '2026_01_02_210014_add_rate_to_employees_table', 4),
(16, '2026_01_02_215243_create_role_rates_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 3),
(4, 'App\\Models\\User', 4),
(4, 'App\\Models\\User', 5),
(5, 'App\\Models\\User', 6),
(5, 'App\\Models\\User', 7),
(2, 'App\\Models\\User', 8);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('001fcf56-6717-4e7c-b433-4c15085af0f0', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Pesanan SPK-20251227-439 mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Waiting Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-30 07:09:47', '2025-12-30 07:09:47'),
('0174d988-284b-4634-b3ea-bc21bc2e5d85', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 1, '{\"actions\":[],\"body\":\"Pesanan SPK-20251219-789 mulai di Sewing.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Sewing Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-18 20:35:26', '2025-12-18 20:35:26'),
('02bbaec1-6866-4b91-a331-e92453b6aebb', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251227-439 - TES pada Tahap QC\\/Packing Berhasil Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-05 04:48:13', '2026-01-05 04:48:13'),
('03a49fde-923d-4fc4-a9ce-d05218739229', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251227-439 - TES pada Tahap Cutting Berhasil Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-30 03:26:18', '2025-12-30 03:26:18'),
('03b62503-a61b-440c-b00c-1f743b3ebb58', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Kartu telah diarsipkan dari papan produksi.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251227-439 untuk TES Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:08:19', '2026-01-06 13:08:19'),
('03f8feb1-beee-499c-b39e-3598c572205a', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251227-439 - TES pada Tahap Sewing Berhasil Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-05 06:29:26', '2026-01-05 06:29:26'),
('05a35ac3-a7af-426b-9cac-a7371286a3b2', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":\"Stok Sabrina telah dikurangi 2 Rol.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Cutting Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 06:15:57', '2026-01-01 06:15:57'),
('065faf6e-1e5f-472d-89f0-376673a42192', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 1, '{\"actions\":[],\"body\":\"Tahap Waiting Selesai & Kartu Dipindahkan ke Cutting\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251218-381 - PPG LDII Jomin Barat.\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-19 03:32:10', '2025-12-19 03:32:10'),
('07828a9b-dd4b-47ca-b20a-a690efd7a657', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251219-839 - SD Gentra IV  pada Tahap Sewing Berhasil Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-31 03:35:47', '2025-12-31 03:35:47'),
('08441e7b-dc68-4263-a53f-2567990e28e6', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Tahap Waiting Selesai & Kartu Dipindahkan ke Cutting\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251218-381 - PPG LDII Jomin Barat.\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-19 03:23:20', '2025-12-19 03:23:20'),
('08a73493-ecd9-496b-9408-b40afdd4522f', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 2, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20260106-528 - SD Jomin Barat III pada Tahap QC\\/Packing Berhasil Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:21:36', '2026-01-06 13:21:36'),
('08b3a218-2277-496d-b02f-a041bdbf788a', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-information-circle\",\"iconColor\":\"info\",\"status\":\"info\",\"title\":\"Berhasil Cicil 11 Pcs untuk pesanan SPK-20251219-839 oleh Sulis\\/Andri\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-28 17:09:59', '2025-12-28 17:09:59'),
('094c13fa-d1c4-489d-af95-5ac4298acadb', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251227-439 untuk TES dipindahkan ke Tahap Potongan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 06:12:00', '2026-01-01 06:12:00'),
('09b75644-1ef6-429c-96a3-1c4f3205af47', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251227-439 - TES pada Tahap Sewing Berhasil Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-05 06:29:26', '2026-01-05 06:29:26'),
('09c7b6bb-f364-48ea-8e64-a26fd4cd9328', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Pesanan SPK-20251227-439 - TES mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi QC & Packing Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-05 04:46:48', '2026-01-05 04:46:48'),
('0e502374-98e3-4cfc-ac8c-39aa07411466', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Tersisa 5 Rol. Segera isi ulang!\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-exclamation-triangle\",\"iconColor\":\"danger\",\"status\":\"danger\",\"title\":\"\\u26a0\\ufe0f Stok Rendah: Kain Sutra\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 15:05:50', '2026-01-01 15:05:50'),
('0f38a21b-f3b0-4c37-a279-bf877fbc5b15', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 2, '{\"actions\":[],\"body\":\"Pesanan SPK-20260106-239 - SMK Pusara mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 14:47:27', '2026-01-06 14:47:27'),
('0f827ed6-c059-4e4a-a4f1-c4e888704dd3', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Kembali ke tahap awal, melakukan produksi ulang.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-information-circle\",\"iconColor\":\"info\",\"status\":\"info\",\"title\":\"Pesanan SPK-20251227-439 untuk TES Diulang\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-30 03:20:13', '2025-12-30 03:20:13'),
('0fa85afd-a6f6-4970-8f85-d32f18bb68b7', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[{\"name\":\"Lihat Pesanan\",\"color\":null,\"event\":null,\"eventData\":[],\"dispatchDirection\":false,\"dispatchToComponent\":null,\"extraAttributes\":[],\"icon\":null,\"iconPosition\":\"before\",\"iconSize\":null,\"isOutlined\":false,\"isDisabled\":false,\"label\":\"Lihat pesanan\",\"shouldClose\":false,\"shouldMarkAsRead\":false,\"shouldMarkAsUnread\":false,\"shouldOpenUrlInNewTab\":false,\"size\":\"sm\",\"tooltip\":null,\"url\":\"\\/admin\\/orders\\/11\\/view\",\"view\":\"filament-actions::link-action\"}],\"body\":\"Pesanan SPK-20251227-439 (TES) jatuh tempo dalam 3 hari lagi!\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-exclamation-circle\",\"iconColor\":\"warning\",\"status\":\"warning\",\"title\":\"Peringatan Deadline!\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-04 12:46:32', '2026-01-04 12:46:32'),
('0ff0a77a-a314-41a8-b507-88c07c096cb3', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-information-circle\",\"iconColor\":\"info\",\"status\":\"info\",\"title\":\"Berhasil Cicil 30 Pcs untuk pesanan SPK-20251218-381 oleh Haris\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-29 03:11:42', '2025-12-29 03:11:42'),
('1029d411-c279-49e7-8ea3-cdb4f458b91e', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 6, '{\"actions\":[],\"body\":\"Kartu telah diarsipkan dari papan produksi.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20260106-239 untuk SMK Pusara Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-07 04:16:11', '2026-01-07 04:16:11'),
('10a8081f-45fc-459c-a039-72493131c7fc', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[{\"name\":\"Lihat\",\"color\":null,\"event\":null,\"eventData\":[],\"dispatchDirection\":false,\"dispatchToComponent\":null,\"extraAttributes\":[],\"icon\":null,\"iconPosition\":\"before\",\"iconSize\":null,\"isOutlined\":false,\"isDisabled\":false,\"label\":\"Lihat\",\"shouldClose\":false,\"shouldMarkAsRead\":false,\"shouldMarkAsUnread\":false,\"shouldOpenUrlInNewTab\":false,\"size\":\"sm\",\"tooltip\":null,\"url\":\"\\/admin\\/orders\\/13\\/edit\",\"view\":\"filament-actions::link-action\"}],\"body\":\"Pesanan SPK-20260106-239 (Seragam Batik) jatuh tempo dalam 3 hari.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-exclamation-circle\",\"iconColor\":\"warning\",\"status\":\"warning\",\"title\":\"Deadline Mendekat (H-3)\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 18:18:05', '2026-01-06 18:18:05'),
('119ff793-f657-4040-a22c-83561e373e40', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Pesanan SPK-20251227-439 mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-31 03:26:54', '2025-12-31 03:26:54'),
('1354af43-e678-43dc-8324-1232f795f631', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Pesanan SPK-20251227-439 mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Waiting Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-30 07:10:04', '2025-12-30 07:10:04'),
('13d8ab7d-4088-4104-a171-670761e1e0ee', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 8, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20260106-239 untuk SMK Pusara dipindahkan ke Tahap Potongan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 14:38:48', '2026-01-06 14:38:48'),
('140988fb-d097-41e3-971f-9852d883b87f', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 8, '{\"actions\":[],\"body\":\"Stok Sabrina telah dikurangi 2 Rol.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Cutting Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 14:41:05', '2026-01-06 14:41:05'),
('156b6ae8-3d94-4d43-a5be-800c3c545463', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 5, '{\"actions\":[{\"name\":\"Lihat\",\"color\":null,\"event\":null,\"eventData\":[],\"dispatchDirection\":false,\"dispatchToComponent\":null,\"extraAttributes\":[],\"icon\":null,\"iconPosition\":\"before\",\"iconSize\":null,\"isOutlined\":false,\"isDisabled\":false,\"label\":\"Lihat\",\"shouldClose\":false,\"shouldMarkAsRead\":false,\"shouldMarkAsUnread\":false,\"shouldOpenUrlInNewTab\":false,\"size\":\"sm\",\"tooltip\":null,\"url\":\"\\/admin\\/orders\\/13\\/edit\",\"view\":\"filament-actions::link-action\"}],\"body\":\"Pesanan SPK-20260106-239 (Seragam Batik) jatuh tempo dalam 3 hari.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-exclamation-circle\",\"iconColor\":\"warning\",\"status\":\"warning\",\"title\":\"Deadline Mendekat (H-3)\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-07 03:26:19', '2026-01-07 03:26:19'),
('158ba11f-4d83-4aa2-8b77-d0404905a165', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":\"Pesanan SPK-20251227-439 - TES mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-05 05:23:05', '2026-01-05 05:23:05'),
('159a87bb-3f1d-447f-b0d5-b1e3f3ef5e03', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Pesanan SPK-20251227-439 mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-30 03:36:23', '2025-12-30 03:36:23'),
('16c6b977-f7c0-4d2d-8c60-674f0048a19f', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":\"Pesanan SPK-20251227-439 mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-31 03:26:54', '2025-12-31 03:26:54'),
('17858327-d946-43e8-8516-745343af33c9', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":\"Pesanan SPK-20260106-528 - SD Jomin Barat III mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi QC & Packing Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:19:48', '2026-01-06 13:19:48'),
('1a61e8fd-4c28-48f8-a53d-03427afeb0f8', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-information-circle\",\"iconColor\":\"info\",\"status\":\"info\",\"title\":\"Berhasil Cicil 10 Pcs untuk pesanan SPK-20251218-381 oleh Herman\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-30 02:43:19', '2025-12-30 02:43:19'),
('1adbdf29-9e53-4f62-8ad7-885004190bea', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251219-839 - SD Gentra IV  pada Tahap QC\\/Packing Berhasil Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-30 03:59:17', '2025-12-30 03:59:17'),
('1f3ec3d1-47fa-44b6-92b8-d7b20726a85f', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Proses Cutting pesanan SPK-20251218-381 ( PPG LDII Jomin Barat ) Selesai, Lanjut ke Penjahitan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-25 08:08:30', '2025-12-25 08:08:30'),
('1fbf57f9-3c15-4190-bbd2-be9a57f05a74', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20260106-239 untuk SMK Pusara dipindahkan ke Tahap Potongan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 14:38:48', '2026-01-06 14:38:48'),
('1ff9071f-1eb2-4a68-8a97-74c69037d9cb', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Stok Sabrina telah dikurangi 2 Rol.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Cutting Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-26 05:58:16', '2025-12-26 05:58:16'),
('20221542-92f2-49ec-bcc5-ae887a2e84b6', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251227-439 - TES pada Tahap Sewing Berhasil Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-05 04:52:38', '2026-01-05 04:52:38'),
('2207b390-8c4e-49d2-ae8e-eaeb7d1c338e', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Tahap Cutting Selesai & Kartu Dipindahkan ke Sewing\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251218-349 - PT.Pupuk Kujang Cikampek.\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-19 03:34:26', '2025-12-19 03:34:26'),
('223fbb59-d043-48e6-8426-52fc42c0c467', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Stok Sabrina telah dikurangi 1 Rol.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Cutting Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 07:02:38', '2026-01-01 07:02:38'),
('24ba6910-15c8-42de-aaae-f050ceae0514', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[{\"name\":\"Lihat\",\"color\":null,\"event\":null,\"eventData\":[],\"dispatchDirection\":false,\"dispatchToComponent\":null,\"extraAttributes\":[],\"icon\":null,\"iconPosition\":\"before\",\"iconSize\":null,\"isOutlined\":false,\"isDisabled\":false,\"label\":\"Lihat\",\"shouldClose\":false,\"shouldMarkAsRead\":false,\"shouldMarkAsUnread\":false,\"shouldOpenUrlInNewTab\":false,\"size\":\"sm\",\"tooltip\":null,\"url\":\"\\/admin\\/orders\\/13\\/edit\",\"view\":\"filament-actions::link-action\"}],\"body\":\"Pesanan SPK-20260106-239 (Seragam Batik) jatuh tempo dalam 3 hari.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-exclamation-circle\",\"iconColor\":\"warning\",\"status\":\"warning\",\"title\":\"Deadline Mendekat (H-3)\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-07 03:26:19', '2026-01-07 03:26:19'),
('25b74c7b-f3ce-4d87-8a35-84c69b8376f9', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 1, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Tahap Cutting Selesai & Kartu Dipindahkan ke Sewing\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-18 20:20:32', '2025-12-18 20:20:32'),
('25be5ecd-e1ea-4cec-99dc-5169bc9b7bf9', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":\"Stok Sabrina telah dikurangi 1 Rol.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Cutting Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 07:02:38', '2026-01-01 07:02:38'),
('25dd4e13-8502-4bbd-8876-6845c5d3739f', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 8, '{\"actions\":[{\"name\":\"Lihat\",\"color\":null,\"event\":null,\"eventData\":[],\"dispatchDirection\":false,\"dispatchToComponent\":null,\"extraAttributes\":[],\"icon\":null,\"iconPosition\":\"before\",\"iconSize\":null,\"isOutlined\":false,\"isDisabled\":false,\"label\":\"Lihat\",\"shouldClose\":false,\"shouldMarkAsRead\":false,\"shouldMarkAsUnread\":false,\"shouldOpenUrlInNewTab\":false,\"size\":\"sm\",\"tooltip\":null,\"url\":\"\\/admin\\/orders\\/13\\/edit\",\"view\":\"filament-actions::link-action\"}],\"body\":\"Pesanan SPK-20260106-239 (Seragam Batik) jatuh tempo dalam 3 hari.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-exclamation-circle\",\"iconColor\":\"warning\",\"status\":\"warning\",\"title\":\"Deadline Mendekat (H-3)\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 18:18:05', '2026-01-06 18:18:05'),
('26ce592d-3a2b-435e-a4a6-09ebf2d68fb8', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251219-839 - SD Gentra IV  pada Tahap QC\\/Packing Berhasil Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-31 03:53:23', '2025-12-31 03:53:23'),
('27d1e91c-4cc5-4ee8-a68a-2b5d2055dcf7', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Pesanan SPK-20251219-839 mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-27 20:42:20', '2025-12-27 20:42:20'),
('293cb252-6937-4132-9d54-0ef7b6caf197', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251219-839 - SD Gentra IV  pada Tahap QC\\/Packing Berhasil Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-30 03:59:18', '2025-12-30 03:59:18'),
('298a2364-9bd3-4a52-b9f1-7a8689c7e900', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 7, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20260106-528 untuk SD Jomin Barat III dipindahkan ke Tahap Potongan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:11:16', '2026-01-06 13:11:16'),
('2a14a593-78fd-4f81-be2d-e28a76dc8d26', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[{\"name\":\"Lihat Pesanan\",\"color\":null,\"event\":null,\"eventData\":[],\"dispatchDirection\":false,\"dispatchToComponent\":null,\"extraAttributes\":[],\"icon\":null,\"iconPosition\":\"before\",\"iconSize\":null,\"isOutlined\":false,\"isDisabled\":false,\"label\":\"Lihat pesanan\",\"shouldClose\":false,\"shouldMarkAsRead\":false,\"shouldMarkAsUnread\":false,\"shouldOpenUrlInNewTab\":false,\"size\":\"sm\",\"tooltip\":null,\"url\":\"\\/admin\\/orders\\/11\\/view\",\"view\":\"filament-actions::link-action\"}],\"body\":\"Pesanan SPK-20251227-439 (TES) jatuh tempo dalam 3 hari lagi!\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-exclamation-circle\",\"iconColor\":\"warning\",\"status\":\"warning\",\"title\":\"Peringatan Deadline!\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-02 08:05:07', '2026-01-02 08:05:07'),
('2a16a425-19df-4ff0-b7f6-f6f1d2193315', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 6, '{\"actions\":[],\"body\":\"Stok Sabrina telah dikurangi 2 Rol.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Cutting Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 14:41:05', '2026-01-06 14:41:05'),
('2a435c2b-3540-4b2c-a7f0-7bb890d58ece', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":\"Pesanan SPK-20260106-239 - SMK Pusara mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 14:47:27', '2026-01-06 14:47:27'),
('2cd31fb1-ea57-4987-80a0-21afc6a78b6f', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":\"Pesanan SPK-20251227-439 mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Waiting Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-30 07:09:47', '2025-12-30 07:09:47'),
('2dee84e8-54eb-4aca-b994-92453ca31ea7', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":\"Kembali ke tahap awal, melakukan produksi ulang.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-information-circle\",\"iconColor\":\"info\",\"status\":\"info\",\"title\":\"Pesanan SPK-20251227-439 untuk TES Diulang\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-30 03:20:13', '2025-12-30 03:20:13'),
('2e244c79-6bf0-47da-9677-817d7d16845c', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-information-circle\",\"iconColor\":\"info\",\"status\":\"info\",\"title\":\"Berhasil Cicil 30 Pcs untuk pesanan SPK-20251218-381 oleh Haris\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-29 03:11:42', '2025-12-29 03:11:42'),
('2f6afed6-8504-4d26-8dc2-7d316a1a1181', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251227-439 - TES pada Tahap QC\\/Packing Berhasil Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-05 04:48:13', '2026-01-05 04:48:13'),
('3011ddc7-141e-45e4-8538-df0a59947401', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Kartu telah diarsipkan dari papan produksi.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251218-518 untuk TK Tadika Mesra Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-26 06:47:54', '2025-12-26 06:47:54'),
('358a8d62-86d8-4c05-b3f7-3d91f08ffed9', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 7, '{\"actions\":[],\"body\":\"Stok Sabrina telah dikurangi 2 Rol.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Cutting Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 14:41:05', '2026-01-06 14:41:05'),
('35c4af26-25d6-48f0-a162-22c7b11dadbe', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Kembali ke tahap awal, melakukan produksi ulang.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-information-circle\",\"iconColor\":\"info\",\"status\":\"info\",\"title\":\"Pesanan SPK-20251218-349 untuk PT.Pupuk Kujang Cikampek Diulang\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-25 19:01:13', '2025-12-25 19:01:13'),
('37f4e137-7d34-440a-a97a-21872641674d', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 6, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251227-439 - TES pada Tahap QC\\/Packing Berhasil Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-05 04:48:13', '2026-01-05 04:48:13'),
('37f5775e-e931-430b-98fd-a1b364d884a3', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251226-872 - SD Sarimulya III pada Tahap QC\\/Packing Berhasil Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-26 06:46:14', '2025-12-26 06:46:14'),
('38c7b204-76bc-4224-b52b-792fbdb4623f', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Kartu telah diarsipkan dari papan produksi.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251218-381 untuk PPG LDII Jomin Barat Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:10:06', '2026-01-06 13:10:06'),
('397ec1b8-e11b-411b-8d0f-de3f5ce339e0', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Tahap Cutting Selesai & Kartu Dipindahkan ke Sewing\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-18 20:20:32', '2025-12-18 20:20:32'),
('39c6c4cb-9e4c-492a-9799-2d59d28de2ac', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Tahap Cutting Selesai & Kartu Dipindahkan ke Sewing\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251218-381 - PPG LDII Jomin Barat.\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-19 03:58:56', '2025-12-19 03:58:56'),
('3a8ac666-836c-4834-b28f-f73b13db24fe', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":\"Pesanan SPK-20251227-439 - TES mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi QC & Packing Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 06:46:10', '2026-01-01 06:46:10'),
('3a9d2dbe-d4ac-4555-9ab7-a83832fa1c57', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Pesanan SPK-20251218-381 mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi QC & Packing Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 03:14:00', '2026-01-01 03:14:00'),
('3ae711a3-64ce-42ee-8f1a-bc0abefda153', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 6, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Proses Cutting pesanan SPK-20251227-439 ( TES ) Selesai, Lanjut ke Penjahitan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 07:03:27', '2026-01-01 07:03:27'),
('3bc69911-57fd-4f44-8409-923b490d241c', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 1, '{\"actions\":[],\"body\":\"Tahap Cutting Selesai & Kartu Dipindahkan ke Sewing\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251218-349 - PT.Pupuk Kujang Cikampek.\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-19 03:34:26', '2025-12-19 03:34:26'),
('3bd3400f-4293-49af-962e-bf44976316b7', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 6, '{\"actions\":[],\"body\":\"Pesanan SPK-20260106-239 - SMK Pusara mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 14:47:27', '2026-01-06 14:47:27'),
('3bd9d8fe-0347-4f78-9177-4512c476ccf7', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 6, '{\"actions\":[],\"body\":\"Pesanan SPK-20260106-239 - SMK Pusara mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi QC & Packing Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 18:05:03', '2026-01-06 18:05:03'),
('3c89a456-c89b-49a5-8ef0-015aaab0b812', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 5, '{\"actions\":[],\"body\":\"Pesanan SPK-20251227-439 - TES mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', '2026-01-06 14:50:10', '2026-01-05 04:52:02', '2026-01-06 14:50:10'),
('3d3a176f-f6cb-4196-9bc6-680b1c4aba6a', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Pesanan SPK-20251219-839 mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi QC & Packing Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-31 03:52:33', '2025-12-31 03:52:33'),
('4278c0ce-d2b1-4395-a8d9-f37659cc7ab8', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 6, '{\"actions\":[],\"body\":\"Pesanan SPK-20251227-439 - TES mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi QC & Packing Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 06:46:10', '2026-01-01 06:46:10'),
('42a963e5-d682-4cbf-a920-b67bb546497d', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Tersisa 0 Rol. Segera isi ulang!\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-exclamation-triangle\",\"iconColor\":\"danger\",\"status\":\"danger\",\"title\":\"\\u26a0\\ufe0f Stok Rendah: Kain Sutra\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-20 17:42:15', '2025-12-20 17:42:15'),
('42b8f51d-6f1d-4883-b164-44955cd02b66', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 6, '{\"actions\":[{\"name\":\"Lihat Pesanan\",\"color\":null,\"event\":null,\"eventData\":[],\"dispatchDirection\":false,\"dispatchToComponent\":null,\"extraAttributes\":[],\"icon\":null,\"iconPosition\":\"before\",\"iconSize\":null,\"isOutlined\":false,\"isDisabled\":false,\"label\":\"Lihat pesanan\",\"shouldClose\":false,\"shouldMarkAsRead\":false,\"shouldMarkAsUnread\":false,\"shouldOpenUrlInNewTab\":false,\"size\":\"sm\",\"tooltip\":null,\"url\":\"\\/admin\\/orders\\/11\\/view\",\"view\":\"filament-actions::link-action\"}],\"body\":\"Pesanan SPK-20251227-439 (TES) jatuh tempo dalam 3 hari lagi!\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-exclamation-circle\",\"iconColor\":\"warning\",\"status\":\"warning\",\"title\":\"Peringatan Deadline!\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-04 12:47:46', '2026-01-04 12:47:46'),
('4304ce69-7075-43f8-87cd-fb4e7d34df44', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 6, '{\"actions\":[{\"name\":\"Lihat\",\"color\":null,\"event\":null,\"eventData\":[],\"dispatchDirection\":false,\"dispatchToComponent\":null,\"extraAttributes\":[],\"icon\":null,\"iconPosition\":\"before\",\"iconSize\":null,\"isOutlined\":false,\"isDisabled\":false,\"label\":\"Lihat\",\"shouldClose\":false,\"shouldMarkAsRead\":false,\"shouldMarkAsUnread\":false,\"shouldOpenUrlInNewTab\":false,\"size\":\"sm\",\"tooltip\":null,\"url\":\"\\/admin\\/orders\\/13\\/edit\",\"view\":\"filament-actions::link-action\"}],\"body\":\"Pesanan SPK-20260106-239 (Seragam Batik) jatuh tempo dalam 3 hari.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-exclamation-circle\",\"iconColor\":\"warning\",\"status\":\"warning\",\"title\":\"Deadline Mendekat (H-3)\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-07 03:26:19', '2026-01-07 03:26:19'),
('44a317f7-0793-4751-8c9f-e1f121e72d25', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[{\"name\":\"Lihat Pesanan\",\"color\":null,\"event\":null,\"eventData\":[],\"dispatchDirection\":false,\"dispatchToComponent\":null,\"extraAttributes\":[],\"icon\":null,\"iconPosition\":\"before\",\"iconSize\":null,\"isOutlined\":false,\"isDisabled\":false,\"label\":\"Lihat pesanan\",\"shouldClose\":false,\"shouldMarkAsRead\":false,\"shouldMarkAsUnread\":false,\"shouldOpenUrlInNewTab\":false,\"size\":\"sm\",\"tooltip\":null,\"url\":\"\\/admin\\/orders\\/11\\/view\",\"view\":\"filament-actions::link-action\"}],\"body\":\"Pesanan SPK-20251227-439 (TES) jatuh tempo dalam 3 hari lagi!\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-exclamation-circle\",\"iconColor\":\"warning\",\"status\":\"warning\",\"title\":\"Peringatan Deadline!\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-04 12:46:32', '2026-01-04 12:46:32'),
('46bdda5c-a414-4416-bcbf-fa8fe5da8a59', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":\"Kembali ke tahap awal, melakukan produksi ulang.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-information-circle\",\"iconColor\":\"info\",\"status\":\"info\",\"title\":\"Pesanan SPK-20251227-439 untuk TES Diulang\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-30 04:51:14', '2025-12-30 04:51:14'),
('472c68e4-6077-4117-b252-71ae08ae5723', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Tersisa 0 Rol. Segera isi ulang!\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-exclamation-triangle\",\"iconColor\":\"danger\",\"status\":\"danger\",\"title\":\"\\u26a0\\ufe0f Stok Rendah: Dry-FIT (Polyester)\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-25 08:00:29', '2025-12-25 08:00:29'),
('4760a020-a095-4055-b112-368cf073d634', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 2, '{\"actions\":[],\"body\":\"Stok Sabrina telah dikurangi 2 Rol.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Cutting Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:13:08', '2026-01-06 13:13:08'),
('4774daab-a1c5-4be4-85cb-b013a37323cf', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 6, '{\"actions\":[],\"body\":\"Pesanan SPK-20251227-439 - TES mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-05 05:23:05', '2026-01-05 05:23:05'),
('47dc0276-6dc6-476e-bd4a-b89315265bc1', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251219-839 - SD Gentra IV  pada Tahap QC\\/Packing Berhasil Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-31 03:53:23', '2025-12-31 03:53:23'),
('486e0e74-e59a-4aad-8e15-94a5626d81bd', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 2, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20260106-239 untuk SMK Pusara dipindahkan ke Tahap Potongan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 14:38:48', '2026-01-06 14:38:48'),
('48c8cece-f922-4295-a334-018bb16dad4d', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Tersisa 0 Rol. Segera isi ulang!\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-exclamation-triangle\",\"iconColor\":\"danger\",\"status\":\"danger\",\"title\":\"\\u26a0\\ufe0f Stok Rendah: Dry-FIT (Polyester)\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 16:08:51', '2026-01-01 16:08:51'),
('48f2d613-0808-4e53-a2c2-fe237fd8b1f9', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":\"Kartu telah diarsipkan dari papan produksi.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20260106-528 untuk SD Jomin Barat III Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:22:32', '2026-01-06 13:22:32'),
('490adbcc-88ce-45c1-905c-fa107aa8d296', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 6, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251227-439 - TES pada Tahap Sewing Berhasil Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-05 06:29:26', '2026-01-05 06:29:26'),
('49dd9148-99c0-40d1-922f-9b2bb557e240', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 2, '{\"actions\":[],\"body\":\"Kartu telah diarsipkan dari papan produksi.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20260106-528 untuk SD Jomin Barat III Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:22:32', '2026-01-06 13:22:32'),
('4a44f199-5887-48c6-93c9-7a18a97a4a7a', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 7, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Proses Cutting pesanan SPK-20260106-528 ( SD Jomin Barat III ) Selesai, Lanjut ke Penjahitan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:16:05', '2026-01-06 13:16:05'),
('4b9840d6-783a-4dbe-be58-2d4eb3d04c1c', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Kartu telah diarsipkan dari papan produksi.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20260106-528 untuk SD Jomin Barat III Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:22:32', '2026-01-06 13:22:32'),
('4d32dd9f-6d7f-48ca-a4b0-13d39b432f07', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251226-872 - SD Sarimulya III pada Tahap Sewing Berhasil Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-26 06:41:12', '2025-12-26 06:41:12');
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('5106fbe5-b787-4b93-836d-7c61a862311b', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 6, '{\"actions\":[],\"body\":\"Kartu telah diarsipkan dari papan produksi.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251218-381 untuk PPG LDII Jomin Barat Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:10:06', '2026-01-06 13:10:06'),
('552d1074-b59f-4159-9453-ee5acba7c937', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Pesanan SPK-20251226-872 mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi QC & Packing untuk SD Sarimulya III Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-26 06:41:25', '2025-12-26 06:41:25'),
('56183c2e-d0cc-419e-8e46-207a1b566ffc', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 6, '{\"actions\":[{\"name\":\"Lihat Pesanan\",\"color\":null,\"event\":null,\"eventData\":[],\"dispatchDirection\":false,\"dispatchToComponent\":null,\"extraAttributes\":[],\"icon\":null,\"iconPosition\":\"before\",\"iconSize\":null,\"isOutlined\":false,\"isDisabled\":false,\"label\":\"Lihat pesanan\",\"shouldClose\":false,\"shouldMarkAsRead\":false,\"shouldMarkAsUnread\":false,\"shouldOpenUrlInNewTab\":false,\"size\":\"sm\",\"tooltip\":null,\"url\":\"\\/admin\\/orders\\/11\\/view\",\"view\":\"filament-actions::link-action\"}],\"body\":\"Pesanan SPK-20251227-439 (TES) jatuh tempo dalam 3 hari lagi!\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-exclamation-circle\",\"iconColor\":\"warning\",\"status\":\"warning\",\"title\":\"Peringatan Deadline!\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-02 08:05:07', '2026-01-02 08:05:07'),
('56d3fb5c-bab1-465f-baed-9331f692cdef', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":\"Stok Sabrina telah dikurangi 2 Rol.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Cutting Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 14:41:05', '2026-01-06 14:41:05'),
('56f0e81e-46d7-4324-8d59-c08bd3302038', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 7, '{\"actions\":[],\"body\":\"Pesanan SPK-20260106-239 - SMK Pusara mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 14:47:27', '2026-01-06 14:47:27'),
('571e4bc4-5e0f-4fcb-9c5b-6d6baad02ad8', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 7, '{\"actions\":[],\"body\":\"Kartu telah diarsipkan dari papan produksi.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251227-439 untuk TES Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:08:19', '2026-01-06 13:08:19'),
('579ea619-649f-4efb-b738-b8e47c8a7be6', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 6, '{\"actions\":[],\"body\":\"Kembali ke tahap awal, melakukan produksi ulang.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-information-circle\",\"iconColor\":\"info\",\"status\":\"info\",\"title\":\"Pesanan SPK-20251227-439 untuk TES Diulang\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 06:50:49', '2026-01-01 06:50:49'),
('59531495-c45e-4bba-b24a-20ccea60a09b', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 2, '{\"actions\":[],\"body\":\"Pesanan SPK-20251227-439 - TES mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi QC & Packing Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-05 04:46:48', '2026-01-05 04:46:48'),
('5ad34719-1858-4352-b5a8-ee85a4c17aa2', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":\"Pesanan SPK-20251227-439 mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Waiting Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-30 07:10:04', '2025-12-30 07:10:04'),
('5ae19203-2e7c-4991-8b23-b65f775e2633', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Kembali ke tahap awal, melakukan produksi ulang.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-information-circle\",\"iconColor\":\"info\",\"status\":\"info\",\"title\":\"Pesanan SPK-20251227-439 untuk TES Diulang\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 06:50:49', '2026-01-01 06:50:49'),
('5cac28a0-6bef-4b43-b88e-61bc79aebae2', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 6, '{\"actions\":[{\"name\":\"Lihat\",\"color\":null,\"event\":null,\"eventData\":[],\"dispatchDirection\":false,\"dispatchToComponent\":null,\"extraAttributes\":[],\"icon\":null,\"iconPosition\":\"before\",\"iconSize\":null,\"isOutlined\":false,\"isDisabled\":false,\"label\":\"Lihat\",\"shouldClose\":false,\"shouldMarkAsRead\":false,\"shouldMarkAsUnread\":false,\"shouldOpenUrlInNewTab\":false,\"size\":\"sm\",\"tooltip\":null,\"url\":\"\\/admin\\/orders\\/13\\/edit\",\"view\":\"filament-actions::link-action\"}],\"body\":\"Pesanan SPK-20260106-239 (Seragam Batik) jatuh tempo dalam 3 hari.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-exclamation-circle\",\"iconColor\":\"warning\",\"status\":\"warning\",\"title\":\"Deadline Mendekat (H-3)\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 18:18:05', '2026-01-06 18:18:05'),
('5d773e21-dc32-40ae-9798-df39a17838c0', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Proses Cutting pesanan SPK-20260106-528 ( SD Jomin Barat III ) Selesai, Lanjut ke Penjahitan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:16:04', '2026-01-06 13:16:04'),
('5f722212-b106-4220-a1fa-9989ff11b530', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Stok Sabrina telah dikurangi 2 Rol.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Cutting Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:13:08', '2026-01-06 13:13:08'),
('601e8648-cbca-4644-9d40-07b06e5aa103', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Pesanan SPK-20260106-239 - SMK Pusara mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 14:47:27', '2026-01-06 14:47:27'),
('609f2a7f-dac4-4238-b0fb-7c822a7e4118', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251218-381 untuk PPG LDII Jomin Barat dipindahkan ke Tahap Potongan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-25 07:59:22', '2025-12-25 07:59:22'),
('60ff9e7a-680a-4311-b9a6-2a2ccf7a8390', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Pesanan SPK-20251227-439 - TES mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 07:04:18', '2026-01-01 07:04:18'),
('619d9d19-7415-4a9e-a388-08fdb1d86f79', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Pesanan SPK-20251227-439 - TES mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 06:26:21', '2026-01-01 06:26:21'),
('62d8eb55-a658-46cd-b149-76bc4923386b', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Tersisa -8 Rol. Segera isi ulang!\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-exclamation-triangle\",\"iconColor\":\"danger\",\"status\":\"danger\",\"title\":\"\\u26a0\\ufe0f Stok Rendah: Sabrina\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-20 04:52:07', '2025-12-20 04:52:07'),
('64060f2e-d434-493c-9953-f6548b8161eb', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 5, '{\"actions\":[],\"body\":\"Stok Sabrina telah dikurangi 2 Rol.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Cutting Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', '2026-01-06 14:50:10', '2026-01-06 14:41:05', '2026-01-06 14:50:10'),
('642aff05-8e8b-4f99-9348-2f3e4dcdbd78', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":\"Pesanan SPK-20251227-439 - TES mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 06:26:21', '2026-01-01 06:26:21'),
('646c4304-56c4-4172-a2ba-c3afb6970578', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251227-439 untuk TES dipindahkan ke Tahap Potongan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-30 03:21:08', '2025-12-30 03:21:08'),
('64f46314-334e-4feb-b5d4-c399a4de5513', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 7, '{\"actions\":[],\"body\":\"Kartu telah diarsipkan dari papan produksi.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20260106-239 untuk SMK Pusara Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-07 04:16:11', '2026-01-07 04:16:11'),
('65271281-35be-4d9e-bbee-7e8c18bbf02b', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Pesanan SPK-20251218-381 mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-29 03:07:22', '2025-12-29 03:07:22'),
('66cd6d50-5821-470c-91f3-e39c0c6b4fc9', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Pesanan SPK-20251218-381 - PPG LDII Jomin Barat mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi QC & Packing Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-05 07:32:53', '2026-01-05 07:32:53'),
('6734ff54-5fbb-4cd6-ae68-f9e9eb0e89b2', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 1, '{\"actions\":[{\"name\":\"Lihat Pesanan\",\"color\":null,\"event\":null,\"eventData\":[],\"dispatchDirection\":false,\"dispatchToComponent\":null,\"extraAttributes\":[],\"icon\":null,\"iconPosition\":\"before\",\"iconSize\":null,\"isOutlined\":false,\"isDisabled\":false,\"label\":\"Lihat pesanan\",\"shouldClose\":false,\"shouldMarkAsRead\":false,\"shouldMarkAsUnread\":false,\"shouldOpenUrlInNewTab\":false,\"size\":\"sm\",\"tooltip\":null,\"url\":\"\\/admin\\/orders\\/11\\/view\",\"view\":\"filament-actions::link-action\"}],\"body\":\"Pesanan SPK-20251227-439 (TES) jatuh tempo dalam 3 hari lagi!\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-exclamation-circle\",\"iconColor\":\"warning\",\"status\":\"warning\",\"title\":\"Peringatan Deadline!\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-04 12:47:45', '2026-01-04 12:47:45'),
('673ccf49-1bfd-484c-957b-30cfad9676dc', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251218-349 untuk PT.Pupuk Kujang Cikampek dipindahkan ke Tahap Potongan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-25 19:05:10', '2025-12-25 19:05:10'),
('67a75fee-a95b-42e2-8be1-9a5034f212ea', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Tersisa 4 Rol. Segera isi ulang!\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-exclamation-triangle\",\"iconColor\":\"danger\",\"status\":\"danger\",\"title\":\"\\u26a0\\ufe0f Stok Rendah: Kain Sutra\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-18 19:55:20', '2025-12-18 19:55:20'),
('68993c62-8caf-4449-9773-7cf2fb1877f2', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 5, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20260106-528 untuk SD Jomin Barat III dipindahkan ke Tahap Potongan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', '2026-01-06 14:50:10', '2026-01-06 13:11:16', '2026-01-06 14:50:10'),
('699a792d-f709-471d-a99b-f4a5f0dcec1c', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 6, '{\"actions\":[],\"body\":\"Stok Sabrina telah dikurangi 1 Rol.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Cutting Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 07:02:38', '2026-01-01 07:02:38'),
('6a3fc1f3-9b63-4aec-8c72-e26669a50d9b', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 5, '{\"actions\":[],\"body\":\"Stok Sabrina telah dikurangi 2 Rol.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Cutting Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', '2026-01-06 14:50:10', '2026-01-06 13:13:08', '2026-01-06 14:50:10'),
('6ab6a90b-b984-465a-bf83-95cf4f97cd63', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":\"Stok Kain Sutra telah dikurangi 1 Rol.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Cutting Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 04:40:17', '2026-01-01 04:40:17'),
('6b70f041-c3eb-483c-9ef5-ad5222bf4cdd', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Tersisa 0 Rol. Segera isi ulang!\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-exclamation-triangle\",\"iconColor\":\"danger\",\"status\":\"danger\",\"title\":\"\\u26a0\\ufe0f Stok Rendah: Sabrina\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 15:48:36', '2026-01-01 15:48:36'),
('6bba7e7b-4f9c-4bd1-abb4-295abe4be96b', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20260106-528 - SD Jomin Barat III pada Tahap QC\\/Packing Berhasil Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:21:36', '2026-01-06 13:21:36'),
('6e73ea82-3473-4b2b-9d29-89e3bc8c009a', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":\"Stok Sabrina telah dikurangi 2 Rol.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Cutting Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:13:08', '2026-01-06 13:13:08'),
('7052e08d-c236-4e0e-975b-33c0bdc7fa3b', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Pesanan SPK-20251219-839 mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-27 02:47:07', '2025-12-27 02:47:07'),
('70dd0d2f-1a77-4126-90b3-a420f1e636bf', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":\"Pesanan SPK-20251219-839 mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-31 03:31:58', '2025-12-31 03:31:58'),
('71752104-14ae-483a-8c3a-3251c59518b5', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 8, '{\"actions\":[],\"body\":\"Pesanan SPK-20260106-239 - SMK Pusara mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi QC & Packing Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 18:05:03', '2026-01-06 18:05:03'),
('72f93c07-aa66-4803-aca4-bedbb8d38d96', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":\"Pesanan SPK-20251227-439 mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi QC & Packing Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-28 05:35:41', '2025-12-28 05:35:41'),
('733a8dd6-040a-4422-9006-dd8575fa4224', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Stok Sabrina telah dikurangi 2 Rol.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Cutting Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 06:15:57', '2026-01-01 06:15:57'),
('73e35eca-380b-4029-98ca-8e76cffc25dd', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251227-439 - TES pada Tahap Sewing Berhasil Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-30 04:49:55', '2025-12-30 04:49:55'),
('743ba4ef-8856-4f2d-9354-8cfd2b402b39', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Pesanan SPK-20251218-349 mulai di Sewing.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Sewing Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-18 20:41:30', '2025-12-18 20:41:30'),
('7504f8f7-b7af-49b9-8422-4632f171681e', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[{\"name\":\"Lihat\",\"color\":null,\"event\":null,\"eventData\":[],\"dispatchDirection\":false,\"dispatchToComponent\":null,\"extraAttributes\":[],\"icon\":null,\"iconPosition\":\"before\",\"iconSize\":null,\"isOutlined\":false,\"isDisabled\":false,\"label\":\"Lihat\",\"shouldClose\":false,\"shouldMarkAsRead\":false,\"shouldMarkAsUnread\":false,\"shouldOpenUrlInNewTab\":false,\"size\":\"sm\",\"tooltip\":null,\"url\":\"\\/admin\\/orders\\/13\\/edit\",\"view\":\"filament-actions::link-action\"}],\"body\":\"Pesanan SPK-20260106-239 (Seragam Batik) jatuh tempo dalam 3 hari.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-exclamation-circle\",\"iconColor\":\"warning\",\"status\":\"warning\",\"title\":\"Deadline Mendekat (H-3)\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 18:18:05', '2026-01-06 18:18:05'),
('75415621-8089-4e31-be7f-230a5a090dda', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 5, '{\"actions\":[],\"body\":\"Kartu telah diarsipkan dari papan produksi.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251218-381 untuk PPG LDII Jomin Barat Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', '2026-01-06 14:50:10', '2026-01-06 13:10:06', '2026-01-06 14:50:10'),
('756c5a82-49c8-4678-afa6-9d66d774ce64', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 2, '{\"actions\":[],\"body\":\"Stok Sabrina telah dikurangi 2 Rol.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Cutting Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 14:41:05', '2026-01-06 14:41:05'),
('76a9fa42-988c-4882-b249-e7f1bedafc25', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251219-839 - SD Gentra IV  pada Tahap Sewing Berhasil Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-27 04:36:24', '2025-12-27 04:36:24'),
('77a613fd-00bf-4f69-9bc9-f3874a3a0a1e', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 5, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251227-439 - TES pada Tahap QC\\/Packing Berhasil Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', '2026-01-06 14:50:10', '2026-01-05 04:48:13', '2026-01-06 14:50:10'),
('781df127-fbdf-44df-be8e-0096c656c6ef', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 1, '{\"actions\":[],\"body\":\"Tahap Waiting Selesai & Kartu Dipindahkan ke Cutting\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251218-381 - PPG LDII Jomin Barat.\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-19 03:23:19', '2025-12-19 03:23:19'),
('7a076e07-84e9-433c-9d84-da6126e4fd4a', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 6, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20260106-528 untuk SD Jomin Barat III dipindahkan ke Tahap Potongan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:11:16', '2026-01-06 13:11:16'),
('7b3b1859-47ee-40da-aef9-57fe3796eff0', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Pesanan SPK-20251227-439 mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Waiting Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-30 07:11:13', '2025-12-30 07:11:13'),
('7b75f981-7462-4b9f-bc35-d69da1e370ab', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":\"Kartu telah diarsipkan dari papan produksi.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251218-349 untuk PT.Pupuk Kujang Cikampek Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-28 14:47:35', '2025-12-28 14:47:35'),
('7c3a9e36-6ea9-45ed-9c73-be611c774ff3', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 6, '{\"actions\":[],\"body\":\"Pesanan SPK-20251227-439 - TES mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 07:04:18', '2026-01-01 07:04:18'),
('7cb36f4f-bd53-4008-a4d9-92afa6f7ead7', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Kartu telah diarsipkan dari papan produksi.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251219-789 untuk SMK Insan Tazakka Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-26 06:45:08', '2025-12-26 06:45:08'),
('7ebecfc1-2a3b-424a-b60b-961a23540894', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 7, '{\"actions\":[],\"body\":\"Kartu telah diarsipkan dari papan produksi.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20260106-528 untuk SD Jomin Barat III Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:22:32', '2026-01-06 13:22:32'),
('7f6eb45d-3dd6-4d53-9010-fad1bd4ccc55', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Kembali ke tahap awal, melakukan produksi ulang.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-information-circle\",\"iconColor\":\"info\",\"status\":\"info\",\"title\":\"Pesanan SPK-20251218-381 untuk PPG LDII Jomin Barat Diulang\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-27 10:20:07', '2025-12-27 10:20:07'),
('7f869414-11eb-4ed9-98a7-b0f3a77919cc', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":\"Pesanan SPK-20251227-439 mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Waiting Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-30 07:11:13', '2025-12-30 07:11:13'),
('80829350-d508-4b41-a17b-976341df73cb', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Tersisa 0 Rol. Segera isi ulang!\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-exclamation-triangle\",\"iconColor\":\"danger\",\"status\":\"danger\",\"title\":\"\\u26a0\\ufe0f Stok Rendah: Kain Sutra\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-25 19:16:19', '2025-12-25 19:16:19'),
('81eb4e70-4afd-4d8a-85b2-69e25472942f', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Kartu telah diarsipkan dari papan produksi.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251218-349 untuk PT.Pupuk Kujang Cikampek Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-28 14:47:35', '2025-12-28 14:47:35'),
('83e2c8b4-697f-43cd-8377-5b7507a6f6c7', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251227-439 untuk TES dipindahkan ke Tahap Potongan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-30 03:21:08', '2025-12-30 03:21:08'),
('8559f93f-d94e-4c3f-a969-5fb4fddd3051', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":\"Pesanan SPK-20251218-381 mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-29 03:07:22', '2025-12-29 03:07:22'),
('858c666f-42b6-4dee-baf8-46548620e092', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 5, '{\"actions\":[],\"body\":\"Pesanan SPK-20251227-439 - TES mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi QC & Packing Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', '2026-01-06 14:50:10', '2026-01-05 04:46:49', '2026-01-06 14:50:10'),
('85b53149-5901-4d1f-914d-eb5b2ada03c7', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Proses Cutting pesanan SPK-20251226-872 ( SD Sarimulya III ) Selesai, Lanjut ke Penjahitan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-26 06:23:19', '2025-12-26 06:23:19'),
('85fe0841-4c28-484c-a026-a1fa8204baf1', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Stok Dry-FIT (Polyester) telah dikurangi 2 Rol.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Cutting Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-25 08:00:29', '2025-12-25 08:00:29'),
('861462e6-2ea6-4995-b6be-6182c5c85cbf', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 5, '{\"actions\":[],\"body\":\"Kartu telah diarsipkan dari papan produksi.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251227-439 untuk TES Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', '2026-01-06 14:50:10', '2026-01-06 13:08:19', '2026-01-06 14:50:10'),
('86c969e1-a5f7-43d5-8fa7-1692e4d1f164', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 5, '{\"actions\":[],\"body\":\"Kartu telah diarsipkan dari papan produksi.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20260106-528 untuk SD Jomin Barat III Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', '2026-01-06 14:50:10', '2026-01-06 13:22:32', '2026-01-06 14:50:10'),
('89c37107-1bb4-4783-a648-d98b7248359f', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251218-349 untuk PT.Pupuk Kujang Cikampek dipindahkan ke Tahap Potongan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-25 05:00:33', '2025-12-25 05:00:33'),
('8aa343d5-c79b-4aae-9fb3-d8643bd333f8', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 2, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251227-439 - TES pada Tahap QC\\/Packing Berhasil Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-05 04:48:13', '2026-01-05 04:48:13'),
('8b114e36-3208-4daf-81bf-95c6d72f6daf', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 7, '{\"actions\":[],\"body\":\"Kartu telah diarsipkan dari papan produksi.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251218-381 untuk PPG LDII Jomin Barat Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:10:06', '2026-01-06 13:10:06'),
('8c9f4971-1ad3-442e-850e-8408c4a87b2e', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Tahap Sewing Selesai & Kartu Dipindahkan ke QC\\/Packing\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251219-789 - SMK Insan Tazakka.\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-18 21:02:33', '2025-12-18 21:02:33'),
('8d3d361c-e6ac-4eb0-b0bd-1f89c59aad6b', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 7, '{\"actions\":[{\"name\":\"Lihat\",\"color\":null,\"event\":null,\"eventData\":[],\"dispatchDirection\":false,\"dispatchToComponent\":null,\"extraAttributes\":[],\"icon\":null,\"iconPosition\":\"before\",\"iconSize\":null,\"isOutlined\":false,\"isDisabled\":false,\"label\":\"Lihat\",\"shouldClose\":false,\"shouldMarkAsRead\":false,\"shouldMarkAsUnread\":false,\"shouldOpenUrlInNewTab\":false,\"size\":\"sm\",\"tooltip\":null,\"url\":\"\\/admin\\/orders\\/13\\/edit\",\"view\":\"filament-actions::link-action\"}],\"body\":\"Pesanan SPK-20260106-239 (Seragam Batik) jatuh tempo dalam 3 hari.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-exclamation-circle\",\"iconColor\":\"warning\",\"status\":\"warning\",\"title\":\"Deadline Mendekat (H-3)\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-07 03:26:19', '2026-01-07 03:26:19'),
('8dad921f-1802-4ad2-ae93-d287a8b7787a', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 2, '{\"actions\":[{\"name\":\"Lihat\",\"color\":null,\"event\":null,\"eventData\":[],\"dispatchDirection\":false,\"dispatchToComponent\":null,\"extraAttributes\":[],\"icon\":null,\"iconPosition\":\"before\",\"iconSize\":null,\"isOutlined\":false,\"isDisabled\":false,\"label\":\"Lihat\",\"shouldClose\":false,\"shouldMarkAsRead\":false,\"shouldMarkAsUnread\":false,\"shouldOpenUrlInNewTab\":false,\"size\":\"sm\",\"tooltip\":null,\"url\":\"\\/admin\\/orders\\/13\\/edit\",\"view\":\"filament-actions::link-action\"}],\"body\":\"Pesanan SPK-20260106-239 (Seragam Batik) jatuh tempo dalam 3 hari.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-exclamation-circle\",\"iconColor\":\"warning\",\"status\":\"warning\",\"title\":\"Deadline Mendekat (H-3)\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-07 03:26:19', '2026-01-07 03:26:19'),
('8e67b06d-da35-4881-abb1-11d17e8e2313', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20260106-239 untuk SMK Pusara dipindahkan ke Tahap Potongan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 14:38:48', '2026-01-06 14:38:48'),
('8edc12e9-2f7c-4e0a-a45f-60ad73aa83ff', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 2, '{\"actions\":[],\"body\":\"Pesanan SPK-20251227-439 - TES mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-05 04:52:02', '2026-01-05 04:52:02'),
('8ee62171-4d02-4152-a9bd-b652f3baedc0', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 7, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20260106-528 - SD Jomin Barat III pada Tahap QC\\/Packing Berhasil Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:21:36', '2026-01-06 13:21:36'),
('8f1713a9-2dd2-4c62-9822-54eaa582acac', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 6, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Proses Cutting pesanan SPK-20260106-528 ( SD Jomin Barat III ) Selesai, Lanjut ke Penjahitan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:16:04', '2026-01-06 13:16:04'),
('8f2d11aa-695b-4abd-81a1-2e5ca73bde09', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Pesanan SPK-20251219-839 mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-27 02:47:20', '2025-12-27 02:47:20'),
('8fb06952-04ae-4624-b1a3-034f6c5b648e', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 5, '{\"actions\":[],\"body\":\"Kartu telah diarsipkan dari papan produksi.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20260106-239 untuk SMK Pusara Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-07 04:16:11', '2026-01-07 04:16:11'),
('92b15907-c925-40eb-9b43-8c2e7630515e', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251227-439 untuk TES dipindahkan ke Tahap Potongan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 06:12:00', '2026-01-01 06:12:00'),
('9301ef8d-ab58-451a-bc88-ec8d331b492c', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 5, '{\"actions\":[],\"body\":\"Pesanan SPK-20260106-528 - SD Jomin Barat III mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi QC & Packing Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', '2026-01-06 14:50:10', '2026-01-06 13:19:48', '2026-01-06 14:50:10'),
('9577754b-15ab-464d-b3f0-bda48ad30868', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 8, '{\"actions\":[{\"name\":\"Lihat\",\"color\":null,\"event\":null,\"eventData\":[],\"dispatchDirection\":false,\"dispatchToComponent\":null,\"extraAttributes\":[],\"icon\":null,\"iconPosition\":\"before\",\"iconSize\":null,\"isOutlined\":false,\"isDisabled\":false,\"label\":\"Lihat\",\"shouldClose\":false,\"shouldMarkAsRead\":false,\"shouldMarkAsUnread\":false,\"shouldOpenUrlInNewTab\":false,\"size\":\"sm\",\"tooltip\":null,\"url\":\"\\/admin\\/orders\\/13\\/edit\",\"view\":\"filament-actions::link-action\"}],\"body\":\"Pesanan SPK-20260106-239 (Seragam Batik) jatuh tempo dalam 3 hari.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-exclamation-circle\",\"iconColor\":\"warning\",\"status\":\"warning\",\"title\":\"Deadline Mendekat (H-3)\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-07 03:26:19', '2026-01-07 03:26:19'),
('9984a0c5-be39-46fe-9ab7-4f5c924e7b8d', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":\"Pesanan SPK-20260106-528 - SD Jomin Barat III mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:17:15', '2026-01-06 13:17:15'),
('9a7409a2-aefa-4b38-8b5f-d2f0f77a97f0', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 7, '{\"actions\":[],\"body\":\"Pesanan SPK-20260106-528 - SD Jomin Barat III mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:17:15', '2026-01-06 13:17:15'),
('9afc769c-9adc-4a61-b43b-245a0e4ed066', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[{\"name\":\"Lihat\",\"color\":null,\"event\":null,\"eventData\":[],\"dispatchDirection\":false,\"dispatchToComponent\":null,\"extraAttributes\":[],\"icon\":null,\"iconPosition\":\"before\",\"iconSize\":null,\"isOutlined\":false,\"isDisabled\":false,\"label\":\"Lihat\",\"shouldClose\":false,\"shouldMarkAsRead\":false,\"shouldMarkAsUnread\":false,\"shouldOpenUrlInNewTab\":false,\"size\":\"sm\",\"tooltip\":null,\"url\":\"\\/admin\\/orders\\/13\\/edit\",\"view\":\"filament-actions::link-action\"}],\"body\":\"Pesanan SPK-20260106-239 (Seragam Batik) jatuh tempo dalam 3 hari.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-exclamation-circle\",\"iconColor\":\"warning\",\"status\":\"warning\",\"title\":\"Deadline Mendekat (H-3)\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-07 03:26:19', '2026-01-07 03:26:19'),
('9bca31c7-7429-43b9-9bbf-570aec8d0918', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 6, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20260106-528 - SD Jomin Barat III pada Tahap QC\\/Packing Berhasil Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:21:36', '2026-01-06 13:21:36'),
('9bd58d7f-52de-4a2f-802a-ac1b4f316d47', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Tersisa 0 Rol. Segera isi ulang!\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-exclamation-triangle\",\"iconColor\":\"danger\",\"status\":\"danger\",\"title\":\"\\u26a0\\ufe0f Stok Rendah: Dry-FIT (Polyester)\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-23 10:44:48', '2025-12-23 10:44:48'),
('9cd46449-b719-4d35-bc28-e978c59432f5', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Pesanan SPK-20251227-439 - TES mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-05 04:52:02', '2026-01-05 04:52:02'),
('9ee8a364-2f3f-4f1f-8c5e-ed2fa1607c5f', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Tersisa 0 Rol. Segera isi ulang!\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-exclamation-triangle\",\"iconColor\":\"danger\",\"status\":\"danger\",\"title\":\"\\u26a0\\ufe0f Stok Rendah: Kain Sutra\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 15:44:02', '2026-01-01 15:44:02'),
('a00c7018-80f2-4a46-a2ef-591c7a4708d0', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Pesanan SPK-20251219-789 mulai di QC\\/Packing.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi QC\\/Packing Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-19 02:50:34', '2025-12-19 02:50:34'),
('a025a64f-9d8f-47c6-b5ec-d5d2349de281', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 5, '{\"actions\":[],\"body\":\"Pesanan SPK-20251218-381 - PPG LDII Jomin Barat mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi QC & Packing Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', '2026-01-06 14:50:10', '2026-01-05 07:32:53', '2026-01-06 14:50:10'),
('a040fd3e-0330-4e08-a82e-f4c16e46d6c1', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-information-circle\",\"iconColor\":\"info\",\"status\":\"info\",\"title\":\"Berhasil Cicil 5 Pcs di Tahap Sewing\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-30 04:13:28', '2025-12-30 04:13:28');
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('a04ec073-789f-43f2-b274-a9d3c6a0dd5a', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":\"Kembali ke tahap awal, melakukan produksi ulang.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-information-circle\",\"iconColor\":\"info\",\"status\":\"info\",\"title\":\"Pesanan SPK-20251219-839 untuk SD Gentra IV  Diulang\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-30 04:00:01', '2025-12-30 04:00:01'),
('a1e0c2e9-8bc6-4801-99ae-dd9830bf5d0d', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Pesanan SPK-20251219-839 mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-31 03:31:58', '2025-12-31 03:31:58'),
('a20624f3-c94b-4c76-862a-63d8ac6f45a1', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Stok Dry-FIT (Polyester) telah dikurangi 1 Rol.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Cutting Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-30 03:22:23', '2025-12-30 03:22:23'),
('a48b96d9-7fef-4836-b1bd-0526a2a1ed65', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 6, '{\"actions\":[],\"body\":\"Pesanan SPK-20251218-381 mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi QC & Packing Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 03:14:01', '2026-01-01 03:14:01'),
('a65369e4-6377-4aa7-9e7a-a7647770879c', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 5, '{\"actions\":[],\"body\":\"Pesanan SPK-20260106-528 - SD Jomin Barat III mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', '2026-01-06 14:50:10', '2026-01-06 13:17:15', '2026-01-06 14:50:10'),
('a732d485-1a0b-4415-be2c-567f17309a0c', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 5, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251227-439 - TES pada Tahap Sewing Berhasil Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', '2026-01-06 14:50:10', '2026-01-05 04:52:38', '2026-01-06 14:50:10'),
('a7494c94-0fd3-47ab-a0dd-af2338ebfbd3', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 5, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251227-439 - TES pada Tahap Sewing Berhasil Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', '2026-01-06 14:50:10', '2026-01-05 06:29:26', '2026-01-06 14:50:10'),
('a805ee0f-01c0-4332-8b26-48d603cbfa04', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 1, '{\"actions\":[{\"name\":\"Lihat Pesanan\",\"color\":null,\"event\":null,\"eventData\":[],\"dispatchDirection\":false,\"dispatchToComponent\":null,\"extraAttributes\":[],\"icon\":null,\"iconPosition\":\"before\",\"iconSize\":null,\"isOutlined\":false,\"isDisabled\":false,\"label\":\"Lihat pesanan\",\"shouldClose\":false,\"shouldMarkAsRead\":false,\"shouldMarkAsUnread\":false,\"shouldOpenUrlInNewTab\":false,\"size\":\"sm\",\"tooltip\":null,\"url\":\"\\/admin\\/orders\\/11\\/view\",\"view\":\"filament-actions::link-action\"}],\"body\":\"Pesanan SPK-20251227-439 (TES) jatuh tempo dalam 3 hari lagi!\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-exclamation-circle\",\"iconColor\":\"warning\",\"status\":\"warning\",\"title\":\"Peringatan Deadline!\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-02 08:05:07', '2026-01-02 08:05:07'),
('a865efeb-7d6c-4a9e-b0a2-773b98ccaad0', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251227-439 - TES pada Tahap Sewing Berhasil Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-27 19:14:30', '2025-12-27 19:14:30'),
('a9af5800-9a2d-4e6c-aee6-cd7ca8d7ce56', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Tersisa 0 Rol. Segera isi ulang!\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-exclamation-triangle\",\"iconColor\":\"danger\",\"status\":\"danger\",\"title\":\"\\u26a0\\ufe0f Stok Rendah: Sabrina\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-25 05:02:00', '2025-12-25 05:02:00'),
('a9d6b3dd-439c-4865-830d-1a0a70de5b12', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":\"Pesanan SPK-20251219-839 mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi QC & Packing Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-31 03:52:33', '2025-12-31 03:52:33'),
('aa2766aa-3554-4598-8c0c-fe58bb5581bf', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Tersisa 0 Rol. Segera isi ulang!\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-exclamation-triangle\",\"iconColor\":\"danger\",\"status\":\"danger\",\"title\":\"\\u26a0\\ufe0f Stok Rendah: Dry-FIT (Polyester)\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-02 03:43:52', '2026-01-02 03:43:52'),
('aaa8d11c-1683-4ea5-912f-cb1be8d30335', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Kembali ke tahap awal, melakukan produksi ulang.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-information-circle\",\"iconColor\":\"info\",\"status\":\"info\",\"title\":\"Pesanan SPK-20251227-439 untuk TES Diulang\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 06:10:39', '2026-01-01 06:10:39'),
('aaab9de7-04ab-43fe-8575-20260552ddea', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 2, '{\"actions\":[{\"name\":\"Lihat\",\"color\":null,\"event\":null,\"eventData\":[],\"dispatchDirection\":false,\"dispatchToComponent\":null,\"extraAttributes\":[],\"icon\":null,\"iconPosition\":\"before\",\"iconSize\":null,\"isOutlined\":false,\"isDisabled\":false,\"label\":\"Lihat\",\"shouldClose\":false,\"shouldMarkAsRead\":false,\"shouldMarkAsUnread\":false,\"shouldOpenUrlInNewTab\":false,\"size\":\"sm\",\"tooltip\":null,\"url\":\"\\/admin\\/orders\\/13\\/edit\",\"view\":\"filament-actions::link-action\"}],\"body\":\"Pesanan SPK-20260106-239 (Seragam Batik) jatuh tempo dalam 3 hari.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-exclamation-circle\",\"iconColor\":\"warning\",\"status\":\"warning\",\"title\":\"Deadline Mendekat (H-3)\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 18:18:05', '2026-01-06 18:18:05'),
('aad9aa08-d17f-4ad0-9cfc-e3054dc3d61b', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 6, '{\"actions\":[],\"body\":\"Kartu telah diarsipkan dari papan produksi.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251227-439 untuk TES Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:08:19', '2026-01-06 13:08:19'),
('abc789fc-1e5a-49a3-8b5d-25a7ea47856e', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Kembali ke tahap awal, melakukan produksi ulang.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-information-circle\",\"iconColor\":\"info\",\"status\":\"info\",\"title\":\"Pesanan SPK-20251218-381 untuk PPG LDII Jomin Barat Diulang\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-26 06:50:43', '2025-12-26 06:50:43'),
('ace3d3e5-2941-485f-921c-38705e1275d4', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":\"Pesanan SPK-20251227-439 mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-30 03:36:23', '2025-12-30 03:36:23'),
('ad634ac2-78ad-41b6-af8d-c309e690100d', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 2, '{\"actions\":[],\"body\":\"Kartu telah diarsipkan dari papan produksi.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251227-439 untuk TES Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:08:19', '2026-01-06 13:08:19'),
('ae199ec7-1311-4756-baf3-307d88e0002b', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 5, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Proses Cutting pesanan SPK-20260106-528 ( SD Jomin Barat III ) Selesai, Lanjut ke Penjahitan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', '2026-01-06 14:50:10', '2026-01-06 13:16:04', '2026-01-06 14:50:10'),
('ae5d94f6-94ab-44b8-9c90-80267db40ad3', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Kartu telah diarsipkan dari papan produksi.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20260106-239 untuk SMK Pusara Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-07 04:16:11', '2026-01-07 04:16:11'),
('afdbf6a7-7cea-4293-b5bc-bac8880763da', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 2, '{\"actions\":[],\"body\":\"Pesanan SPK-20260106-239 - SMK Pusara mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi QC & Packing Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 18:05:03', '2026-01-06 18:05:03'),
('b0065ffa-096d-4db9-bac3-4cb409b5bc60', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 7, '{\"actions\":[],\"body\":\"Pesanan SPK-20260106-528 - SD Jomin Barat III mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi QC & Packing Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:19:48', '2026-01-06 13:19:48'),
('b045c912-006f-44dd-a7bf-e2ac4353ee6a', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 6, '{\"actions\":[],\"body\":\"Pesanan SPK-20251227-439 - TES mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-05 04:52:02', '2026-01-05 04:52:02'),
('b0ea502d-1961-439f-a75f-5ff2c9b825b8', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Tahap Sewing untuk pesanan SPK-20251218-381 - PPG LDII Jomin Barat Selesai!\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-30 02:46:09', '2025-12-30 02:46:09'),
('b267ab59-73a0-4d83-9c97-e5c3a47c89b8', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":\"Kartu telah diarsipkan dari papan produksi.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251218-381 untuk PPG LDII Jomin Barat Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:10:06', '2026-01-06 13:10:06'),
('b27072e0-3741-4903-820d-b07d30544a2b', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 1, '{\"actions\":[],\"body\":\"Pesanan SPK-20251219-789 mulai di QC\\/Packing.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi QC\\/Packing Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-19 02:50:34', '2025-12-19 02:50:34'),
('b28591ea-65cb-4da7-8575-b4d51ee66095', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251226-872 untuk SD Sarimulya III dipindahkan ke Tahap Potongan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-26 05:48:59', '2025-12-26 05:48:59'),
('b2ae27e7-7fe0-4847-b544-36e4c33f0cf4', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Pesanan SPK-20251219-789 mulai di Sewing.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Sewing Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-18 20:35:26', '2025-12-18 20:35:26'),
('b4d0088e-2b6f-48c8-9519-30da226be48a', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Tersisa 0 Rol. Segera isi ulang!\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-exclamation-triangle\",\"iconColor\":\"danger\",\"status\":\"danger\",\"title\":\"\\u26a0\\ufe0f Stok Rendah: Kain Sutra\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 15:47:22', '2026-01-01 15:47:22'),
('b68d381d-13b9-4174-9f72-0f21526ff899', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Pesanan SPK-20260106-528 - SD Jomin Barat III mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi QC & Packing Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:19:48', '2026-01-06 13:19:48'),
('b7393540-cc39-49de-ac55-d72f8bf596f6', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Pesanan SPK-20251218-381 mulai di Sewing.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Sewing Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-20 03:28:33', '2025-12-20 03:28:33'),
('b7867e19-c34c-4836-8a43-4f43f6f965f7', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Proses Cutting pesanan SPK-20251227-439 ( TES ) Selesai, Lanjut ke Penjahitan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 07:03:27', '2026-01-01 07:03:27'),
('b79792d6-d31b-4e37-b6db-85d4d15f6295', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 6, '{\"actions\":[],\"body\":\"Pesanan SPK-20260106-528 - SD Jomin Barat III mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:17:15', '2026-01-06 13:17:15'),
('b8017812-919b-418d-a155-eaa57f91a088', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Pesanan SPK-20251227-439 mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi QC & Packing Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-28 05:35:41', '2025-12-28 05:35:41'),
('b84a4c97-f79e-4222-99a6-ea8aa778ba03', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Pesanan SPK-20251218-381 mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 03:04:03', '2026-01-01 03:04:03'),
('b9127849-d8a3-42c1-afe2-d08aa12e0d9d', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 7, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20260106-239 untuk SMK Pusara dipindahkan ke Tahap Potongan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 14:38:48', '2026-01-06 14:38:48'),
('b9131ba7-efe8-4d6d-805a-2ff50c85dd95', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 2, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251227-439 - TES pada Tahap Sewing Berhasil Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-05 04:52:38', '2026-01-05 04:52:38'),
('ba2fbc4d-623a-44a2-8f33-49eb7fd45be1', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 2, '{\"actions\":[],\"body\":\"Pesanan SPK-20260106-528 - SD Jomin Barat III mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:17:15', '2026-01-06 13:17:15'),
('bacb38df-334a-48ec-9608-fbb14edcfb0c', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Kartu telah diarsipkan dari papan produksi.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251219-839 untuk SD Gentra IV  Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-31 03:54:53', '2025-12-31 03:54:53'),
('bbeab854-b813-456f-9dfe-b5f6e6da9eb7', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20260106-528 - SD Jomin Barat III pada Tahap QC\\/Packing Berhasil Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:21:36', '2026-01-06 13:21:36'),
('bca470b1-11cb-4cdd-b212-d149f84e47cc', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 6, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251227-439 - TES pada Tahap Sewing Berhasil Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-05 04:52:38', '2026-01-05 04:52:38'),
('bcb9ec8f-d25f-4382-991c-8eb3e03b83e4', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Pesanan SPK-20260106-528 - SD Jomin Barat III mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:17:15', '2026-01-06 13:17:15'),
('bcf9708f-1bc7-464c-930f-02075a81a047', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 6, '{\"actions\":[],\"body\":\"Pesanan SPK-20251227-439 - TES mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi QC & Packing Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-05 04:46:49', '2026-01-05 04:46:49'),
('bd413a26-0e05-4372-b8cd-33f60c96f50b', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 6, '{\"actions\":[],\"body\":\"Stok Kain Sutra telah dikurangi 1 Rol.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Cutting Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 04:40:17', '2026-01-01 04:40:17'),
('bd723387-3a8b-4bdb-8a33-e97c9ac1c7a2', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 1, '{\"actions\":[],\"body\":\"Pesanan SPK-20251218-349 mulai di Sewing.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Sewing Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-18 20:41:30', '2025-12-18 20:41:30'),
('be48b344-1b54-4069-8b82-0c1a67dcd330', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Stok Kain Sutra telah dikurangi 1 Rol.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Cutting Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-25 19:29:26', '2025-12-25 19:29:26'),
('beee1590-5ca7-48ac-97cf-c885642d7e00', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Tahap Sewing untuk pesanan SPK-20251218-381 - PPG LDII Jomin Barat Selesai!\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-30 02:46:09', '2025-12-30 02:46:09'),
('bf25cbae-89e1-4794-ae05-31f931dd4f1a', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Pesanan SPK-20251226-872 mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit untuk SD Sarimulya III Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-26 06:30:11', '2025-12-26 06:30:11'),
('bf6681e0-3dd7-4df5-98f7-39f69b16599a', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 7, '{\"actions\":[],\"body\":\"Stok Sabrina telah dikurangi 2 Rol.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Cutting Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:13:08', '2026-01-06 13:13:08'),
('c0f6664d-2e3e-4f71-b242-6d18eb3b3e09', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Pesanan SPK-20251227-439 - TES mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi QC & Packing Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 06:46:10', '2026-01-01 06:46:10'),
('c1a8d965-69a2-4b27-8e78-8c279dd60bcf', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":\"Pesanan SPK-20251218-381 mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 03:04:03', '2026-01-01 03:04:03'),
('c2253b84-ab7e-487f-94bb-2dcda45f674b', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251227-439 - TES pada Tahap Sewing Berhasil Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-30 04:49:55', '2025-12-30 04:49:55'),
('c2a0ddc7-6e98-43f5-b452-719aa86469bd', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Stok Sabrina telah dikurangi 1 Rol.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Cutting Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-25 05:02:00', '2025-12-25 05:02:00'),
('c2b4aa1a-93fd-4884-9eee-c484a116920f', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 2, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251227-439 - TES pada Tahap Sewing Berhasil Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-05 06:29:26', '2026-01-05 06:29:26'),
('c3280bc1-cae9-4c1e-b51c-c9933afeeaa6', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Pesanan SPK-20251219-839 mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi QC & Packing Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-27 19:13:48', '2025-12-27 19:13:48'),
('c408a3d8-eeef-464e-ab63-1b0373259af3', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Cutting Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-18 20:19:52', '2025-12-18 20:19:52'),
('c4c05d7f-8587-4835-b1d9-d1554a1a1c7e', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Kembali ke tahap awal, melakukan produksi ulang.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-information-circle\",\"iconColor\":\"info\",\"status\":\"info\",\"title\":\"Pesanan SPK-20251219-839 untuk SD Gentra IV  Diulang\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-30 04:00:01', '2025-12-30 04:00:01'),
('c65ac437-d376-42bf-9ce3-21a547e4db87', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251219-839 - SD Gentra IV  pada Tahap Sewing Berhasil Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-31 03:35:47', '2025-12-31 03:35:47'),
('c6fa3883-e050-4fa0-b8d1-6e7c7f9503ae', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 2, '{\"actions\":[],\"body\":\"Pesanan SPK-20251227-439 - TES mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-05 05:23:05', '2026-01-05 05:23:05'),
('c71d54b3-4ca9-441b-ba50-635c2bf0e5d3', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":\"Kembali ke tahap awal, melakukan produksi ulang.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-information-circle\",\"iconColor\":\"info\",\"status\":\"info\",\"title\":\"Pesanan SPK-20251218-381 untuk PPG LDII Jomin Barat Diulang\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-31 03:44:18', '2025-12-31 03:44:18'),
('c8467341-c30b-49dc-b8bb-c450ca1a4ba8', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Pesanan SPK-20251227-439 mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-27 18:43:47', '2025-12-27 18:43:47'),
('c937623c-5ad3-4404-b9c8-0992ab919cd3', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-information-circle\",\"iconColor\":\"info\",\"status\":\"info\",\"title\":\"Berhasil Cicil 5 Pcs di Tahap Sewing\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-30 04:13:28', '2025-12-30 04:13:28'),
('caa2b0d3-c207-48cd-ba4f-5a849bbb74e0', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":\"Pesanan SPK-20251227-439 - TES mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi QC & Packing Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-05 04:46:49', '2026-01-05 04:46:49'),
('cae91928-bf12-4e2e-9c7a-976c3761c947', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 6, '{\"actions\":[],\"body\":\"Kembali ke tahap awal, melakukan produksi ulang.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-information-circle\",\"iconColor\":\"info\",\"status\":\"info\",\"title\":\"Pesanan SPK-20251227-439 untuk TES Diulang\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 06:10:39', '2026-01-01 06:10:39'),
('caea307d-7b84-4271-b70d-495aa3ddc38f', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 8, '{\"actions\":[],\"body\":\"Pesanan SPK-20260106-239 - SMK Pusara mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 14:47:27', '2026-01-06 14:47:27'),
('cb062e96-1c45-4abf-97db-9b127400c008', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251227-439 - TES pada Tahap Sewing Berhasil Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-05 04:52:38', '2026-01-05 04:52:38'),
('cb06e7d9-0540-43c4-b441-49a8eed1f64f', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Proses Cutting pesanan SPK-20260106-528 ( SD Jomin Barat III ) Selesai, Lanjut ke Penjahitan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:16:04', '2026-01-06 13:16:04'),
('cb38cefc-8d9e-4804-b03c-bbbe5b1bd98e', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":\"Kartu telah diarsipkan dari papan produksi.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20260106-239 untuk SMK Pusara Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-07 04:16:11', '2026-01-07 04:16:11'),
('cbfb0268-9a8d-4c1b-8606-bdadd48f5503', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 1, '{\"actions\":[],\"body\":\"Tahap Sewing Selesai & Kartu Dipindahkan ke QC\\/Packing\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251219-789 - SMK Insan Tazakka.\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-18 21:02:33', '2025-12-18 21:02:33'),
('cc2645b9-9e45-4603-adef-aa681ac680be', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251227-439 - TES pada Tahap Cutting Berhasil Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-30 03:26:18', '2025-12-30 03:26:18'),
('ccdcee46-48b4-4fa8-81cf-8e85ee47fe89', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":\"Kembali ke tahap awal, melakukan produksi ulang.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-information-circle\",\"iconColor\":\"info\",\"status\":\"info\",\"title\":\"Pesanan SPK-20251227-439 untuk TES Diulang\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 06:10:39', '2026-01-01 06:10:39'),
('cde5a394-14ae-42b4-a1ce-cbd3bc8c081f', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 5, '{\"actions\":[],\"body\":\"Pesanan SPK-20251227-439 - TES mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', '2026-01-06 14:50:10', '2026-01-05 05:23:05', '2026-01-06 14:50:10'),
('cdf548b0-c0a8-4ce1-bb3f-9e3dd862603c', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Kembali ke tahap awal, melakukan produksi ulang.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-information-circle\",\"iconColor\":\"info\",\"status\":\"info\",\"title\":\"Pesanan SPK-20251218-381 untuk PPG LDII Jomin Barat Diulang\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-31 03:44:18', '2025-12-31 03:44:18'),
('cebfac2c-ac69-4c91-b135-b831822cd3a9', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Pesanan SPK-20251227-439 mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-27 18:44:29', '2025-12-27 18:44:29'),
('cf828211-2cd6-4393-830a-0d4752854962', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 5, '{\"actions\":[],\"body\":\"Pesanan SPK-20260106-239 - SMK Pusara mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi QC & Packing Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 18:05:03', '2026-01-06 18:05:03'),
('cfafc9f5-5331-4f01-8173-aa63ea5a32b2', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251227-439 untuk TES dipindahkan ke Tahap Potongan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 07:01:15', '2026-01-01 07:01:15'),
('cff36601-d207-4779-823e-8d0b0fe89683', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Proses Cutting pesanan SPK-20251227-439 ( TES ) Selesai, Lanjut ke Penjahitan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 06:24:24', '2026-01-01 06:24:24'),
('d0561744-b3bd-459f-a9e1-498864f9c00e', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 1, '{\"actions\":[],\"body\":\"Pesanan SPK-20251218-381 mulai di Sewing.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Sewing Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-20 03:28:33', '2025-12-20 03:28:33'),
('d13b2af0-561f-4504-b147-f119018d0882', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Proses Cutting pesanan SPK-20251227-439 ( TES ) Selesai, Lanjut ke Penjahitan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 06:24:24', '2026-01-01 06:24:24'),
('d1e623df-9216-47e0-a69d-dd83bc583517', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 2, '{\"actions\":[],\"body\":\"Pesanan SPK-20260106-528 - SD Jomin Barat III mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi QC & Packing Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:19:48', '2026-01-06 13:19:48'),
('d23cd39a-b8ab-4d37-9a2e-267016c0a498', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 2, '{\"actions\":[],\"body\":\"Pesanan SPK-20251218-381 - PPG LDII Jomin Barat mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi QC & Packing Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-05 07:32:53', '2026-01-05 07:32:53'),
('d3a74d70-41c3-4c49-b591-84736d2f4f96', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 1, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Cutting Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-18 20:19:52', '2025-12-18 20:19:52'),
('d4382f9e-ebf6-44a2-8649-764e4312ba7e', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20260106-528 untuk SD Jomin Barat III dipindahkan ke Tahap Potongan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:11:16', '2026-01-06 13:11:16'),
('d4a9fdf5-0ab4-42ea-9ed1-1582c49bdd56', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Pesanan SPK-20260106-239 - SMK Pusara mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi QC & Packing Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 18:05:03', '2026-01-06 18:05:03'),
('d4ae275f-b0eb-4a03-9ccc-b6a17bd06a94', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 5, '{\"actions\":[{\"name\":\"Lihat\",\"color\":null,\"event\":null,\"eventData\":[],\"dispatchDirection\":false,\"dispatchToComponent\":null,\"extraAttributes\":[],\"icon\":null,\"iconPosition\":\"before\",\"iconSize\":null,\"isOutlined\":false,\"isDisabled\":false,\"label\":\"Lihat\",\"shouldClose\":false,\"shouldMarkAsRead\":false,\"shouldMarkAsUnread\":false,\"shouldOpenUrlInNewTab\":false,\"size\":\"sm\",\"tooltip\":null,\"url\":\"\\/admin\\/orders\\/13\\/edit\",\"view\":\"filament-actions::link-action\"}],\"body\":\"Pesanan SPK-20260106-239 (Seragam Batik) jatuh tempo dalam 3 hari.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-exclamation-circle\",\"iconColor\":\"warning\",\"status\":\"warning\",\"title\":\"Deadline Mendekat (H-3)\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 18:18:05', '2026-01-06 18:18:05'),
('d551f804-878b-491c-8cf9-733415858401', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Tersisa 0 Rol. Segera isi ulang!\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-exclamation-triangle\",\"iconColor\":\"danger\",\"status\":\"danger\",\"title\":\"\\u26a0\\ufe0f Stok Rendah: Kain Sutra\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 15:07:04', '2026-01-01 15:07:04'),
('d57f5bc6-6faa-47fc-a397-397d6d88988d', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 1, '{\"actions\":[{\"name\":\"Lihat Pesanan\",\"color\":null,\"event\":null,\"eventData\":[],\"dispatchDirection\":false,\"dispatchToComponent\":null,\"extraAttributes\":[],\"icon\":null,\"iconPosition\":\"before\",\"iconSize\":null,\"isOutlined\":false,\"isDisabled\":false,\"label\":\"Lihat pesanan\",\"shouldClose\":false,\"shouldMarkAsRead\":false,\"shouldMarkAsUnread\":false,\"shouldOpenUrlInNewTab\":false,\"size\":\"sm\",\"tooltip\":null,\"url\":\"\\/admin\\/orders\\/11\\/view\",\"view\":\"filament-actions::link-action\"}],\"body\":\"Pesanan SPK-20251227-439 (TES) jatuh tempo dalam 3 hari lagi!\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-exclamation-circle\",\"iconColor\":\"warning\",\"status\":\"warning\",\"title\":\"Peringatan Deadline!\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-04 12:46:32', '2026-01-04 12:46:32'),
('d83d6c19-5b64-49d6-8441-4300c2db115a', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Tahap Waiting Selesai & Kartu Dipindahkan ke Cutting\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251218-381 - PPG LDII Jomin Barat.\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-19 03:32:11', '2025-12-19 03:32:11'),
('d8c8d0e5-4571-4de9-8584-358c2d9d4b16', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 6, '{\"actions\":[],\"body\":\"Pesanan SPK-20251218-381 mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 03:04:03', '2026-01-01 03:04:03'),
('db5debf3-fd64-4bfa-80a3-9920982fa104', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-information-circle\",\"iconColor\":\"info\",\"status\":\"info\",\"title\":\"Berhasil Cicil 20 Pcs untuk pesanan SPK-20251218-381 oleh Haris\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-29 04:52:47', '2025-12-29 04:52:47'),
('dc6d48d9-00d3-441b-90c4-0738d3e6096f', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":\"Pesanan SPK-20260106-239 - SMK Pusara mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi QC & Packing Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 18:05:03', '2026-01-06 18:05:03'),
('dc7a64c1-fb9d-496e-b896-253f6bb020fb', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 6, '{\"actions\":[{\"name\":\"Lihat Pesanan\",\"color\":null,\"event\":null,\"eventData\":[],\"dispatchDirection\":false,\"dispatchToComponent\":null,\"extraAttributes\":[],\"icon\":null,\"iconPosition\":\"before\",\"iconSize\":null,\"isOutlined\":false,\"isDisabled\":false,\"label\":\"Lihat pesanan\",\"shouldClose\":false,\"shouldMarkAsRead\":false,\"shouldMarkAsUnread\":false,\"shouldOpenUrlInNewTab\":false,\"size\":\"sm\",\"tooltip\":null,\"url\":\"\\/admin\\/orders\\/11\\/view\",\"view\":\"filament-actions::link-action\"}],\"body\":\"Pesanan SPK-20251227-439 (TES) jatuh tempo dalam 3 hari lagi!\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-exclamation-circle\",\"iconColor\":\"warning\",\"status\":\"warning\",\"title\":\"Peringatan Deadline!\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-04 12:46:32', '2026-01-04 12:46:32');
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('de1c0863-c5ed-49c9-9733-9184d22f4e10', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[{\"name\":\"Lihat Pesanan\",\"color\":null,\"event\":null,\"eventData\":[],\"dispatchDirection\":false,\"dispatchToComponent\":null,\"extraAttributes\":[],\"icon\":null,\"iconPosition\":\"before\",\"iconSize\":null,\"isOutlined\":false,\"isDisabled\":false,\"label\":\"Lihat pesanan\",\"shouldClose\":false,\"shouldMarkAsRead\":false,\"shouldMarkAsUnread\":false,\"shouldOpenUrlInNewTab\":false,\"size\":\"sm\",\"tooltip\":null,\"url\":\"\\/admin\\/orders\\/11\\/view\",\"view\":\"filament-actions::link-action\"}],\"body\":\"Pesanan SPK-20251227-439 (TES) jatuh tempo dalam 3 hari lagi!\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-exclamation-circle\",\"iconColor\":\"warning\",\"status\":\"warning\",\"title\":\"Peringatan Deadline!\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-02 08:05:07', '2026-01-02 08:05:07'),
('de3251f3-b17c-454f-9afe-be52f3fde23c', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[{\"name\":\"Lihat Pesanan\",\"color\":null,\"event\":null,\"eventData\":[],\"dispatchDirection\":false,\"dispatchToComponent\":null,\"extraAttributes\":[],\"icon\":null,\"iconPosition\":\"before\",\"iconSize\":null,\"isOutlined\":false,\"isDisabled\":false,\"label\":\"Lihat pesanan\",\"shouldClose\":false,\"shouldMarkAsRead\":false,\"shouldMarkAsUnread\":false,\"shouldOpenUrlInNewTab\":false,\"size\":\"sm\",\"tooltip\":null,\"url\":\"\\/admin\\/orders\\/11\\/view\",\"view\":\"filament-actions::link-action\"}],\"body\":\"Pesanan SPK-20251227-439 (TES) jatuh tempo dalam 3 hari lagi!\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-exclamation-circle\",\"iconColor\":\"warning\",\"status\":\"warning\",\"title\":\"Peringatan Deadline!\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-04 12:47:45', '2026-01-04 12:47:45'),
('df0dbf6f-aa1b-4741-b64d-1648c26cde67', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":\"Stok Dry-FIT (Polyester) telah dikurangi 1 Rol.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Cutting Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-30 03:22:23', '2025-12-30 03:22:23'),
('e340d50d-69c7-4162-9241-604eeab28cff', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 2, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20260106-528 untuk SD Jomin Barat III dipindahkan ke Tahap Potongan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:11:16', '2026-01-06 13:11:16'),
('e40e12c8-7b6d-4533-8ca1-bf84b00cda3f', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":\"Kartu telah diarsipkan dari papan produksi.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251227-439 untuk TES Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:08:19', '2026-01-06 13:08:19'),
('e444969a-c449-4222-abd3-350ce9942dbb', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[{\"name\":\"Lihat Pesanan\",\"color\":null,\"event\":null,\"eventData\":[],\"dispatchDirection\":false,\"dispatchToComponent\":null,\"extraAttributes\":[],\"icon\":null,\"iconPosition\":\"before\",\"iconSize\":null,\"isOutlined\":false,\"isDisabled\":false,\"label\":\"Lihat pesanan\",\"shouldClose\":false,\"shouldMarkAsRead\":false,\"shouldMarkAsUnread\":false,\"shouldOpenUrlInNewTab\":false,\"size\":\"sm\",\"tooltip\":null,\"url\":\"\\/admin\\/orders\\/11\\/view\",\"view\":\"filament-actions::link-action\"}],\"body\":\"Pesanan SPK-20251227-439 (TES) jatuh tempo dalam 3 hari lagi!\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-exclamation-circle\",\"iconColor\":\"warning\",\"status\":\"warning\",\"title\":\"Peringatan Deadline!\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-04 12:47:45', '2026-01-04 12:47:45'),
('e4b9fcde-084a-4500-b314-97656288b188', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 1, '{\"actions\":[],\"body\":\"Tahap Cutting Selesai & Kartu Dipindahkan ke Sewing\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251218-381 - PPG LDII Jomin Barat.\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-19 03:58:56', '2025-12-19 03:58:56'),
('e6771b47-05f2-4e30-9812-557a2562afab', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Stok Kain Sutra telah dikurangi 1 Rol.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Cutting Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 04:40:17', '2026-01-01 04:40:17'),
('e91a1090-f36b-4f85-8e2a-97adcada736b', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 2, '{\"actions\":[],\"body\":\"Kartu telah diarsipkan dari papan produksi.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20260106-239 untuk SMK Pusara Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-07 04:16:11', '2026-01-07 04:16:11'),
('e93f7309-1db5-4e91-ae2e-a0f4b78bfb53', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":\"Pesanan SPK-20251218-381 mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi QC & Packing Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 03:14:00', '2026-01-01 03:14:00'),
('ea513080-8953-4c67-9ab7-9948063a06fe', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":\"Kartu telah diarsipkan dari papan produksi.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251219-839 untuk SD Gentra IV  Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-31 03:54:53', '2025-12-31 03:54:53'),
('eb6343d1-d61d-487a-aba3-905c65521ea8', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-information-circle\",\"iconColor\":\"info\",\"status\":\"info\",\"title\":\"Berhasil Cicil 10 Pcs untuk pesanan SPK-20251218-381 oleh Herman\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-30 02:43:19', '2025-12-30 02:43:19'),
('ecd0b517-c02e-4387-9e61-dd01e30ee46e', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20260106-528 untuk SD Jomin Barat III dipindahkan ke Tahap Potongan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:11:16', '2026-01-06 13:11:16'),
('ed40359d-77fa-4662-9520-e14a9e4b99a8', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-information-circle\",\"iconColor\":\"info\",\"status\":\"info\",\"title\":\"Berhasil Cicil 20 Pcs untuk pesanan SPK-20251218-381 oleh Haris\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-29 04:52:47', '2025-12-29 04:52:47'),
('ed44d759-f5c4-48fe-b2fe-bbcca3b949ca', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-information-circle\",\"iconColor\":\"info\",\"status\":\"info\",\"title\":\"Berhasil Cicil 11 Pcs untuk pesanan SPK-20251219-839 oleh Sulis\\/Andri\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-28 17:09:59', '2025-12-28 17:09:59'),
('ee68d5f6-a770-43a3-b341-e9c4690eecbc', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 6, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Proses Cutting pesanan SPK-20251227-439 ( TES ) Selesai, Lanjut ke Penjahitan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 06:24:25', '2026-01-01 06:24:25'),
('ef7bf7e2-d64b-4761-b502-9343978a1c7b', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Kembali ke tahap awal, melakukan produksi ulang.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-information-circle\",\"iconColor\":\"info\",\"status\":\"info\",\"title\":\"Pesanan SPK-20251227-439 untuk TES Diulang\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-30 04:51:14', '2025-12-30 04:51:14'),
('f0d445a0-8348-47de-ab80-758ff38b290c', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":\"Kembali ke tahap awal, melakukan produksi ulang.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-information-circle\",\"iconColor\":\"info\",\"status\":\"info\",\"title\":\"Pesanan SPK-20251227-439 untuk TES Diulang\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 06:50:49', '2026-01-01 06:50:49'),
('f0f5bb5a-0fc8-4acf-aaa4-d98280a38487', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":\"Pesanan SPK-20251218-381 - PPG LDII Jomin Barat mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi QC & Packing Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-05 07:32:53', '2026-01-05 07:32:53'),
('f1d5bc79-d7f7-475a-9204-9fd90e2c5f73', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251227-439 untuk TES dipindahkan ke Tahap Potongan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 07:01:15', '2026-01-01 07:01:15'),
('f2034229-e4e5-43d1-b923-a1e65404e8b5', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 6, '{\"actions\":[],\"body\":\"Stok Sabrina telah dikurangi 2 Rol.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Cutting Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 06:15:57', '2026-01-01 06:15:57'),
('f27d85f2-de2f-4dc2-9130-3ec6efc6e56a', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 6, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251227-439 untuk TES dipindahkan ke Tahap Potongan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 07:01:15', '2026-01-01 07:01:15'),
('f429f311-587c-4188-8ebc-b4c5abc30fd3', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Kartu telah diarsipkan dari papan produksi.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251226-872 untuk SD Sarimulya III Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-26 06:49:28', '2025-12-26 06:49:28'),
('f475823a-6f5c-40b2-87e6-39c181c596b8', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 7, '{\"actions\":[],\"body\":\"Pesanan SPK-20260106-239 - SMK Pusara mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi QC & Packing Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 18:05:03', '2026-01-06 18:05:03'),
('f4892a67-5669-4454-b2ff-172f4f8c98a7', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 2, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Proses Cutting pesanan SPK-20260106-528 ( SD Jomin Barat III ) Selesai, Lanjut ke Penjahitan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:16:04', '2026-01-06 13:16:04'),
('f522f540-949a-48d9-b953-c0bfe4b592da', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 6, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251227-439 untuk TES dipindahkan ke Tahap Potongan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 06:12:00', '2026-01-01 06:12:00'),
('f664bfbc-b57e-480a-a161-3d7b57924dfd', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 6, '{\"actions\":[],\"body\":\"Pesanan SPK-20251218-381 - PPG LDII Jomin Barat mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi QC & Packing Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-05 07:32:53', '2026-01-05 07:32:53'),
('f762adb7-0e8b-4862-9d33-f418acbd5065', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":\"Pesanan SPK-20251227-439 - TES mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-05 04:52:02', '2026-01-05 04:52:02'),
('f8816044-b41b-4047-90ee-a072205518a1', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Proses Cutting pesanan SPK-20251218-349 ( PT.Pupuk Kujang Cikampek ) Selesai, Lanjut ke Penjahitan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-25 05:15:21', '2025-12-25 05:15:21'),
('f898fd21-db3b-4790-89e8-43ccbdf7d873', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[],\"body\":\"Pesanan SPK-20251227-439 - TES mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 07:04:18', '2026-01-01 07:04:18'),
('f8d1e361-2d63-45c3-9f55-3fb1e91171a1', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 6, '{\"actions\":[],\"body\":\"Pesanan SPK-20251227-439 - TES mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 06:26:21', '2026-01-01 06:26:21'),
('f8e6ab84-f67a-4938-820e-85a18774fe25', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Pesanan SPK-20251227-439 - TES mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-05 05:23:05', '2026-01-05 05:23:05'),
('f9388b33-adfd-447b-9b11-566b86d38473', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 7, '{\"actions\":[{\"name\":\"Lihat\",\"color\":null,\"event\":null,\"eventData\":[],\"dispatchDirection\":false,\"dispatchToComponent\":null,\"extraAttributes\":[],\"icon\":null,\"iconPosition\":\"before\",\"iconSize\":null,\"isOutlined\":false,\"isDisabled\":false,\"label\":\"Lihat\",\"shouldClose\":false,\"shouldMarkAsRead\":false,\"shouldMarkAsUnread\":false,\"shouldOpenUrlInNewTab\":false,\"size\":\"sm\",\"tooltip\":null,\"url\":\"\\/admin\\/orders\\/13\\/edit\",\"view\":\"filament-actions::link-action\"}],\"body\":\"Pesanan SPK-20260106-239 (Seragam Batik) jatuh tempo dalam 3 hari.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-exclamation-circle\",\"iconColor\":\"warning\",\"status\":\"warning\",\"title\":\"Deadline Mendekat (H-3)\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 18:18:05', '2026-01-06 18:18:05'),
('f9a2a933-2349-4514-af57-b1b6a6d05efb', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Kartu telah diarsipkan dari papan produksi.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251219-928 untuk SMk 1 Purwakarta Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-25 19:04:36', '2025-12-25 19:04:36'),
('f9c32ebb-623d-4aa6-9640-1e9eb568c79a', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Tersisa 2 Rol. Segera isi ulang!\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-exclamation-triangle\",\"iconColor\":\"danger\",\"status\":\"danger\",\"title\":\"\\u26a0\\ufe0f Stok Rendah: Kain Sutra\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2025-12-20 09:38:36', '2025-12-20 09:38:36'),
('fa46fb23-6d1a-4288-894c-e4f5c2128b93', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 6, '{\"actions\":[],\"body\":\"Pesanan SPK-20260106-528 - SD Jomin Barat III mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi QC & Packing Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:19:48', '2026-01-06 13:19:48'),
('fad0c326-8e89-4846-943a-1e24e614f455', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 2, '{\"actions\":[],\"body\":\"Kartu telah diarsipkan dari papan produksi.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20251218-381 untuk PPG LDII Jomin Barat Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:10:06', '2026-01-06 13:10:06'),
('fb0dd61c-ae93-4003-b1cd-50998b35f509', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Proses Cutting pesanan SPK-20251227-439 ( TES ) Selesai, Lanjut ke Penjahitan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-01 07:03:27', '2026-01-01 07:03:27'),
('fbcb76e6-cdd4-40d9-bdec-2733aca8177e', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 6, '{\"actions\":[],\"body\":\"Kartu telah diarsipkan dari papan produksi.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20260106-528 untuk SD Jomin Barat III Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:22:32', '2026-01-06 13:22:32'),
('fcb94525-4ea7-4527-8299-9fff4a26da59', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 3, '{\"actions\":[],\"body\":\"Stok Sabrina telah dikurangi 2 Rol.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Cutting Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 14:41:05', '2026-01-06 14:41:05'),
('fd23a985-9560-4736-b659-a4d724b42455', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 5, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20260106-239 untuk SMK Pusara dipindahkan ke Tahap Potongan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', '2026-01-06 14:50:10', '2026-01-06 14:38:48', '2026-01-06 14:50:10'),
('fd8d656b-9217-4d4f-a61e-1afd27e991fc', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 8, '{\"actions\":[],\"body\":\"Kartu telah diarsipkan dari papan produksi.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20260106-239 untuk SMK Pusara Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-07 04:16:11', '2026-01-07 04:16:11'),
('fdca2157-4c89-4402-a739-fcddbac12ef2', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 5, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20260106-528 - SD Jomin Barat III pada Tahap QC\\/Packing Berhasil Diselesaikan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', '2026-01-06 14:50:10', '2026-01-06 13:21:36', '2026-01-06 14:50:10'),
('fe336085-7e85-4312-91ff-277353d6bea0', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 6, '{\"actions\":[],\"body\":null,\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Pesanan SPK-20260106-239 untuk SMK Pusara dipindahkan ke Tahap Potongan\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 14:38:48', '2026-01-06 14:38:48'),
('fe50d985-edb7-4684-a83a-218977a81787', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 6, '{\"actions\":[],\"body\":\"Stok Sabrina telah dikurangi 2 Rol.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Cutting Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', NULL, '2026-01-06 13:13:08', '2026-01-06 13:13:08'),
('ffbfcabf-1d5b-463c-a54c-dbda74f099c7', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 5, '{\"actions\":[],\"body\":\"Pesanan SPK-20260106-239 - SMK Pusara mulai dikerjakan.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Produksi Jahit Dimulai\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', '2026-01-06 14:50:10', '2026-01-06 14:47:27', '2026-01-06 14:50:10');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `order_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `agency_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `deadline` date NOT NULL,
  `status` enum('Waiting','Cutting','Sewing','QC/Packing','Done') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Waiting',
  `is_completed` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `agency_name`, `client_name`, `phone`, `product_name`, `quantity`, `deadline`, `status`, `is_completed`, `created_at`, `updated_at`) VALUES
(1, 'SPK-20251218-349', 'PT.Pupuk Kujang Cikampek', 'Yuda', '081234567890', 'Seragam Kerja ', 50, '2025-12-31', 'Done', 1, '2025-12-17 17:40:17', '2025-12-28 14:47:25'),
(2, 'SPK-20251218-381', 'PPG LDII Jomin Barat', 'Denny', '081234567888', 'Seragam Caberawit', 70, '2025-12-30', 'Done', 1, '2025-12-18 11:19:22', '2026-01-06 13:10:06'),
(3, 'SPK-20251218-518', 'TK Tadika Mesra', 'Upin Ipin', '081233564888', 'Baju Olahraga', 15, '2026-01-02', 'Done', 1, '2025-12-18 16:57:18', '2025-12-26 06:47:54'),
(4, 'SPK-20251219-839', 'SD Gentra IV ', 'Ehsan', '081234567888', 'Seragam Batik', 33, '2025-12-27', 'Done', 1, '2025-12-18 17:16:45', '2025-12-31 03:54:53'),
(5, 'SPK-20251219-789', 'SMK Insan Tazakka', 'Herce', '081233567990', 'Kaos Tour 2026', 50, '2025-12-29', 'Done', 1, '2025-12-18 17:20:29', '2025-12-26 06:45:07'),
(6, 'SPK-20251219-928', 'SMk 1 Purwakarta', 'Andri', '081234567890', 'Baju Olahraga', 30, '2026-01-01', 'Done', 1, '2025-12-19 03:18:42', '2025-12-25 19:04:36'),
(7, 'SPK-20251222-749', 'Genciko FC', 'Devano', '088212925132', 'Jersey Genciko', 35, '2026-01-10', 'Done', 1, '2025-12-22 12:40:10', '2025-12-25 03:59:59'),
(9, 'SPK-20251223-154', 'Spartan FC', 'Ferdi', '081234567890', 'Jersey Spartan', 30, '2025-12-31', 'Done', 1, '2025-12-23 14:04:30', '2025-12-25 04:02:05'),
(10, 'SPK-20251226-872', 'SD Sarimulya III', 'Reyvan', '08812345789', 'Seragam BAtik Khas', 60, '2026-01-31', 'Done', 1, '2025-12-26 05:36:41', '2025-12-26 06:49:28'),
(11, 'SPK-20251227-439', 'TES', 'TES', '00000000', 'TES', 10, '2026-01-04', 'Done', 1, '2025-12-27 04:46:37', '2026-01-06 13:08:14'),
(12, 'SPK-20260106-528', 'SD Jomin Barat III', 'Asep', '081234567890', 'Seragam Olahraga', 30, '2026-01-23', 'Done', 1, '2026-01-06 13:05:52', '2026-01-13 09:15:02'),
(13, 'SPK-20260106-239', 'SMK Pusara', 'Fadlan', '081234567890', 'Seragam Batik', 20, '2026-01-10', 'Done', 1, '2026-01-06 14:01:44', '2026-01-13 09:15:37'),
(14, 'SPK-20260110-117', 'PT.Changsin Indonesia', 'Amelia', '081234567890', 'Seragam Tour', 100, '2026-01-31', 'Cutting', 0, '2026-01-10 13:21:52', '2026-01-13 09:08:17'),
(15, 'SPK-20260111-776', 'PT CSTI', 'Fitri', '081234567890', 'Hoodie', 50, '2026-01-30', 'QC/Packing', 0, '2026-01-10 23:09:47', '2026-01-10 23:42:03');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `production_logs`
--

CREATE TABLE `production_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `employee_id` bigint UNSIGNED NOT NULL,
  `stage` enum('Waiting','Cutting','Sewing','QC/Packing','Done') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Mulai','Sedang Diproses','Selesai') COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `output_qty` int NOT NULL DEFAULT '0',
  `reject_qty` int DEFAULT '0',
  `timestamp` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `production_logs`
--

INSERT INTO `production_logs` (`id`, `order_id`, `employee_id`, `stage`, `status`, `notes`, `output_qty`, `reject_qty`, `timestamp`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 'Cutting', 'Selesai', '', 15, 0, '2025-12-18 17:32:21', '2025-12-18 17:32:21', '2025-12-18 17:32:21'),
(2, 3, 1, 'Cutting', 'Selesai', '', 15, 0, '2025-12-18 17:32:21', '2025-12-18 17:32:21', '2025-12-18 17:32:21'),
(3, 3, 1, 'Sewing', 'Selesai', '', 15, 0, '2025-12-18 19:07:38', '2025-12-18 19:07:38', '2025-12-18 19:07:38'),
(4, 3, 1, 'Sewing', 'Selesai', '', 50, 0, '2025-12-18 19:07:38', '2025-12-18 19:07:38', '2025-12-18 19:07:38'),
(5, 5, 1, 'Sewing', 'Selesai', '', 50, 0, '2025-12-18 19:40:36', '2025-12-18 19:40:36', '2025-12-18 20:10:58'),
(6, 5, 1, 'Cutting', 'Selesai', '', 50, 0, '2025-12-18 19:40:49', '2025-12-18 19:40:49', '2025-12-18 20:10:51'),
(7, 3, 1, 'QC/Packing', 'Selesai', NULL, 15, NULL, '2025-12-18 20:02:03', '2025-12-18 20:02:03', '2025-12-20 04:02:38'),
(9, 5, 1, 'Cutting', 'Selesai', '', 50, 0, '2025-12-18 20:11:43', '2025-12-18 20:11:43', '2025-12-18 20:20:32'),
(10, 5, 1, 'Cutting', 'Selesai', '', 50, 0, '2025-12-18 20:11:54', '2025-12-18 20:11:54', '2025-12-18 20:20:32'),
(12, 5, 1, 'Sewing', 'Selesai', '', 50, 0, '2025-12-18 20:35:26', '2025-12-18 20:35:26', '2025-12-18 21:02:33'),
(13, 1, 1, 'Sewing', 'Sedang Diproses', '', 0, 0, '2025-12-18 20:41:29', '2025-12-18 20:41:29', '2025-12-18 20:41:29'),
(15, 1, 1, 'Cutting', 'Selesai', '', 50, 0, '2025-12-19 02:42:23', '2025-12-19 02:42:23', '2025-12-19 03:34:25'),
(16, 3, 1, 'Sewing', 'Selesai', 'Lanjut ke QC', 15, NULL, '2025-12-19 02:42:23', '2025-12-19 02:42:23', '2025-12-20 03:59:53'),
(17, 5, 1, 'QC/Packing', 'Selesai', 'Semua ssiap dikirim', 70, 0, '2025-12-19 02:50:34', '2025-12-19 02:50:34', '2025-12-20 03:47:28'),
(18, 6, 1, 'Cutting', 'Selesai', 'Size XL 15 Pcs\nSize L 15 Pcs', 30, NULL, '2025-12-19 03:19:59', '2025-12-19 03:19:59', '2025-12-19 15:13:42'),
(20, 1, 1, 'Sewing', 'Selesai', '', 50, 0, '2025-12-19 13:53:18', '2025-12-19 13:53:18', '2025-12-19 13:53:18'),
(21, 1, 1, 'Sewing', 'Selesai', '', 0, 0, '2025-12-19 13:55:17', '2025-12-19 13:55:17', '2025-12-19 13:55:17'),
(22, 1, 1, 'Cutting', 'Selesai', '', 0, 0, '2025-12-19 14:05:12', '2025-12-19 14:05:12', '2025-12-19 14:05:12'),
(24, 1, 1, 'Cutting', 'Selesai', NULL, 0, 0, '2025-12-20 04:06:14', '2025-12-20 04:06:14', '2025-12-20 04:06:14'),
(25, 1, 1, 'Cutting', 'Selesai', NULL, 0, 0, '2025-12-20 04:10:19', '2025-12-20 04:10:19', '2025-12-20 04:10:19'),
(27, 1, 1, 'Cutting', 'Selesai', 'Detail Size: [{\"size\":\"L\",\"qty\":\"25\"},{\"size\":\"XL\",\"qty\":\"10\"}]', 35, 0, '2025-12-20 04:52:07', '2025-12-20 04:52:07', '2025-12-20 05:03:01'),
(28, 1, 1, 'Cutting', 'Selesai', NULL, 0, 0, '2025-12-20 05:06:32', '2025-12-20 05:06:32', '2025-12-20 05:06:32'),
(29, 1, 1, 'Cutting', 'Selesai', NULL, 0, 0, '2025-12-20 05:23:37', '2025-12-20 05:23:37', '2025-12-20 05:23:37'),
(30, 6, 1, 'Cutting', 'Selesai', 'Detail Size: [{\"size\":\"L\",\"qty\":\"30\"}]', 30, 0, '2025-12-20 05:24:36', '2025-12-20 05:24:36', '2025-12-20 17:58:21'),
(32, 1, 1, 'Cutting', 'Selesai', 'Detail Size: [{\"size\":\"L\",\"qty\":\"30\"},{\"size\":\"XL\",\"qty\":\"15\"},{\"size\":\"XXL\",\"qty\":\"5\"}]', 50, 0, '2025-12-20 17:42:15', '2025-12-20 17:42:15', '2025-12-20 17:48:35'),
(35, 1, 1, 'Waiting', 'Sedang Diproses', NULL, 0, 0, '2025-12-21 07:46:53', '2025-12-21 07:46:53', '2025-12-21 07:46:53'),
(37, 6, 1, 'Sewing', 'Selesai', NULL, 30, NULL, '2025-12-24 04:36:22', '2025-12-21 10:54:40', '2025-12-24 04:36:22'),
(38, 1, 1, 'Cutting', 'Selesai', 'Detail Size: [{\"size\":\"M\",\"qty\":\"25\"},{\"size\":\"L\",\"qty\":\"25\"}]', 50, 0, '2025-12-21 11:04:24', '2025-12-21 11:04:24', '2025-12-22 04:04:00'),
(40, 6, 1, 'Cutting', 'Mulai', NULL, 0, 0, '2025-12-21 11:20:46', '2025-12-21 11:20:46', '2025-12-21 11:20:46'),
(43, 6, 1, 'Sewing', 'Selesai', NULL, 30, NULL, '2025-12-24 04:36:22', '2025-12-21 11:21:15', '2025-12-24 04:36:22'),
(44, 6, 1, 'Sewing', 'Selesai', NULL, 30, NULL, '2025-12-24 04:36:22', '2025-12-21 11:21:22', '2025-12-24 04:36:22'),
(45, 6, 1, 'Cutting', 'Mulai', NULL, 0, 0, '2025-12-21 11:22:14', '2025-12-21 11:22:14', '2025-12-21 11:22:14'),
(46, 6, 1, 'Sewing', 'Selesai', NULL, 30, NULL, '2025-12-24 04:36:22', '2025-12-21 11:22:21', '2025-12-24 04:36:22'),
(47, 1, 1, 'QC/Packing', 'Selesai', NULL, 50, NULL, '2025-12-23 10:35:26', '2025-12-22 04:05:00', '2025-12-23 10:35:26'),
(48, 1, 1, 'QC/Packing', 'Selesai', NULL, 50, NULL, '2025-12-23 10:35:26', '2025-12-22 04:05:07', '2025-12-23 10:35:26'),
(49, 6, 1, 'Cutting', 'Mulai', 'Dipindahkan via Kanban', 0, 0, '2025-12-22 04:05:17', '2025-12-22 04:05:17', '2025-12-22 04:05:17'),
(50, 5, 1, 'QC/Packing', 'Selesai', NULL, 50, NULL, '2025-12-23 15:22:59', '2025-12-22 04:05:41', '2025-12-23 15:22:59'),
(54, 7, 1, 'Waiting', 'Selesai', NULL, 0, 0, '2025-12-22 16:08:51', '2025-12-22 16:08:51', '2025-12-22 16:08:51'),
(55, 7, 1, 'Cutting', 'Selesai', 'Detail Size: [{\"size\":\"M\",\"qty\":\"7\"},{\"size\":\"L\",\"qty\":\"13\"},{\"size\":\"XL\",\"qty\":\"8\"},{\"size\":\"XXL\",\"qty\":\"2\"},{\"size\":\"S\",\"qty\":\"5\"}]', 35, 0, '2025-12-23 02:33:43', '2025-12-23 02:33:43', '2025-12-23 02:42:07'),
(56, 7, 1, 'Sewing', 'Sedang Diproses', NULL, 0, 0, '2025-12-23 02:43:09', '2025-12-23 02:43:09', '2025-12-23 02:43:09'),
(57, 7, 1, 'QC/Packing', 'Sedang Diproses', NULL, 0, 0, '2025-12-23 02:57:18', '2025-12-23 02:57:18', '2025-12-23 02:57:18'),
(58, 1, 1, 'QC/Packing', 'Selesai', NULL, 50, NULL, '2025-12-23 10:35:26', '2025-12-23 10:28:02', '2025-12-23 10:35:26'),
(64, 9, 1, 'Waiting', 'Selesai', NULL, 0, 0, '2025-12-23 14:29:33', '2025-12-23 14:29:33', '2025-12-23 14:29:33'),
(65, 9, 1, 'Cutting', 'Selesai', '\"Model: Jersey Custom | Bahan: Dry-FIT (Polyester) | Warna: Putih | Penggunaan: 3 Rol (30 Meter) | SIZES_DATA:[{\\\"size\\\":\\\"L\\\",\\\"qty\\\":\\\"10\\\"},{\\\"size\\\":\\\"XL\\\",\\\"qty\\\":\\\"10\\\"},{\\\"size\\\":\\\"M\\\",\\\"qty\\\":\\\"10\\\"}]\"', 30, 0, '2025-12-23 14:31:06', '2025-12-23 14:31:06', '2025-12-23 14:46:53'),
(66, 9, 1, 'Sewing', 'Selesai', 'Lanjut ke tahap QC dan Packing', 30, NULL, '2025-12-23 15:03:45', '2025-12-23 14:46:54', '2025-12-23 15:03:45'),
(67, 6, 1, 'Cutting', 'Selesai', '\"Model: Jersey Custom | Bahan: Sabrina | Warna: Maroon | Penggunaan: 2 Rol (20 Meter) | SIZES_DATA:[{\\\"size\\\":\\\"M\\\",\\\"qty\\\":\\\"10\\\"},{\\\"size\\\":\\\"L\\\",\\\"qty\\\":\\\"10\\\"},{\\\"size\\\":\\\"XL\\\",\\\"qty\\\":\\\"10\\\"}]\"', 30, 0, '2025-12-23 14:51:29', '2025-12-23 14:51:29', '2025-12-23 15:01:58'),
(68, 6, 1, 'Sewing', 'Selesai', NULL, 30, NULL, '2025-12-24 04:36:22', '2025-12-23 15:01:58', '2025-12-24 04:36:22'),
(69, 5, 1, 'Cutting', 'Mulai', '\"Dipindahkan via Kanban\"', 0, 0, '2025-12-23 15:03:12', '2025-12-23 15:03:12', '2025-12-23 15:03:12'),
(70, 5, 1, 'Cutting', 'Mulai', '\"Dipindahkan via Kanban\"', 0, 0, '2025-12-23 15:03:21', '2025-12-23 15:03:21', '2025-12-23 15:03:21'),
(71, 9, 1, 'QC/Packing', 'Selesai', 'Siap dikirimkan', 30, NULL, '2025-12-23 15:08:59', '2025-12-23 15:03:46', '2025-12-23 15:08:59'),
(72, 5, 1, 'Cutting', 'Selesai', '\"Model: Seragam | Bahan: Sabrina | Warna: Maroon | Penggunaan: 2 Rol (20 Meter) | SIZES_DATA:[{\\\"size\\\":\\\"L\\\",\\\"qty\\\":\\\"15\\\"},{\\\"size\\\":\\\"XL\\\",\\\"qty\\\":\\\"15\\\"}]\"', 30, 0, '2025-12-23 15:05:25', '2025-12-23 15:05:25', '2025-12-23 15:12:35'),
(73, 5, 1, 'Sewing', 'Selesai', NULL, 30, NULL, '2025-12-23 15:19:56', '2025-12-23 15:12:35', '2025-12-23 15:19:56'),
(74, 5, 1, 'Sewing', 'Selesai', NULL, 30, NULL, '2025-12-23 15:19:56', '2025-12-23 15:19:18', '2025-12-23 15:19:56'),
(75, 5, 1, 'QC/Packing', 'Selesai', NULL, 50, NULL, '2025-12-23 15:22:59', '2025-12-23 15:19:56', '2025-12-23 15:22:59'),
(76, 5, 1, 'QC/Packing', 'Selesai', NULL, 50, NULL, '2025-12-23 15:22:59', '2025-12-23 15:21:17', '2025-12-23 15:22:59'),
(77, 5, 1, 'QC/Packing', 'Selesai', NULL, 50, NULL, '2025-12-23 15:22:59', '2025-12-23 15:21:17', '2025-12-23 15:22:59'),
(78, 6, 1, 'Cutting', 'Selesai', NULL, 0, 0, '2025-12-23 15:39:59', '2025-12-23 15:39:59', '2025-12-23 15:39:59'),
(79, 6, 1, 'Cutting', 'Sedang Diproses', '\"Model: Seragam | Bahan: Dry-FIT (Polyester) | Warna: Putih | Penggunaan: 3 Rol (30 Meter)\"', 0, 0, '2025-12-23 15:44:43', '2025-12-23 15:44:43', '2025-12-23 15:44:43'),
(80, 6, 1, 'Sewing', 'Selesai', NULL, 30, NULL, '2025-12-24 04:36:22', '2025-12-24 03:43:19', '2025-12-24 04:36:22'),
(81, 6, 1, 'QC/Packing', 'Selesai', NULL, 30, NULL, '2025-12-24 04:45:18', '2025-12-24 04:36:22', '2025-12-24 04:45:18'),
(82, 6, 1, 'QC/Packing', 'Selesai', NULL, 30, NULL, '2025-12-24 04:45:18', '2025-12-24 04:38:22', '2025-12-24 04:45:18'),
(89, 1, 2, 'Waiting', 'Mulai', '\"Pesanan diulang (Repeat Order).\"', 0, 0, '2025-12-25 03:15:32', '2025-12-25 03:15:32', '2025-12-25 03:15:32'),
(90, 1, 1, 'Waiting', 'Selesai', NULL, 0, 0, '2025-12-25 05:00:29', '2025-12-25 05:00:29', '2025-12-25 05:00:29'),
(91, 1, 1, 'Cutting', 'Selesai', '\"Model: Seragam | Bahan: Sabrina | Warna: Maroon | Penggunaan: 1 Rol (10 Meter) | SIZES_DATA:[{\\\"size\\\":\\\"S\\\",\\\"qty\\\":\\\"10\\\"},{\\\"size\\\":\\\"M\\\",\\\"qty\\\":\\\"10\\\"},{\\\"size\\\":\\\"L\\\",\\\"qty\\\":\\\"20\\\"},{\\\"size\\\":\\\"XL\\\",\\\"qty\\\":\\\"10\\\"}]\"', 50, 0, '2025-12-25 05:02:00', '2025-12-25 05:02:00', '2025-12-25 05:15:20'),
(92, 1, 1, 'Sewing', 'Mulai', NULL, 0, 0, '2025-12-25 05:15:21', '2025-12-25 05:15:21', '2025-12-25 05:15:21'),
(97, 1, 1, 'Done', 'Mulai', '\"Dipindahkan via Kanban\"', 0, 0, '2025-12-25 15:13:44', '2025-12-25 15:13:44', '2025-12-25 15:13:44'),
(98, 5, 1, 'Done', 'Mulai', '\"Dipindahkan via Kanban\"', 0, 0, '2025-12-25 15:17:41', '2025-12-25 15:17:41', '2025-12-25 15:17:41'),
(101, 1, 2, 'Waiting', 'Mulai', '\"Pesanan diulang (Repeat Order).\"', 0, 0, '2025-12-25 19:01:08', '2025-12-25 19:01:08', '2025-12-25 19:01:08'),
(102, 1, 1, 'Waiting', 'Selesai', NULL, 0, 0, '2025-12-25 19:05:09', '2025-12-25 19:05:09', '2025-12-25 19:05:09'),
(103, 1, 1, 'Cutting', 'Sedang Diproses', '\"Model: Seragam | Bahan: Kain Sutra | Warna: Pink | Penggunaan: 1 Rol (70 Meter)\"', 0, 0, '2025-12-25 19:29:26', '2025-12-25 19:29:26', '2025-12-25 19:29:26'),
(104, 10, 1, 'Waiting', 'Selesai', NULL, 0, 0, '2025-12-26 05:48:59', '2025-12-26 05:48:59', '2025-12-26 05:48:59'),
(105, 10, 1, 'Cutting', 'Selesai', '\"Model: Kemeja | Bahan: Sabrina | Warna: Navy | Penggunaan: 2 Rol (80 Yard) | SIZES_DATA:[{\\\"size\\\":\\\"S\\\",\\\"qty\\\":\\\"015\\\"},{\\\"size\\\":\\\"M\\\",\\\"qty\\\":\\\"015\\\"},{\\\"size\\\":\\\"L\\\",\\\"qty\\\":\\\"015\\\"},{\\\"size\\\":\\\"XL\\\",\\\"qty\\\":\\\"015\\\"}]\"', 60, 0, '2025-12-26 05:58:15', '2025-12-26 05:58:15', '2025-12-26 06:23:19'),
(106, 10, 1, 'Sewing', 'Selesai', 'Lanjut Packing', 60, NULL, '2025-12-26 06:41:11', '2025-12-26 06:23:19', '2025-12-26 06:41:11'),
(107, 10, 1, 'Sewing', 'Selesai', 'Lanjut Packing', 60, NULL, '2025-12-26 06:41:11', '2025-12-26 06:28:14', '2025-12-26 06:41:11'),
(108, 10, 1, 'Sewing', 'Selesai', 'Lanjut Packing', 60, NULL, '2025-12-26 06:41:11', '2025-12-26 06:30:11', '2025-12-26 06:41:11'),
(109, 10, 1, 'QC/Packing', 'Selesai', NULL, 60, NULL, '2025-12-26 06:46:14', '2025-12-26 06:41:11', '2025-12-26 06:46:14'),
(110, 10, 1, 'QC/Packing', 'Selesai', NULL, 60, NULL, '2025-12-26 06:46:14', '2025-12-26 06:41:25', '2025-12-26 06:46:14'),
(113, 1, 1, 'Sewing', 'Mulai', '\"Dipindahkan via Kanban\"', 0, 0, '2025-12-26 17:57:26', '2025-12-26 17:57:26', '2025-12-26 17:57:26'),
(114, 1, 1, 'Cutting', 'Mulai', '\"Dipindahkan via Kanban\"', 0, 0, '2025-12-26 17:58:05', '2025-12-26 17:58:05', '2025-12-26 17:58:05'),
(118, 1, 1, 'Sewing', 'Mulai', '\"Dipindahkan via Kanban\"', 0, 0, '2025-12-27 02:47:26', '2025-12-27 02:47:26', '2025-12-27 02:47:26'),
(120, 1, 1, 'Sewing', 'Mulai', '\"Dipindahkan via Kanban\"', 0, 0, '2025-12-27 04:36:44', '2025-12-27 04:36:44', '2025-12-27 04:36:44'),
(123, 1, 1, 'Done', 'Mulai', '\"Dipindahkan via Kanban\"', 0, 0, '2025-12-27 10:22:36', '2025-12-27 10:22:36', '2025-12-27 10:22:36'),
(138, 4, 1, 'Waiting', 'Mulai', '\"Pesanan diulang (Repeat Order). Riwayat sebelumnya telah dibersihkan.\"', 0, 0, '2025-12-30 04:00:01', '2025-12-30 04:00:01', '2025-12-30 04:00:01'),
(146, 4, 1, 'Sewing', 'Selesai', NULL, 33, NULL, '2025-12-31 03:35:47', '2025-12-30 08:22:31', '2025-12-31 03:35:47'),
(149, 4, 1, 'Sewing', 'Selesai', NULL, 33, NULL, '2025-12-31 03:35:47', '2025-12-31 03:31:58', '2025-12-31 03:35:47'),
(150, 4, 1, 'QC/Packing', 'Selesai', NULL, 33, NULL, '2025-12-31 03:53:22', '2025-12-31 03:35:47', '2025-12-31 03:53:22'),
(155, 4, 2, 'QC/Packing', 'Selesai', NULL, 33, NULL, '2025-12-31 03:53:22', '2025-12-31 03:52:33', '2025-12-31 03:53:22'),
(173, 11, 1, 'Waiting', 'Selesai', NULL, 0, 0, '2026-01-01 07:01:15', '2026-01-01 07:01:15', '2026-01-01 07:01:15'),
(174, 11, 1, 'Cutting', 'Selesai', '\"Model: TEESSS | Bahan: Sabrina | Warna: Navy | Panjang: 80 yard | Penggunaan: 1 Rol | SIZES_DATA:[{\\\"size\\\":\\\"S\\\",\\\"qty\\\":\\\"5\\\"},{\\\"size\\\":\\\"M\\\",\\\"qty\\\":\\\"5\\\"}]\"', 10, 0, '2026-01-01 07:02:37', '2026-01-01 07:02:37', '2026-01-01 07:03:27'),
(175, 11, 4, 'Sewing', 'Selesai', NULL, 10, 0, '2026-01-01 07:06:17', '2026-01-01 07:03:27', '2026-01-01 07:06:17'),
(176, 11, 4, 'Sewing', 'Selesai', NULL, 10, 0, '2026-01-01 07:06:17', '2026-01-01 07:04:18', '2026-01-01 07:06:17'),
(177, 11, 4, 'Sewing', 'Selesai', NULL, 11, NULL, '2026-01-05 04:52:38', '2026-01-04 05:11:03', '2026-01-05 04:52:38'),
(178, 11, 1, 'QC/Packing', 'Selesai', NULL, 11, NULL, '2026-01-05 04:48:13', '2026-01-05 04:10:26', '2026-01-05 04:48:13'),
(179, 11, 1, 'QC/Packing', 'Selesai', NULL, 11, NULL, '2026-01-05 04:48:13', '2026-01-05 04:46:48', '2026-01-05 04:48:13'),
(180, 11, 1, 'Sewing', 'Selesai', NULL, 11, NULL, '2026-01-05 04:52:38', '2026-01-05 04:51:02', '2026-01-05 04:52:38'),
(181, 11, 1, 'Sewing', 'Selesai', NULL, 11, NULL, '2026-01-05 04:52:38', '2026-01-05 04:52:02', '2026-01-05 04:52:38'),
(184, 11, 1, 'Sewing', 'Selesai', NULL, 9, 1, '2026-01-05 06:29:26', '2026-01-05 05:23:05', '2026-01-05 06:29:26'),
(204, 11, 1, 'Done', 'Mulai', '\"Dipindahkan via Kanban\"', 0, 0, '2026-01-05 17:40:18', '2026-01-05 17:40:18', '2026-01-05 17:40:18'),
(205, 2, 1, 'Done', 'Mulai', '\"Dipindahkan via Kanban\"', 0, 0, '2026-01-06 13:08:35', '2026-01-06 13:08:35', '2026-01-06 13:08:35'),
(206, 12, 1, 'Waiting', 'Selesai', NULL, 0, 0, '2026-01-06 13:11:16', '2026-01-06 13:11:16', '2026-01-06 13:11:16'),
(207, 12, 1, 'Cutting', 'Selesai', '\"Model: Seragam Olahraga | Bahan: Sabrina | Warna: Maroon | Panjang: 30 yard | Penggunaan: 2 Rol | SIZES_DATA:[{\\\"size\\\":\\\"S\\\",\\\"qty\\\":\\\"5\\\"},{\\\"size\\\":\\\"M\\\",\\\"qty\\\":\\\"5\\\"},{\\\"size\\\":\\\"L\\\",\\\"qty\\\":\\\"10\\\"},{\\\"size\\\":\\\"XL\\\",\\\"qty\\\":\\\"5\\\"},{\\\"size\\\":\\\"XXL\\\",\\\"qty\\\":\\\"5\\\"}]\"', 30, 0, '2026-01-06 13:13:07', '2026-01-06 13:13:07', '2026-01-06 13:16:04'),
(208, 12, 1, 'Sewing', 'Selesai', NULL, 30, 0, '2026-01-06 13:19:25', '2026-01-06 13:16:04', '2026-01-06 13:19:25'),
(209, 12, 1, 'Sewing', 'Selesai', NULL, 30, 0, '2026-01-06 13:19:25', '2026-01-06 13:17:14', '2026-01-06 13:19:25'),
(210, 12, 1, 'QC/Packing', 'Selesai', NULL, 30, 0, '2026-01-06 13:21:35', '2026-01-06 13:19:48', '2026-01-06 13:21:35'),
(211, 13, 1, 'Waiting', 'Selesai', NULL, 0, 0, '2026-01-06 14:38:47', '2026-01-06 14:38:47', '2026-01-06 14:38:47'),
(213, 13, 4, 'Sewing', 'Selesai', '\"Dipindahkan via Kanban\"', 20, 0, '2026-01-06 14:49:16', '2026-01-06 14:46:02', '2026-01-06 14:49:16'),
(214, 13, 4, 'Sewing', 'Selesai', NULL, 20, 0, '2026-01-06 14:49:16', '2026-01-06 14:47:27', '2026-01-06 14:49:16'),
(215, 13, 1, 'QC/Packing', 'Selesai', NULL, 20, 0, '2026-01-07 04:14:58', '2026-01-06 18:05:02', '2026-01-07 04:14:58'),
(216, 14, 1, 'Waiting', 'Selesai', NULL, 0, 0, '2026-01-10 13:23:02', '2026-01-10 13:23:02', '2026-01-10 13:23:02'),
(217, 14, 1, 'Cutting', 'Selesai', '\"Model: Tshirt Tour | Bahan: Kain Polyester | Warna: Merah | Panjang: 10 yard | Penggunaan: 2 Rol | SIZES_DATA:[{\\\"size\\\":\\\"S\\\",\\\"qty\\\":\\\"25\\\"},{\\\"size\\\":\\\"M\\\",\\\"qty\\\":\\\"25\\\"},{\\\"size\\\":\\\"L\\\",\\\"qty\\\":\\\"25\\\"},{\\\"size\\\":\\\"XL\\\",\\\"qty\\\":\\\"25\\\"}]\"', 100, 0, '2026-01-10 13:26:14', '2026-01-10 13:26:14', '2026-01-10 13:29:13'),
(218, 14, 1, 'Sewing', 'Selesai', NULL, 100, 0, '2026-01-10 13:36:33', '2026-01-10 13:29:13', '2026-01-10 13:36:33'),
(219, 14, 1, 'Sewing', 'Selesai', NULL, 100, 0, '2026-01-10 13:36:33', '2026-01-10 13:29:45', '2026-01-10 13:36:33'),
(220, 14, 1, 'QC/Packing', 'Selesai', NULL, 100, 0, '2026-01-10 15:19:35', '2026-01-10 14:39:15', '2026-01-10 15:19:35'),
(221, 15, 1, 'Waiting', 'Selesai', NULL, 0, 0, '2026-01-10 23:24:39', '2026-01-10 23:24:39', '2026-01-10 23:24:39'),
(222, 15, 1, 'Cutting', 'Selesai', '\"Model: Hoodie | Bahan: Kain Polyester | Warna: Merah | Panjang: 10 yard | Penggunaan: 2 Rol | SIZES_DATA:[{\\\"size\\\":\\\"S\\\",\\\"qty\\\":\\\"10\\\"},{\\\"size\\\":\\\"M\\\",\\\"qty\\\":\\\"10\\\"},{\\\"size\\\":\\\"L\\\",\\\"qty\\\":\\\"17\\\"},{\\\"size\\\":\\\"XL\\\",\\\"qty\\\":\\\"13\\\"}]\"', 50, 0, '2026-01-10 23:29:22', '2026-01-10 23:29:22', '2026-01-10 23:30:19'),
(223, 15, 1, 'Sewing', 'Selesai', NULL, 50, 0, '2026-01-10 23:42:03', '2026-01-10 23:30:19', '2026-01-10 23:42:03'),
(224, 15, 1, 'Sewing', 'Selesai', NULL, 50, 0, '2026-01-10 23:42:03', '2026-01-10 23:30:49', '2026-01-10 23:42:03'),
(225, 14, 1, 'Waiting', 'Selesai', NULL, 0, 0, '2026-01-13 09:08:17', '2026-01-13 09:08:17', '2026-01-13 09:08:17'),
(226, 15, 1, 'QC/Packing', 'Sedang Diproses', NULL, 0, 0, '2026-01-13 09:16:53', '2026-01-13 09:16:53', '2026-01-13 09:16:53');

-- --------------------------------------------------------

--
-- Table structure for table `production_outputs`
--

CREATE TABLE `production_outputs` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `employee_id` bigint UNSIGNED NOT NULL,
  `stage` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `production_outputs`
--

INSERT INTO `production_outputs` (`id`, `order_id`, `employee_id`, `stage`, `qty`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 4, 1, 'Sewing', 11, 'Done', NULL, '2025-12-28 16:02:46', '2025-12-28 16:02:46'),
(2, 4, 1, 'Sewing', 11, 'Done', NULL, '2025-12-28 16:52:33', '2025-12-28 16:52:33'),
(4, 4, 1, 'Sewing', 11, 'Done', NULL, '2025-12-28 17:04:10', '2025-12-28 17:04:10'),
(5, 4, 1, 'QC/Packing', 11, 'Done', NULL, '2025-12-28 17:05:14', '2025-12-28 17:05:14'),
(6, 4, 1, 'QC/Packing', 11, 'Done', NULL, '2025-12-28 17:09:59', '2025-12-28 17:09:59'),
(15, 2, 5, 'Sewing', 40, 'Done', NULL, '2026-01-01 03:05:32', '2026-01-01 03:05:32'),
(16, 2, 5, 'Sewing', 10, 'Done', NULL, '2026-01-01 03:08:30', '2026-01-01 03:08:30'),
(17, 2, 5, 'Sewing', 20, 'Done', NULL, '2026-01-01 03:11:36', '2026-01-01 03:11:36'),
(18, 2, 2, 'QC/Packing', 30, 'Done', NULL, '2026-01-01 03:14:39', '2026-01-01 03:14:39'),
(19, 2, 2, 'QC/Packing', 40, 'Done', NULL, '2026-01-01 04:40:57', '2026-01-01 04:40:57'),
(24, 11, 4, 'Sewing', 5, 'Done', NULL, '2026-01-01 07:05:10', '2026-01-01 07:05:10'),
(25, 11, 4, 'Sewing', 5, 'Done', NULL, '2026-01-01 07:06:17', '2026-01-01 07:06:17'),
(26, 12, 1, 'Sewing', 10, 'Done', NULL, '2026-01-06 13:18:15', '2026-01-06 13:18:15'),
(27, 12, 1, 'Sewing', 20, 'Done', NULL, '2026-01-06 13:19:24', '2026-01-06 13:19:24'),
(28, 12, 1, 'QC/Packing', 15, 'Done', NULL, '2026-01-06 13:20:42', '2026-01-06 13:20:42'),
(29, 13, 4, 'Sewing', 10, 'Done', NULL, '2026-01-06 14:48:24', '2026-01-06 14:48:24'),
(30, 13, 4, 'Sewing', 10, 'Done', NULL, '2026-01-06 14:49:16', '2026-01-06 14:49:16'),
(31, 13, 1, 'QC/Packing', 20, 'Done', NULL, '2026-01-07 04:14:57', '2026-01-07 04:14:57'),
(32, 14, 1, 'Sewing', 25, 'Done', NULL, '2026-01-10 13:30:35', '2026-01-10 13:30:35'),
(33, 14, 1, 'Sewing', 25, 'Done', NULL, '2026-01-10 13:31:15', '2026-01-10 13:31:15'),
(34, 14, 1, 'Sewing', 50, 'Done', NULL, '2026-01-10 13:36:33', '2026-01-10 13:36:33'),
(35, 14, 1, 'QC/Packing', 50, 'Done', NULL, '2026-01-10 15:18:49', '2026-01-10 15:18:49'),
(36, 14, 1, 'QC/Packing', 50, 'Done', NULL, '2026-01-10 15:19:35', '2026-01-10 15:19:35'),
(37, 15, 1, 'Sewing', 20, 'Done', NULL, '2026-01-10 23:40:40', '2026-01-10 23:40:40'),
(38, 15, 1, 'Sewing', 10, 'Done', NULL, '2026-01-10 23:41:12', '2026-01-10 23:41:12'),
(39, 15, 1, 'Sewing', 20, 'Done', NULL, '2026-01-10 23:42:03', '2026-01-10 23:42:03');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Owner', 'web', '2025-12-17 17:36:37', '2025-12-17 17:36:37'),
(2, 'Admin', 'web', '2025-12-17 17:36:37', '2025-12-17 17:36:37'),
(3, 'Cutting', 'web', '2025-12-17 17:36:37', '2025-12-17 17:36:37'),
(4, 'Tailor', 'web', '2025-12-17 17:36:37', '2025-12-17 17:36:37'),
(5, 'QC/Packing', 'web', '2025-12-17 17:36:37', '2025-12-17 17:36:37');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_rates`
--

CREATE TABLE `role_rates` (
  `id` bigint UNSIGNED NOT NULL,
  `role_name` enum('Owner','Admin','Cutting','Tailor','QC/Packing') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate_per_pcs` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_rates`
--

INSERT INTO `role_rates` (`id`, `role_name`, `rate_per_pcs`, `created_at`, `updated_at`) VALUES
(1, 'Tailor', 10000.00, '2026-01-02 17:11:56', '2026-01-02 17:21:35'),
(2, 'Owner', 15000.00, '2026-01-02 17:56:14', '2026-01-02 17:56:14'),
(3, 'Cutting', 12000.00, '2026-01-06 14:12:32', '2026-01-06 14:12:32');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('ABcQhSeSbAi83NeF5JbdlJT1FeXNmeM5034T4pXY', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicFNLYms1YTJUYXU5RjVsdENyTW9HU2U2SUQwZmdZMjNRNEM3RDFWdyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9sb2dpbiI7czo1OiJyb3V0ZSI7czoyNToiZmlsYW1lbnQuYWRtaW4uYXV0aC5sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1767884680),
('chBfzAAWMnG9OLN3cfXTk8DEU4815MIvnySJfFss', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaUtUY29nYUNkZTV4aEl5UWI1N1ZBUHNQY1M3aGJIRDZkRWZxemE3bSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo1MzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL3N0YXRpc3Rpay1raW5lcmphLXBlZ2F3YWkiO31zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czozMzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL2xvZ2luIjtzOjU6InJvdXRlIjtzOjI1OiJmaWxhbWVudC5hZG1pbi5hdXRoLmxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1767884695),
('wxHJYiqxCCq9jesfBBVP8GlYgBkeK7KV2WG5cKU6', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiSXRoblo5YzluZ0w2a2hkZU5uZ0kwV1FZc0NGUEJLeXdSS0dqMXE2bSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9zdGF0aXN0aWsta2luZXJqYS1wZWdhd2FpIjtzOjU6InJvdXRlIjtzOjU2OiJmaWxhbWVudC5hZG1pbi5yZXNvdXJjZXMuc3RhdGlzdGlrLWtpbmVyamEtcGVnYXdhaS5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjA6IiQyeSQxMiRIaC9nWjVrd25IWkJzV1JtaE5MVlJlTWFubi9zY3hsUkpEWGRtbGdpL3h0cWc0cG5GWUh0cSI7fQ==', 1767861357);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_npwp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_address` text COLLATE utf8mb4_unicode_ci,
  `notification_deadline` tinyint(1) NOT NULL DEFAULT '1',
  `deadline_reminder_days` int NOT NULL DEFAULT '3',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `company_name`, `company_email`, `company_phone`, `company_npwp`, `company_address`, `notification_deadline`, `deadline_reminder_days`, `created_at`, `updated_at`) VALUES
(1, 'Konveksi Bandung 48', 'konveksibandung48@gmail.com', NULL, NULL, 'Jl. Situgunting Timur II, 008/008, Suka Asih, Bojongloa Kaler, Kota Bandung', 1, 3, '2026-01-02 06:47:28', '2026-01-06 13:31:25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `employee_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `employee_id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Test User', 'test@example.com', '2025-12-17 17:36:20', '$2y$12$l6PKuqSGkAvj3n1OnpN0YO97jx9DSpTbuROKMwn0qdMvTk7lVYE6u', '3kWje4q4aM', '2025-12-17 17:36:21', '2025-12-17 17:36:21'),
(2, 1, 'Sulis/Andri', 'owner@konveksibandung48.com', NULL, '$2y$12$Hh/gZ5kwnHZBsWRmhNLVReMann/scxlRJDXdmlgi/xtqg4pnFYHtq', 'BQAYQUlz5BqSvNWg6FroWbZLAJBV1ypFbecS1ig8ft5XF90gm9clxgWQ6A0q', '2025-12-17 17:36:38', '2025-12-17 17:36:38'),
(3, 2, 'Admin Konveksi', 'admin@konveksibandung48.com', NULL, '$2y$12$qDLsTcTEzDZj5LpdyarbOOIP14RiSijl0lVYDb5SFDCayuM9flv6q', NULL, '2025-12-17 17:36:38', '2026-01-02 18:05:00'),
(4, 3, 'Haris', 'haris@konveksibandung48.com', NULL, '$2y$12$erRhGO7XGcZmrT5Ly33KbeiusjJFUasVsUPHFrULVahGklK7V7aim', NULL, '2025-12-19 03:45:31', '2025-12-19 03:45:31'),
(5, 4, 'Herman', 'herman@konveksibandung48.com', NULL, '$2y$12$LoSk8IcaWJy6ox8RuBYDbOBK9/e094AC1KbfsoC2SHtwhlaKKMCdG', NULL, '2025-12-29 16:35:42', '2026-01-06 14:51:47'),
(6, 5, 'Devano', 'devano@konveksibandung48.com', NULL, '$2y$12$Z/fkvJbWko6cNE8jDsOQeejH7CBcLAhMhsda.W71t9WWGrtShI3Ua', NULL, '2026-01-01 03:02:51', '2026-01-01 03:02:51'),
(7, 6, 'Reyvan', 'reyvan@konveksibandung48.com', NULL, '$2y$12$phDoIk4tPuUExzOjEl4Gceve8p4HiDm7.xIHp23fhhk7Ca/zDiabi', NULL, '2026-01-06 12:55:21', '2026-01-06 12:55:21'),
(8, 7, 'Rafa', 'rafa@konveksibandung48.com', NULL, '$2y$12$kadjB9Gv77zBvi2bgz6iI.7l0hjZNCz9/oi9tOg0mAvjVL4MFtZ.m', NULL, '2026-01-06 13:40:09', '2026-01-06 13:40:09');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employees_email_unique` (`email`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `inventories`
--
ALTER TABLE `inventories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inventories_sku_unique` (`sku`);

--
-- Indexes for table `inventory_histories`
--
ALTER TABLE `inventory_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventory_histories_inventory_id_foreign` (`inventory_id`);

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
-- Indexes for table `material_usages`
--
ALTER TABLE `material_usages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `material_usages_order_id_foreign` (`order_id`),
  ADD KEY `material_usages_inventory_id_foreign` (`inventory_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `production_logs`
--
ALTER TABLE `production_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `production_logs_order_id_foreign` (`order_id`),
  ADD KEY `production_logs_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `production_outputs`
--
ALTER TABLE `production_outputs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `production_outputs_order_id_foreign` (`order_id`),
  ADD KEY `production_outputs_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `role_rates`
--
ALTER TABLE `role_rates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_rates_role_name_unique` (`role_name`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_employee_id_unique` (`employee_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventories`
--
ALTER TABLE `inventories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `inventory_histories`
--
ALTER TABLE `inventory_histories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `material_usages`
--
ALTER TABLE `material_usages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `production_logs`
--
ALTER TABLE `production_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=227;

--
-- AUTO_INCREMENT for table `production_outputs`
--
ALTER TABLE `production_outputs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `role_rates`
--
ALTER TABLE `role_rates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inventory_histories`
--
ALTER TABLE `inventory_histories`
  ADD CONSTRAINT `inventory_histories_inventory_id_foreign` FOREIGN KEY (`inventory_id`) REFERENCES `inventories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `material_usages`
--
ALTER TABLE `material_usages`
  ADD CONSTRAINT `material_usages_inventory_id_foreign` FOREIGN KEY (`inventory_id`) REFERENCES `inventories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `material_usages_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `production_logs`
--
ALTER TABLE `production_logs`
  ADD CONSTRAINT `production_logs_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `production_logs_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `production_outputs`
--
ALTER TABLE `production_outputs`
  ADD CONSTRAINT `production_outputs_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `production_outputs_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

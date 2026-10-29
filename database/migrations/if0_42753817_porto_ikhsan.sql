-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql305.infinityfree.com
-- Generation Time: Oct 25, 2026 at 05:31 AM
-- Server version: 11.4.13-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_42753817_porto_ikhsan`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `last_login_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `last_login_at`, `created_at`, `updated_at`) VALUES
(1, 'Admin Ikhsan', 'admin@example.com', '$2y$10$cgLRf.Bgm3hGaWb.FPUffelvCprSH1jOy6t87JtVOTtRhbCGwZFmK', '2026-09-19 22:23:16', '2026-08-26 02:13:53', '2026-09-20 05:23:16');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `document_type` varchar(50) DEFAULT 'cv',
  `file_path` varchar(255) NOT NULL,
  `original_name` varchar(255) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `educations`
--

CREATE TABLE `educations` (
  `id` int(11) NOT NULL,
  `institution_name` varchar(150) NOT NULL,
  `study_program` varchar(150) NOT NULL,
  `degree` varchar(50) NOT NULL,
  `start_year` int(11) NOT NULL,
  `end_year` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `educations`
--

INSERT INTO `educations` (`id`, `institution_name`, `study_program`, `degree`, `start_year`, `end_year`, `description`, `logo`, `sort_order`, `is_active`) VALUES
(1, 'Politeknik LP3I KampusTasikmalaya', 'D3 Manajemen Informatika', '-', 2023, NULL, 'Berfokus pada pengembangan sistem informasi, basis data, rekayasa perangkat lunak, dan keamanan sistem komputer.', 'logo_polban.png', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `experiences`
--

CREATE TABLE `experiences` (
  `id` int(11) NOT NULL,
  `organization_name` varchar(150) NOT NULL,
  `role` varchar(150) NOT NULL,
  `experience_type` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `is_current` tinyint(1) DEFAULT 0,
  `description` text NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(20) DEFAULT 'unread',
  `read_at` datetime DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `subject`, `message`, `status`, `read_at`, `ip_address`, `user_agent`, `created_at`) VALUES
(1, 'Adrian Hartanto', 'adrian@agency.com', 'Tawaran Magang - Backend Developer', 'Halo Ikhsan, kami tertarik dengan portofolio Anda dan ingin menawarkan posisi magang Backend Developer di agensi kami untuk periode semester depan.', 'unread', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/115.0.0.0', '2026-08-26 02:13:02'),
(2, 'Ahmad Fauzi', 'ahmad@fauzi.com', 'Tanya Proyek BUMDes', 'Halo, saya sedang melihat detail proyek digitalisasi BUMDes milik Anda di KKN. Apakah website tersebut menggunakan arsitektur OOP MVC murni? Sangat rapi dan terstruktur!', 'unread', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/115.0.0.0', '2026-08-26 02:13:02'),
(3, 'Rian Hidayat', 'rian@startup.co.id', 'Kerjasama Pengembangan Website', 'Kami butuh bantuan mahasiswa D3 Manajemen Informatika untuk proyek pembuatan landing page statis selama 3 bulan ke depan. Jika berminat, hubungi saya balik.', 'read', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/115.0.0.0', '2026-08-26 02:13:02');

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` int(11) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `headline` varchar(255) NOT NULL,
  `internship_target` varchar(150) NOT NULL,
  `short_bio` text NOT NULL,
  `about_text` text NOT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `location` varchar(150) DEFAULT NULL,
  `availability_status` tinyint(1) DEFAULT 1,
  `email` varchar(150) NOT NULL,
  `whatsapp` varchar(30) DEFAULT NULL,
  `github_url` varchar(255) DEFAULT NULL,
  `linkedin_url` varchar(255) DEFAULT NULL,
  `instagram_url` varchar(255) DEFAULT NULL,
  `tiktok_url` varchar(255) DEFAULT NULL,
  `youtube_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `full_name`, `headline`, `internship_target`, `short_bio`, `about_text`, `profile_photo`, `location`, `availability_status`, `email`, `whatsapp`, `github_url`, `linkedin_url`, `instagram_url`, `tiktok_url`, `youtube_url`, `created_at`, `updated_at`) VALUES
(1, 'M. Ikhsan Hidayat', 'Mahasiswa D3 Manajemen Informatika', '-', 'Saya adalah mahasiswa D3 Manajemen Informatika yang berfokus pada pengembangan backend web, pengelolaan database relasional, dan penulisan kode PHP yang bersih dan aman.', 'Sebagai mahasiswa tingkat akhir di program studi D3 Manajemen Informatika, saya aktif mengeksplorasi dunia pengembangan web khususnya backend development. Saya memiliki minat besar pada performa query SQL, keamanan aplikasi, dan penulisan RESTful API. Selama perkuliahan, saya telah mengerjakan beberapa proyek digitalisasi untuk masyarakat (KKN) dan sistem pergudangan untuk tugas besar perkuliahan. Saya siap mendedikasikan kemampuan saya sebagai magang Backend Developer untuk berkolaborasi dan berkembang di lingkungan industri yang profesional.', 'uploads/profile/25ce06ba2fa0e10b0f7f2a257ffcc8b7.jpg', 'Tasikmalaya, Indonesia', 0, 'ikhsanhidayatmuhamad@gmail.com', '+6282119491906', 'https://github.com/mikhsanhidayat', 'https://linkedin.com/in/faisalrahman', '', '', '', '2026-08-26 02:13:01', '2026-08-26 12:46:37');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `summary` text NOT NULL,
  `background` text NOT NULL,
  `objective` text NOT NULL,
  `solution` text NOT NULL,
  `role_description` text NOT NULL,
  `process_description` text NOT NULL,
  `feature_description` text NOT NULL,
  `result_description` text NOT NULL,
  `challenge_description` text DEFAULT NULL,
  `cover_image` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `project_status` varchar(50) NOT NULL,
  `demo_url` varchar(255) DEFAULT NULL,
  `github_url` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `publication_status` varchar(20) DEFAULT 'draft',
  `is_featured` tinyint(1) DEFAULT 0,
  `sort_order` int(11) DEFAULT 0,
  `published_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `category_id`, `title`, `slug`, `summary`, `background`, `objective`, `solution`, `role_description`, `process_description`, `feature_description`, `result_description`, `challenge_description`, `cover_image`, `start_date`, `end_date`, `project_status`, `demo_url`, `github_url`, `video_url`, `publication_status`, `is_featured`, `sort_order`, `published_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'Sistem Pengelolaan Keuangan BUMDes', 'sistem-pengelolaan-keuangan-bumdes', 'Sistem manajemen keuangan digital berbasis web untuk Badan Usaha Milik Desa (BUMDes) yang mencakup pencatatan transaksi kas, manajemen aset, laporan neraca & laba rugi, serta audit trail koreksi transaksi secara real-time.', 'BUMDes di desa lokasi KKN masih mengelola pembukuan keuangan secara manual menggunakan buku besar kertas. Proses ini rentan terhadap kesalahan hitung, sulit diaudit, dan tidak transparan bagi pihak pengawas desa. Pembuatan laporan neraca bulanan membutuhkan waktu hingga beberapa hari kerja.', 'Membangun sistem informasi keuangan BUMDes berbasis web yang mampu mencatat transaksi kas masuk/keluar, mengelola aset tetap, menyusun laporan neraca dan laba rugi secara otomatis, serta mendukung transparansi dan akuntabilitas keuangan desa.', 'Mengembangkan aplikasi web menggunakan framework Laravel dengan database MySQL, dilengkapi sistem autentikasi multi-role (Super Admin, Direktur, Bendahara, Pengawas), modul pencatatan transaksi dengan audit trail koreksi, manajemen aset fisik per unit usaha, dashboard statistik keuangan interaktif, serta fitur ekspor laporan PDF/Excel.', 'Bertindak sebagai Full Stack Developer & Database Architect. Saya merancang skema relasi database (10+ tabel), membangun seluruh logika backend menggunakan Laravel Eloquent ORM & Service Layer pattern, mengimplementasikan sistem koreksi transaksi audit-safe (reversing & replacement), merancang laporan neraca dinamis dengan perhitungan real-time, serta membangun antarmuka pengguna responsif dengan Vanilla CSS dan animasi micro-interaction.', 'Dimulai dari analisis kebutuhan keuangan BUMDes, perancangan skema database relasional, implementasi sistem autentikasi berbasis peran (Spatie Laravel Permission), pengembangan modul transaksi dengan validasi saldo kas, pembangunan sistem koreksi audit trail, kalkulasi neraca dinamis (Aktiva vs Pasiva), dan pengujian menyeluruh dengan 48 unit/feature test yang seluruhnya lolos (100% passed).', 'Dashboard statistik keuangan real-time dengan grafik interaktif, Pencatatan transaksi kas masuk/keluar per unit usaha, Sistem koreksi transaksi audit-safe (reversing & replacement), Manajemen aset fisik dengan pencatatan perolehan otomatis, Laporan neraca saldo & laba rugi dinamis, Manajemen tahun buku & tutup buku, Autentikasi multi-role (Super Admin, Direktur, Bendahara, Pengawas), Audit log aktivitas pengguna, Ekspor laporan PDF/Excel.', 'Sistem pembukuan BUMDes berhasil terdigitalisasi penuh. Proses pembuatan laporan keuangan bulanan yang sebelumnya membutuhkan 2–3 hari kerja kini dapat diselesaikan dalam hitungan menit. Transparansi keuangan meningkat karena seluruh pihak (Direktur, Bendahara, Pengawas) dapat memantau kondisi keuangan secara real-time sesuai hak akses masing-masing.', NULL, 'uploads/projects/covers/dc03842cbe3bb67790fc0dfbdce017f9.png', '2025-07-01', '2025-08-15', 'Selesai', NULL, 'https://github.com/ikhsan-dev/kkn-bumdes-keuangan', NULL, 'published', 1, 1, '2026-08-26 09:13:01', '2026-08-26 02:13:01', '2026-08-26 10:27:04'),
(2, 1, 'Website Profil Wisata Desa Wisata Indah', 'website-profil-wisata-desa-wisata-indah', 'Media informasi digital interaktif untuk memperkenalkan potensi wisata alam, homestay, dan kuliner khas desa.', 'Desa wisata memiliki banyak destinasi yang belum dikenal luas karena kurangnya media promosi digital yang ramah bagi wisatawan luar daerah.', 'Membuat platform promosi destinasi wisata desa yang dinamis untuk menarik minat pengunjung lokal maupun luar kota.', 'Membuat landing page dinamis yang menampilkan detail tempat wisata, galeri dokumentasi kegiatan, peta interaktif, serta form reservasi homestay sederhana.', 'Membangun modul frontend responsif menggunakan Bootstrap dan mengintegrasikannya dengan database MySQL via PHP Native untuk menyajikan data destinasi secara dinamis.', 'Mengumpulkan konten foto dari perangkat desa, menyusun layout landing page, menghubungkan form kontak ke database, dan optimasi gambar untuk mempercepat loading page.', 'Daftar Destinasi Wisata Interaktif, Form Hubungi Pengelola, Galeri Kegiatan KKN, Peta Lokasi Google Maps.', 'Destinasi wisata desa berhasil go-online dan mencatatkan peningkatan jumlah kunjungan wisatawan sekitar 25% setelah 2 bulan dipublikasikan.', NULL, 'uploads/projects/covers/81d9a1d1330577d7b1b7bf35799f260a.png', '2026-07-23', '2026-08-20', 'Selesai', 'https://institutalamrimba.com/', 'https://github.com/ikhsan-dev/kkn-profil-wisata', NULL, 'published', 0, 2, '2026-08-26 09:13:01', '2026-08-26 02:13:01', '2026-08-26 04:54:48'),
(3, 2, 'Sistem Pengelolaan Inventory Gudang Toko', 'sistem-pengelolaan-inventory-gudang-toko', 'Aplikasi web manajemen gudang berbasis Laravel untuk mencatat mutasi stok produk jadi & bahan baku secara real-time, dilengkapi laporan transaksi dan AI Assistant berbasis Google Gemini.', 'Tugas kuliah mata kuliah Pengembangan Aplikasi: pengelolaan gudang yang masih manual menyebabkan kesulitan dalam memantau stok bahan baku dan produk jadi secara akurat, serta tidak adanya riwayat transaksi yang terstruktur.', 'Membangun sistem informasi gudang terpusat yang mampu mencatat transaksi barang masuk, keluar, dan retur secara otomatis, serta menyediakan laporan mutasi stok yang dapat diakses kapan saja oleh staf gudang.', 'Membangun aplikasi manajemen gudang berbasis Laravel & MySQL dengan fitur CRUD produk & bahan baku, pencatatan log transaksi (masuk/keluar/retur), laporan mutasi stok, serta integrasi AI Chatbot (Google Gemini API) yang mampu menjawab pertanyaan seputar data stok secara real-time.', 'Developer Tunggal (Fullstack). Merancang arsitektur database, membangun seluruh fitur CRUD & manajemen stok, mengimplementasikan sistem autentikasi Laravel Breeze, serta mengintegrasikan Google Gemini API sebagai AI Assistant berbasis RAG (Retrieval-Augmented Generation).', 'Analisis kebutuhan sistem, perancangan skema database & alur transaksi, implementasi autentikasi & manajemen user, pembangunan fitur inventaris produk & bahan baku, pengembangan sistem pelaporan, integrasi AI Chatbot dengan data real-time, serta pengujian fungsionalitas end-to-end.', 'Manajemen Stok Produk Jadi & Bahan Baku, Pencatatan Transaksi Masuk/Keluar/Retur, Log Riwayat Transaksi Lengkap, Laporan Mutasi Stok, Manajemen User & Role, AI Chatbot berbasis Google Gemini (RAG), Dashboard Statistik Real-time.', 'Sistem berhasil mendigitalisasi proses pencatatan gudang dari manual ke digital, mampu menangani ratusan data transaksi produk & bahan baku, dan mendapatkan nilai A pada tugas besar kuliah. Fitur AI Chatbot menjadi nilai tambah yang memudahkan staf dalam mengakses informasi stok tanpa harus membuka laporan manual.', NULL, 'uploads/projects/covers/765d3cfb1ba55800bfb54594b0cdb6ad.png', '2024-10-15', '2025-01-06', 'Selesai', NULL, 'https://github.com/mikhsanhidayat/GUDANG_APP', NULL, 'published', 1, 3, '2026-08-26 09:13:01', '2026-08-26 02:13:01', '2026-08-26 09:21:15'),
(4, 2, 'E-Cashier Pasar: Aplikasi Manajemen Transaksi & Laporan Penjualan Berbasis Web', 'e-cashier-pasar-aplikasi-manajemen-transaksi-laporan-penjualan-berbasis-web', 'Aplikasi kasir digital berbasis web untuk pedagang pasar tradisional yang memudahkan pencatatan transaksi penjualan, pengelolaan stok produk, dan pembuatan laporan keuangan harian maupun bulanan secara otomatis.', 'Pedagang di pasar tradisional masih mengandalkan pencatatan manual menggunakan buku atau kertas untuk mencatat transaksi penjualan. Metode ini rawan kesalahan, sulit ditelusuri, dan tidak efisien saat transaksi berlangsung cepat. Selain itu, pembuatan laporan keuangan bulanan membutuhkan waktu lama karena harus direkap secara manual.', 'Membangun sistem kasir digital yang mudah digunakan oleh pedagang pasar, mampu mencatat transaksi secara real-time, mengelola data produk dan stok, serta menghasilkan laporan penjualan harian dan bulanan secara otomatis tanpa perlu rekap manual.', 'Dibangun aplikasi web kasir berbasis Goravel (Go) dengan fitur login berbasis JWT, manajemen produk dan kategori, sistem transaksi kasir (Point of Sale), riwayat transaksi, serta laporan harian dan bulanan yang dapat diekspor ke file Excel. Tampilan antarmuka modern dan responsif sehingga mudah dioperasikan oleh kasir.', 'Full-stack Developer — merancang arsitektur database, membangun seluruh REST API backend menggunakan Goravel Framework, mengimplementasikan autentikasi JWT, membuat sistem manajemen pengguna dengan role admin dan kasir, serta mengembangkan antarmuka frontend menggunakan template HTML dengan JavaScript vanilla.', 'Analisis kebutuhan pedagang pasar dan alur transaksi kasir secara langsung.\r\nPerancangan skema database (users, products, categories, units, transactions, transaction_details).\r\nSetup project menggunakan Goravel Framework dengan konfigurasi MySQL.\r\nPengembangan REST API untuk autentikasi, produk, kategori, satuan, transaksi, dan laporan.\r\nPembuatan antarmuka frontend (halaman login, dashboard, kasir POS, laporan).\r\nImplementasi ekspor laporan ke Excel menggunakan library Excelize.\r\nPengujian alur transaksi end-to-end dan seeder data untuk simulasi demo.', 'Autentikasi login dengan JWT (role: Admin & Kasir)\r\nDashboard statistik penjualan real-time dengan grafik tren mingguan/bulanan\r\nSistem kasir (Point of Sale) dengan keranjang belanja dan perhitungan kembalian otomatis\r\nManajemen produk, kategori, dan satuan barang\r\nRiwayat transaksi lengkap dengan detail item\r\nLaporan penjualan harian dan bulanan\r\nEkspor laporan ke file Excel\r\nManajemen pengguna (tambah, edit, hapus, reset password)\r\nManajemen profil akun', 'Proses pencatatan transaksi yang sebelumnya membutuhkan waktu 5–10 menit per transaksi (manual) menjadi kurang dari 1 menit menggunakan sistem kasir digital ini. Rekap laporan bulanan yang biasanya memakan waktu 2–3 hari kini dapat dihasilkan secara otomatis dalam hitungan detik dan langsung dapat diunduh dalam format Excel.', NULL, 'uploads/projects/covers/cb831fe5159195786646c21a59993e50.png', '2026-06-09', '2026-08-11', 'Selesai', NULL, NULL, NULL, 'published', 0, 0, '2026-08-27 03:28:56', '2026-08-27 07:28:12', '2026-08-27 07:28:55');

-- --------------------------------------------------------

--
-- Table structure for table `project_categories`
--

CREATE TABLE `project_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(120) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project_categories`
--

INSERT INTO `project_categories` (`id`, `name`, `slug`, `is_active`) VALUES
(1, 'Proyek KKN / Pengabdian', 'proyek-kkn', 1),
(2, 'Tugas Kuliah', 'tugas-kuliah', 1),
(3, 'Proyek Pribadi', 'proyek-pribadi', 1);

-- --------------------------------------------------------

--
-- Table structure for table `project_media`
--

CREATE TABLE `project_media` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `media_type` varchar(30) DEFAULT 'image',
  `file_path` varchar(255) DEFAULT NULL,
  `external_url` varchar(255) DEFAULT NULL,
  `title` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project_media`
--

INSERT INTO `project_media` (`id`, `project_id`, `media_type`, `file_path`, `external_url`, `title`, `description`, `alt_text`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'image', 'uploads/projects/gallery/da558d120d9c145d6c41fa484d97636a.png', NULL, 'Halaman Buku Kas Harian', 'Menampilkan laporan mutasi kas masuk dan keluar harian beserta saldo berjalan (running balance) BUMDes secara real-time. Dilengkapi filter berdasarkan rentang tanggal dan unit usaha, serta fitur ekspor ke PDF dan Excel.', 'Tampilan buku kas harian BUMDes', 1, 1, '2026-08-26 02:13:01', '2026-08-26 10:31:18'),
(2, 1, 'image', 'uploads/projects/gallery/4faa390ed52fd8648e90abd8272e320f.png', NULL, 'Halaman Rekapitulasi Tahunan', 'Menampilkan perbandingan perkembangan total pendapatan dan pengeluaran BUMDes lintas tahun buku. Menyajikan total akumulasi surplus/defisit per tahun anggaran untuk mendukung evaluasi kinerja keuangan jangka panjang.', 'Tampilan rekapitulasi tahunan keuangan BUMDes', 2, 1, '2026-08-26 02:13:01', '2026-08-26 10:36:36'),
(3, 1, 'image', 'uploads/projects/gallery/7513da8f3ff162f6e2e6cfeebd63abf0.png', NULL, 'Halaman Laporan Laba Rugi Sederhana', 'Menampilkan kalkulasi selisih antara total pendapatan operasional dan total beban operasional BUMDes. Laporan dikelompokkan berdasarkan kategori pemasukan dan pengeluaran, dilengkapi estimasi laba/rugi berjalan netto pada periode yang dipilih.', 'Tampilan laporan laba rugi sederhana BUMDes', 4, 1, '2026-08-26 02:13:01', '2026-08-26 10:37:50'),
(5, 2, 'image', 'uploads/projects/gallery/baf0b9397963f99d088fb0f82213ec33.png', NULL, 'PANEL ADMIN', 'Halaman dashboard yang berfungsi untuk mengelola semua kegiatan yang ada di aplikasi', 'PANEL ADMIN', 1, 1, '2026-08-26 04:48:31', '2026-08-26 04:48:31'),
(6, 3, 'image', 'uploads/projects/gallery/32d2b73a362375e5f49b523b246ac058.png', NULL, 'Halaman Data Produk — Tabel Manajemen Inventaris', 'Halaman Data Produk menampilkan seluruh daftar produk jadi yang tersimpan di gudang dalam format tabel yang informatif. Setiap baris menampilkan Kode Produk (auto-generated, contoh: PRD-JAS-936), Nama Produk, Warna, Logo, dan jumlah Stok Tersedia yang ditandai dengan badge warna — hijau untuk stok aman dan merah untuk stok kritis.\r\n\r\nTerdapat fitur pencarian produk secara real-time di sudut kanan atas tabel, tombol Tambah Produk untuk menambahkan data baru, serta empat tombol aksi pada setiap baris: Retur (kembalikan stok), Tambah (tambah stok masuk), Edit (ubah data produk), dan Hapus (hapus data). Halaman ini juga dilengkapi navigasi pagination untuk mengelola data dalam jumlah besar.', 'Tampilan tabel data produk gudang dengan fitur pencarian, stok badge, dan tombol aksi CRUD', 1, 1, '2026-08-26 09:27:01', '2026-08-26 09:27:01'),
(7, 3, 'image', 'uploads/projects/gallery/114ac61123c72d132dec00d83bf6108f.png', NULL, 'Halaman Data Bahan Baku — Tabel Manajemen Bahan Mentah', 'Halaman Data Bahan Baku menampilkan seluruh daftar bahan mentah yang tersimpan di gudang dalam format tabel yang terstruktur. Setiap baris berisi Kode Bahan (auto-generated, contoh: BHN-KAI-5931), Nama Bahan, Warna, dan Sisa Stok yang ditampilkan dengan badge warna — hijau untuk stok aman dan merah untuk stok kritis.\r\n\r\nHalaman ini dilengkapi fitur pencarian bahan secara real-time, tombol Tambah Bahan Baku untuk mendaftarkan bahan baru, serta empat tombol aksi pada setiap baris: Retur (kembalikan bahan), Tambah (catat bahan masuk), Edit (ubah data bahan), dan Hapus (hapus data). Navigasi pagination tersedia di bagian bawah untuk memudahkan pengelolaan data bahan dalam jumlah besar.', 'Tampilan tabel data bahan baku gudang dengan kode bahan, nama, warna, sisa stok, dan tombol aksi CRUD', 2, 1, '2026-08-26 09:29:54', '2026-08-26 09:29:54'),
(8, 3, 'image', 'uploads/projects/gallery/c81249a37bf93178fd0fedddff1b7a54.png', NULL, 'Halaman Laporan Produk — Riwayat Retur & Grafik Mutasi Stok', 'Halaman Laporan Produk menyajikan ringkasan lengkap seluruh aktivitas mutasi stok produk jadi dalam dua format visual: tabel riwayat dan grafik batang.\r\n\r\nBagian atas menampilkan tabel Laporan Retur Produk yang mencatat setiap pengembalian barang secara detail, meliputi Tanggal transaksi, Kode Produk, Nama Produk, Jumlah item yang diretur, Kondisi barang (rusak/bagus), serta Keterangan asal retur (misalnya: Retur dari pelanggan). Bagian bawah menampilkan grafik batang komparatif yang memvisualisasikan total transaksi berdasarkan tipe: Masuk (hijau), Keluar (merah), dan Retur (biru), sehingga admin dapat membaca tren pergerakan stok produk secara cepat dan akurat.', 'Halaman laporan produk dengan tabel retur dan grafik batang mutasi stok masuk, keluar, dan retur', 3, 1, '2026-08-26 09:32:41', '2026-08-26 09:32:41'),
(9, 3, 'image', 'uploads/projects/gallery/1d5ce81a430005b5fb27a5e71580381d.png', NULL, 'Halaman Laporan Bahan Baku — Riwayat Retur & Grafik Mutasi Bahan', 'Halaman Laporan Bahan Baku menyajikan ringkasan lengkap seluruh aktivitas mutasi stok bahan mentah dalam dua format visual: tabel riwayat retur dan grafik batang mutasi.\r\n\r\nBagian tabel mencatat setiap transaksi retur bahan secara detail, mencakup Tanggal, Kode Bahan (contoh: BHN-KAN-5326), Nama Bahan, Jumlah Retur, Keterangan asal pengembalian (contoh: Sisa potongan/reject produksi), serta Status penyelesaian retur yang ditandai dengan badge — hijau untuk \"Selesai\" dan kuning untuk \"Pending\". Bagian bawah menampilkan grafik batang komparatif yang memvisualisasikan total transaksi berdasarkan tipe: Masuk (hijau), Keluar (merah), dan Retur (biru), memudahkan admin dalam membaca tren penggunaan bahan baku secara keseluruhan.', 'Halaman laporan bahan baku dengan tabel retur bahan, status selesai/pending, dan grafik batang mutasi stok', 0, 1, '2026-08-26 09:37:56', '2026-08-26 09:37:56'),
(10, 3, 'image', 'uploads/projects/gallery/35d30ebfc1b97356e34de882fbf600ae.png', NULL, 'Fitur Gudang AI — Asisten Cerdas Berbasis Google Gemini (RAG)', 'Gudang AI adalah fitur asisten cerdas yang terintegrasi langsung di dalam aplikasi sebagai floating widget di sudut kanan bawah layar. Fitur ini dapat diakses dari halaman mana pun tanpa berpindah halaman, memberikan pengalaman tanya-jawab yang cepat dan seamless bagi pengguna.\r\n\r\nDitenagai oleh Google Gemini API dengan pendekatan RAG (Retrieval-Augmented Generation), Gudang AI mampu menjawab pertanyaan berbasis data real-time dari database gudang — seperti mengecek stok kritis, produk yang paling sering keluar, hingga ringkasan mutasi bahan baku. Contoh pada gambar: ketika user bertanya \"apa barang yang kurang dari 10\", AI langsung merespons dengan data aktual dari sistem, yaitu produk Jas Hujan Rerum (Stok: 6) dan Jas Hujan Sunt (Stok: 6), tanpa perlu user membuka halaman laporan secara manual.', 'Fitur chatbot Gudang AI berbasis Google Gemini yang menampilkan jawaban real-time tentang stok kritis produk gudang', 0, 1, '2026-08-26 09:39:44', '2026-08-26 09:39:44'),
(11, 1, 'image', 'uploads/projects/gallery/ca5e2f1e4a143f7232c30f76f669f0d5.png', NULL, 'Halaman Rekapitulasi Bulanan', 'Menampilkan ringkasan total pemasukan, total pengeluaran, dan surplus/defisit BUMDes per bulan dalam satu tahun anggaran. Dilengkapi filter per unit usaha dan fitur ekspor laporan ke PDF maupun Excel.', 'Tampilan rekapitulasi bulanan keuangan BUMDes', 0, 1, '2026-08-26 10:33:11', '2026-08-26 10:33:11'),
(12, 1, 'image', 'uploads/projects/gallery/19599b30910a600bfe637ad10865b916.png', NULL, 'Halaman Laporan Arus Kas', 'Menampilkan mutasi masuk dan keluar kas berdasarkan aktivitas operasional, investasi, dan pendanaan BUMDes. Menyajikan saldo awal kas, kenaikan/penurunan bersih, dan saldo akhir kas pada periode yang dipilih secara terperinci per kategori transaksi.', 'Tampilan laporan arus kas BUMDes', 5, 1, '2026-08-26 10:39:59', '2026-08-26 10:39:59'),
(13, 1, 'image', 'uploads/projects/gallery/7ad958f4db813738b2e5193d32cbc017.png', NULL, 'Halaman Laporan Neraca Sederhana', 'Menampilkan posisi aset (Aktiva) berbanding kewajiban dan modal (Pasiva) BUMDes per tanggal tertentu. Neraca otomatis memvalidasi keseimbangan Aktiva dan Pasiva, dengan status \"SEIMBANG\" jika selisihnya Rp0, memastikan akurasi pembukuan secara real-time.', 'Tampilan laporan neraca sederhana BUMDes', 6, 1, '2026-08-26 11:27:26', '2026-08-26 11:27:26'),
(14, 1, 'image', 'uploads/projects/gallery/40acf19c16e5a8e81bdb3c2ca7a3fb82.png', NULL, 'Halaman Daftar Inventaris Aset Tetap', 'Menampilkan rincian seluruh aset tetap yang dimiliki BUMDes beserta unit usaha penanggung jawab, tanggal perolehan, kondisi, dan nilai investasi. Dilengkapi filter berdasarkan golongan, kondisi, dan status aset, serta menampilkan total nilai investasi aset secara keseluruhan.', 'Tampilan daftar inventaris aset tetap BUMDes', 7, 1, '2026-08-26 11:31:02', '2026-08-26 11:31:02');

-- --------------------------------------------------------

--
-- Table structure for table `project_technologies`
--

CREATE TABLE `project_technologies` (
  `project_id` int(11) NOT NULL,
  `technology_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project_technologies`
--

INSERT INTO `project_technologies` (`project_id`, `technology_id`) VALUES
(1, 1),
(1, 2),
(2, 2),
(3, 2),
(4, 2),
(1, 3),
(2, 3),
(3, 3),
(1, 4),
(2, 4),
(3, 4),
(4, 4),
(2, 5),
(3, 5),
(1, 6),
(2, 6),
(3, 6),
(4, 6),
(4, 7),
(4, 8);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `key` varchar(100) NOT NULL,
  `value` text DEFAULT NULL,
  `type` varchar(30) DEFAULT 'text',
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `type`, `updated_at`) VALUES
(1, 'website_name', 'M. Ikhsan Hidayat - Portofolio', 'text', '2026-08-26 09:40:52'),
(2, 'meta_title', 'M.  |Ikhasan Hidayat Backend Developer Intern Portfolio', 'text', '2026-08-26 09:40:52'),
(3, 'meta_description', 'Website portofolio resmi M. Ikhsanul Karim, mahasiswa D3 Manajemen Informatika yang siap magang sebagai Backend Web Developer.', 'textarea', '2026-08-26 02:13:02'),
(4, 'footer_text', 'M. Ikhsan Hidayat. Dibuat menggunakan Native PHP, MySQL & Tailwind CSS.', 'text', '2026-08-26 09:40:52'),
(5, 'primary_color', 'indigo', 'text', '2026-09-20 05:22:27'),
(6, 'google_maps_link', 'https://www.google.com/maps/place/Kurniabakti,+Kec.+Ciawi,+Kabupaten+Tasikmalaya,+Jawa+Barat/@-7.1518118,108.1326968,2130m/data=!3m1!1e3!4m6!3m5!1s0x2e6f4bfdef5bffcf:0x3ae11bb566d0b251!8m2!3d-7.1507884!4d108.1413845!16s%2Fg%2F120qd3hj!5m1!1e1?authuser=0&entry=ttu&g_ep=EgoyMDI2MDgyMy4wIKXMDSoASAFQAw%3D%3D', 'textarea', '2026-08-26 06:23:42');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `proficiency_level` varchar(50) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `name`, `category`, `icon`, `proficiency_level`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'PHP', 'Backend', NULL, 'Menengah', 1, 1, '2026-08-26 02:13:01', '2026-08-26 02:13:01'),
(2, 'Go', 'Backend', NULL, 'Dasar', 2, 1, '2026-08-26 02:13:01', '2026-08-26 02:35:37'),
(3, 'MySQL', 'Database', NULL, 'Menengah', 1, 1, '2026-08-26 02:13:01', '2026-08-26 02:35:49'),
(5, 'HTML5 & CSS3', 'Frontend', NULL, 'Mahir', 1, 1, '2026-08-26 02:13:01', '2026-08-26 02:13:01'),
(6, 'Tailwind CSS', 'Frontend', NULL, 'Menengah', 2, 1, '2026-08-26 02:13:01', '2026-08-26 02:13:01'),
(7, 'JavaScript', 'Frontend', NULL, 'Menengah', 3, 1, '2026-08-26 02:13:01', '2026-08-26 02:38:29'),
(8, 'Git & GitHub', 'Tools', NULL, 'Menengah', 1, 1, '2026-08-26 02:13:01', '2026-08-26 02:13:01'),
(9, 'VS Code', 'Tools', NULL, 'Mahir', 2, 1, '2026-08-26 02:13:01', '2026-08-26 02:13:01'),
(10, 'Composer', 'Tools', NULL, 'Menengah', 3, 1, '2026-08-26 02:13:01', '2026-08-26 02:13:01'),
(11, 'Kerja Sama Tim', 'Soft Skill', NULL, 'Mahir', 1, 1, '2026-08-26 02:13:01', '2026-08-26 02:13:01'),
(12, 'Analisis Masalah', 'Soft Skill', NULL, 'Menengah', 2, 1, '2026-08-26 02:13:01', '2026-08-26 02:13:01');

-- --------------------------------------------------------

--
-- Table structure for table `technologies`
--

CREATE TABLE `technologies` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `technologies`
--

INSERT INTO `technologies` (`id`, `name`, `icon`, `is_active`) VALUES
(1, 'PHP Native', 'code-2', 1),
(2, 'MySQL', 'database', 1),
(3, 'Tailwind CSS', 'paint-bucket', 1),
(4, 'JavaScript', 'file-json-2', 1),
(5, 'Laravel', 'cpu', 1),
(6, 'Git', 'git-branch', 1),
(7, 'Bootstrap', 'layout', 1),
(8, 'Goravel', NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `educations`
--
ALTER TABLE `educations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `experiences`
--
ALTER TABLE `experiences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `project_categories`
--
ALTER TABLE `project_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `project_media`
--
ALTER TABLE `project_media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `project_technologies`
--
ALTER TABLE `project_technologies`
  ADD PRIMARY KEY (`project_id`,`technology_id`),
  ADD KEY `technology_id` (`technology_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key` (`key`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `technologies`
--
ALTER TABLE `technologies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `educations`
--
ALTER TABLE `educations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `experiences`
--
ALTER TABLE `experiences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `project_categories`
--
ALTER TABLE `project_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `project_media`
--
ALTER TABLE `project_media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `technologies`
--
ALTER TABLE `technologies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `project_categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `project_media`
--
ALTER TABLE `project_media`
  ADD CONSTRAINT `project_media_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `project_technologies`
--
ALTER TABLE `project_technologies`
  ADD CONSTRAINT `project_technologies_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `project_technologies_ibfk_2` FOREIGN KEY (`technology_id`) REFERENCES `technologies` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

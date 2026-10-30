<?php

declare(strict_types=1);

// 1. Autoload & Environment setup
require_once __DIR__ . '/../vendor/autoload.php';

try {
    if (file_exists(__DIR__ . '/../.env')) {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
        $dotenv->load();
    } else {
        throw new RuntimeException('.env file is missing. Please copy it from .env.example first.');
    }
} catch (Exception $e) {
    fwrite(STDERR, "Configuration Error: " . $e->getMessage() . "\n");
    exit(1);
}

use App\Core\Database;

// Helper print functions
function info(string $msg): void {
    echo "\033[32m[INFO]\033[0m {$msg}\n";
}

function error(string $msg): void {
    fwrite(STDERR, "\033[31m[ERROR]\033[0m {$msg}\n");
}

function warn(string $msg): void {
    echo "\033[33m[WARN]\033[0m {$msg}\n";
}

// Check arguments
$command = $argv[1] ?? null;

if ($command === null) {
    echo "Penggunaan: php bin/console.php [command]\n";
    echo "Command yang tersedia:\n";
    echo "  migrate     - Menjalankan migrasi skema tabel database\n";
    echo "  seed        - Mengisi data demo/seeder awal ke database\n";
    echo "  make:admin  - Membuat akun administrator baru\n";
    exit(1);
}

switch ($command) {
    case 'migrate':
        runMigration();
        break;
    case 'seed':
        runSeeder();
        break;
    case 'make:admin':
        createAdmin();
        break;
    default:
        error("Command '{$command}' tidak dikenal.");
        exit(1);
}

/**
 * Runs migration by reading schema.sql and executing it.
 */
function runMigration(): void
{
    info("Memulai migrasi database...");
    
    $schemaFile = __DIR__ . '/../database/migrations/schema.sql';
    if (!file_exists($schemaFile)) {
        error("File skema tidak ditemukan di: {$schemaFile}");
        exit(1);
    }

    // Ensure database exists
    $host = $_ENV['DB_HOST'] ?? '127.0.0.1';
    $port = $_ENV['DB_PORT'] ?? '3306';
    $user = $_ENV['DB_USERNAME'] ?? 'root';
    $pass = $_ENV['DB_PASSWORD'] ?? '';
    $dbName = $_ENV['DB_DATABASE'] ?? 'porto_ikhsan';
    
    try {
        $tempDsn = "mysql:host={$host};port={$port};charset=utf8mb4";
        $tempPdo = new PDO($tempDsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        $tempPdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        info("Database '{$dbName}' dipastikan aktif.");
    } catch (PDOException $e) {
        warn("Gagal mengecek/membuat database: " . $e->getMessage() . ". Mencoba koneksi langsung...");
    }

    $sql = file_get_contents($schemaFile);

    try {
        $db = Database::getConnection();
        // Since PDO execute() doesn't always support multiple statements directly, we can execute the SQL queries.
        // For MySQL, PDO::exec supports multiple queries separated by semicolons.
        $db->exec($sql);
        info("Migrasi database berhasil diselesaikan!");
    } catch (PDOException $e) {
        error("Kegagalan Migrasi: " . $e->getMessage());
        exit(1);
    }
}

/**
 * Runs seeder to populate default data.
 */
function runSeeder(): void
{
    info("Memulai seeding data...");
    
    try {
        $db = Database::getConnection();

        // 1. Seed Profile
        info("Seeding data profile...");
        $db->exec("TRUNCATE TABLE `profiles`");
        $stmtProfile = $db->prepare("
            INSERT INTO `profiles` 
            (`full_name`, `headline`, `internship_target`, `short_bio`, `about_text`, `location`, `availability_status`, `email`, `whatsapp`, `github_url`, `linkedin_url`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmtProfile->execute([
            'M. Ikhsanul Karim',
            'Mahasiswa D3 Manajemen Informatika',
            'Backend Developer Intern',
            'Saya adalah mahasiswa D3 Manajemen Informatika yang berfokus pada pengembangan backend web, pengelolaan database relasional, dan penulisan kode PHP yang bersih dan aman.',
            'Sebagai mahasiswa tingkat akhir di program studi D3 Manajemen Informatika, saya aktif mengeksplorasi dunia pengembangan web khususnya backend development. Saya memiliki minat besar pada performa query SQL, keamanan aplikasi, dan penulisan RESTful API. Selama perkuliahan, saya telah mengerjakan beberapa proyek digitalisasi untuk masyarakat (KKN) dan sistem pergudangan untuk tugas besar perkuliahan. Saya siap mendedikasikan kemampuan saya sebagai magang Backend Developer untuk berkolaborasi dan berkembang di lingkungan industri yang profesional.',
            'Bandung, Indonesia',
            1, // Available
            'ikhsan@example.com',
            '+6281234567890',
            'https://github.com/ikhsan-dev',
            'https://linkedin.com/in/ikhsankarim'
        ]);

        // 2. Seed Skills
        info("Seeding data skills...");
        $db->exec("TRUNCATE TABLE `skills`");
        $stmtSkill = $db->prepare("
            INSERT INTO `skills` (`name`, `category`, `proficiency_level`, `sort_order`, `is_active`) 
            VALUES (?, ?, ?, ?, 1)
        ");
        
        $skills = [
            // Backend
            ['PHP', 'Backend', 'Menengah', 1],
            ['Node.js', 'Backend', 'Dasar', 2],
            // Database
            ['MySQL / MariaDB', 'Database', 'Menengah', 1],
            ['PostgreSQL', 'Database', 'Dasar', 2],
            // Frontend
            ['HTML5 & CSS3', 'Frontend', 'Mahir', 1],
            ['Tailwind CSS', 'Frontend', 'Menengah', 2],
            ['JavaScript (ES6+)', 'Frontend', 'Menengah', 3],
            // Tools
            ['Git & GitHub', 'Tools', 'Menengah', 1],
            ['VS Code', 'Tools', 'Mahir', 2],
            ['Composer', 'Tools', 'Menengah', 3],
            // Soft Skill
            ['Kerja Sama Tim', 'Soft Skill', 'Mahir', 1],
            ['Analisis Masalah', 'Soft Skill', 'Menengah', 2],
        ];

        foreach ($skills as $skill) {
            $stmtSkill->execute($skill);
        }

        // 3. Seed Project Categories
        info("Seeding data project_categories...");
        $db->exec("SET FOREIGN_KEY_CHECKS = 0; TRUNCATE TABLE `project_categories`; SET FOREIGN_KEY_CHECKS = 1;");
        $stmtCat = $db->prepare("INSERT INTO `project_categories` (`name`, `slug`, `is_active`) VALUES (?, ?, ?)");
        
        $stmtCat->execute(['Proyek KKN / Pengabdian', 'proyek-kkn', 1]); // ID 1
        $stmtCat->execute(['Tugas Kuliah', 'tugas-kuliah', 1]);           // ID 2
        $stmtCat->execute(['Proyek Pribadi', 'proyek-pribadi', 1]);       // ID 3
        
        // Get Category IDs
        $catKknId = 1;
        $catTugasId = 2;
        $catPribadiId = 3;

        // 4. Seed Technologies
        info("Seeding data technologies...");
        $db->exec("SET FOREIGN_KEY_CHECKS = 0; TRUNCATE TABLE `technologies`; SET FOREIGN_KEY_CHECKS = 1;");
        $stmtTech = $db->prepare("INSERT INTO `technologies` (`name`, `icon`, `is_active`) VALUES (?, ?, ?)");
        
        $stmtTech->execute(['PHP Native', 'code-2', 1]);    // ID 1
        $stmtTech->execute(['MySQL', 'database', 1]);       // ID 2
        $stmtTech->execute(['Tailwind CSS', 'paint-bucket', 1]); // ID 3
        $stmtTech->execute(['JavaScript', 'file-json-2', 1]); // ID 4
        $stmtTech->execute(['Laravel', 'cpu', 1]);          // ID 5
        $stmtTech->execute(['Git', 'git-branch', 1]);       // ID 6
        $stmtTech->execute(['Bootstrap', 'layout', 1]);     // ID 7

        // 5. Seed Projects
        info("Seeding data projects...");
        $db->exec("SET FOREIGN_KEY_CHECKS = 0; TRUNCATE TABLE `projects`; SET FOREIGN_KEY_CHECKS = 1;");
        $stmtProj = $db->prepare("
            INSERT INTO `projects` 
            (`category_id`, `title`, `slug`, `summary`, `background`, `objective`, `solution`, `role_description`, `process_description`, `feature_description`, `result_description`, `cover_image`, `start_date`, `end_date`, `project_status`, `demo_url`, `github_url`, `publication_status`, `is_featured`, `sort_order`, `published_at`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'published', ?, ?, NOW())
        ");

        // Project 1: Sistem Pengelolaan Keuangan BUMDes
        $stmtProj->execute([
            $catKknId,
            'Sistem Pengelolaan Keuangan BUMDes',
            'sistem-pengelolaan-keuangan-bumdes',
            'Sistem pencatatan laporan keuangan digital untuk Badan Usaha Milik Desa guna memfasilitasi transparansi pembukuan kas desa.',
            'BUMDes di desa lokasi KKN masih mengelola laporan keuangan kas secara manual menggunakan buku besar kertas, yang rentan terhadap kerusakan fisik dan kesalahan perhitungan saldo pembukuan bulanan.',
            'Membangun sistem informasi pencatatan kas masuk dan kas keluar berbasis web yang dapat otomatis menyusun laporan rugi laba dan neraca saldo bulanan.',
            'Mengembangkan aplikasi web responsif menggunakan native PHP dengan penyimpanan MySQL, dilengkapi fitur dashboard statistik kas, manajemen pos anggaran belanja, dan cetak PDF laporan bulanan.',
            'Bertindak sebagai Backend Developer & Database Designer. Saya merancang skema relasi database (8 tabel), menulis seluruh modul query transaksi keuangan menggunakan PDO prepared statements, dan membuat PDF generator menggunakan library eksternal.',
            'Dimulai dari analisis kebutuhan BUMDes, perancangan diagram entity-relationship (ERD), pembuatan database, implementasi logika backend transaksi kas, dan pengujian alur perhitungan neraca keuangan.',
            'Dashboard statistik kas harian, Modul Transaksi Kas Masuk/Keluar, Cetak Laporan Neraca & Rugi Laba bulanan, Autentikasi Staf BUMDes, Ekspor PDF/Excel.',
            'Sistem pembukuan BUMDes terdigitalisasi penuh. Staf desa dapat menghemat waktu pengerjaan laporan bulanan dari 3 hari menjadi beberapa klik saja, serta mengurangi risiko kesalahan hitung hingga 0%.',
            'placeholder_bumdes.png',
            '2025-07-01',
            '2025-08-15',
            'Selesai',
            'https://demo-bumdes.example.com',
            'https://github.com/ikhsan-dev/kkn-bumdes-keuangan',
            1, // Featured
            1  // Order
        ]);
        $projBumdesId = $db->lastInsertId();

        // Project 2: Website Profil Wisata Desa
        $stmtProj->execute([
            $catKknId,
            'Website Profil Wisata Desa Wisata Indah',
            'website-profil-wisata-desa-wisata-indah',
            'Media informasi digital interaktif untuk memperkenalkan potensi wisata alam, homestay, dan kuliner khas desa.',
            'Desa wisata memiliki banyak destinasi yang belum dikenal luas karena kurangnya media promosi digital yang ramah bagi wisatawan luar daerah.',
            'Membuat platform promosi destinasi wisata desa yang dinamis untuk menarik minat pengunjung lokal maupun luar kota.',
            'Membuat landing page dinamis yang menampilkan detail tempat wisata, galeri dokumentasi kegiatan, peta interaktif, serta form reservasi homestay sederhana.',
            'Membangun modul frontend responsif menggunakan Bootstrap dan mengintegrasikannya dengan database MySQL via PHP Native untuk menyajikan data destinasi secara dinamis.',
            'Mengumpulkan konten foto dari perangkat desa, menyusun layout landing page, menghubungkan form kontak ke database, dan optimasi gambar untuk mempercepat loading page.',
            'Daftar Destinasi Wisata Interaktif, Form Hubungi Pengelola, Galeri Kegiatan KKN, Peta Lokasi Google Maps.',
            'Destinasi wisata desa berhasil go-online dan mencatatkan peningkatan jumlah kunjungan wisatawan sekitar 25% setelah 2 bulan dipublikasikan.',
            'placeholder_wisata.png',
            '2025-07-10',
            '2025-08-05',
            'Selesai',
            null,
            'https://github.com/ikhsan-dev/kkn-profil-wisata',
            0, // Not featured
            2  // Order
        ]);
        $projWisataId = $db->lastInsertId();

        // Project 3: Sistem Pengelolaan Inventory Gudang
        $stmtProj->execute([
            $catTugasId,
            'Sistem Pengelolaan Inventory Gudang Toko',
            'sistem-pengelolaan-inventory-gudang-toko',
            'Aplikasi web manajemen stok barang masuk, barang keluar, dan notifikasi stok kritis untuk minimarket lokal.',
            'Tugas kuliah mata kuliah Pemrograman Web lanjut: minimarket lokal sering mengalami penumpukan barang expired atau kekurangan stok akibat tidak adanya monitoring real-time.',
            'Menyediakan sistem monitoring persediaan stok gudang secara real-time demi memudahkan staf gudang melakukan restock barang tepat waktu.',
            'Membangun CMS inventory berbasis PHP Native & MySQL dengan fitur peringatan (alert) visual ketika stok barang berada di bawah batas minimum.',
            'Developer Tunggal (Fullstack). Merancang database, menulis fungsionalitas CRUD barang beserta kategorinya, dan mengimplementasikan sistem enkripsi password session login.',
            'Analisis kasus, perancangan mock-up UI, pembuatan tabel database, koding login handler & middleware, koding fitur penyesuaian stok, serta demo di depan dosen pengampu.',
            'Manajemen Stok Masuk/Keluar, Filter Kategori Barang, Alerts Stok Kritis, Riwayat Transaksi Barang, Laporan Mutasi Barang.',
            'Mendapatkan nilai A pada tugas besar kuliah, dan sistem disimulasikan sukses menangani mutasi 500+ data produk tanpa kendala beban server.',
            'placeholder_gudang.png',
            '2024-09-15',
            '2024-12-10',
            'Selesai',
            null,
            'https://github.com/ikhsan-dev/inventory-gudang',
            1, // Featured
            3  // Order
        ]);
        $projGudangId = $db->lastInsertId();

        // 6. Seed Project Technologies (Many-to-Many Bridge)
        info("Linking projects with technologies...");
        $db->exec("TRUNCATE TABLE `project_technologies`");
        $stmtProjTech = $db->prepare("INSERT INTO `project_technologies` (`project_id`, `technology_id`) VALUES (?, ?)");
        
        // Bumdes: PHP Native (1), MySQL (2), Tailwind CSS (3), JavaScript (4), Git (6)
        $stmtProjTech->execute([$projBumdesId, 1]);
        $stmtProjTech->execute([$projBumdesId, 2]);
        $stmtProjTech->execute([$projBumdesId, 3]);
        $stmtProjTech->execute([$projBumdesId, 4]);
        $stmtProjTech->execute([$projBumdesId, 6]);

        // Wisata: PHP Native (1), MySQL (2), Bootstrap (7), Git (6)
        $stmtProjTech->execute([$projWisataId, 1]);
        $stmtProjTech->execute([$projWisataId, 2]);
        $stmtProjTech->execute([$projWisataId, 7]);
        $stmtProjTech->execute([$projWisataId, 6]);

        // Gudang: PHP Native (1), MySQL (2), Tailwind CSS (3), Git (6)
        $stmtProjTech->execute([$projGudangId, 1]);
        $stmtProjTech->execute([$projGudangId, 2]);
        $stmtProjTech->execute([$projGudangId, 3]);
        $stmtProjTech->execute([$projGudangId, 6]);

        // 7. Seed Project Media (Multi-Photo)
        info("Seeding data project_media...");
        $db->exec("SET FOREIGN_KEY_CHECKS = 0; TRUNCATE TABLE `project_media`; SET FOREIGN_KEY_CHECKS = 1;");
        $stmtMedia = $db->prepare("
            INSERT INTO `project_media` 
            (`project_id`, `media_type`, `file_path`, `title`, `description`, `alt_text`, `sort_order`, `is_active`) 
            VALUES (?, 'image', ?, ?, ?, ?, ?, 1)
        ");

        // Bumdes Media
        $stmtMedia->execute([
            $projBumdesId,
            'placeholder_bumdes_dashboard.png',
            'Halaman Dashboard Keuangan',
            'Menampilkan grafik statistik kas masuk dan keluar harian serta laporan saldo akhir kas secara real-time.',
            'Tampilan dashboard utama sistem BUMDes',
            1
        ]);
        $stmtMedia->execute([
            $projBumdesId,
            'placeholder_bumdes_transaksi.png',
            'Form Pencatatan Transaksi Baru',
            'Alur staf memasukkan data kas masuk/keluar lengkap dengan nomor bukti, tanggal, dan alokasi pos anggaran kas.',
            'Halaman input transaksi kas BUMDes',
            2
        ]);
        $stmtMedia->execute([
            $projBumdesId,
            'placeholder_bumdes_kkn.png',
            'Sosialisasi Penggunaan Sistem',
            'Momen tim KKN mendampingi perangkat desa dalam pelatihan input pembukuan dan pembacaan neraca digital.',
            'Dokumentasi pelatihan KKN di kantor desa',
            3
        ]);

        // Gudang Media
        $stmtMedia->execute([
            $projGudangId,
            'placeholder_gudang_monitoring.png',
            'Daftar Stok Produk Kritis',
            'Fitur pemantauan otomatis yang mendeteksi stok barang di bawah 10 unit dengan indikator warna merah cerah.',
            'Tampilan tabel persediaan kritis',
            1
        ]);

        // 8. Seed Educations
        info("Seeding data educations...");
        $db->exec("TRUNCATE TABLE `educations`");
        $stmtEdu = $db->prepare("
            INSERT INTO `educations` (`institution_name`, `study_program`, `degree`, `start_year`, `end_year`, `description`, `logo`, `sort_order`, `is_active`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1)
        ");
        $stmtEdu->execute([
            'Politeknik Negeri Bandung',
            'D3 Manajemen Informatika',
            'A.Md.Kom (Calon)',
            2023,
            2026,
            'Berfokus pada pengembangan sistem informasi, basis data, rekayasa perangkat lunak, dan keamanan sistem komputer. IPK berjalan: 3.82 / 4.00.',
            'logo_polban.png',
            1
        ]);

        // 9. Seed Settings
        info("Seeding data settings...");
        $db->exec("TRUNCATE TABLE `settings`");
        $stmtSet = $db->prepare("INSERT INTO `settings` (`key`, `value`, `type`) VALUES (?, ?, ?)");
        
        $stmtSet->execute(['website_name', 'M. Ikhsanul Karim - Portofolio', 'text']);
        $stmtSet->execute(['meta_title', 'M. Ikhsanul Karim | Backend Developer Intern Portfolio', 'text']);
        $stmtSet->execute(['meta_description', 'Website portofolio resmi M. Ikhsanul Karim, mahasiswa D3 Manajemen Informatika yang siap magang sebagai Backend Web Developer.', 'textarea']);
        $stmtSet->execute(['footer_text', 'M. Ikhsanul Karim. Dibuat menggunakan Native PHP, MySQL & Tailwind CSS.', 'text']);
        $stmtSet->execute(['primary_color', 'blue', 'text']); // Default accent color options: blue, indigo, slate
        
        // 10. Seed Messages
        info("Seeding data messages...");
        $db->exec("TRUNCATE TABLE `messages`");
        $stmtMsg = $db->prepare("
            INSERT INTO `messages` (`name`, `email`, `subject`, `message`, `status`, `ip_address`, `user_agent`) 
            VALUES (?, ?, ?, ?, ?, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/115.0.0.0')
        ");
        
        $stmtMsg->execute([
            'Adrian Hartanto', 
            'adrian@agency.com', 
            'Tawaran Magang - Backend Developer', 
            'Halo Ikhsan, kami tertarik dengan portofolio Anda dan ingin menawarkan posisi magang Backend Developer di agensi kami untuk periode semester depan.', 
            'unread'
        ]);
        
        $stmtMsg->execute([
            'Ahmad Fauzi', 
            'ahmad@fauzi.com', 
            'Tanya Proyek BUMDes', 
            'Halo, saya sedang melihat detail proyek digitalisasi BUMDes milik Anda di KKN. Apakah website tersebut menggunakan arsitektur OOP MVC murni? Sangat rapi dan terstruktur!', 
            'unread'
        ]);
        
        $stmtMsg->execute([
            'Rian Hidayat', 
            'rian@startup.co.id', 
            'Kerjasama Pengembangan Website', 
            'Kami butuh bantuan mahasiswa D3 Manajemen Informatika untuk proyek pembuatan landing page statis selama 3 bulan ke depan. Jika berminat, hubungi saya balik.', 
            'read'
        ]);

        info("Seeding database selesai sukses!");

    } catch (PDOException $e) {
        error("Kegagalan Seeding: " . $e->getMessage());
        exit(1);
    }
}

/**
 * CLI command to interactively create a new administrator account.
 */
function createAdmin(): void
{
    info("Memulai pembuatan akun administrator...");
    
    // Read input interactively
    echo "Masukkan Nama Lengkap: ";
    $name = trim(fgets(STDIN));
    
    echo "Masukkan Email / Username: ";
    $email = trim(fgets(STDIN));
    
    // Simple email validation
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        error("Email tidak valid.");
        exit(1);
    }

    echo "Masukkan Password: ";
    // Read password securely if possible, otherwise simple text read
    // On Windows standard PHP fgets(STDIN) is fully sufficient for terminal setup
    $password = rtrim(fgets(STDIN) ?: '', "\r\n");

    if (!\App\Services\PasswordPolicy::valid($password)) {
        error("Password harus minimal 12 karakter Unicode, maksimal 72 byte, tanpa karakter NUL.");
        exit(1);
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    try {
        $db = Database::getConnection();
        
        // Check if admin already exists
        $checkStmt = $db->prepare("SELECT id FROM `admins` WHERE `email` = ?");
        $checkStmt->execute([$email]);
        if ($checkStmt->fetch()) {
            error("Admin dengan email '{$email}' sudah terdaftar.");
            exit(1);
        }

        $stmt = $db->prepare("INSERT INTO `admins` (`name`, `email`, `password`) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $hashedPassword]);
        
        info("Akun admin '{$email}' berhasil didaftarkan!");
    } catch (PDOException $e) {
        error("Gagal menambahkan admin: " . $e->getMessage());
        exit(1);
    }
}

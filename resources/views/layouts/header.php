<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Portofolio Mahasiswa') ?></title>
    <meta name="description" content="<?= e($settings['meta_description'] ?? 'Website portofolio resmi M. Ikhsanul Karim, mahasiswa D3 Manajemen Informatika.') ?>">
    
    <!-- Fonts: Inter & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- GLightbox CDN (only loaded when needed, but we can put it in header to be safe) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">
    
    <style>
        .active-nav-link {
            color: #2563eb;
            font-weight: 700;
            border-bottom: 2px solid #2563eb;
        }
    </style>
</head>
<body class="bg-slate-50 font-sans text-slate-700 min-h-screen flex flex-col antialiased selection:bg-blue-600 selection:text-white">

    <!-- Header / Sticky Navbar -->
    <header id="main-header" class="fixed top-0 left-0 right-0 z-40 bg-white/80 backdrop-blur-md border-b border-slate-200 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 md:h-20 transition-all duration-300" id="navbar-container">
                
                <!-- Logo -->
                <a href="/" class="flex items-center gap-2 group">
                    <div class="w-9 h-9 rounded-lg bg-blue-600 flex items-center justify-center text-white font-bold font-heading shadow-md group-hover:scale-105 transition-transform">
                        IK
                    </div>
                    <span class="font-heading font-extrabold text-lg text-slate-800 tracking-tight group-hover:text-blue-600 transition-colors">
                        Ikhsan<span class="text-blue-600 group-hover:text-slate-800">.</span>
                    </span>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center gap-8 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                    <a href="/#home" class="nav-link py-2 hover:text-blue-600 transition-colors">Beranda</a>
                    <a href="/#tentang" class="nav-link py-2 hover:text-blue-600 transition-colors">Tentang</a>
                    <a href="/#keahlian" class="nav-link py-2 hover:text-blue-600 transition-colors">Keahlian</a>
                    <a href="/#pendidikan" class="nav-link py-2 hover:text-blue-600 transition-colors">Studi</a>
                    <a href="/#proyek" class="nav-link py-2 hover:text-blue-600 transition-colors">Proyek</a>
                    <a href="/#kontak" class="nav-link py-2 hover:text-blue-600 transition-colors">Kontak</a>
                </nav>

                <!-- Desktop CTA Actions -->
                <div class="hidden md:flex items-center gap-3">
                    <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true): ?>
                        <a href="/admin/dashboard" class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow transition-all focus:outline-none">
                            <i data-lucide="layout-dashboard" class="w-3.5 h-3.5"></i> Panel Admin
                        </a>
                    <?php else: ?>
                        <a href="/admin/login" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-slate-600 hover:text-slate-900 border border-slate-300 rounded-lg hover:bg-slate-100 transition-colors">
                            <i data-lucide="lock" class="w-3.5 h-3.5"></i> Login Admin
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Mobile Hamburger Menu Button -->
                <div class="flex items-center md:hidden">
                    <button type="button" onclick="toggleMobileMenu()" class="p-2 rounded-md text-slate-600 hover:text-blue-600 focus:outline-none" aria-label="Menu Utama">
                        <i data-lucide="menu" class="w-6 h-6" id="menu-icon"></i>
                    </button>
                </div>

            </div>
        </div>

        <!-- Mobile Drawer Menu -->
        <div class="hidden md:hidden bg-white border-t border-slate-100 px-4 py-4 space-y-3" id="mobile-menu">
            <a href="/#home" onclick="toggleMobileMenu()" class="block px-3 py-2 rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50 hover:text-blue-600 transition-colors">Beranda</a>
            <a href="/#tentang" onclick="toggleMobileMenu()" class="block px-3 py-2 rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50 hover:text-blue-600 transition-colors">Tentang</a>
            <a href="/#keahlian" onclick="toggleMobileMenu()" class="block px-3 py-2 rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50 hover:text-blue-600 transition-colors">Keahlian</a>
            <a href="/#pendidikan" onclick="toggleMobileMenu()" class="block px-3 py-2 rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50 hover:text-blue-600 transition-colors">Studi</a>
            <a href="/#proyek" onclick="toggleMobileMenu()" class="block px-3 py-2 rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50 hover:text-blue-600 transition-colors">Proyek</a>
            <a href="/#kontak" onclick="toggleMobileMenu()" class="block px-3 py-2 rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50 hover:text-blue-600 transition-colors">Kontak</a>
            
            <div class="pt-4 border-t border-slate-100">
                <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true): ?>
                    <a href="/admin/dashboard" onclick="toggleMobileMenu()" class="flex items-center justify-center gap-1.5 w-full py-2.5 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm">
                        <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Panel Admin
                    </a>
                <?php else: ?>
                    <a href="/admin/login" onclick="toggleMobileMenu()" class="flex items-center justify-center gap-1.5 w-full py-2.5 text-xs font-bold text-slate-700 bg-slate-50 border border-slate-200 rounded-lg">
                        <i data-lucide="lock" class="w-4 h-4"></i> Login Admin
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <main class="flex-grow pt-16 md:pt-20">

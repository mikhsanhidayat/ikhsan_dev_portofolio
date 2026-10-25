<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? e($title) . ' | CMS Admin Portofolio' : 'CMS Admin Portofolio' ?></title>
    
    <!-- Google Fonts: Inter & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS (CDN for CMS) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="h-full font-sans text-slate-800 flex overflow-hidden">

    <!-- Wrapper -->
    <div class="flex flex-1 w-full overflow-hidden">
        
        <!-- Sidebar (Desktop) -->
        <aside id="admin-sidebar" class="hidden md:flex flex-col w-64 bg-slate-900 text-slate-300 border-r border-slate-800 transition-all duration-300">
            <!-- Sidebar Header -->
            <div class="h-16 flex items-center justify-between px-6 border-b border-slate-800 bg-slate-950">
                <span class="text-sm font-extrabold tracking-wider font-heading text-white">CMS ADMIN</span>
                <span class="text-[10px] bg-slate-800 text-slate-300 py-0.5 px-2 rounded-full border border-slate-700">MVP v1.0</span>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 overflow-y-auto px-4 py-4 space-y-1">
                <a href="/admin/dashboard" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg hover:bg-slate-800 hover:text-white transition-colors">
                    <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Dashboard
                </a>
                
                <div class="pt-4 pb-2">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest px-3">Data Portofolio</p>
                </div>
                
                <a href="/admin/profile" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg hover:bg-slate-800 hover:text-white transition-colors">
                    <i data-lucide="user" class="w-4 h-4"></i> Manajemen Profil
                </a>
                <a href="/admin/skills" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg hover:bg-slate-800 hover:text-white transition-colors">
                    <i data-lucide="award" class="w-4 h-4"></i> Manajemen Keahlian
                </a>
                <a href="/admin/projects" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg hover:bg-slate-800 hover:text-white transition-colors">
                    <i data-lucide="folder-git-2" class="w-4 h-4"></i> Manajemen Proyek
                </a>
                <a href="/admin/education" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg hover:bg-slate-800 hover:text-white transition-colors">
                    <i data-lucide="graduation-cap" class="w-4 h-4"></i> Pendidikan
                </a>
                <a href="/admin/experience" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg hover:bg-slate-800 hover:text-white transition-colors">
                    <i data-lucide="briefcase" class="w-4 h-4"></i> Pengalaman (Opsional)
                </a>
                <a href="/admin/cv" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg hover:bg-slate-800 hover:text-white transition-colors">
                    <i data-lucide="file-text" class="w-4 h-4"></i> Manajemen CV
                </a>
                
                <div class="pt-4 pb-2">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest px-3">Kontak & Pesan</p>
                </div>
                
                <a href="/admin/messages" class="flex items-center justify-between px-3 py-2 text-sm font-medium rounded-lg hover:bg-slate-800 hover:text-white transition-colors">
                    <span class="flex items-center gap-3">
                        <i data-lucide="mail" class="w-4 h-4"></i> Pesan Masuk
                    </span>
                    <!-- Unread badge (will be dynamic) -->
                    <span id="unread-badge" class="hidden text-xs bg-red-600 text-white font-bold px-2 py-0.5 rounded-full">0</span>
                </a>
                
                <div class="pt-4 pb-2 border-t border-slate-800 mt-4">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest px-3">Sistem</p>
                </div>
                
                <a href="/admin/settings" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg hover:bg-slate-800 hover:text-white transition-colors">
                    <i data-lucide="settings" class="w-4 h-4"></i> Pengaturan Website
                </a>
            </nav>

            <!-- Sidebar Footer -->
            <div class="p-4 border-t border-slate-800 bg-slate-950">
                <form action="/admin/logout" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin keluar?');">
                    <?= csrf_field() ?>
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold text-red-400 hover:text-white hover:bg-red-900/30 rounded-lg border border-red-900/30 transition-colors">
                        <i data-lucide="log-out" class="w-4 h-4"></i> Keluar
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex flex-col flex-1 overflow-hidden">
            
            <!-- Topbar -->
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 z-10 shadow-sm">
                <!-- Left: Toggle Sidebar Mobile -->
                <div class="flex items-center gap-4">
                    <button id="mobile-sidebar-toggle" class="p-1 rounded-lg text-slate-500 hover:bg-slate-100 md:hidden focus:outline-none">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                    <!-- Page Title / Breadcrumb -->
                    <h1 class="text-lg font-bold font-heading text-slate-800"><?= e($title ?? 'Admin Dashboard') ?></h1>
                </div>
                
                <!-- Right: Profile Info -->
                <div class="flex items-center gap-4">
                    <a href="<?= route('/') ?>" target="_blank" class="hidden sm:inline-flex items-center gap-2 px-3 py-1.5 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors">
                        <i data-lucide="external-link" class="w-3.5 h-3.5"></i> Lihat Website
                    </a>
                    
                    <div class="flex items-center gap-2 border-l border-slate-200 pl-4">
                        <div class="text-right hidden sm:block">
                            <p class="text-xs font-bold text-slate-700"><?= e($_SESSION['admin_name'] ?? 'Admin') ?></p>
                            <p class="text-[10px] text-slate-400 font-medium"><?= e($_SESSION['admin_email'] ?? 'admin@example.com') ?></p>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-slate-300 flex items-center justify-center font-bold text-slate-600 border border-slate-400">
                            <?= strtoupper(substr($_SESSION['admin_name'] ?? 'A', 0, 1)) ?>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Pane -->
            <main class="flex-1 overflow-y-auto p-6 bg-slate-50">
                <!-- Flash Messages -->
                <?php if (session_has_flash('success')): ?>
                    <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 text-green-700 flex items-center gap-3 text-sm shadow-sm">
                        <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
                        <span><?= e(session_flash('success')) ?></span>
                    </div>
                <?php endif; ?>

                <?php if (session_has_flash('error')): ?>
                    <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 text-red-700 flex items-center gap-3 text-sm shadow-sm">
                        <i data-lucide="alert-circle" class="w-5 h-5 text-red-600"></i>
                        <span><?= e(session_flash('error')) ?></span>
                    </div>
                <?php endif; ?>

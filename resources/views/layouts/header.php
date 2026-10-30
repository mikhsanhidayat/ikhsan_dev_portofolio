<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <?php
    $metaTitle = $title ?? 'Muhamad Ikhsan Hidayat | Fullstack Developer Portfolio';
    $metaDescription = $settings['meta_description'] ?? 'Portofolio Muhamad Ikhsan Hidayat, Fullstack Developer lulusan D3 Manajemen Informatika yang berpengalaman membangun aplikasi web dengan Laravel, PHP, dan MySQL.';
    ?>
    <title><?= e($metaTitle) ?></title>
    <meta name="description" content="<?= e($metaDescription) ?>">
    <meta property="og:title" content="<?= e($metaTitle) ?>">
    <meta property="og:description" content="<?= e($metaDescription) ?>">
    <meta name="twitter:title" content="<?= e($metaTitle) ?>">
    <meta name="twitter:description" content="<?= e($metaDescription) ?>">
    
    <!-- Google Fonts: Space Grotesk, Fraunces (Retro Serif), JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400..900;1,9..144,400..900&family=JetBrains+Mono:ital,wght@0,400..800;1,400..800&family=Space+Grotesk:wght@400;500;700&display=swap" rel="stylesheet">
    
    <!-- Phosphor Icons: Script & CSS Stylesheets -->
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/@phosphor-icons/web@2.1.1/src/bold/style.css">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/@phosphor-icons/web@2.1.1/src/fill/style.css">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/@phosphor-icons/web@2.1.1/src/regular/style.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    
    <!-- Lucide Icons CDN (Fallback support) -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Space Grotesk', 'sans-serif'],
                        serif: ['Fraunces', 'serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                    colors: {
                        retro: {
                            bg: 'var(--bg-color)',
                            card: 'var(--card-color)',
                            text: 'var(--text-color)',
                            accent: 'var(--accent-color)',
                            secondary: 'var(--secondary-color)',
                            border: 'var(--border-color)'
                        }
                    }
                }
            }
        }
    </script>

    <style>
        :root {
            --bg-color: #F4EFE6;
            --card-color: #FFFDF9;
            --text-color: #1C1B18;
            --accent-color: #FF5A36;
            --secondary-color: #E6DEC8;
            --border-color: #1C1B18;
        }

        [data-theme="matcha"] {
            --bg-color: #E8EFE6;
            --card-color: #F9FBF9;
            --text-color: #162619;
            --accent-color: #3B7A57;
            --secondary-color: #D2E0CE;
            --border-color: #162619;
        }

        [data-theme="cyber95"] {
            --bg-color: #16161A;
            --card-color: #242629;
            --text-color: #FFFFFE;
            --accent-color: #7F5AF0;
            --secondary-color: #2CB67D;
            --border-color: #FFFFFE;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            transition: background-color 0.4s ease, color 0.4s ease;
            overflow-x: clip;
        }

        html {
            scroll-padding-top: calc(var(--public-header-height, 10rem) + 1rem);
        }

        main section[id] {
            scroll-margin-top: 0;
        }

        #public-header {
            position: sticky;
            top: 0;
            z-index: 50;
            background-color: var(--bg-color);
        }

        #public-header > header {
            position: relative;
        }

        #mobile-menu {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            margin-top: 0;
            max-height: calc(100vh - var(--public-header-height, 10rem) - 1rem);
            max-height: calc(100dvh - var(--public-header-height, 10rem) - 1rem);
            overflow-y: auto;
            overscroll-behavior: contain;
        }

        /* Subtle Dot Grid Background */
        .bg-grid {
            background-image: radial-gradient(var(--border-color) 1px, transparent 1px);
            background-size: 24px 24px;
            background-position: -1px -1px;
        }

        /* Retro Brutalist Shadow & Borders */
        .retro-border {
            border: 2px solid var(--border-color);
        }

        .retro-shadow {
            box-shadow: 5px 5px 0px var(--border-color);
            transition: all 0.2s cubic-bezier(0.25, 1, 0.5, 1);
        }

        .retro-shadow-sm {
            box-shadow: 3px 3px 0px var(--border-color);
            transition: all 0.2s cubic-bezier(0.25, 1, 0.5, 1);
        }

        .retro-shadow-hover:hover {
            transform: translate(-3px, -3px);
            box-shadow: 8px 8px 0px var(--border-color);
        }

        .retro-btn:active {
            transform: translate(3px, 3px);
            box-shadow: 0px 0px 0px var(--border-color);
        }

        /* Film Grain Overlay */
        .noise-overlay {
            position: fixed;
            top: 0; left: 0; width: 100vw; height: 100vh;
            pointer-events: none;
            z-index: 9999;
            opacity: 0.035;
            background: url('data:image/svg+xml;utf8,%3Csvg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg"%3E%3Cfilter id="noiseFilter"%3E%3CfeTurbulence type="fractalNoise" baseFrequency="0.8" numOctaves="3" stitchTiles="stitch"/%3E%3C/filter%3E%3Crect width="100%25" height="100%25" filter="url(%23noiseFilter)"/%3E%3C/svg%3E');
        }

        /* Marquee Animation */
        @keyframes marquee {
            0% { transform: translateX(0%); }
            100% { transform: translateX(-50%); }
        }
        .animate-marquee {
            display: flex;
            width: max-content;
            animation: marquee 24s linear infinite;
        }
        .animate-marquee:hover {
            animation-play-state: paused;
        }

        /* Vinyl Spin Animation */
        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .spin-vinyl {
            animation: spin-slow 6s linear infinite;
            animation-play-state: paused;
        }
        .spin-vinyl.playing {
            animation-play-state: running;
        }

        /* Unified Retro In-Out Animation Engine */
        .retro-reveal {
            opacity: 0;
            transform: translateY(32px) scale(0.97);
            transition: opacity 0.65s cubic-bezier(0.22, 1, 0.36, 1), transform 0.65s cubic-bezier(0.22, 1, 0.36, 1);
            will-change: opacity, transform;
        }
        .retro-reveal.is-visible {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
        .retro-reveal.is-exited-up {
            opacity: 0.15;
            transform: translateY(-20px) scale(0.98);
        }
        .stagger-1 { transition-delay: 80ms; }
        .stagger-2 { transition-delay: 160ms; }
        .stagger-3 { transition-delay: 240ms; }
        .stagger-4 { transition-delay: 320ms; }
        .stagger-5 { transition-delay: 400ms; }

        /* Navbar Active Indicator (ScrollSpy) */
        .nav-link-retro {
            position: relative;
            transition: all 0.25s cubic-bezier(0.22, 1, 0.36, 1);
            border-radius: 0.5rem;
            padding: 0.25rem 0.65rem;
        }
        .nav-link-retro.is-active {
            background-color: var(--accent-color);
            color: #ffffff !important;
            box-shadow: 2px 2px 0px var(--border-color);
            font-weight: 700;
        }

        /* Smooth Filter Animation on Project Cards */
        .project-card {
            transition: opacity 0.22s cubic-bezier(0.22, 1, 0.36, 1), transform 0.22s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.2s cubic-bezier(0.25, 1, 0.5, 1);
        }

        @media (prefers-reduced-motion: reduce) {
            .retro-reveal {
                opacity: 1 !important;
                transform: none !important;
                transition: none !important;
            }
        }

        /* Custom Cursor (Desktop Only) */
        @media (pointer: fine) {
            .custom-cursor {
                width: 20px;
                height: 20px;
                border: 2px solid var(--border-color);
                background-color: var(--accent-color);
                border-radius: 50%;
                position: fixed;
                pointer-events: none;
                z-index: 10000;
                transform: translate(-50%, -50%);
                transition: width 0.2s, height 0.2s, background-color 0.2s, transform 0.08s ease-out;
                mix-blend-mode: normal;
            }
            .custom-cursor.hovered {
                width: 44px;
                height: 44px;
                background-color: transparent;
                border-width: 2px;
                border-style: dashed;
            }
        }
    </style>

    <!-- Pre-load theme from localStorage immediately -->
    <script>
        (function() {
            try {
                const savedTheme = localStorage.getItem('ikhsan_retro_theme');
                if (savedTheme && savedTheme !== 'default') {
                    document.documentElement.setAttribute('data-theme', savedTheme);
                }
            } catch (e) {}
        })();
    </script>
</head>
<body class="font-sans antialiased selection:bg-retro-accent selection:text-white">

    <!-- Noise Overlay -->
    <div class="noise-overlay" aria-hidden="true"></div>

    <!-- Custom Cursor (Desktop Only) -->
    <div id="cursor" class="custom-cursor hidden md:block" aria-hidden="true"></div>

    <!-- Top OS Status Bar -->
    <div id="public-header">
    <div class="w-full retro-border border-t-0 border-x-0 bg-retro-secondary px-4 py-1.5 text-xs font-mono flex flex-wrap justify-between items-center gap-2">
        <div class="flex items-center gap-2">
            <span class="inline-block w-2.5 h-2.5 rounded-full bg-green-500 border border-retro-border animate-pulse"></span>
            <span class="font-bold tracking-tight">IKHSAN_OS v2.6</span>
            <span class="hidden sm:inline text-retro-text/75">| TASIKMALAYA, ID ✦ TERSEDIA UNTUK FULLSTACK &amp; WEB DEV</span>
        </div>
        <div class="flex items-center gap-4">
            <!-- Theme Switcher -->
            <div class="flex items-center gap-1.5" role="group" aria-label="Pemilih Tema">
                <span class="hidden md:inline font-bold">TEMA:</span>
                <button type="button" onclick="setTheme('default')" title="Classic Cream" aria-label="Tema Classic Cream" class="w-4 h-4 rounded-full bg-[#FF5A36] border border-black hover:scale-125 transition-transform"></button>
                <button type="button" onclick="setTheme('matcha')" title="Retro Matcha" aria-label="Tema Retro Matcha" class="w-4 h-4 rounded-full bg-[#3B7A57] border border-black hover:scale-125 transition-transform"></button>
                <button type="button" onclick="setTheme('cyber95')" title="Cyber 95 Dark" aria-label="Tema Cyber 95 Dark" class="w-4 h-4 rounded-full bg-[#7F5AF0] border border-white hover:scale-125 transition-transform"></button>
            </div>
            <span id="live-clock" class="font-bold">00:00:00 WIB</span>
        </div>
    </div>

    <!-- Navigation Header -->
    <header class="max-w-[1380px] w-[92%] mx-auto pt-5 pb-3">
        <nav class="bg-retro-card retro-border retro-shadow rounded-xl px-4 sm:px-6 py-3 flex justify-between items-center">
            
            <!-- Logo -->
            <a href="/#beranda" class="font-serif font-black text-xl sm:text-2xl tracking-tight flex items-center gap-2 group">
                <span class="w-8 h-8 rounded-lg bg-retro-accent text-white retro-border flex items-center justify-center font-mono text-base group-hover:rotate-12 transition-transform shadow-xs">IK</span>
                <span>Ikhsan<span class="text-retro-accent">.dev</span></span>
            </a>

            <!-- Desktop Menu -->
            <div class="hidden lg:flex items-center gap-3 xl:gap-4 font-mono text-xs sm:text-sm">
                <a href="/#beranda" class="nav-link-retro hover:text-retro-accent transition-all" data-target="beranda">Beranda</a>
                <a href="/#tentang" class="nav-link-retro hover:text-retro-accent transition-all" data-target="tentang">Tentang</a>
                <a href="/#keahlian" class="nav-link-retro hover:text-retro-accent transition-all" data-target="keahlian">Keahlian</a>
                <a href="/#studi" class="nav-link-retro hover:text-retro-accent transition-all" data-target="studi">Studi</a>
                <a href="/#proyek" class="nav-link-retro hover:text-retro-accent transition-all" data-target="proyek">Proyek</a>
                <a href="/#kontak" class="nav-link-retro hover:text-retro-accent transition-all" data-target="kontak">Kontak</a>
            </div>

            <div class="flex lg:hidden items-center gap-2.5">
                <!-- Mobile Menu Button (Retro Boxed Button) -->
                <button id="mobile-menu-btn" type="button" class="lg:hidden w-10 h-10 rounded-xl bg-retro-secondary hover:bg-retro-accent hover:text-white retro-border retro-shadow-sm flex items-center justify-center text-xl transition-all active:translate-x-0.5 active:translate-y-0.5 cursor-pointer" aria-label="Buka Menu Navigasi" aria-expanded="false">
                    <i id="mobile-menu-icon" class="ph-bold ph-list"></i>
                </button>
            </div>
        </nav>

        <!-- Mobile Drawer / Dropdown Window (OS Window Style) -->
        <div id="mobile-menu" class="hidden lg:hidden mt-3 bg-retro-card retro-border retro-shadow rounded-2xl overflow-hidden font-mono text-xs sm:text-sm flex-col">
            <!-- OS Title Bar -->
            <div class="bg-retro-secondary border-b-2 border-retro-border px-4 py-2.5 flex items-center justify-between font-bold">
                <div class="flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#FF5F56] border border-black inline-block"></span>
                    <span class="w-2.5 h-2.5 rounded-full bg-[#FFBD2E] border border-black inline-block"></span>
                    <span class="w-2.5 h-2.5 rounded-full bg-[#27C93F] border border-black inline-block"></span>
                    <span class="ml-2 text-retro-text text-xs tracking-wider">NAV_DRAWER.SYS</span>
                </div>
                <span class="text-[10px] bg-retro-card px-2 py-0.5 rounded border border-retro-border text-retro-accent font-bold">READY</span>
            </div>

            <!-- Drawer Links -->
            <div class="p-3 space-y-1 bg-retro-card">
                <a href="/#beranda" class="nav-link-retro mobile-link py-2.5 px-3 rounded-lg border border-transparent hover:border-retro-border hover:bg-retro-secondary flex items-center justify-between font-bold text-retro-text transition-colors" data-target="beranda">
                    <span>Beranda</span>
                    <i class="ph-bold ph-caret-right text-xs"></i>
                </a>
                <a href="/#tentang" class="nav-link-retro mobile-link py-2.5 px-3 rounded-lg border border-transparent hover:border-retro-border hover:bg-retro-secondary flex items-center justify-between font-bold text-retro-text transition-colors" data-target="tentang">
                    <span>Tentang</span>
                    <i class="ph-bold ph-caret-right text-xs"></i>
                </a>
                <a href="/#keahlian" class="nav-link-retro mobile-link py-2.5 px-3 rounded-lg border border-transparent hover:border-retro-border hover:bg-retro-secondary flex items-center justify-between font-bold text-retro-text transition-colors" data-target="keahlian">
                    <span>Keahlian</span>
                    <i class="ph-bold ph-caret-right text-xs"></i>
                </a>
                <a href="/#studi" class="nav-link-retro mobile-link py-2.5 px-3 rounded-lg border border-transparent hover:border-retro-border hover:bg-retro-secondary flex items-center justify-between font-bold text-retro-text transition-colors" data-target="studi">
                    <span>Studi</span>
                    <i class="ph-bold ph-caret-right text-xs"></i>
                </a>
                <a href="/#proyek" class="nav-link-retro mobile-link py-2.5 px-3 rounded-lg border border-transparent hover:border-retro-border hover:bg-retro-secondary flex items-center justify-between font-bold text-retro-text transition-colors" data-target="proyek">
                    <span>Proyek</span>
                    <i class="ph-bold ph-caret-right text-xs"></i>
                </a>
                <a href="/#kontak" class="nav-link-retro mobile-link py-2.5 px-3 rounded-lg border border-transparent hover:border-retro-border hover:bg-retro-secondary flex items-center justify-between font-bold text-retro-text transition-colors" data-target="kontak">
                    <span>Kontak</span>
                    <i class="ph-bold ph-caret-right text-xs"></i>
                </a>
            </div>
        </div>
    </header>
    </div>

    <script>
        (function() {
            const publicHeader = document.getElementById('public-header');
            const updateHeaderHeight = () => {
                document.documentElement.style.setProperty('--public-header-height', `${publicHeader.getBoundingClientRect().height}px`);
            };
            updateHeaderHeight();
            if ('ResizeObserver' in window) {
                new ResizeObserver(updateHeaderHeight).observe(publicHeader);
            }
            window.addEventListener('resize', updateHeaderHeight);
            window.addEventListener('load', updateHeaderHeight);
            if (document.fonts) document.fonts.ready.then(updateHeaderHeight);
        })();
    </script>

    <!-- Main Content Container -->
    <main class="w-full">

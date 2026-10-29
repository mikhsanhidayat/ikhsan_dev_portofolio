<?php require dirname(__DIR__) . '/layouts/header.php'; ?>

<!-- ========================================================================= -->
<!-- SECTION 1: HERO / BERANDA (#beranda)                                     -->
<!-- Menggunakan max-w-[1380px] w-[92%] mx-auto agar mengisi layar dengan pas  -->
<!-- ========================================================================= -->
<div class="max-w-[1380px] w-[92%] mx-auto">
    <section id="beranda" class="pt-24 pb-10 scroll-mt-20">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
            
            <!-- Left Hero Content -->
            <div class="lg:col-span-7 space-y-6 retro-reveal stagger-1">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-retro-secondary retro-border font-mono text-xs md:text-sm">
                    <i class="ph-fill ph-sparkle text-retro-accent text-base"></i>
                    <span class="font-bold tracking-wider text-retro-text"><?= strtoupper(e($profile['headline'] ?? 'FULLSTACK DEVELOPER')) ?> &amp; SYSTEM ARCHITECT</span>
                </div>

                <h1 class="font-serif text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-black leading-[1.08] tracking-tight text-retro-text">
                    Halo, Saya <span class="bg-retro-accent text-white px-3.5 py-1 rounded-lg retro-border inline-block -rotate-1"><?= e($profile['full_name'] ?? 'M. Ikhsan Hidayat') ?></span>
                </h1>

                <!-- Teks Paragraf Utama: font-medium & text-retro-text pekat (tanpa opacity pudar) -->
                <p class="text-base md:text-lg text-retro-text max-w-2xl leading-relaxed font-sans font-medium">
                    <?= e($profile['short_bio'] ?? 'Saya adalah Fullstack Developer dengan latar belakang D3 Manajemen Informatika yang berfokus pada pengembangan aplikasi web, mulai dari antarmuka pengguna, backend, hingga pengelolaan database.') ?>
                </p>

                <!-- CTA Action Buttons -->
                <div class="flex flex-wrap items-center gap-4 pt-2">
                    <a href="#proyek" class="px-7 py-3.5 rounded-xl bg-retro-accent text-white font-mono font-bold text-sm md:text-base retro-border retro-shadow retro-shadow-hover retro-btn flex items-center gap-2 transition-all">
                        <span>Lihat Portofolio</span>
                        <i class="ph-bold ph-arrow-down-right text-lg"></i>
                    </a>
                    <a href="#kontak" class="px-7 py-3.5 rounded-xl bg-retro-card text-retro-text font-mono font-bold text-sm md:text-base retro-border retro-shadow retro-shadow-hover retro-btn flex items-center gap-2 transition-all">
                        <i class="ph-bold ph-terminal-window text-lg"></i>
                        <span>Hubungi Saya</span>
                    </a>
                </div>
            </div>

            <!-- Right Interactive Retro Window Card (PROFIL_IKHSAN.EXE) -->
            <div class="lg:col-span-5 retro-reveal stagger-2">
                <div id="hero-card" class="bg-retro-card retro-border retro-shadow rounded-2xl overflow-hidden transition-transform duration-200 ease-out">
                    
                    <!-- Window Title Bar -->
                    <div class="bg-retro-secondary border-b-2 border-retro-border px-4 py-2.5 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-[#FF5F56] border border-black inline-block"></span>
                            <span class="w-3 h-3 rounded-full bg-[#FFBD2E] border border-black inline-block"></span>
                            <span class="w-3 h-3 rounded-full bg-[#27C93F] border border-black inline-block"></span>
                        </div>
                        <span class="font-mono text-xs font-bold tracking-wider text-retro-text">PROFIL_IKHSAN.EXE</span>
                        <i class="ph-bold ph-arrows-out-simple text-xs"></i>
                    </div>

                    <!-- Window Body -->
                    <div class="p-6 space-y-5 bg-grid">
                        
                        <!-- Avatar & Profile Details -->
                        <div class="flex flex-col sm:flex-row items-center gap-5 bg-retro-card p-4 sm:p-5 rounded-xl retro-border">
                            <!-- Foto Asli M. Ikhsan Hidayat -->
                            <div class="relative w-28 h-28 rounded-xl bg-retro-secondary retro-border overflow-hidden shrink-0 flex items-center justify-center shadow-xs">
                                <?php if (!empty($profile['profile_photo'])): ?>
                                    <img src="/<?= ltrim($profile['profile_photo'], '/') ?>" 
                                         alt="<?= e($profile['full_name'] ?? 'M. Ikhsan Hidayat') ?>" 
                                         class="w-full h-full object-cover">
                                <?php else: ?>
                                    <i class="ph-bold ph-user text-5xl text-retro-text/60"></i>
                                <?php endif; ?>
                                <span class="absolute bottom-1 right-1 bg-green-400 text-black font-mono text-[10px] font-bold px-1.5 rounded border border-black">PRO</span>
                            </div>

                            <div class="space-y-1 text-center sm:text-left">
                                <div class="font-mono text-xs sm:text-sm text-retro-accent font-bold">@mikhsanhidayat</div>
                                <h2 class="font-serif font-bold text-xl text-retro-text"><?= e($profile['full_name'] ?? 'M. Ikhsan Hidayat') ?></h2>
                                <p class="font-mono text-xs sm:text-sm text-retro-text font-medium">📍 <?= e($profile['location'] ?? 'Tasikmalaya, ID') ?></p>
                                <div class="pt-2 flex flex-wrap justify-center sm:justify-start gap-1.5">
                                    <span class="px-2.5 py-1 text-xs font-mono bg-retro-secondary rounded border border-retro-border font-semibold text-retro-text">PHP Native</span>
                                    <span class="px-2.5 py-1 text-xs font-mono bg-retro-secondary rounded border border-retro-border font-semibold text-retro-text">Laravel</span>
                                    <span class="px-2.5 py-1 text-xs font-mono bg-retro-secondary rounded border border-retro-border font-semibold text-retro-text">MySQL</span>
                                </div>
                            </div>
                        </div>

                        <!-- Interactive Retro Vinyl Player (Web Audio API) -->
                        <div class="bg-retro-card p-4 rounded-xl retro-border flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3.5">
                                <div id="vinyl-disc" class="w-12 h-12 rounded-full bg-zinc-900 border-2 border-retro-border flex items-center justify-center spin-vinyl shrink-0 relative shadow-inner">
                                    <div class="w-4 h-4 rounded-full bg-retro-accent border border-white"></div>
                                    <div class="w-1.5 h-1.5 rounded-full bg-black absolute"></div>
                                </div>
                                <div>
                                    <div class="font-mono text-[11px] uppercase tracking-wider text-retro-text font-semibold">Lofi Synth Mix</div>
                                    <div id="track-status" class="font-bold text-xs sm:text-sm truncate max-w-[140px] sm:max-w-[180px] text-retro-text">8-Bit Coffee Shop</div>
                                </div>
                            </div>
                            <button id="play-music-btn" type="button" onclick="toggleRetroSound()" class="px-4 py-2 rounded-lg bg-retro-secondary hover:bg-retro-accent hover:text-white retro-border font-mono text-xs sm:text-sm font-bold flex items-center gap-1.5 transition-colors cursor-pointer shrink-0">
                                <i id="play-icon" class="ph-fill ph-play text-base"></i>
                                <span id="play-text">PLAY</span>
                            </button>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <!-- 4 Baris Kartu Statistik Hero (Angka 3xl-4xl & Teks Lebih Besar) -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 pt-8">
            <div class="bg-retro-card retro-border retro-shadow-sm rounded-xl p-4 sm:p-5 font-mono flex items-center gap-4 retro-reveal stagger-1">
                <span class="text-3xl md:text-4xl font-black text-retro-accent">4+</span>
                <div class="leading-tight">
                    <div class="text-sm font-semibold text-retro-text">Proyek Selesai</div>
                    <div class="text-xs font-medium text-retro-text/75">Pengembangan Web</div>
                </div>
            </div>
            <div class="bg-retro-card retro-border retro-shadow-sm rounded-xl p-4 sm:p-5 font-mono flex items-center gap-4 retro-reveal stagger-2">
                <span class="text-3xl md:text-4xl font-black text-retro-accent">3+</span>
                <div class="leading-tight">
                    <div class="text-sm font-semibold text-retro-text">Basis Data</div>
                    <div class="text-xs font-medium text-retro-text/75">MySQL &amp; Relasional</div>
                </div>
            </div>
            <div class="bg-retro-card retro-border retro-shadow-sm rounded-xl p-4 sm:p-5 font-mono flex items-center gap-4 retro-reveal stagger-3">
                <span class="text-3xl md:text-4xl font-black text-retro-accent">11+</span>
                <div class="leading-tight">
                    <div class="text-sm font-semibold text-retro-text">Kompetensi</div>
                    <div class="text-xs font-medium text-retro-text/75">Tools &amp; Framework</div>
                </div>
            </div>
            <div class="bg-retro-card retro-border retro-shadow-sm rounded-xl p-4 sm:p-5 font-mono flex items-center gap-4 retro-reveal stagger-4">
                <span class="text-3xl md:text-4xl font-black text-retro-accent">D3</span>
                <div class="leading-tight">
                    <div class="text-sm font-semibold text-retro-text">Manajemen Informatika</div>
                    <div class="text-xs font-medium text-retro-text/75">Politeknik LP3I</div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- ========================================================================= -->
<!-- 2. FULL-WIDTH MARQUEE BANNER (UJUNG KE UJUNG LAYAR)                       -->
<!-- Dikeluarkan dari container agar memanjang penuh 100% lebar viewport       -->
<!-- ========================================================================= -->
<div class="w-full border-y-2 border-retro-border bg-retro-secondary py-3.5 my-8 overflow-hidden" aria-hidden="true">
    <div class="animate-marquee font-mono text-sm md:text-base font-bold tracking-wider flex items-center gap-8 text-retro-text">
        <span>✦ FULLSTACK DEVELOPMENT</span>
        <span>✦ PHP NATIVE MVC</span>
        <span>✦ LARAVEL FRAMEWORK</span>
        <span>✦ MYSQL RELATIONAL DB</span>
        <span>✦ TAILWIND CSS</span>
        <span>✦ RESTFUL API ARCHITECTURE</span>
        <span>✦ CLEAN &amp; SECURE CODE</span>
        <!-- Duplicate for infinite seamless scroll -->
        <span>✦ FULLSTACK DEVELOPMENT</span>
        <span>✦ PHP NATIVE MVC</span>
        <span>✦ LARAVEL FRAMEWORK</span>
        <span>✦ MYSQL RELATIONAL DB</span>
        <span>✦ TAILWIND CSS</span>
        <span>✦ RESTFUL API ARCHITECTURE</span>
        <span>✦ CLEAN &amp; SECURE CODE</span>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MAIN SECTIONS CONTAINER (max-w-[1380px] w-[92%] mx-auto)                  -->
<!-- ========================================================================= -->
<div class="max-w-[1380px] w-[92%] mx-auto">

    <!-- ========================================================================= -->
    <!-- SECTION 2: TENTANG SAYA (#tentang)                                        -->
    <!-- ========================================================================= -->
    <section id="tentang" class="py-10 md:py-12 scroll-mt-20">
        
        <!-- Section Header -->
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 border-b-2 border-retro-border pb-4 mb-6 md:mb-8 retro-reveal">
            <div>
                <span class="font-mono text-xs md:text-sm uppercase tracking-widest text-retro-accent font-bold">// 01. TENTANG SAYA</span>
                <h2 class="font-serif text-3xl md:text-4xl font-black mt-1 text-retro-text">Sedikit Tentang Saya</h2>
            </div>
            <span class="font-mono text-xs md:text-sm bg-retro-card px-3.5 py-1.5 rounded-lg retro-border self-start sm:self-auto font-bold text-retro-text">
                SYS_INFO: FULLSTACK &amp; D3 MI
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
            
            <!-- Kolom Kiri: Narasi Diri (7 Kolom) -->
            <div class="lg:col-span-7 bg-retro-card retro-border retro-shadow rounded-2xl p-6 sm:p-8 space-y-6 flex flex-col justify-between retro-reveal stagger-1">
                <div class="space-y-4">
                    <h3 class="font-serif text-2xl md:text-3xl font-black leading-snug text-retro-text">
                        "Membangun aplikasi web yang fungsional, terstruktur rapi, dan memberikan solusi nyata."
                    </h3>
                    
                    <div class="text-base md:text-lg text-retro-text space-y-3.5 leading-relaxed font-sans font-medium">
                        <?php if (!empty($profile['about_text'])): ?>
                            <?php foreach (array_filter(explode("\n", (string) $profile['about_text'])) as $paragraph): ?>
                                <p><?= e(trim($paragraph)) ?></p>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>
                                Saya memiliki minat tinggi dalam pengembangan aplikasi web yang aman, efisien, dan mudah digunakan. Terbiasa menangani siklus pengembangan mulai dari rancangan database, logic backend berbasis PHP, hingga antarmuka responsif.
                            </p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Mini Core Values -->
                <div class="grid grid-cols-3 gap-4 pt-6 border-t-2 border-dashed border-retro-border/40 font-mono text-center sm:text-left">
                    <div>
                        <div class="text-2xl sm:text-3xl font-black text-retro-accent">100%</div>
                        <div class="text-xs sm:text-sm font-semibold text-retro-text">Dedikasi Solutif</div>
                    </div>
                    <div>
                        <div class="text-2xl sm:text-3xl font-black text-retro-accent">Clean</div>
                        <div class="text-xs sm:text-sm font-semibold text-retro-text">Struktur &amp; MVC</div>
                    </div>
                    <div>
                        <div class="text-2xl sm:text-3xl font-black text-retro-accent">Secure</div>
                        <div class="text-xs sm:text-sm font-semibold text-retro-text">PDO &amp; Sanitasi</div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: INFO_PERSONAL.DAT (5 Kolom) -->
            <div class="lg:col-span-5 bg-retro-card retro-border retro-shadow rounded-2xl p-6 sm:p-7 space-y-5 flex flex-col justify-between retro-reveal stagger-2">
                <div>
                    <!-- Diskette Window Header -->
                    <div class="flex items-center justify-between border-b-2 border-retro-border pb-3.5">
                        <span class="font-mono font-bold text-sm sm:text-base flex items-center gap-2 text-retro-text">
                            <i class="ph-fill ph-floppy-disk text-retro-accent text-xl"></i>
                            INFO_PERSONAL.DAT
                        </span>
                        <span class="font-mono text-xs font-semibold text-retro-text/75">1.44 MB</span>
                    </div>

                    <!-- Personal Information List (Font Lebih Besar text-sm md:text-base) -->
                    <div class="space-y-4 pt-4 font-mono text-sm md:text-base">
                        <div class="flex items-start gap-3">
                            <i class="ph-bold ph-map-pin text-xl text-retro-accent shrink-0 mt-0.5"></i>
                            <div>
                                <span class="font-bold block text-xs uppercase tracking-wider text-retro-text/80">LOKASI:</span>
                                <span class="text-retro-text font-medium"><?= e($profile['location'] ?? 'Tasikmalaya, Indonesia') ?></span>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <i class="ph-bold ph-envelope text-xl text-retro-accent shrink-0 mt-0.5"></i>
                            <div class="w-full">
                                <span class="font-bold block text-xs uppercase tracking-wider text-retro-text/80">EMAIL:</span>
                                <div class="flex items-center justify-between gap-2 mt-0.5">
                                    <span id="about-email-text" class="text-retro-text font-medium break-all select-all"><?= e($profile['email'] ?? 'ikhsanhidayatmuhamad@gmail.com') ?></span>
                                    <button type="button" onclick="copyPersonalEmail()" class="px-2.5 py-1 bg-retro-secondary hover:bg-retro-accent hover:text-white rounded border border-retro-border text-xs font-bold transition-colors shrink-0 cursor-pointer">
                                        <span id="about-copy-label">Salin</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <i class="ph-bold ph-whatsapp-logo text-xl text-retro-accent shrink-0 mt-0.5"></i>
                            <div>
                                <span class="font-bold block text-xs uppercase tracking-wider text-retro-text/80">WHATSAPP:</span>
                                <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $profile['whatsapp'] ?? '6282119491906') ?>" target="_blank" rel="noopener noreferrer" class="text-retro-accent hover:underline font-bold inline-flex items-center gap-1">
                                    <span><?= e($profile['whatsapp'] ?? '+6282119491906') ?></span>
                                    <i class="ph-bold ph-arrow-up-right text-sm"></i>
                                </a>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <i class="ph-bold ph-github-logo text-xl text-retro-accent shrink-0 mt-0.5"></i>
                            <div>
                                <span class="font-bold block text-xs uppercase tracking-wider text-retro-text/80">GITHUB:</span>
                                <a href="<?= e($profile['github_url'] ?? 'https://github.com/mikhsanhidayat') ?>" target="_blank" rel="noopener noreferrer" class="text-retro-accent hover:underline font-bold inline-flex items-center gap-1">
                                    <span>github.com/mikhsanhidayat</span>
                                    <i class="ph-bold ph-arrow-up-right text-sm"></i>
                                </a>
                            </div>
                        </div>

                        <?php if (!empty($profile['linkedin_url'])): ?>
                            <div class="flex items-start gap-3">
                                <i class="ph-bold ph-linkedin-logo text-xl text-retro-accent shrink-0 mt-0.5"></i>
                                <div>
                                    <span class="font-bold block text-xs uppercase tracking-wider text-retro-text/80">LINKEDIN:</span>
                                    <a href="<?= e($profile['linkedin_url']) ?>" target="_blank" rel="noopener noreferrer" class="text-retro-accent hover:underline font-bold inline-flex items-center gap-1">
                                        <span>Profil LinkedIn</span>
                                        <i class="ph-bold ph-arrow-up-right text-sm"></i>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- CV Document Download Action if Available -->
                <?php if (!empty($cv) && !empty($cv['file_path'])): ?>
                    <div class="pt-3 border-t-2 border-retro-border/20">
                        <a href="/<?= ltrim($cv['file_path'], '/') ?>" target="_blank" class="w-full py-3 rounded-xl bg-retro-secondary hover:bg-retro-accent hover:text-white retro-border font-mono text-xs sm:text-sm font-bold flex items-center justify-center gap-2 transition-all">
                            <i class="ph-bold ph-file-pdf text-lg"></i>
                            <span>UNDUH CURRICULUM VITAE (CV)</span>
                        </a>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </section>

    <!-- ========================================================================= -->
    <!-- SECTION 3: KEAHLIAN & KOMPETENSI (#keahlian)                               -->
    <!-- ========================================================================= -->
    <section id="keahlian" class="py-10 md:py-12 scroll-mt-20">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 border-b-2 border-retro-border pb-4 mb-6 md:mb-8 retro-reveal">
            <div>
                <span class="font-mono text-xs md:text-sm uppercase tracking-widest text-retro-accent font-bold">// 02. PERANGKAT KERJA</span>
                <h2 class="font-serif text-3xl md:text-4xl font-black mt-1 text-retro-text">Keahlian &amp; Kompetensi</h2>
            </div>
            <span class="font-mono text-xs md:text-sm bg-retro-card px-3.5 py-1.5 rounded-lg retro-border self-start sm:self-auto font-bold text-retro-text">
                STACK_TOTAL: <?= count($skillsRaw ?? []) ?> KOMPETENSI
            </span>
        </div>

        <!-- Skills Cards Grid: Padding Lega (p-6), Nama Skill text-base, Badge text-xs px-3 py-1 -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php 
            $categoryDllMap = [
                'Backend'    => 'BACKEND_SYS.DLL',
                'Frontend'   => 'FRONTEND_UI.EXE',
                'Database'   => 'DATABASE_SQL.DAT',
                'Tools'      => 'DEV_TOOLS.CFG',
                'Soft Skill' => 'CORE_VALUES.SYS',
                'Server & Deployment' => 'SERVER_OPS.SYS',
            ];
            $catIndex = 0;
            ?>
            <?php foreach ($skills as $catName => $items): ?>
                <?php 
                $fileDllName = $categoryDllMap[$catName] ?? (strtoupper(str_replace(' ', '_', $catName)) . '.SYS');
                $catStagger = 'stagger-' . (($catIndex % 5) + 1);
                $catIndex++;
                ?>
                <div class="bg-retro-card retro-border retro-shadow rounded-2xl overflow-hidden flex flex-col justify-between retro-reveal <?= $catStagger ?>">
                    <div>
                        <!-- OS Window Card Titlebar -->
                        <div class="bg-retro-secondary border-b-2 border-retro-border px-4 py-2.5 flex items-center justify-between font-mono text-xs md:text-sm">
                            <span class="font-bold flex items-center gap-2 text-retro-text">
                                <i class="ph-bold ph-terminal-window text-retro-accent text-base"></i>
                                <?= e($fileDllName) ?>
                            </span>
                            <span class="px-2.5 py-0.5 bg-retro-card rounded border border-retro-border text-xs font-bold text-retro-text">
                                <?= count($items) ?> Item
                            </span>
                        </div>

                        <!-- Skill Items List (p-6 lega, nama skill text-base font-semibold) -->
                        <div class="p-6 space-y-3.5 font-mono">
                            <?php foreach ($items as $skill): ?>
                                <?php
                                $prof = strtolower(trim((string)($skill['proficiency_level'] ?? 'menengah')));
                                $badgeClass = match ($prof) {
                                    'mahir', 'expert', 'advanced' => 'bg-retro-accent text-white',
                                    'dasar', 'beginner'           => 'bg-retro-secondary text-retro-text',
                                    default                       => 'bg-retro-card text-retro-text',
                                };
                                ?>
                                <div class="flex items-center justify-between gap-3 p-2.5 rounded-lg bg-retro-bg/60 border border-retro-border/50 hover:border-retro-border transition-colors">
                                    <div class="flex items-center gap-2.5 font-semibold text-base text-retro-text truncate">
                                        <i class="ph-bold ph-check-circle text-retro-accent text-lg shrink-0"></i>
                                        <span class="truncate"><?= e($skill['name']) ?></span>
                                    </div>
                                    <span class="px-3 py-1 text-xs font-bold rounded border border-retro-border shrink-0 <?= $badgeClass ?>">
                                        <?= e(ucfirst($skill['proficiency_level'] ?? 'Menengah')) ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- ========================================================================= -->
    <!-- SECTION 4: RIWAYAT STUDI & AKTIVITAS (#studi)                             -->
    <!-- ========================================================================= -->
    <section id="studi" class="py-10 md:py-12 scroll-mt-20">
        
        <!-- Header -->
        <div class="border-b-2 border-retro-border pb-4 mb-6 md:mb-8 flex flex-col sm:flex-row sm:items-end justify-between gap-4 retro-reveal">
            <div>
                <span class="font-mono text-xs md:text-sm uppercase tracking-widest text-retro-accent font-bold">// 03. LOG PERJALANAN</span>
                <h2 class="font-serif text-3xl md:text-4xl font-black mt-1 text-retro-text">Riwayat Studi &amp; Aktivitas</h2>
            </div>
            <span class="font-mono text-xs md:text-sm bg-retro-card px-3.5 py-1.5 rounded-lg retro-border self-start sm:self-auto font-bold text-retro-text">
                TIMELINE_ARCHIVE.LOG
            </span>
        </div>

        <div class="space-y-5">
            <?php $timelineIdx = 0; ?>
            <!-- Pendidikan Formal -->
            <?php foreach ($educations as $edu): ?>
                <?php 
                $eduStagger = 'stagger-' . (($timelineIdx % 5) + 1); 
                $timelineIdx++;
                ?>
                <div class="bg-retro-card retro-border retro-shadow-sm hover:translate-x-1 transition-transform rounded-xl p-6 sm:p-7 flex flex-col sm:flex-row sm:items-center justify-between gap-5 retro-reveal <?= $eduStagger ?>">
                    <div class="space-y-2">
                        <div class="flex items-center gap-2.5">
                            <span class="px-3 py-1 bg-retro-accent text-white font-mono text-xs md:text-sm font-bold rounded border border-retro-border">
                                <?= e($edu['start_year']) ?> — <?= !empty($edu['end_year']) ? e($edu['end_year']) : 'SEKARANG' ?>
                            </span>
                            <span class="font-mono text-xs md:text-sm text-retro-text font-semibold">• Pendidikan Formal</span>
                        </div>
                        <h3 class="font-serif text-xl md:text-2xl font-bold pt-1 text-retro-text">
                            <?= e($edu['study_program']) ?> — <?= e($edu['institution_name']) ?>
                        </h3>
                        <?php if (!empty($edu['description'])): ?>
                            <p class="text-sm md:text-base text-retro-text font-medium max-w-3xl leading-relaxed font-sans"><?= e($edu['description']) ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="font-mono text-xs md:text-sm bg-retro-secondary px-4 py-2 rounded-lg retro-border self-start sm:self-center shrink-0 font-bold text-retro-text">
                        Tasikmalaya, ID
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Pengalaman / Aktivitas (Jika Tersedia) -->
            <?php if (!empty($experiences)): ?>
                <?php foreach ($experiences as $exp): ?>
                    <?php 
                    $expStagger = 'stagger-' . (($timelineIdx % 5) + 1); 
                    $timelineIdx++;
                    ?>
                    <div class="bg-retro-card retro-border retro-shadow-sm hover:translate-x-1 transition-transform rounded-xl p-6 sm:p-7 flex flex-col sm:flex-row sm:items-center justify-between gap-5 retro-reveal <?= $expStagger ?>">
                        <div class="space-y-2">
                            <div class="flex items-center gap-2.5">
                                <span class="px-3 py-1 bg-retro-secondary font-mono text-xs md:text-sm font-bold rounded border border-retro-border text-retro-text">
                                    <?= date('M Y', strtotime($exp['start_date'])) ?> — <?= $exp['is_current'] ? 'SEKARANG' : ($exp['end_date'] ? date('M Y', strtotime($exp['end_date'])) : '-') ?>
                                </span>
                                <span class="font-mono text-xs md:text-sm text-retro-text font-semibold">• <?= e($exp['company_name'] ?? 'Pengalaman Proyek') ?></span>
                            </div>
                            <h3 class="font-serif text-xl md:text-2xl font-bold pt-1 text-retro-text">
                                <?= e($exp['position_title']) ?>
                            </h3>
                            <?php if (!empty($exp['description'])): ?>
                                <p class="text-sm md:text-base text-retro-text font-medium max-w-3xl leading-relaxed font-sans"><?= e($exp['description']) ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="font-mono text-xs md:text-sm bg-retro-secondary px-4 py-2 rounded-lg retro-border self-start sm:self-center shrink-0 font-bold text-retro-text">
                            <?= e($exp['location'] ?? 'Indonesia') ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

    <!-- ========================================================================= -->
    <!-- SECTION 5: PROYEK & KARYA (#proyek)                                       -->
    <!-- Grid 4 kolom lebih lega, judul text-lg, summary text-sm, fallback visual   -->
    <!-- ========================================================================= -->
    <section id="proyek" class="py-10 md:py-12 scroll-mt-20">
        
        <!-- Header & Category Filter Buttons -->
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-4 border-b-2 border-retro-border pb-4 mb-6 md:mb-8 retro-reveal">
            <div>
                <span class="font-mono text-xs md:text-sm uppercase tracking-widest text-retro-accent font-bold">// 04. ARSIP KARYA</span>
                <h2 class="font-serif text-3xl md:text-4xl font-black mt-1 text-retro-text">Proyek &amp; Karya Pilihan</h2>
            </div>

            <!-- Category Filter Buttons -->
            <div class="flex flex-wrap gap-2.5 font-mono text-xs md:text-sm overflow-x-auto pb-1" role="tablist">
                <button type="button" onclick="filterRetroProjects('all', this)" class="filter-btn px-4 py-2 rounded-lg retro-border bg-retro-accent text-white font-bold transition-all cursor-pointer">
                    Semua Proyek
                </button>
                <?php foreach ($categories as $cat): ?>
                    <button type="button" onclick="filterRetroProjects('<?= (int) $cat['id'] ?>', this)" class="filter-btn px-4 py-2 rounded-lg retro-border bg-retro-card hover:bg-retro-secondary font-semibold transition-all cursor-pointer text-retro-text">
                        <?= e($cat['name']) ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- 4 Kolom Grid Proyek (Lebar & Proporsional di Layar 1380px) -->
        <div id="projects-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($projects as $index => $proj): ?>
                <?php 
                $projNum = str_pad((string)($index + 1), 2, '0', STR_PAD_LEFT);
                $isFeatured = (int)($proj['is_featured'] ?? 0) === 1;
                $projStagger = 'stagger-' . (($index % 4) + 1);

                // Cek ketersediaan berkas cover fisik di public path
                $coverRelPath = !empty($proj['cover_image']) ? ltrim($proj['cover_image'], '/') : '';
                $hasCover = !empty($coverRelPath) && is_file(public_path($coverRelPath));
                ?>
                <article data-category-id="<?= (int) ($proj['category_id'] ?? 0) ?>" class="project-card bg-retro-card retro-border retro-shadow retro-shadow-hover rounded-2xl overflow-hidden flex flex-col justify-between retro-reveal <?= $projStagger ?>">
                    <div>
                        <!-- Titlebar Jendela Retro -->
                        <div class="bg-retro-secondary border-b-2 border-retro-border px-4 py-2.5 flex justify-between items-center font-mono text-xs">
                            <span class="font-bold truncate max-w-[180px] text-retro-text">
                                <?= $projNum ?>_<?= strtoupper(substr(e($proj['slug'] ?? 'APP'), 0, 14)) ?>.EXE
                            </span>
                            <?php if ($isFeatured): ?>
                                <span class="px-2 py-0.5 bg-retro-accent text-white rounded font-bold text-[10px] shrink-0">
                                    ★ UNGGULAN
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- Media Screenshot / Fallback Visual Bergaya Terminal Retro -->
                        <div class="h-48 bg-retro-secondary/50 border-b-2 border-retro-border overflow-hidden relative group">
                            <?php if ($hasCover): ?>
                                <!-- Gambar Thumbnail Asli Proyek -->
                                <img src="/<?= e($coverRelPath) ?>" 
                                     alt="<?= e($proj['title']) ?>" 
                                     loading="lazy" 
                                     class="w-full h-48 object-cover border-b-2 border-retro-border group-hover:scale-105 transition-transform duration-300">
                            <?php else: ?>
                                <!-- Fallback Visual Bergaya Terminal Retro yang Menarik -->
                                <div class="w-full h-48 p-4 flex flex-col justify-between bg-grid bg-retro-secondary/40 relative overflow-hidden group">
                                    <div class="flex items-center justify-between border-b border-retro-border/40 pb-1.5 font-mono text-[10px]">
                                        <div class="flex gap-1.5">
                                            <span class="w-2.5 h-2.5 rounded-full bg-red-400 border border-black inline-block"></span>
                                            <span class="w-2.5 h-2.5 rounded-full bg-yellow-400 border border-black inline-block"></span>
                                            <span class="w-2.5 h-2.5 rounded-full bg-green-400 border border-black inline-block"></span>
                                        </div>
                                        <span class="font-bold text-retro-text/80 uppercase tracking-wider"><?= strtoupper(substr(e($proj['slug'] ?? 'APP'), 0, 14)) ?>.APP</span>
                                    </div>
                                    
                                    <div class="flex flex-col items-center justify-center text-center px-2 py-1 space-y-2">
                                        <div class="w-11 h-11 rounded-xl bg-retro-card retro-border flex items-center justify-center text-2xl text-retro-accent shadow-xs group-hover:scale-110 transition-transform">
                                            <i class="ph-bold ph-terminal-window"></i>
                                        </div>
                                        <h4 class="font-serif font-black text-xs sm:text-sm text-retro-text line-clamp-2 leading-snug px-1">
                                            <?= e($proj['title']) ?>
                                        </h4>
                                    </div>

                                    <div class="flex items-center justify-between font-mono text-[10px] pt-1.5 border-t border-retro-border/30 text-retro-text font-bold">
                                        <span class="text-retro-accent flex items-center gap-1">
                                            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                                            READY
                                        </span>
                                        <span class="px-2 py-0.5 bg-retro-card rounded border border-retro-border text-[9px]"><?= e($proj['category_name'] ?? 'Proyek') ?></span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Content Area (Judul text-lg, summary text-sm font-medium) -->
                        <div class="p-5 space-y-3">
                            <!-- Category Badge -->
                            <span class="inline-block px-2.5 py-0.5 bg-retro-secondary rounded border border-retro-border text-xs font-mono font-bold text-retro-text">
                                <?= e($proj['category_name'] ?? 'Proyek Web') ?>
                            </span>

                            <h3 class="font-serif text-lg font-bold leading-snug line-clamp-2 text-retro-text">
                                <?= e($proj['title']) ?>
                            </h3>

                            <p class="text-sm text-retro-text font-medium line-clamp-2 leading-relaxed font-sans">
                                <?= e($proj['summary'] ?? '') ?>
                            </p>

                            <!-- Technologies Tags -->
                            <?php if (!empty($proj['technologies'])): ?>
                                <div class="flex flex-wrap gap-1.5 pt-1 font-mono text-xs">
                                    <?php foreach (array_slice($proj['technologies'], 0, 3) as $tech): ?>
                                        <span class="px-2 py-0.5 bg-retro-secondary/80 rounded border border-retro-border/70 font-semibold text-retro-text">
                                            <?= e($tech['name']) ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Footer Action Button -->
                    <div class="px-5 pb-5 pt-1">
                        <a href="/project/<?= e($proj['slug']) ?>" class="w-full py-2.5 px-4 rounded-xl bg-retro-card hover:bg-retro-accent hover:text-white retro-border font-mono text-xs md:text-sm font-bold flex items-center justify-between transition-colors group">
                            <span>Lihat Detail Proyek</span>
                            <i class="ph-bold ph-arrow-up-right text-base group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform"></i>
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- ========================================================================= -->
    <!-- SECTION 6: HUBUNGI SAYA (#kontak)                                         -->
    <!-- ========================================================================= -->
    <section id="kontak" class="py-10 md:py-12 scroll-mt-20">
        <div class="bg-retro-card retro-border retro-shadow rounded-2xl overflow-hidden retro-reveal">
            
            <!-- Window Header -->
            <div class="bg-retro-secondary border-b-2 border-retro-border px-5 py-3 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="ph-fill ph-envelope-simple text-retro-accent text-lg"></i>
                    <span class="font-mono text-xs md:text-sm font-bold text-retro-text">KIRIM_PESAN.SH</span>
                </div>
                <span class="font-mono text-xs font-bold text-retro-text">PORT: 8080 // ONLINE</span>
            </div>

            <div class="p-6 sm:p-10 lg:p-12 grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
                
                <!-- Kolom Kiri: Teks Kolaborasi & Google Maps -->
                <div class="lg:col-span-6 space-y-5">
                    <span class="font-mono text-xs md:text-sm uppercase tracking-widest text-retro-accent font-bold">// 05. KONTAK</span>
                    <h2 class="font-serif text-3xl md:text-4xl lg:text-5xl font-black leading-tight text-retro-text">
                        Mari Kolaborasi &amp; Bangun Sistem yang Handal.
                    </h2>
                    <p class="text-base md:text-lg text-retro-text font-medium leading-relaxed font-sans">
                        Punya peluang magang, proyek pengembangan aplikasi, atau sekadar ingin berdiskusi seputar pemrograman web? Kotak transmisi pesan saya selalu terbuka!
                    </p>

                    <!-- Copy Email Box -->
                    <div class="pt-1">
                        <div class="inline-flex items-center gap-2 p-2.5 rounded-xl bg-retro-secondary retro-border">
                            <span id="email-text" class="font-mono text-sm sm:text-base font-bold px-2 text-retro-text"><?= e($profile['email'] ?? 'ikhsanhidayatmuhamad@gmail.com') ?></span>
                            <button type="button" onclick="copyContactEmail()" class="px-3.5 py-1.5 bg-retro-card hover:bg-retro-accent hover:text-white rounded-lg retro-border font-mono text-xs sm:text-sm font-bold transition-colors flex items-center gap-1.5 cursor-pointer text-retro-text">
                                <i class="ph-bold ph-copy text-base"></i>
                                <span id="copy-label">Salin</span>
                            </button>
                        </div>
                    </div>

                    <!-- Social Icons Row (Dengan Ikon SVG & Teks Jelas - Tidak Kosong) -->
                    <div class="flex flex-wrap gap-3 pt-2">
                        <?php if (!empty($profile['github_url'])): ?>
                            <a href="<?= e($profile['github_url']) ?>" target="_blank" rel="noopener noreferrer" 
                               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-retro-card hover:bg-retro-accent hover:text-white retro-border retro-shadow-sm font-mono text-xs sm:text-sm font-bold transition-all text-retro-text" 
                               title="GitHub">
                                <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/></svg>
                                <span>GitHub</span>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($profile['linkedin_url'])): ?>
                            <a href="<?= e($profile['linkedin_url']) ?>" target="_blank" rel="noopener noreferrer" 
                               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-retro-card hover:bg-retro-accent hover:text-white retro-border retro-shadow-sm font-mono text-xs sm:text-sm font-bold transition-all text-retro-text" 
                               title="LinkedIn">
                                <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                                <span>LinkedIn</span>
                            </a>
                        <?php endif; ?>
                        <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $profile['whatsapp'] ?? '6282119491906') ?>" target="_blank" rel="noopener noreferrer" 
                           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-retro-card hover:bg-retro-accent hover:text-white retro-border retro-shadow-sm font-mono text-xs sm:text-sm font-bold transition-all text-retro-text" 
                           title="WhatsApp">
                            <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                            <span>WhatsApp</span>
                        </a>
                    </div>

                    <!-- Google Maps Tasikmalaya / Ciawi -->
                    <div class="pt-2">
                        <div class="retro-border rounded-xl overflow-hidden h-48 w-full shadow-inner bg-retro-secondary">
                            <iframe 
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126620.28639999982!2d108.157833!3d-7.327438!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e65751d3dc536cf%3A0x401e8f1fc28c680!2sTasikmalaya%2C%20Jawa%20Barat!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" 
                                class="w-full h-full border-0" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade"
                                title="Peta Lokasi Tasikmalaya">
                            </iframe>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Form Kontak PHP Asli -->
                <form id="public-contact-form" action="/contact" method="POST" class="lg:col-span-6 space-y-4 bg-retro-bg p-6 sm:p-7 rounded-xl retro-border">
                    <div>
                        <label for="form-name" class="block font-mono text-xs md:text-sm font-bold mb-1.5 text-retro-text">NAMA LENGKAP *</label>
                        <input type="text" name="name" id="form-name" required minlength="3" placeholder="Nama Anda" class="w-full px-4 py-3 rounded-lg bg-retro-card retro-border font-sans text-sm md:text-base focus:outline-none focus:ring-2 focus:ring-retro-accent text-retro-text">
                    </div>
                    <div>
                        <label for="form-email" class="block font-mono text-xs md:text-sm font-bold mb-1.5 text-retro-text">ALAMAT EMAIL *</label>
                        <input type="email" name="email" id="form-email" required placeholder="nama@email.com" class="w-full px-4 py-3 rounded-lg bg-retro-card retro-border font-sans text-sm md:text-base focus:outline-none focus:ring-2 focus:ring-retro-accent text-retro-text">
                    </div>
                    <div>
                        <label for="form-subject" class="block font-mono text-xs md:text-sm font-bold mb-1.5 text-retro-text">SUBJEK PESAN *</label>
                        <input type="text" name="subject" id="form-subject" required minlength="5" placeholder="Penawaran Magang / Kolaborasi Proyek" class="w-full px-4 py-3 rounded-lg bg-retro-card retro-border font-sans text-sm md:text-base focus:outline-none focus:ring-2 focus:ring-retro-accent text-retro-text">
                    </div>
                    <div>
                        <label for="form-message" class="block font-mono text-xs md:text-sm font-bold mb-1.5 text-retro-text">ISI PESAN *</label>
                        <textarea name="message" id="form-message" rows="3" required minlength="15" placeholder="Tuliskan detail pesan Anda di sini..." class="w-full px-4 py-3 rounded-lg bg-retro-card retro-border font-sans text-sm md:text-base focus:outline-none focus:ring-2 focus:ring-retro-accent text-retro-text"></textarea>
                    </div>
                    <button type="submit" id="form-submit-btn" class="w-full py-3.5 rounded-xl bg-retro-accent text-white font-mono font-bold text-sm md:text-base retro-border retro-shadow-sm retro-btn flex items-center justify-center gap-2 hover:opacity-95 transition-all cursor-pointer">
                        <i class="ph-bold ph-paper-plane-tilt text-lg"></i>
                        <span>KIRIM TRANSMISI PESAN</span>
                    </button>
                </form>

            </div>
        </div>
    </section>

</div>

<?php require dirname(__DIR__) . '/layouts/footer.php'; ?>

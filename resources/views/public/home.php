<?php require dirname(__DIR__) . '/layouts/header.php'; ?>

<!-- TOAST NOTIFICATION CONTAINER -->
<div id="toast-container" class="fixed top-20 right-6 z-50 space-y-3 pointer-events-none"></div>

<!-- ================= HERO SECTION ================= -->
<section id="home" class="relative overflow-hidden bg-slate-900 text-white py-20 lg:py-32 flex items-center min-h-[calc(100vh-5rem)]">
    <!-- Grid decorative background -->
    <div class="absolute inset-0 bg-[linear-gradient(to_right,#0f172a_1px,transparent_1px),linear-gradient(to_bottom,#0f172a_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)] opacity-35"></div>
    <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-600 rounded-full blur-3xl opacity-20"></div>
    <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-indigo-600 rounded-full blur-3xl opacity-20"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Left Info Column -->
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                
                <!-- Status Badge -->
                <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-blue-500/10 text-blue-400 border border-blue-500/20 text-xs font-bold uppercase tracking-wider mx-auto lg:mx-0">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                    </span>
                    Mahasiswa Manajemen Informatika
                </div>

                <div class="space-y-3">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold font-heading tracking-tight">
                        Halo, Saya <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-400"><?= e($profile['full_name'] ?? 'M. Ikhsanul Karim') ?></span>
                    </h1>
                    <h2 class="text-lg sm:text-xl font-bold font-heading text-slate-300">
                        <?= e($profile['headline'] ?? 'Backend Developer Intern') ?>
                    </h2>
                </div>

                <p class="text-xs sm:text-sm text-slate-400 leading-relaxed max-w-xl mx-auto lg:mx-0 font-light">
                    <?= e($profile['short_bio'] ?? 'Saya adalah mahasiswa D3 Manajemen Informatika yang berfokus pada pengembangan backend server-side, arsitektur database, dan pembuatan sistem manajemen konten.') ?>
                </p>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-4">
                    <a href="#proyek" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 rounded-lg text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-lg shadow-blue-600/30 hover:shadow-blue-700/40 hover:-translate-y-0.5 transition-all focus:outline-none">
                        <i data-lucide="eye" class="w-4 h-4"></i> Lihat Portofolio
                    </a>
                    
                    <?php if ($cv): ?>
                        <a href="<?= route($cv['file_path']) ?>" target="_blank"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 rounded-lg text-sm font-bold text-slate-200 bg-slate-800 hover:bg-slate-700 border border-slate-700 hover:border-slate-600 hover:-translate-y-0.5 transition-all focus:outline-none">
                            <i data-lucide="download-cloud" class="w-4 h-4"></i> Unduh CV (PDF)
                        </a>
                    <?php endif; ?>
                </div>

            </div>

            <!-- Right Photo Column -->
            <div class="lg:col-span-5 flex justify-center">
                <div class="relative w-64 h-64 sm:w-80 sm:h-80 lg:w-96 lg:h-96">
                    <!-- Glow background -->
                    <div class="absolute inset-0 bg-gradient-to-tr from-blue-600 to-indigo-600 rounded-3xl rotate-6 blur opacity-40 animate-pulse"></div>
                    
                    <!-- Outer container -->
                    <div class="absolute inset-0 bg-slate-800 border-2 border-slate-700 rounded-3xl overflow-hidden shadow-2xl flex items-center justify-center">
                        <?php if (!empty($profile['profile_photo']) && is_file(public_path($profile['profile_photo']))): ?>
                            <img src="<?= route($profile['profile_photo']) ?>" alt="<?= e($profile['full_name']) ?>" class="w-full h-full object-cover">
                        <?php else: ?>
                            <div class="flex flex-col items-center justify-center text-slate-500">
                                <i data-lucide="user" class="w-24 h-24 mb-3 text-slate-600"></i>
                                <span class="text-xs uppercase font-bold tracking-wider"><?= e($profile['full_name'] ?? 'M. Ikhsanul Karim') ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ================= TENTANG SAYA SECTION ================= -->
<section id="tentang" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
            <h2 class="text-3xl font-extrabold font-heading text-slate-800 tracking-tight">Tentang Saya</h2>
            <div class="w-16 h-1.5 bg-blue-600 mx-auto rounded-full"></div>
            <p class="text-xs text-slate-500 uppercase tracking-widest font-bold">Profil Singkat & Latar Belakang Mahasiswa</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
            
            <!-- Left Info Block -->
            <div class="space-y-6">
                <h3 class="text-xl font-bold font-heading text-slate-800">
                    Saya senang menerjemahkan logika kompleks menjadi basis data dan sistem yang efisien.
                </h3>
                
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-light">
                    Sebagai mahasiswa Manajemen Informatika, saya dibekali kemampuan teknis untuk menganalisis kebutuhan sistem, merancang proses basis data, dan mengembangkan aplikasi web yang aman. Fokus utama saya adalah menjadi **Backend Developer** dengan keahlian khusus di PHP (OOP & MVC) dan MySQL.
                </p>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-light">
                    Beberapa proyek yang telah saya kerjakan meliputi digitalisasi di tingkat desa selama KKN (Kuliah Kerja Nyata) serta pengerjaan tugas perkuliahan berbasis pemrograman web native.
                </p>

            </div>

            <!-- Right Contacts Block -->
            <div class="bg-slate-50 border border-slate-200 rounded-xl p-6 space-y-6">
                <h4 class="text-sm font-bold text-slate-700 uppercase tracking-wider pb-3 border-b border-slate-200 flex items-center gap-2">
                    <i data-lucide="contact" class="w-4 h-4 text-slate-500"></i> Informasi Personal
                </h4>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                            <i data-lucide="map-pin" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-400 font-bold uppercase">Lokasi Domisili</p>
                            <p class="text-xs font-semibold text-slate-800"><?= e($profile['location'] ?? 'Bandung, Jawa Barat') ?></p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-400 font-bold uppercase">Alamat Email</p>
                            <p class="text-xs font-semibold text-slate-800 font-mono"><?= e($profile['email'] ?? 'ikhsan@example.com') ?></p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                            <i data-lucide="phone" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-400 font-bold uppercase">No. Telepon / WA</p>
                            <p class="text-xs font-semibold text-slate-800 font-mono"><?= e($profile['whatsapp'] ?? '+62 812-3456-7890') ?></p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                            <i data-lucide="link" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-400 font-bold uppercase">Sosial Media</p>
                            <div class="flex items-center gap-2 mt-1">
                                <?php if (!empty($profile['github_url'])): ?>
                                    <a href="<?= e($profile['github_url']) ?>" target="_blank" class="text-slate-600 hover:text-blue-600" title="GitHub">
                                        <i data-lucide="github" class="w-4 h-4"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if (!empty($profile['linkedin_url'])): ?>
                                    <a href="<?= e($profile['linkedin_url']) ?>" target="_blank" class="text-slate-600 hover:text-blue-600" title="LinkedIn">
                                        <i data-lucide="linkedin" class="w-4 h-4"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

<!-- ================= KEAHLIAN SECTION ================= -->
<section id="keahlian" class="py-20 bg-slate-50 border-t border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
            <h2 class="text-3xl font-extrabold font-heading text-slate-800 tracking-tight">Keahlian & Kompetensi</h2>
            <div class="w-16 h-1.5 bg-blue-600 mx-auto rounded-full"></div>
            <p class="text-xs text-slate-500 uppercase tracking-widest font-bold">Keahlian Teknis & Non-teknis Yang Dikuasai</p>
        </div>

        <?php if (empty($skills)): ?>
            <div class="text-center py-12 text-slate-400">Belum ada keahlian aktif untuk ditampilkan.</div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($skills as $categoryName => $catSkills): ?>
                    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm space-y-4">
                        <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider pb-2.5 border-b border-slate-100 flex items-center gap-2">
                            <!-- Icon selection depending on category name -->
                            <?php if ($categoryName === 'Backend'): ?>
                                <i data-lucide="server" class="w-4.5 h-4.5 text-blue-600"></i>
                            <?php elseif ($categoryName === 'Database'): ?>
                                <i data-lucide="database" class="w-4.5 h-4.5 text-blue-600"></i>
                            <?php elseif ($categoryName === 'Frontend'): ?>
                                <i data-lucide="layout" class="w-4.5 h-4.5 text-blue-600"></i>
                            <?php elseif ($categoryName === 'Tools'): ?>
                                <i data-lucide="wrench" class="w-4.5 h-4.5 text-blue-600"></i>
                            <?php else: ?>
                                <i data-lucide="award" class="w-4.5 h-4.5 text-blue-600"></i>
                            <?php endif; ?>
                            
                            <?= e($categoryName) ?>
                        </h3>

                        <div class="space-y-3">
                            <?php foreach ($catSkills as $skill): ?>
                                <div class="flex items-center justify-between p-2 bg-slate-50 rounded border border-slate-100 hover:border-slate-200 transition-colors">
                                    <span class="text-xs font-semibold text-slate-700"><?= e($skill['name']) ?></span>
                                    <?php if ($skill['proficiency_level']): ?>
                                        <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-0.5 text-[10px] font-bold text-blue-700 ring-1 ring-inset ring-blue-700/10">
                                            <?= e($skill['proficiency_level']) ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</section>

<!-- ================= PENDIDIKAN & PENGALAMAN SECTION ================= -->
<section id="pendidikan" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
            <h2 class="text-3xl font-extrabold font-heading text-slate-800 tracking-tight">Riwayat Studi & Aktivitas</h2>
            <div class="w-16 h-1.5 bg-blue-600 mx-auto rounded-full"></div>
            <p class="text-xs text-slate-500 uppercase tracking-widest font-bold">Pendidikan Formal dan Pengalaman Terkait</p>
        </div>

        <!-- Conditional Layout: if experience has entries, double column. Otherwise single column spanning full width for education! -->
        <div class="grid grid-cols-1 <?= !empty($experiences) ? 'lg:grid-cols-2' : '' ?> gap-12 items-start">
            
            <!-- Left Column: Educations -->
            <div class="space-y-6">
                <h3 class="text-lg font-bold font-heading text-slate-800 flex items-center gap-2 border-b border-slate-100 pb-3">
                    <i data-lucide="graduation-cap" class="w-5 h-5 text-blue-600"></i> Pendidikan Formal
                </h3>

                <?php if (empty($educations)): ?>
                    <p class="text-xs text-slate-400">Belum ada riwayat pendidikan untuk ditampilkan.</p>
                <?php else: ?>
                    <div class="relative border-l border-slate-200 ml-4 space-y-6">
                        <?php foreach ($educations as $edu): ?>
                            <div class="relative pl-6">
                                <!-- Dot icon marker -->
                                <div class="absolute -left-2 top-1.5 w-4 h-4 rounded-full bg-blue-600 border-4 border-white shadow-sm"></div>
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2">
                                        <h4 class="text-xs font-bold text-slate-800 leading-tight"><?= e($edu['institution_name']) ?></h4>
                                        <span class="inline-flex items-center rounded bg-slate-50 px-2 py-0.5 text-[9px] font-bold text-slate-600 ring-1 ring-inset ring-slate-500/10">
                                            <?= e($edu['degree']) ?>
                                        </span>
                                    </div>
                                    <p class="text-[11px] font-semibold text-slate-600"><?= e($edu['study_program']) ?></p>
                                    <p class="text-[10px] font-mono text-slate-400 font-medium">Periode: <?= $edu['start_year'] ?> - <?= $edu['end_year'] ?: 'Sekarang' ?></p>
                                    <?php if ($edu['description']): ?>
                                        <p class="text-xs text-slate-500 font-light mt-1.5 leading-relaxed"><?= e($edu['description']) ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Right Column: Experiences (Optional) -->
            <?php if (!empty($experiences)): ?>
                <div class="space-y-6">
                    <h3 class="text-lg font-bold font-heading text-slate-800 flex items-center gap-2 border-b border-slate-100 pb-3">
                        <i data-lucide="briefcase" class="w-5 h-5 text-blue-600"></i> Pengalaman Kerja & Organisasi
                    </h3>

                    <div class="relative border-l border-slate-200 ml-4 space-y-6">
                        <?php foreach ($experiences as $exp): ?>
                            <div class="relative pl-6">
                                <div class="absolute -left-2 top-1.5 w-4 h-4 rounded-full bg-indigo-600 border-4 border-white shadow-sm"></div>
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2">
                                        <h4 class="text-xs font-bold text-slate-800 leading-tight"><?= e($exp['organization_name']) ?></h4>
                                        <span class="inline-flex items-center rounded bg-slate-50 px-2 py-0.5 text-[9px] font-bold text-slate-600 ring-1 ring-inset ring-slate-500/10">
                                            <?= e($exp['experience_type']) ?>
                                        </span>
                                    </div>
                                    <p class="text-[11px] font-semibold text-slate-600"><?= e($exp['role']) ?></p>
                                    <p class="text-[10px] font-mono text-slate-400 font-medium">
                                        Periode: <?= date('M Y', strtotime($exp['start_date'])) ?> - 
                                        <?= $exp['is_current'] ? 'Sekarang' : ($exp['end_date'] ? date('M Y', strtotime($exp['end_date'])) : '-') ?>
                                    </p>
                                    <p class="text-xs text-slate-500 font-light mt-1.5 leading-relaxed"><?= e($exp['description']) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>

<!-- ================= PROYEK PORTFOLIO SECTION ================= -->
<section id="proyek" class="py-20 bg-slate-50 border-t border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-12 space-y-3">
            <h2 class="text-3xl font-extrabold font-heading text-slate-800 tracking-tight">Dokumentasi Proyek</h2>
            <div class="w-16 h-1.5 bg-blue-600 mx-auto rounded-full"></div>
            <p class="text-xs text-slate-500 uppercase tracking-widest font-bold">Hasil Karya, Tugas Akhir, & Proyek Pengabdian</p>
        </div>

        <!-- Javascript-based Category Filter Tabs -->
        <div class="flex justify-center items-center gap-2 flex-wrap mb-10">
            <button onclick="filterCategory('all')" id="tab-all"
                class="filter-tab px-4 py-2 text-xs font-bold rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 shadow-sm transition-all focus:outline-none ring-2 ring-blue-600/30">
                Semua Proyek
            </button>
            <?php foreach ($categories as $cat): ?>
                <button onclick="filterCategory(<?= $cat['id'] ?>)" id="tab-<?= $cat['id'] ?>"
                    class="filter-tab px-4 py-2 text-xs font-bold rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 shadow-sm transition-all focus:outline-none">
                    <?= e($cat['name']) ?>
                </button>
            <?php endforeach; ?>
        </div>

        <!-- Projects Grid -->
        <?php if (empty($projects)): ?>
            <div class="text-center py-16 text-slate-400">Belum ada data proyek terpublikasi.</div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="projects-grid">
                <?php foreach ($projects as $proj): ?>
                    <div class="project-card bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm flex flex-col hover:shadow-md transition-all duration-300 transform"
                        data-category-id="<?= $proj['category_id'] ?>">
                        
                        <!-- Card Cover Image -->
                        <div class="w-full h-48 bg-slate-200 overflow-hidden flex items-center justify-center relative">
                            <?php if ($proj['cover_image']): ?>
                                <img src="<?= route($proj['cover_image']) ?>" alt="<?= e($proj['title']) ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <i data-lucide="image" class="w-10 h-10 text-slate-400"></i>
                            <?php endif; ?>
                            
                            <!-- Featured Ribbon Badge -->
                            <?php if ($proj['is_featured']): ?>
                                <div class="absolute top-3 right-3 bg-yellow-500 text-slate-950 px-2 py-0.5 rounded text-[9px] uppercase font-bold tracking-wider flex items-center gap-1 shadow">
                                    <i data-lucide="star" class="w-3 h-3 fill-slate-950"></i> Unggulan
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Card Body -->
                        <div class="p-6 flex-grow flex flex-col justify-between space-y-4">
                            <div class="space-y-2">
                                <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-0.5 text-[9px] font-bold text-blue-700 ring-1 ring-inset ring-blue-700/10 uppercase tracking-wider">
                                    <?= e($proj['category_name']) ?>
                                </span>
                                
                                <h3 class="text-base font-bold font-heading text-slate-800 leading-tight">
                                    <?= e($proj['title']) ?>
                                </h3>
                                
                                <p class="text-xs text-slate-500 font-light line-clamp-3 leading-relaxed">
                                    <?= e($proj['summary']) ?>
                                </p>
                            </div>

                            <!-- Tech Stack list -->
                            <div class="space-y-3 pt-3 border-t border-slate-100">
                                <div class="flex flex-wrap gap-1.5">
                                    <?php foreach ($proj['technologies'] as $tech): ?>
                                        <span class="text-[9px] font-bold bg-slate-50 text-slate-600 border border-slate-200 px-1.5 py-0.5 rounded leading-none">
                                            <?= e($tech['name']) ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>

                                <a href="/project/<?= e($proj['slug']) ?>" 
                                    class="w-full inline-flex items-center justify-center gap-1.5 px-4 py-2 text-xs font-bold text-slate-700 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-lg transition-all focus:outline-none">
                                    Lihat Detail Proyek <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                                </a>
                            </div>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</section>

<!-- ================= HUBUNGI SAYA / KONTAK SECTION ================= -->
<section id="kontak" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
            <h2 class="text-3xl font-extrabold font-heading text-slate-800 tracking-tight">Hubungi Saya</h2>
            <div class="w-16 h-1.5 bg-blue-600 mx-auto rounded-full"></div>
            <p class="text-xs text-slate-500 uppercase tracking-widest font-bold">Kirimkan Penawaran Kerja Sama atau Pertanyaan</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            
            <!-- Left Info column -->
            <div class="lg:col-span-5 space-y-6">
                <div class="space-y-3 text-center lg:text-left">
                    <h3 class="text-lg font-bold font-heading text-slate-800">Mari berkolaborasi membangun sistem berkualitas!</h3>
                    <p class="text-xs text-slate-500 font-light leading-relaxed">
                        Silakan kirimkan pertanyaan atau masukan melalui formulir di samping. Saya akan membalas pesan Anda sesegera mungkin.
                    </p>
                </div>

                <!-- Google Maps Iframe or Visual Info card -->
                <div class="border border-slate-200 rounded-xl overflow-hidden shadow-sm h-64 bg-slate-100 flex items-center justify-center relative">
                    <!-- Google Maps Iframe -->
                    <iframe 
                        src="<?= e(get_google_maps_embed_url($settings['google_maps_link'] ?? 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126748.29177263567!2d107.57311634561073!3d-6.903444331685455!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e6398252477f%3A0x146a1f9a0e3685e!2sBandung%2C%20Kota%20Bandung%2C%20Jawa%20Barat!5e0!3m2!1sid!2sid!4v1689100000000!5m2!1sid!2sid')) ?>" 
                        class="w-full h-full border-0 absolute inset-0" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>

            <!-- Right Form column -->
            <div class="lg:col-span-7 bg-slate-50 border border-slate-200 rounded-xl p-6 md:p-8 shadow-sm">
                <form id="public-contact-form" action="/contact" method="POST" class="space-y-4">
                    <?= csrf_field() ?>
                    
                    <!-- Antispam Honeypot (hidden from human via style and autocomplete) -->
                    <input type="text" name="website" class="hidden" style="display:none !important;" tabindex="-1" autocomplete="off">

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="form-name" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="form-name" required minlength="3"
                                class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs"
                                placeholder="Contoh: Adrian Hartanto">
                        </div>
                        <div>
                            <label for="form-email" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Alamat Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" id="form-email" required
                                class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs"
                                placeholder="Contoh: adrian@agency.com">
                        </div>
                    </div>

                    <div>
                        <label for="form-subject" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Subjek Pesan <span class="text-red-500">*</span></label>
                        <input type="text" name="subject" id="form-subject" required minlength="5"
                            class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs"
                            placeholder="Contoh: Tawaran Magang Backend Developer">
                    </div>

                    <div>
                        <label for="form-message" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Isi Pesan <span class="text-red-500">*</span></label>
                        <textarea name="message" id="form-message" rows="5" required minlength="15"
                            class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs"
                            placeholder="Tuliskan detail pertanyaan atau penawaran magang Anda..."></textarea>
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="submit" id="form-submit-btn"
                            class="inline-flex items-center justify-center gap-2 px-5 py-2.5 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-md transition-colors focus:outline-none">
                            <i data-lucide="send" class="w-4 h-4"></i> Kirim Pesan
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>

<!-- ================= JS SCRIPTS FOR AJAX AND FILTERING ================= -->
<script>
    // 1. Projects Category Filtering (Client-side)
    function filterCategory(catId) {
        const cards = document.querySelectorAll('.project-card');
        const tabs = document.querySelectorAll('.filter-tab');

        // Toggle Active Tab class
        tabs.forEach(tab => {
            if (tab.id === 'tab-' + catId) {
                tab.classList.add('ring-2', 'ring-blue-600/30', 'text-blue-700');
                tab.classList.remove('text-slate-600');
            } else {
                tab.classList.remove('ring-2', 'ring-blue-600/30', 'text-blue-700');
                tab.classList.add('text-slate-600');
            }
        });

        // Hide/Show cards with smooth transitions
        cards.forEach(card => {
            if (catId === 'all' || card.getAttribute('data-category-id') === String(catId)) {
                card.style.display = 'flex';
                // Trigger smooth fade-in
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'scale(1)';
                }, 50);
            } else {
                card.style.opacity = '0';
                card.style.transform = 'scale(0.95)';
                // Wait for animation to finish before hiding display
                setTimeout(() => {
                    card.style.display = 'none';
                }, 300);
            }
        });
    }

    // 2. AJAX Public Contact Form Submission
    const contactForm = document.getElementById('public-contact-form');
    const submitBtn = document.getElementById('form-submit-btn');

    if (contactForm) {
        contactForm.addEventListener('submit', (e) => {
            e.preventDefault();

            // Validate front-end length checks
            const nameVal = document.getElementById('form-name').value.trim();
            const subjectVal = document.getElementById('form-subject').value.trim();
            const messageVal = document.getElementById('form-message').value.trim();

            if (nameVal.length < 3) {
                showToast('Nama minimal terdiri dari 3 karakter.', 'error');
                return;
            }
            if (subjectVal.length < 5) {
                showToast('Subjek minimal terdiri dari 5 karakter.', 'error');
                return;
            }
            if (messageVal.length < 15) {
                showToast('Pesan minimal terdiri dari 15 karakter.', 'error');
                return;
            }

            // Set loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="inline-block animate-spin border-2 border-white border-t-transparent rounded-full w-3.5 h-3.5"></span> Mengirim...';

            const formData = new FormData(contactForm);

            // POST via fetch
            fetch('/contact', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(async response => {
                const res = await response.json();
                if (!response.ok) {
                    throw new Error(res.message || 'Terjadi kesalahan sistem.');
                }
                return res;
            })
            .then(res => {
                if (res.success) {
                    showToast(res.message, 'success');
                    contactForm.reset(); // clear input
                } else {
                    showToast(res.message, 'error');
                }
            })
            .catch(err => {
                console.error(err);
                showToast(err.message || 'Gagal mengirim pesan. Silakan coba kembali.', 'error');
            })
            .finally(() => {
                // Reset submit button state
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i data-lucide="send" class="w-4 h-4"></i> Kirim Pesan';
                lucide.createIcons();
            });
        });
    }

    // 3. Dynamic Toast Message display
    function showToast(message, type = 'success') {
        const container = document.getElementById('toast-container');
        if (!container) return;

        const toast = document.createElement('div');
        toast.className = `p-4 rounded-xl border flex items-center gap-3 shadow-lg pointer-events-auto w-80 max-w-sm animate-in slide-in-from-top-4 duration-300 ${
            type === 'success' 
                ? 'bg-green-50 border-green-200 text-green-800' 
                : 'bg-red-50 border-red-200 text-red-800'
        }`;

        const iconName = type === 'success' ? 'check-circle-2' : 'alert-circle';
        const iconColor = type === 'success' ? 'text-green-600' : 'text-red-600';

        toast.innerHTML = `
            <i data-lucide="${iconName}" class="w-5 h-5 flex-shrink-0 ${iconColor}"></i>
            <p class="text-xs font-semibold">${message}</p>
        `;

        container.appendChild(toast);
        lucide.createIcons();

        // Remove toast automatically after 5 seconds
        setTimeout(() => {
            toast.classList.remove('slide-in-from-top-4');
            toast.classList.add('animate-out', 'fade-out', 'duration-300');
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 5000);
    }
</script>

<?php require dirname(__DIR__) . '/layouts/footer.php'; ?>

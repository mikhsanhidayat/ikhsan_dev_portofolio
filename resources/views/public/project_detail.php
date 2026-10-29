<?php require dirname(__DIR__) . '/layouts/header.php'; ?>

<?php
// Inline helper to extract YouTube Embed ID
function parse_youtube_embed(?string $url): ?string {
    if (empty($url)) return null;
    $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i';
    if (preg_match($pattern, $url, $matches)) {
        return "https://www.youtube.com/embed/" . $matches[1];
    }
    return null;
}
$youtubeEmbedUrl = parse_youtube_embed($project['video_url'] ?? null);
?>

<div class="max-w-[1380px] w-[92%] mx-auto py-8 md:py-12 space-y-6">
    
    <!-- Top Breadcrumb Navigation -->
    <div class="flex items-center justify-between font-mono text-xs">
        <a href="/#proyek" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-retro-card hover:bg-retro-accent hover:text-white retro-border retro-shadow-sm font-bold text-retro-text transition-colors">
            <i class="ph-bold ph-arrow-left text-base"></i>
            <span>&larr; Kembali ke Beranda</span>
        </a>
        <span class="px-3 py-1.5 rounded-lg bg-retro-secondary retro-border font-bold text-retro-text text-xs">
            SYS_ID: #<?= (int)$project['id'] ?> // <?= strtoupper(substr(e($project['slug'] ?? 'APP'), 0, 16)) ?>.EXE
        </span>
    </div>

    <!-- Main Window Container: DETAIL_PROYEK.EXE -->
    <article class="bg-retro-card retro-border retro-shadow rounded-2xl overflow-hidden">
        
        <!-- OS Window Titlebar -->
        <div class="bg-retro-secondary border-b-2 border-retro-border px-5 py-3 flex items-center justify-between font-mono text-xs md:text-sm font-bold">
            <div class="flex items-center gap-2.5">
                <span class="w-3 h-3 rounded-full bg-[#FF5F56] border border-black inline-block"></span>
                <span class="w-3 h-3 rounded-full bg-[#FFBD2E] border border-black inline-block"></span>
                <span class="w-3 h-3 rounded-full bg-[#27C93F] border border-black inline-block"></span>
                <span class="ml-2 text-retro-text">DETAIL_PROYEK.EXE // <?= strtoupper(e($project['slug'] ?? 'APP')) ?></span>
            </div>
            <div class="flex items-center gap-3">
                <span class="hidden sm:inline-block px-2.5 py-0.5 rounded bg-retro-card retro-border text-xs text-retro-text">
                    STATUS: <?= strtoupper(e($project['project_status'] ?? 'SELESAI')) ?>
                </span>
                <span class="text-retro-accent font-bold">PORT: 8080 // ACTIVE</span>
            </div>
        </div>

        <!-- Window Body -->
        <div class="p-6 sm:p-10 lg:p-12 space-y-10">
            
            <!-- Project Header Info -->
            <div class="space-y-4 border-b-2 border-retro-border pb-8">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-lg bg-retro-accent text-white font-mono text-xs md:text-sm font-bold">
                        <i class="ph-fill ph-tag"></i>
                        <span><?= e($project['category_name'] ?? 'Proyek Web') ?></span>
                    </span>
                    <?php if ((int)($project['is_featured'] ?? 0) === 1): ?>
                        <span class="px-3 py-1 bg-yellow-400 text-black border border-black font-mono text-xs font-black rounded-lg">
                            ★ PROYEK UNGGULAN
                        </span>
                    <?php endif; ?>
                    <span class="font-mono text-xs md:text-sm text-retro-text font-semibold sm:ml-auto">
                        Periode: <?= date('M Y', strtotime($project['start_date'])) ?> &mdash; <?= $project['end_date'] ? date('M Y', strtotime($project['end_date'])) : 'Sekarang' ?>
                    </span>
                </div>

                <h1 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-black text-retro-text leading-tight tracking-tight">
                    <?= e($project['title']) ?>
                </h1>

                <?php if (!empty($project['summary'])): ?>
                    <p class="text-base md:text-lg text-retro-text leading-relaxed font-sans font-medium max-w-4xl">
                        <?= e($project['summary']) ?>
                    </p>
                <?php endif; ?>

                <!-- Action Buttons: Live Demo & GitHub -->
                <?php if (!empty($project['demo_url']) || !empty($project['github_url'])): ?>
                    <div class="flex flex-wrap items-center gap-3 pt-2">
                        <?php if (!empty($project['demo_url'])): ?>
                            <a href="<?= e($project['demo_url']) ?>" target="_blank" rel="noopener noreferrer"
                               class="px-6 py-3 rounded-xl bg-retro-accent text-white font-mono font-bold text-xs sm:text-sm retro-border retro-shadow-sm retro-btn flex items-center gap-2 hover:opacity-95 transition-all">
                                <i class="ph-bold ph-arrow-square-out text-lg"></i>
                                <span>KUNJUNGI LIVE DEMO</span>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($project['github_url'])): ?>
                            <a href="<?= e($project['github_url']) ?>" target="_blank" rel="noopener noreferrer"
                               class="px-6 py-3 rounded-xl bg-retro-card hover:bg-retro-secondary text-retro-text font-mono font-bold text-xs sm:text-sm retro-border retro-shadow-sm retro-btn flex items-center gap-2 transition-all">
                                <i class="ph-bold ph-github-logo text-lg"></i>
                                <span>REPOSITORY GITHUB</span>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Media Hero: Cover Screenshot -->
            <div class="space-y-3">
                <div class="flex items-center justify-between font-mono text-xs md:text-sm font-bold text-retro-text">
                    <span class="flex items-center gap-2">
                        <i class="ph-bold ph-image text-retro-accent text-base"></i>
                        COVER_SCREENSHOT_PREVIEW.PNG
                    </span>
                    <span class="text-xs text-retro-text/75">DISPLAY: 100% SCALE</span>
                </div>

                <div class="w-full bg-retro-secondary/40 retro-border rounded-xl overflow-hidden shadow-inner">
                    <?php 
                    $coverRelPath = !empty($project['cover_image']) ? ltrim($project['cover_image'], '/') : '';
                    $hasCover = !empty($coverRelPath) && is_file(public_path($coverRelPath));
                    ?>
                    <?php if ($hasCover): ?>
                        <img src="/<?= e($coverRelPath) ?>" 
                             alt="<?= e($project['title']) ?>" 
                             class="w-full max-h-[560px] object-cover object-top border-b-2 border-retro-border">
                    <?php else: ?>
                        <div class="w-full h-80 flex flex-col items-center justify-center p-8 text-center space-y-3 font-mono bg-grid">
                            <i class="ph-bold ph-browsers text-6xl text-retro-accent"></i>
                            <div class="font-bold text-base text-retro-text">Pratinjau Antarmuka Tidak Tersedia</div>
                            <div class="text-xs text-retro-text/75 max-w-md">Tangkapan layar sistem untuk proyek ini sedang dalam arsip lokal.</div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- YouTube Video Demo Embed (if present) -->
            <?php if ($youtubeEmbedUrl): ?>
                <div class="space-y-3">
                    <div class="flex items-center justify-between font-mono text-xs md:text-sm font-bold text-retro-text">
                        <span class="flex items-center gap-2">
                            <i class="ph-bold ph-video-camera text-retro-accent text-base"></i>
                            DEMO_REKAMAN_VIDEO.MP4
                        </span>
                        <span class="text-xs text-retro-text/75">YOUTUBE STREAM</span>
                    </div>
                    <div class="aspect-video w-full retro-border rounded-xl overflow-hidden bg-black shadow-inner">
                        <iframe src="<?= $youtubeEmbedUrl ?>" class="w-full h-full" allowfullscreen allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Main Content Grid (Narrative Left 8 cols & Sidebar Right 4 cols) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Left Narrative Column (8 cols) -->
                <div class="lg:col-span-8 space-y-8">
                    
                    <!-- Latar Belakang & Tujuan -->
                    <?php if (!empty($project['background']) || !empty($project['objective'])): ?>
                        <div class="bg-retro-bg p-6 sm:p-8 rounded-xl retro-border space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <?php if (!empty($project['background'])): ?>
                                    <div class="space-y-2">
                                        <h3 class="font-mono text-xs md:text-sm font-bold text-retro-accent uppercase tracking-wider flex items-center gap-1.5">
                                            <i class="ph-bold ph-question"></i>
                                            <span>Masalah &amp; Latar Belakang</span>
                                        </h3>
                                        <p class="text-sm md:text-base text-retro-text font-medium leading-relaxed font-sans whitespace-pre-line"><?= e($project['background']) ?></p>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($project['objective'])): ?>
                                    <div class="space-y-2">
                                        <h3 class="font-mono text-xs md:text-sm font-bold text-retro-accent uppercase tracking-wider flex items-center gap-1.5">
                                            <i class="ph-bold ph-target"></i>
                                            <span>Tujuan Proyek</span>
                                        </h3>
                                        <p class="text-sm md:text-base text-retro-text font-medium leading-relaxed font-sans whitespace-pre-line"><?= e($project['objective']) ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Solusi & Peran Tanggung Jawab -->
                    <?php if (!empty($project['solution']) || !empty($project['role_description'])): ?>
                        <div class="bg-retro-bg p-6 sm:p-8 rounded-xl retro-border space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <?php if (!empty($project['solution'])): ?>
                                    <div class="space-y-2">
                                        <h3 class="font-mono text-xs md:text-sm font-bold text-retro-accent uppercase tracking-wider flex items-center gap-1.5">
                                            <i class="ph-bold ph-check-circle"></i>
                                            <span>Solusi yang Dibangun</span>
                                        </h3>
                                        <p class="text-sm md:text-base text-retro-text font-medium leading-relaxed font-sans whitespace-pre-line"><?= e($project['solution']) ?></p>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($project['role_description'])): ?>
                                    <div class="space-y-2">
                                        <h3 class="font-mono text-xs md:text-sm font-bold text-retro-accent uppercase tracking-wider flex items-center gap-1.5">
                                            <i class="ph-bold ph-user-check"></i>
                                            <span>Peran &amp; Tanggung Jawab</span>
                                        </h3>
                                        <p class="text-sm md:text-base text-retro-text font-medium leading-relaxed font-sans whitespace-pre-line"><?= e($project['role_description']) ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Fitur Utama & Proses Pengerjaan -->
                    <?php if (!empty($project['feature_description']) || !empty($project['process_description'])): ?>
                        <div class="bg-retro-bg p-6 sm:p-8 rounded-xl retro-border space-y-6">
                            <?php if (!empty($project['feature_description'])): ?>
                                <div class="space-y-2">
                                    <h3 class="font-mono text-xs md:text-sm font-bold text-retro-accent uppercase tracking-wider flex items-center gap-1.5">
                                        <i class="ph-bold ph-stack"></i>
                                        <span>Fitur Utama Sistem</span>
                                    </h3>
                                    <p class="text-sm md:text-base text-retro-text font-medium leading-relaxed font-sans whitespace-pre-line"><?= e($project['feature_description']) ?></p>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($project['process_description'])): ?>
                                <hr class="border-retro-border/20">
                                <div class="space-y-2">
                                    <h3 class="font-mono text-xs md:text-sm font-bold text-retro-accent uppercase tracking-wider flex items-center gap-1.5">
                                        <i class="ph-bold ph-git-branch"></i>
                                        <span>Tahapan &amp; Proses Pengerjaan</span>
                                    </h3>
                                    <p class="text-sm md:text-base text-retro-text font-medium leading-relaxed font-sans whitespace-pre-line"><?= e($project['process_description']) ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Hasil Nyata & Tantangan -->
                    <?php if (!empty($project['result_description']) || !empty($project['challenge_description'])): ?>
                        <div class="bg-retro-bg p-6 sm:p-8 rounded-xl retro-border space-y-6">
                            <?php if (!empty($project['result_description'])): ?>
                                <div class="space-y-2">
                                    <h3 class="font-mono text-xs md:text-sm font-bold text-retro-accent uppercase tracking-wider flex items-center gap-1.5">
                                        <i class="ph-bold ph-trend-up"></i>
                                        <span>Hasil &amp; Dampak Nyata</span>
                                    </h3>
                                    <p class="text-sm md:text-base text-retro-text font-medium leading-relaxed font-sans whitespace-pre-line"><?= e($project['result_description']) ?></p>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($project['challenge_description'])): ?>
                                <hr class="border-retro-border/20">
                                <div class="space-y-2 bg-retro-secondary/40 border border-retro-border rounded-xl p-4">
                                    <h3 class="font-mono text-xs md:text-sm font-bold text-retro-accent uppercase tracking-wider flex items-center gap-1.5">
                                        <i class="ph-bold ph-warning"></i>
                                        <span>Tantangan &amp; Pembelajaran</span>
                                    </h3>
                                    <p class="text-sm md:text-base text-retro-text font-medium leading-relaxed font-sans whitespace-pre-line"><?= e($project['challenge_description']) ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                </div>

                <!-- Right Sidebar Column (4 cols) -->
                <div class="lg:col-span-4 space-y-6">
                    
                    <!-- Tech Stack Widget -->
                    <div class="bg-retro-bg retro-border rounded-xl p-6 space-y-4">
                        <div class="font-mono text-xs md:text-sm font-bold text-retro-text uppercase tracking-wider pb-3 border-b-2 border-retro-border flex items-center justify-between">
                            <span>STACK_DIGUNAKAN</span>
                            <i class="ph-bold ph-code text-retro-accent text-base"></i>
                        </div>
                        <?php if (!empty($technologies)): ?>
                            <div class="flex flex-wrap gap-2">
                                <?php foreach ($technologies as $tech): ?>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-mono font-bold text-retro-text bg-retro-card rounded-lg border border-retro-border shadow-xs">
                                        <i class="ph-bold ph-circle text-[8px] text-retro-accent"></i>
                                        <?= e($tech['name']) ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-xs font-mono text-retro-text/70">Tidak ada data teknologi.</p>
                        <?php endif; ?>
                    </div>

                    <!-- Metadata Status Widget -->
                    <div class="bg-retro-bg retro-border rounded-xl p-6 space-y-4 font-mono text-xs">
                        <div class="font-bold text-retro-text uppercase tracking-wider pb-3 border-b-2 border-retro-border flex items-center justify-between text-xs md:text-sm">
                            <span>INFO_META.SYS</span>
                            <i class="ph-bold ph-info text-retro-accent text-base"></i>
                        </div>

                        <div class="space-y-3">
                            <div class="flex items-center justify-between pb-2 border-b border-retro-border/20">
                                <span class="text-retro-text/75">Status Pengerjaan</span>
                                <span class="px-2 py-0.5 rounded bg-green-100 text-green-900 border border-green-800 font-bold text-[10px]">
                                    <?= e($project['project_status'] ?? 'Selesai') ?>
                                </span>
                            </div>

                            <div class="flex items-center justify-between pb-2 border-b border-retro-border/20">
                                <span class="text-retro-text/75">Mulai Pengerjaan</span>
                                <span class="font-bold text-retro-text">
                                    <?= date('d M Y', strtotime($project['start_date'])) ?>
                                </span>
                            </div>

                            <div class="flex items-center justify-between pb-2 border-b border-retro-border/20">
                                <span class="text-retro-text/75">Selesai Pengerjaan</span>
                                <span class="font-bold text-retro-text">
                                    <?= $project['end_date'] ? date('d M Y', strtotime($project['end_date'])) : 'Masih Berjalan' ?>
                                </span>
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="text-retro-text/75">Kategori</span>
                                <span class="font-bold text-retro-accent">
                                    <?= e($project['category_name'] ?? 'Proyek') ?>
                                </span>
                            </div>
                        </div>

                        <!-- Direct links in sidebar -->
                        <div hidden class="pt-3 space-y-2">
                            <?php if (!empty($project['demo_url'])): ?>
                                <a href="<?= e($project['demo_url']) ?>" target="_blank" rel="noopener noreferrer"
                                   class="w-full py-2.5 px-4 rounded-xl bg-retro-accent text-white font-mono font-bold text-xs retro-border retro-shadow-sm retro-btn flex items-center justify-center gap-2 hover:opacity-95 transition-all">
                                    <i class="ph-bold ph-arrow-square-out text-base"></i>
                                    <span>Buka Live Demo</span>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($project['github_url'])): ?>
                                <a href="<?= e($project['github_url']) ?>" target="_blank" rel="noopener noreferrer"
                                   class="w-full py-2.5 px-4 rounded-xl bg-retro-card hover:bg-retro-secondary text-retro-text font-mono font-bold text-xs retro-border retro-shadow-sm retro-btn flex items-center justify-center gap-2 transition-colors">
                                    <i class="ph-bold ph-github-logo text-base"></i>
                                    <span>Buka Repository</span>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>

            </div>

            <!-- Gallery Multi-media Documentation (Bottom) -->
            <?php if (!empty($mediaItems)): ?>
                <div class="pt-8 border-t-2 border-retro-border space-y-5">
                    <div class="flex items-center justify-between font-mono text-xs md:text-sm font-bold text-retro-text">
                        <span class="flex items-center gap-2">
                            <i class="ph-bold ph-images text-retro-accent text-base"></i>
                            DOKUMENTASI_TANGKAPAN_LAYAR.LOG
                        </span>
                        <span class="px-2.5 py-0.5 rounded bg-retro-secondary retro-border text-xs">
                            <?= count($mediaItems) ?> Berkas Gambar
                        </span>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        <?php foreach ($mediaItems as $media): ?>
                            <a href="<?= route($media['file_path']) ?>" 
                               class="glightbox retro-border rounded-xl overflow-hidden shadow-xs flex flex-col hover:scale-102 transition-transform duration-200 relative group aspect-video bg-retro-secondary"
                               data-gallery="gallery_proj" 
                               data-title="<?= e($media['title'] ?? '') ?>" 
                               data-description="<?= e($media['description'] ?? '') ?>">
                                
                                <?php 
                                $thumbPath = str_replace('projects/gallery/', 'projects/gallery/thumbs/thumb_', $media['file_path']);
                                if (is_file(public_path($thumbPath))): 
                                ?>
                                    <img src="<?= route($thumbPath) ?>" alt="<?= e($media['alt_text'] ?? '') ?>" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <img src="<?= route($media['file_path']) ?>" alt="<?= e($media['alt_text'] ?? '') ?>" class="w-full h-full object-cover">
                                <?php endif; ?>
                                
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white">
                                    <i class="ph-bold ph-magnifying-glass-plus text-2xl"></i>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </article>

</div>

<?php require dirname(__DIR__) . '/layouts/footer.php'; ?>

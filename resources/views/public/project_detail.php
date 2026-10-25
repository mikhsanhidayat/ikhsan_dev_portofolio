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

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    <!-- Breadcrumb -->
    <nav class="mb-6 flex items-center justify-between">
        <a href="/#proyek" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-slate-800 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Daftar Proyek
        </a>
    </nav>

    <!-- Project Title Header -->
    <div class="space-y-4 mb-8">
        <span class="inline-flex items-center rounded-md bg-blue-50 px-2.5 py-1 text-xs font-bold text-blue-700 ring-1 ring-inset ring-blue-700/10 uppercase tracking-wider">
            <?= e($project['category_name']) ?>
        </span>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold font-heading text-slate-800 leading-tight">
            <?= e($project['title']) ?>
        </h1>
        <p class="text-slate-500 text-sm max-w-3xl leading-relaxed font-light">
            <?= e($project['summary']) ?>
        </p>
    </div>

    <!-- Main Grid layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Left: Narratives Story Column (8 cols) -->
        <div class="lg:col-span-8 space-y-8">
            
            <!-- Cover image large -->
            <div class="bg-slate-200 border border-slate-200 rounded-2xl overflow-hidden shadow-sm aspect-video flex items-center justify-center">
                <?php if ($project['cover_image']): ?>
                    <img src="<?= route($project['cover_image']) ?>" alt="<?= e($project['title']) ?>" class="w-full h-full object-cover">
                <?php else: ?>
                    <i data-lucide="image" class="w-16 h-16 text-slate-400"></i>
                <?php endif; ?>
            </div>

            <!-- Narratives detailed content cards -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 md:p-8 shadow-sm space-y-8">
                
                <!-- Background & Objective -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest flex items-center gap-1.5">
                            <i data-lucide="help-circle" class="w-4 h-4"></i> Masalah / Latar Belakang
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-light whitespace-pre-line"><?= e($project['background']) ?></p>
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest flex items-center gap-1.5">
                            <i data-lucide="target" class="w-4 h-4"></i> Tujuan Proyek
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-light whitespace-pre-line"><?= e($project['objective']) ?></p>
                    </div>
                </div>

                <hr class="border-slate-100">

                <!-- Solution & Role -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest flex items-center gap-1.5">
                            <i data-lucide="check-circle" class="w-4 h-4"></i> Solusi yang Dibangun
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-light whitespace-pre-line"><?= e($project['solution']) ?></p>
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest flex items-center gap-1.5">
                            <i data-lucide="user-check" class="w-4 h-4"></i> Peran & Tanggung Jawab Anda
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-light whitespace-pre-line"><?= e($project['role_description']) ?></p>
                    </div>
                </div>

                <hr class="border-slate-100">

                <!-- Process -->
                <div class="space-y-2">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest flex items-center gap-1.5">
                        <i data-lucide="git-branch" class="w-4 h-4"></i> Proses & Tahapan Pengerjaan
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-light whitespace-pre-line"><?= e($project['process_description']) ?></p>
                </div>

                <hr class="border-slate-100">

                <!-- Features & Results -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest flex items-center gap-1.5">
                            <i data-lucide="layers" class="w-4 h-4"></i> Fitur Utama
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-light whitespace-pre-line"><?= e($project['feature_description']) ?></p>
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest flex items-center gap-1.5">
                            <i data-lucide="trending-up" class="w-4 h-4"></i> Hasil & Dampak Nyata
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-light whitespace-pre-line"><?= e($project['result_description']) ?></p>
                    </div>
                </div>

                <!-- Challenges (if present) -->
                <?php if (!empty($project['challenge_description'])): ?>
                    <hr class="border-slate-100">
                    <div class="space-y-2 bg-yellow-50/50 border border-yellow-100 rounded-xl p-4">
                        <h3 class="text-xs font-bold text-yellow-800 uppercase tracking-widest flex items-center gap-1.5">
                            <i data-lucide="alert-triangle" class="w-4 h-4"></i> Tantangan & Pembelajaran
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-light whitespace-pre-line"><?= e($project['challenge_description']) ?></p>
                    </div>
                <?php endif; ?>

            </div>

        </div>

        <!-- Right: Sidebar Widget Column (4 cols) -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Metadata widget -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm space-y-5">
                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider pb-3 border-b border-slate-100">
                    Detail Proyek
                </h3>

                <div class="space-y-4">
                    <div class="flex items-center justify-between text-xs pb-3 border-b border-slate-50">
                        <span class="text-slate-400 font-medium">Status</span>
                        <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 font-bold text-green-700 ring-1 ring-inset ring-green-600/20">
                            <?= e($project['project_status']) ?>
                        </span>
                    </div>

                    <div class="flex items-center justify-between text-xs pb-3 border-b border-slate-50">
                        <span class="text-slate-400 font-medium">Periode Pengerjaan</span>
                        <span class="font-semibold text-slate-800 font-mono">
                            <?= date('M Y', strtotime($project['start_date'])) ?> - 
                            <?= $project['end_date'] ? date('M Y', strtotime($project['end_date'])) : 'Sekarang' ?>
                        </span>
                    </div>

                    <?php if (!empty($project['demo_url'])): ?>
                        <a href="<?= e($project['demo_url']) ?>" target="_blank"
                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-md transition-colors focus:outline-none">
                            <i data-lucide="external-link" class="w-4 h-4"></i> Kunjungi Live Demo
                        </a>
                    <?php endif; ?>

                    <?php if (!empty($project['github_url'])): ?>
                        <a href="<?= e($project['github_url']) ?>" target="_blank"
                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 text-xs font-bold text-slate-700 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-lg transition-colors focus:outline-none">
                            <i data-lucide="github" class="w-4 h-4"></i> Repository GitHub
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- YouTube video player widget (if present) -->
            <?php if ($youtubeEmbedUrl): ?>
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
                    <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider p-6 pb-3 border-b border-slate-100 bg-white">
                        Presentasi Video Demo
                    </h3>
                    <div class="aspect-video w-full bg-slate-900">
                        <iframe src="<?= $youtubeEmbedUrl ?>" class="w-full h-full" allowfullscreen allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Technologies widget -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm space-y-4">
                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider pb-3 border-b border-slate-100">
                    Teknologi Digunakan
                </h3>
                <div class="flex flex-wrap gap-2">
                    <?php foreach ($technologies as $tech): ?>
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-semibold text-slate-700 bg-slate-50 rounded border border-slate-200 shadow-sm leading-none">
                            <?php if ($tech['icon']): ?>
                                <i data-lucide="<?= e($tech['icon']) ?>" class="w-3.5 h-3.5 text-slate-400"></i>
                            <?php endif; ?>
                            <?= e($tech['name']) ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>

    </div>

    <!-- Gallery Multi-media documentation section (bottom) -->
    <?php if (!empty($mediaItems)): ?>
        <div class="mt-12 bg-white rounded-2xl border border-slate-200 p-6 md:p-8 shadow-sm space-y-6">
            <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider pb-3 border-b border-slate-100 flex items-center gap-2">
                <i data-lucide="images" class="w-5 h-5 text-blue-600"></i> Galeri Dokumentasi Proyek
            </h3>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                <?php foreach ($mediaItems as $media): ?>
                    <!-- Link tag triggers GLightbox -->
                    <a href="<?= route($media['file_path']) ?>" 
                       class="glightbox border border-slate-200 rounded-xl overflow-hidden shadow-sm flex flex-col hover:border-blue-500 hover:shadow-md transition-all duration-300 relative group aspect-video"
                       data-gallery="gallery_proj" 
                       data-title="<?= e($media['title']) ?>" 
                       data-description="<?= e($media['description']) ?>">
                        
                        <!-- Thumbnail photo image -->
                        <?php 
                        $thumbPath = str_replace('projects/gallery/', 'projects/gallery/thumbs/thumb_', $media['file_path']);
                        if (is_file(public_path($thumbPath))): 
                        ?>
                            <img src="<?= route($thumbPath) ?>" alt="<?= e($media['alt_text']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        <?php else: ?>
                            <img src="<?= route($media['file_path']) ?>" alt="<?= e($media['alt_text']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        <?php endif; ?>
                        
                        <!-- Hover icon overlays -->
                        <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <i data-lucide="zoom-in" class="w-8 h-8 text-white"></i>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

</div>

<?php require dirname(__DIR__) . '/layouts/footer.php'; ?>

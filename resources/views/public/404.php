<?php require dirname(__DIR__) . '/layouts/header.php'; ?>

<div class="max-w-[1380px] w-[92%] mx-auto py-16 md:py-24 min-h-[calc(100vh-14rem)] flex items-center justify-center">
    <!-- OS Alert Dialog Window: ERR_404_NOT_FOUND.SYS -->
    <div class="w-full max-w-xl bg-retro-card retro-border retro-shadow rounded-2xl overflow-hidden">
        
        <!-- Dialog Title Bar -->
        <div class="bg-retro-secondary border-b-2 border-retro-border px-5 py-3 flex items-center justify-between font-mono text-xs md:text-sm font-bold">
            <div class="flex items-center gap-2.5">
                <span class="w-3 h-3 rounded-full bg-[#FF5F56] border border-black inline-block"></span>
                <span class="w-3 h-3 rounded-full bg-[#FFBD2E] border border-black inline-block"></span>
                <span class="w-3 h-3 rounded-full bg-[#27C93F] border border-black inline-block"></span>
                <span class="ml-2 tracking-wider text-retro-text">ERR_404_NOT_FOUND.SYS</span>
            </div>
            <span class="px-2.5 py-0.5 rounded bg-retro-accent text-white font-bold text-[10px] tracking-wider">
                CRITICAL_ALERT
            </span>
        </div>

        <!-- Dialog Body -->
        <div class="p-6 sm:p-10 text-center space-y-6 bg-retro-card">
            
            <!-- Warning Icon & Error Code -->
            <div class="flex flex-col items-center justify-center space-y-3">
                <div class="w-16 h-16 rounded-2xl bg-retro-secondary retro-border flex items-center justify-center text-4xl text-retro-accent shadow-xs">
                    <i class="ph-bold ph-warning-octagon"></i>
                </div>
                <h1 class="text-7xl sm:text-8xl font-black font-serif text-retro-accent leading-none tracking-tight">404</h1>
                <p class="font-mono text-xs sm:text-sm font-bold text-retro-text uppercase tracking-widest">
                    [EXCEPTION: FILE_OR_ROUTE_NOT_FOUND]
                </p>
            </div>

            <!-- Description -->
            <div class="space-y-3 max-w-md mx-auto">
                <p class="text-sm md:text-base text-retro-text font-medium font-sans leading-relaxed">
                    Sistem mendeteksi bahwa tautan, berkas, atau halaman yang Anda minta tidak tersedia atau telah dipindahkan dari direktori server.
                </p>
                
                <!-- System Diagnostics Box -->
                <div class="p-4 bg-retro-bg rounded-xl retro-border font-mono text-xs text-retro-text/85 text-left space-y-1 shadow-inner">
                    <div class="text-retro-accent font-bold pb-1 border-b border-retro-border/20">// DIAGNOSTIK_SERVER</div>
                    <div>STATUS : HTTP/1.1 404 Not Found</div>
                    <div class="truncate">ALAMAT : <?= e($_SERVER['REQUEST_URI'] ?? '/unknown') ?></div>
                    <div>TINDAKAN: Rerouting ke beranda disarankan</div>
                </div>
            </div>

            <!-- Action Button -->
            <div class="pt-2">
                <a href="/#beranda" class="inline-flex items-center gap-2 px-7 py-3.5 rounded-xl bg-retro-accent text-white font-mono font-bold text-sm md:text-base retro-border retro-shadow-sm retro-btn hover:opacity-95 transition-all">
                    <i class="ph-bold ph-house text-lg"></i>
                    <span>Kembali ke Beranda Utama</span>
                </a>
            </div>
        </div>

    </div>
</div>

<?php 
if (!isset($settings)) {
    $settings = [
        'footer_text' => 'M. Ikhsan Hidayat. Portofolio Minimalist Retro.'
    ];
}
if (!isset($profile)) {
    $profile = [
        'full_name' => 'M. Ikhsan Hidayat',
        'email' => 'ikhsanhidayatmuhamad@gmail.com',
        'whatsapp' => '+6282119491906',
    ];
}
require dirname(__DIR__) . '/layouts/footer.php'; 
?>

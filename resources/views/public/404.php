<?php require dirname(__DIR__) . '/layouts/header.php'; ?>

<div class="flex-grow flex items-center justify-center py-20 px-4">
    <div class="max-w-md w-full text-center space-y-6">
        
        <!-- Animated 404 Visual -->
        <div class="relative">
            <h1 class="text-9xl font-extrabold text-blue-600/10 font-heading select-none leading-none">404</h1>
            <div class="absolute inset-0 flex items-center justify-center">
                <i data-lucide="help-circle" class="w-16 h-16 text-blue-600 animate-bounce"></i>
            </div>
        </div>

        <div class="space-y-2">
            <h2 class="text-2xl font-bold font-heading text-slate-800">Halaman Tidak Ditemukan</h2>
            <p class="text-xs text-slate-500 max-w-sm mx-auto">
                Maaf, berkas atau tautan halaman yang Anda tuju tidak tersedia, dipindahkan, atau tidak ditemukan.
            </p>
        </div>

        <div>
            <a href="/" class="inline-flex items-center gap-2 px-5 py-2.5 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-md transition-colors focus:outline-none">
                <i data-lucide="home" class="w-4 h-4"></i> Kembali ke Beranda
            </a>
        </div>

    </div>
</div>

<?php 
// Render mini footer to satisfy layout requirements
// Since footer requires $settings, let's create a minimal settings block if not present
if (!isset($settings)) {
    $settings = [
        'footer_text' => 'M. Ikhsanul Karim. Portofolio Mahasiswa D3 Manajemen Informatika.'
    ];
}
if (!isset($profile)) {
    $profile = [];
}
require dirname(__DIR__) . '/layouts/footer.php'; 
?>

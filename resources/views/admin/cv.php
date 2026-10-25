<?php require dirname(__DIR__) . '/layouts/admin_header.php'; ?>

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl border border-slate-200 p-6 md:p-8 shadow-sm">
        
        <div class="flex items-center justify-between pb-6 border-b border-slate-100 mb-6">
            <div>
                <h2 class="text-lg font-bold font-heading text-slate-800">Manajemen Curriculum Vitae (CV)</h2>
                <p class="text-xs text-slate-500">Unggah berkas CV format PDF. Tombol unduh CV di halaman publik hanya akan tampil jika berkas tersedia.</p>
            </div>
            <i data-lucide="file-text" class="w-8 h-8 text-slate-400"></i>
        </div>

        <!-- Status CV Aktif -->
        <div class="mb-8">
            <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">CV Aktif Saat Ini</h3>
            
            <?php if ($cv): ?>
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-red-50 text-red-600 rounded-lg flex-shrink-0 border border-red-100">
                            <i data-lucide="file-text" class="w-8 h-8"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-800 truncate max-w-[280px]" title="<?= e($cv['original_name']) ?>">
                                <?= e($cv['original_name']) ?>
                            </p>
                            <p class="text-[10px] text-slate-400 font-medium">Diunggah pada: <?= date('d-m-Y H:i', strtotime($cv['created_at'])) ?></p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <a href="<?= route($cv['file_path']) ?>" target="_blank" 
                            class="flex-1 sm:flex-none inline-flex items-center justify-center gap-1.5 px-3 py-2 text-xs font-bold text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 rounded-lg transition-colors shadow-sm">
                            <i data-lucide="eye" class="w-3.5 h-3.5"></i> Lihat
                        </a>
                        <form action="/admin/cv/delete" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berkas CV ini?');" class="flex-1 sm:flex-none">
                            <?= csrf_field() ?>
                            <button type="submit" 
                                class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-2 text-xs font-bold text-red-600 bg-red-50 border border-red-200 hover:bg-red-100 rounded-lg transition-colors">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <div class="border-2 border-dashed border-slate-200 rounded-xl p-8 text-center text-slate-400">
                    <i data-lucide="file-warning" class="w-10 h-10 mx-auto mb-2 text-slate-300"></i>
                    <p class="text-sm font-semibold">Belum ada berkas CV yang diunggah.</p>
                    <p class="text-xs text-slate-400 mt-1">Gunakan form di bawah untuk mengunggah CV pertama Anda.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Form Unggah CV -->
        <div class="pt-6 border-t border-slate-100">
            <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-4">Unggah / Ganti Berkas CV</h3>
            
            <form action="/admin/cv" method="POST" enctype="multipart/form-data" class="space-y-4">
                <?= csrf_field() ?>
                
                <div>
                    <label for="cv_file" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pilih Berkas PDF <span class="text-red-500">*</span></label>
                    <input type="file" name="cv_file" id="cv_file" accept="application/pdf" required
                        class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="text-[10px] text-slate-400 mt-2">Maksimal 10 MB. Hanya menerima format PDF asli.</p>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit" id="upload-cv-btn"
                        class="inline-flex items-center justify-center gap-2 px-5 py-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm transition-colors focus:outline-none">
                        <i data-lucide="upload-cloud" class="w-4 h-4"></i> Unggah CV
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Handle Loading State
    const form = document.querySelector('form[action="/admin/cv"]');
    const uploadBtn = document.getElementById('upload-cv-btn');

    if (form && uploadBtn) {
        form.addEventListener('submit', () => {
            uploadBtn.disabled = true;
            uploadBtn.innerHTML = '<span class="inline-block animate-spin border-2 border-white border-t-transparent rounded-full w-4 h-4"></span> Mengunggah...';
        });
    }
</script>

<?php require dirname(__DIR__) . '/layouts/admin_footer.php'; ?>

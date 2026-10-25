<?php require dirname(__DIR__, 2) . '/layouts/admin_header.php'; ?>

<div class="space-y-6 max-w-6xl mx-auto">
    <!-- Back to Projects link -->
    <div>
        <a href="/admin/projects" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-slate-800 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Daftar Proyek
        </a>
    </div>

    <!-- Main Grid layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left: Upload Photo Form -->
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm h-fit">
            <h3 class="text-sm font-bold text-slate-700 pb-3 border-b border-slate-100 mb-4 flex items-center gap-2">
                <i data-lucide="plus-circle" class="w-4 h-4 text-slate-500"></i> Tambah Foto Baru
            </h3>
            
            <form action="/admin/projects/gallery/<?= $project['id'] ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
                <?= csrf_field() ?>
                
                <div>
                    <label for="media_file" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Pilih Berkas Foto <span class="text-red-500">*</span></label>
                    <input type="file" name="media_file" id="media_file" accept="image/*" required
                        class="block w-full text-xs text-slate-500 file:mr-4 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="text-[9px] text-slate-400 mt-1">Maksimal 5 MB. JPG, JPEG, PNG, WebP.</p>
                </div>

                <div>
                    <label for="title" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Judul Foto <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" required
                        class="block w-full border border-slate-300 rounded-lg px-3 py-1.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                        placeholder="Contoh: Halaman Dashboard Utama">
                </div>

                <div>
                    <label for="description" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Deskripsi Detail Foto <span class="text-red-500">*</span></label>
                    <textarea name="description" id="description" rows="3" required
                        class="block w-full border border-slate-300 rounded-lg px-3 py-1.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                        placeholder="Jelaskan fungsi komponen/fitur yang tertampil di gambar ini..."></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="alt_text" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Alt Text (Aksesibilitas)</label>
                        <input type="text" name="alt_text" id="alt_text"
                            class="block w-full border border-slate-300 rounded-lg px-3 py-1.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                            placeholder="Deskripsi singkat gambar">
                    </div>
                    <div>
                        <label for="sort_order" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Urutan</label>
                        <input type="number" name="sort_order" id="sort_order" value="0" min="0"
                            class="block w-full border border-slate-300 rounded-lg px-3 py-1.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                    </div>
                </div>

                <div class="flex items-center pt-2">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" checked class="sr-only peer">
                        <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600 relative after:top-[2px] after:left-[2px]"></div>
                        <span class="ml-2 text-xs font-bold text-slate-600">Aktif (Tampilkan)</span>
                    </label>
                </div>

                <div class="pt-3 border-t border-slate-100 flex justify-end">
                    <button type="submit" id="upload-btn"
                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm transition-colors focus:outline-none">
                        <i data-lucide="upload-cloud" class="w-4 h-4"></i> Unggah Foto
                    </button>
                </div>
            </form>
        </div>

        <!-- Right: Current Media Grid -->
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
                <h3 class="text-sm font-bold text-slate-700 pb-3 border-b border-slate-100 mb-6 flex items-center gap-2">
                    <i data-lucide="images" class="w-5 h-5 text-slate-500"></i> Galeri Dokumentasi Foto
                </h3>
                
                <?php if (empty($mediaItems)): ?>
                    <div class="text-center py-16 text-slate-400">
                        <i data-lucide="image-off" class="w-12 h-12 mx-auto mb-3 text-slate-300"></i>
                        <h4 class="font-bold text-slate-700">Belum ada Foto Dokumentasi</h4>
                        <p class="text-xs mt-1">Gunakan formulir sebelah kiri untuk mengunggah foto dokumentasi proyek pertama Anda.</p>
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php foreach ($mediaItems as $media): ?>
                            <div class="border border-slate-200 rounded-xl overflow-hidden shadow-sm flex flex-col bg-slate-50 relative group">
                                
                                <!-- Active/Inactive Badge -->
                                <div class="absolute top-2 left-2 z-10">
                                    <?php if ($media['is_active']): ?>
                                        <span class="bg-green-500/80 text-white font-bold text-[9px] uppercase px-2 py-0.5 rounded backdrop-blur">Aktif</span>
                                    <?php else: ?>
                                        <span class="bg-slate-500/80 text-white font-bold text-[9px] uppercase px-2 py-0.5 rounded backdrop-blur">Draft</span>
                                    <?php endif; ?>
                                </div>

                                <!-- Photo Container -->
                                <div class="w-full h-40 bg-slate-200 border-b border-slate-200 overflow-hidden flex items-center justify-center relative">
                                    <?php 
                                    $thumbPath = str_replace('projects/gallery/', 'projects/gallery/thumbs/thumb_', $media['file_path']);
                                    if (is_file(public_path($thumbPath))): 
                                    ?>
                                        <img src="<?= route($thumbPath) ?>" alt="<?= e($media['alt_text']) ?>" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <i data-lucide="image" class="w-8 h-8 text-slate-400"></i>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Meta Description -->
                                <div class="p-4 flex-grow space-y-1">
                                    <div class="flex justify-between items-start">
                                        <h4 class="text-xs font-bold text-slate-800 line-clamp-1" title="<?= e($media['title']) ?>"><?= e($media['title']) ?></h4>
                                        <span class="text-[10px] font-mono font-bold text-slate-400">Urutan: <?= $media['sort_order'] ?></span>
                                    </div>
                                    <p class="text-[11px] text-slate-500 line-clamp-2" title="<?= e($media['description']) ?>">
                                        <?= e($media['description']) ?>
                                    </p>
                                </div>
                                
                                <!-- Actions Footer -->
                                <div class="px-4 py-2.5 bg-white border-t border-slate-100 flex justify-end gap-2">
                                    <button 
                                        onclick="openEditModal(<?= htmlspecialchars(json_encode($media)) ?>)"
                                        class="inline-flex items-center gap-1 px-2.5 py-1 text-[11px] font-bold text-slate-700 bg-slate-50 hover:bg-slate-100 rounded border border-slate-300 transition-colors">
                                        <i data-lucide="edit-2" class="w-3 h-3"></i> Edit
                                    </button>
                                    <form action="/admin/projects/gallery/delete/<?= $media['id'] ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto dokumentasi ini dari server?');">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="project_id" value="<?= $project['id'] ?>">
                                        <button type="submit" 
                                            class="inline-flex items-center gap-1 px-2.5 py-1 text-[11px] font-bold text-red-600 bg-red-50 hover:bg-red-100 rounded border border-red-200 transition-colors">
                                            <i data-lucide="trash-2" class="w-3 h-3"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- ================= EDIT MEDIA MODAL ================= -->
<div id="edit-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeEditModal()"></div>
    <div class="relative bg-white rounded-xl shadow-lg border border-slate-200 w-full max-w-md p-6 overflow-hidden mx-4 animate-in fade-in zoom-in-95 duration-200">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
            <h3 class="text-base font-bold font-heading text-slate-800">Edit Metadata Foto Galeri</h3>
            <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form id="edit-form" action="" method="POST" enctype="multipart/form-data" class="space-y-4">
            <?= csrf_field() ?>
            <input type="hidden" name="project_id" value="<?= $project['id'] ?>">
            
            <div>
                <label for="edit-file" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Ganti File Gambar (Kosongkan jika tidak diubah)</label>
                <input type="file" name="media_file" id="edit-file" accept="image/*"
                    class="block w-full text-xs text-slate-500 file:mr-4 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <p class="text-[9px] text-slate-400 mt-1">Maksimal 5 MB.</p>
            </div>

            <div>
                <label for="edit-title" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Judul Foto <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="edit-title" required
                    class="block w-full border border-slate-300 rounded-lg px-3 py-1.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            </div>

            <div>
                <label for="edit-description" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Deskripsi Detail Foto <span class="text-red-500">*</span></label>
                <textarea name="description" id="edit-description" rows="3" required
                    class="block w-full border border-slate-300 rounded-lg px-3 py-1.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="edit-alt" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Alt Text</label>
                    <input type="text" name="alt_text" id="edit-alt"
                        class="block w-full border border-slate-300 rounded-lg px-3 py-1.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                </div>
                <div>
                    <label for="edit-order" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Urutan</label>
                    <input type="number" name="sort_order" id="edit-order" min="0"
                        class="block w-full border border-slate-300 rounded-lg px-3 py-1.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                </div>
            </div>

            <div class="flex items-center pt-2">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" id="edit-active" value="1" class="sr-only peer">
                    <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600 relative after:top-[2px] after:left-[2px]"></div>
                    <span class="ml-2 text-xs font-bold text-slate-600">Aktif (Tampilkan)</span>
                </label>
            </div>

            <div class="pt-4 flex justify-end gap-2 border-t border-slate-100">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 text-xs font-bold text-slate-500 hover:bg-slate-100 rounded-lg transition-colors border border-slate-200">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const editModal = document.getElementById('edit-modal');
    const editForm = document.getElementById('edit-form');
    
    // Add form loading state
    const addForm = document.querySelector('form[action^="/admin/projects/gallery/"]');
    const uploadBtn = document.getElementById('upload-btn');
    if (addForm && uploadBtn) {
        addForm.addEventListener('submit', () => {
            uploadBtn.disabled = true;
            uploadBtn.innerHTML = '<span class="inline-block animate-spin border-2 border-white border-t-transparent rounded-full w-4 h-4"></span> Mengunggah...';
        });
    }

    function openEditModal(media) {
        document.getElementById('edit-title').value = media.title;
        document.getElementById('edit-description').value = media.description;
        document.getElementById('edit-alt').value = media.alt_text || '';
        document.getElementById('edit-order').value = media.sort_order;
        document.getElementById('edit-active').checked = parseInt(media.is_active) === 1;

        editForm.setAttribute('action', '/admin/projects/gallery/edit/' + media.id);
        editModal.classList.remove('hidden');
        lucide.createIcons();
    }

    function closeEditModal() {
        editModal.classList.add('hidden');
    }

    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeEditModal();
        }
    });
</script>

<?php require dirname(__DIR__, 2) . '/layouts/admin_footer.php'; ?>

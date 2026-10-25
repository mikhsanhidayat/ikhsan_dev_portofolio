<?php require dirname(__DIR__) . '/layouts/admin_header.php'; ?>

<div class="space-y-6">
    <!-- Top Actions -->
    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs text-slate-500">Kelola kategori proyek untuk membagi pengelompokan portofolio Anda.</p>
        </div>
        <button onclick="openAddModal()" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm transition-colors focus:outline-none">
            <i data-lucide="plus-circle" class="w-4 h-4"></i> Tambah Kategori
        </button>
    </div>

    <!-- Categories Table -->
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <?php if (empty($categories)): ?>
                <div class="text-center py-12 text-slate-400">
                    <i data-lucide="folder-heart" class="w-12 h-12 mx-auto mb-3 text-slate-300"></i>
                    <h3 class="font-bold text-slate-700">Belum ada Kategori</h3>
                    <p class="text-xs mt-1">Klik tombol 'Tambah Kategori' untuk memasukkan data pertama.</p>
                </div>
            <?php else: ?>
                <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                        <tr>
                            <th class="px-6 py-3">Nama Kategori</th>
                            <th class="px-6 py-3">Slug (URL)</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-600">
                        <?php foreach ($categories as $cat): ?>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 font-semibold text-slate-800"><?= e($cat['name']) ?></td>
                                <td class="px-6 py-4 font-mono text-xs text-slate-500"><?= e($cat['slug']) ?></td>
                                <td class="px-6 py-4">
                                    <?php if ($cat['is_active']): ?>
                                        <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-bold text-green-700 ring-1 ring-inset ring-green-600/20">Aktif</span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center rounded-md bg-slate-100 px-2 py-1 text-xs font-bold text-slate-500 ring-1 ring-inset ring-slate-600/10">Non-aktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button 
                                            onclick="openEditModal(<?= htmlspecialchars(json_encode($cat)) ?>)"
                                            class="p-1 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors"
                                            title="Edit">
                                            <i data-lucide="edit-2" class="w-4 h-4"></i>
                                        </button>
                                        <form action="/admin/categories/delete/<?= $cat['id'] ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');" class="inline">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="p-1 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded transition-colors" title="Hapus">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- ================= ADD MODAL ================= -->
<div id="add-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeAddModal()"></div>
    <div class="relative bg-white rounded-xl shadow-lg border border-slate-200 w-full max-w-md p-6 overflow-hidden mx-4 animate-in fade-in zoom-in-95 duration-200">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
            <h3 class="text-base font-bold font-heading text-slate-800">Tambah Kategori Baru</h3>
            <button onclick="closeAddModal()" class="text-slate-400 hover:text-slate-600">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form action="/admin/categories" method="POST" class="space-y-4">
            <?= csrf_field() ?>
            
            <div>
                <label for="add-name" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Nama Kategori <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="add-name" required
                    class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                    placeholder="Contoh: Proyek KKN, Tugas Kuliah, Proyek Pribadi">
            </div>

            <div class="flex items-center pt-2">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" checked class="sr-only peer">
                    <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600 relative after:top-[2px] after:left-[2px]"></div>
                    <span class="ml-2 text-xs font-bold text-slate-600">Aktif</span>
                </label>
            </div>

            <div class="pt-4 flex justify-end gap-2 border-t border-slate-100">
                <button type="button" onclick="closeAddModal()" class="px-4 py-2 text-xs font-bold text-slate-500 hover:bg-slate-100 rounded-lg transition-colors border border-slate-200">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ================= EDIT MODAL ================= -->
<div id="edit-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeEditModal()"></div>
    <div class="relative bg-white rounded-xl shadow-lg border border-slate-200 w-full max-w-md p-6 overflow-hidden mx-4 animate-in fade-in zoom-in-95 duration-200">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
            <h3 class="text-base font-bold font-heading text-slate-800">Edit Kategori</h3>
            <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form id="edit-form" action="" method="POST" class="space-y-4">
            <?= csrf_field() ?>
            
            <div>
                <label for="edit-name" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Nama Kategori <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="edit-name" required
                    class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            </div>

            <div class="flex items-center pt-2">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" id="edit-active" value="1" class="sr-only peer">
                    <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600 relative after:top-[2px] after:left-[2px]"></div>
                    <span class="ml-2 text-xs font-bold text-slate-600">Aktif</span>
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
    const addModal = document.getElementById('add-modal');
    const editModal = document.getElementById('edit-modal');
    const editForm = document.getElementById('edit-form');

    function openAddModal() {
        addModal.classList.remove('hidden');
    }
    function closeAddModal() {
        addModal.classList.add('hidden');
    }

    function openEditModal(cat) {
        document.getElementById('edit-name').value = cat.name;
        document.getElementById('edit-active').checked = parseInt(cat.is_active) === 1;

        editForm.setAttribute('action', '/admin/categories/edit/' + cat.id);
        editModal.classList.remove('hidden');
        lucide.createIcons();
    }
    
    function closeEditModal() {
        editModal.classList.add('hidden');
    }

    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeAddModal();
            closeEditModal();
        }
    });
</script>

<?php require dirname(__DIR__) . '/layouts/admin_footer.php'; ?>

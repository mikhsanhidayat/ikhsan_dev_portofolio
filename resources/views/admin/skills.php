<?php require dirname(__DIR__) . '/layouts/admin_header.php'; ?>

<div class="space-y-6">
    <!-- Top Actions -->
    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs text-slate-500">Daftar kompetensi teknis dan soft skill yang akan ditampilkan pada halaman beranda publik.</p>
        </div>
        <button onclick="openAddModal()" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm transition-colors focus:outline-none">
            <i data-lucide="plus-circle" class="w-4 h-4"></i> Tambah Keahlian
        </button>
    </div>

    <!-- Skills Table -->
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <?php if (empty($skills)): ?>
                <div class="text-center py-12 text-slate-400">
                    <i data-lucide="award" class="w-12 h-12 mx-auto mb-3 text-slate-300"></i>
                    <h3 class="font-bold text-slate-700">Belum ada Keahlian</h3>
                    <p class="text-xs mt-1">Klik tombol 'Tambah Keahlian' untuk menambahkan data keahlian pertama Anda.</p>
                </div>
            <?php else: ?>
                <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                        <tr>
                            <th class="px-6 py-3">Nama Keahlian</th>
                            <th class="px-6 py-3">Kategori</th>
                            <th class="px-6 py-3">Pemahaman</th>
                            <th class="px-6 py-3 text-center">Urutan</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-600">
                        <?php foreach ($skills as $skill): ?>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 font-semibold text-slate-800"><?= e($skill['name']) ?></td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center rounded-md bg-slate-50 px-2 py-1 text-xs font-semibold text-slate-600 ring-1 ring-inset ring-slate-500/10">
                                        <?= e($skill['category']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <?php if ($skill['proficiency_level']): ?>
                                        <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-semibold text-blue-700 ring-1 ring-inset ring-blue-700/10">
                                            <?= e($skill['proficiency_level']) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-slate-400 text-xs">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-center font-mono font-bold"><?= $skill['sort_order'] ?></td>
                                <td class="px-6 py-4">
                                    <?php if ($skill['is_active']): ?>
                                        <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-bold text-green-700 ring-1 ring-inset ring-green-600/20">Aktif</span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center rounded-md bg-slate-100 px-2 py-1 text-xs font-bold text-slate-500 ring-1 ring-inset ring-slate-600/10">Non-aktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <!-- Edit button triggers javascript populate -->
                                        <button 
                                            onclick="openEditModal(<?= htmlspecialchars(json_encode($skill)) ?>)"
                                            class="p-1 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors"
                                            title="Edit">
                                            <i data-lucide="edit-2" class="w-4 h-4"></i>
                                        </button>
                                        <!-- Delete form -->
                                        <form action="/admin/skills/delete/<?= $skill['id'] ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus keahlian ini?');" class="inline">
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
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeAddModal()"></div>
    
    <!-- Modal Content -->
    <div class="relative bg-white rounded-xl shadow-lg border border-slate-200 w-full max-w-md p-6 overflow-hidden mx-4 animate-in fade-in zoom-in-95 duration-200">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
            <h3 class="text-base font-bold font-heading text-slate-800">Tambah Keahlian Baru</h3>
            <button onclick="closeAddModal()" class="text-slate-400 hover:text-slate-600">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form action="/admin/skills" method="POST" class="space-y-4">
            <?= csrf_field() ?>
            
            <div>
                <label for="add-name" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Nama Keahlian <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="add-name" required
                    class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                    placeholder="Contoh: PHP, MySQL, CSS">
            </div>

            <div>
                <label for="add-category" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Kategori <span class="text-red-500">*</span></label>
                <select name="category" id="add-category" required
                    class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm bg-white">
                    <option value="">-- Pilih Kategori --</option>
                    <option value="Backend">Backend</option>
                    <option value="Database">Database</option>
                    <option value="Frontend">Frontend</option>
                    <option value="Tools">Tools</option>
                    <option value="Soft Skill">Soft Skill</option>
                </select>
            </div>

            <div>
                <label for="add-proficiency" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Tingkat Pemahaman</label>
                <select name="proficiency_level" id="add-proficiency"
                    class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm bg-white">
                    <option value="">Tidak ditampilkan</option>
                    <option value="Dasar">Dasar</option>
                    <option value="Menengah">Menengah</option>
                    <option value="Mahir">Mahir</option>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="add-order" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Urutan Tampil</label>
                    <input type="number" name="sort_order" id="add-order" value="0" min="0"
                        class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                </div>
                <div class="flex items-center pt-6">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" checked class="sr-only peer">
                        <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600 relative after:top-[2px] after:left-[2px]"></div>
                        <span class="ml-2 text-xs font-bold text-slate-600">Aktif</span>
                    </label>
                </div>
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
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeEditModal()"></div>
    
    <!-- Modal Content -->
    <div class="relative bg-white rounded-xl shadow-lg border border-slate-200 w-full max-w-md p-6 overflow-hidden mx-4 animate-in fade-in zoom-in-95 duration-200">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
            <h3 class="text-base font-bold font-heading text-slate-800">Edit Data Keahlian</h3>
            <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form id="edit-form" action="" method="POST" class="space-y-4">
            <?= csrf_field() ?>
            
            <div>
                <label for="edit-name" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Nama Keahlian <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="edit-name" required
                    class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            </div>

            <div>
                <label for="edit-category" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Kategori <span class="text-red-500">*</span></label>
                <select name="category" id="edit-category" required
                    class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm bg-white">
                    <option value="Backend">Backend</option>
                    <option value="Database">Database</option>
                    <option value="Frontend">Frontend</option>
                    <option value="Tools">Tools</option>
                    <option value="Soft Skill">Soft Skill</option>
                </select>
            </div>

            <div>
                <label for="edit-proficiency" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Tingkat Pemahaman</label>
                <select name="proficiency_level" id="edit-proficiency"
                    class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm bg-white">
                    <option value="">Tidak ditampilkan</option>
                    <option value="Dasar">Dasar</option>
                    <option value="Menengah">Menengah</option>
                    <option value="Mahir">Mahir</option>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="edit-order" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Urutan Tampil</label>
                    <input type="number" name="sort_order" id="edit-order" min="0"
                        class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                </div>
                <div class="flex items-center pt-6">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" id="edit-active" value="1" class="sr-only peer">
                        <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600 relative after:top-[2px] after:left-[2px]"></div>
                        <span class="ml-2 text-xs font-bold text-slate-600">Aktif</span>
                    </label>
                </div>
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
    // Modal Selectors
    const addModal = document.getElementById('add-modal');
    const editModal = document.getElementById('edit-modal');
    const editForm = document.getElementById('edit-form');

    // Add Modal Actions
    function openAddModal() {
        addModal.classList.remove('hidden');
    }
    function closeAddModal() {
        addModal.classList.add('hidden');
    }

    // Edit Modal Actions
    function openEditModal(skill) {
        // Populate inputs
        document.getElementById('edit-name').value = skill.name;
        document.getElementById('edit-category').value = skill.category;
        document.getElementById('edit-proficiency').value = skill.proficiency_level || '';
        document.getElementById('edit-order').value = skill.sort_order;
        document.getElementById('edit-active').checked = parseInt(skill.is_active) === 1;

        // Set action URI
        editForm.setAttribute('action', '/admin/skills/edit/' + skill.id);

        editModal.classList.remove('hidden');
        
        // Re-init icons if any in edit modal
        lucide.createIcons();
    }
    
    function closeEditModal() {
        editModal.classList.add('hidden');
    }

    // Close modals on Escape key
    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeAddModal();
            closeEditModal();
        }
    });
</script>

<?php require dirname(__DIR__) . '/layouts/admin_footer.php'; ?>

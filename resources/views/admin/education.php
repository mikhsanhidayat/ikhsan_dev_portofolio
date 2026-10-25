<?php require dirname(__DIR__) . '/layouts/admin_header.php'; ?>

<div class="space-y-6">
    <!-- Top Actions -->
    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs text-slate-500">Daftar riwayat pendidikan formal Anda yang ditampilkan di website portofolio.</p>
        </div>
        <button onclick="openAddModal()" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm transition-colors focus:outline-none">
            <i data-lucide="plus-circle" class="w-4 h-4"></i> Tambah Pendidikan
        </button>
    </div>

    <!-- Educations Table -->
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <?php if (empty($educations)): ?>
                <div class="text-center py-12 text-slate-400">
                    <i data-lucide="graduation-cap" class="w-12 h-12 mx-auto mb-3 text-slate-300"></i>
                    <h3 class="font-bold text-slate-700">Belum ada Riwayat Pendidikan</h3>
                    <p class="text-xs mt-1">Klik tombol 'Tambah Pendidikan' untuk memasukkan data pertama.</p>
                </div>
            <?php else: ?>
                <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                        <tr>
                            <th class="px-6 py-3">Institusi</th>
                            <th class="px-6 py-3">Program Studi</th>
                            <th class="px-6 py-3">Jenjang</th>
                            <th class="px-6 py-3 text-center">Periode</th>
                            <th class="px-6 py-3 text-center">Urutan</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-600">
                        <?php foreach ($educations as $edu): ?>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 font-semibold text-slate-800"><?= e($edu['institution_name']) ?></td>
                                <td class="px-6 py-4"><?= e($edu['study_program']) ?></td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-semibold text-blue-700 ring-1 ring-inset ring-blue-700/10">
                                        <?= e($edu['degree']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center font-mono font-medium">
                                    <?= $edu['start_year'] ?> - <?= $edu['end_year'] ?: 'Sekarang' ?>
                                </td>
                                <td class="px-6 py-4 text-center font-mono font-bold"><?= $edu['sort_order'] ?></td>
                                <td class="px-6 py-4">
                                    <?php if ($edu['is_active']): ?>
                                        <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-bold text-green-700 ring-1 ring-inset ring-green-600/20">Aktif</span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center rounded-md bg-slate-100 px-2 py-1 text-xs font-bold text-slate-500 ring-1 ring-inset ring-slate-600/10">Non-aktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button 
                                            onclick="openEditModal(<?= htmlspecialchars(json_encode($edu)) ?>)"
                                            class="p-1 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors"
                                            title="Edit">
                                            <i data-lucide="edit-2" class="w-4 h-4"></i>
                                        </button>
                                        <form action="/admin/education/delete/<?= $edu['id'] ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pendidikan ini?');" class="inline">
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
            <h3 class="text-base font-bold font-heading text-slate-800">Tambah Riwayat Pendidikan</h3>
            <button onclick="closeAddModal()" class="text-slate-400 hover:text-slate-600">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form action="/admin/education" method="POST" class="space-y-4">
            <?= csrf_field() ?>
            
            <div>
                <label for="add-institution" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Nama Institusi <span class="text-red-500">*</span></label>
                <input type="text" name="institution_name" id="add-institution" required
                    class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                    placeholder="Contoh: Politeknik Negeri Bandung">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="add-program" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Program Studi <span class="text-red-500">*</span></label>
                    <input type="text" name="study_program" id="add-program" required
                        class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                        placeholder="Contoh: Manajemen Informatika">
                </div>
                <div>
                    <label for="add-degree" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Jenjang / Gelar <span class="text-red-500">*</span></label>
                    <input type="text" name="degree" id="add-degree" required
                        class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                        placeholder="Contoh: D3 / A.Md.Kom">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="add-start" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Tahun Mulai <span class="text-red-500">*</span></label>
                    <input type="number" name="start_year" id="add-start" required min="1900" max="2100"
                        class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                        placeholder="Contoh: 2023">
                </div>
                <div>
                    <label for="add-end" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Tahun Lulus (Kosongkan jika aktif)</label>
                    <input type="number" name="end_year" id="add-end" min="1900" max="2100"
                        class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                        placeholder="Contoh: 2026">
                </div>
            </div>

            <div>
                <label for="add-desc" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Deskripsi / Kegiatan Akademik</label>
                <textarea name="description" id="add-desc" rows="3"
                    class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                    placeholder="Contoh: Aktif berorganisasi Himpunan, IPK berjalan 3.8, dll..."></textarea>
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
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeEditModal()"></div>
    <div class="relative bg-white rounded-xl shadow-lg border border-slate-200 w-full max-w-md p-6 overflow-hidden mx-4 animate-in fade-in zoom-in-95 duration-200">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
            <h3 class="text-base font-bold font-heading text-slate-800">Edit Riwayat Pendidikan</h3>
            <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form id="edit-form" action="" method="POST" class="space-y-4">
            <?= csrf_field() ?>
            
            <div>
                <label for="edit-institution" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Nama Institusi <span class="text-red-500">*</span></label>
                <input type="text" name="institution_name" id="edit-institution" required
                    class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="edit-program" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Program Studi <span class="text-red-500">*</span></label>
                    <input type="text" name="study_program" id="edit-program" required
                        class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                </div>
                <div>
                    <label for="edit-degree" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Jenjang / Gelar <span class="text-red-500">*</span></label>
                    <input type="text" name="degree" id="edit-degree" required
                        class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="edit-start" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Tahun Mulai <span class="text-red-500">*</span></label>
                    <input type="number" name="start_year" id="edit-start" required min="1900" max="2100"
                        class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                </div>
                <div>
                    <label for="edit-end" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Tahun Lulus (Kosongkan jika aktif)</label>
                    <input type="number" name="end_year" id="edit-end" min="1900" max="2100"
                        class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                </div>
            </div>

            <div>
                <label for="edit-desc" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Deskripsi / Kegiatan Akademik</label>
                <textarea name="description" id="edit-desc" rows="3"
                    class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"></textarea>
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
    // Selectors
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
    function openEditModal(edu) {
        // Populate inputs
        document.getElementById('edit-institution').value = edu.institution_name;
        document.getElementById('edit-program').value = edu.study_program;
        document.getElementById('edit-degree').value = edu.degree;
        document.getElementById('edit-start').value = edu.start_year;
        document.getElementById('edit-end').value = edu.end_year || '';
        document.getElementById('edit-desc').value = edu.description || '';
        document.getElementById('edit-order').value = edu.sort_order;
        document.getElementById('edit-active').checked = parseInt(edu.is_active) === 1;

        // Set action URI
        editForm.setAttribute('action', '/admin/education/edit/' + edu.id);

        editModal.classList.remove('hidden');
        lucide.createIcons();
    }
    
    function closeEditModal() {
        editModal.classList.add('hidden');
    }

    // Escape Key Modal Close
    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeAddModal();
            closeEditModal();
        }
    });
</script>

<?php require dirname(__DIR__) . '/layouts/admin_footer.php'; ?>

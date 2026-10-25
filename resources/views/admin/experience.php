<?php require dirname(__DIR__) . '/layouts/admin_header.php'; ?>

<div class="space-y-6">
    <!-- Top Actions -->
    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs text-slate-500">Kelola riwayat kerja, magang, atau organisasi. Halaman publik hanya menampilkan bagian ini jika ada data aktif.</p>
        </div>
        <button onclick="openAddModal()" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm transition-colors focus:outline-none">
            <i data-lucide="plus-circle" class="w-4 h-4"></i> Tambah Pengalaman
        </button>
    </div>

    <!-- Experiences Table -->
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <?php if (empty($experiences)): ?>
                <div class="text-center py-12 text-slate-400">
                    <i data-lucide="briefcase" class="w-12 h-12 mx-auto mb-3 text-slate-300"></i>
                    <h3 class="font-bold text-slate-700">Belum ada Riwayat Pengalaman</h3>
                    <p class="text-xs mt-1">Klik tombol 'Tambah Pengalaman' untuk memasukkan data pertama.</p>
                </div>
            <?php else: ?>
                <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                        <tr>
                            <th class="px-6 py-3">Organisasi/Perusahaan</th>
                            <th class="px-6 py-3">Posisi</th>
                            <th class="px-6 py-3">Tipe</th>
                            <th class="px-6 py-3 text-center">Periode</th>
                            <th class="px-6 py-3 text-center">Urutan</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-600">
                        <?php foreach ($experiences as $exp): ?>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 font-semibold text-slate-800"><?= e($exp['organization_name']) ?></td>
                                <td class="px-6 py-4"><?= e($exp['role']) ?></td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center rounded-md bg-slate-50 px-2 py-1 text-xs font-semibold text-slate-600 ring-1 ring-inset ring-slate-500/10">
                                        <?= e($exp['experience_type']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center font-mono font-medium">
                                    <?= date('M Y', strtotime($exp['start_date'])) ?> - 
                                    <?= $exp['is_current'] ? 'Sekarang' : ($exp['end_date'] ? date('M Y', strtotime($exp['end_date'])) : '-') ?>
                                </td>
                                <td class="px-6 py-4 text-center font-mono font-bold"><?= $exp['sort_order'] ?></td>
                                <td class="px-6 py-4">
                                    <?php if ($exp['is_active']): ?>
                                        <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-bold text-green-700 ring-1 ring-inset ring-green-600/20">Aktif</span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center rounded-md bg-slate-100 px-2 py-1 text-xs font-bold text-slate-500 ring-1 ring-inset ring-slate-600/10">Non-aktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button 
                                            onclick="openEditModal(<?= htmlspecialchars(json_encode($exp)) ?>)"
                                            class="p-1 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors"
                                            title="Edit">
                                            <i data-lucide="edit-2" class="w-4 h-4"></i>
                                        </button>
                                        <form action="/admin/experience/delete/<?= $exp['id'] ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pengalaman ini?');" class="inline">
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
            <h3 class="text-base font-bold font-heading text-slate-800">Tambah Riwayat Pengalaman</h3>
            <button onclick="closeAddModal()" class="text-slate-400 hover:text-slate-600">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form action="/admin/experience" method="POST" class="space-y-4">
            <?= csrf_field() ?>
            
            <div>
                <label for="add-organization" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Nama Perusahaan / Organisasi <span class="text-red-500">*</span></label>
                <input type="text" name="organization_name" id="add-organization" required
                    class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                    placeholder="Contoh: PT. Maju Bersama / HIMA MI">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="add-role" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Peran / Jabatan <span class="text-red-500">*</span></label>
                    <input type="text" name="role" id="add-role" required
                        class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                        placeholder="Contoh: Backend Developer / Ketua Divisi">
                </div>
                <div>
                    <label for="add-type" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Jenis Pengalaman <span class="text-red-500">*</span></label>
                    <select name="experience_type" id="add-type" required
                        class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm bg-white">
                        <option value="Kerja Magang">Kerja Magang</option>
                        <option value="Organisasi">Organisasi</option>
                        <option value="Kepanitiaan">Kepanitiaan</option>
                        <option value="Proyek Freelance">Proyek Freelance</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="add-start" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Tanggal Mulai <span class="text-red-500">*</span></label>
                    <input type="date" name="start_date" id="add-start" required
                        class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                </div>
                <div>
                    <label for="add-end" id="add-end-label" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Tanggal Selesai</label>
                    <input type="date" name="end_date" id="add-end"
                        class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                </div>
            </div>

            <div class="flex items-center">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_current" id="add-current" value="1" class="sr-only peer" onchange="toggleAddDate(this)">
                    <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600 relative after:top-[2px] after:left-[2px]"></div>
                    <span class="ml-2 text-xs font-semibold text-slate-600">Masih aktif di posisi ini</span>
                </label>
            </div>

            <div>
                <label for="add-desc" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Deskripsi Tanggung Jawab <span class="text-red-500">*</span></label>
                <textarea name="description" id="add-desc" rows="3" required
                    class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                    placeholder="Jelaskan peran, tanggung jawab, dan hasil pengerjaan Anda..."></textarea>
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
            <h3 class="text-base font-bold font-heading text-slate-800">Edit Riwayat Pengalaman</h3>
            <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form id="edit-form" action="" method="POST" class="space-y-4">
            <?= csrf_field() ?>
            
            <div>
                <label for="edit-organization" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Nama Perusahaan / Organisasi <span class="text-red-500">*</span></label>
                <input type="text" name="organization_name" id="edit-organization" required
                    class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="edit-role" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Peran / Jabatan <span class="text-red-500">*</span></label>
                    <input type="text" name="role" id="edit-role" required
                        class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                </div>
                <div>
                    <label for="edit-type" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Jenis Pengalaman <span class="text-red-500">*</span></label>
                    <select name="experience_type" id="edit-type" required
                        class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm bg-white">
                        <option value="Kerja Magang">Kerja Magang</option>
                        <option value="Organisasi">Organisasi</option>
                        <option value="Kepanitiaan">Kepanitiaan</option>
                        <option value="Proyek Freelance">Proyek Freelance</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="edit-start" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Tanggal Mulai <span class="text-red-500">*</span></label>
                    <input type="date" name="start_date" id="edit-start" required
                        class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                </div>
                <div>
                    <label for="edit-end" id="edit-end-label" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Tanggal Selesai</label>
                    <input type="date" name="end_date" id="edit-end"
                        class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                </div>
            </div>

            <div class="flex items-center">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_current" id="edit-current" value="1" class="sr-only peer" onchange="toggleEditDate(this)">
                    <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600 relative after:top-[2px] after:left-[2px]"></div>
                    <span class="ml-2 text-xs font-semibold text-slate-600">Masih aktif di posisi ini</span>
                </label>
            </div>

            <div>
                <label for="edit-desc" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Deskripsi Tanggung Jawab <span class="text-red-500">*</span></label>
                <textarea name="description" id="edit-desc" rows="3" required
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
    const addModal = document.getElementById('add-modal');
    const editModal = document.getElementById('edit-modal');
    const editForm = document.getElementById('edit-form');

    // Toggle End Date Field depending on 'is_current' checkbox
    function toggleAddDate(cb) {
        const endDateInput = document.getElementById('add-end');
        if (cb.checked) {
            endDateInput.value = '';
            endDateInput.disabled = true;
            endDateInput.classList.add('bg-slate-100', 'cursor-not-allowed');
        } else {
            endDateInput.disabled = false;
            endDateInput.classList.remove('bg-slate-100', 'cursor-not-allowed');
        }
    }

    function toggleEditDate(cb) {
        const endDateInput = document.getElementById('edit-end');
        if (cb.checked) {
            endDateInput.value = '';
            endDateInput.disabled = true;
            endDateInput.classList.add('bg-slate-100', 'cursor-not-allowed');
        } else {
            endDateInput.disabled = false;
            endDateInput.classList.remove('bg-slate-100', 'cursor-not-allowed');
        }
    }

    function openAddModal() {
        addModal.classList.remove('hidden');
        toggleAddDate(document.getElementById('add-current'));
    }
    function closeAddModal() {
        addModal.classList.add('hidden');
    }

    function openEditModal(exp) {
        // Populate inputs
        document.getElementById('edit-organization').value = exp.organization_name;
        document.getElementById('edit-role').value = exp.role;
        document.getElementById('edit-type').value = exp.experience_type;
        document.getElementById('edit-start').value = exp.start_date;
        document.getElementById('edit-end').value = exp.end_date || '';
        document.getElementById('edit-desc').value = exp.description;
        document.getElementById('edit-order').value = exp.sort_order;
        document.getElementById('edit-active').checked = parseInt(exp.is_active) === 1;

        const currentCb = document.getElementById('edit-current');
        currentCb.checked = parseInt(exp.is_current) === 1;
        toggleEditDate(currentCb);

        // Set Action URI
        editForm.setAttribute('action', '/admin/experience/edit/' + exp.id);

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

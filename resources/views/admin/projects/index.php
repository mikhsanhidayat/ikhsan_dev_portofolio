<?php require dirname(__DIR__, 2) . '/layouts/admin_header.php'; ?>

<div class="space-y-6">
    <!-- Top Actions -->
    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs text-slate-500">Kelola dokumentasi proyek digitalisasi KKN, tugas perkuliahan, dan proyek pribadi Anda.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="/admin/categories" class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors border border-slate-200 shadow-sm">
                <i data-lucide="folders" class="w-3.5 h-3.5"></i> Kelola Kategori
            </a>
            <a href="/admin/technologies" class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors border border-slate-200 shadow-sm">
                <i data-lucide="cpu" class="w-3.5 h-3.5"></i> Kelola Teknologi
            </a>
            <a href="/admin/projects/create" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm transition-colors focus:outline-none">
                <i data-lucide="plus-circle" class="w-4 h-4"></i> Tambah Proyek
            </a>
        </div>
    </div>

    <!-- Projects Table -->
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <?php if (empty($projects)): ?>
                <div class="text-center py-12 text-slate-400">
                    <i data-lucide="folder-git-2" class="w-12 h-12 mx-auto mb-3 text-slate-300"></i>
                    <h3 class="font-bold text-slate-700">Belum ada Proyek</h3>
                    <p class="text-xs mt-1">Klik tombol 'Tambah Proyek' untuk mendaftarkan proyek pertama Anda.</p>
                </div>
            <?php else: ?>
                <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                        <tr>
                            <th class="px-6 py-3">Cover</th>
                            <th class="px-6 py-3">Judul Proyek</th>
                            <th class="px-6 py-3">Kategori</th>
                            <th class="px-6 py-3 text-center">Periode</th>
                            <th class="px-6 py-3 text-center">Urutan</th>
                            <th class="px-6 py-3 text-center">Unggulan</th>
                            <th class="px-6 py-3 text-center">Status</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-600">
                        <?php foreach ($projects as $proj): ?>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <!-- Cover image thumb -->
                                <td class="px-6 py-4 flex-shrink-0">
                                    <div class="w-16 h-10 rounded bg-slate-100 border border-slate-200 overflow-hidden flex items-center justify-center">
                                        <?php 
                                        $thumbPath = str_replace('projects/covers/', 'projects/covers/thumbs/thumb_', $proj['cover_image']);
                                        if (is_file(public_path($thumbPath))): 
                                        ?>
                                            <img src="<?= route($thumbPath) ?>" alt="Cover" class="w-full h-full object-cover">
                                        <?php else: ?>
                                            <i data-lucide="image" class="w-4 h-4 text-slate-400"></i>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-semibold text-slate-800">
                                    <a href="/project/<?= e($proj['slug']) ?>" target="_blank" class="hover:text-primary-700 hover:underline">
                                        <?= e($proj['title']) ?>
                                    </a>
                                    <span class="block text-[10px] font-normal text-slate-400 font-mono"><?= e($proj['slug']) ?></span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center rounded-md bg-slate-50 px-2 py-1 text-xs font-semibold text-slate-600 ring-1 ring-inset ring-slate-500/10">
                                        <?= $proj['category_name'] ? e($proj['category_name']) : 'Tanpa Kategori' ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center font-mono font-medium text-xs">
                                    <?= date('Y', strtotime($proj['start_date'])) ?>
                                </td>
                                <td class="px-6 py-4 text-center font-mono font-bold"><?= $proj['sort_order'] ?></td>
                                <td class="px-6 py-4 text-center">
                                    <?php if ($proj['is_featured']): ?>
                                        <span class="inline-flex p-1 bg-yellow-50 text-yellow-600 rounded-full border border-yellow-200" title="Proyek Unggulan">
                                            <i data-lucide="star" class="w-3.5 h-3.5 fill-yellow-600"></i>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-slate-300 font-mono">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <?php if ($proj['publication_status'] === 'published'): ?>
                                        <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-bold text-green-700 ring-1 ring-inset ring-green-600/20">Terbit</span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center rounded-md bg-yellow-50 px-2 py-1 text-xs font-bold text-yellow-700 ring-1 ring-inset ring-yellow-600/20">Draft</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <!-- Gallery multi photo management -->
                                        <a href="/admin/projects/gallery/<?= $proj['id'] ?>" 
                                            class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-semibold text-purple-700 bg-purple-50 hover:bg-purple-100 rounded border border-purple-200 transition-colors"
                                            title="Kelola Galeri Foto">
                                            <i data-lucide="images" class="w-3.5 h-3.5"></i> Galeri
                                        </a>
                                        <!-- Edit -->
                                        <a href="/admin/projects/edit/<?= $proj['id'] ?>" 
                                            class="p-1 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors"
                                            title="Edit">
                                            <i data-lucide="edit-2" class="w-4 h-4"></i>
                                        </a>
                                        <!-- Delete -->
                                        <form action="/admin/projects/delete/<?= $proj['id'] ?>" method="POST" onsubmit="return confirm('APAKAH ANDA YAKIN? Menghapus proyek ini juga akan menghapus permanen seluruh foto dokumentasi di dalam galeri proyek dari server disk!');" class="inline">
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

<?php require dirname(__DIR__, 2) . '/layouts/admin_footer.php'; ?>

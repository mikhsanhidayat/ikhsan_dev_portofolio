<?php require dirname(__DIR__, 2) . '/layouts/admin_header.php'; ?>

<div class="max-w-5xl mx-auto mb-12">
    <div class="mb-6 flex items-center justify-between">
        <a href="/admin/projects" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-slate-800 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Daftar Proyek
        </a>
    </div>

    <form action="/admin/projects/create" method="POST" enctype="multipart/form-data" class="space-y-8">
        <?= csrf_field() ?>

        <!-- SECTION 1: INFORMASI UTAMA -->
        <div class="bg-white rounded-xl border border-slate-200 p-6 md:p-8 shadow-sm">
            <h3 class="text-sm font-bold text-slate-700 pb-4 border-b border-slate-100 mb-6 flex items-center gap-2">
                <i data-lucide="info" class="w-4 h-4 text-slate-500"></i> Informasi Utama Proyek
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Title -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Judul Proyek <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" required
                        class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                        placeholder="Contoh: Sistem Pengelolaan Keuangan BUMDes">
                </div>

                <!-- Category -->
                <div>
                    <label for="category_id" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kategori Proyek</label>
                    <select name="category_id" id="category_id"
                        class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm bg-white">
                        <option value="">-- Tanpa Kategori --</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= e($cat['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <!-- Start Date -->
                <div>
                    <label for="start_date" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tanggal Mulai Pengerjaan <span class="text-red-500">*</span></label>
                    <input type="date" name="start_date" id="start_date" required
                        class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                </div>

                <!-- End Date -->
                <div>
                    <label for="end_date" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tanggal Selesai (Kosongkan jika aktif)</label>
                    <input type="date" name="end_date" id="end_date"
                        class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                </div>

                <!-- Project Status -->
                <div>
                    <label for="project_status" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Status Proyek <span class="text-red-500">*</span></label>
                    <select name="project_status" id="project_status" required
                        class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm bg-white">
                        <option value="Selesai">Selesai</option>
                        <option value="Dalam Pengembangan">Dalam Pengembangan</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <!-- Cover Image Upload -->
                <div>
                    <label for="cover_image" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Gambar Cover Proyek <span class="text-red-500">*</span></label>
                    <input type="file" name="cover_image" id="cover_image" accept="image/*" required
                        class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="text-[9px] text-slate-400 mt-1">Maksimal 5 MB. JPG, JPEG, PNG, WebP. Cover dioptimalkan & dikompres otomatis ke WebP.</p>
                </div>

                <!-- URLs: Demo & GitHub -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="demo_url" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tautan Demo / Live</label>
                        <input type="url" name="demo_url" id="demo_url"
                            class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                            placeholder="https://demo.com">
                    </div>
                    <div>
                        <label for="github_url" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Repository GitHub</label>
                        <input type="url" name="github_url" id="github_url"
                            class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                            placeholder="https://github.com/...">
                    </div>
                </div>
            </div>

            <!-- YouTube Video URL and Order -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div class="md:col-span-2">
                    <label for="video_url" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tautan Video YouTube (Opsional)</label>
                    <input type="url" name="video_url" id="video_url"
                        class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                        placeholder="https://www.youtube.com/watch?v=...">
                </div>
                <div>
                    <label for="sort_order" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Urutan Tampil</label>
                    <input type="number" name="sort_order" id="sort_order" value="0" min="0"
                        class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                </div>
            </div>

            <!-- Feature Checkboxes -->
            <div class="mt-6 flex flex-wrap gap-6 items-center pt-4 border-t border-slate-100">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" class="sr-only peer">
                    <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-yellow-500 relative after:top-[2px] after:left-[2px]"></div>
                    <span class="ml-2 text-xs font-bold text-slate-600">Proyek Unggulan (Featured)</span>
                </label>
                
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Status Publikasi:</span>
                    <select name="publication_status"
                        class="border border-slate-300 rounded-lg px-3 py-1 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs bg-white">
                        <option value="draft">Draft (Sembunyikan)</option>
                        <option value="published">Diterbitkan (Tampil ke Publik)</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- SECTION 2: TEKNOLOGI YANG DIGUNAKAN -->
        <div class="bg-white rounded-xl border border-slate-200 p-6 md:p-8 shadow-sm">
            <h3 class="text-sm font-bold text-slate-700 pb-4 border-b border-slate-100 mb-6 flex items-center gap-2">
                <i data-lucide="cpu" class="w-4 h-4 text-slate-500"></i> Tagging Teknologi <span class="text-slate-400 text-xs font-normal">(Pilih semua yang digunakan)</span>
            </h3>

            <?php if (empty($technologies)): ?>
                <p class="text-xs text-slate-400">Belum ada data teknologi aktif. Silakan tambahkan terlebih dahulu di menu <a href="/admin/technologies" class="text-blue-600 underline">Manajemen Teknologi</a>.</p>
            <?php else: ?>
                <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-4">
                    <?php foreach ($technologies as $tech): ?>
                        <label class="border border-slate-200 rounded-lg p-3 flex items-center gap-2 hover:bg-slate-50 cursor-pointer select-none">
                            <input type="checkbox" name="technologies[]" value="<?= $tech['id'] ?>" class="rounded text-blue-600 focus:ring-blue-500 border-slate-300">
                            <span class="text-xs font-semibold text-slate-700 flex items-center gap-1.5">
                                <?php if ($tech['icon']): ?>
                                    <i data-lucide="<?= e($tech['icon']) ?>" class="w-3.5 h-3.5 text-slate-400"></i>
                                <?php endif; ?>
                                <?= e($tech['name']) ?>
                            </span>
                        </label>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- SECTION 3: PENJELASAN RINCI / KONTEN DETAIL -->
        <div class="bg-white rounded-xl border border-slate-200 p-6 md:p-8 shadow-sm">
            <h3 class="text-sm font-bold text-slate-700 pb-4 border-b border-slate-100 mb-6 flex items-center gap-2">
                <i data-lucide="file-text" class="w-4 h-4 text-slate-500"></i> Narasi & Deskripsi Detail Proyek
            </h3>

            <div class="space-y-6">
                <!-- Summary -->
                <div>
                    <label for="summary" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Ringkasan Singkat (Summary) <span class="text-red-500">*</span></label>
                    <textarea name="summary" id="summary" rows="2" required
                        class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                        placeholder="Deskripsi singkat proyek dalam 1-2 kalimat (tampil di kartu proyek publik)..."></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Background -->
                    <div>
                        <label for="background" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Latar Belakang / Masalah <span class="text-red-500">*</span></label>
                        <textarea name="background" id="background" rows="4" required
                            class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                            placeholder="Jelaskan masalah awal sebelum proyek ini dibuat..."></textarea>
                    </div>

                    <!-- Objective -->
                    <div>
                        <label for="objective" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tujuan Proyek <span class="text-red-500">*</span></label>
                        <textarea name="objective" id="objective" rows="4" required
                            class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                            placeholder="Apa yang ingin dicapai melalui pembuatan proyek ini..."></textarea>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Solution -->
                    <div>
                        <label for="solution" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Solusi yang Dibuat <span class="text-red-500">*</span></label>
                        <textarea name="solution" id="solution" rows="4" required
                            class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                            placeholder="Jelaskan aplikasi/website/fitur utama yang dibangun sebagai solusi..."></textarea>
                    </div>

                    <!-- Role Description -->
                    <div>
                        <label for="role_description" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Peran & Tanggung Jawab Anda <span class="text-red-500">*</span></label>
                        <textarea name="role_description" id="role_description" rows="4" required
                            class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                            placeholder="Jelaskan kontribusi spesifik Anda dalam proyek (misal: Backend Developer merancang DB & modul API)..."></textarea>
                    </div>
                </div>

                <!-- Process Description -->
                <div>
                    <label for="process_description" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Proses & Tahapan Pengerjaan <span class="text-red-500">*</span></label>
                    <textarea name="process_description" id="process_description" rows="4" required
                        class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                        placeholder="Jelaskan alur pengerjaan dari analisis, desain, coding, hingga pengujian..."></textarea>
                </div>

                <!-- Feature Description -->
                <div>
                    <label for="feature_description" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Fitur Utama Aplikasi <span class="text-red-500">*</span></label>
                    <textarea name="feature_description" id="feature_description" rows="3" required
                        class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                        placeholder="Sebutkan fitur-fitur penting yang berhasil dibangun (pisahkan dengan koma atau baris baru)..."></textarea>
                </div>

                <!-- Result Description -->
                <div>
                    <label for="result_description" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Hasil / Dampak Proyek <span class="text-red-500">*</span></label>
                    <textarea name="result_description" id="result_description" rows="3" required
                        class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                        placeholder="Jelaskan hasil nyata atau dampak setelah sistem digunakan (misal: mempercepat laporan bulanan dari 3 hari menjadi 5 menit)..."></textarea>
                </div>

                <!-- Challenge Description -->
                <div>
                    <label for="challenge_description" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tantangan & Pembelajaran (Opsional)</label>
                    <textarea name="challenge_description" id="challenge_description" rows="3"
                        class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                        placeholder="Jelaskan kesulitan teknis yang dihadapi dan pelajaran penting yang Anda ambil..."></textarea>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end gap-3">
            <a href="/admin/projects" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-bold text-slate-500 hover:bg-slate-100 rounded-lg border border-slate-200 transition-colors bg-white">
                Batal
            </a>
            <button type="submit" id="submit-btn"
                class="inline-flex items-center justify-center gap-2 px-6 py-2.5 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm focus:outline-none transition-colors">
                <i data-lucide="check" class="w-4 h-4"></i> Publikasikan Proyek
            </button>
        </div>
    </form>
</div>

<script>
    // Handle Loading State
    const form = document.querySelector('form');
    const submitBtn = document.getElementById('submit-btn');

    if (form && submitBtn) {
        form.addEventListener('submit', () => {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="inline-block animate-spin border-2 border-white border-t-transparent rounded-full w-4 h-4"></span> Menyimpan...';
        });
    }
</script>

<?php require dirname(__DIR__, 2) . '/layouts/admin_footer.php'; ?>

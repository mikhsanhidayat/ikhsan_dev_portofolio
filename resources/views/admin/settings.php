<?php require dirname(__DIR__) . '/layouts/admin_header.php'; ?>

<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl border border-slate-200 p-6 md:p-8 shadow-sm">
        
        <div class="flex items-center justify-between pb-6 border-b border-slate-100 mb-6">
            <div>
                <h2 class="text-lg font-bold font-heading text-slate-800">Pengaturan Website</h2>
                <p class="text-xs text-slate-500">Konfigurasi umum identitas website, meta tags untuk SEO, tampilan warna aksen, dan link peta Google Maps.</p>
            </div>
            <i data-lucide="settings" class="w-8 h-8 text-slate-400"></i>
        </div>

        <form id="website-settings-form" action="/admin/settings" method="POST" class="space-y-6">
            <?= csrf_field() ?>

            <!-- Row 1: Website Name and Meta Title -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="website_name" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Website <span class="text-red-500">*</span></label>
                    <input type="text" name="website_name" id="website_name" required value="<?= e($settings['website_name'] ?? '') ?>"
                        class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                </div>
                <div>
                    <label for="meta_title" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Meta Title <span class="text-red-500">*</span></label>
                    <input type="text" name="meta_title" id="meta_title" required value="<?= e($settings['meta_title'] ?? '') ?>"
                        class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                </div>
            </div>

            <!-- Row 2: Meta Description -->
            <div>
                <label for="meta_description" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Meta Description <span class="text-red-500">*</span></label>
                <textarea name="meta_description" id="meta_description" rows="3" required
                    class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"><?= e($settings['meta_description'] ?? '') ?></textarea>
            </div>

            <!-- Row 3: Footer Text -->
            <div>
                <label for="footer_text" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Teks Hak Cipta / Footer <span class="text-red-500">*</span></label>
                <input type="text" name="footer_text" id="footer_text" required value="<?= e($settings['footer_text'] ?? '') ?>"
                    class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            </div>

            <!-- Row 4: Google Maps Location -->
            <div>
                <label for="google_maps_link" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Lokasi / Kota (Google Maps) <span class="text-red-500">*</span></label>
                <input type="text" name="google_maps_link" id="google_maps_link" required value="<?= e($settings['google_maps_link'] ?? '') ?>"
                    class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                    placeholder="Contoh: Ciawi, Tasikmalaya atau alamat lengkap Anda">
                <p class="text-[10px] text-slate-400 mt-1">Anda bisa mengetikkan nama daerah/alamat secara sederhana (contoh: <strong>Kec. Ciawi, Tasikmalaya, Jawa Barat</strong>) atau menempelkan link peta.</p>
            </div>

            <!-- Row 5: Primary Color dropdown -->
            <div>
                <label for="primary_color" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Warna Aksen Utama</label>
                <select name="primary_color" id="primary_color" required
                    class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm bg-white">
                    <option value="blue" <?= ($settings['primary_color'] ?? '') === 'blue' ? 'selected' : '' ?>>Biru (Default)</option>
                    <option value="indigo" <?= ($settings['primary_color'] ?? '') === 'indigo' ? 'selected' : '' ?>>Indigo</option>
                    <option value="slate" <?= ($settings['primary_color'] ?? '') === 'slate' ? 'selected' : '' ?>>Slate / Abu-abu</option>
                </select>
            </div>

            <!-- Submit Button -->
            <div class="pt-6 border-t border-slate-100 flex justify-end">
                <button type="submit" id="save-settings-btn"
                    class="inline-flex items-center justify-center gap-2 px-6 py-2.5 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm focus:outline-none transition-colors">
                    <i data-lucide="save" class="w-4 h-4"></i> Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>

    <div class="mt-6 bg-white rounded-xl border border-slate-200 p-6 md:p-8 shadow-sm">
        <div class="pb-6 border-b border-slate-100 mb-6">
            <h2 class="text-lg font-bold font-heading text-slate-800">Keamanan Akun</h2>
            <p id="password-help" class="text-xs text-slate-500 mt-2">Gunakan kata sandi baru minimal 12 karakter Unicode dan maksimal 72 byte. Spasi tetap dihitung. Setelah berhasil, Anda harus masuk kembali. Sesi di perangkat lain tidak otomatis keluar.</p>
        </div>
        <form id="password-settings-form" action="/admin/settings/password" method="POST" class="space-y-6" aria-describedby="password-help">
            <?= csrf_field() ?>
            <div>
                <label for="current_password" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kata Sandi Saat Ini</label>
                <input type="password" id="current_password" name="current_password" autocomplete="current-password" required class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="new_password" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kata Sandi Baru</label>
                    <input type="password" id="new_password" name="new_password" autocomplete="new-password" required class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                </div>
                <div>
                    <label for="confirm_password" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Konfirmasi Kata Sandi Baru</label>
                    <input type="password" id="confirm_password" name="confirm_password" autocomplete="new-password" required class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                </div>
            </div>
            <div class="pt-6 border-t border-slate-100 flex justify-end">
                <button type="submit" id="save-password-btn" class="w-full md:w-auto inline-flex items-center justify-center px-6 py-2.5 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">Ubah Kata Sandi</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Handle Loading State
    const form = document.getElementById('website-settings-form');
    const saveBtn = document.getElementById('save-settings-btn');

    if (form && saveBtn) {
        form.addEventListener('submit', () => {
            saveBtn.disabled = true;
            saveBtn.innerHTML = '<span class="inline-block animate-spin border-2 border-white border-t-transparent rounded-full w-4 h-4"></span> Menyimpan...';
        });
    }
    const passwordForm = document.getElementById('password-settings-form');
    const passwordBtn = document.getElementById('save-password-btn');
    if (passwordForm && passwordBtn) {
        passwordForm.addEventListener('submit', () => {
            passwordBtn.disabled = true;
            passwordBtn.textContent = 'Memperbarui...';
        });
    }
</script>

<?php require dirname(__DIR__) . '/layouts/admin_footer.php'; ?>

<?php require dirname(__DIR__) . '/layouts/admin_header.php'; ?>

<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl border border-slate-200 p-6 md:p-8 shadow-sm">
        
        <div class="flex items-center justify-between pb-6 border-b border-slate-100 mb-6">
            <div>
                <h2 class="text-lg font-bold font-heading text-slate-800">Ubah Profil Personal</h2>
                <p class="text-xs text-slate-500">Informasi ini akan ditampilkan langsung di bagian Hero dan Tentang Saya pada halaman publik.</p>
            </div>
            <i data-lucide="user" class="w-8 h-8 text-slate-400"></i>
        </div>

        <form action="/admin/profile" method="POST" enctype="multipart/form-data" class="space-y-6">
            <?= csrf_field() ?>

            <!-- Row 1: Name and Title -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="full_name" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="full_name" id="full_name" required value="<?= e($profile['full_name']) ?>"
                        class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                </div>
                <div>
                    <label for="headline" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Headline Profil <span class="text-red-500">*</span></label>
                    <input type="text" name="headline" id="headline" required value="<?= e($profile['headline']) ?>"
                        class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                        placeholder="Contoh: Fullstack Developer">
                </div>
            </div>

            <!-- Row 2: Target Job and Location -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="internship_target" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Target Magang <span class="text-red-500">*</span></label>
                    <input type="text" name="internship_target" id="internship_target" required value="<?= e($profile['internship_target']) ?>"
                        class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                        placeholder="Contoh: Backend Developer Intern">
                </div>
                <div>
                    <label for="location" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Domisili / Lokasi</label>
                    <input type="text" name="location" id="location" value="<?= e($profile['location']) ?>"
                        class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                        placeholder="Contoh: Bandung, Indonesia">
                </div>
            </div>

            <!-- Profile Photo Upload -->
            <div class="bg-slate-50 rounded-xl p-4 border border-slate-200/60 flex flex-col sm:flex-row items-center gap-6">
                <div class="w-24 h-24 rounded-full bg-slate-200 border border-slate-300 flex-shrink-0 overflow-hidden flex items-center justify-center relative">
                    <?php if (!empty($profile['profile_photo']) && is_file(public_path($profile['profile_photo']))): ?>
                        <img src="<?= route($profile['profile_photo']) ?>" alt="Foto Profil" class="w-full h-full object-cover">
                    <?php else: ?>
                        <i data-lucide="user" class="w-10 h-10 text-slate-400"></i>
                    <?php endif; ?>
                </div>
                <div class="flex-grow space-y-2 text-center sm:text-left">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Foto Profil</label>
                    <input type="file" name="profile_photo" id="profile_photo" accept="image/*"
                        class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="text-[10px] text-slate-400">Maksimal 5 MB. Format diizinkan: JPG, JPEG, PNG, WebP.</p>
                </div>
            </div>

            <!-- Bio and About Text -->
            <div>
                <label for="short_bio" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Bio Singkat <span class="text-red-500">*</span></label>
                <textarea name="short_bio" id="short_bio" rows="2" required
                    class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                    placeholder="Tulis biografi satu paragraf pendek untuk bagian Hero..."><?= e($profile['short_bio']) ?></textarea>
            </div>

            <div>
                <label for="about_text" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tentang Saya (Lengkap) <span class="text-red-500">*</span></label>
                <textarea name="about_text" id="about_text" rows="5" required
                    class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                    placeholder="Tulis deskripsi rinci tentang latar belakang, keahlian, dan tujuan karir Anda..."><?= e($profile['about_text']) ?></textarea>
            </div>

            <!-- Contact Fields -->
            <div class="pt-6 border-t border-slate-100">
                <h3 class="text-sm font-bold text-slate-700 mb-4 flex items-center gap-2">
                    <i data-lucide="link" class="w-4 h-4 text-slate-500"></i> Kontak & Tautan Profesional
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Email Publik <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email" required value="<?= e($profile['email']) ?>"
                            class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                    </div>
                    <div>
                        <label for="whatsapp" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">WhatsApp</label>
                        <input type="text" name="whatsapp" id="whatsapp" value="<?= e($profile['whatsapp']) ?>"
                            class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                            placeholder="Contoh: +6281234567890">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label for="github_url" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">URL GitHub</label>
                        <input type="url" name="github_url" id="github_url" value="<?= e($profile['github_url']) ?>"
                            class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                            placeholder="https://github.com/username">
                    </div>
                    <div>
                        <label for="linkedin_url" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">URL LinkedIn</label>
                        <input type="url" name="linkedin_url" id="linkedin_url" value="<?= e($profile['linkedin_url']) ?>"
                            class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                            placeholder="https://linkedin.com/in/username">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                    <div>
                        <label for="instagram_url" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">URL Instagram</label>
                        <input type="url" name="instagram_url" id="instagram_url" value="<?= e($profile['instagram_url'] ?? '') ?>"
                            class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                            placeholder="https://instagram.com/username">
                    </div>
                    <div>
                        <label for="tiktok_url" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">URL TikTok</label>
                        <input type="url" name="tiktok_url" id="tiktok_url" value="<?= e($profile['tiktok_url'] ?? '') ?>"
                            class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                            placeholder="https://tiktok.com/@username">
                    </div>
                    <div>
                        <label for="youtube_url" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">URL YouTube</label>
                        <input type="url" name="youtube_url" id="youtube_url" value="<?= e($profile['youtube_url'] ?? '') ?>"
                            class="block w-full border border-slate-300 rounded-lg px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                            placeholder="https://youtube.com/@channel">
                    </div>
                </div>
            </div>



            <!-- Submit Button -->
            <div class="pt-6 border-t border-slate-100 flex justify-end">
                <button type="submit" id="save-profile-btn"
                    class="inline-flex items-center justify-center gap-2 px-6 py-2.5 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm focus:outline-none transition-colors">
                    <i data-lucide="save" class="w-4 h-4"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Handle Loading State
    const form = document.querySelector('form');
    const saveBtn = document.getElementById('save-profile-btn');

    if (form && saveBtn) {
        form.addEventListener('submit', () => {
            saveBtn.disabled = true;
            saveBtn.innerHTML = '<span class="inline-block animate-spin border-2 border-white border-t-transparent rounded-full w-4 h-4"></span> Menyimpan...';
        });
    }
</script>

<?php require dirname(__DIR__) . '/layouts/admin_footer.php'; ?>

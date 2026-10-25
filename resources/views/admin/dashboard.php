<?php require dirname(__DIR__) . '/layouts/admin_header.php'; ?>

<!-- Overview Statistics Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    
    <!-- Projects Card -->
    <a href="/admin/projects" class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm hover:shadow transition-shadow flex items-center justify-between group">
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Proyek</p>
            <h3 class="text-3xl font-extrabold text-slate-800 mt-1"><?= $totalProjects ?></h3>
        </div>
        <div class="p-3 bg-blue-50 text-blue-600 rounded-lg group-hover:bg-blue-100 transition-colors">
            <i data-lucide="folder-git-2" class="w-6 h-6"></i>
        </div>
    </a>
    
    <!-- Photos Card -->
    <a href="/admin/projects" class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm hover:shadow transition-shadow flex items-center justify-between group">
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Foto Dokumentasi</p>
            <h3 class="text-3xl font-extrabold text-slate-800 mt-1"><?= $totalMedia ?></h3>
        </div>
        <div class="p-3 bg-purple-50 text-purple-600 rounded-lg group-hover:bg-purple-100 transition-colors">
            <i data-lucide="image" class="w-6 h-6"></i>
        </div>
    </a>
    
    <!-- Messages Card -->
    <a href="/admin/messages" class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm hover:shadow transition-shadow flex items-center justify-between group">
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Pesan</p>
            <h3 class="text-3xl font-extrabold text-slate-800 mt-1"><?= $totalMessages ?></h3>
        </div>
        <div class="p-3 bg-green-50 text-green-600 rounded-lg group-hover:bg-green-100 transition-colors">
            <i data-lucide="mail" class="w-6 h-6"></i>
        </div>
    </a>
    
    <!-- Unread Messages Card -->
    <a href="/admin/messages?status=unread" class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm hover:shadow transition-shadow flex items-center justify-between group">
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Pesan Belum Dibaca</p>
            <h3 class="text-3xl font-extrabold text-slate-800 mt-1 <?= $unreadMessages > 0 ? 'text-red-600' : 'text-slate-800' ?>"><?= $unreadMessages ?></h3>
        </div>
        <div class="p-3 <?= $unreadMessages > 0 ? 'bg-red-100 text-red-600' : 'bg-slate-100 text-slate-600' ?> rounded-lg">
            <i data-lucide="mail-warning" class="w-6 h-6 animate-pulse"></i>
        </div>
    </a>
</div>

<!-- Dashboard Grid Body -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Left: Message Info -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Latest Messages Section -->
        <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-bold font-heading text-slate-800 flex items-center gap-2">
                    <i data-lucide="mail" class="w-5 h-5 text-slate-500"></i> Pesan Masuk Terbaru
                </h3>
                <a href="/admin/messages" class="text-xs font-semibold text-primary-600 hover:underline">Lihat Semua</a>
            </div>
            
            <div class="overflow-x-auto">
                <?php if (empty($latestMessages)): ?>
                    <div class="text-center py-8 text-slate-400 text-sm">
                        <i data-lucide="mail-open" class="w-8 h-8 mx-auto mb-2 text-slate-300"></i>
                        <p>Belum ada pesan masuk dari pengunjung.</p>
                    </div>
                <?php else: ?>
                    <table class="min-w-full divide-y divide-slate-100 text-left text-sm">
                        <thead>
                            <tr class="text-slate-400 font-semibold">
                                <th class="py-2">Pengirim</th>
                                <th class="py-2">Subjek</th>
                                <th class="py-2">Waktu</th>
                                <th class="py-2">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-600">
                            <?php foreach ($latestMessages as $msg): ?>
                                <tr>
                                    <td class="py-3 pr-4 font-semibold text-slate-800">
                                        <?= e($msg['name']) ?>
                                        <span class="block text-xs font-normal text-slate-400"><?= e($msg['email']) ?></span>
                                    </td>
                                    <td class="py-3 pr-4 truncate max-w-[200px]"><?= e($msg['subject']) ?></td>
                                    <td class="py-3 pr-4 text-xs text-slate-400">
                                        <?= date('d-m-Y H:i', strtotime($msg['created_at'])) ?>
                                    </td>
                                    <td class="py-3">
                                        <?php if ($msg['status'] === 'unread'): ?>
                                            <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">Belum dibaca</span>
                                        <?php elseif ($msg['status'] === 'read'): ?>
                                            <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">Dibaca</span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center rounded-md bg-slate-50 px-2 py-1 text-xs font-medium text-slate-700 ring-1 ring-inset ring-slate-700/10">Diarsip</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Main Right: Quick Info Panel -->
    <div class="space-y-6">
        <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
            <h3 class="text-base font-bold font-heading text-slate-800 mb-4 flex items-center gap-2">
                <i data-lucide="info" class="w-5 h-5 text-slate-500"></i> Informasi Sistem & Update
            </h3>
            <ul class="space-y-3 text-sm text-slate-600">
                <li class="flex justify-between items-center py-1.5 border-b border-slate-100">
                    <span class="font-medium text-slate-400">Pembaruan Terakhir:</span>
                    <span class="font-semibold text-slate-800 text-right"><?= $lastUpdate ?></span>
                </li>
                <li class="flex justify-between items-center py-1.5 border-b border-slate-100">
                    <span class="font-medium text-slate-400">Versi PHP:</span>
                    <span class="font-bold text-slate-800"><?= PHP_VERSION ?></span>
                </li>
                <li class="flex justify-between items-center py-1.5 border-b border-slate-100">
                    <span class="font-medium text-slate-400">Database Driver:</span>
                    <span class="font-bold text-slate-800">PDO MySQL</span>
                </li>
                <li class="flex justify-between items-center py-1.5">
                    <span class="font-medium text-slate-400">Status Debug:</span>
                    <span class="inline-flex items-center rounded-md px-2 py-0.5 text-xs font-bold font-mono <?= ($_ENV['APP_DEBUG'] ?? 'false') === 'true' ? 'bg-green-50 text-green-700 ring-1 ring-green-600/10' : 'bg-slate-100 text-slate-700 ring-1 ring-slate-600/10' ?>">
                        <?= ($_ENV['APP_DEBUG'] ?? 'false') === 'true' ? 'AKTIF' : 'NON-AKTIF' ?>
                    </span>
                </li>
            </ul>
        </div>
        
        <!-- Shortcuts Card -->
        <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
            <h3 class="text-base font-bold font-heading text-slate-800 mb-4 flex items-center gap-2">
                <i data-lucide="zap" class="w-5 h-5 text-slate-500"></i> Pintasan Cepat
            </h3>
            <div class="grid grid-cols-2 gap-3 text-center text-xs">
                <a href="/admin/projects" class="p-3 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-lg flex flex-col items-center gap-1 font-semibold text-slate-700 transition-colors">
                    <i data-lucide="plus-circle" class="w-5 h-5 text-blue-600"></i> Tambah Proyek
                </a>
                <a href="/admin/profile" class="p-3 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-lg flex flex-col items-center gap-1 font-semibold text-slate-700 transition-colors">
                    <i data-lucide="user-cog" class="w-5 h-5 text-purple-600"></i> Edit Profil
                </a>
            </div>
        </div>
    </div>
</div>

<?php require dirname(__DIR__) . '/layouts/admin_footer.php'; ?>

<?php require dirname(__DIR__) . '/layouts/admin_header.php'; ?>

<div class="space-y-6">
    <!-- Top Filter Bar & Search -->
    <div class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4 bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
        
        <!-- Filter Tabs -->
        <div class="flex items-center gap-1.5 overflow-x-auto pb-2 md:pb-0">
            <a href="/admin/inbox?status=unread<?= !empty($currentSearch) ? '&search=' . urlencode($currentSearch) : '' ?>"
                class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all whitespace-nowrap <?= $currentStatus === 'unread' ? 'bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-700/10' : 'text-slate-600 hover:bg-slate-100' ?>">
                Belum Dibaca
            </a>
            <a href="/admin/inbox?status=read<?= !empty($currentSearch) ? '&search=' . urlencode($currentSearch) : '' ?>"
                class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all whitespace-nowrap <?= $currentStatus === 'read' ? 'bg-slate-100 text-slate-700' : 'text-slate-600 hover:bg-slate-100' ?>">
                Sudah Dibaca
            </a>
            <a href="/admin/inbox?status=archived<?= !empty($currentSearch) ? '&search=' . urlencode($currentSearch) : '' ?>"
                class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all whitespace-nowrap <?= $currentStatus === 'archived' ? 'bg-slate-100 text-slate-700' : 'text-slate-600 hover:bg-slate-100' ?>">
                Diarsipkan
            </a>
            <a href="/admin/inbox?status=all<?= !empty($currentSearch) ? '&search=' . urlencode($currentSearch) : '' ?>"
                class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all whitespace-nowrap <?= $currentStatus === 'all' ? 'bg-slate-100 text-slate-700' : 'text-slate-600 hover:bg-slate-100' ?>">
                Semua Pesan
            </a>
        </div>

        <!-- Search Input -->
        <form action="/admin/inbox" method="GET" class="relative flex-grow md:max-w-xs">
            <input type="hidden" name="status" value="<?= e($currentStatus) ?>">
            <input type="text" name="search" value="<?= e($currentSearch) ?>"
                placeholder="Cari pengirim, subjek..."
                class="w-full pl-9 pr-4 py-1.5 border border-slate-300 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-blue-500 text-slate-900">
            <div class="absolute left-3 top-2 text-slate-400">
                <i data-lucide="search" class="w-4 h-4"></i>
            </div>
            <?php if (!empty($currentSearch)): ?>
                <a href="/admin/inbox?status=<?= e($currentStatus) ?>" class="absolute right-3 top-2 text-slate-400 hover:text-slate-600">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Messages Container -->
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <?php if (empty($messages)): ?>
                <div class="text-center py-16 text-slate-400">
                    <i data-lucide="mail-warning" class="w-12 h-12 mx-auto mb-3 text-slate-300"></i>
                    <h3 class="font-bold text-slate-700">Tidak Ada Pesan</h3>
                    <p class="text-xs mt-1">Tidak ada pesan masuk yang sesuai dengan filter saat ini.</p>
                </div>
            <?php else: ?>
                <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                        <tr>
                            <th class="px-6 py-3">Pengirim</th>
                            <th class="px-6 py-3">Subjek & Pesan</th>
                            <th class="px-6 py-3 text-center">Tanggal Masuk</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-600">
                        <?php foreach ($messages as $msg): ?>
                            <tr onclick="openMessageDetail(<?= $msg['id'] ?>)" 
                                class="cursor-pointer hover:bg-slate-50 transition-colors <?= $msg['status'] === 'unread' ? 'bg-blue-50/30 font-semibold text-slate-900' : '' ?>">
                                
                                <!-- Sender details -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-semibold"><?= e($msg['name']) ?></span>
                                        <span class="text-xs font-normal text-slate-400 font-mono"><?= e($msg['email']) ?></span>
                                    </div>
                                </td>

                                <!-- Subject & Message body preview -->
                                <td class="px-6 py-4 max-w-[280px] md:max-w-[400px]">
                                    <div class="flex flex-col">
                                        <span class="text-sm truncate <?= $msg['status'] === 'unread' ? 'text-slate-900 font-bold' : 'text-slate-700' ?>">
                                            <?= e($msg['subject']) ?>
                                        </span>
                                        <span class="text-xs text-slate-400 truncate font-normal">
                                            <?= e($msg['message']) ?>
                                        </span>
                                    </div>
                                </td>

                                <!-- Date -->
                                <td class="px-6 py-4 text-center whitespace-nowrap font-mono text-xs text-slate-500">
                                    <?= date('d-m-Y H:i', strtotime($msg['created_at'])) ?>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 text-right whitespace-nowrap" onclick="event.stopPropagation()">
                                    <div class="flex items-center justify-end gap-2">
                                        <!-- Open Detail -->
                                        <button onclick="openMessageDetail(<?= $msg['id'] ?>)" 
                                            class="p-1 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors" title="Buka Pesan">
                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                        </button>
                                        
                                        <!-- Archive -->
                                        <?php if ($msg['status'] !== 'archived'): ?>
                                            <form action="/admin/inbox/archive/<?= $msg['id'] ?>" method="POST" class="inline">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="p-1 text-slate-400 hover:text-purple-600 hover:bg-purple-50 rounded transition-colors" title="Arsip">
                                                    <i data-lucide="archive" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>

                                        <!-- Delete -->
                                        <form action="/admin/inbox/delete/<?= $msg['id'] ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan ini secara permanen?');" class="inline">
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

<!-- ================= READING DETAIL MODAL ================= -->
<div id="detail-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeMessageDetail()"></div>
    
    <!-- Modal Content -->
    <div class="relative bg-white rounded-xl shadow-lg border border-slate-200 w-full max-w-2xl p-6 overflow-hidden mx-4 animate-in fade-in zoom-in-95 duration-200">
        
        <!-- Header -->
        <div class="flex items-start justify-between pb-4 border-b border-slate-100 mb-4">
            <div>
                <h3 class="text-base font-bold font-heading text-slate-800" id="msg-subject">Subjek Pesan</h3>
                <p class="text-[10px] text-slate-400 mt-0.5" id="msg-meta">Meta data</p>
            </div>
            <button onclick="closeMessageDetail()" class="text-slate-400 hover:text-slate-600">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- Sender Bio Card -->
        <div class="bg-slate-50 border border-slate-200 rounded-lg p-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
            <div class="flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-sm" id="msg-avatar">
                    MI
                </div>
                <div>
                    <h4 class="text-xs font-bold text-slate-800" id="msg-sender-name">Nama Pengirim</h4>
                    <p class="text-[10px] font-mono text-slate-400" id="msg-sender-email">pengirim@example.com</p>
                </div>
            </div>
            <!-- Reply button -->
            <a href="" id="msg-reply-btn" 
                class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm transition-colors w-full sm:w-auto text-center">
                <i data-lucide="mail" class="w-3.5 h-3.5"></i> Balas via Email
            </a>
        </div>

        <!-- Message Body -->
        <div class="border border-slate-100 rounded-lg p-4 max-h-60 overflow-y-auto bg-white mb-6">
            <p class="text-xs text-slate-700 leading-relaxed whitespace-pre-wrap" id="msg-body">
                Isi pesan detail...
            </p>
        </div>

        <!-- Footer Actions -->
        <div class="pt-4 border-t border-slate-100 flex flex-wrap gap-2 justify-between items-center">
            <!-- Mark as Unread option -->
            <form action="" method="POST" id="msg-unread-form">
                <?= csrf_field() ?>
                <input type="hidden" name="status" value="unread">
                <button type="submit" class="text-xs font-bold text-slate-500 hover:text-slate-800 hover:bg-slate-100 px-3 py-2 rounded-lg transition-colors border border-slate-200">
                    Tandai Belum Dibaca
                </button>
            </form>

            <div class="flex items-center gap-2">
                <!-- Archive form inside modal -->
                <form action="" method="POST" id="msg-archive-form">
                    <?= csrf_field() ?>
                    <button type="submit" class="text-xs font-bold text-purple-700 bg-purple-50 hover:bg-purple-100 px-3 py-2 rounded-lg transition-colors border border-purple-200">
                        Arsipkan
                    </button>
                </form>
                
                <!-- Delete form inside modal -->
                <form action="" method="POST" id="msg-delete-form" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan ini secara permanen?');">
                    <?= csrf_field() ?>
                    <button type="submit" class="text-xs font-bold text-white bg-red-600 hover:bg-red-700 px-3 py-2 rounded-lg transition-colors shadow-sm">
                        Hapus Permanen
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const detailModal = document.getElementById('detail-modal');

    // Fetch and open Message Detail via AJAX
    function openMessageDetail(id) {
        // Fetch details
        fetch('/admin/inbox/detail/' + id, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response not ok');
            return response.json();
        })
        .then(res => {
            if (res.success) {
                const msg = res.data;

                // Populate Fields
                document.getElementById('msg-subject').innerText = msg.subject;
                document.getElementById('msg-sender-name').innerText = msg.name;
                document.getElementById('msg-sender-email').innerText = msg.email;
                document.getElementById('msg-body').innerText = msg.message;
                
                // Formulate avatar initials
                const initials = msg.name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
                document.getElementById('msg-avatar').innerText = initials;

                // Meta Info: Date and IP
                const dateObj = new Date(msg.created_at);
                const dateStr = dateObj.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' });
                document.getElementById('msg-meta').innerText = 'Diterima pada: ' + dateStr + ' | IP: ' + msg.ip_address;

                // Setup Reply Mailto link
                const mailtoSubject = encodeURIComponent('Re: ' + msg.subject);
                const mailtoBody = encodeURIComponent('Halo ' + msg.name + ',\n\nTerima kasih telah menghubungi saya di portofolio.\n\n---\nPertanyaan Anda:\n"' + msg.message + '"');
                const mailtoUrl = 'mailto:' + msg.email + '?subject=' + mailtoSubject + '&body=' + mailtoBody;
                document.getElementById('msg-reply-btn').setAttribute('href', mailtoUrl);

                // Setup Forms Actions
                document.getElementById('msg-unread-form').setAttribute('action', '/admin/inbox/toggle-read/' + msg.id);
                document.getElementById('msg-archive-form').setAttribute('action', '/admin/inbox/archive/' + msg.id);
                document.getElementById('msg-delete-form').setAttribute('action', '/admin/inbox/delete/' + msg.id);

                // Show Modal
                detailModal.classList.remove('hidden');
                lucide.createIcons();
            }
        })
        .catch(err => {
            console.error('Failed to load message detail:', err);
            alert('Gagal memuat detail pesan. Silakan coba kembali.');
        });
    }

    function closeMessageDetail() {
        detailModal.classList.add('hidden');
        // reload location to reflect read/unread status of rows if needed
        window.location.reload();
    }

    // Modal Close via Escape key
    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeMessageDetail();
        }
    });
</script>

<?php require dirname(__DIR__) . '/layouts/admin_footer.php'; ?>

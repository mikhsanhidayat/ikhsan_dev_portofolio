            </main>
        </div>
    </div>

    <!-- Mobile Sidebar Drawer (Hidden by default) -->
    <div id="mobile-sidebar" class="fixed inset-0 z-50 flex md:hidden hidden">
        <!-- Backdrop -->
        <div id="mobile-sidebar-backdrop" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>
        
        <!-- Sidebar Content -->
        <aside class="relative flex flex-col w-64 bg-slate-900 text-slate-300 border-r border-slate-800 transition-all duration-300">
            <!-- Close Button -->
            <div class="absolute top-4 right-4 md:hidden">
                <button id="mobile-sidebar-close" class="p-1 rounded-md text-slate-400 hover:text-white focus:outline-none">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>

            <!-- Sidebar Header -->
            <div class="h-16 flex items-center px-6 border-b border-slate-800 bg-slate-950">
                <span class="text-sm font-extrabold tracking-wider font-heading text-white">CMS ADMIN</span>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 overflow-y-auto px-4 py-4 space-y-1">
                <a href="/admin/dashboard" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg hover:bg-slate-800 hover:text-white transition-colors">
                    <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Dashboard
                </a>
                
                <div class="pt-4 pb-2">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest px-3">Data Portofolio</p>
                </div>
                
                <a href="/admin/profile" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg hover:bg-slate-800 hover:text-white transition-colors">
                    <i data-lucide="user" class="w-4 h-4"></i> Manajemen Profil
                </a>
                <a href="/admin/skills" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg hover:bg-slate-800 hover:text-white transition-colors">
                    <i data-lucide="award" class="w-4 h-4"></i> Manajemen Keahlian
                </a>
                <a href="/admin/projects" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg hover:bg-slate-800 hover:text-white transition-colors">
                    <i data-lucide="folder-git-2" class="w-4 h-4"></i> Manajemen Proyek
                </a>
                <a href="/admin/education" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg hover:bg-slate-800 hover:text-white transition-colors">
                    <i data-lucide="graduation-cap" class="w-4 h-4"></i> Pendidikan
                </a>
                <a href="/admin/experience" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg hover:bg-slate-800 hover:text-white transition-colors">
                    <i data-lucide="briefcase" class="w-4 h-4"></i> Pengalaman (Opsional)
                </a>
                <a href="/admin/cv" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg hover:bg-slate-800 hover:text-white transition-colors">
                    <i data-lucide="file-text" class="w-4 h-4"></i> Manajemen CV
                </a>
                
                <div class="pt-4 pb-2">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest px-3">Kontak & Pesan</p>
                </div>
                
                <a href="/admin/messages" class="flex items-center justify-between px-3 py-2 text-sm font-medium rounded-lg hover:bg-slate-800 hover:text-white transition-colors">
                    <span class="flex items-center gap-3">
                        <i data-lucide="mail" class="w-4 h-4"></i> Pesan Masuk
                    </span>
                </a>
                
                <div class="pt-4 pb-2 border-t border-slate-800 mt-4">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest px-3">Sistem</p>
                </div>
                
                <a href="/admin/settings" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg hover:bg-slate-800 hover:text-white transition-colors">
                    <i data-lucide="settings" class="w-4 h-4"></i> Pengaturan Website
                </a>
            </nav>

            <!-- Sidebar Footer -->
            <div class="p-4 border-t border-slate-800 bg-slate-950">
                <form action="/admin/logout" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin keluar?');">
                    <?= csrf_field() ?>
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold text-red-400 hover:text-white hover:bg-red-900/30 rounded-lg border border-red-900/30 transition-colors">
                        <i data-lucide="log-out" class="w-4 h-4"></i> Keluar
                    </button>
                </form>
            </div>
        </aside>
    </div>

    <!-- Scripts -->
    <script>
        // Initialize Lucide Icons
        lucide.createIcons();

        // Mobile Sidebar Toggling Logic
        const mobileToggleBtn = document.getElementById('mobile-sidebar-toggle');
        const mobileSidebar = document.getElementById('mobile-sidebar');
        const mobileSidebarClose = document.getElementById('mobile-sidebar-close');
        const mobileSidebarBackdrop = document.getElementById('mobile-sidebar-backdrop');

        function toggleMobileSidebar() {
            mobileSidebar.classList.toggle('hidden');
        }

        if (mobileToggleBtn) {
            mobileToggleBtn.addEventListener('click', toggleMobileSidebar);
        }
        if (mobileSidebarClose) {
            mobileSidebarClose.addEventListener('click', toggleMobileSidebar);
        }
        if (mobileSidebarBackdrop) {
            mobileSidebarBackdrop.addEventListener('click', toggleMobileSidebar);
        }

        // Active Link Highlight
        const currentPath = window.location.pathname;
        const allNavLinks = document.querySelectorAll('aside nav a');
        allNavLinks.forEach(link => {
            const href = link.getAttribute('href');
            if (currentPath === href || (href !== '/admin/dashboard' && currentPath.startsWith(href))) {
                link.classList.remove('hover:bg-slate-800', 'hover:text-white');
                link.classList.add('bg-slate-800', 'text-white', 'border-l-4', 'border-primary-500', 'pl-2');
            }
        });
    </script>
</body>
</html>
